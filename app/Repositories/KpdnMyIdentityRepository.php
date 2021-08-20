<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class KpdnMyIdentityRepository
 * KPDN My Identity Repository to validate and fetch
 * data of person using malaysia identification number.
 *
 * @package App\Repositories
 */
class KpdnMyIdentityRepository
{
    /**
     * @param $nric
     * @param $userId
     * @param string $type
     * @return array|bool|null[]|string
     */
    public static function search($nric, $userId, $type = 'basic')
    {
        return self::getMyIdentity($nric, self::generateToken($userId), $userId, $type);
    }

    /**
     * Generate new token.
     * @param $userId
     * @return bool|string
     */
    public static function generateToken($userId)
    {
        $fields = [
            'name' => 'generateToken',
            'param' => [
                'user_id' => $userId,
                'app_id' => config('myidentity.app_id'),
                'app_secret' => config('myidentity.app_secret'),
            ]
        ];

        return static::fetchData($fields);
    }

    /**
     * Get identity data
     * @param $nric
     * @param $token
     * @param $userId
     * @param string $type
     * @return bool|string
     */
    public static function getMyIdentity($nric, $token, $userId, $type = 'basic')
    {
        $fields = [
            'name' => 'getMyIdentity',
            'param' => [
                'nokp' => $nric,
            ]
        ];

        return static::fetchData($fields, $token, $type);
    }

    /**
     * Prepare for data fetching using CURL.
     *
     * @param $fields
     * @param null $token
     * @param string $type
     * @return array|bool|null[]|string
     */
    public static function fetchData($fields, $token = null, $type = 'basic')
    {
        $fields_string = '';

//        foreach ($fields as $key => $value) {
//            $fields_string .= $key . '=' . $value . '&';
//        }
//
//        rtrim($fields_string, '&');

        $url = config('myidentity.url') . 'jwtapi/';
        $client = new Client();
        $options = [
            'json' => $fields,
//            'handler' => $stack,
            'debug' => false,
        ];

        if ($token != null) {
            $options['headers'] = [
                'Authorization' => 'Bearer ' . $token,
            ];
        }
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

        switch ($fields['name']) {
            case 'getMyIdentity':
                if ($response->response->status == 200) {
                    return static::getDataBasedOnType($response->response->result, $type);
                } else {
                    return $response->error->message;
                }
            case 'generateToken':
            default:
                if ($response->response->status == 200) {
                    return $response->response->result->token;
                }
        }
    }

    /**
     * @param $result
     * @param $type
     * @return array
     */
    public static function getDataBasedOnType($result, $type)
    {
        switch ($type) {
            case 'all':
                return static::getAllData($result);
            case 'basic':
            case 'public':
            default:
                return static::getBasicData($result);
        }
    }

    /**
     * @param $result
     * @return array
     */
    public static function getAllData($result)
    {
        return (array)$result;
    }

    /**
     * @param $result
     * @return array
     */
    public static function getBasicData($result)
    {
        return $data = [
            "ReplyIndicator" => $result->ReplyIndicator ?? null,
            "RecordStatus" => $result->RecordStatus ?? null,
            "ResidentialStatus" => $result->ResidentialStatus ?? null,
            "Message" => $result->Message ?? null,
            "Name" => $result->Name ?? null,
            'ICNumber' => $result->ICNumber ?? null,
            'DateOfBirth' => $result->DateOfBirth ?? null,
            'Gender' => $result->Gender ?? null,
        ];
    }

    /**
     * @param $result
     * @param $dataset
     * @return array
     */
    public static function getCustomData($result, $dataset)
    {
        $data_key = [
            'nric' => 'ICNumber',
            'old_ic' => 'OldICnumber',
            'name' => 'Name',
            'dob' => 'DateOfBirth',
            'dod' => 'DateOfDeath',
            'gender' => 'Gender',
            'race' => 'Race',
            'photo' => 'Photo',
            'religion' => 'Religion',
            'citizenship_status' => 'CitizenshipStatus',
            'residential_status' => 'ResidentialStatus',
            'email_address' => 'EmailAddress',
            'phone_mobile_number' => 'MobilePhoneNumber',
            'perm_address_1' => 'PermanentAddress1',
            'perm_address_2' => 'PermanentAddress2',
            'perm_address_3' => 'PermanentAddress3',
            'perm_address_postcode' => 'PermanentAddressPostcode',
            'perm_address_city' => 'PermanentAddressCityCode',
            'perm_address_state' => 'PermanentAddressStateCode',
            'corr_address_1' => 'CorrespondenceAddress1',
            'corr_address_2' => 'CorrespondenceAddress2',
            'corr_address_3' => 'CorrespondenceAddress3',
            'corr_address_postcode' => 'CorrespondenceAddressPostcode',
            'corr_address_city' => 'CorrespondenceAddressCityCode',
            'corr_address_state' => 'CorrespondenceAddressStateCode',
            'corr_address_country' => 'CorrespondenceAddressCountryCode',
        ];
        $data = [];

        foreach ($dataset as $key => $datum) {
            $data[$datum] = $result->$data_key[$datum];
        }

        return $data;
    }
}
