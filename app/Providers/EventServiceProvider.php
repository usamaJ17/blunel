<?php

namespace App\Providers;

use App\Events\AddFundToWalletEvent;
use App\Events\DeliverymanPasswordResetEvent;
use App\Events\DigitalProductOtpVerificationMailEvent;
use App\Events\EmailVerificationEvent;
use App\Events\OrderPlacedEvent;
use App\Events\PasswordResetMailEvent;
use App\Events\ChattingEvent;
use App\Events\OrderStatusEvent;
use App\Events\RefundEvent;
use App\Listeners\AddFundToWalletListener;
use App\Listeners\DeliverymanPasswordResetListener;
use App\Listeners\DigitalProductOtpVerificationMailListener;
use App\Listeners\EmailVerificationListener;
use App\Listeners\OrderPlacedListener;
use App\Listeners\PasswordResetMailListener;
use App\Listeners\ChattingListener;
use App\Listeners\OrderStatusListener;
use App\Listeners\RefundListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        AddFundToWalletEvent::class => [
            AddFundToWalletListener::class,
        ],
        DigitalProductOtpVerificationMailEvent::class => [
            DigitalProductOtpVerificationMailListener::class,
        ],
        DeliverymanPasswordResetEvent::class => [
            DeliverymanPasswordResetListener::class,
        ],
        EmailVerificationEvent::class => [
            EmailVerificationListener::class,
        ],
        PasswordResetMailEvent::class => [
            PasswordResetMailListener::class,
        ],
        OrderPlacedEvent::class => [
            OrderPlacedListener::class,
        ],
        OrderStatusEvent::class => [
            OrderStatusListener::class,
        ],
        ChattingEvent::class => [
            ChattingListener::class,
        ],
        RefundEvent::class => [
            RefundListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
