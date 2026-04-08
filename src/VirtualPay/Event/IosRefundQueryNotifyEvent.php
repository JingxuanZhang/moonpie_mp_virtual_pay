<?php

namespace Moonpie\EasyWechat\VirtualPay\Event;

use EasyWeChat\Kernel\Support\Arr;

/**
 * iOS Refund Query Notify Event for Virtual Pay.
 *
 * Triggered when Apple sends a refund inquiry to the developer.
 * The developer must respond within 3 seconds with a refund decision.
 */
class IosRefundQueryNotifyEvent extends CommonEvent
{
    protected $resultCode = 0;
    protected $resultInfo = '';
    protected $evidence = '';

    /**
     * Get the refund inquiry time (Unix timestamp).
     *
     * @return string
     */
    public function getRefundTime(): string
    {
        return Arr::get($this->subject, 'refund_time', '');
    }

    /**
     * Get the original order time for this refund (Unix timestamp).
     *
     * @return string
     */
    public function getOrderTime(): string
    {
        return Arr::get($this->subject, 'order_time', '');
    }

    /**
     * Get the Apple payment receipt number.
     *
     * @return string
     */
    public function getChannelBill(): string
    {
        return Arr::get($this->subject, 'channel_bill', '');
    }

    /**
     * Get the Apple bundle ID.
     *
     * @return string
     */
    public function getBundleId(): string
    {
        return Arr::get($this->subject, 'bundleid', '');
    }

    /**
     * Get the product (item) ID.
     *
     * @return string
     */
    public function getProductId(): string
    {
        return Arr::get($this->subject, 'product_id', '');
    }

    /**
     * Get the item/token quantity.
     *
     * @return string
     */
    public function getPCount(): string
    {
        return Arr::get($this->subject, 'p_count', '');
    }

    /**
     * Get the user's refund request reason.
     *
     * @return string
     */
    public function getRefundRequestReason(): string
    {
        return Arr::get($this->subject, 'refund_request_reason', '');
    }

    /**
     * Get the delivery status.
     *
     * 0: not delivered, 1: delivered, 2: delivering
     *
     * @return int
     */
    public function getProvideStatus(): int
    {
        return (int) Arr::get($this->subject, 'provide_status', 0);
    }

    /**
     * Get the payment order ID associated with the refund.
     *
     * @return string
     */
    public function getPayOrderId(): string
    {
        return Arr::get($this->subject, 'pay_order_id', '');
    }

    /**
     * Approve the refund (suggest refund to Apple).
     *
     * @param string $evidence The reason/evidence for approving the refund (required)
     * @param string $resultInfo Additional description
     * @return $this
     */
    public function approveRefund(string $evidence, string $resultInfo = ''): self
    {
        $this->resultCode = 0;
        $this->resultInfo = $resultInfo;
        $this->evidence = $evidence;
        return $this;
    }

    /**
     * Reject the refund (refuse refund to Apple).
     *
     * @param string $evidence The reason/evidence for rejecting the refund (required)
     * @param string $resultInfo Additional description
     * @return $this
     */
    public function rejectRefund(string $evidence, string $resultInfo = ''): self
    {
        $this->resultCode = 1;
        $this->resultInfo = $resultInfo;
        $this->evidence = $evidence;
        return $this;
    }

    /**
     * Get the iOS refund query response.
     *
     * @return array
     */
    public function getResponse(): array
    {
        return [
            'result_code' => $this->resultCode,
            'result_info' => $this->resultInfo,
            'evidence' => $this->evidence,
        ];
    }
}
