<?php

namespace Moonpie\EasyWechat\VirtualPay\Event;

use EasyWeChat\Kernel\Support\Arr;

/**
 * Refund Processed Event for Virtual Pay.
 *
 * Triggered when refund is processed.
 */
class RefundProcessedEvent extends CommonEvent
{
    /**
     * Get the AppId.
     *
     * @return string
     */
    public function getAppId(): string
    {
        return Arr::get($this->subject, 'AppId', '');
    }

    /**
     * Get the OrderId.
     *
     * @return string
     */
    public function getOrderId(): string
    {
        return Arr::get($this->subject, 'OrderId', '');
    }

    /**
     * Get the Amount.
     *
     * @return int
     */
    public function getAmount(): int
    {
        return (int) Arr::get($this->subject, 'Amount', 0);
    }

    /**
     * Get the Env.
     *
     * @return int
     */
    public function getEnv(): int
    {
        return (int) Arr::get($this->subject, 'Env', 0);
    }
}
