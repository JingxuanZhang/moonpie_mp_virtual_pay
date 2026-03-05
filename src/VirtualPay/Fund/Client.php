<?php

namespace Moonpie\EasyWechat\VirtualPay\Fund;

use Moonpie\EasyWechat\VirtualPay\BasicClient;
use Pimple\Container;

/**
 * Fund Client for Virtual Pay
 * 广告金相关接口
 */
class Client extends BasicClient
{
    /**
     * 查询广告金充值账户
     *
     * @param int|null $env 0-正式环境 1-沙箱环境（仅作为签名校验，查询的结果都是正式环境的）
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function queryTransferAccount($env = null)
    {
        $params = [];
        if ($env !== null) {
            $params['env'] = $env;
        }
        
        return $this->httpPostJson('https://api.weixin.qq.com/xpay/query_transfer_account', $params);
    }

    /**
     * 查询广告金发放记录
     *
     * @param array $params 请求参数
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function queryAdverFunds($params)
    {
        return $this->httpPostJson('https://api.weixin.qq.com/xpay/query_adver_funds', $params);
    }

    /**
     * 充值广告金
     *
     * @param array $params 请求参数
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function createFundsBill($params)
    {
        return $this->httpPostJson('https://api.weixin.qq.com/xpay/create_funds_bill', $params);
    }

    /**
     * 绑定广告金充值账户
     *
     * @param array $params 请求参数
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function bindTransferAccount($params)
    {
        return $this->httpPostJson('https://api.weixin.qq.com/xpay/bind_transfer_account', $params);
    }

    /**
     * 查询广告金充值记录
     *
     * @param array $params 请求参数
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function queryFundsBill($params)
    {
        return $this->httpPostJson('https://api.weixin.qq.com/xpay/query_funds_bill', $params);
    }

    /**
     * 查询广告金回收记录
     *
     * @param array $params 请求参数
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function queryRecoverBill($params)
    {
        return $this->httpPostJson('https://api.weixin.qq.com/xpay/query_recover_bill', $params);
    }

    /**
     * 下载广告金订单
     *
     * @param string $fundId 广告金发放ID
     * @param int|null $env 0-正式环境 1-沙箱环境（仅作为签名校验，查询的结果都是正式环境的）
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     */
    public function downloadAdverfundsOrder($fundId, $env = null)
    {
        $params = [
            'fund_id' => $fundId,
        ];
        
        if ($env !== null) {
            $params['env'] = $env;
        }
        
        return $this->httpPostJson('https://api.weixin.qq.com/xpay/download_adverfunds_order', $params);
    }
}