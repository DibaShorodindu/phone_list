<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Victorybiz\LaravelCryptoPaymentGateway\LaravelCryptoPaymentGateway;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        return LaravelCryptoPaymentGateway::callback();
    }
    public function payNow(Request $request)
    {
        $description = $request->dataFilter . ' ' . $request->phoneNumber . ' phone numbers.';
        $price = $request->price;
        $callbackUrl = $this->getCallbackurl($price);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-sandbox.nowpayments.io/v1/payment',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "price_amount": ' . $price . ',
            "price_currency": "usd",
            "pay_currency": "btc",
            "ipn_callback_url": "' . $callbackUrl . '",
            "order_id": "RGDBP-21314",
            "order_description": "' . $description . '"
            }',
            CURLOPT_HTTPHEADER => array(
                'x-api-key: HKA2W76-QJ44HDE-K1SHGSP-00FENBS',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($response);
        //TODO store response in database....

        // dd($response);
        return Redirect::to($response->ipn_callback_url);
    }

    private function getCallbackurl($price)
    {
        if ($price == 100) {
            return "https://sandbox.nowpayments.io/payment/?iid=4323803483";
        }
    }


    public function payNow(Request $request)
    {
        $description = $request->dataFilter . ' ' . $request->phoneNumber . ' phone numbers.';
        $price = $request->price;
        $callbackUrl = $this->getCallbackurl($price);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-sandbox.nowpayments.io/v1/payment',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "price_amount": ' . $price . ',
            "price_currency": "usd",
            "pay_currency": "btc",
            "ipn_callback_url": "' . $callbackUrl . '",
            "order_id": "RGDBP-21314",
            "order_description": "' . $description . '"
            }',
            CURLOPT_HTTPHEADER => array(
                'x-api-key: HKA2W76-QJ44HDE-K1SHGSP-00FENBS',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($response);
        //TODO store response in database....

        // dd($response);
        return Redirect::to($response->ipn_callback_url);
    }

    private function getCallbackurl($price)
    {
        if ($price == 100) {
            return "https://sandbox.nowpayments.io/payment/?iid=4323803483";
        }
    }

}
