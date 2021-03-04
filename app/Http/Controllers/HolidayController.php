<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Http\Resources\HolidayResource;
use App\Models\Holiday;
=======
>>>>>>> add-holiday-feature
use Illuminate\Http\Request;

class HolidayController extends Controller
{
<<<<<<< HEAD
    public function index()
    {
        return HolidayResource::collection(Holiday::orderBy('start_date')->paginate(10));

    }
=======
    //
>>>>>>> add-holiday-feature
}
