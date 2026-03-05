<?php

namespace Moonpie\EasyWechat\VirtualPay\Withdraw;

use Moonpie\EasyWechat\VirtualPay\BasicClient;
use Pimple\Container;

/**
 * Withdraw Client for Virtual Pay
 */
class Client extends BasicClient
{
    /**
     * Create withdraw order.
     *
     * @param array $params
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     *
     * @see https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html#create-withdraw-order
     */
    public function createWithdrawOrder($params)
    {
        // Remove env from params as it should only be in query string for signature
        $data = $params;
        unset($data['env']);
        
        return $this->httpPostJson('https://api.weixin.qq.com/xpay/create_withdraw_order', $data);
    }

    /**
     * Query withdraw order.
     *
     * @param string $withdrawNo
     * @param int|null $env
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     *
     * @see https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html#query-withdraw-order
     */
    public function queryWithdrawOrder($withdrawNo, $env = null)
    {
        $params = [
            'withdraw_no' => $withdrawNo,
        ];

        if ($env !== null) {
            $params['env'] = $env;
        }

        return $this->httpPostJson('https://api.weixin.qq.com/xpay/query_withdraw_order', $params);
    }
}