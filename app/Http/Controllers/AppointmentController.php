<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class AppointmentController extends Controller
{
    //
    function index(Request $request)
    {
        $redis    = Redis::connection();
        $response = $redis->get('list');
        $response = json_decode($response) ?? [];

        return view('create', [
            'appointments' => $response
        ]);
    }

    function store(AppointmentRequest $request)
    {
        Appointment::create($request->validated());

        return back();
    }
}
