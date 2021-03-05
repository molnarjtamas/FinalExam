<?php

namespace App\Http\Controllers;


use App\Http\Resources\HolidayResource;
use App\Models\Holiday;
use App\Models\User;
use Illuminate\Http\Request;

class HolidayController extends Controller
{

    public function index()
    {
        return HolidayResource::collection(Holiday::orderBy('start_date')->paginate(10));

    }
    public function show(User $user)
    {
//        dd($user);
        return HolidayResource::collection($user->holidays()->orderBy('start_date')->paginate(4));
    }




}
