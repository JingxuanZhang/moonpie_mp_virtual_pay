<?php

namespace Moonpie\EasyWechat\VirtualPay;

use Moonpie\EasyWechat\VirtualPay\Bill\Client as BillClient;
use Moonpie\EasyWechat\VirtualPay\Withdraw\Client as WithdrawClient;
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
        // Verify that the container is a mini program application
        if (!isset($app['mini_program'])) {
            throw new \RuntimeException('The container must be a mini program application.');
        }

        // Register virtual pay clients
        $app['virtual_pay_balance'] = function ($app) {
            return new BasicClient($app, '/xpay/query_user_balance');
        };

        $app['virtual_pay_order'] = function ($app) {
            return new BasicClient($app, '/xpay/currency_pay');
        };

        $app['virtual_pay_currency'] = function ($app) {
            return new BasicClient($app, '/xpay/cancel_currency_pay');
        };

        $app['virtual_pay_goods'] = function ($app) {
            return new BasicClient($app, '/xpay/goods');
        };

        $app['virtual_pay_withdraw'] = function ($app) {
            return new WithdrawClient($app);
        };

        $app['virtual_pay_fund'] = function ($app) {
            return new BasicClient($app, '/xpay/fund');
        };

        $app['virtual_pay_complaint'] = function ($app) {
            return new BasicClient($app, '/xpay/complaint');
        };

        $app['virtual_pay_bill'] = function ($app) {
            return new BillClient($app);
        };
    }
}