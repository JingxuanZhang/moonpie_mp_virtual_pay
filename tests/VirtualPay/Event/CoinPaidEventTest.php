<?php

namespace Moonpie\EasyWechat\VirtualPay\Tests\Event;

use PHPUnit\Framework\TestCase;
use Moonpie\EasyWechat\VirtualPay\Event\CoinPaidEvent;

class CoinPaidEventTest extends TestCase
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
            'Event' => 'xpay_coin_pay_notify',
            'AppId' => 'wx1234567890abcdef',
            'OpenId' => 'o1234567890abcdef1234567890',
            'OrderId' => 'order_1234567890',
            'Amount' => 100,
            'Env' => 1
        ];

        $event = new CoinPaidEvent($message);

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
            'Event' => 'xpay_coin_pay_notify',
            'AppId' => 'wx1234567890abcdef',
            'OpenId' => 'o1234567890abcdef1234567890',
            'OrderId' => 'order_1234567890',
            'Amount' => 100,
            'Env' => 1
        ];

        $event = new CoinPaidEvent($message);

        $this->assertEquals('gh_1234567890ab', $event->getToUserName());
        $this->assertEquals('o1234567890abcdef1234567890', $event->getFromUserName());
        $this->assertEquals(1609459200, $event->getCreateTime());
        $this->assertEquals('event', $event->getMsgType());
        $this->assertEquals('xpay_coin_pay_notify', $event->getEvent());
        $this->assertEquals('wx1234567890abcdef', $event->getAppId());
        $this->assertEquals('o1234567890abcdef1234567890', $event->getOpenId());
        $this->assertEquals('order_1234567890', $event->getOrderId());
        $this->assertEquals(100, $event->getAmount());
        $this->assertEquals(1, $event->getEnv());
    }

    /**
     * Test getter methods with missing fields return default values.
     */
    public function testGetterMethodsReturnDefaultValuesForMissingFields()
    {
        $message = []; // Empty message

        $event = new CoinPaidEvent($message);

        $this->assertEquals('', $event->getToUserName());
        $this->assertEquals('', $event->getFromUserName());
        $this->assertEquals(0, $event->getCreateTime());
        $this->assertEquals('', $event->getMsgType());
        $this->assertEquals('', $event->getEvent());
        $this->assertEquals('', $event->getAppId());
        $this->assertEquals('', $event->getOpenId());
        $this->assertEquals('', $event->getOrderId());
        $this->assertEquals(0, $event->getAmount());
        $this->assertEquals(0, $event->getEnv());
    }

    /**
     * Test Arr::get() default value behavior for string fields.
     */
    public function testArrGetDefaultBehaviorForStringFields()
    {
        $message = [
            'OrderId' => 'valid_order_id'
        ];

        $event = new CoinPaidEvent($message);

        // Missing fields should return default empty string
        $this->assertEquals('', $event->getToUserName());
        $this->assertEquals('', $event->getFromUserName());
        $this->assertEquals('', $event->getAppId());
        $this->assertEquals('', $event->getOpenId());
        
        // Valid field should return its value
        $this->assertEquals('valid_order_id', $event->getOrderId());
    }

    /**
     * Test Arr::get() default value behavior for integer fields.
     */
    public function testArrGetDefaultBehaviorForIntegerFields()
    {
        $message = [
            'CreateTime' => null,
            'Amount' => false,
            'Env' => 'not_a_number'
        ];

        $event = new CoinPaidEvent($message);

        // Invalid values should be cast to 0
        $this->assertEquals(0, $event->getCreateTime());
        $this->assertEquals(0, $event->getAmount());
        $this->assertEquals(0, $event->getEnv());
    }
}