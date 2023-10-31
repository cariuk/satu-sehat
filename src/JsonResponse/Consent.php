<?php

namespace syahrulzzadie\SatuSehat\JsonResponse;

class Consent
{
    public static function convert($response)
    {
        $data = json_decode($response->body(),true);
        return [
            'ihs_number' => $data['id'],
            'data' => $data
        ];
    }
}