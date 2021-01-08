<?php

use Xeor\YandexServicesAuth\Models\YandexServicesAuthSettings as Settings;

Route::get('yandex_services_auth/oauth', function (){
    if (empty($_GET['code'])) {
        Log::warning('Yandex Services Auth: The "code" parameter is empty.');
        return redirect('/backend/xeor/yandexservicesauth/settings');
    }
    $settings = Settings::instance();
    $client_id = $settings->yandex_services_auth_client_id;
    $client_secret = $settings->yandex_services_auth_client_secret;
    $query = array(
        'grant_type' => 'authorization_code',
        'client_id' => $client_id,
        'code' => $_GET['code']
    );
    if (!empty($client_secret)) {
        $query['client_secret'] = $client_secret;
    }
    $query = http_build_query($query);
    $header = "Content-type: application/x-www-form-urlencoded";
    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => $header,
            'content' => $query
        )
    );
    $context = stream_context_create($opts);
    $result = file_get_contents('https://oauth.yandex.ru/token', false, $context);
    if ($result === FALSE) {
        Log::warning('Yandex Services Auth: Token request failed.');
        return redirect('/backend/xeor/yandexservicesauth/settings');
    }
    $response = json_decode($result);
    $settings->yandex_services_auth_token = $response->access_token;
    if (isset($response->expires_in)) {
        $settings->yandex_services_auth_timestamp = $_SERVER['REQUEST_TIME'] + $response->expires_in;
    }
    else {
        $settings->yandex_services_auth_timestamp = NULL;
    }
    $settings->save();
    Log::info('Yandex Services Auth: Token request is successful.');
    return redirect('/backend/xeor/yandexservicesauth/settings');
});
