@php
    use App\Enums\ViewPaths\Admin\BusinessSettings;
    use App\Enums\ViewPaths\Admin\Currency;
    use App\Enums\ViewPaths\Admin\DatabaseSetting;
    use App\Enums\ViewPaths\Admin\EnvironmentSettings;
    use App\Enums\ViewPaths\Admin\SiteMap;
    use App\Enums\ViewPaths\Admin\SoftwareUpdate;
    use App\Enums\ViewPaths\Admin\ThemeSetup;
@endphp
<div class="inline-page-menu my-4">
    <ul class="list-unstyled">
        <li class="{{ Request::is('admin/business-settings/web-config/'.EnvironmentSettings::VIEW[URI]) ?'active':'' }}">
            <a href="{{route('admin.business-settings.web-config.environment-setup')}}">{{translate('Environment_Setup')}}</a>
        </li>

        <li class="{{ Request::is('admin/business-settings/web-config/'.BusinessSettings::APP_SETTINGS[URI]) ?'active':'' }}">
            <a href="{{route('admin.business-settings.web-config.app-settings')}}">{{translate('app_Settings')}}</a>
        </li>

        <li class="{{ Request::is('admin/business-settings/'.BusinessSettings::COOKIE_SETTINGS[URI]) ? 'active':'' }}">
            <a href="{{ route('admin.business-settings.cookie-settings') }}">{{translate('cookies')}}</a>
        </li>

        <li class="{{ Request::is('admin/business-settings/'.BusinessSettings::OTP_SETUP[URI]) ? 'active':'' }}">
            <a href="{{ route('admin.business-settings.otp-setup') }}">{{translate('OTP_&_Login')}}</a>
        </li>

        <li class="{{ Request::is('admin/business-settings/language') ?'active':'' }}">
            <a href="{{route('admin.business-settings.language.index')}}">{{translate('language')}}</a>
        </li>

        <li class="{{ Request::is('admin/currency/'.Currency::LIST[URI]) ?'active':'' }}">
            <a href="{{route('admin.currency.view')}}">{{translate('Currency')}}</a>
        </li>

        <li class="{{ Request::is('admin/system-settings/'.SoftwareUpdate::VIEW[URI]) ?'active':'' }}">
            <a href="{{route('admin.system-settings.software-update')}}">{{translate('software_Update')}}</a>
        </li>

        <li class="{{ Request::is('admin/business-settings/web-config/'.SiteMap::VIEW[URI]) ?'active':'' }}">
            <a href="{{route('admin.business-settings.web-config.mysitemap')}}">{{translate('Generate_Site_Map')}}</a>
        </li>

        <li class="{{ Request::is('admin/business-settings/'.BusinessSettings::ANALYTICS_INDEX[URI]) ?'active':'' }}">
            <a href="{{route('admin.business-settings.analytics-index')}}">{{translate('Analytic_Script')}}</a>
        </li>

        <li class="{{ Request::is('admin/business-settings/web-config/'.BusinessSettings::LOGIN_URL_SETUP[URI]) ?'active':'' }}">
            <a href="{{route('admin.business-settings.web-config.login-url-setup')}}">{{translate('login_Url_Setup')}}</a>
        </li>

        <li class="{{ Request::is('admin/business-settings/web-config/theme/'.ThemeSetup::VIEW[URI]) ?'active':'' }}">
            <a href="{{route('admin.business-settings.web-config.theme.setup')}}">{{translate('theme_Setup')}}</a>
        </li>

        <li class="{{ Request::is('admin/business-settings/web-config/'.DatabaseSetting::VIEW[URI]) ?'active':'' }}">
            <a href="{{route('admin.business-settings.web-config.db-index')}}">{{translate('Clean_Database')}}</a>
        </li>

        <li class="{{ Request::is('admin/addon') ?'active':'' }}">
            <a href="{{route('admin.addon.index')}}">{{translate('system_Addons')}}</a>
        </li>

    </ul>
</div>
