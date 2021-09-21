<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected function sendToGate(Order $order){
        $params = array(
            'order_id' => $order->id,
            'amount' => $order->amount,
            'name' => auth()->user()->name,
            'mail' => auth()->user()->email,
            'callback' => 'https://localhost:8000/api/user/payment/callback',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.idpay.ir/v1.1/payment');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-API-KEY: 45e66d8e-6726-4455-badf-ed6fa6930e07',
            'X-SANDBOX: 1'
        ));

        $result = curl_exec($ch);
        curl_close($ch);

        return $this->respond($result);
    }

    public function callback(Request $request){
//        return $request->status;

        switch (request()->status) {
            case 1:
                return $this->respondWithMessage('پرداخت انجام نشده است');
                break;
            case 2:
                return $this->respondWithMessage('پرداخت ناموفق بوده است');
                break;
            case 3:
                return $this->respondWithMessage('خطا رخ داده است');
                break;
            case 4:
                return $this->respondWithMessage('بلوکه شده');
                break;
            case 5:
                return $this->respondWithMessage('برگشت به پرداخت کننده');
                break;
            case 6:
                return $this->respondWithMessage('برگشت خورده سیستمی');
                break;
            case 7:
                return $this->respondWithMessage('انصراف از پرداخت');
                break;
            case 8:
                return $this->respondWithMessage('به درگاه پرداخت منتقل شد');
                break;
            case 10:
                return $this->respondWithMessage('در انتظار تایید پرداخت');
                break;
            case 100:
                return $this->respondWithMessage('پرداخت تایید شده است');
                break;
            case 101:
                return $this->respondWithMessage('پرداخت قبلا تایید شده است');
                break;
//            case 200:
//                return $this->respondWithMessage('به دریافت کننده واریز شد');
//                break;
//            default:
//                echo "Your favorite color is neither red, blue, nor green!";
        }

        if ($request->status==200){
            $params = array(
                'id' => $request->id,
                'order_id' => $request->order_id,
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.idpay.ir/v1.1/payment/inquiry');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'X-API-KEY: 45e66d8e-6726-4455-badf-ed6fa6930e07',
                'X-SANDBOX: 1',
            ));

            $result = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            var_dump($httpcode);
            var_dump($result);
        }

    }

}
