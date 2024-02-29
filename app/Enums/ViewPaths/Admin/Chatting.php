<?php

namespace App\Enums\ViewPaths\Admin;

enum Chatting
{

    const VIEW = [
        URI => 'chat',
        VIEW => 'admin-views.delivery-man.chat'
    ];

    const MESSAGE = [
        URI => 'ajax-message-by-delivery-man',
        VIEW => ''
    ];

    const ADD = [
        URI => 'admin-message-store',
        VIEW => ''
    ];


}
