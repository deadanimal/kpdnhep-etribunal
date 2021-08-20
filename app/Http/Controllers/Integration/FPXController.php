<?php

namespace App\Http\Controllers\Integration;

use App\CaseModel\ClaimCase;
use App\CaseModel\Form1;
use App\CaseModel\Form2;
use App\Http\Controllers\Controller;
use App\LogModel\LogCounter;
use App\LogModel\LogReceipt;
use App\MasterModel\MasterBank;
use App\PaymentModel\Payment;
use App\PaymentModel\PaymentFPX;
use App\Repositories\RunnerRepository;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use PDF;
use Response;
use Session;

class FPXController extends Controller
{
    /**
     * PortalController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => [
            'printReceipt', 'details', 'process', 'submit', 'modal', 'indirect',
        ]]);
    }

    public function printReceipt($payment_id)
    {
        $payment = Payment::findOrFail($payment_id);

        if ($payment->payment_status_id == 4) {
            $this->data['payment'] = $payment;
            $this->data['now_date'] = date('d/m/Y');
            $this->data['now_time'] = date('h.i A');
            $this->data['paid_at_date'] = date('d/m/Y', strtotime($payment->fpxs->last()->paid_at));
            $this->data['paid_at_time'] = date('H:i:s', strtotime($payment->fpxs->last()->paid_at));

            /**
             * if user is not a public user
             *      then salinan
             */
            if (Auth::user()->user_type_id != 3) {
                $this->data['status'] = 'SALINAN';
            } else if ($payment->form_no == 1) {
                if (($form1 = Form1::find($payment->form_id))->is_printed == 1) {
                    $this->data['status'] = 'SALINAN';
                } else {
                    $this->data['status'] = 'ASAL';
                    $form1->is_printed = 1;
                    $form1->save();
                }
            } else if ($payment->form_no == 2) {
                if (($form2 = Form2::find($payment->form_id))->is_printed == 1) {
                    $this->data['status'] = 'SALINAN';
                } else {
                    $this->data['status'] = 'ASAL';
                    $form2->is_printed = 1;
                    $form2->save();
                }
            }

            $pdf = PDF::loadView('integration/fpx/receipt', $this->data);
            $pdf->setOption('enable-javascript', true);
            return $pdf->download('Receipt-No' . $payment->receipt_no . '.pdf');
        } else {
            return $payment->status->status;
        }

    }

    public function details(Request $request)
    {
        $payment = Payment::findOrFail($request->payment_id);

        if ($payment->payment_fpx_id) {
            $claim_case_id = $payment->claim_case_id;
            $case = ClaimCase::findOrFail($claim_case_id);
            $form_no = $payment->form_no;
            $description = $payment->description;
            $fpx_debitAuthCode = $payment->fpx->fpx_status_id;
            $fpx_fpxTxnId = $payment->fpx->fpx_transaction_no;
            $fpx_buyerBankId = $payment->fpx->bank->bank_code;
            $fpx_txnAmount = $payment->fpx->paid_amount;
            $fpx_sellerOrderNo = $payment->payment_id;

            return view('integration.fpx.indirect', compact('val', 'fpx_debitAuthCode', 'fpx_fpxTxnId',
                'fpx_buyerBankId', 'fpx_txnAmount', 'ErrorCode', 'case', 'description', 'form_no',
                'payment', 'fpx_sellerOrderNo'));
        }
    }

    public function process(Request $request)
    {
        Session::flash('bank_id', $request->bank_id);
        Session::flash('email', $request->email);
        Session::flash('payment_id', $request->payment_id);
        Session::flash('acc_type', $request->acc_type);

        return Response::json(['result' => 'ok']);
    }

    public function submit(Request $request)
    {
        $bank_id = Session::get('bank_id');
        $email = Session::get('email');
        $payment_id = Session::get('payment_id');
        $acc_type = Session::get('acc_type');
        $payment = Payment::findOrFail($payment_id);
        $description = trans('fpx.application_fee');

        $payment_fpx_id = PaymentFPX::insertGetId([
            'payment_id' => $payment_id,
            'bank_id' => $bank_id,
            'email' => $email,
            'created_by_user_id' => Auth::id(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $payment->payment_fpx_id = $payment_fpx_id;
        $payment->updated_at = Carbon::now();
        $payment->payment_status_id = 2;
        $payment->fpx_created_at = Carbon::now();
        $payment->save();

        $bank_id = MasterBank::findOrFail($bank_id)->bank_code;

        $amount = $payment->amount;

        return view('integration.fpx.submit', compact('bank_id', 'email', 'description', 'payment_id', 'payment_fpx_id',
            'acc_type', 'amount'));
    }

    public function modal($payment_id)
    {
        $this->middleware('auth');

        $payment = Payment::find($payment_id);

        if (!$payment)
            return trans('fpx.none');

        if ($payment->payment_status_id == 4)
            return trans('fpx.payment_completed');

        if ($payment->fpx_created_at) {
            $end = Carbon::parse($payment->fpx_created_at);

            $length = Carbon::now()->diffInMinutes($end);

            if ($length < 15) {
                return trans('fpx.wait_15min') . " <script>$('#btnProceedFPX').addClass('hidden');</script>";
            }
        }

        //dd($payment_id);

        /// Summary description for Controller
        ///  ErrorCode  : Description
        ///  00         : Your signature has been verified successfully.
        ///  06         : No Certificate found
        ///  07         : One Certificate Found and Expired
        ///  08         : Both Certificates Expired
        ///  09         : Your Data cannot be verified against the Signature.


        //Merchant will need to edit the below parameter to match their environment.
        error_reporting(E_ALL);

        /* Generating String to send to fpx */
        /*For B2C, message.token = 01
        For B2B1, message.token = 02 */

        $fpx_msgToken = "01";
        $fpx_msgType = "BE";
        $fpx_sellerExId = "EX00000668";
        $fpx_version = "6.0";
        /* Generating signing String */
        $data = $fpx_msgToken . "|" . $fpx_msgType . "|" . $fpx_sellerExId . "|" . $fpx_version;
        /* Reading key */
        $priv_key = file_get_contents('/var/www/html/EX00000668.key');
        $pkeyid = openssl_get_privatekey($priv_key);
        openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
        $fpx_checkSum = strtoupper(bin2hex($binary_signature));


        //extract data from the post

        extract($_POST);
        $fields_string = "";

        //set POST variables
        $url = 'https://www.mepsfpx.com.my/FPXMain/RetrieveBankList';

        $fields = array(
            'fpx_msgToken' => urlencode($fpx_msgToken),
            'fpx_msgType' => urlencode($fpx_msgType),
            'fpx_sellerExId' => urlencode($fpx_sellerExId),
            'fpx_checkSum' => urlencode($fpx_checkSum),
            'fpx_version' => urlencode($fpx_version)

        );
        $response_value = array();
        $bank_list = array();

        try {
            //url-ify the data for the POST
            foreach ($fields as $key => $value) {
                $fields_string .= $key . '=' . $value . '&';
            }
            rtrim($fields_string, '&');

            //open connection
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

            //set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

            // receive server response ...
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //execute post

            $result = curl_exec($ch);

            //close connection
            curl_close($ch);

            $token = strtok($result, "&");
            while ($token !== false) {
                list($key1, $value1) = explode("=", $token);
                $value1 = urldecode($value1);
                $response_value[$key1] = $value1;
                $token = strtok("&");
            }

            $fpx_msgToken = reset($response_value);

            //Response Checksum Calculation String
            $data = $response_value['fpx_bankList'] . "|" . $response_value['fpx_msgToken'] . "|" . $response_value['fpx_msgType'] . "|" . $response_value['fpx_sellerExId'];
            $val = $this->verifySign_fpx($response_value['fpx_checkSum'], $data);

            // val == 00 verification success

            $token = strtok($response_value['fpx_bankList'], ",");
            while ($token !== false) {
                list($key1, $value1) = explode("~", $token);
                $value1 = urldecode($value1);
                $bank_list[$key1] = $value1;
                $token = strtok(",");
            }


        } catch (Exception $e) {
            echo 'Error :', ($e->getMessage());
        }

        $description = $payment->description;
        $payment_id = $payment->payment_id;

        $userid = Auth::id();
        $email = User::find($userid)->email;
        $banks_b2g = MasterBank::where('is_prod', 1)->where('is_b2g', 1)->get();
        $banks_c2g = MasterBank::where('is_prod', 1)->where('is_c2g', 1)->get();

        //dd($banks);

        return view('integration.fpx.modal', compact('bank_list', 'description', 'payment_id', 'email', 'banks_c2g', 'banks_b2g', 'payment'));

    }

    public function direct(Request $request)
    {
        error_reporting(E_ALL);

//        $fpx_buyerBankBranch = $request->fpx_buyerBankBranch;
//        $fpx_buyerBankId = $request->fpx_buyerBankId;
//        $fpx_buyerIban = $request->fpx_buyerIban;
//        $fpx_buyerId = $request->fpx_buyerId;
        $fpx_buyerName = $request->fpx_buyerName;
//        $fpx_creditAuthCode = $request->fpx_creditAuthCode;
//        $fpx_creditAuthNo = $request->fpx_creditAuthNo;
        $fpx_debitAuthCode = $request->fpx_debitAuthCode;
//        $fpx_debitAuthNo = $request->fpx_debitAuthNo;
        $fpx_fpxTxnId = $request->fpx_fpxTxnId;
//        $fpx_fpxTxnTime = $request->fpx_fpxTxnTime;
//        $fpx_makerName = $request->fpx_makerName;
//        $fpx_msgToken = $request->fpx_msgToken;
//        $fpx_msgType = $request->fpx_msgType;
//        $fpx_sellerExId = $request->fpx_sellerExId;
        $fpx_sellerExOrderNo = $request->fpx_sellerExOrderNo;
//        $fpx_sellerId = $request->fpx_sellerId;
        $fpx_sellerOrderNo = $request->fpx_sellerOrderNo;
//        $fpx_sellerTxnTime = $request->fpx_sellerTxnTime;
        $fpx_txnAmount = $request->fpx_txnAmount;
//        $fpx_txnCurrency = $request->fpx_txnCurrency;

//        $fpx_checkSum = $request->fpx_checkSum;

//        $data = $fpx_buyerBankBranch . "|" . $fpx_buyerBankId . "|" . $fpx_buyerIban . "|" . $fpx_buyerId . "|" . $fpx_buyerName . "|" . $fpx_creditAuthCode . "|" . $fpx_creditAuthNo . "|" . $fpx_debitAuthCode . "|" . $fpx_debitAuthNo . "|" . $fpx_fpxTxnId . "|" . $fpx_fpxTxnTime . "|" . $fpx_makerName . "|" . $fpx_msgToken . "|" . $fpx_msgType . "|" . $fpx_sellerExId . "|" . $fpx_sellerExOrderNo . "|" . $fpx_sellerId . "|" . $fpx_sellerOrderNo . "|" . $fpx_sellerTxnTime . "|" . $fpx_txnAmount . "|" . $fpx_txnCurrency;

        $fpx_id = str_replace('FPX-V2-', '', $fpx_sellerExOrderNo);
        $payment_id = str_replace('FPX-V2-', '', $fpx_sellerOrderNo);

        $fpx = PaymentFPX::find($fpx_id);
        $payment = Payment::findOrFail($payment_id);

        if ($fpx_debitAuthCode == '00') {
            $fpx->paid_amount = $fpx_txnAmount;
            $fpx->paid_at = Carbon::now();

            $payment->paid_at = Carbon::now();
            $payment->payment_status_id = 4;
            $payment->updated_at = Carbon::now();

            $log_counter = LogCounter::where('counter_key', 'fpx_receipt')->first();

            // check if receipt_no is already generated
            if($payment->receipt_no == null) {
                $receipt_is_null = 1;
                $receipt_number = "T" . date('y') . sprintf('%06d', $log_counter->counter_value);
            } else {
                $receipt_is_null = 0;
                $receipt_number = $payment->receipt_no;
            }

            $payment->receipt_no = $receipt_number;

            if($receipt_is_null == 1) {
                $log_counter->counter_value = $log_counter->counter_value + 1;
                $log_counter->save();
            }

            $form_no = $payment->form_no;
            $form_id = $payment->form_id;

            if ($form_no == 1) {
                $form = Form1::find($form_id);
            } else if ($form_no == 2) {
                $form = Form2::find($form_id);
            }

            if ($form && $form->payment->payment_status_id != 4) {

                if ($form_no == 1) {
                    $form->form_status_id = 14;
                } else if ($form_no == 2) {
                    $form->form_status_id = 19;
                }

                $form->payment_id = $payment_id;
                $form->updated_at = Carbon::now();
                $form->save();
            }

            if ($form && $form->payment->payment_status_id == 4) {
                if ($form_no == 1) {
                    $form->form_status_id = 14;
                } else if ($form_no == 2) {
                    $form->form_status_id = 19;
                }

                $form->updated_at = Carbon::now();
                $form->save();
            }
        } else {
            if ($payment->payment_status_id != 4) {
                $payment->payment_status_id = 5;
                $payment->fpx_created_at = NULL;
            }
        }

        $payment->save();

        // save log receipt
        if($fpx_debitAuthCode == '00')
        {
            LogReceipt::create([
                'payment_id' => $payment_id,
                'txn_type' => 'fpxcontroller',
                'receipt_number' => $receipt_number ?? '-',
            ]);
        }

        $fpx->fpx_status_id = $fpx_debitAuthCode;
        $fpx->updated_at = Carbon::now();
        $fpx->fpx_transaction_no = $fpx_fpxTxnId;
        $fpx->paid_by = $fpx_buyerName;
        $fpx->save();

        return "OK";

    }

    public function indirect(Request $request)
    {
        $this->middleware('auth');
        $fpx_buyerBankBranch = $request->fpx_buyerBankBranch;
        $fpx_buyerBankId = $request->fpx_buyerBankId;
        $fpx_buyerIban = $request->fpx_buyerIban;
        $fpx_buyerId = $request->fpx_buyerId;
        $fpx_buyerName = $request->fpx_buyerName;
        $fpx_creditAuthCode = $request->fpx_creditAuthCode;
        $fpx_creditAuthNo = $request->fpx_creditAuthNo;
        $fpx_debitAuthCode = $request->fpx_debitAuthCode;
        $fpx_debitAuthNo = $request->fpx_debitAuthNo;
        $fpx_fpxTxnId = $request->fpx_fpxTxnId;
        $fpx_fpxTxnTime = $request->fpx_fpxTxnTime;
        $fpx_makerName = $request->fpx_makerName;
        $fpx_msgToken = $request->fpx_msgToken;
        $fpx_msgType = $request->fpx_msgType;
        $fpx_sellerExId = $request->fpx_sellerExId;
        $fpx_sellerExOrderNo = $request->fpx_sellerExOrderNo;
        $fpx_sellerId = $request->fpx_sellerId;
        $fpx_sellerOrderNo = $request->fpx_sellerOrderNo;
        $fpx_sellerTxnTime = $request->fpx_sellerTxnTime;
        $fpx_txnAmount = $request->fpx_txnAmount;
        $fpx_txnCurrency = $request->fpx_txnCurrency;
        $fpx_checkSum = $request->fpx_checkSum;

        $fpx_id = str_replace('FPX-V2-', '', $fpx_sellerExOrderNo);
        $fpx = PaymentFPX::find($fpx_id);

        error_reporting(E_ALL);

        //dd($request);

        /* Generating String to send to fpx */
        /*For B2C, message.token = 01
        For B2B1, message.token = 02 */

        $new_fpx_msgType = "AE";
        $new_fpx_msgToken = $fpx_msgToken;
        $new_fpx_sellerExId = "EX00000668";
        $new_fpx_sellerExOrderNo = $fpx_sellerExOrderNo;
        $new_fpx_sellerTxnTime = $fpx_sellerTxnTime;
        $new_fpx_sellerOrderNo = $fpx_sellerOrderNo;
        $new_fpx_sellerId = "SE00000895";//SE00001438
        $new_fpx_sellerBankCode = "01";
        $new_fpx_txnCurrency = "MYR";
        $new_fpx_txnAmount = $fpx_txnAmount;
        $new_fpx_buyerEmail = $fpx->email ?? null;
        $new_fpx_checkSum = "";
        $new_fpx_buyerName = "";
        $new_fpx_buyerBankId = $fpx_buyerBankId;
        $new_fpx_buyerBankBranch = "";
        $new_fpx_buyerAccNo = "";
        $new_fpx_buyerId = "";
        $new_fpx_makerName = "";
        $new_fpx_buyerIban = "";
        $new_fpx_productDesc = __('fpx.application_fee');
        $new_fpx_version = "6.0";

        /* Generating signing String */
        $data = $new_fpx_buyerAccNo . "|" . $new_fpx_buyerBankBranch . "|" . $new_fpx_buyerBankId . "|" . $new_fpx_buyerEmail . "|" . $new_fpx_buyerIban . "|" . $new_fpx_buyerId . "|" . $new_fpx_buyerName . "|" . $new_fpx_makerName . "|" . $new_fpx_msgToken . "|" . $new_fpx_msgType . "|" . $new_fpx_productDesc . "|" . $new_fpx_sellerBankCode . "|" . $new_fpx_sellerExId . "|" . $new_fpx_sellerExOrderNo . "|" . $new_fpx_sellerId . "|" . $new_fpx_sellerOrderNo . "|" . $new_fpx_sellerTxnTime . "|" . $new_fpx_txnAmount . "|" . $new_fpx_txnCurrency . "|" . $new_fpx_version;

        /* Reading key */
//EX00000668-24082018.key
        $priv_key = file_get_contents('/var/www/html/EX00000668.key');
//$priv_key = file_get_contents('/var/www/html/EX00000668-24082018.key');
        $pkeyid = openssl_get_privatekey($priv_key);
        openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
        $new_fpx_checkSum = strtoupper(bin2hex($binary_signature));


        //extract data from the post

        extract($_POST);
        $fields_string = "";

        //set POST variables
        $url = 'https://www.mepsfpx.com.my/FPXMain/sellerNVPTxnStatus.jsp';

        $fields = array(
            'fpx_msgType' => urlencode($new_fpx_msgType),
            'fpx_msgToken' => urlencode($new_fpx_msgToken),
            'fpx_sellerExId' => urlencode($new_fpx_sellerExId),
            'fpx_sellerExOrderNo' => urlencode($new_fpx_sellerExOrderNo),
            'fpx_sellerTxnTime' => urlencode($new_fpx_sellerTxnTime),
            'fpx_sellerOrderNo' => urlencode($new_fpx_sellerOrderNo),
            'fpx_sellerId' => urlencode($new_fpx_sellerId),
            'fpx_sellerBankCode' => urlencode($new_fpx_sellerBankCode),
            'fpx_txnCurrency' => urlencode($new_fpx_txnCurrency),
            'fpx_txnAmount' => urlencode($new_fpx_txnAmount),
            'fpx_buyerEmail' => urlencode($new_fpx_buyerEmail),
            'fpx_checkSum' => urlencode($new_fpx_checkSum),
            'fpx_buyerName' => urlencode($new_fpx_buyerName),
            'fpx_buyerBankId' => urlencode($new_fpx_buyerBankId),
            'fpx_buyerBankBranch' => urlencode($new_fpx_buyerBankBranch),
            'fpx_buyerAccNo' => urlencode($new_fpx_buyerAccNo),
            'fpx_buyerId' => urlencode($new_fpx_buyerId),
            'fpx_makerName' => urlencode($new_fpx_makerName),
            'fpx_buyerIban' => urlencode($new_fpx_buyerIban),
            'fpx_productDesc' => urlencode($new_fpx_productDesc),
            'fpx_version' => urlencode($new_fpx_version)
        );
        $response_value = array();

        try {
            //url-ify the data for the POST
            foreach ($fields as $key => $value) {
                $fields_string .= $key . '=' . $value . '&';
            }
            rtrim($fields_string, '&');

            //open connection
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

            //set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

            // receive server response ...
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //execute post
            $result = curl_exec($ch);
//            echo $result;


            //close connection
            curl_close($ch);
            $token = strtok($result, "&");
            while ($token !== false) {
                list($key1, $value1) = explode("=", $token);
                $value1 = urldecode($value1);
                $response_value[$key1] = $value1;
                $token = strtok("&");
            }

            $fpx_debitAuthCode = reset($response_value);

            //Response Checksum Calculation String
            $data = $response_value['fpx_buyerBankBranch'] . "|" . $response_value['fpx_buyerBankId'] . "|" . $response_value['fpx_buyerIban'] . "|" . $response_value['fpx_buyerId'] . "|" . $response_value['fpx_buyerName'] . "|" . $response_value['fpx_creditAuthCode'] . "|" . $response_value['fpx_creditAuthNo'] . "|" . $fpx_debitAuthCode . "|" . $response_value['fpx_debitAuthNo'] . "|" . $response_value['fpx_fpxTxnId'] . "|" . $response_value['fpx_fpxTxnTime'] . "|" . $response_value['fpx_makerName'] . "|" . $response_value['fpx_msgToken'] . "|" . $response_value['fpx_msgType'] . "|" . $response_value['fpx_sellerExId'] . "|" . $response_value['fpx_sellerExOrderNo'] . "|" . $response_value['fpx_sellerId'] . "|" . $response_value['fpx_sellerOrderNo'] . "|" . $response_value['fpx_sellerTxnTime'] . "|" . $response_value['fpx_txnAmount'] . "|" . $response_value['fpx_txnCurrency'];

            // $val = $this->verifySign_fpx($response_value['fpx_checkSum'], $data);
//dd($val);
            // val == 1 verification success
            //if ($val != "00")
            //    abort(403, $val);

            $payment_id = str_replace('FPX-V2-', '', $fpx_sellerOrderNo);
            $payment = Payment::find($payment_id);

            $claim_case_id = $payment->claim_case_id;
            $case = ClaimCase::find($claim_case_id);
            $form_no = $payment->form_no;
            $description = $payment->description;

            return view('integration.fpx.indirect', compact('val', 'fpx_debitAuthCode', 'fpx_fpxTxnId', 'fpx_buyerBankId', 'fpx_txnAmount', 'ErrorCode', 'case', 'description', 'form_no', 'payment', 'fpx_sellerOrderNo'));
        } catch (Exception $e) {
            abort(403, $e->getMessage());
        }

        // $data=$fpx_buyerBankBranch."|".$fpx_buyerBankId."|".$fpx_buyerIban."|".$fpx_buyerId."|".$fpx_buyerName."|".$fpx_creditAuthCode."|".$fpx_creditAuthNo."|".$fpx_debitAuthCode."|".$fpx_debitAuthNo."|".$fpx_fpxTxnId."|".$fpx_fpxTxnTime."|".$fpx_makerName."|".$fpx_msgToken."|".$fpx_msgType."|".$fpx_sellerExId."|".$fpx_sellerExOrderNo."|".$fpx_sellerId."|".$fpx_sellerOrderNo."|".$fpx_sellerTxnTime."|".$fpx_txnAmount."|".$fpx_txnCurrency;

        // $val=$this->verifySign_fpx($fpx_checkSum, $data);

    }

    private function hextobin($hexstr)
    {
        $n = strlen($hexstr);
        $sbin = "";
        $i = 0;
        while ($i < $n) {
            $a = substr($hexstr, $i, 2);
            $c = pack("H*", $a);
            if ($i == 0) {
                $sbin = $c;
            } else {
                $sbin .= $c;
            }
            $i += 2;
        }
        return $sbin;
    }

    private function validateCertificate($path, $sign, $toSign)
    {
        global $ErrorCode;

        $d_ate = date("Y");
        //validating Last Three Certificates
        $fpxcert = array($path . "fpxprod.cer");
        $certs = $this->checkCertExpiry($fpxcert);
        // echo count($certs) ;
        $signdata = $this->hextobin($sign);


        if (count($certs) == 1) {

            $pkeyid = openssl_pkey_get_public($certs[0]);
            $ret = openssl_verify($toSign, $signdata, $pkeyid);
            if ($ret != 1) {
                $ErrorCode = " Your Data cannot be verified against the Signature. " . " ErrorCode :[09]";
                return "09";
            }
        } elseif (count($certs) == 2) {

            $pkeyid = openssl_pkey_get_public($certs[0]);
            $ret = openssl_verify($toSign, $signdata, $pkeyid);
            if ($ret != 1) {

                $pkeyid = openssl_pkey_get_public($certs[1]);
                $ret = openssl_verify($toSign, $signdata, $pkeyid);
                if ($ret != 1) {
                    $ErrorCode = " Your Data cannot be verified against the Signature. " . " ErrorCode :[09]";
                    return "09";
                }
            }

        }
        if ($ret == 1) {

            $ErrorCode = " Your signature has been verified successfully. " . " ErrorCode :[00]";
            return "00";
        }


        return $ErrorCode;


    }

    private function verifySign_fpx($sign, $toSign)
    {
        error_reporting(0);

        return $this->validateCertificate('/var/www/html/', $sign, $toSign);
    }

    private function checkCertExpiry($path)
    {
        global $ErrorCode;

        $stack = array();
        $t_ime = time();
        $curr_date = date("Ymd", $t_ime);
        for ($x = 0; $x < 2; $x++) {
            error_reporting(0);
            $key_id = file_get_contents($path[$x]);
            if ($key_id == null) {
                $cert_exists++;
                continue;
            }
            $certinfo = openssl_x509_parse($key_id);
            $s = $certinfo['validTo_time_t'];
            $crtexpirydate = date("Ymd", $s - 86400);
            if ($crtexpirydate > $curr_date) {
                if ($x > 0) {
                    if ($this->certRollOver($path[$x], $path[$x - 1]) == "true") {
                        array_push($stack, $key_id);
                        return $stack;
                    }
                }
                array_push($stack, $key_id);
                return $stack;
            } elseif ($crtexpirydate == $curr_date) {
                if ($x > 0 && (file_exists($path[$x - 1]) != 1)) {
                    if ($this->certRollOver($path[$x], $path[$x - 1]) == "true") {
                        array_push($stack, $key_id);
                        return $stack;
                    }
                } else if (file_exists($path[$x + 1]) != 1) {
                    array_push($stack, file_get_contents($path[$x]), $key_id);
                    return $stack;
                }


                array_push($stack, file_get_contents($path[$x + 1]), $key_id);

                return $stack;
            }

        }
        if ($cert_exists == 2)
            $ErrorCode = "Invalid Certificates.  " . " ErrorCode : [06]";  //No Certificate (or) All Certificate are Expired
        else if ($stack . Count == 0 && $cert_exists == 1)
            $ErrorCode = "One Certificate Found and Expired " . "ErrorCode : [07]";
        else if ($stack . Count == 0 && $cert_exists == 0)
            $ErrorCode = "Both Certificates Expired " . "ErrorCode : [08]";
        return $stack;


    }

    private function certRollOver($old_crt, $new_crt)
    {

        if (file_exists($new_crt) == 1) {

            rename($new_crt, $new_crt . "_" . date("YmdHis", time()));//FPXOLD.cer to FPX_CURRENT.cer_<CURRENT TIMESTAMP>

        }
        if ((file_exists($new_crt) != 1) && (file_exists($old_crt) == 1)) {
            rename($old_crt, $new_crt);                                 //FPX.cer to FPX_CURRENT.cer
        }


        return "true";
    }
}
