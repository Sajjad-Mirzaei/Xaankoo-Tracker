<?php

namespace App\Http\Controllers\Api\V1\User;

use App\ApiCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function requestCode(Request $request){

        $request->validate(['email'=>'required|email']);

        $user=User::whereEmail($request->email)->first();

        if (is_null($user)){
            return $this->respondNotFound(ApiCode::USER_NOT_FIND);
        }

        Password::sendResetLink($request->only('email'));
        return $this->respondWithMessage('Reset password link send on your email id.');
    }

    public function reset(ResetPasswordRequest $request){

        $user=User::whereEmail($request->email)->first();
        $check=Password::tokenExists($user,$request->token);
        if (! $check){
            return $this->respondBadRequest(ApiCode::INVALID_RESET_PASSWORD_TOKEN);
        }

        $user->update([
            'password'=>Hash::make($request->password)
        ]);

        $user->save();

        return $this->respondWithMessage('Password successfully changed');
    }
}
