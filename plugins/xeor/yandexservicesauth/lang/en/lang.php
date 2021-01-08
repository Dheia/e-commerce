<?php

return [
    'plugin' => [
        'name' => 'Yandex Services Authorization API',
        'description' => 'Provides authorization routines for different Yandex services.',
        'tab' => 'Yandex Services Authorization API',
        'access_settings' => 'Manage Yandex Services Authorization API Settings'
    ],
    'settings' => [
        'menu_label' => 'Yandex Services Authorization API',
        'menu_description' => 'Manage Yandex Services Authorization API Settings.',
        'yandex_services_auth_section' => 'Yandex Services Authorization API',
        'yandex_services_auth_client_id' => 'Client ID',
        'yandex_services_auth_client_secret' => 'Client Secret',
        'yandex_services_auth_timestamp' => 'Expiration time',
        'required_client_id' => 'Client ID field is required.',
        'saving' => 'Saving...',
        'not_authorized' => 'The application is not authorized yet.',
        'authorized' => 'The application is already authorized.',
        'expiring' => 'The application authorization is expiring.',
        'expired' => 'The application authorization has expired.',
        'section_title' => 'Yandex Services Authorization API',
    ]
];
