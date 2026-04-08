Apple 支付不支持开发者主动向用户发起退款，用户可在 App Store 申请退款，用户申请方式：


用户申请后，Apple 支付会根据自身策略判断，并会向开发者发起重复三次的退款问询，开发者可根据自身策略响应问询。

Apple 支付只会参考开发者的问询结果，最终结果依然由 Apple 支付处理，详情可咨询苹果公司 (Apple) 。

消息推送和原有规范保持一致：消息推送

响应接口：xpay_subscribe_ios_refund_query_notify
如果连续 3 次、在 3 秒内均未应答退款问询，微信平台会向 Apple 支付返回「不确定」作为退款参考，也即退款决定权交由苹果公司 (Apple) 处理。

消息内容：WxaVirtualPayIosRefundQueryNotifyEvent
字段	类型	备注
refund_time	string	问询时间，Unix时间戳
order_time	string	该笔退款的订单时间（退款订单对应的交易时间），Unix时间戳
channel_bill	string	Apple 支付票据号
bundleid	string	应用的 Apple bundleid
product_id	string	道具 id
p_count	string	道具/代币数量
refund_request_reason	string	用户请求退款的原因
provide_status	string	发货状态，0 : 未发货 1：已发货 2：发货中
pay_order_id	string	退款对应支付订单号
应答响应：IosRefundQueryResponse
字段	类型	备注
result_code	int32	结果码，0-放过，建议退款；1-拦截，拒绝退款
result_info	string	结果描述
evidence	string	决策凭据(必填），业务需返回建议退款/拒绝退款的依据，用于退款审计
如 Apple 支付发起退款、并退款成功，平台会通过原有的退款推送 xpay_refund_notify
