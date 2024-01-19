<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

use DateTime;
use Dotenv\Dotenv;
use syahrulzzadie\SatuSehat\Models\SatusehatToken;
use syahrulzzadie\SatuSehat\Utilitys\Enviroment;
use syahrulzzadie\SatuSehat\Utilitys\Url;

class Auth
{
    public $patient_dev = ['P02478375538', 'P02428473601', 'P03647103112', 'P01058967035', 'P01836748436', 'P01654557057', 'P00805884304', 'P00883356749', 'P00912894463'];

    public $practitioner_dev = ['10009880728', '10006926841', '10001354453', '10010910332', '10018180913', '10002074224', '10012572188', '10018452434', '10014058550', '10001915884'];

    private static function requestToken(): array
    {
        $dotenv = Dotenv::createUnsafeImmutable(getcwd());
        $dotenv->safeLoad();

        switch (getenv('SATUSEHAT_ENV'))
        {
            case 'PROD' : {
                $clientId =  getenv('CLIENTID_PROD');
                $clientSecret = getenv('CLIENTSECRET_PROD');
                break;
            }
            case 'STG' : {
                $clientId =  getenv('CLIENTID_STG');
                $clientSecret = getenv('CLIENTSECRET_STG');
                break;
            }
            case 'DEV' : {
                $clientId =  getenv('CLIENTID_DEV');
                $clientSecret = getenv('CLIENTSECRET_DEV');
                break;
            }
            default : {
                return [
                    'status' => false,
                    'message' => 'Add your organization_id at environment first'
                ];
            }
        }

        try {
            $url = Url::authUrl();
            $data['client_id'] = $clientId;
            $data['client_secret'] = $clientSecret;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded'
            ]);
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                return [
                    'status' => false,
                    'message' => curl_error($ch)
                ];
            }
            curl_close($ch);
            $data = json_decode($response, true);

            return [
                'status' => true,
                'data' => [
                    'token' => $data['access_token'],
                    'expired' => $data['expires_in'],
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    private static function generateToken(): array
    {
        $requestToken = self::requestToken();
        if ($requestToken['status']) {
            $data = $requestToken['data'];

            SatusehatToken::create([
                'environment' => getenv('SATUSEHAT_ENV'),
                'token' => $data['token']
            ]);

            return [
                'status' => true,
                'data' => [
                    'token' => $data['token']
                ]
            ];
        }
        return [
            'status' => false,
            'message' => $requestToken['message']
        ];
    }

    private static function getDiffSecond($dateTime)
    {
        $datetime = new DateTime($dateTime);
        $current_datetime = new DateTime();
        $interval = $current_datetime->diff($datetime);
        $seconds_difference = $interval->s + ($interval->i * 60) + ($interval->h * 3600) + ($interval->days * 86400);
        return intval($seconds_difference);
    }

    public static function getToken(): array
    {
        $token = SatusehatToken::where('environment', getenv('SATUSEHAT_ENV'))->orderBy('created_at', 'desc')
            ->where('created_at', '>', now()->subMinutes(50))->first();

        if ($token) {
            return [
                'status' => true,
                'token' => $token->token
            ];
        } else {
            $generate = self::generateToken();
            if ($generate['status']) {
                $data = $generate['data'];
                return [
                    'status' => true,
                    'token' => $data['token']
                ];
            } else {
                return [
                    'status' => false,
                    'message' => $generate['message']
                ];
            }
        }
    }
}
