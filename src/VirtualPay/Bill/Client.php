<?php

namespace Moonpie\EasyWechat\VirtualPay\Bill;

use Moonpie\EasyWechat\VirtualPay\BasicClient;
use Pimple\Container;

/**
 * Bill Client for Virtual Pay
 */
class Client extends BasicClient
{
    /**
     * Download mini program bill.
     *
     * @param int $beginDs Start date (e.g., 20230801)
     * @param int $endDs End date (e.g., 20230810)
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function downloadBill($beginDs, $endDs)
    {
        $params = [
            'begin_ds' => $beginDs,
            'end_ds' => $endDs,
        ];

        return $this->httpPostJson(
            'https://api.weixin.qq.com/xpay/download_bill',
            $params
        );
    }
}