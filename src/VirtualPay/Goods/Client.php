<?php

namespace Moonpie\EasyWechat\VirtualPay\Goods;

use Moonpie\EasyWechat\VirtualPay\BasicClient;
use EasyWeChat\Kernel\Support\Arr;
use Pimple\Container;

/**
 * Goods Client for Virtual Pay
 */
class Client extends BasicClient
{
    /**
     * Start upload goods task.
     *
     * @param array $uploadItem
     * @param int|null $env
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function startUploadGoods($uploadItem, $env = null)
    {
        $env = $env ?? $this->getEnv();

        $params = [
            'upload_item' => $uploadItem,
            'env' => $env,
        ];

        return $this->httpPostJson('https://api.weixin.qq.com/xpay/start_upload_goods', $params);
    }

    /**
     * Query upload goods task.
     *
     * @param int|null $env
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function queryUploadGoods($env = null)
    {
        $env = $env ?? $this->getEnv();

        $params = [
            'env' => $env,
        ];

        return $this->httpPostJson('https://api.weixin.qq.com/xpay/query_upload_goods', $params);
    }

    /**
     * Start publish goods task.
     *
     * @param array $publishItem
     * @param int|null $env
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function startPublishGoods($publishItem, $env = null)
    {
        if ($env === null) {
            $env = $this->app['config']['virtual_pay.env'] ?? 0;
        }

        $params = [
            'publish_item' => $publishItem,
            'env' => $env,
        ];

        return $this->httpPostJson('https://api.weixin.qq.com/xpay/start_publish_goods', $params);
    }

    /**
     * Query publish goods task.
     *
     * @param int|null $env
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function queryPublishGoods($env = null)
    {
        if ($env === null) {
            $env = $this->app['config']['virtual_pay.env'] ?? 0;
        }

        $params = [
            'env' => $env,
        ];

        return $this->httpPostJson('https://api.weixin.qq.com/xpay/query_publish_goods', $params);
    }
}