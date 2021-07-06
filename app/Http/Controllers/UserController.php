<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessInvitationRequest;
use App\Http\Resources\UserResource;
use App\Models\Invitation;
use App\Models\User;
use App\Notifications\InvitationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class UserController extends Controller
{
    /**
     * Return a UserCollection Json paginated.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return UserResource::collection(User::orderBy('name')->paginate(10));
    }

    //this function is processing the member invitations
    public function process_invitations(ProcessInvitationRequest $request)
    {
        //validation
        $validated = $request->validated();
        //generating token
        do {
            $token = Str::random(20);
        } while (Invitation::where('token', $token)->first());
        $validated['token'] = $token;
        //registering new record into the invitations table
        Invitation::create($validated);

        //generating url
        $url = URL::temporarySignedRoute(
            'registration', now()->addMinutes(300), ['token' => $token, 'email' => $validated['email']],
        );

        //Sending invitation through mail
        Notification::route('mail', $validated['email'])->notify(new InvitationNotification($url));

        //redirecting with response
        return redirect('/dashboard')->with('success', 'The Invitation has been sent successfully');
    }

    //function to retrieve the permissions of users
    public function get_authPerms()
    {
        return Auth::user()->getAllPermissions()->pluck('name');
    }
}
