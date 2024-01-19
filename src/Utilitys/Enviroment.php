<?php

namespace syahrulzzadie\SatuSehat\Utilitys;

use Dotenv\Dotenv;

class Enviroment
{
    public function __construct()
    {


        switch (getenv('SATUSEHAT_ENV'))
        {
            case 'PROD' : {
                $this->client_id =  getenv('CLIENTID_PROD');
                $this->client_secret = getenv('CLIENTSECRET_PROD');
                $this->organization_id = getenv('CLIENTSECRET_PROD');
                break;
            }
            case 'STG' : {
                $this->client_id =  getenv('CLIENTID_STG');
                $this->client_secret = getenv('CLIENTSECRET_STG');
                $this->organization_id = getenv('CLIENTSECRET_STG');

                break;
            }
            case 'DEV' : {
                $this->client_id =  getenv('CLIENTID_DEV');
                $this->client_secret = getenv('CLIENTSECRET_DEV');
                $this->organization_id = getenv('CLIENTSECRET_DEV');
                break;
            }
            default : {
                return [
                    'status' => false,
                    'message' => 'Add your organization_id at environment first'
                ];
            }
        }
    }

    public static function clientId()
    {
        $dotenv = Dotenv::createUnsafeImmutable(getcwd());
        $dotenv->safeLoad();
        switch (getenv('SATUSEHAT_ENV')){
            case 'PROD' : {
                return getenv('CLIENTID_PROD');
                break;
            }
            case 'STG' : {
                return getenv('CLIENTID_STG');
                break;
            }
            case 'DEV' : {
                return getenv('CLIENTID_DEV');
                break;
            }
        }
    }

    public static function clientSecret()
    {
        $dotenv = Dotenv::createUnsafeImmutable(getcwd());
        $dotenv->safeLoad();
        switch (getenv('SATUSEHAT_ENV')){
            case 'PROD' : {
                return getenv('CLIENTSECRET_PROD');
                break;
            }
            case 'STG' : {
                return getenv('CLIENTSECRET_STG');
                break;
            }
            case 'DEV' : {
                return getenv('CLIENTSECRET_DEV');
                break;
            }
        }
    }

    public static function organizationId()
    {
        $dotenv = Dotenv::createUnsafeImmutable(getcwd());
        $dotenv->safeLoad();
        switch (getenv('SATUSEHAT_ENV')){
            case 'PROD' : {
                return getenv('ORGID_PROD');
                break;
            }
            case 'STG' : {
                return getenv('ORGID_STG');
                break;
            }
            case 'DEV' : {
                return getenv('ORGID_DEV');
                break;
            }
        }
    }
}
