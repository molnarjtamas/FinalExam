<?php

namespace App\Http\Controllers;


use App\Http\Requests\ProcessHolidayRequest;
use App\Http\Resources\HolidayResource;
use App\Models\Holiday;
use App\Models\User;
use App\Notifications\HolidayNotification;
use App\Notifications\HolidayRequested;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class HolidayController extends Controller
{
    // this function shows all of the holidays
    public function index()
    {
        return HolidayResource::collection(Holiday::orderBy('start_date')->paginate(10));
    }

    //this function shows holidays by user ID
    public function show(User $user)
    {
        return HolidayResource::collection($user->holidays()->orderBy('start_date')->paginate(4));
    }

    // this function processes the holiday request
    public function process_holidays(ProcessHolidayRequest $request)
    {
        //validation
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        $days_left = User::findOrFail(Auth::id())->days_left;
        //check if paid vacation exceeds remaining days
        if( ($validated['type'] == 'paid')
            && ($this->workDays($validated['start_date'],$validated['end_date']) > $days_left) ){
            return redirect('/holiday')->with('success','no')->with('message','You do not have enough paid vacations days left.');
        }

        //inserting into the database
        $holiday = Holiday::create($validated);

        //singed url generation
        $approve_url = URL::signedRoute(
            "holiday.approve", $holiday->id
        );
        $decline_url = URL::signedRoute(
            "holiday.decline", $holiday->id
        );

        //sending the holiday request through mail
        Notification::route('mail', 'office@webgurus.biz')
            ->notify(new HolidayRequested($approve_url, $decline_url, $validated));

        //redirecting with response
        return redirect('/holiday')->with('success','yes')->with('message','The request has been sent successfully');
    }

    //function to approve the holiday request
    public function approve(Holiday $holiday)
    {
        try {
            //checking to not to approve multiple times, thus decrementing the days_left
            if ($holiday->approved == true) {
                return response()->view(
                    'errors.409',
                    ['message' => 'Holiday has been already approved.'], 409);
            }

            // checking the type of status and deducting only working days and if it is a paid leave
            if ($holiday->type == 'paid') {
                $days = $holiday->user['days_left'] - $this->workDays($holiday['start_date'], $holiday['end_date']);

                $holiday->user->update(['days_left' => $days]);
            }
            // setting status to true
            $holiday->update(['approved' => true]);
        } catch (\Exception $e) {
            // displaying the error
            return response()->view(
                'errors.anyerror',
                ['code'=>$e->getCode() ,'message' => $e->getMessage()]);
        }
        //redirecting to holidays page
        return redirect('holiday');

    }

    //function for declining request
    public function decline(Holiday $holiday)
    {
        try {
            //checking to not to delete already approved request
            if ($holiday->approved == true) {
                return response()->view(
                    'errors.409',
                    ['message' => 'Holiday has been already approved.'], 409);
            }
            // deleting the request
            $holiday->delete();
        } catch (\Exception $e) {
            // displaying the error
            return response()->view(
                'errors.anyerror',
                ['code'=>$e->getCode() ,'message' => $e->getMessage()]);
        }
        //redirecting to holidays page
        return redirect('holiday');

    }

    // function to calculate working days
    private function workDays($from, $to)
    {
        $workingDays = [1, 2, 3, 4, 5]; # date format = N (1 = Monday, ...)
        $holidayDays = ['*-12-25', '*-01-01', '*-12-23']; # variable and fixed holidays

        $from = new DateTime($from);
        $to = new DateTime($to);
        $to->modify('+1 day');
        $interval = new DateInterval('P1D');
        $periods = new DatePeriod($from, $interval, $to);

        $days = 0;
        foreach ($periods as $period) {
            if (!in_array($period->format('N'), $workingDays)) continue;
            if (in_array($period->format('Y-m-d'), $holidayDays)) continue;
            if (in_array($period->format('*-m-d'), $holidayDays)) continue;
            $days++;
        }
        return $days;
    }

}
