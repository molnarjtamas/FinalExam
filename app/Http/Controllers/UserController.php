<?php

namespace App\Http\Controllers;

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
    public function process_invitations(Request $request)
    {
        //validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email'
        ]);
        $validator->after(function ($validator) use ($request) {
            if (Invitation::where('email', $request->input('email'))->exists()) {
                $validator->errors()->add('email', 'There exists an invite with this email!');
            }
        });
        if ($validator->fails()) {
            return redirect(route('dashboard'))
                ->withErrors($validator)
                ->withInput();
        };
        //generating token
        do {
            $token = Str::random(20);
        } while (Invitation::where('token', $token)->first());
        //registering new record into the invitations table
        Invitation::create([
            'token' => $token,
            'email' => $request->input('email'),
            'role' => $request->input('role'),
        ]);

        //generating url
        $url = URL::temporarySignedRoute(

            'registration', now()->addMinutes(300), ['token' => $token, 'email' => $request->input('email')],
        );

        //Sending invitation through mail
        Notification::route('mail', $request->input('email'))->notify(new InvitationNotification($url));

        //redirecting with response
        return redirect('/dashboard')->with('success', 'The Invitation has been sent successfully');
    }

    //function to retrieve the permissions of users
    public function get_authPerms()
    {
        return Auth::user()->getAllPermissions()->pluck('name');
    }



//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function create()
//    {
//        //
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
//     */
//    public function store(Request $request)
//    {
//        //
//    }
//
//    /**
//     * Display the specified resource.
//     *
//     * @param  \App\Models\User  $user
//     * @return \Illuminate\Http\Response
//     */
//    public function show(User $user)
//    {
//        //
//    }
//
//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  \App\Models\User  $user
//     * @return \Illuminate\Http\Response
//     */
//    public function edit(User $user)
//    {
//        //
//    }
//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \App\Models\User  $user
//     * @return \Illuminate\Http\Response
//     */
//    public function update(Request $request, User $user)
//    {
//        //
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  \App\Models\User  $user
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy(User $user)
//    {
//        //
//    }
}
