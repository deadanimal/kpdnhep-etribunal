<?php

namespace App\Http\Controllers\Integration;

use App\Http\Controllers\Controller;
use App\MasterModel\MasterState;
use Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Psr\Http\Message\ResponseInterface;

class SsmController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checkSsm(Request $request)
    {
        $fields = [
            'accessid' => config('ssm.access_id'),
            'refno' => config('ssm.ref_no') . ' ' . (Auth::user()->user_id ?? '-'),
            'regno' => $request->regno
        ];

        return self::fetchData($fields);
    }

    public static function fetchData($fields)
    {
        $url = config('ssm.url') . 'search.php';
        $client = new Client();
        $options = [
            'form_params' => $fields,
            'debug' => false,
        ];

        /**
         * @param \GuzzleHttp\Promise\PromiseInterface $client
         * @return Object
         */
        $promise = $client->postAsync($url, $options)->then(
            function (ResponseInterface $res) {
                return $res;
            },
            function (RequestException $e) {
                return $e->getMessage();
            }
        );

        $promise_response = $promise->wait();

        $response = json_decode($promise_response->getBody()->getContents());

        $states = MasterState::pluck('state_id', 'code_hubssm');

        if($response->status == 403) {
            return ['status' => 'failed', 'message' => __("swal.user_not_found")];
        }

        if ($response->status == 200) {
            switch ($response->type) {
                case 'ROB':
                    $dataFinal = [
                        'name' => $response->data->robBusinessInfo->registrationName ?? null,
                        'address_1' => $response->data->robBusinessInfo->mainAddress1 ?? null,
                        'address_2' => $response->data->robBusinessInfo->mainAddress2 ?? null,
                        'address_3' => $response->data->robBusinessInfo->mainAddress3 ?? null,
                        'postcode' => $response->data->robBusinessInfo->mainPostcode ?? null,
                        'state' => $state[$response->data->robBusinessInfo->mainState] ?? '',
                    ];
                    break;
                case 'ROC':
                    $dataFinal = [
                        'name' => $response->data->rocCompanyInfo->companyName,
                        'address_1' => $response->data->rocRegAddressInfo->address1,
                        'address_2' => $response->data->rocRegAddressInfo->address2,
                        'address_3' => $response->data->rocRegAddressInfo->address3,
                        'postcode' => $response->data->rocRegAddressInfo->postcode,
                        'state' => $states[$response->data->rocRegAddressInfo->state] ?? '',
                    ];
                    break;
                default:
                    $dataFinal = [];
                    break;
            }

            return ['status' => 'ok', 'data' => $dataFinal, 'message' => __("swal.user_found")];
        }

        return ['status' => 'failed', 'message' => __("swal.user_not_found")];
    }
}
