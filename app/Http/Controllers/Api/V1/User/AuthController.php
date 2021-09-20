<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Models\User;
use App\ApiCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected function register(RegisterRequest $request){
        $validatedData=$request->validated();
        $validatedData['password'] = bcrypt($request->password);
        $user = User::create($validatedData);
        $accessToken = $user->createToken('authToken')->accessToken;
        if (is_null($user)||is_null($accessToken)){
            return $this->respondBadRequest(ApiCode::REGISTER_FAILED);
        }
        return $this->respond(['user'=>$user,'token'=>$accessToken],'User Created Successfully');
    }

    protected function login(LoginRequest $request){
        $validatedData=$request->validated();
        if (!auth()->attempt($validatedData)) {
            return $this->respondBadRequest(ApiCode::LOGIN_FAILED);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return $this->respond(['user'=>auth()->user(),'token'=>$accessToken]);
    }

    protected function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->respondWithMessage('Logged out');
    }

    protected function change(ChangePasswordRequest $request){
        $validatedData=$request->validated();
        $user=auth()->user();
        $newPassword=$validatedData['oldpassword'];
        $oldPassword=$user->getAuthPassword();
        if (!Hash::check($newPassword, $oldPassword))
        {
            return $this->respondBadRequest(ApiCode::CHANGE_PASSWORD_FAILED);
        }
        $user->update(array('password'=>bcrypt($validatedData['password'])));
        return $this->respondWithMessage('Password changed successfully');
    }
}
