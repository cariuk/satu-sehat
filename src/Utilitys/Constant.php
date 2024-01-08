<?php

namespace syahrulzzadie\SatuSehat\Utilitys;

use Dotenv\Dotenv;

class Constant
{
    public static $consentUrl = "https://api-satusehat.kemkes.go.id/consent/v1";
    public static $kfaUrl = "https://api-satusehat.kemkes.go.id/kfa-v2";
    public static $kycUrl = "https://api-satusehat.kemkes.go.id/kyc/v1";

    public static function authUrl()
    {
        $dotenv = Dotenv::createUnsafeImmutable(getcwd());
        $dotenv->safeLoad();
        switch (getenv('SATUSEHAT_ENV')){
            case 'PROD' : {
                return getenv('SATUSEHAT_AUTH_PROD');
                break;
            }
            case 'STG' : {
                return getenv('SATUSEHAT_AUTH_STG');
                break;
            }
            case 'DEV' : {
                return getenv('SATUSEHAT_AUTH_DEV');
                break;
            }
        }
    }

    public static function baseUrl()
    {
        $dotenv = Dotenv::createUnsafeImmutable(getcwd());
        $dotenv->safeLoad();
        switch (getenv('SATUSEHAT_ENV')){
            case 'PROD' : {
                return getenv('SATUSEHAT_FHIR_PROD');
                break;
            }
            case 'STG' : {
                return getenv('SATUSEHAT_FHIR_STH');
                break;
            }
            case 'DEV' : {
                return getenv('SATUSEHAT_FHIR_deV');
                break;
            }
        }
    }
}
