<?php

namespace Moonpie\EasyWeChat\VirtualPay\Complaint;

use Moonpie\EasyWechat\VirtualPay\BasicClient;
use Pimple\Container;

/**
 * Complaint Client for Virtual Pay
 */
class Client extends BasicClient
{
    /**
     * Get complaint list
     *
     * @param array $params Request parameters
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     *
     * @see https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html#get-complaint-list
     */
    public function getComplaintList($params)
    {
        return $this->httpPostJson('https://api.weixin.qq.com/xpay/get_complaint_list', $params);
    }

    /**
     * Get complaint detail
     *
     * @param string $complaintId Complaint ID
     * @param int|null $env Environment (0-正式环境, 1-沙箱环境)
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     *
     * @see https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html#get-complaint-detail
     */
    public function getComplaintDetail($complaintId, $env = null)
    {
        $params = [
            'complaint_id' => $complaintId,
        ];
        
        if ($env !== null) {
            $params['env'] = $env;
        }
        
        return $this->httpPostJson('https://api.weixin.qq.com/xpay/get_complaint_detail', $params);
    }

    /**
     * Get negotiation history
     *
     * @param string $complaintId Complaint ID
     * @param int $offset Offset (default: 0)
     * @param int $limit Limit (default: 20)
     * @param int|null $env Environment (0-正式环境, 1-沙箱环境)
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     *
     * @see https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html#get-negotiation-history
     */
    public function getNegotiationHistory($complaintId, $offset = 0, $limit = 20, $env = null)
    {
        $params = [
            'complaint_id' => $complaintId,
            'offset' => $offset,
            'limit' => $limit,
        ];
        
        if ($env !== null) {
            $params['env'] = $env;
        }
        
        return $this->httpPostJson('https://api.weixin.qq.com/xpay/get_negotiation_history', $params);
    }

    /**
     * Response to complaint
     *
     * @param string $complaintId Complaint ID
     * @param string $responseContent Response content
     * @param array $responseImages Response images (file_id array from uploadVpFile)
     * @param int|null $env Environment (0-正式环境, 1-沙箱环境)
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     *
     * @see https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html#response-complaint
     */
    public function responseComplaint($complaintId, $responseContent, $responseImages = [], $env = null)
    {
        $params = [
            'complaint_id' => $complaintId,
            'response_content' => $responseContent,
            'response_images' => $responseImages,
        ];
        
        if ($env !== null) {
            $params['env'] = $env;
        }
        
        return $this->httpPostJson('https://api.weixin.qq.com/xpay/response_complaint', $params);
    }

    /**
     * Complete complaint processing
     *
     * @param string $complaintId Complaint ID
     * @param int|null $env Environment (0-正式环境, 1-沙箱环境)
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     *
     * @see https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html#complete-complaint
     */
    public function completeComplaint($complaintId, $env = null)
    {
        $params = [
            'complaint_id' => $complaintId,
        ];
        
        if ($env !== null) {
            $params['env'] = $env;
        }
        
        return $this->httpPostJson('https://api.weixin.qq.com/xpay/complete_complaint', $params);
    }

    /**
     * Upload media file
     *
     * @param array $params Request parameters
     *   - base64_img: Base64 encoded image content (max 1MB)
     *   - img_url: Image URL (max 2MB, preferred over base64_img)
     *   - file_name: File name
     *   - env: Environment (0-正式环境, 1-沙箱环境)
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     *
     * @see https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html#upload-vp-file
     */
    public function uploadVpFile($params)
    {
        return $this->httpPostJson('https://api.weixin.qq.com/xpay/upload_vp_file', $params);
    }

    /**
     * Get upload file signature for download
     *
     * @param string $wxpayUrl WeChat Pay image URL (format: "https://api.mch.weixin.qq.com/v3/merchant-service/images/{xxxxxx}")
     * @param bool $convertCos Whether to convert to COS storage
     * @param string|null $complaintId Complaint ID
     * @param int|null $env Environment (0-正式环境, 1-沙箱环境)
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|string
     *
     * @see https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html#get-upload-file-sign
     */
    public function getUploadFileSign($wxpayUrl, $convertCos = false, $complaintId = null, $env = null)
    {
        $params = [
            'wxpay_url' => $wxpayUrl,
            'convert_cos' => $convertCos,
        ];
        
        if ($complaintId !== null) {
            $params['complaint_id'] = $complaintId;
        }
        
        if ($env !== null) {
            $params['env'] = $env;
        }
        
        return $this->httpPostJson('https://api.weixin.qq.com/xpay/get_upload_file_sign', $params);
    }
}