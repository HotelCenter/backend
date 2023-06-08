<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = validator::make($request->all(), [
            "children_count" => "integer|min:0|required",
            "room_id" => "integer|min:1|required",
            "adult_count" => "integer|min:1|required",
            "amount" => "decimal:0,2|required",
            "user_id" => "integer|min:1|required",
            "checkin_date" => "date_format:Y-m-d\TH:i:s.v\Z|required|after_or_equal:today",
            "checkout_date" => "date_format:Y-m-d\TH:i:s.v\Z|required|after_or_equal:tomorrow",


        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $validated = $validator->validate();
        $checkin_date = Carbon::parse($validated['checkin_date'])->toDateTimeString();
        $checkout_date = Carbon::parse($validated['checkout_date'])->toDateTimeString();
        $validated = array_replace($validated, [
            'checkin_date' => $checkin_date,
            'checkout_date' => $checkout_date,
        ]);
        $room = Room::find($validated['room_id']);
        $user = User::find($validated['user_id']);
        if (!$room) {
            return response()->json(["message" => "room not found"], 404);
        }
        if (!$user) {
            return response()->json(["message" => "user not found"], 404);
        }
        $reservation = new Reservation($validated);
        $reservation->save();
        $room->date_available = $validated['checkout_date'];
        $room->date_booked = $validated['checkin_date'];
        $room->save();
        return response()->json($reservation);
    }
    public function updateConfirmedPayment(Request $request, Reservation $reservation)
    {
        $reservation->confirmed_payment = true;
        $reservation->save();
        return response()->json($reservation);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        return response()->json($reservation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}