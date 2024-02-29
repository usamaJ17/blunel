<?php

namespace App\Enums\ViewPaths\Admin;

enum DeliverymanWithdraw
{

    const LIST = [
        URI => 'withdraw-list',
        VIEW => 'admin-views.delivery-man.withdraw.withdraw_list'
    ];

    const EXPORT_LIST = [
        URI => 'withdraw-list-export',
        VIEW => ''
    ];

    const VIEW = [
        URI => 'withdraw-view',
        VIEW => 'admin-views.delivery-man.withdraw.withdraw-view'
    ];

    const UPDATE = [
        URI => 'withdraw-status',
        VIEW => ''
    ];

}
