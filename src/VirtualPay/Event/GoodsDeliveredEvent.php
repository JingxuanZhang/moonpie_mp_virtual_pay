<?php

namespace Moonpie\EasyWechat\VirtualPay\Event;

use Symfony\Component\EventDispatcher\GenericEvent;
use EasyWeChat\Kernel\Support\Arr;

/**
 * Goods Delivered Event for Virtual Pay.
 *
 * Triggered when goods are delivered to the user.
 */
class GoodsDeliveredEvent extends GenericEvent
{
    /**
     * Create a new GoodsDeliveredEvent instance.
     *
     * @param array $message The raw message data from WeChat
     */
    public function __construct(array $message)
    {
        parent::__construct($message);
    }

    /**
     * Get the ToUserName (mini program original ID).
     *
     * @return string
     */
    public function getToUserName(): string
    {
        return Arr::get($this->subject, 'ToUserName', '');
    }

    /**
     * Get the FromUserName (WeChat official openid).
     *
     * @return string
     */
    public function getFromUserName(): string
    {
        return Arr::get($this->subject, 'FromUserName', '');
    }

    /**
     * Get the CreateTime (message creation timestamp).
     *
     * @return int
     */
    public function getCreateTime(): int
    {
        return (int) Arr::get($this->subject, 'CreateTime', 0);
    }

    /**
     * Get the MsgType.
     *
     * @return string
     */
    public function getMsgType(): string
    {
        return Arr::get($this->subject, 'MsgType', '');
    }

    /**
     * Get the Event type.
     *
     * @return string
     */
    public function getEvent(): string
    {
        return Arr::get($this->subject, 'Event', '');
    }

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
     * Get the OpenId.
     *
     * @return string
     */
    public function getOpenId(): string
    {
        return Arr::get($this->subject, 'OpenId', '');
    }

    /**
     * Get the DeliverOrderId.
     *
     * @return string
     */
    public function getDeliverOrderId(): string
    {
        return Arr::get($this->subject, 'DeliverOrderId', '');
    }

    /**
     * Get the BizOrderId.
     *
     * @return string
     */
    public function getBizOrderId(): string
    {
        return Arr::get($this->subject, 'BizOrderId', '');
    }

    /**
     * Get the GoodsId.
     *
     * @return string
     */
    public function getGoodsId(): string
    {
        return Arr::get($this->subject, 'GoodsId', '');
    }

    /**
     * Get the GoodsInfo.
     *
     * @return string
     */
    public function getGoodsInfo(): string
    {
        return Arr::get($this->subject, 'GoodsInfo', '');
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