<?php

namespace Moonpie\EasyWechat\VirtualPay\Tests\Server\Handlers;

use PHPUnit\Framework\TestCase;
use Moonpie\EasyWechat\VirtualPay\Server\Handlers\VirtualPayEventHandler;
use Moonpie\EasyWechat\VirtualPay\Event\GoodsDeliveredEvent;
use Moonpie\EasyWechat\VirtualPay\Event\CoinPaidEvent;
use Moonpie\EasyWechat\VirtualPay\Event\RefundProcessedEvent;
use Moonpie\EasyWechat\VirtualPay\Event\ComplaintFiledEvent;
use Moonpie\EasyWechat\VirtualPay\Event\IosRefundQueryNotifyEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use EasyWeChat\Kernel\Exceptions\BadRequestException;
use EasyWeChat\Kernel\Messages\Raw;

class VirtualPayEventHandlerTest extends TestCase
{
    /**
     * @var EventDispatcherInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $mockEventDispatcher;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $mockApp;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->mockEventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->mockEventDispatcher->method('dispatch')
            ->willReturnCallback(function ($event) { return $event; });

        $mockRequest = $this->createMock(\Symfony\Component\HttpFoundation\Request::class);
        $mockRequest->method('getContentType')->willReturn('json');
        $this->mockApp = new class($mockRequest) {
            public $request;
            public function __construct($request) { $this->request = $request; }
        };
    }

    public function testIdentifiesGoodsDeliveredEventType()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher, $this->mockApp);
        $message = [
            'Event' => 'xpay_goods_deliver_notify',
            'ToUserName' => 'gh_1234567890ab'
        ];

        $this->mockEventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                $this->isInstanceOf(GoodsDeliveredEvent::class),
                $this->equalTo('xpay_goods_deliver_notify')
            );

        $result = $handler->handle($message);
        
        $this->assertInstanceOf(Raw::class, $result);
    }

    public function testIdentifiesCoinPaidEventType()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher, $this->mockApp);
        $message = [
            'Event' => 'xpay_coin_pay_notify',
            'ToUserName' => 'gh_1234567890ab'
        ];

        $this->mockEventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                $this->isInstanceOf(CoinPaidEvent::class),
                $this->equalTo('xpay_coin_pay_notify')
            );

        $result = $handler->handle($message);
        
        $this->assertInstanceOf(Raw::class, $result);
    }

    public function testIdentifiesRefundProcessedEventType()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher, $this->mockApp);
        $message = [
            'Event' => 'xpay_refund_notify',
            'ToUserName' => 'gh_1234567890ab'
        ];

        $this->mockEventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                $this->isInstanceOf(RefundProcessedEvent::class),
                $this->equalTo('xpay_refund_notify')
            );

        $result = $handler->handle($message);
        
        $this->assertInstanceOf(Raw::class, $result);
    }

    public function testIdentifiesComplaintFiledEventType()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher, $this->mockApp);
        $message = [
            'Event' => 'xpay_complaint_notify',
            'ToUserName' => 'gh_1234567890ab'
        ];

        $this->mockEventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                $this->isInstanceOf(ComplaintFiledEvent::class),
                $this->equalTo('xpay_complaint_notify')
            );

        $result = $handler->handle($message);
        
        $this->assertInstanceOf(Raw::class, $result);
    }

    public function testIdentifiesIosRefundQueryEventType()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher, $this->mockApp);
        $message = [
            'Event' => 'xpay_subscribe_ios_refund_query_notify',
            'ToUserName' => 'gh_1234567890ab'
        ];

        $this->mockEventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                $this->isInstanceOf(IosRefundQueryNotifyEvent::class),
                $this->equalTo('xpay_subscribe_ios_refund_query_notify')
            );

        $result = $handler->handle($message);
        
        $this->assertInstanceOf(Raw::class, $result);
    }

    public function testCreatesCorrectEventObjects()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher, $this->mockApp);
        
        $goodsMessage = ['Event' => 'xpay_goods_deliver_notify', 'TestField' => 'test_value'];
        $this->mockEventDispatcher
            ->expects($this->at(0))
            ->method('dispatch')
            ->with($this->callback(function ($event) {
                return $event instanceof GoodsDeliveredEvent && 
                       $event->getSubject()['TestField'] === 'test_value';
            }));
        
        $handler->handle($goodsMessage);
        
        $this->mockEventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->mockEventDispatcher->method('dispatch')
            ->willReturnCallback(function ($event) { return $event; });
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher, $this->mockApp);
        
        $coinMessage = ['Event' => 'xpay_coin_pay_notify', 'TestField' => 'test_value'];
        $this->mockEventDispatcher
            ->expects($this->at(0))
            ->method('dispatch')
            ->with($this->callback(function ($event) {
                return $event instanceof CoinPaidEvent && 
                       $event->getSubject()['TestField'] === 'test_value';
            }));
        
        $handler->handle($coinMessage);
        
        $this->mockEventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->mockEventDispatcher->method('dispatch')
            ->willReturnCallback(function ($event) { return $event; });
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher, $this->mockApp);
        
        $refundMessage = ['Event' => 'xpay_refund_notify', 'TestField' => 'test_value'];
        $this->mockEventDispatcher
            ->expects($this->at(0))
            ->method('dispatch')
            ->with($this->callback(function ($event) {
                return $event instanceof RefundProcessedEvent && 
                       $event->getSubject()['TestField'] === 'test_value';
            }));
        
        $handler->handle($refundMessage);
        
        $this->mockEventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->mockEventDispatcher->method('dispatch')
            ->willReturnCallback(function ($event) { return $event; });
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher, $this->mockApp);
        
        $complaintMessage = ['Event' => 'xpay_complaint_notify', 'TestField' => 'test_value'];
        $this->mockEventDispatcher
            ->expects($this->at(0))
            ->method('dispatch')
            ->with($this->callback(function ($event) {
                return $event instanceof ComplaintFiledEvent && 
                       $event->getSubject()['TestField'] === 'test_value';
            }));
        
        $handler->handle($complaintMessage);

        $this->mockEventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->mockEventDispatcher->method('dispatch')
            ->willReturnCallback(function ($event) { return $event; });
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher, $this->mockApp);

        $iosRefundMessage = ['Event' => 'xpay_subscribe_ios_refund_query_notify', 'TestField' => 'ios_refund_value'];
        $this->mockEventDispatcher
            ->expects($this->at(0))
            ->method('dispatch')
            ->with($this->callback(function ($event) {
                return $event instanceof IosRefundQueryNotifyEvent &&
                       $event->getSubject()['TestField'] === 'ios_refund_value';
            }));

        $handler->handle($iosRefundMessage);
    }

    public function testReturnsCorrectWeChatResponseFormat()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher, $this->mockApp);
        $message = ['Event' => 'xpay_goods_deliver_notify'];

        $result = $handler->handle($message);
        
        $this->assertInstanceOf(Raw::class, $result);
    }

    public function testTriggersEventDispatcherEvents()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher, $this->mockApp);
        $message = ['Event' => 'xpay_goods_deliver_notify'];

        $this->mockEventDispatcher
            ->expects($this->once())
            ->method('dispatch');

        $handler->handle($message);
    }

    public function testHandlesUnknownEventTypes()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher, $this->mockApp);
        $message = ['Event' => 'unknown_event_type'];

        $this->mockEventDispatcher
            ->expects($this->never())
            ->method('dispatch');

        $result = $handler->handle($message);
        
        $this->assertInstanceOf(Raw::class, $result);
    }

    public function testHandlesJsonStringPayload()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher, $this->mockApp);
        $jsonMessage = json_encode(['Event' => 'xpay_goods_deliver_notify']);

        $this->mockEventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(GoodsDeliveredEvent::class));

        $result = $handler->handle($jsonMessage);
        
        $this->assertInstanceOf(Raw::class, $result);
    }

    public function testHandlesXmlStringPayload()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher, $this->mockApp);
        $xmlMessage = '<xml><Event>xpay_goods_deliver_notify</Event></xml>';

        $this->mockEventDispatcher
            ->expects($this->never())
            ->method('dispatch');

        $result = $handler->handle($xmlMessage);
        
        $this->assertInstanceOf(Raw::class, $result);
    }

    public function testHandlesArrayPayloadDirectly()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher, $this->mockApp);
        $arrayMessage = ['Event' => 'xpay_goods_deliver_notify'];

        $this->mockEventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(GoodsDeliveredEvent::class));

        $result = $handler->handle($arrayMessage);
        
        $this->assertInstanceOf(Raw::class, $result);
    }

    public function testThrowsBadRequestExceptionForInvalidPayload()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher, $this->mockApp);
        $invalidPayload = new \stdClass();

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('Invalid message format');
        
        $handler->handle($invalidPayload);
    }

    public function testHandlesEmptyPayload()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher, $this->mockApp);
        
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('Invalid message format');
        
        $handler->handle(null);
    }

    public function testHandlesEmptyArrayPayload()
    {
        $handler = new VirtualPayEventHandler($this->mockEventDispatcher, $this->mockApp);
        $emptyArray = [];

        $this->mockEventDispatcher
            ->expects($this->never())
            ->method('dispatch');

        $result = $handler->handle($emptyArray);
        
        $this->assertInstanceOf(Raw::class, $result);
    }
}
