<?php

namespace Moonpie\EasyWechat\VirtualPay\Order;

use EasyWeChat\Kernel\Support\Arr;
use Moonpie\EasyWechat\VirtualPay\BasicClient;
use Pimple\Container;

/**
 * Order Client for Virtual Pay
 */
class Client extends BasicClient
{
    /**
     * Query order by wx_order_id
     *
     * @param string $orderId
     * @param string $openid
     * @param int|null $env
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function queryWxOrder($orderId, $openid, $env = null)
    {
        $env = $env ?? $this->getEnv();

        $data = [
            'openid' => $openid,
            'env' => $env,
        ];

        $data['wx_order_id'] = $orderId;

        $response = $this->httpPostJson(
            'https://api.weixin.qq.com/xpay/query_order',
            $data
        );

        return $response;
    }
    /**
     * Query order by order_id
     *
     * @param string $orderId
     * @param string $openid
     * @param int|null $env
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function queryOrder($orderId, $openid, $env = null)
    {
        $env = $env ?? $this->getEnv();

        $data = [
            'openid' => $openid,
            'env' => $env,
        ];

        $data['order_id'] = $orderId;

        $response = $this->httpPostJson(
            'https://api.weixin.qq.com/xpay/query_order',
            $data
        );

        return $response;
    }

    /**
     * Notify that goods have been provided.
     *
     * @param string $orderId
     * @param string|null $wxOrderId
     * @param int|null $env
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function notifyProvideGoods($orderId, $wxOrderId = null, $env = null)
    {
        $env = $env ?? $this->getEnv();

        $data = [
            'env' => $env,
        ];

        // Use order_id or wx_order_id (at least one must be provided)
        if ($wxOrderId !== null) {
            $data['wx_order_id'] = $wxOrderId;
        } else {
            $data['order_id'] = $orderId;
        }

        $response = $this->httpPostJson(
            'https://api.weixin.qq.com/xpay/notify_provide_goods',
            $data
        );

        return $response;
    }

    /**
     * Refund an order created with jsapi.
     *
     * @param array $params
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function refundOrder($params)
    {
        $env = $this->getEnv($params);

        $data = [
            'openid' => Arr::get($params, 'openid'),
            'env' => $env,
            'refund_order_id' => Arr::get($params, 'refund_order_id'),
            'left_fee' => Arr::get($params, 'left_fee'),
            'refund_fee' => Arr::get($params, 'refund_fee'),
            'biz_meta' => Arr::get($params, 'biz_meta', ''),
            'refund_reason' => (string) Arr::get($params, 'refund_reason', '0'),
            'req_from' => (string) Arr::get($params, 'req_from', '1'),
        ];

        // Add order_id or wx_order_id (at least one must be provided)
        if (Arr::has($params, 'wx_order_id')) {
            $data['wx_order_id'] = Arr::get($params, 'wx_order_id');
        } else {
            $data['order_id'] = Arr::get($params, 'order_id');
        }

        $response = $this->httpPostJson(
            'https://api.weixin.qq.com/xpay/refund_order',
            $data
        );

        return $response;
    }
}

