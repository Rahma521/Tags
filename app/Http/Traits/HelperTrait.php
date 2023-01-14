<?php

namespace App\Http\Traits;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;

use phpDocumentor\Reflection\Types\False_;


trait HelperTrait
{
   
    public function responseJson($status, $message, $data =null, $resource = null)
    {
        if ($resource) {
            return $resource->additional([
                'status' => $status,
                'message' => $message,
                'additional_data' => $data,
                
            ]);
        }
        else{
            $response = [
                'status' => $status,
                'message' => $message,
                'data' => $data,
            ];
            return response()->json($response);
        }

    }

}
