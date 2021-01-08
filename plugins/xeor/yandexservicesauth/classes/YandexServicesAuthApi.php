<?php namespace Xeor\YandexServicesAuth\Classes;

use Xeor\YandexServicesAuth\Models\YandexServicesAuthSettings as Settings;

class YandexServicesAuthApi
{

    /**
     * API function to return information for other plugins.
     *
     * @param string $value
     *  - client_id
     *  - client_secret
     *  - token
     */
    public static function authInfo($value = 'token')
    {
        $settings = Settings::instance();
        switch ($value) {
            case 'client_id':
                return $settings->yandex_services_auth_client_id;
            case 'client_secret':
                return $settings->yandex_services_auth_client_secret;
            case 'token':
            default:
                return $settings->yandex_services_auth_token;
        }
    }

    /**
     * Deprecated API function to return information for other plugins.
     *
     * @param string $value
     *  - client_id
     *  - client_secret
     *  - token
     */
    public static function yandex_services_auth_info($value = 'token')
    {
        return self::authInfo($value);
    }

    /**
     * Helper function to determine the authorization status.
     */
    public static function authStatus($period = 604800) {
        $settings = Settings::instance();
        $auth_token = $settings->yandex_services_auth_token;
        $auth_timestamp = $settings->yandex_services_auth_timestamp;
        if (empty($auth_token)) {
            return 'not authorized';
        }
        if (empty($auth_timestamp)) {
            return 'authorized';
        }
        if (($auth_timestamp - $_SERVER['REQUEST_TIME']) < 0) {
            return 'expired';
        }
        if (($auth_timestamp - $_SERVER['REQUEST_TIME']) < $period) {
            return 'expiring';
        }
        else {
            return 'authorized';
        }
    }

}