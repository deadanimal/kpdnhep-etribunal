<?php

namespace App\Repositories;

use App\CaseModel\Form1;
use App\CaseModel\Form2;
use App\Helpers\getDateExcludeHolidayHelper;
use App\LogModel\LogCounter;
use App\LogModel\LogReceipt;
use App\PaymentModel\Payment;
use Carbon\Carbon;
use http\Exception;

class FpxRepository
{
    public static function indirect($payment_fpx, $dump = false)
    {
        echo $payment_fpx->payment_fpx_id . ' - ';
//        self::validateCertificate($sign, $toSign);
        $datetime = date('YmdHis');

        $fpx_msgType = "AE";
        $fpx_msgToken = $payment_fpx->msgToken ?? '01';
        $fpx_sellerExId = config('integration.fpx.exchange_id');
        $fpx_sellerExOrderNo = 'FPX-V2-' . $payment_fpx->payment_fpx_id;
        $fpx_sellerTxnTime = $datetime;
        $fpx_sellerOrderNo = 'FPX-V2-' . $payment_fpx->payment->payment_id;
        $fpx_sellerId = config('integration.fpx.seller_id');
        $fpx_sellerBankCode = "01";
        $fpx_txnCurrency = "MYR";
        $fpx_txnAmount = $payment_fpx->payment->amount;
        $fpx_buyerEmail = $payment_fpx->email != null ? $payment_fpx->email : null;
        $fpx_checkSum = "";
        $fpx_buyerName = "";
        $fpx_buyerBankId = $payment_fpx->bank->bank_code;
        $fpx_buyerBankBranch = "";
        $fpx_buyerAccNo = "";
        $fpx_buyerId = "";
        $fpx_makerName = "";
        $fpx_buyerIban = "";
        $fpx_productDesc = __('fpx.application_fee');
        $fpx_version = "6.0";

        $fields = array(
            'fpx_msgType' => urlencode($fpx_msgType),
            'fpx_msgToken' => urlencode($fpx_msgToken),
            'fpx_sellerExId' => urlencode($fpx_sellerExId),
            'fpx_sellerExOrderNo' => urlencode($fpx_sellerExOrderNo),
            'fpx_sellerTxnTime' => urlencode($fpx_sellerTxnTime),
            'fpx_sellerOrderNo' => urlencode($fpx_sellerOrderNo),
            'fpx_sellerId' => urlencode($fpx_sellerId),
            'fpx_sellerBankCode' => urlencode($fpx_sellerBankCode),
            'fpx_txnCurrency' => urlencode($fpx_txnCurrency),
            'fpx_txnAmount' => urlencode($fpx_txnAmount),
            'fpx_buyerEmail' => urlencode($fpx_buyerEmail),
            'fpx_checkSum' => urlencode($fpx_checkSum),
            'fpx_buyerName' => urlencode($fpx_buyerName),
            'fpx_buyerBankId' => urlencode($fpx_buyerBankId),
            'fpx_buyerBankBranch' => urlencode($fpx_buyerBankBranch),
            'fpx_buyerAccNo' => urlencode($fpx_buyerAccNo),
            'fpx_buyerId' => urlencode($fpx_buyerId),
            'fpx_makerName' => urlencode($fpx_makerName),
            'fpx_buyerIban' => urlencode($fpx_buyerIban),
            'fpx_productDesc' => urlencode($fpx_productDesc),
            'fpx_version' => urlencode($fpx_version)
        );

        /* Generating signing String */
        $data = $fpx_buyerAccNo . "|" . $fpx_buyerBankBranch . "|" . $fpx_buyerBankId . "|" . $fpx_buyerEmail . "|"
            . $fpx_buyerIban . "|" . $fpx_buyerId . "|" . $fpx_buyerName . "|" . $fpx_makerName . "|" . $fpx_msgToken
            . "|" . $fpx_msgType . "|" . $fpx_productDesc . "|" . $fpx_sellerBankCode . "|" . $fpx_sellerExId
            . "|" . $fpx_sellerExOrderNo . "|" . $fpx_sellerId . "|" . $fpx_sellerOrderNo . "|" . $fpx_sellerTxnTime
            . "|" . $fpx_txnAmount . "|" . $fpx_txnCurrency . "|" . $fpx_version;

        /* Reading key */
        $priv_key = file_get_contents(config('integration.fpx.cert_path') . config('integration.fpx.cert_exchange_filename') . '.key');
        $pkeyid = openssl_get_privatekey($priv_key);
        openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
        $fpx_checkSum = strtoupper(bin2hex($binary_signature));

        //extract data from the post

        extract($_POST);
        $fields_string = "";

        //set POST variables
        $url = 'https://www.mepsfpx.com.my/FPXMain/sellerNVPTxnStatus.jsp';

        $fields = [
            'fpx_msgType' => urlencode($fpx_msgType),
            'fpx_msgToken' => urlencode($fpx_msgToken),
            'fpx_sellerExId' => urlencode($fpx_sellerExId),
            'fpx_sellerExOrderNo' => urlencode($fpx_sellerExOrderNo),
            'fpx_sellerTxnTime' => urlencode($fpx_sellerTxnTime),
            'fpx_sellerOrderNo' => urlencode($fpx_sellerOrderNo),
            'fpx_sellerId' => urlencode($fpx_sellerId),
            'fpx_sellerBankCode' => urlencode($fpx_sellerBankCode),
            'fpx_txnCurrency' => urlencode($fpx_txnCurrency),
            'fpx_txnAmount' => urlencode($fpx_txnAmount),
            'fpx_buyerEmail' => urlencode($fpx_buyerEmail),
            'fpx_checkSum' => urlencode($fpx_checkSum),
            'fpx_buyerName' => urlencode($fpx_buyerName),
            'fpx_buyerBankId' => urlencode($fpx_buyerBankId),
            'fpx_buyerBankBranch' => urlencode($fpx_buyerBankBranch),
            'fpx_buyerAccNo' => urlencode($fpx_buyerAccNo),
            'fpx_buyerId' => urlencode($fpx_buyerId),
            'fpx_makerName' => urlencode($fpx_makerName),
            'fpx_buyerIban' => urlencode($fpx_buyerIban),
            'fpx_productDesc' => urlencode($fpx_productDesc),
            'fpx_version' => urlencode($fpx_version)
        ];
        $response_value = array();

        try {
            //	echo 'hantar'.PHP_EOL;
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
            //echo "RESULT";
            //echo $result;

            //close connection
            curl_close($ch);
            $token_adv = explode('&', $result);
            $token = strtok($result, "&");
            $fpx_txn_datetime = isset($token_adv[6]) ? Carbon::createFromFormat('YmdHis', str_replace('fpx_sellerTxnTime=', '', $token_adv[6]))->toDateTimeString() : date('Y-m-d H:i:s');

            if ($dump) {
                dump($result);
            }

            if($result == "ERROR\n") {
                $payment_fpx->fpx_status_id = 76;
                $payment_fpx->save();
                return;
            }

            while ($token !== false) {
                list($key1, $value1) = explode("=", $token);
                $value1 = urldecode($value1);
                $response_value[$key1] = $value1;
                $token = strtok("&");
            }

//            $fpx_debitAuthCode = reset($response_value);

//            Response Checksum Calculation String
//            $data = $response_value['fpx_buyerBankBranch'] . "|" . $response_value['fpx_buyerBankId'] . "|" . $response_value['fpx_buyerIban'] . "|" . $response_value['fpx_buyerId'] . "|" . $response_value['fpx_buyerName'] . "|" . $response_value['fpx_creditAuthCode'] . "|" . $response_value['fpx_creditAuthNo'] . "|" . $fpx_debitAuthCode . "|" . $response_value['fpx_debitAuthNo'] . "|" . $response_value['fpx_fpxTxnId'] . "|" . $response_value['fpx_fpxTxnTime'] . "|" . $response_value['fpx_makerName'] . "|" . $response_value['fpx_msgToken'] . "|" . $response_value['fpx_msgType'] . "|" . $response_value['fpx_sellerExId'] . "|" . $response_value['fpx_sellerExOrderNo'] . "|" . $response_value['fpx_sellerId'] . "|" . $response_value['fpx_sellerOrderNo'] . "|" . $response_value['fpx_sellerTxnTime'] . "|" . $response_value['fpx_txnAmount'] . "|" . $response_value['fpx_txnCurrency'];
//            $val = self::verifySign_fpx($response_value['fpx_checkSum'], $data);
//            echo $val;

            if ($dump) {
                dump($response_value);
                dd($dump);
            }

            if ($payment_fpx->fpx_status_id != '00') { // prevent when data is 00 at first and 76 at second time.
                // update data
                $payment_fpx_data = [
                    'fpx_status_id' => $response_value['fpx_debitAuthCode'],
                    'updated_at' => date('Y-m-d H:i:s'),
                    'paid_at' => $fpx_txn_datetime,
                    'paid_amount' => urlencode($fpx_txnAmount),
                    'paid_by' => isset($token_adv[4]) ? str_replace('+', ' ', str_replace('fpx_buyerName=', '', $token_adv[4])) : null,
                    'fpx_transaction_no' => isset($token_adv[18]) ? str_replace('fpx_fpxTxnId=', '', $token_adv[18]) : null,
                ];

                $payment_fpx->update($payment_fpx_data);
            }

            if ($response_value['fpx_debitAuthCode'] == '00') {
                $payment = Payment::findOrFail($payment_fpx->payment_id);

                $log_counter = LogCounter::where('counter_key', 'fpx_receipt')->first();

                // check if receipt_no is already generated
                if ($payment->receipt_no == null) {
                    $receipt_is_null = 1;
                    $receipt_number = "T" . date('y') . sprintf('%06d', $log_counter->counter_value);
                } else {
                    $receipt_is_null = 0;
                    $receipt_number = $payment->receipt_no;
                }

                $payment->paid_at = $fpx_txn_datetime;
                $payment->receipt_no = $receipt_number;
                $payment->payment_status_id = 4;
                $payment->save();

                // save log receipt
                LogReceipt::create([
                    'payment_id' => $payment_fpx->payment_id,
                    'txn_type' => 'fpxrepository',
                    'receipt_number' => $receipt_number
                ]);

                if ($receipt_is_null == 1) {
                    $log_counter->counter_value = $log_counter->counter_value + 1;
                    $log_counter->save();
                }

                // update form data
                $payment = Payment::findOrFail($payment_fpx->payment_id);
                self::updateFormData($payment);
            }

            echo $payment_fpx->payment_fpx_id . ' - ' . $payment_fpx->fpx_status_id . PHP_EOL;

        } catch (Exception $e) {
            abort(403, $e->getMessage());
        }
    }

    private static function validateCertificate($sign, $toSign)
    {
        $error_code = '';
        $path = config('integration.fpx.cert_path');

        $fpx_certificate = [
            $path . config('integration.fpx.cert_exchange_filename') . ".cer",
            $path . config('integration.fpx.cert_fpx_filename') . ".cer",
        ];

        $certs = self::checkCertExpiry($fpx_certificate);
        $sign_data = self::hextobin($sign);

        if (count($certs) == 1) {
            $pkeyid = openssl_pkey_get_public($certs[0]);
            $ret = openssl_verify($toSign, $sign_data, $pkeyid);
            if ($ret != 1) {
                $error_code = " Your Data cannot be verified against the Signature. " . " ErrorCode :[09]";
                return "09";
            }
        } elseif (count($certs) == 2) {

            $pkeyid = openssl_pkey_get_public($certs[0]);
            $ret = openssl_verify($toSign, $sign_data, $pkeyid);
            if ($ret != 1) {
                $pkeyid = openssl_pkey_get_public($certs[1]);
                $ret = openssl_verify($toSign, $sign_data, $pkeyid);
                if ($ret != 1) {
                    $error_code = " Your Data cannot be verified against the Signature. " . " ErrorCode :[09]";
                    return "09";
                }
            }

        }
        echo $error_code;
        if ($ret == 1) {
            return "00"; // success
        }
        return $error_code;
    }

    private static function checkCertExpiry($path)
    {
        $stack = [];
        $cert_exists = 0;
        $curr_date = date("Ymd", time());

        for ($x = 0; $x < 2; $x++) {
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
                    if (certRollOver($path[$x], $path[$x - 1]) == "true") {
                        array_push($stack, $key_id);
                        return $stack;
                    }
                }
                array_push($stack, $key_id);
                return $stack;
            } elseif ($crtexpirydate == $curr_date) {
                if ($x > 0 && (file_exists($path[$x - 1]) != 1)) {
                    if (certRollOver($path[$x], $path[$x - 1]) == "true") {
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
        echo $ErrorCode;
        return $stack;

    }


    private static function verifySign_fpx($sign, $toSign)
    {
        error_reporting(0);

        return self::validateCertificate(config('integration.fpx.cert_path'), $sign, $toSign);
    }


    private static function hextobin($hexstr)
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

    protected static function updateFormData($payment)
    {
        $form_no = $payment->form_no;
        $form_id = $payment->form_id;

        if ($form_no == 1) {
            $form = Form1::find($form_id);
        } else if ($form_no == 2) {
            $form = Form2::find($form_id);
        }

        if ($form && $form->payment->payment_status_id != 4) {

            if ($form_no == 1) {
                $form->form_status_id = 14; // new
                $branch_id = $form->case->branch_id;
            } else {
                $form->form_status_id = 19; // new
                $branch_id = $form->form1->case->branch_id;
            }

            $filing_date = $form->filing_date = $form->filing_date ?:
                Carbon::now()->toDateString();
            $form->matured_date = $form->matured_date ?:
                getDateExcludeHolidayHelper::byBranch($filing_date, env("CONF_F1_MATURED_DURATION", 14), $branch_id);

            $form->payment_id = $payment->payment_id;
            $form->updated_at = Carbon::now();
            $form->save();
        }
    }
}
