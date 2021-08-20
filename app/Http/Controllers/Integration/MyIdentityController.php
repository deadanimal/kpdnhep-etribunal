<?php

namespace App\Http\Controllers\Integration;

use App;
use App\Http\Controllers\Controller;
use App\LogModel\LogMyIdentity;
use App\Repositories\KpdnMyIdentityRepository;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use SoapClient;

class MyIdentityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['checkIC', 'checkICFull']);
    }

    public function checkIcPublic(Request $request)
    {
//        dd($request->all());
        $data = $request->all();

        $log = LogMyIdentity::select(DB::raw('count(1) as total'))
            ->where('ip_address', $request->ip())
            ->where('requested_at', '>=', Carbon::parse()->subHour()->toDateTimeString())
            ->first();

        if ($log->total >= 20) {
            return response()->json(['status' => 'fail', 'message' => 'Too many request. Please try later.']);
        }

        LogMyIdentity::create([
            'ip_address' => $request->ip(),
            'agency_code' => 110012,
            'branch_code' => 'eTribunal',
            'username' => Auth::user()->username ?? $data['ic'],
            'transaction_code' => 'T7',
            'requested_at' => date('Y-m-d H:i:s'),
            'requested_ic' => $data['ic'],
            'request_indicator' => '1',
            'replied_at' => date('Y-m-d H:i:s'),
            'reply_indicator' => '1'
        ]);

        $identity = self::checkIcNew($data['ic']);

        if ($data['name'] != $identity['Name']) {
            return response()->json(['status' => 'fail', 'message' => 'Identification number not valid or name not match or both.']);
        }

        return response()->json(['status' => 'ok', 'message' => 'success', 'data' => $identity]);
    }

    public function checkIC(Request $request, $ic)
    {
        LogMyIdentity::create([
            'ip_address' => $request->ip(),
            'agency_code' => 110012,
            'branch_code' => 'eTribunal',
            'username' => Auth::user()->username ?? $ic,
            'transaction_code' => 'T7',
            'requested_at' => date('Y-m-d H:i:s'),
            'requested_ic' => $ic,
            'request_indicator' => 'C',
            'replied_at' => date('Y-m-d H:i:s'),
            'reply_indicator' => '1'
        ]);


        return self::checkIcNew($ic);

//        return self::checkIcOld($request, $ic);

    }

    protected static function checkIcNew($ic)
    {
        $data = KpdnMyIdentityRepository::search($ic, $ic, 'public');

        if ($data['ReplyIndicator'] > 0) {
            $data['RecordStatus'] = (in_array($data['RecordStatus'], ['A', '1', 'F'])
                ? __('new.active')
                : (in_array($data['RecordStatus'], ['A', '1', 'F'])
                    ? __('new.died')
                    : '')
            );

            $data['ResidentialStatus'] = (in_array(trim($data['ResidentialStatus']), ['B', 'C', ''])
                ? __('new.citizen')
                : (in_array($data['ResidentialStatus'], ['M', 'P'])
                    ? __('new.permanent_resident')
                    : (in_array($data['ResidentialStatus'], ['M', 'P'])
                        ? __('new.not_citizen_or_perm')
                        : '')
                )
            );
        }

        if ($data) {
            return response()->json($data);
        }

        return response()->json();
    }

    protected static function checkIcOld($request, $ic)
    {
        $validate = $request->validate ? $request->validate : false;
        $pic = $request->pic ? $request->pic : false;
        libxml_disable_entity_loader(false);
        $client = new SoapClient('/var/www/html/crsservice.wsdl', ['stream_context' => stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]])]);
        libxml_disable_entity_loader(true);
        $arr = array(
            "AgencyCode" => "110012",
            "BranchCode" => "eTribunal",
            "UserId" => Auth::check() ? Auth::user()->username : $ic,
            "TransactionCode" => Auth::check() ? (Auth::user()->user_type_id != 3 ? "T2" : "T7") : "T7", // T2-Agency T7-Public
            "RequestDateTime" => date("c"),
            "ICNumber" => $ic,
            "RequestIndicator" => $pic ? "A" : "C", // A-BasicInfo C-Picture+Info
        );

        // 850402105677

        $obj = $client->__soapCall("retrieveCitizensData", array($arr));

        LogMyIdentity::create([
            'ip_address' => $request->ip(),
            'agency_code' => $obj->AgencyCode,
            'branch_code' => $obj->BranchCode,
            'username' => $obj->UserId,
            'transaction_code' => $obj->TransactionCode,
            'requested_at' => date('Y-m-d H:i:s', strtotime($arr['RequestDateTime'])),
            'requested_ic' => $ic,
            'request_indicator' => $arr['RequestIndicator'],
            'replied_at' => $obj->ReplyDateTime ? date('Y-m-d H:i:s', strtotime($obj->ReplyDateTime)) : date('Y-m-d H:i:s'),
            'reply_indicator' => $obj->ReplyIndicator
        ]);

        if ($obj->ReplyIndicator > 0) {

            if (property_exists($obj, 'RecordStatus')) {
                if ($obj->RecordStatus == "A" || $obj->RecordStatus == "1" || $obj->RecordStatus == "F")
                    $obj->RecordStatus = __('new.active');
                else if ($obj->RecordStatus == "2" || $obj->RecordStatus == "B" || $obj->RecordStatus == "H")
                    $obj->RecordStatus = __('new.died');
            }

            if (property_exists($obj, 'ResidentialStatus')) {
                if ($obj->ResidentialStatus == "B" || $obj->ResidentialStatus == "C" || trim($obj->ResidentialStatus) == "")
                    $obj->ResidentialStatus = __('new.citizen');
                else if ($obj->ResidentialStatus == "M" || $obj->ResidentialStatus == "P")
                    $obj->ResidentialStatus = __('new.permanent_resident');
                else if ($obj->ResidentialStatus == "H" || $obj->ResidentialStatus == "X" || $obj->ResidentialStatus == "Q")
                    $obj->ResidentialStatus = __('new.not_citizen_or_perm');
            }
        }

        if (property_exists($obj, 'Message')) {
            $obj->Message = self::translateMessage($obj->Message);
        }

        if ($validate) {
            return response()->json([
                "ReplyIndicator" => $obj->ReplyIndicator,
                "RecordStatus" => property_exists($obj, 'RecordStatus') ? $obj->RecordStatus : null,
                "ResidentialStatus" => property_exists($obj, 'ResidentialStatus') ? $obj->ResidentialStatus : null,
                "Message" => property_exists($obj, 'Message') ? $obj->Message : null,
                "Name" => property_exists($obj, 'Name') ? $obj->Name : null
            ]);
        }

        return response()->json($obj);
    }

    public function checkSOAP()
    {
        if (extension_loaded('soap'))
            die("Yay! SOAP installed!");
        else
            die("Nay! SOAP not installed!");
    }

    public function checkICFull(Request $request)
    {
        if (!Auth::user() || Auth::user()->user_type_id == 3) {
            return 'ok';
        }

        LogMyIdentity::create([
            'ip_address' => $request->ip(),
            'agency_code' => 110012,
            'branch_code' => 'eTribunal',
            'username' => Auth::user()->username ?? $request->ic,
            'transaction_code' => 'T7',
            'requested_at' => date('Y-m-d H:i:s'),
            'requested_ic' => $request->ic,
            'request_indicator' => 'C',
            'replied_at' => date('Y-m-d H:i:s'),
            'reply_indicator' => '1'
        ]);

        $data = KpdnMyIdentityRepository::search($request->ic, $request->ic, 'all');

        if (isset($data['Message'])) {
            $data['Message'] = self::translateMessage($data['Message']);
        }

        if (isset($data['Photo'])) {
            $data['Photo'] = base64_encode(pack('H*', $data['Photo']));
        }

        $obj = $data;

        return view('integration.myidentity.viewModal', compact("obj"));

        $ic = $request->ic;

        libxml_disable_entity_loader(false);
        $client = new SoapClient('/var/www/html/crsservice.wsdl', ['stream_context' => stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]])]);
        libxml_disable_entity_loader(true);

        $arr = array(
            "AgencyCode" => "110012",
            "BranchCode" => "eTribunal",
            "UserId" => Auth::check() ? Auth::user()->username : $ic,
            "TransactionCode" => "T2",
            "RequestDateTime" => date("c"),
            "ICNumber" => $ic,
            "RequestIndicator" => "C", // A-BasicInfo C-Picture+Info
        );
        $obj = $client->__soapCall("retrieveCitizensData", array($arr));

        LogMyIdentity::create([
            'ip_address' => $request->ip(),
            'agency_code' => $obj->AgencyCode,
            'branch_code' => $obj->BranchCode,
            'username' => $obj->UserId,
            'transaction_code' => $obj->TransactionCode,
            'requested_at' => date('Y-m-d H:i:s', strtotime($arr['RequestDateTime'])),
            'requested_ic' => $ic,
            'request_indicator' => $arr['RequestIndicator'],
            'replied_at' => $obj->ReplyDateTime ? date('Y-m-d H:i:s', strtotime($obj->ReplyDateTime)) : date('Y-m-d H:i:s'),
            'reply_indicator' => $obj->ReplyIndicator
        ]);

        if (property_exists($obj, 'Message')) {
            $obj->Message = self::translateMessage($obj->Message);
        }

        if (property_exists($obj, 'Photo')) {
            $obj->Photo = base64_encode($this->hexToStr($obj->Photo));
        }

        return view('integration.myidentity.viewModal', compact("obj"));
    }

    protected function hexToStr($hex)
    {
        $string = '';
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $string .= chr(hexdec($hex[$i] . $hex[$i + 1]));
        }
        return $string;
    }

    protected static function translateMessage($message)
    {

        if (App::getLocale() == "my")
            return $message;

        if (stripos($message, "Rekod tidak dijumpai dalam myIDENTITY") !== false) {
            return str_replace("Rekod tidak dijumpai dalam myIDENTITY", "The record is not found in myIDENTITY", $message);
        } else if (stripos($message, "Pemilik diminta hadir ke JPN untuk menukar Kad Pengenalan ke MyKad") !== false) {
            return str_replace("Pemilik diminta hadir ke JPN untuk menukar Kad Pengenalan ke MyKad", "The owner is required to be present at JPN to change the Identification Card to MyKad", $message);
        } else if (stripos($message, "Pemilik Kad Pengenalan adalah Penduduk Sementara") !== false) {
            return str_replace("Pemilik Kad Pengenalan adalah Penduduk Sementara", "The owner of the Identification Card is a Temporary Resident", $message);
        } else if (stripos($message, "Taraf Penduduk Pemilik Kad Pengenalan belum ditentukan") !== false) {
            return str_replace("Taraf Penduduk Pemilik Kad Pengenalan belum ditentukan", "The Residential Status of the owner for the Identification Card is yet to be confirmed", $message);
        } else if (stripos($message, "Pemilik Kad Pengenalan bukan Warganegara") !== false) {
            return str_replace("Pemilik Kad Pengenalan bukan Warganegara", "The owner of the Identification Card is not a Citizen", $message);
        } else if (stripos($message, "No Kad Pengenalan telah bertukar. Gunakan No Kad Pengenalan yang baru") !== false) {
            return str_replace("No Kad Pengenalan telah bertukar. Gunakan No Kad Pengenalan yang baru", "Identification Card No. has been changed. Please use the new Identification Card No", $message);
        } else if (stripos($message, "Tiada maklumat Taraf Penduduk. Pemilik diminta hadir ke JPN untuk semakan") !== false) {
            return str_replace("Tiada maklumat Taraf Penduduk. Pemilik diminta hadir ke JPN untuk semakan", "The Residential Status is unavailable. The owner is required to be present at JPN for review", $message);
        } else if (stripos($message, "Status Rekod Tidak Sah. Pemilik diminta hadir ke JPN untuk semakan") !== false) {
            return str_replace("Status Rekod Tidak Sah. Pemilik diminta hadir ke JPN untuk semakan", "The Record Status is invalid. The owner is required to be present at JPN for review", $message);
        } else if (stripos($message, "Rekod di JPN perlu dikemaskini. Pemilik diminta hadir ke JPN untuk semakan dan pengesahan") !== false) {
            return str_replace("Rekod di JPN perlu dikemaskini. Pemilik diminta hadir ke JPN untuk semakan dan pengesahan", "The record at JPN needs to be updated. The owner is required to be present at JPN for review and verification", $message);
        } else if (stripos($message, "Pemilik diminta hadir ke JPN untuk semakan") !== false) {
            return str_replace("Pemilik diminta hadir ke JPN untuk semakan", "The owner is required to be present at JPN for review", $message);
        } else if (stripos($message, "Pastikan nilai atau format data yang dihantar adalah betul") !== false) {
            return str_replace("Pastikan nilai atau format data yang dihantar adalah betul", "Please make sure the value or format sent is valid", $message);
        } else
            return $message;
    }
}
