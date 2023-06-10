<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\PaginateModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class HotelController extends Controller
{
    public function __construct()
    {

        $this->authorizeResource(Hotel::class, 'hotel', ['except' => ['show', 'index']]);
        $this->middleware('auth:api', ['except' => ['show', 'index', 'getRoomsByHotel', 'getHotelsByFilters']]);

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
            Hotel::count(),
            Hotel::orderByDesc('rating')->orderBy('created_at')
        );
        return response()->json($response);
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
            return response()->json($validator->errors(), 422);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'description' => 'required|string',
            'image' => 'required|string|max:255',
            'rating' => 'required|numeric|min:0|max:5',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $validatedData = $validator->validated();
        $validatedData['slug'] = Str::slug($validatedData['name']);
        $newhotel = new Hotel;
        $newhotel->user_id = $validatedData['user_id'];
        $newhotel->name = $validatedData['name'];
        $newhotel->address = $validatedData['address'];
        $newhotel->city = $validatedData['city'];
        $newhotel->postcode = $validatedData['postcode'];
        $newhotel->country = $validatedData['country'];
        $newhotel->phone_number = $validatedData['phone_number'];
        $newhotel->description = $validatedData['description'];
        $newhotel->slug = $validatedData['slug'];
        $newhotel->image = $validatedData['image'];
        $newhotel->rating = $validatedData['rating'];
        $newhotel->save();


        return response()->json(["data" => $newhotel]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hotel $hotel)
    {

        $rules = [
            'address' => 'string|max:255',
            'city' => 'string|max:255',
            'postcode' => 'string|max:10',
            'country' => 'string|max:255',
            'phone_number' => 'string|max:20',
            'description' => 'string',
            'image' => 'string|max:255',
            'rating' => 'numeric|min:0|max:5',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $hotel->address = $request->input('name', $hotel->address);
        $hotel->city = $request->input('city', $hotel->city);
        $hotel->postcode = $request->input('postcode', $hotel->name);
        $hotel->country = $request->input('country', $hotel->country);
        $hotel->phone_number = $request->input('phone_number', $hotel->phone_number);
        $hotel->description = $request->input('name', $hotel->description);
        $hotel->image = $request->input('image', $hotel->image);
        $hotel->rating = $request->input('rating', $hotel->rating);
        $hotel->save();


        return response()->json(["data" => $hotel]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return response()->json(["data" => ['message' => 'Hotel deleted successfully']]);
    }
}