<?php namespace Xeor\YandexServicesAuth\Controllers;

use Log;
use Redirect;
use BackendMenu;
use ValidationException;
use Backend\Classes\Controller;
use System\Classes\SettingsManager;
use Xeor\YandexServicesAuth\Models\YandexServicesAuthSettings;
use Xeor\YandexServicesAuth\Classes\YandexServicesAuthApi;

/**
 * Settings Back-end Controller
 */
class Settings extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'xeor.yandexservicesauth::lang.settings.menu_label';
        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('Xeor.YandexServicesAuth', 'settings');
    }

    public function index()
    {
        $settings = YandexServicesAuthSettings::instance();
        $this->vars['yandex_services_auth_client_id'] = $settings->yandex_services_auth_client_id;
        $this->vars['yandex_services_auth_client_secret'] = $settings->yandex_services_auth_client_secret;
        $status = YandexServicesAuthApi::authStatus();
        switch ($status) {
            case 'not authorized':
                $this->vars['auth_status'] = '<span style="color:red;">' . e(trans('xeor.yandexservicesauth::lang.settings.not_authorized')) . '</span>';
                break;
            case 'authorized':
                $this->vars['auth_status'] = '<span style="color:green;">' . e(trans('xeor.yandexservicesauth::lang.settings.authorized')) . '</span>';
                break;
            case 'expiring':
                $this->vars['auth_status'] = '<span style="color:yellow;">' . e(trans('xeor.yandexservicesauth::lang.settings.expiring')) . '</span>';
                break;
            case 'expired':
                $this->vars['auth_status'] = '<span style="color:red;">' . e(trans('xeor.yandexservicesauth::lang.settings.expired')) . '</span>';
                break;
            default:
                $this->vars['auth_status'] = '';
                break;
        }
    }

    public function index_onSave()
    {
        $yandex_services_auth_client_id = post('yandex_services_auth_client_id');
        $yandex_services_auth_client_secret = post('yandex_services_auth_client_secret');
        if (!strlen($yandex_services_auth_client_id)) {
            throw new ValidationException(['yandex_services_auth_client_id' => trans('xeor.yandexservicesauth::lang.settings.required_client_id')]);
        }
        else {
            $settings = YandexServicesAuthSettings::instance();
            $settings->yandex_services_auth_client_id = $yandex_services_auth_client_id;
            $settings->yandex_services_auth_client_secret = $yandex_services_auth_client_secret;
            $settings->save();
            return redirect()->away('https://oauth.yandex.ru/authorize?response_type=code&client_id=' . $yandex_services_auth_client_id);
        }
    }

}
