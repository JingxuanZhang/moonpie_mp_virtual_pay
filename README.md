# Moonpie MP Virtual Pay

WeChat Mini Program Virtual Payment for EasyWeChat

微信小程序虚拟支付 for EasyWeChat

## 安装
```bash
composer require moonpie/mp-virtual-pay
```

## 配置
```php
use EasyWeChat\MiniProgram\Application;
use Moonpie\EasyWechat\VirtualPay\VirtualPayServiceProvider;

$config = [
    'app_id' => 'wx-app-id',
    'secret' => 'wx-app-secret',
    'response_type' => 'array',
    
    // 虚拟支付配置
    'virtual_pay' => [
        'offer_id' => 'your offer id',
        'app_key' => 'your-prod-app-key',
        'sandbox_app_key' => 'your-sandbox-app-key',
        'env' => 0, // 0-正式环境 1-沙箱环境
    ],
];

$miniProgram = new Application($config);
$miniProgram->register(new VirtualPayServiceProvider());
```

### 使用示例
```php
// 1. 查询用户余额（需要用户态签名）
$balance = $miniProgram->virtual_pay_balance->queryUserBalance(
    'user-openid',
    '127.0.0.1',
    $userSessionKey // 从用户登录获取
);

// 2. 扣减代币（需要用户态签名）
$result = $miniProgram->virtual_pay_currency->currencyPay([
    'openid' => 'user-openid',
    'amount' => 100,
    'order_id' => 'order-123',
    'user_ip' => '127.0.0.1',
    'payitem' => json_encode([[
        'productid' => 'item-001',
        'unit_price' => 100,
        'quantity' => 1
    ]])
], $userSessionKey);

// 3. 查询商家余额（不需要用户态签名）
$bizBalance = $miniProgram->virtual_pay_balance->queryBizBalance();

// 4. 代币赠送（不需要用户态签名）
$presentResult = $miniProgram->virtual_pay_currency->presentCurrency([
    'openid' => 'user-openid',
    'order_id' => 'present-001',
    'amount' => 50,
]);

// 5. 查询订单
$order = $miniProgram->virtual_pay_order->queryOrder('order-123');

// 6. 退款
$refund = $miniProgram->virtual_pay_order->refundOrder([
    'openid' => 'user-openid',
    'order_id' => 'order-123',
    'refund_order_id' => 'refund-001',
    'left_fee' => 100,
    'refund_fee' => 100,
    'refund_reason' => '0',
    'req_from' => '2',
]);
// 7. 发起支付, 需要sessionKey
$signData = [
'buyQuantity' => 1, //number		是	购买数量
'env' => 0, //number		否	环境配置, 0 米大师正式环境, 1 米大师沙箱环境, 默认为 0
'currencyType' => 'CNY', //string		是	币种 合法值	说明 CNY	人民币
'productId' => '', string		否	道具ID, **该字段仅mode=short_series_goods时需要必填**
'goodsPrice' => 100, //number		否	道具单价(分), **该字段仅mode=short_series_goods时需要必填**, 用来校验价格与后台道具价格是否一致, 避免用户在业务商城页看到的价格与实际价格不一致导致投诉 
'activitySellingPrice' => 40, //number		否	道具优惠价格（分），**非必填，该字段需与goodsPrice一起传入**。如用户使用优惠券、积分等，需要以低于道具价格下单时可传入，传入后该价格即为实际下单价格，优惠价格最低为道具价格的40%。（注：iOS端暂不支持使用优惠价格下单） 
'outTradeNo' => 'unique order no', //string		是	业务订单号, 每个订单号只能使用一次, 重复使用会失败(极端情况不保证唯一, 不建议业务强依赖唯一性).  要求8-32个字符内, 只能是数字、大小写字母、符号 _-|*@组成, 不能以下划线(_)开头
'attach' => '', //	string		是	透传数据, 发货通知时会透传给
];
$mode = 'short_series_goods';//可选项short_series_goods	道具直购|short_series_coin	代币充值
$virtualPayData = $miniProgram->virtual_pay_order->buildVirtualPayData($signData, $mode, $sessionKey);

// 8. 消息通知回调
//添加统一的消息监听器
use EasyWeChat\Kernel\Messages\Message;
$dispatcher = $app->events;
$dispatcher->addListener('xpay_goods_deliver_notify', callable(Event\GoodsDeliveredEvent $event));//道具发货推送
$dispatcher->addListener('xpay_coin_pay_notify', callable(Event\CoinPaidEvent $event));//代币支付推送
$dispatcher->addListener('xpay_refund_notify', callable(Event\RefundProcessedEvent $event));//退款推送
$dispatcher->addListener('xpay_complaint_notify', callable(Event\ComplaintFiledEvent $event));//用户投诉推送
$handler = new Moonpie\EasyWechat\VirtualPay\Server\Handlers\VirtualPayEventHandler($dispatcher, $app);
$app->server->push($handler, Message::EVENT);
$response = $app->server->serve();
//如何处理$response需要针对不同框架对Symfony Response的支持区别对待
//使用者的重心将集中到如何编写具体事件的callable
```

---

## 📚 API 模块说明

### Balance（余额管理）
- `queryUserBalance($openid, $userIp, $sessionKey)` - 查询用户代币余额
- `queryBizBalance()` - 查询商家账户余额

### Order（订单管理）
- `buildVirtualPayData($signData, $mode, $sessionKey)` - 生成wx.requestVirtualPayment需要的支付信息(下单);
- `queryOrder($orderId, $openid, $env)` - 查询订单
- `notifyProvideGoods($orderId, $wxOrderId, $env)` - 通知发货
- `refundOrder($params)` - 订单退款

### Currency（代币管理）
- `currencyPay($params, $sessionKey)` - 扣减代币
- `cancelCurrencyPay($params, $sessionKey)` - 代币支付退款
- `presentCurrency($params)` - 代币赠送

### Goods（道具管理）
- `startUploadGoods($uploadItem, $env)` - 启动批量上传道具
- `queryUploadGoods($env)` - 查询上传道具任务
- `startPublishGoods($publishItem, $env)` - 启动批量发布道具
- `queryPublishGoods($env)` - 查询发布道具任务

### Withdraw（提现管理）
- `createWithdrawOrder($params)` - 创建提现单
- `queryWithdrawOrder($withdrawNo, $env)` - 查询提现单

### Fund（广告金管理）
- `queryTransferAccount($env)` - 查询广告金充值账户
- `queryAdverFunds($params)` - 查询广告金发放记录
- `createFundsBill($params)` - 充值广告金
- `bindTransferAccount($params)` - 绑定广告金充值账户
- `queryFundsBill($params)` - 查询广告金充值记录
- `queryRecoverBill($params)` - 查询广告金回收记录
- `downloadAdverfundsOrder($fundId, $env)` - 下载广告金订单

### Complaint（投诉管理）
- `getComplaintList($params)` - 获取投诉列表
- `getComplaintDetail($complaintId, $env)` - 获取投诉详情
- `getNegotiationHistory($complaintId, $offset, $limit, $env)` - 获取协商历史
- `responseComplaint($complaintId, $responseContent, $responseImages, $env)` - 回复用户
- `completeComplaint($complaintId, $env)` - 完成投诉处理
- `uploadVpFile($params)` - 上传媒体文件
- `getUploadFileSign($wxpayUrl, $convertCos, $complaintId, $env)` - 获取文件下载签名

### Bill（账单管理）
- `downloadBill($beginDs, $endDs)` - 下载小程序账单

## 要求

- PHP >= 7.2
- easywechat/easywechat: ^4.0

## 许可证

MIT 许可证 - 详情请参见 [LICENSE](LICENSE)。
