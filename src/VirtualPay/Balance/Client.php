<?php

namespace Moonpie\EasyWechat\VirtualPay\Balance;

use Moonpie\EasyWechat\VirtualPay\BasicClient;

/**
 * Balance Client for Virtual Pay
 */
class Client extends BasicClient
{
    /**
     * Query user balance.
     *
     * @param string $openid
     * @param string $userIp
     * @param string $sessionKey
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function queryUserBalance($openid, $userIp, $sessionKey)
    {
        $env = $this->getEnv();

        $data = [
            'openid' => $openid,
            'env' => $env,
            'user_ip' => $userIp,
        ];

        $response = $this->httpPostJson(
            'https://api.weixin.qq.com/xpay/query_user_balance',
            $data,
            [],
            $sessionKey
        );

        return $response;
    }

    /**
     * Query business balance.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function queryBizBalance()
    {
        $env = $this->getEnv();

        $data = [
            'env' => $env,
        ];

        $response = $this->httpPostJson(
            'https://api.weixin.qq.com/xpay/query_biz_balance',
            $data
        );

        return $response;
    }
}

