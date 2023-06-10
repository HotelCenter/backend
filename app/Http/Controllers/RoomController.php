<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\PaginateModel;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function __construct()
    {

        $this->authorizeResource(Room::class, 'room', ['except' => ['show', 'index']]);
        $this->middleware('auth:api', ['except' => ['show', 'index']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $response = PaginateModel::paginateAPI(
            $request,
            Room::count(),
            Room::orderBy('created_at')
        );
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'date_available' => 'required|date',
            'date_booked' => 'required|date',
            'minimum_children' => 'required|integer',
            'minimum_adults' => 'required|integer',
            'base_price' => 'required|numeric',
            'adult_price' => 'required|numeric',
            'child_price' => 'required|numeric',
            'taxes' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'characteristics' => 'required|string',
            'hotel_id' => 'required|integer',
        ];


        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validatedData = $validator->validated();
        $user = auth()->user();
        $hotel = Hotel::find($validatedData['hotel_id']);
        if ($hotel->user_id != $user->id) {
            return response()->json(["message" => "This Hotel is not belong to you"], 422);
        }
        $newRoom = new Room;
        $newRoom->date_available = $validatedData['date_available'];
        $newRoom->date_booked = $validatedData['date_booked'];
        $newRoom->minimum_children = $validatedData['minimum_children'];
        $newRoom->minimum_adults = $validatedData['minimum_adults'];
        $newRoom->base_price = $validatedData['base_price'];
        $newRoom->adult_price = $validatedData['adult_price'];
        $newRoom->child_price = $validatedData['child_price'];
        $newRoom->taxes = $validatedData['taxes'];
        $newRoom->discount = $validatedData['discount'];
        $newRoom->characteristics = $validatedData['characteristics'];
        $newRoom->hotel_id = $validatedData['hotel_id'];

        $newRoom->save();


        return response()->json(["data" => $newRoom]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        return response()->json($room);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {

        $rules = [
            'minimum_children' => 'integer',
            'minimum_adults' => 'integer',
            'base_price' => 'numeric',
            'adult_price' => 'numeric',
            'child_price' => 'numeric',
            'taxes' => 'numeric',
            'discount' => 'numeric',
            'characteristics' => 'string',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = auth()->user();
        $hotel = Hotel::find($room->hotel_id);
        if ($hotel->user_id != $user->id) {
            return response()->json(["message" => "This Hotel is not belong to you"], 422);
        }
        $room->minimum_children = $request->input('minimum_children', $room->minimum_children);
        $room->minimum_adults = $request->input('minimum_adults', $room->minimum_adults);
        $room->base_price = $request->input('base_price', $room->base_price);
        $room->adult_price = $request->input('adult_price', $room->adult_price);
        $room->child_price = $request->input('child_price', $room->child_price);
        $room->taxes = $request->input('taxes', $room->taxes);
        $room->discount = $request->input('discount', $room->discount);
        $room->characteristics = $request->input('characteristics', $room->characteristics);

        $room->save();


        return response()->json(["data" => $room]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return response()->json(["data" => ['message' => 'Room deleted successfully']]);
    }
}