<?php

namespace Moonpie\EasyWechat\VirtualPay\Tests\Event;

use PHPUnit\Framework\TestCase;
use Moonpie\EasyWechat\VirtualPay\Event\GoodsDeliveredEvent;

class GoodsDeliveredEventTest extends TestCase
{
    /**
     * Test constructor properly stores message data.
     */
    public function testConstructorStoresMessageData()
    {
        $message = [
            'ToUserName' => 'gh_1234567890ab',
            'FromUserName' => 'o1234567890abcdef1234567890',
            'CreateTime' => 1609459200,
            'MsgType' => 'event',
            'Event' => 'xpay_goods_deliver_notify',
            'AppId' => 'wx1234567890abcdef',
            'OpenId' => 'o1234567890abcdef1234567890',
            'DeliverOrderId' => 'deliver_1234567890',
            'BizOrderId' => 'biz_1234567890',
            'GoodsId' => 'goods_1234567890',
            'GoodsInfo' => 'Sample goods information',
            'Env' => 1
        ];

        $event = new GoodsDeliveredEvent($message);

        // Verify that the subject contains the original message
        $this->assertEquals($message, $event->getSubject());
    }

    /**
     * Test getter methods return correct values from message data.
     */
    public function testGetterMethodsReturnCorrectValues()
    {
        $message = [
            'ToUserName' => 'gh_1234567890ab',
            'FromUserName' => 'o1234567890abcdef1234567890',
            'CreateTime' => 1609459200,
            'MsgType' => 'event',
            'Event' => 'xpay_goods_deliver_notify',
            'AppId' => 'wx1234567890abcdef',
            'OpenId' => 'o1234567890abcdef1234567890',
            'DeliverOrderId' => 'deliver_1234567890',
            'BizOrderId' => 'biz_1234567890',
            'GoodsId' => 'goods_1234567890',
            'GoodsInfo' => 'Sample goods information',
            'Env' => 1
        ];

        $event = new GoodsDeliveredEvent($message);

        $this->assertEquals('gh_1234567890ab', $event->getToUserName());
        $this->assertEquals('o1234567890abcdef1234567890', $event->getFromUserName());
        $this->assertEquals(1609459200, $event->getCreateTime());
        $this->assertEquals('event', $event->getMsgType());
        $this->assertEquals('xpay_goods_deliver_notify', $event->getEvent());
        $this->assertEquals('wx1234567890abcdef', $event->getAppId());
        $this->assertEquals('o1234567890abcdef1234567890', $event->getOpenId());
        $this->assertEquals('deliver_1234567890', $event->getDeliverOrderId());
        $this->assertEquals('biz_1234567890', $event->getBizOrderId());
        $this->assertEquals('goods_1234567890', $event->getGoodsId());
        $this->assertEquals('Sample goods information', $event->getGoodsInfo());
        $this->assertEquals(1, $event->getEnv());
    }

    /**
     * Test getter methods with missing fields return default values.
     */
    public function testGetterMethodsReturnDefaultValuesForMissingFields()
    {
        $message = []; // Empty message

        $event = new GoodsDeliveredEvent($message);

        $this->assertEquals('', $event->getToUserName());
        $this->assertEquals('', $event->getFromUserName());
        $this->assertEquals(0, $event->getCreateTime());
        $this->assertEquals('', $event->getMsgType());
        $this->assertEquals('', $event->getEvent());
        $this->assertEquals('', $event->getAppId());
        $this->assertEquals('', $event->getOpenId());
        $this->assertEquals('', $event->getDeliverOrderId());
        $this->assertEquals('', $event->getBizOrderId());
        $this->assertEquals('', $event->getGoodsId());
        $this->assertEquals('', $event->getGoodsInfo());
        $this->assertEquals(0, $event->getEnv());
    }

    /**
     * Test Arr::get() default value behavior for string fields.
     */
    public function testArrGetDefaultBehaviorForStringFields()
    {
        $message = [
            'DeliverOrderId' => 'valid_id',
            'BizOrderId' => 'valid_biz_id',
            'GoodsId' => 'valid_goods_id',
            'GoodsInfo' => 'valid_info'
        ];

        $event = new GoodsDeliveredEvent($message);

        // Missing fields should return default empty string
        $this->assertEquals('', $event->getToUserName());
        $this->assertEquals('', $event->getFromUserName());
        $this->assertEquals('', $event->getAppId());
        $this->assertEquals('', $event->getOpenId());
        
        // Valid fields should return their values
        $this->assertEquals('valid_id', $event->getDeliverOrderId());
        $this->assertEquals('valid_biz_id', $event->getBizOrderId());
        $this->assertEquals('valid_goods_id', $event->getGoodsId());
        $this->assertEquals('valid_info', $event->getGoodsInfo());
    }

    /**
     * Test Arr::get() default value behavior for integer fields.
     */
    public function testArrGetDefaultBehaviorForIntegerFields()
    {
        $message = [
            'CreateTime' => null,
            'Env' => false,
            'SomeInvalidInt' => 'not_a_number'
        ];

        $event = new GoodsDeliveredEvent($message);

        // Invalid values should be cast to 0
        $this->assertEquals(0, $event->getCreateTime());
        $this->assertEquals(0, $event->getEnv());
    }
}