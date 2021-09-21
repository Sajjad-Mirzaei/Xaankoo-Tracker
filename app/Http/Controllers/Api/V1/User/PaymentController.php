<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
//    protected function sendToGate(Order $order){
//        $response = Http::post('https://api.idpay.ir/v1.1/payment', [
//            'order_id' => $order->id,
//            'amount' => $order->amount,
//            'name'=>auth()->user()->name,
//            'email'=>auth()->user()->email,
//            ''
//        ]);
//
//        session(auth()->user(),);
//    }

}
