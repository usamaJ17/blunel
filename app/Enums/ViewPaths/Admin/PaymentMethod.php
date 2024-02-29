<?php

namespace App\Enums\ViewPaths\Admin;

enum PaymentMethod
{
    const LIST = [
        URI => '/',
        VIEW => 'admin-views.business-settings.payment-method.index'
    ];

    const UPDATE = [
        URI => '/',
        VIEW => ''
    ];

    const UPDATE_CONFIG = [
        URI => 'addon-payment-set',
        VIEW => ''
    ];
}
