<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Events\UserActivation;
use App\Http\Controllers\Controller;
use App\Models\ActivationCode;
use App\Models\User;
use Carbon\Carbon;


class UserActivationController extends Controller
{
    public function requestCode(User $user){
        if (! $user->hasVerifiedEmail()){
            if ($user->activationcodes()){
               $checkCode=$user->activationcodes()->where('expire','>=',Carbon::now())->latest()->first();
               if ($checkCode){
                   if($checkCode->expire>Carbon::now()){
                       return response()->json(['message'=>'Try 15 Min Later'],400);
                   }
               }
            }
            event(new UserActivation($user));
            return response()->json(['message'=>'Email Send Away'],200);
        }

        return response()->json(['message'=>'User Activated'],400);
    }

    public function activation($token){
        $activationCode = ActivationCode::whereCode($token)->first();

        if (!$activationCode){
            return response()->json(['message'=>'Not Exist'],404);
        }

        if ($activationCode->expire< Carbon::now()){
            return response()->json(['message'=>'Code Expired'],400);
        }

        if ($activationCode->used == true){
            return response()->json(['message'=>'Code Used'],400);
        }

        $activationCode->user()->update([
            'email_verified_at' => Carbon::now()
        ]);

        $activationCode->update([
            'used' => true
        ]);


        echo "<script>window.close();</script>";

    }
}
