<?php

/********************************************************************/
/*	Integration usage:												*/
/*		use App\Http\Controllers\Integration\MySMSController;		*/
/*																	*/
/*		$sms = new MySMSController;									*/
/*		$sms->sendSMS("01XXXXXXXX","Message right here");			*/
/********************************************************************/

namespace App\Http\Controllers\Integration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\LogModel\LogSMSSent;
use App\CaseModel\Inquiry;
use App\MasterModel\MasterState;
use Auth;

/**
 * @deprecated see App\Libraries\SendSms
 * Class MySMSController
 * @package App\Http\Controllers\Integration
 */
class MySMSController extends Controller
{
    //
    public function receiveSMS(Request $request) {
        $keyword = $request->keyword;                           //exmpl : POLIS
        $smsid = $request->smsid;                               //exmpl: 213239847326489
        $shortcode = $request->shortcode;                       //exmpl: 15888
        $sender = $request->sender;                             //+60191234567
        $guid = $request->guid;                                 //exmpl: A23456785.SD1234435
        $telco = $request->telco;                               // exmpl: CELCOM
        $details = strtoupper(urldecode($request->details));    //exmpl: POLIS SAMAN PXX2344

        $state = MasterState::find(16);

        $inquiry = new Inquiry;
        //$inquiry->inquiry_no = "S-WPPPJ-".$state->next_inquiry_no."-".date("Y");
        $inquiry->inquiry_method_id = 7;
        $inquiry->inquiry_msg = $details;
        $inquiry->save();

        $keys = explode(" ", $details);

        // if($keys[0] != "TTPM")
        //     $result = "Format mesej SMS salah. Sila semak semula.";
        // else
            $result = "Pertanyaan anda telah diterima dan disimpan.";

        $reply = $keyword.' : '.$result;

        return response($reply,200)
            ->header('Deliver', '0')
            ->header('StatusCode', '200')
            ->header('Reply', $reply);
    }

    public function sendSMS($sender,$details,$debug=false) {
        $this->middleware('auth');

		// Hard-coded information for MySMS
		$username="dapat15888";
        $password="ZGFwYXQxMjM=";
        $keyword="TTPM";
        $shortcode="15888";
        $telco="DIGI";
        $servicetype='BULK';

        // Check for any spaces
    	$sender = trim($sender);
    	$sender = str_replace(' ', '', $sender);
        // Check for - sign
        $sender = str_replace('-', '', $sender);
        // Start with 0
        if (substr($sender, 0, 1) == '6')
            $sender = "+".$sender;
        else if (substr($sender, 0, 1) == '0')
            $sender = "+6".$sender;

    	$get_request = "http://mtsms.15888.my/sendsms.aspx"
						."?username=".$username
        				."&password=".$password
        				."&keyword=".$keyword
        				."&smsid=0"
        				."&shortcode=".$shortcode
        				."&sender=".urlencode($sender)
        				."&servicetype=".$servicetype
        				."&details=".urlencode($details)
        				."&telco=".$telco
        				."&guid=0";

        // Make GET request to the server
        try {
    		$client = new Client();
    		$response = $client->request('GET', $get_request);

    		// Check for debug if option is enabled
    		if($debug===true){
                //dd($response);
                $result = $response;
            }
            else {
            	$output = explode("|", $response->getBody());

            	$result = $response->getBody();

    			// Check for response code
    			if(strpos( $output[sizeof($output) - 1], '200' ) !== false)
    				$result = 1;
    	        else
    	            $result = 0;

                // Logging
                $log = new LogSMSSent;
                $log->phone = $sender;
                $log->message = $details;
                $log->sender_user_id = Auth::id();
                $log->status = $response->getBody();
                $log->save();
            }

            // Return result = 1  if it is success, else return 0
            return $result;
            
        } catch (GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();

            return 0;
        }
	}
}
