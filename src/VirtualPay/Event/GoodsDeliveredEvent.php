<?php

namespace Moonpie\EasyWechat\VirtualPay\Event;

use EasyWeChat\Kernel\Support\Arr;

/**
 * Goods Delivered Event for Virtual Pay.
 *
 * Triggered when goods are delivered to the user.
 */
class GoodsDeliveredEvent extends CommonEvent
{
    /**
     * Get OutTradeNo
     * @return string
     */
    public function getOutTradeNo(): string
    {
        return Arr::get($this->subject, 'OutTradeNo', '');
    }


    /**
     * Get the GoodsInfo.
     *
     * @return array
     */
    public function getGoodsInfo(): array
    {
        return Arr::get($this->subject, 'GoodsInfo', []);
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
    /**
     * Get the TeamInfo.
     *
     * @return array
     */
    public function getTeamInfo(): array
    {
        return Arr::get($this->subject, 'TeamInfo', []);
    }
    /**
     * Get the WechatPayInfo.
     *
     * @return array
     */
    public function getWeChatPayInfo(): array
    {
        return Arr::get($this->subject, 'WeChatPayInfo', []);
    }
}

