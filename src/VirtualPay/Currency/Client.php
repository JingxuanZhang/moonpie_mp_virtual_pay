<?php

namespace Moonpie\EasyWechat\VirtualPay\Currency;

use EasyWeChat\Kernel\Support\Arr;
use Moonpie\EasyWechat\VirtualPay\BasicClient;
use Pimple\Container;

/**
 * Currency Client for Virtual Pay
 */
class Client extends BasicClient
{
    /**
     * Deduct currency (generally used for currency payment).
     *
     * @param array $params
     * @param string $sessionKey
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function currencyPay($params, $sessionKey)
    {
        $env = $this->getEnv($params);

        $data = [
            'openid' => Arr::get($params, 'openid'),
            'env' => $env,
            'user_ip' => Arr::get($params, 'user_ip'),
            'amount' => Arr::get($params, 'amount'),
            'order_id' => Arr::get($params, 'order_id'),
            'payitem' => Arr::get($params, 'payitem'),
            'remark' => Arr::get($params, 'remark', ''),
        ];

        $response = $this->httpPostJson(
            'https://api.weixin.qq.com/xpay/currency_pay',
            $data,
            [],
            $sessionKey
        );

        return $response;
    }

    /**
     * Refund currency payment (inverse operation of currency_pay).
     *
     * @param array $params
     * @param string $sessionKey
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function cancelCurrencyPay($params, $sessionKey)
    {
        $env = $this->getEnv($params);

        $data = [
            'openid' => Arr::get($params, 'openid'),
            'env' => $env,
            'user_ip' => Arr::get($params, 'user_ip'),
            'pay_order_id' => Arr::get($params, 'pay_order_id'),
            'order_id' => Arr::get($params, 'order_id'),
            'amount' => Arr::get($params, 'amount'),
        ];

        $response = $this->httpPostJson(
            'https://api.weixin.qq.com/xpay/cancel_currency_pay',
            $data,
            [],
            $sessionKey
        );

        return $response;
    }

    /**
     * Present currency to user.
     *
     * @param array $params
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function presentCurrency($params)
    {
        $env = $this->getEnv($params);

        $data = [
            'openid' => Arr::get($params, 'openid'),
            'env' => $env,
            'order_id' => Arr::get($params, 'order_id'),
            'amount' => Arr::get($params, 'amount'),
        ];

        $response = $this->httpPostJson(
            'https://api.weixin.qq.com/xpay/present_currency',
            $data
        );

        return $response;
    }
}

