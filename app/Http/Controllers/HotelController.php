<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotels = Hotel::orderByDesc('rating')->take(10)->get();
        sleep(5);
        return response()->json($hotels);
    }
    public function getHotelsByFilters(Request $request)
    {
        $validator = validator::make($request->all(), [
            "children" => "integer|min:0|required",
            "rooms" => "integer|min:1|required",
            "adults" => "integer|min:1|required",
            "destination" => "string|required",
            "checkindate" => "date|required|after_or_equal:today",
            "checkoutdate" => "date|required|after_or_equal:tomorrow",

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $validated = $validator->validated();
        $destination = $validated['destination'];
        $rooms_count = $validated['rooms'];
        $children = $validated['children'];
        $adults = $validated['adults'];
        $checkindate = $validated['checkindate'];
        $hotels_query = Hotel::where('city', 'like', '%' . $destination . '%')->
            orWhere('country', 'like', '%' . $destination . '%')->get();
        $hotels = [];
        foreach ($hotels_query as $hotel) {
            $filtered_rooms = $hotel->rooms()->where('date_available', "<=", $checkindate)->where('minimum_children', '>=', $children)->where('minimum_adults', '>=', $adults);
            if ($filtered_rooms->count() >= $rooms_count) {
                array_push($hotels, $hotel);
            }
        }
        sleep(5);
        return response()->json($hotels);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function show(Hotel $hotel)
    {
        return response()->json($hotel);
    }

    public function getRoomsByHotel(Hotel $hotel)
    {
        $rooms = $hotel->rooms()->orderBy("date_available")->get();
        return response()->json($rooms);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotel $hotel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hotel $hotel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotel $hotel)
    {
        //
    }
}