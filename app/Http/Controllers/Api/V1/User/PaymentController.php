<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;


class PaymentController extends Controller
{
    private function header($sandbox)
    {
        return [
            'Content-Type: application/json',
            'X-API-KEY:'.env('IDPAY_API_KEY'),
            'X-SANDBOX:'.$sandbox
        ];
    }

    private function requestHttp($params, $header,$url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.idpay.ir/v1.1/'.$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ['result'=>$result,'http_code'=>$httpcode];
    }

    public $msg;

    private function status_response($status)
    {
        switch ($status) {
            case 1:
                $this->msg = 'پرداخت انجام نشده است.  ';
                break;
            case 2:
                $this->msg = 'پرداخت ناموفق بوده است.';
                break;
            case 3:
                $this->msg = 'خطا رخ داده است.';
                break;
            case 4:
                $this->msg = 'بلوکه شده.';
                break;
            case 5:
                $this->msg = 'برگشت به پرداخت کننده.';
                break;
            case 6:
                $this->msg = 'برگشت خورده سیستمی.';
                break;
            case 7:
                $this->msg = 'انصراف از پرداخت.';
                break;
            case 8:
                $this->msg = 'به درگاه پرداخت منتقل شد.';
                break;
            case 10:
                $this->msg = 'در انتظار تایید پرداخت.';
                break;
            case 100:
                $this->msg = 'پرداخت تایید شده است.';
                break;
            case 101:
                $this->msg = 'پرداخت قبلا تایید شده است.';
                break;

            case 200:
                $this->msg = 'به دریافت کننده واریز شد.';
                break;
            case 405:
                $this->msg = 'تایید پرداخت امکان پذیر نیست.';
                break;
        }
    }

    protected function sendToGate(Order $order){
        $params = array(
            'order_id' => $order->id,
            'amount' => $order->amount,
            'name' => auth()->user()->name,
            'mail' => auth()->user()->email,
            'callback' => 'https://localhost:8000/api/user/payment/callback',
        );
        $header=$this->header(1);
        $response=$this->requestHttp($params,$header,'payment');

        return $this->respond($response);
    }

    public function callback(Request $request){

        $this->status_response($request->status);

        if ($request->status==200){
            $params = array(
                'id' => $request->id,
                'order_id' => $request->order_id,
            );

            $header=$this->header(1);
            $response=$this->requestHttp($params,$header,'inquiry');

            return $this->respond($response);
        }
        return $this->msg;
    }

}
