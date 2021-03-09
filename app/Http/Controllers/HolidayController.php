<?php

namespace App\Http\Controllers;


use App\Http\Requests\ProcessHolidayRequest;
use App\Http\Resources\HolidayResource;
use App\Models\Holiday;
use App\Models\User;
use App\Notifications\HolidayNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class HolidayController extends Controller
{

    public function index()
    {
        return HolidayResource::collection(Holiday::orderBy('start_date')->paginate(10));

    }
    public function show(User $user)
    {
        return HolidayResource::collection($user->holidays()->orderBy('start_date')->paginate(4));
    }

    public function process_holidays(ProcessHolidayRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id']=Auth::id();

        $holiday =Holiday::create($validated);

        $approve_url = URL::signedRoute(
            "holiday.approve",$holiday->id
        );
        $decline_url = URL::signedRoute(
            "holiday.decline",$holiday->id
        );

        Notification::route('mail', 'managment@webgurus.com')
            ->notify(new HolidayNotification($approve_url,$decline_url,$validated));

        return redirect('/holiday')->with('success', 'The Invitation has been sent successfully');
    }

    public function approve(Holiday $holiday)
    {

        $holiday->update(['approved' => true]);

        return redirect('holiday');

    }

    public function decline(Holiday $holiday)
    {

        $holiday->delete();

        return redirect('holiday');

    }

}
