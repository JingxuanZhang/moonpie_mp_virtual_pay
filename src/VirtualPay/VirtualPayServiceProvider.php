<?php

namespace Moonpie\EasyWechat\VirtualPay;

use Moonpie\EasyWechat\VirtualPay\Server\Handlers\VirtualPayEventHandler;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Virtual Pay Service Provider
 */
class VirtualPayServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $app
     */
    public function register(Container $app)
    {
        // Register virtual pay clients
        $app['virtual_pay_balance'] = function ($app) {
            return new Balance\Client($app);
        };

        $app['virtual_pay_order'] = function ($app) {
            return new Order\Client($app);
        };

        $app['virtual_pay_currency'] = function ($app) {
            return new Currency\Client($app);
        };

        $app['virtual_pay_goods'] = function ($app) {
            return new Goods\Client($app);
        };

        $app['virtual_pay_withdraw'] = function ($app) {
            return new Withdraw\Client($app);
        };

        $app['virtual_pay_fund'] = function ($app) {
            return new Fund\Client($app);
        };

        $app['virtual_pay_complaint'] = function ($app) {
            return new Complaint\Client($app);
        };

        $app['virtual_pay_bill'] = function ($app) {
            return new Bill\Client($app);
        };

        // Register event handler
        $this->registerEventHandler($app);
    }

    /**
     * Register the virtual pay event handler.
     *
     * @param Container $app
     */
    protected function registerEventHandler(Container $app)
    {
        if (isset($app['server'])) {
            $app['server']->push(
                function ($message) use ($app) {
                    // Check if this is a virtual pay event
                    if (is_array($message) && isset($message['Event'])) {
                        $eventType = $message['Event'];
                        if (in_array($eventType, [
                            'xpay_goods_deliver_notify',
                            'xpay_coin_pay_notify', 
                            'xpay_refund_notify',
                            'xpay_complaint_notify'
                        ])) {
                            $handler = new VirtualPayEventHandler($app['events']);
                            return $handler->handle($message);
                        }
                    }
                    
                    return null;
                }
            );
        }
    }
}

