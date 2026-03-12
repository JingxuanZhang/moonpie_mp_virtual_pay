<?php

namespace Moonpie\EasyWechat\VirtualPay\Event;

use EasyWeChat\Kernel\Contracts\MessageInterface;
use EasyWeChat\Kernel\Messages\Raw;
use Symfony\Component\EventDispatcher\GenericEvent;
use EasyWeChat\Kernel\Support\Arr;

/**
 * Common Logic for all virutal event
 */
class CommonEvent extends GenericEvent
{
    protected $errorCode = 0;
    protected $errorMsg = 'success';
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
     * Get the OpenId.
     *
     * @return string
     */
    public function getOpenId(): string
    {
        return Arr::get($this->subject, 'OpenId', '');
    }

    public function getResponse(): array
    {
        return ['ErrCode' => $this->errorCode, 'ErrMsg' => $this->errorMsg];
    }
    public function markOk()
    {
        $this->errorCode = 0;
        $this->errorMsg = 'success';
        return $this;
    }
    public function markFail($message, $code = 1)
    {
        if ($code == 0) {
            $code = -10000;
        }
        $this->errorCode = $code;
        $this->errorMsg = $message;
        return $this;
    }
}
