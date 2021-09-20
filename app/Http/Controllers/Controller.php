<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function respond($data,$message=null){
        return ResponseBuilder::asSuccess()->withData($data)->withMessage($message)->build();
    }

    public function respondWithMessage($message){
        return ResponseBuilder::asSuccess()->withMessage($message)->build();
    }

    public function respondWithError($api_code,$http_code){
        return ResponseBuilder::asError($api_code)->withHttpCode($http_code)->build();
    }

    public function respondBadRequest($api_code){
        return $this->respondWithError($api_code,400);
    }

    public function respondNotAccess($api_code){
        return ResponseBuilder::asError($api_code)->withMessage('Not Access')->withHttpCode(403)->build();
    }

    public function respondUnAuthenticated($api_code){
        return $this->respondWithError($api_code,401);
    }

    public function respondNotFound($api_code){
        return $this->respondWithError($api_code,404);
    }

}
