<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\WalletController;
use App\Order;
use App\Staff;
use App\User;
use App\BusinessSetting;
use Illuminate\Http\Request;
use Paypal;
use Redirect;
use Session;
use App\Mail\PaymentConfirmationShipper;
use App\Mail\PaymentConfirmationOwner;
use App\Mail\PaymentConfirmationManager;

class ByanpayController extends Controller
{
    public function __construct()
    {
//        if(Session::has('payment_type')){
        //
        //            if(BusinessSetting::where('type', 'paypal_sandbox')->first()->value == 1){
        //                $mode = 'sandbox';
        //                $endPoint = 'https://api.sandbox.paypal.com';
        //            }
        //            else{
        //                $mode = 'live';
        //                $endPoint = 'https://api.paypal.com';
        //            }
        //
        //            if(Session::get('payment_type') == 'cart_payment' || Session::get('payment_type') == 'wallet_payment'){
        //                $this->_apiContext = PayPal::ApiContext(
        //                    env('PAYPAL_CLIENT_ID'),
        //                    env('PAYPAL_CLIENT_SECRET'));
        //
        //                $this->_apiContext->setConfig(array(
        //                    'mode' => $mode,
        //                    'service.EndPoint' => $endPoint,
        //                    'http.ConnectionTimeOut' => 30,
        //                    'log.LogEnabled' => true,
        //                    'log.FileName' => public_path('logs/paypal.log'),
        //                    'log.LogLevel' => 'FINE'
        //                ));
        //            }
        //            elseif (Session::get('payment_type') == 'seller_payment') {
        //                $seller = Seller::findOrFail(Session::get('payment_data')['seller_id']);
        //                $this->_apiContext = PayPal::ApiContext(
        //                    $seller->paypal_client_id,
        //                    $seller->paypal_client_secret);
        //
        //                $this->_apiContext->setConfig(array(
        //                    'mode' => $mode,
        //                    'service.EndPoint' => 'https://api.paypal.com',
        //                    'http.ConnectionTimeOut' => 30,
        //                    'log.LogEnabled' => true,
        //                    'log.FileName' => public_path('logs/paypal.log'),
        //                    'log.LogLevel' => 'FINE'
        //                ));
        //            }
        //        }
    }

    public function getCheckout()
    {
        $payer = PayPal::Payer();
        $payer->setPaymentMethod('paypal');
        $amount = PayPal::Amount();
        $amount->setCurrency('USD');

        if (Session::has('payment_type')) {
            if (Session::get('payment_type') == 'cart_payment') {
                $order = Order::findOrFail(Session::get('order_id'));
                $amount->setTotal(convert_to_usd($order->grand_total));
                $description = 'Payment for order completion';
            } elseif (Session::get('payment_type') == 'seller_payment' || Session::get('payment_type') == 'wallet_payment') {
                $amount->setTotal(convert_to_usd(Session::get('payment_data')['amount']));
                $description = 'Payment to seller';
            }
        }
        // This is the simple way,
        // you can alternatively describe everything in the order separately;
        // Reference the PayPal PHP REST SDK for details.
        //        $transaction = PayPal::Transaction();
        //        $transaction->setAmount($amount);
        //        $transaction->setDescription($description);
         //        $redirectUrls = PayPal:: RedirectUrls();
        //        $redirectUrls->setReturnUrl(url('paypal/payment/done'));
        //        $redirectUrls->setCancelUrl(url('paypal/payment/cancel'));
        //        $payment = PayPal::Payment();
        //        $payment->setIntent('sale');
        //        $payment->setPayer($payer);
        //        $payment->setRedirectUrls($redirectUrls);
        //        $payment->setTransactions(array($transaction));
        //        $response = $payment->create($this->_apiContext);
        //        $redirectUrl = $response->links[1]->href;

        return Redirect::to($redirectUrl);
    }

    public function payment()
    {
        return view('byanpay');
    }
    public function post_payment(Request $request)
    {
        $order = Order::findOrFail(Session::get('order_id'));
        $txnid = $order->code;
        $amount = $order->grand_total;
        $surl = url('/byanpay/payment/back');
        $currency = 'SAR';
        $fname = json_decode($order->shipping_address)->name;
        $lname = 'test';
        $addr1 = 'test';
        $addr2 = 'test';
        $city = json_decode($order->shipping_address)->city;
        $state = json_decode($order->shipping_address)->country;
        $postcode = json_decode($order->shipping_address)->postal_code;
        $country = 'SA';
        $email = json_decode($order->shipping_address)->email;
        $mobile = json_decode($order->shipping_address)->phone;
        $mkey = env('BYAN_MERCHANT_KEY');
        $gurl = env('BYAN_URL');
        $colab = env('BYAN_COLLAB');
        $mid = env('BYAN_MERCHANT_ID');
        $iv = '0123456789abcdef';

        $text = '11100||11111011|' . $txnid . '|' . $amount . '|' . $surl . '|' . $surl . '|INTERNET|01|' . $currency . '||1111111111|' . $fname .
            '|' . $lname . '|' . $addr1 . '|' . $addr2 . '|' . $city . '|' . $state . '|' . $postcode . '|' . $country . '|' . $email . '|' . $mobile .
            '||111111110001|' . $fname . '|' . $lname . '|' . $addr1 . '|' . $addr2 . '|' . $city . '|' . $state . '|' . $postcode . '|' . $country .
            '|' . $mobile;
        session(['key' => $mkey]);
        session(['iv' => $iv]);

        $size = openssl_cipher_iv_length('AES-256-CBC');
        $pad = $size - (strlen($text) % $size);
        $padtext = $text . str_repeat(chr($pad), $pad);
        $crypt = base64_encode(openssl_encrypt($padtext, 'AES-256-CBC', base64_decode($mkey), OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv));
        $obj = array("action" => $gurl, "requestParameter" => $crypt, "CollaboratorID" => $colab, "MerchantID" => $mid);

        header('Access-Control-Allow-Origin: *');
        header("Content-Type: application/json");
        return json_encode($obj);
    }

    public function payment_done(Request $request)
    {

        if (!$_POST) {
             return redirect()->action('PurchaseHistoryController@index')->withErrors('There was an error with your transaction, please always use local card with valid information.');
        }

        extract($_POST);
        $msg = "";

        if (isset($_POST['txnErrMsg'])) {
            $msg = 'Error::' . $_POST['txnErrMsg'];
        }

        $respAr = explode("||", $responseParameter);

        if (count($respAr) < 2) {
            $msg = 'Something Wen Wrong!';
        }

        if ($msg == '') {
            $enctext = base64_decode($respAr[1]);
            $padtext = openssl_decrypt($enctext, 'AES-256-CBC', base64_decode($request->session()->get('key')), OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $request->session()->get('iv'));
            $pad = ord($padtext{strlen($padtext) - 1});
            if ($pad > strlen($padtext)) {
                 return redirect()->action('PurchaseHistoryController@index')->withErrors('There was an error with your transaction, please always use local card with valid information.');
            }

            if (strspn($padtext, $padtext{strlen($padtext) - 1}, strlen($padtext) - $pad) != $pad) {
                 return redirect()->action('PurchaseHistoryController@index')->withErrors('There was an error with your transaction, please always use local card with valid information.');
            }

            $response = substr($padtext, 0, -1 * $pad);

            $orderid = '';
            $amount = 0;
            $status = '';
            //original response decrypted and store in $r_main variable
            $r_main = explode('||', $response);
            if (substr($r_main[0], 0, 1) == '1') {
                $r_trans = explode('|', $r_main[1]);

                if (substr($r_trans[0], 2, 1) == '1') {
                    $amount = $r_trans[3];
                    $orderid = $r_trans[1];
                }
            }
            if (substr($r_main[0], 2, 1) == '1') {
                $r_trans = explode('|', $r_main[2]);
                if (substr($r_trans[0], 0, 1) == '1') {
                    $status = $r_trans[1];
                    $status_msg = $r_trans[3];
                    if (!$status_msg) {
                        $status_msg = "Payment Cancelled or Declined...";
                    }

                }
            }
             //return $orderid;
            if ($amount > 0 && $status != 'FAILURE') {
                $order_update = Order::where('code', $orderid)->update(['payment_status' => 'paid', 'payment_type' => 'byanpay', 'grand_total' => $amount]);
                $order = Order::where('code', $orderid)->first();
                $array1['view'] = 'emails.paymentshipper';
                $array1['subject'] = 'Order Placed - ';
                $array1['from'] = env('MAIL_USERNAME');
                $array1['content'] = 'Hi. An order has been placed to your address. Order code is: ' . $orderid . ' . Thank You';
                $shipper_email = json_decode($order->shipping_address)->email;
                \Mail::to($shipper_email)->send(new PaymentConfirmationShipper($array1));
                $shipper_sms = sendSMS(json_decode($order->shipping_address)->phone, $array1['content']);

                $array2['view'] = 'emails.paymentorderer';
                $array2['subject'] = 'Order Placed - ';
                $array2['from'] = env('MAIL_USERNAME');
                $array2['content'] = 'Your order with the tracking number ' . $orderid . ' was placed successfully. we will deliver in time. Thanks for shopping';
                $orderer = User::where('id', $order->user_id)->first();
                $orderer_email = $orderer->email;
                \Mail::to($orderer_email)->send(new PaymentConfirmationOwner($array2));
                $orderer_sms = sendSMS($orderer->phone, $array2['content']);

                $role_users = Staff::where('role_id', 1)->get();
                $array3['view'] = 'emails.paymentmanager';
                $array3['subject'] = 'Order Placed - ';
                $array3['from'] = env('MAIL_USERNAME');
                $array3['content'] = 'An order with tracking number ' . $orderid . ' needs to prepared and delivered to the customer. Please assign the product to a driver after the product is prepared';
                foreach ($role_users as $role_user) {
                    $user = User::where('id', $role_user->user_id)->select('email', 'phone')->first();
                    $user_email = $user->email;
                    \Mail::to($user_email)->send(new PaymentConfirmationManager($array3));
                    $suser_sms = sendSMS($user->phone, $array3['content']);

                }

                if (BusinessSetting::where('type', 'category_wise_commission')->first()->value != 1) {
                    $commission_percentage = BusinessSetting::where('type', 'vendor_commission')->first()->value;
                    foreach ($order->orderDetails as $key => $orderDetail) {
                        $orderDetail->payment_status = 'paid';
                        $orderDetail->save();
                        if($orderDetail->product->user->user_type == 'seller'){
                            $seller = $orderDetail->product->user->seller;
                            $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->price*(100-$commission_percentage))/100;
                            $seller->save();
                        }
                    }
                }
                else{
                    foreach ($order->orderDetails as $key => $orderDetail) {
                        $orderDetail->payment_status = 'paid';
                        $orderDetail->save();
                        if($orderDetail->product->user->user_type == 'seller'){
                            $commission_percentage = $orderDetail->product->category->commision_rate;
                            $seller = $orderDetail->product->user->seller;
                            $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->price*(100-$commission_percentage))/100;
                            $seller->save();
                        }
                    }
                }

                Session::put('cart', collect([]));
                Session::forget('order_id');
                Session::forget('payment_type');
                Session::forget('delivery_info');
                Session::forget('coupon_id');
                Session::forget('coupon_discount');


                $request->session()->forget('key');
                $request->session()->forget('iv');
                return redirect()->action('PurchaseHistoryController@index')->withSuccess('Your payment is succcessful and we sent you an email and SMS with Order ID ' . $orderid);
            } else {
                $request->session()->forget('key');
                $request->session()->forget('iv');
                return redirect()->action('PurchaseHistoryController@index')->withErrors('There was an error with your transaction, please always use local card with valid information.');

           }
        } else {
                $request->session()->forget('key');
                $request->session()->forget('iv');
                return redirect()->action('PurchaseHistoryController@index')->withErrors('There was an error with your transaction, please always use local card with valid information.');

         }

    }

    public function getCancel()
    {
        // Curse and humiliate the user for cancelling this most sacred payment (yours)
        $request->session()->forget('order_id');
        $request->session()->forget('payment_data');
        flash(__('Payment cancelled'))->success();
        return redirect()->url()->previous();
    }

    public function getDone(Request $request)
    {
        $payment_id = $request->get('paymentId');
        $token = $request->get('token');
        $payer_id = $request->get('PayerID');

        $payment = '';
        // $payment = PayPal::getById($payment_id, $this->_apiContext);
        // $paymentExecution = PayPal::PaymentExecution();
        // $paymentExecution->setPayerId($payer_id);
        // $executePayment = $payment->execute($paymentExecution, $this->_apiContext);

        if ($request->session()->has('payment_type')) {
            if ($request->session()->get('payment_type') == 'cart_payment') {
                $checkoutController = new CheckoutController;
                return $checkoutController->checkout_done($request->session()->get('order_id'), $payment);
            } elseif ($request->session()->get('payment_type') == 'seller_payment') {
                $commissionController = new CommissionController;
                return $commissionController->seller_payment_done($request->session()->get('payment_data'), $payment);
            } elseif ($request->session()->get('payment_type') == 'wallet_payment') {
                $walletController = new WalletController;
                return $walletController->wallet_payment_done($request->session()->get('payment_data'), $payment);
            }
        }
    }
}
