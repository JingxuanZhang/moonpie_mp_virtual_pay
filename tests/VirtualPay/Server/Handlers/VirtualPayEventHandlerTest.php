<?php

namespace Moonpie\EasyWechat\VirtualPay\Tests\Server\Handlers;

use PHPUnit\Framework\TestCase;
use Moonpie\EasyWechat\VirtualPay\Server\Handlers\VirtualPayEventHandler;
use Moonpie\EasyWechat\VirtualPay\Event\GoodsDeliveredEvent;
use Moonpie\EasyWechat\VirtualPay\Event\CoinPaidEvent;
use Moonpie\EasyWechat\VirtualPay\Event\RefundProcessedEvent;
use Moonpie\EasyWechat\VirtualPay\Event\ComplaintFiledEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use EasyWeChat\Kernel\Exceptions\BadRequestException;

class VirtualPayEventHandlerTest extends TestCase
{
    /**
     * @var EventDispatcherInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $mockEventDispatcher;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create mock event dispatcher
        $this->mockEventDispatcher = $this->createMock(EventDispatcherInterface::class);
    }

    /**
     * Test handler can identify goods delivered event type.
     */
    public function testIdentifiesGoodsDeliveredEventType()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher);
        $message = [
            'Event' => 'xpay_goods_deliver_notify',
            'ToUserName' => 'gh_1234567890ab'
        ];

        // Expect the event dispatcher to be called with GoodsDeliveredEvent
        $this->mockEventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                $this->isInstanceOf(GoodsDeliveredEvent::class),
                $this->equalTo(GoodsDeliveredEvent::class)
            );

        $result = $handler->handle($message);
        
        $this->assertEquals(['ErrCode' => 0, 'ErrMsg' => 'success'], $result);
    }

    /**
     * Test handler can identify coin paid event type.
     */
    public function testIdentifiesCoinPaidEventType()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher);
        $message = [
            'Event' => 'xpay_coin_pay_notify',
            'ToUserName' => 'gh_1234567890ab'
        ];

        // Expect the event dispatcher to be called with CoinPaidEvent
        $this->mockEventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                $this->isInstanceOf(CoinPaidEvent::class),
                $this->equalTo(CoinPaidEvent::class)
            );

        $result = $handler->handle($message);
        
        $this->assertEquals(['ErrCode' => 0, 'ErrMsg' => 'success'], $result);
    }

    /**
     * Test handler can identify refund processed event type.
     */
    public function testIdentifiesRefundProcessedEventType()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher);
        $message = [
            'Event' => 'xpay_refund_notify',
            'ToUserName' => 'gh_1234567890ab'
        ];

        // Expect the event dispatcher to be called with RefundProcessedEvent
        $this->mockEventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                $this->isInstanceOf(RefundProcessedEvent::class),
                $this->equalTo(RefundProcessedEvent::class)
            );

        $result = $handler->handle($message);
        
        $this->assertEquals(['ErrCode' => 0, 'ErrMsg' => 'success'], $result);
    }

    /**
     * Test handler can identify complaint filed event type.
     */
    public function testIdentifiesComplaintFiledEventType()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher);
        $message = [
            'Event' => 'xpay_complaint_notify',
            'ToUserName' => 'gh_1234567890ab'
        ];

        // Expect the event dispatcher to be called with ComplaintFiledEvent
        $this->mockEventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                $this->isInstanceOf(ComplaintFiledEvent::class),
                $this->equalTo(ComplaintFiledEvent::class)
            );

        $result = $handler->handle($message);
        
        $this->assertEquals(['ErrCode' => 0, 'ErrMsg' => 'success'], $result);
    }

    /**
     * Test each event type creates correct Event object.
     */
    public function testCreatesCorrectEventObjects()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher);
        
        // Test GoodsDeliveredEvent
        $goodsMessage = ['Event' => 'xpay_goods_deliver_notify', 'TestField' => 'test_value'];
        $this->mockEventDispatcher
            ->expects($this->at(0))
            ->method('dispatch')
            ->with($this->callback(function ($event) {
                return $event instanceof GoodsDeliveredEvent && 
                       $event->getSubject()['TestField'] === 'test_value';
            }));
        
        $handler->handle($goodsMessage);
        
        // Reset mock for next test
        $this->mockEventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher);
        
        // Test CoinPaidEvent
        $coinMessage = ['Event' => 'xpay_coin_pay_notify', 'TestField' => 'test_value'];
        $this->mockEventDispatcher
            ->expects($this->at(0))
            ->method('dispatch')
            ->with($this->callback(function ($event) {
                return $event instanceof CoinPaidEvent && 
                       $event->getSubject()['TestField'] === 'test_value';
            }));
        
        $handler->handle($coinMessage);
        
        // Reset mock for next test
        $this->mockEventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher);
        
        // Test RefundProcessedEvent
        $refundMessage = ['Event' => 'xpay_refund_notify', 'TestField' => 'test_value'];
        $this->mockEventDispatcher
            ->expects($this->at(0))
            ->method('dispatch')
            ->with($this->callback(function ($event) {
                return $event instanceof RefundProcessedEvent && 
                       $event->getSubject()['TestField'] === 'test_value';
            }));
        
        $handler->handle($refundMessage);
        
        // Reset mock for next test
        $this->mockEventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher);
        
        // Test ComplaintFiledEvent
        $complaintMessage = ['Event' => 'xpay_complaint_notify', 'TestField' => 'test_value'];
        $this->mockEventDispatcher
            ->expects($this->at(0))
            ->method('dispatch')
            ->with($this->callback(function ($event) {
                return $event instanceof ComplaintFiledEvent && 
                       $event->getSubject()['TestField'] === 'test_value';
            }));
        
        $handler->handle($complaintMessage);
    }

    /**
     * Test returns correct WeChat response format.
     */
    public function testReturnsCorrectWeChatResponseFormat()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher);
        $message = ['Event' => 'xpay_goods_deliver_notify'];

        $result = $handler->handle($message);
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('ErrCode', $result);
        $this->assertArrayHasKey('ErrMsg', $result);
        $this->assertEquals(0, $result['ErrCode']);
        $this->assertEquals('success', $result['ErrMsg']);
    }

    /**
     * Test correctly triggers event_dispatcher events.
     */
    public function testTriggersEventDispatcherEvents()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher);
        $message = ['Event' => 'xpay_goods_deliver_notify'];

        // Verify dispatch is called exactly once
        $this->mockEventDispatcher
            ->expects($this->once())
            ->method('dispatch');

        $handler->handle($message);
    }

    /**
     * Test handles unknown event types gracefully.
     */
    public function testHandlesUnknownEventTypes()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher);
        $message = ['Event' => 'unknown_event_type'];

        // Should not call dispatch for unknown events
        $this->mockEventDispatcher
            ->expects($this->never())
            ->method('dispatch');

        $result = $handler->handle($message);
        
        $this->assertEquals(['ErrCode' => 0, 'ErrMsg' => 'success'], $result);
    }

    /**
     * Test handles JSON string payload.
     */
    public function testHandlesJsonStringPayload()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher);
        $jsonMessage = json_encode(['Event' => 'xpay_goods_deliver_notify']);

        $this->mockEventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(GoodsDeliveredEvent::class));

        $result = $handler->handle($jsonMessage);
        
        $this->assertEquals(['ErrCode' => 0, 'ErrMsg' => 'success'], $result);
    }

    /**
     * Test handles XML string payload (should fail gracefully).
     */
    public function testHandlesXmlStringPayload()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher);
        $xmlMessage = '<xml><Event>xpay_goods_deliver_notify</Event></xml>';

        // json_decode will return null for XML, so message becomes []
        $this->mockEventDispatcher
            ->expects($this->never())
            ->method('dispatch');

        $result = $handler->handle($xmlMessage);
        
        $this->assertEquals(['ErrCode' => 0, 'ErrMsg' => 'success'], $result);
    }

    /**
     * Test handles array payload directly.
     */
    public function testHandlesArrayPayloadDirectly()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher);
        $arrayMessage = ['Event' => 'xpay_goods_deliver_notify'];

        $this->mockEventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(GoodsDeliveredEvent::class));

        $result = $handler->handle($arrayMessage);
        
        $this->assertEquals(['ErrCode' => 0, 'ErrMsg' => 'success'], $result);
    }

    /**
     * Test throws BadRequestException for invalid payload types.
     */
    public function testThrowsBadRequestExceptionForInvalidPayload()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher);
        $invalidPayload = new \stdClass();

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('Invalid message format');
        
        $handler->handle($invalidPayload);
    }

    /**
     * Test handles empty payload.
     */
    public function testHandlesEmptyPayload()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher);
        
        // null payload should throw exception
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('Invalid message format');
        
        $handler->handle(null);
    }

    /**
     * Test handles empty array payload.
     */
    public function testHandlesEmptyArrayPayload()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher);
        $emptyArray = [];

        // Empty array has no Event field, so it should return success without dispatching
        $this->mockEventDispatcher
            ->expects($this->never())
            ->method('dispatch');

        $result = $handler->handle($emptyArray);
        
        $this->assertEquals(['ErrCode' => 0, 'ErrMsg' => 'success'], $result);
    }
}