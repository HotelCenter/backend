<?php
namespace App\Models;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

abstract class PaginateModel
{
    static public function paginateAPI(Request $request, $total, $query)
    {

        $validator = Validator::make($request->all(), [
            "limit" => "required|min:1|integer",
            "page" => "required|min:1|integer",
        ]);

        if ($validator->fails()) {
            $response = $query->get();

        } else {
            $limit = $request->limit;
            $page = $request->page;
            $skip = $limit * ($page - 1);
            $hotels = $query->skip($skip)->limit($limit)->get();

            $response = [
                "data" => $hotels,
                "pagination" => [
                    "total" => $total,
                    "current" => $page,
                    'perPage' => $limit
                ]
            ];

        }
        return $response;
    }
}

?>