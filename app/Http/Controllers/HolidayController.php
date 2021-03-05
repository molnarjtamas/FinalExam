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
    public function process_holidays(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'description'=> 'required|max:255',
            'start_date' => 'required|date|after:today+ 14 days',
            'end_date' => 'required|after:start_date'
        ]);

        if ($validator->fails()) {

            return redirect(route('holiday'))
                ->withErrors($validator)
                ->withInput();
        };

        $url = URL::signedRoute(

            'holiday',['user ' => Auth::user()]
        );

        Notification::route('mail', 'managment@webgurus.com')->notify(new HolidayNotification($url));


        return redirect('/holiday')->with('success', 'The Invitation has been sent successfully');
    }



}
