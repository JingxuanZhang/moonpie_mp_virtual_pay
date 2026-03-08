<?php

namespace Moonpie\EasyWechat\VirtualPay\Server\Handlers;

use EasyWeChat\Kernel\Contracts\EventHandlerInterface;
use EasyWeChat\Kernel\Exceptions\BadRequestException;
use EasyWeChat\Kernel\Support\Arr;
use Moonpie\EasyWechat\VirtualPay\Event\ComplaintFiledEvent;
use Moonpie\EasyWechat\VirtualPay\Event\CoinPaidEvent;
use Moonpie\EasyWechat\VirtualPay\Event\GoodsDeliveredEvent;
use Moonpie\EasyWechat\VirtualPay\Event\RefundProcessedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Virtual Pay Event Handler.
 *
 * Handles all virtual pay notification events from WeChat.
 */
class VirtualPayEventHandler implements EventHandlerInterface
{
    /**
     * The event dispatcher instance.
     *
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * Create a new VirtualPayEventHandler instance.
     *
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Handle the virtual pay event.
     *
     * @param mixed $payload
     * @return array
     */
    public function handle($payload = null)
    {
        // Parse the message if it's a string (XML/JSON)
        if (is_string($payload)) {
            $message = json_decode($payload, true) ?: [];
        } elseif (is_array($payload)) {
            $message = $payload;
        } else {
            throw new BadRequestException('Invalid message format');
        }

        if (!is_array($message)) {
            throw new BadRequestException('Invalid message format');
        }

        // Get the event type
        $eventType = Arr::get($message, 'Event', '');

        // Dispatch to appropriate handler based on event type
        switch ($eventType) {
            case 'xpay_goods_deliver_notify':
                $event = $this->handleGoodsDelivered($message);
                break;
            case 'xpay_coin_pay_notify':
                $event = $this->handleCoinPaid($message);
                break;
            case 'xpay_refund_notify':
                $event = $this->handleRefundProcessed($message);
                break;
            case 'xpay_complaint_notify':
                $event = $this->handleComplaintFiled($message);
                break;
            default:
                // Unknown event type, return success to avoid retries
                return ['ErrCode' => 0, 'ErrMsg' => 'success'];
        }

        // Dispatch the event
        if (isset($event)) {
            $this->eventDispatcher->dispatch($event, get_class($event));
        }

        // Return success response as required by WeChat
        return ['ErrCode' => 0, 'ErrMsg' => 'success'];
    }

    /**
     * Handle goods delivered event.
     *
     * @param array $message
     * @return GoodsDeliveredEvent
     */
    protected function handleGoodsDelivered(array $message): GoodsDeliveredEvent
    {
        return new GoodsDeliveredEvent($message);
    }

    /**
     * Handle coin paid event.
     *
     * @param array $message
     * @return CoinPaidEvent
     */
    protected function handleCoinPaid(array $message): CoinPaidEvent
    {
        return new CoinPaidEvent($message);
    }

    /**
     * Handle refund processed event.
     *
     * @param array $message
     * @return RefundProcessedEvent
     */
    protected function handleRefundProcessed(array $message): RefundProcessedEvent
    {
        return new RefundProcessedEvent($message);
    }

    /**
     * Handle complaint filed event.
     *
     * @param array $message
     * @return ComplaintFiledEvent
     */
    protected function handleComplaintFiled(array $message): ComplaintFiledEvent
    {
        return new ComplaintFiledEvent($message);
    }
}

