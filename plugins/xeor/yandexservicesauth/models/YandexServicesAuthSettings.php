<?php namespace Xeor\YandexServicesAuth\Models;

use Model;

/**
 * YandexServicesAuthSettings Model
 */
class YandexServicesAuthSettings extends Model
{

    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'xeor_yandex_services_auth_fields';

    public $settingsFields = '';

}