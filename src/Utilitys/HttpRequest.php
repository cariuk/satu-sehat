<?php

namespace syahrulzzadie\SatuSehat\Utilitys;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Validation\ValidationException;
use syahrulzzadie\SatuSehat\JsonResponse as jsonResponse;
use syahrulzzadie\SatuSehat\Models\SatusehatLog;

class HttpRequest
{
    public static function log($id, $action, $url, $payload, $response)
    {
        $status = new SatusehatLog();
        $status->response_id = $id;
        $status->action = $action;
        $status->url = $url;
        $status->payload = $payload;
        $status->response = $response;
        $status->user_id = auth()->user() ? auth()->user()->id : 'Cron Job';
        $status->save();
    }

    public static function get($url)
    {
        $getToken = jsonResponse\Auth::getToken();

        if ($getToken['status']) {
            try {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/x-www-form-urlencoded',
                    'Authorization: Bearer ' . $getToken['token']
                ]);
                $response = curl_exec($ch);
                if (curl_errno($ch)) {
                    return [
                        'status' => false,
                        'message' => curl_error($ch)
                    ];
                }
                curl_close($ch);
                return [
                    'status' => true,
                    'response' => $response
                ];
            } catch (\Exception $e) {

                return ['status' => false, 'message' => $e->getMessage()];
            }
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function post($url, $formData)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $client = new Client();
            $headers = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $getToken['token'],
            ];

            $request = new Request('POST', $url, $headers, json_encode($formData));

            try {
                $res = $client->sendAsync($request)->wait();
                $statusCode = $res->getStatusCode();
                $response = json_decode($res->getBody()->getContents());

                if ($response->resourceType == 'OperationOutcome' || $statusCode >= 400) {
                    $id = 'Error ' . $statusCode;
                } else {
                    $id = $response->id;
                }

                Self::log($id, 'POST', $url, (array)$formData, (array)$response);

                return [$statusCode, $response];
            } catch (ClientException $e) {

                $statusCode = $e->getResponse()->getStatusCode();
                $res = json_decode($e->getResponse()->getBody()->getContents());

                Self::log('Error ' . $statusCode, 'POST', $url, (array)$formData, (array)$res);

                return [$statusCode, $res];
            }
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function postTextPlain($url, $textPlain)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            try {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: text/plain',
                    'Authorization: Bearer ' . $getToken['token']
                ]);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $textPlain);
                $response = curl_exec($ch);
                if (curl_errno($ch)) {
                    return [
                        'status' => false,
                        'message' => curl_error($ch)
                    ];
                }
                curl_close($ch);
                return [
                    'status' => true,
                    'response' => $response
                ];
            } catch (\Exception $e) {
                return ['status' => false, 'message' => $e->getMessage()];
            }
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function put($url, $formData)
    {
        $getToken = jsonResponse\Auth::getToken();
        if ($getToken['status']) {
            $client = new Client();
            $headers = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $getToken['token'],
            ];

            $request = new Request('PUT', $url, $headers, json_encode($formData));

            try {
                $res = $client->sendAsync($request)->wait();
                $statusCode = $res->getStatusCode();
                $response = json_decode($res->getBody()->getContents());

                if ($response->resourceType == 'OperationOutcome' || $statusCode >= 400) {
                    $id = 'Error ' . $statusCode;
                } else {
                    $id = $response->id;
                }
                Self::log($id, 'PUT', $url, (array)$formData, (array)$response);

                return [$statusCode, $response];
            } catch (ClientException $e) {
                $statusCode = $e->getResponse()->getStatusCode();
                $res = json_decode($e->getResponse()->getBody()->getContents());

                Self::log('Error ' . $statusCode, 'PUT', $url, null, (array)$res);

                return [$statusCode, $res];
            }
        }
        return jsonResponse\Error::getToken($getToken);
    }

    public static function poolGet($urls = [])
    {
        $responses = [];
        foreach ($urls as $name => $url) {
            $responses[$name] = self::get($url);
        }
        return $responses;
    }
}
