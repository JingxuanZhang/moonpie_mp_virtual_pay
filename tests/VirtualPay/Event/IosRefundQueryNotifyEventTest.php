<?php

namespace Moonpie\EasyWechat\VirtualPay\Tests\Event;

use PHPUnit\Framework\TestCase;
use Moonpie\EasyWechat\VirtualPay\Event\IosRefundQueryNotifyEvent;

class IosRefundQueryNotifyEventTest extends TestCase
{
    private function createSampleMessage(): array
    {
        return [
            'ToUserName' => 'gh_1234567890ab',
            'FromUserName' => 'o1234567890abcdef1234567890',
            'CreateTime' => 1609459200,
            'MsgType' => 'event',
            'Event' => 'xpay_subscribe_ios_refund_query_notify',
            'refund_time' => '1609459300',
            'order_time' => '1609459100',
            'channel_bill' => 'APPLE_RECEIPT_001',
            'bundleid' => 'com.example.app',
            'product_id' => 'coin_100',
            'p_count' => '100',
            'refund_request_reason' => 'USER_REQUESTED',
            'provide_status' => '1',
            'pay_order_id' => 'order_1234567890',
        ];
    }

    public function testGetterMethodsReturnCorrectValues()
    {
        $event = new IosRefundQueryNotifyEvent($this->createSampleMessage());

        $this->assertEquals('1609459300', $event->getRefundTime());
        $this->assertEquals('1609459100', $event->getOrderTime());
        $this->assertEquals('APPLE_RECEIPT_001', $event->getChannelBill());
        $this->assertEquals('com.example.app', $event->getBundleId());
        $this->assertEquals('coin_100', $event->getProductId());
        $this->assertEquals('100', $event->getPCount());
        $this->assertEquals('USER_REQUESTED', $event->getRefundRequestReason());
        $this->assertEquals(1, $event->getProvideStatus());
        $this->assertEquals('order_1234567890', $event->getPayOrderId());
    }

    public function testGetterMethodsReturnDefaultValuesForMissingFields()
    {
        $event = new IosRefundQueryNotifyEvent([]);

        $this->assertEquals('', $event->getRefundTime());
        $this->assertEquals('', $event->getOrderTime());
        $this->assertEquals('', $event->getChannelBill());
        $this->assertEquals('', $event->getBundleId());
        $this->assertEquals('', $event->getProductId());
        $this->assertEquals('', $event->getPCount());
        $this->assertEquals('', $event->getRefundRequestReason());
        $this->assertEquals(0, $event->getProvideStatus());
        $this->assertEquals('', $event->getPayOrderId());
    }

    public function testApproveRefundSetsCorrectResponse()
    {
        $event = new IosRefundQueryNotifyEvent($this->createSampleMessage());
        $event->approveRefund('User has consumed the items', 'Approved by policy');

        $response = $event->getResponse();
        $this->assertEquals(['result_code' => 0, 'result_info' => 'Approved by policy', 'evidence' => 'User has consumed the items'], $response);
    }

    public function testRejectRefundSetsCorrectResponse()
    {
        $event = new IosRefundQueryNotifyEvent($this->createSampleMessage());
        $event->rejectRefund('Items already used, cannot refund', 'Rejected');

        $response = $event->getResponse();
        $this->assertEquals(['result_code' => 1, 'result_info' => 'Rejected', 'evidence' => 'Items already used, cannot refund'], $response);
    }

    public function testDefaultResponseIsEmpty()
    {
        $event = new IosRefundQueryNotifyEvent($this->createSampleMessage());

        $response = $event->getResponse();
        $this->assertEquals(['result_code' => 0, 'result_info' => '', 'evidence' => ''], $response);
    }

    public function testApproveRefundWithoutResultInfo()
    {
        $event = new IosRefundQueryNotifyEvent($this->createSampleMessage());
        $event->approveRefund('User requested refund');

        $response = $event->getResponse();
        $this->assertEquals(0, $response['result_code']);
        $this->assertEquals('', $response['result_info']);
        $this->assertEquals('User requested refund', $response['evidence']);
    }

    public function testInheritsCommonEventMethods()
    {
        $event = new IosRefundQueryNotifyEvent($this->createSampleMessage());

        $this->assertEquals('gh_1234567890ab', $event->getToUserName());
        $this->assertEquals('o1234567890abcdef1234567890', $event->getFromUserName());
        $this->assertEquals(1609459200, $event->getCreateTime());
        $this->assertEquals('event', $event->getMsgType());
        $this->assertEquals('xpay_subscribe_ios_refund_query_notify', $event->getEvent());
    }

    public function testApproveAndRejectOverrideEachOther()
    {
        $event = new IosRefundQueryNotifyEvent($this->createSampleMessage());

        $event->rejectRefund('Evidence A', 'Info A');
        $this->assertEquals(1, $event->getResponse()['result_code']);

        $event->approveRefund('Evidence B', 'Info B');
        $this->assertEquals(0, $event->getResponse()['result_code']);
        $this->assertEquals('Evidence B', $event->getResponse()['evidence']);
    }
}
