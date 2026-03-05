小程序虚拟支付/产品介绍/

为保障用户权益，提高交易安全，平台将向 “文娱、工具、社交、资讯、深度合成” 类目小程序提供虚拟支付能力，开发者可通过小程序管理后台--虚拟支付模块，开通一个新的微信支付商户号，使用账单查询、资金提现等服务。平台将以通过该支付能力产生的支付金额为结算基数，按一定费率收取技术服务费。

本文档主要介绍虚拟支付的核心基础流程，适用于安卓、鸿蒙、windows端，苹果iOS端有额外开通、适配流程，需依照相关文档处理。

**若测试请先使用沙箱环境，若使用现网环境，平台将收取相关技术服务费。**

**安卓、鸿蒙、windows端：开发者请在2.19.2或以上版本基础库中调用。** **苹果iOS端：开发者请在微信客户端8.0.68或以上版本调用**

## [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#_1-1-%E5%BC%80%E9%80%9A%E6%9D%A1%E4%BB%B6) 1.1.开通条件

●主体类型为已认证小程序

●小程序类型为企业小程序

●小程序运营资质为 “文娱、工具、社交、资讯、深度合成” 类目

●小程序主体信息完备（若有缺陷请使用平台提供的修改链接修正）

## [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#_1-2-%E5%BC%80%E9%80%9A%E5%85%A5%E5%8F%A3) 1.2.开通入口

当小程序完成资质申请并且通过获得“文娱、工具、社交、资讯、深度合成”类目后，点击mp左边栏【虚拟支付】即可前往开通页面进行开通。

![](https://res.wx.qq.com/wxdoc/dist/assets/img/rukou.202e41b2.png)

若当前账户满足开通条件后，点击【开通】按钮进行协议签署及资料上传，开通新的商户号。
![](https://res.wx.qq.com/wxdoc/dist/assets/img/kaitong.1bba374e.png)

## [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#_1-3-%E5%BC%80%E9%80%9A%E6%B5%81%E7%A8%8B) 1.3.开通流程

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E7%AC%AC%E4%B8%80%E6%AD%A5%EF%BC%9A%E9%98%85%E8%AF%BB%E5%8D%8F%E8%AE%AE) 第一步：阅读协议

进行协议阅读虚拟支付协议，勾选【我已阅读并同意上述条款】后进入下一步
![](https://res.wx.qq.com/wxdoc/dist/assets/img/agreement.ad20f781.png)

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E7%AC%AC%E4%BA%8C%E6%AD%A5%EF%BC%9A%E6%8F%90%E4%BA%A4%E5%95%86%E6%88%B7%E7%9B%B8%E5%85%B3%E8%B5%84%E6%96%99%E5%BC%80%E9%80%9A%E5%95%86%E6%88%B7%E5%8F%B7) 第二步：提交商户相关资料开通商户号

填写企业的营业执照，提现账户及支付管理员
![](https://res.wx.qq.com/wxdoc/dist/assets/img/busi_license.6e4fb9f4.png)

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E7%AC%AC%E4%B8%89%E6%AD%A5%EF%BC%9A%E8%B4%A6%E6%88%B7%E7%8A%B6%E6%80%81%E6%9F%A5%E8%AF%A2%E5%8F%8A%E8%B5%84%E6%96%99%E5%AE%A1%E6%A0%B8) 第三步：账户状态查询及资料审核

完成商户资料提交，此时可在界面等待查询账户状态，审核一般需要1-7个工作日，审核状态下次进入时即可查看。
![](<Base64-Image-Removed>)

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E7%AC%AC%E5%9B%9B%E6%AD%A5%EF%BC%9A%E8%BF%9B%E8%A1%8C%E8%B4%A6%E6%88%B7%E9%AA%8C%E8%AF%81) 第四步：进行账户验证

进行账户验证（若支付管理员配置为公司法人则跳过该步骤）
![](https://res.wx.qq.com/wxdoc/dist/assets/img/money_transfer.dc4dc50f.png)

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E7%AC%AC%E4%BA%94%E6%AD%A5%EF%BC%9A%E6%89%AB%E7%A0%81%E7%AD%BE%E7%BA%A6) 第五步：扫码签约

扫码完成签约
![](https://res.wx.qq.com/wxdoc/dist/assets/img/Scan_code.da26d889.png)
签约完成后，资料将提交进行审核，开发者可离开当前页面。

注意由于“账户验证”，“签约”不一定会即时完成，开发者可退出页面，后续再次进入将继续延续之前的配置。

等待约1-2个工作日后回到虚拟支付模块，可以看到状态为已签约，或直接进入了商户管理的模块则表示已完成了签约，成功开通了二级商户号。

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E7%AC%AC%E5%85%AD%E6%AD%A5%EF%BC%9A%E8%BF%9B%E5%85%A5%E5%95%86%E6%88%B7%E7%AE%A1%E7%90%86%E5%90%8E%E5%8F%B0%E8%BF%9B%E8%A1%8C%E8%B4%A6%E5%8D%95-%E8%AE%A2%E5%8D%95%E6%9F%A5%E8%AF%A2%EF%BC%8C%E4%BB%A3%E5%B8%81-%E9%81%93%E5%85%B7%E9%85%8D%E7%BD%AE%E5%8F%8A%E8%B5%84%E9%87%91%E7%AE%A1%E7%90%86) 第六步：进入商户管理后台进行账单/订单查询，代币/道具配置及资金管理

当完成了前续动作后，虚拟支付栏目将呈现为全新的商户管理模块，我们搭建了开发者的商户后台，允许开发者在后台进行基础信息配置，代币及道具配置和管理（开发者可以自行选择使用道具或者代币来管理自己的商品）

详细的功能解释如下

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9F%BA%E6%9C%AC%E9%85%8D%E7%BD%AE%EF%BC%9A%E5%8C%85%E5%90%AB%E4%B8%89%E4%B8%AA%E6%A8%A1%E5%9D%97) 基本配置：包含三个模块

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9F%BA%E7%A1%80%E9%85%8D%E7%BD%AE%EF%BC%9A%E5%BC%80%E5%8F%91%E8%80%85%E5%8F%AF%E5%9C%A8%E8%AF%A5%E7%95%8C%E9%9D%A2%E6%9F%A5%E7%9C%8B%E8%87%AA%E8%BA%AB%E5%9F%BA%E7%A1%80%E9%85%8D%E7%BD%AE%E4%BF%A1%E6%81%AF%EF%BC%88%E5%8C%85%E6%8B%ACappid-offerid-appkey%EF%BC%8C%E5%8F%91%E8%B4%A7%E8%AE%A2%E9%98%85%E7%AD%89%EF%BC%89) 基础配置：开发者可在该界面查看自身基础配置信息（包括appid/offerid/appkey，发货订阅等）

![](https://res.wx.qq.com/wxdoc/dist/assets/img/basic_configuration.43630fa6.png)

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E4%BB%A3%E5%B8%81%E9%85%8D%E7%BD%AE%EF%BC%9A%E5%BC%80%E5%8F%91%E8%80%85%E5%8F%AF%E5%9C%A8%E8%AF%A5%E7%95%8C%E9%9D%A2%E9%85%8D%E7%BD%AE%E4%BB%A3%E5%B8%81%EF%BC%8C%E8%BE%93%E5%85%A5%E4%BB%A3%E5%B8%81%E5%90%8D%E7%A7%B0%E5%B9%B6%E4%B8%94%E8%AE%BE%E7%BD%AE%E4%BB%A3%E5%B8%81%E5%85%91%E6%8D%A2%E6%AF%94%E4%BE%8B%E8%BF%9B%E8%A1%8C%E4%BF%9D%E5%AD%98-%EF%BC%88%E8%AF%B7%E6%B3%A8%E6%84%8F%E4%B8%80%E6%97%A6%E5%8F%91%E5%B8%83%E6%97%A0%E6%B3%95%E4%BF%AE%E6%94%B9%EF%BC%81%E8%AF%B7%E6%B3%A8%E6%84%8F%E4%BB%A3%E5%B8%81%E5%90%8D%E7%A7%B0%E7%AC%A6%E5%90%88%E7%9B%B8%E5%85%B3%E6%B3%95%E5%BE%8B%E6%B3%95%E8%A7%84%E8%A6%81%E6%B1%82%EF%BC%89) 代币配置：开发者可在该界面配置代币，输入代币名称并且设置代币兑换比例进行保存 _（请注意一旦发布无法修改！请注意代币名称符合相关法律法规要求）_

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E9%81%93%E5%85%B7%E7%AE%A1%E7%90%86%EF%BC%9A%E5%BC%80%E5%8F%91%E8%80%85%E5%8F%AF%E5%9C%A8%E8%AF%A5%E7%95%8C%E9%9D%A2%E4%B8%8A%E4%BC%A0%E9%81%93%E5%85%B7%E8%87%B3%E5%BC%80%E5%8F%91%E7%89%88%E6%9C%AC%E5%8F%8A%E5%8F%91%E5%B8%83%E8%87%B3%E7%8E%B0%E7%BD%91%E7%89%88%E6%9C%AC%EF%BC%8C%E5%8F%AF%E6%94%AF%E6%8C%81%E7%BC%96%E8%BE%91%E4%BF%9D%E5%AD%98%E5%90%8E%E5%8F%91%E5%B8%83%EF%BC%8C%E5%B9%B6%E4%B8%94%E5%8F%AF%E4%BB%A5%E6%9F%A5%E7%9C%8B%E5%8F%91%E8%B4%A7%E6%8E%A8%E9%80%81%E9%85%8D%E7%BD%AE-%EF%BC%88%E8%BE%93%E5%85%A5%E7%9A%84%E9%81%93%E5%85%B7%E5%90%8D%E7%A7%B0%E9%9C%80%E7%AC%A6%E5%90%88%E7%9B%B8%E5%85%B3%E6%B3%95%E5%BE%8B%E6%B3%95%E8%A7%84%E8%A6%81%E6%B1%82%EF%BC%89) 道具管理：开发者可在该界面上传道具至开发版本及发布至现网版本，可支持编辑保存后发布，并且可以查看发货推送配置 _（输入的道具名称需符合相关法律法规要求）_

![](https://res.wx.qq.com/wxdoc/dist/assets/img/props_management.883d938c.png)

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%B5%84%E9%87%91%E7%AE%A1%E7%90%86%EF%BC%9A) 资金管理：

可在此界面进行账户余额查询和提现，查看每日账单具体情况，包括订单号，开发者收益等，也可以查看账单明细（后期将支持下载功能）

注：待结算金额指的系尚未进行分账的金额，未扣除技术服务费

结算周期:T+3，即开发者完成一笔订单后，资金将会冻结，3日后进行分帐
![](https://res.wx.qq.com/wxdoc/dist/assets/img/money_management.677576ed.png)

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E4%BA%A4%E6%98%93%E8%AE%A2%E5%8D%95%EF%BC%9A) 交易订单：

可在此界面查询订单状况，包括代币/道具订单的交易及发货情况，可进行退款操作（后期将支持下载功能）
![](https://res.wx.qq.com/wxdoc/dist/assets/img/order.36c67222.png)

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%B9%BF%E5%91%8A%E9%87%91%EF%BC%9A) 广告金：

平台将设置广告金政策以支持开发者的广告投放，商户可在虚拟支付--广告金管理界面查看平台向商户赠送的广告金。
![](https://res.wx.qq.com/wxdoc/dist/assets/img/admoney.4cc223f9.png)

# [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#_2-%E5%BC%80%E5%8F%91%E6%B5%81%E7%A8%8B) 2.开发流程

## [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#_2-1-%E6%97%B6%E5%BA%8F%E5%9B%BE) 2.1.时序图

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E9%81%93%E5%85%B7%E7%9B%B4%E8%B4%AD%E6%B5%81%E7%A8%8B%E5%9B%BE) 道具直购流程图

![道具直购流程图](https://res.wx.qq.com/op_res/CA08xx_rPIBmY0wlGgub9sJ6pEjwU-LGSgHgY98PzuxwAyhg9URK7CYg8twAgDqPYIXBVck3vsQJq9XYktk25w)

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E9%81%93%E5%85%B7%E7%9B%B4%E8%B4%AD%E6%B3%A8%E6%84%8F%E4%BA%8B%E9%A1%B9) 道具直购注意事项

- 【7\. 用户支付成功】: 由wx.requestVirtualPayment的success回调触发，可能会丢失，比如微信异常退出
- 【发货推送分支】和【发货轮训分支】至少实现一个，两个结合的方式，可提供更可靠的道具直购体验

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E4%BB%A3%E5%B8%81%E5%85%85%E5%80%BC%E6%B5%81%E7%A8%8B%E5%9B%BE) 代币充值流程图

![代币充值流程图](https://res.wx.qq.com/op_res/CA08xx_rPIBmY0wlGgub9o09BzNzPT68meMfiNtBSoBv6AJ5_HZIz129zZRBPIqfM1iixM3d0LXbTuBy7xVBeg)

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E4%BB%A3%E5%B8%81%E5%85%85%E5%80%BC%E6%B3%A8%E6%84%8F%E4%BA%8B%E9%A1%B9) 代币充值注意事项

- 【10\. 用户支付成功】 : 由wx.requestVirtualPayment的success回调触发，可能会丢失，比如微信异常退出
- 【支付推送分支】和【支付轮训分支】至少实现一个，两个结合起来会更可靠

## [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#_2-2-wx-API) 2.2.wx API

基础库接口 [wx.requestVirtualPayment](https://developers.weixin.qq.com/miniprogram/dev/api/payment/wx.requestVirtualPayment.html) 用于发起米大师虚拟支付，内部会包含下单，拉起支付逻辑

## [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#_2-3-%E6%9C%8D%E5%8A%A1%E5%99%A8API) 2.3.服务器API

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E7%94%A8%E6%88%B7%E6%80%81%E7%AD%BE%E5%90%8D) 用户态签名

签名参数为signature，加在query后面，例如接口地址是：https://api.weixin.qq.com/xpay/query_user_balance?access_token=xxxx，加上签名后则需要传https://api.weixin.qq.com/xpay/query_user_balance?access_token=xxxx&signature=xxx

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%94%AF%E4%BB%98%E7%AD%BE%E5%90%8D) 支付签名

签名参数为pay_sig，加在query后面，例如接口地址是：https://api.weixin.qq.com/xpay/query_user_balance?access_token=xxxx，加上签名后则需要传 [https://api.weixin.qq.com/xpay/query_user_balance?access_token=xxxx&pay_sig=xxx](https://api.weixin.qq.com/xpay/query_user_balance?access_token=xxxx&signature=xxx)

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E9%94%99%E8%AF%AF%E7%A0%81) 错误码

| 错误码 | 描述 |
| --- | --- |
| -1 | 系统错误 |
| 268490001 | openid错误 |
| 268490002 | 请求参数字段错误，具体看errmsg |
| 268490003 | 签名错误 |
| 268490004 | 重复操作（赠送和代币支付和充值广告金相关接口会返回，表示之前的操作已经成功） |
| 268490005 | 订单已经通过cancel_currency_pay接口退款，不支持再退款 |
| 268490006 | 代币的退款/支付操作金额不足 |
| 268490007 | 图片或文字存在敏感内容，禁止使用 |
| 268490008 | 代币未发布，不允许进行代币操作 |
| 268490009 | 用户session_key不存在或已过期，请重新登录 |
| 268490011 | 数据生成中，请稍后调用本接口获取 |
| 268490012 | 批量任务运行中，请等待完成后才能再次运行 |
| 268490013 | 禁止对核销状态的单进行退款 |
| 268490014 | 退款操作进行中，稍后可以使用相同参数重试 |
| 268490015 | 频率限制 |
| 268490016 | 退款的left_fee字段与实际不符，请通过query_order接口查询确认 |
| 268490018 | 广告金充值帐户行业 id 不匹配 |
| 268490019 | 广告金充值帐户 id已绑定其他 appid |
| 268490020 | 广告金充值帐户主体名称错误 |
| 268490021 | 账户未完成进件 |
| 268490022 | 广告金充值账户无效 |
| 268490023 | 广告金余额不足 |
| 268490024 | 广告金充值金额必须大于 0 |

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#query-user-balance) query_user_balance

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80) 地址

https://api.weixin.qq.com/xpay/query_user_balance?access_token=xxx&pay_sig=xxx

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0) 描述

查询用户代币余额

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| openid | string | 用户的openid |
| env | int | 0-正式环境 1-沙箱环境 |
| user_ip | string | 用户ip，例如:1.1.1.1 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |
| balance | int | 代币总余额，包括有价和赠送部分 |
| present_balance | int | 赠送账户的代币余额 |
| sum_save | int | 累计有价货币充值数量 |
| sum_present | int | 累计赠送无价货币数量 |
| sum_balance | int | 历史总增加的代币金额 |
| sum_cost | int | 历史总消耗代币金额 |
| first_save_flag | bool | 是否满足首充活动标记。0:不满足。1:满足 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%A4%87%E6%B3%A8) 备注

1. 需要用户态签名与支付签名

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#currency-pay) currency_pay

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-2) 地址

https://api.weixin.qq.com/xpay/currency_pay?access_token=xxx&pay_sig=xxx&signature=xxx

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-2) 描述

扣减代币（一般用于代币支付）

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-2) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-2) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| openid | string | 用户的openid |
| env | int | 0-正式环境 1-沙箱环境 |
| user_ip | string | 用户ip，例如:1.1.1.1 |
| amount | int | 支付的代币数量 |
| order_id | string | 订单号 |
| payitem | string | 物品信息。记录到账户流水中。如:\[{"productid":"物品id", "unit_price": 单价, "quantity": 数量}\] |
| remark | string | 备注 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-2) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |
| order_id | string | 订单号 |
| balance | int | 总余额，包括有价和赠送部分 |
| used_present_amount | int | 使用赠送部分的代币数量 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%A4%87%E6%B3%A8-2) 备注

1. 使用用户态签名与支付签名

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#query-order) query_order

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-3) 地址

https://api.weixin.qq.com/xpay/query_order?access_token=xxx&pay_sig=xxx

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-3) 描述

查询创建的订单（现金单，非代币单）

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-3) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-3) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| openid | string | 用户的openid |
| env | int | 0-正式环境 1-沙箱环境 |
| order_id | string | 创建的订单号 |
| wx_order_id | string | 微信内部单号(与order_id二选一) |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-3) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |
| order | object | 订单信息 |

其中order的内容如下：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| order_id | string | 订单号 |
| create_time | int | 创建时间 |
| update_time | int | 更新时间 |
| status | int | 当前状态 0-订单初始化（未创建成功，不可用于支付）1-订单创建成功 2-订单已经支付，待发货 3-订单发货中 4-订单已发货 5-订单已经退款 6-订单已经关闭（不可再使用） 7-订单退款失败 8-用户退款完成 9-回收广告金完成 10-分账回退完成 |
| biz_type | int | 业务类型0-短剧 |
| order_fee | int | 订单金额，单位分 |
| coupon_fee | int | 订单优惠金额，单位分(暂无此字段) |
| paid_fee | int | 用户支付金额 |
| order_type | int | 订单类型0-支付单 1-退款单 |
| refund_fee | int | 当类型为退款单时表示退款金额，单位分 |
| paid_time | int | 支付/退款时间，unix秒级时间戳 |
| provide_time | int | 发货时间 |
| biz_meta | string | 订单创建时传的信息 |
| env_type | int | 环境类型1-现网 2-沙箱 |
| token | string | 下单时米大师返回的token |
| left_fee | int | 支付单类型时表示此单经过退款还剩余的金额，单位分 |
| wx_order_id | string | 微信内部单号 |
| channel_order_id | string | 渠道单号，为用户微信支付详情页面上的商户单号 |
| wxpay_order_id | string | 微信支付交易单号，为用户微信支付详情页面上的交易单号 |
| sett_time | int | 结算时间的秒级时间戳，大于0表示结算成功 |
| sett_state | int | 结算状态0-未开始结算 1-结算中 2-结算成功 3-待结算（与0相同） |
| platform_fee_fen | int | 虚拟支付技术服务费，单位为分；sett_state = 2时返回 |
| cps_fee_fen | int | 公众号、视频号平台的cps服务费，单位为分；sett_state = 2时返回 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%A4%87%E6%B3%A8-3) 备注

1. 使用支付签名

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#cancel-currency-pay) cancel_currency_pay

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-4) 地址

https://api.weixin.qq.com/xpay/cancel_currency_pay?access_token=xxx&pay_sig=xxx

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-4) 描述

代币支付退款(currency_pay接口的逆操作)

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-4) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-4) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| openid | string | 用户的openid |
| env | int | 0-正式环境 1-沙箱环境 |
| user_ip | string | 用户ip，例如1.1.1.1 |
| pay_order_id | string | 代币支付(调用currency_pay接口时)时传的order_id |
| order_id | string | 本次退款单的单号 |
| amount | int | 退款金额 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-4) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |
| order_id | string | 退款订单号 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%A4%87%E6%B3%A8-4) 备注

1. 需要支付签名与用户态签名

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#notify-provide-goods) notify_provide_goods

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-5) 地址

https://api.weixin.qq.com/xpay/notify_provide_goods?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-5) 描述

通知已经发货完成（只能通知现金单）,正常通过xpay_goods_deliver_notify消息推送返回成功就不需要调用这个api接口。这个接口用于异常情况推送不成功时手动将单改成已发货状态

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-5) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-5) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| order_id | string | 下单时传的单号 |
| wx_order_id | string | 微信内部单号(与order_id二选一) |
| env | int | 0-正式环境 1-沙箱环境 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-5) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#present-currency) present_currency

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-6) 地址

https://api.weixin.qq.com/xpay/present_currency?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-6) 描述

代币赠送接口，由于目前不支付按单号查赠送单的功能，所以当需要赠送的时候可以一直重试到返回0或者返回268490004（重复操作）为止

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-6) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-6) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| openid | string | 用户的openid |
| env | int | 0-正式环境 1-沙箱环境 |
| order_id | string | 赠送单号 |
| amount | int | 赠送金额 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-6) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |
| balance | int | 赠送后用户的代币余额 |
| order_id | string | 赠送单号 |
| present_balance | int | 用户收到的总赠送金额 |

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#download-bill) download_bill

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-7) 地址

https://api.weixin.qq.com/xpay/download_bill?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-7) 描述

用于下载小程序账单，第一次调用触发生成下载url，可以间隔轮训来获取最终生成的下载url。

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-7) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-7) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| begin_ds | int | 起始时间（如20230801） |
| end_ds | int | 截止时间（如20230810） |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-7) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |
| url | string | 下载地址（有效时间为半小时，失效后需重新获取） |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%A4%87%E6%B3%A8-5) 备注

1. 使用支付签名

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#refund-order) refund_order

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-8) 地址

https://api.weixin.qq.com/xpay/refund_order?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-8) 描述

对使用jsapi接口下的单进行退款，此接口只是启动退款任务成功，启动后需要调用query_order接口来查询退款单状态，等状态变成退款完成后即为最终成功

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-8) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-8) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| openid | string | 下单时的用户openid |
| order_id | string | 下单时的单号，即jsapi接口传入的OutTradeNo，与wx_order_id字段二选一 |
| wx_order_id | string | 支付单对应的微信侧单号，与order_id字段二选一 |
| refund_order_id | string | 本次退款时需要传的单号，长度为\[8,32\]，字符只允许使用字母、数字、'_'、'-' |
| left_fee | int | 当前单剩余可退金额，单位分，可以通过调用query_order接口查到 |
| refund_fee | int | 本次退款金额，单位分，需要(0,left_fee\] |
| biz_meta | string | 商家自定义数据，传入后可在query_order接口查询时原样返回，长度需要\[0,1024\] |
| refund_reason | string | 退款原因，当前仅支持以下值 0-暂无描述 1-产品问题，影响使用或效果不佳 2-售后问题，无法满足需求 3-意愿问题，用户主动退款 4-价格问题 5:其他原因 |
| req_from | string | 退款来源，当前仅支持以下值 1-人工客服退款，即用户电话给客服，由客服发起退款流程 2-用户自己发起退款流程 3-其它 |
| env | int | 0-正式环境 1-沙箱环境 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-8) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |
| refund_order_id | string | 退款单号 |
| refund_wx_order_id | string | 退款单的微信侧单号 |
| pay_order_id | string | 该退款单对应的支付单单号 |
| pay_wx_order_id | string | 该退款单对应的支付单微信侧单号 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%A4%87%E6%B3%A8-6) 备注

1. 使用支付签名

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#create-withdraw-order) create_withdraw_order

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-9) 地址

https://api.weixin.qq.com/xpay/create_withdraw_order?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-9) 描述

创建提现单

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-9) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-9) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| withdraw_no | string | 提现单单号，长度为\[8,32\]，字符只允许使用字母、数字、'_'、'-' |
| withdraw_amount | string | 提现的金额，单位元，例如提现1分钱请使用0.01，允许不传，不传的情况下表示全额提现 |
| env | int | 0-正式环境 1-沙箱环境 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-9) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |
| withdraw_no | string | 提现单号 |
| wx_withdraw_no | string | 提现单的微信侧单号 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%A4%87%E6%B3%A8-7) 备注

1. 使用支付签名

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#query-withdraw-order) query_withdraw_order

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-10) 地址

https://api.weixin.qq.com/xpay/query_withdraw_order?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-10) 描述

创建提现单

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-10) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-10) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| withdraw_no | string | 提现单单号 |
| env | int | 0-正式环境 1-沙箱环境 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-10) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |
| withdraw_no | string | 提现单号 |
| status | int | 提现单的微信侧单号1-创建成功，提现中 2-提现成功 3-提现失败 |
| withdraw_amount | string | 提现金额 |
| wx_withdraw_no | string | 提现单的微信侧单号 |
| withdraw_success_timestamp | string | 提现单成功的秒级时间戳 |
| create_time | string | 提现单创建时间 |
| fail_reason | string | 提现失败的原因 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%A4%87%E6%B3%A8-8) 备注

1. 使用支付签名

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#start-upload-goods) start_upload_goods

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-11) 地址

https://api.weixin.qq.com/xpay/start_upload_goods?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-11) 描述

启动批量上传道具任务，一次仅支持上传一个道具，多个道具需分多次请求

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-11) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-11) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| upload_item | array | 上传的商品列表 |
| env | int | 0-正式环境 1-沙箱环境 |

upload_item的每一项内容如下：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| id | string | 道具id，长度(0,64\]，字符只允许使用字母、数字、'_'、'-' |
| name | string | 道具名称，长度(0，20\] |
| price | int | 道具单价，单位分，需要大于0 |
| remark | string | 道具备注，长度(0,1024\] |
| item_url | string | 道具图片的url地址，当前仅支持jpg,png等格式 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-11) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%A4%87%E6%B3%A8-9) 备注

1. 使用支付签名

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#query-upload-goods) query_upload_goods

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-12) 地址

https://api.weixin.qq.com/xpay/query_upload_goods?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-12) 描述

查询批量上传道具任务

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-12) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-12) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| env | int | 0-正式环境 1-沙箱环境 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-12) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |
| upload_item | array | 上传的道具列表 |
| status | int | 0-无任务在运行 1-任务运行中 2-上传失败或部分失败（上传任务已经完成） 3-上传成功 |

upload_item的每一项内容如下：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| id | string | 道具id |
| name | string | 道具名称 |
| price | int | 道具单价，单位分 |
| remark | string | 道具备注 |
| item_url | string | 道具图片的url地址（微信转存后） |
| upload_status | int | 0-上传中 1-id已经存在 2-上传成功 3-上传失败 |
| errmsg | string | 上传失败的原因 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%A4%87%E6%B3%A8-10) 备注

1. 使用支付签名

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#start-publish-goods) start_publish_goods

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-13) 地址

https://api.weixin.qq.com/xpay/start_publish_goods?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-13) 描述

启动批量发布道具任务，一次仅支持发布一个道具，多个道具需分多次请求

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-13) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-13) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| publish_item | array | 发布的商品列表 |
| env | int | 0-正式环境 1-沙箱环境 |

publish_item的每一项内容如下：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| id | string | 道具id，添加到开发环境时传的道具id |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-13) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%A4%87%E6%B3%A8-11) 备注

1. 使用支付签名

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#query-publish-goods) query_publish_goods

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-14) 地址

https://api.weixin.qq.com/xpay/query_publish_goods?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-14) 描述

查询批量发布道具任务

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-14) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-14) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| env | int | 0-正式环境 1-沙箱环境 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-14) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |
| publish_item | array | 发布的道具列表 |
| status | int | 0-无任务在运行 1-任务运行中 2-上传失败或部分失败（上传任务已经完成） 3-上传成功 |

upload_item的每一项内容如下：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| id | string | 道具id |
| publish_status | int | 0-上传中 1-id已经存在 2-发布成功 3-发布失败 |
| errmsg | string | 发布失败的原因 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%A4%87%E6%B3%A8-12) 备注

1. 使用支付签名

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#query-biz-balance) query_biz_balance

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-15) 地址

https://api.weixin.qq.com/xpay/query_biz_balance?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-15) 描述

查询商家账户里的可提现余额

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-15) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-15) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| env | int | 0-正式环境 1-沙箱环境（仅作为签名校验，查询的结果都是正式环境的） |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-15) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |
| balance_available | object | 可提现余额 |

其中balance_available内容如下：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| amount | string | 可提现余额，单位元 |
| currency_code | string | 币种（一般为CNY） |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%A4%87%E6%B3%A8-13) 备注

1. 使用支付签名

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#query-transfer-account) query_transfer_account

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-16) 地址

https://api.weixin.qq.com/xpay/query_transfer_account?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-16) 描述

查询广告金充值账户

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-16) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-16) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| env | Number | 0-正式环境 1-沙箱环境（仅作为签名校验，查询的结果都是正式环境的） |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-16) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| acct_list | Array | 广告金充值账户列表 |
| errcode | Number | 错误码 |
| errmsg | String | 错误信息 |

acct_list的每一项内容如下：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| transfer_account_name | String | 充值账户名称 |
| transfer_account_uid | Number | 充值账户 uid |
| transfer_account_agency_id | Number | 充值账户服务商账号 id |
| transfer_account_agency_name | String | 充值账户服务商账号名称 |
| state | Number | 0-待审核，1-审核通过，2-审核驳回 |
| bind_result | Number | 1-绑定成功，2-绑定失败 |
| error_msg | String | 错误信息 |

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#query-adver-funds) query_adver_funds

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-17) 地址

https://api.weixin.qq.com/xpay/query_adver_funds?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-17) 描述

查询广告金发放记录

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-17) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-17) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| page | Number | 查询页码，不小于 1 |
| page_size | Number | 每页记录数量 |
| filter | Object | 查询过滤条件 |
| env | Number | 0-正式环境 1-沙箱环境（仅作为签名校验，查询的结果都是正式环境的） |

filter的每一项内容如下：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| settle_begin | Number | 查询结算周期开始时间，unix秒级时间戳 |
| settle_end | Number | 查询结算周期结束时间，unix秒级时间戳 |
| fund_type | Number | (可选)广告金发放原因， 0:通用赠送，1:广告激励，2:定向激励 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-17) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| adver_funds_list | Array | 广告金发放记录列表 |
| total_page | Number | 查询命中总的页数 |
| errcode | Number | 错误码 |
| errmsg | String | 错误信息 |

adver_funds_list的每一项内容如下：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| settle_begin | Number | 结算周期开始时间，unix秒级时间戳 |
| settle_end | Number | 查算周期结束时间，unix秒级时间戳 |
| total_amount | Number | 发放广告金金额，单位分 |
| remain_amount | Number | 剩余可用广告金金额，单位分 |
| expire_time | Number | 广告金过期时间，unix秒级时间戳 |
| fund_type | Number | 广告金发放原因， 0:通用赠送，1:广告激励，2:定向激励 |
| fund_id | String | 广告金发放ID |

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#create-funds-bill) create_funds_bill

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-18) 地址

https://api.weixin.qq.com/xpay/create_funds_bill?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-18) 描述

充值广告金

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-18) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-18) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| transfer_amount | Number | 充值金额，单位分 |
| transfer_account_uid | Number | 充值账户 uid |
| transfer_account_name | String | 充值账户名称 |
| transfer_account_agency_id | Number | 充值账户服务商账号 id |
| request_id | String | 用户定义每一次请求的唯一 id，相同 id 的不同请求视为重复请求(不超过 1024 个字符) |
| settle_begin | Number | 充值所使用的广告金对应的结算周期开始时间，unix秒级时间戳 |
| settle_end | Number | 充值所使用的广告金对应的结算周期结束时间，unix秒级时间戳 |
| env | Number | 0-正式环境 1-沙箱环境（仅作为签名校验，查询的结果都是正式环境的） |
| authorize_advertise | Number | 是否授权广告数据, 0:否，1:是 |
| fund_type | Number | 广告金发放原因， 0:通用赠送，1:广告激励，2:定向激励 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-18) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | Number | 错误码 |
| errmsg | String | 错误信息 |
| bill_id | String | 充值单 id |

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#bind-transfer-accout) bind_transfer_accout

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-19) 地址

https://api.weixin.qq.com/xpay/bind_transfer_accout?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-19) 描述

绑定广告金充值账户

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-19) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-19) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| transfer_account_uid | Number | 充值账户 uid |
| transfer_account_org_name | String | 充值账户主体名称 |
| env | Number | 0-正式环境 1-沙箱环境（仅作为签名校验，查询的结果都是正式环境的） |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-19) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | Number | 错误码 |
| errmsg | String | 错误信息 |

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#query-funds-bill) query_funds_bill

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-20) 地址

https://api.weixin.qq.com/xpay/query_funds_bill?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-20) 描述

查询广告金充值记录

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-20) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-20) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| page | Number | 查询页码，不小于 1 |
| page_size | Number | 每页记录数量 |
| filter | Object | 查询过滤条件 |
| env | Number | 0-正式环境 1-沙箱环境（仅作为签名校验，查询的结果都是正式环境的） |

filter的每一项内容如下：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| oper_time_begin | Number | 查询充值开始时间，unix秒级时间戳 |
| oper_time_end | Number | 查询充值结束时间，unix秒级时间戳 |
| bill_id | String | (可选)广告金充值单 ID |
| request_id | String | (可选)调用接口 create_funds_bill 进行广告金充值时传入的 request_id 字段 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-20) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| bill_list | Array | 广告金充值记录列表 |
| total_page | Number | 查询命中总的页数 |
| errcode | Number | 错误码 |
| errmsg | String | 错误信息 |

bill_list的每一项内容如下：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| bill_id | String | 充值单 ID |
| oper_time | Number | 充值时间，unix秒级时间戳 |
| settle_begin | Number | 对应广告金结算周期开始时间，unix秒级时间戳 |
| settle_end | Number | 对应广告金结算周期结束时间，unix秒级时间戳 |
| fund_id | String | 对应广告金ID |
| transfer_account_name | String | 充值账户 |
| transfer_account_uid | Number | 充值账户UID |
| transfer_amount | Number | 充值金额，单位：分 |
| status | Number | 广告金充值状态：0-充值中，1-充值成功，2-充值失败 |
| request_id | String | 调用接口 create_funds_bill 进行广告金充值时传入的 request_id 字段 |

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#query-recover-bill) query_recover_bill

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-21) 地址

https://api.weixin.qq.com/xpay/query_recover_bill?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-21) 描述

查询广告金回收记录

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-21) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-21) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| page | Number | 查询页码，不小于 1 |
| page_size | Number | 每页记录数量 |
| filter | Object | 查询过滤条件 |
| env | Number | 0-正式环境 1-沙箱环境（仅作为签名校验，查询的结果都是正式环境的） |

filter的每一项内容如下：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| recover_time_begin | Number | 查询回收开始时间，unix秒级时间戳 |
| recover_time_end | Number | 查询回收结束时间，unix秒级时间戳 |
| bill_id | String | (可选)广告金回收单 ID |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-21) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| bill_list | Array | 广告金回收记录列表 |
| total_page | Number | 查询命中总的页数 |
| errcode | Number | 错误码 |
| errmsg | String | 错误信息 |

bill_list的每一项内容如下：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| bill_id | String | 回收单 ID |
| recover_time | Number | 回收时间，unix秒级时间戳 |
| settle_begin | Number | 结算周期开始时间，unix秒级时间戳 |
| settle_end | Number | 查算周期结束时间，unix秒级时间戳 |
| fund_id | String | 对应的发放广告金ID |
| recover_account_name | String | 回收广告金账户 |
| recover_amount | Number | 回收金额，单位：分 |
| refund_order_list | Array | 对应的退款订单 id |

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#get-complaint-list) get_complaint_list

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-22) 地址

https://api.weixin.qq.com/xpay/get_complaint_list?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-22) 描述

获取投诉列表

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-22) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-22) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| env | int | 0-正式环境 1-沙箱环境（仅作为签名校验，查询的结果都是正式环境的） |
| begin_date | string | 筛选开始时间，格式为yyyy-mm-dd,如“2023-01-01” |
| end_date | string | 筛选结束时间，格式为yyyy-mm-dd,如“2023-01-01” |
| offset | int | 筛选偏移，从0开始 |
| limit | int | 筛选最多返回条数 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-22) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |
| total | int | 总条数 |
| complaints | array | 投诉列表 |

其中complaints内容如下：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| complaint_id | string | 投诉id |
| complaint_time | string | 投诉时间 格式为yyyy-mm-dd'T'HH:MM:ssXXX，其中XXX为时区偏移，例如：2023-11-28T11:11:49+08:00 |
| complaint_detail | string | 投诉内容 |
| complaint_state | string | 投诉状态 PENDING-待处理；PROCESSING-处理中；PROCESSED-已处理完成 |
| payer_phone | string | 投诉人联系方式 |
| payer_openid | string | 投诉人在商户AppID下的唯一标识 |
| complaint_order_info | array | 投诉单关联订单信息 |
| complaint_full_refunded | bool | 投诉单下所有订单是否已全部全额退款 |
| incoming_user_response | bool | 投诉单是否有待回复的用户留言 |
| user_complaint_times | int | 用户投诉次数。用户首次发起投诉记为1次，用户每有一次继续投诉就加1 |
| complaint_media_list | array | 户上传的投诉相关资料，包括图片凭证等 |
| problem_description | string | 用户发起投诉前选择的faq标题 |
| problem_type | string | 问题类型为申请退款的单据是需要最高优先处理的单据。REFUND: 申请退款；SERVICE_NOT_WORK: 服务权益未生效；OTHERS: 其他类型 |
| apply_refund_amount | int | 当问题类型为申请退款时, 有值, (单位:分) |
| user_tag_list | array | 用户标签列表，每一项内容为string。TRUSTED: 此类用户满足极速退款条件；HIGH_RISK: 高风险投诉，请按照运营要求优先妥善处理 |
| service_order_info | array | 投诉单关联服务单信息 |

其中complaint_order_info的每一期内容为：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| transaction_id | string | 投诉单关联的微信支付交易单号 |
| out_trade_no | string | 渠道单号，query_order接口返回的channel_order_id |
| amount | int | 订单金额，单位（分） |
| wxa_out_trade_no | string | 商户单号，商家在拉走支付时传的单号 |
| wx_order_id | string | 小程序侧单号 |

其中complaint_media_list每一项内容为：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| media_type | string | 体文件对应的业务类型，USER_COMPLAINT_IMAGE: 用户提交投诉时上传的图片凭证；OPERATION_IMAGE: 用户、商户、微信支付客服在协商解决投诉时，上传的图片凭证 |
| media_url | array | 每一项的内容为string，媒体文件请求url |

其中service_order_info每一项内容为：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| order_id | string | 微信支付服务订单号，每个微信支付服务订单号与商户号下对应的商户服务订单号一一对应 |
| out_order_no | string | 商户系统内部服务订单号（不是交易单号），与创建订单时一致 |
| state | string | 此处上传的是用户发起投诉时的服务单状态，不会实时更新。DOING: 服务订单进行中；REVOKED: 服务订单已取消；WAITPAY: 服务订单待支付；DONE: 服务订单已完成 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%A4%87%E6%B3%A8-14) 备注

1. 使用支付签名

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#get-complaint-detail) get_complaint_detail

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-23) 地址

https://api.weixin.qq.com/xpay/get_complaint_detail?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-23) 描述

获取投诉详情

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-23) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-23) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| env | int | 0-正式环境 1-沙箱环境（仅作为签名校验，查询的结果都是正式环境的） |
| complaint_id | string | 投诉id，get_complaint_list接口返回 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-23) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |
| complaint | object | 与get_complaint_list接口的complaints一致 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%A4%87%E6%B3%A8-15) 备注

1. 使用支付签名

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#get-negotiation-history) get_negotiation_history

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-24) 地址

https://api.weixin.qq.com/xpay/get_negotiation_history?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-24) 描述

获取协商历史

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-24) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-24) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| env | int | 0-正式环境 1-沙箱环境（仅作为签名校验，查询的结果都是正式环境的） |
| complaint_id | string | 投诉id，get_complaint_list接口返回 |
| offset | int | 筛选偏移，从0开始 |
| limit | int | 筛选最多返回条数 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-24) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |
| total | int | 总条数 |
| history | array | 协商历史 |

其中history的每一项内容为：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| log_id | string | 操作流水号 |
| operator | string | 当前投诉协商记录的操作人 |
| operate_time | string | 当前操作时间，格式为yyyy-mm-dd'T'HH:MM:ssXXX，其中XXX为时区偏移，例如：2023-11-28T11:11:49+08:00 |
| operate_type | string | 当前投诉协商记录的操作类型，对应枚举： USER_CREATE_COMPLAINT: 用户提交投诉 USER_CONTINUE_COMPLAINT: 用户继续投诉 USER_RESPONSE: 用户留言 PLATFORM_RESPONSE: 平台留言 MERCHANT_RESPONSE: 商户留言 MERCHANT_CONFIRM_COMPLETE: 商户申请结单 USER_CREATE_COMPLAINT_SYSTEM_MESSAGE: 用户提交投诉系统通知 COMPLAINT_FULL_REFUNDED_SYSTEM_MESSAGE: 投诉单发起全额退款系统通知 USER_CONTINUE_COMPLAINT_SYSTEM_MESSAGE: 用户继续投诉系统通知 USER_REVOKE_COMPLAINT: 用户主动撤诉（只存在于历史投诉单的协商历史中） USER_COMFIRM_COMPLAINT: 用户确认投诉解决（只存在于历史投诉单的协商历史中） PLATFORM_HELP_APPLICATION: 平台催办 USER_APPLY_PLATFORM_HELP: 用户申请平台协助 MERCHANT_APPROVE_REFUND: 商户同意退款申请 MERCHANT_REFUSE_RERUND: 商户拒绝退款申请, 此时操作内容里展示拒绝原因 USER_SUBMIT_SATISFACTION: 用户提交满意度调查结果,此时操作内容里会展示满意度分数 SERVICE_ORDER_CANCEL: 服务订单已取消 SERVICE_ORDER_COMPLETE: 服务订单已完成 COMPLAINT_PARTIAL_REFUNDED_SYSTEM_MESSAGE: 投诉单发起部分退款系统通知 COMPLAINT_REFUND_RECEIVED_SYSTEM_MESSAGE: 投诉单退款到账系统通知 COMPLAINT_ENTRUSTED_REFUND_SYSTEM_MESSAGE: 投诉单受托退款系统通知 |
| operate_details | string | 当前投诉协商记录的具体内容 |
| complaint_media_list | array | 投诉单执行操作时上传的资料凭证，包含用户、商户、微信支付客服等角色操作 |

其中complaint_media_list每一项的内容如下：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| media_type | string | 媒体文件对应的业务类型，USER_COMPLAINT_IMAGE: 用户提交投诉时上传的图片凭证；OPERATION_IMAGE: 用户、商户、微信支付客服在协商解决投诉时，上传的图片凭证 |
| media_url | array | 每一项的内容为string，媒体文件请求url |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%A4%87%E6%B3%A8-16) 备注

1. 使用支付签名

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#response-complaint) response_complaint

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-25) 地址

https://api.weixin.qq.com/xpay/response_complaint?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-25) 描述

回复用户

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-25) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-25) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| env | int | 0-正式环境 1-沙箱环境（仅作为签名校验，查询的结果都是正式环境的） |
| complaint_id | string | 投诉id，get_complaint_list接口返回 |
| response_content | string | 回复内容 |
| response_images | array | 每一项的内容为string，传upload_vp_file接口返回的file_id |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-25) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%A4%87%E6%B3%A8-17) 备注

1. 使用支付签名

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#complete-complaint) complete_complaint

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-26) 地址

https://api.weixin.qq.com/xpay/complete_complaint?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-26) 描述

完成投诉处理

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-26) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-26) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| env | int | 0-正式环境 1-沙箱环境（仅作为签名校验，查询的结果都是正式环境的） |
| complaint_id | string | 投诉id，get_complaint_list接口返回 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-26) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%A4%87%E6%B3%A8-18) 备注

1. 使用支付签名

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#upload-vp-file) upload_vp_file

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-27) 地址

https://api.weixin.qq.com/xpay/upload_vp_file?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-27) 描述

上传媒体文件（如图片，凭证等）

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-27) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-27) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| env | int | 0-正式环境 1-沙箱环境（仅作为签名校验，查询的结果都是正式环境的） |
| base64_img | string | 经base64编码后的图片内容，使用这个字段最多只能传1m的图片，超过1m请使用img_url字段 |
| img_url | string | 图片url，需要能直接下载，不能是返回302等返回码的地址，最高允许传2m图片（优先使用img_url） |
| file_name | string | 图片名称 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-27) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |
| file_id | string | 返回文件id |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%A4%87%E6%B3%A8-19) 备注

1. 使用支付签名

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#get-upload-file-sign) get_upload_file_sign

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-28) 地址

https://api.weixin.qq.com/xpay/get_upload_file_sign?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-28) 描述

获取微信支付反馈投诉图片的签名头部

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-28) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-28) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| env | int | 0-正式环境 1-沙箱环境（仅作为签名校验，查询的结果都是正式环境的） |
| wxpay_url | string | 微信支付的图片地址格式为"https://api.mch.weixin.qq.com/v3/merchant-service/images/{xxxxxx}" |
| convert_cos | bool | 是否转存到cos，转存后可以获得图片的临时下载地址，30分钟有效 |
| complaint_id | string | 对应的反馈投诉id |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-28) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | int | 错误码 |
| errmsg | string | 错误信息 |
| sign | string | 返回微信支付图片请求的Authorization头部值，具体使用方法可查看备注 |
| cos_url | string | 当convert_cos为true时才有意义，返回转存后的url地址，30分钟有效 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%A4%87%E6%B3%A8-20) 备注

1.使用支付签名

2.微信支付的图片资源下载需要在http请求的时候必填以下3个头部信息，否则会报错

- Authorization，签名验证，由本接口的sign返回
- Accept，值需要是"application/json"
- User-Agent，UA不能为空

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#download-adverfunds-order) download_adverfunds_order

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%9C%B0%E5%9D%80-29) 地址

https://api.weixin.qq.com/xpay/download_adverfunds_order?access_token=xxx&pay_sig=xxx

##### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8F%8F%E8%BF%B0-29) 描述

下载广告金对应的商户订单信息

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E6%96%B9%E6%B3%95-29) 请求方法

POST ， 请求参数为json字符串，Content-Type为application/json

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-29) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| fund_id | String | 广告金发放ID |
| env | Number | 0-正式环境 1-沙箱环境（仅作为签名校验，查询的结果都是正式环境的） |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-29) 返回参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| errcode | Number | 错误码 |
| errmsg | String | 错误信息 |
| url | String | 订单下载链接 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%A4%87%E6%B3%A8-21) 备注

1. 当前仅支持通用赠送广告金对应订单下载
2. 第一次调用触发生成下载url，可以间隔轮训来获取最终生成的下载url。

## [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%B6%88%E6%81%AF%E6%8E%A8%E9%80%81) 消息推送

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8E%A8%E9%80%81%E5%93%8D%E5%BA%94%E6%A0%BC%E5%BC%8F%E8%AF%B4%E6%98%8E) 推送响应格式说明

注：如果推送响应格式不对，微信会重新推送，最多试15次

目前支持三种方式：

1. 【推荐】文档中列的ErrCode方式

推送内容为xml格式时，响应内容需要是xml格式

```text
<xml><Errcode>0</ErrCode><ErrMsg><![CDATA[success]]></ErrMsg></xml>
```

同理推送内容为json格式时，响应内容需要是json格式

```text
{"ErrCode":0,"ErrMsg":"success"}
```

2. 相应内容为空 或者success，表示成功（等价于第一种的ErrCode = 0）

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E9%81%93%E5%85%B7%E5%8F%91%E8%B4%A7%E6%8E%A8%E9%80%81xpay-goods-deliver-notify) 道具发货推送xpay_goods_deliver_notify

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-30) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| ToUserName | String | 小程序原始ID |
| FromUserName | String | 该事件消息的openid，道具发货场景固定为微信官方的openid |
| CreateTime | Number | 消息发送时间 |
| MsgType | String | 消息类型，固定为：event |
| Event | String | 事件类型<br> xpay_goods_deliver_notify |
| OpenId | String | 用户openid |
| OutTradeNo | String | 业务订单号 |
| Env | Number | 环境配置<br> 0：现网环境（也叫正式环境）<br> 1：沙箱环境 |
| WeChatPayInfo | Object | 微信支付信息 非微信支付渠道可能没有 |
| GoodsInfo | Object | 道具参数信息 |
| TeamInfo | Object | 拼团信息 |

WeChatPayInfo内容如下：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| MchOrderNo | String | 微信支付商户单号 |
| TransactionId | String | 交易单号（微信支付订单号） |
| PaidTime | Number | 用户支付时间，Linux秒级时间戳 |

GoodsInfo内容如下：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| ProductId | String | 道具ID |
| Quantity | Number | 数量 |
| OrigPrice | Number | 物品原始价格 （单位：分） |
| ActualPrice | Number | 物品实际支付价格（单位：分） |
| Attach | String | 透传信息 |

TeamInfo内容如下：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| ActivityId | String | 活动id |
| TeamId | String | 团id |
| TeamType | Number | 团类型1-支付全部，拼成退款 |
| TeamAction | 0-创团 1-参团 |  |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-30) 返回参数

| 字段 | 类型 | 是否必填 | 说明 |
| --- | --- | --- | --- |
| ErrCode | Number | 是 | 发送状态。0：成功，其他：失败 todo |
| ErrMsg | String | 否 | 错误原因，用于调试。在errcode非0 的情况下可以返回 |

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E4%BB%A3%E5%B8%81%E6%94%AF%E4%BB%98%E6%8E%A8%E9%80%81xpay-coin-pay-notify) 代币支付推送xpay_coin_pay_notify

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-31) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| ToUserName | String | 小程序原始ID |
| FromUserName | String | 该事件消息的openid，道具发货场景固定为微信官方的openid |
| CreateTime | Number | 消息发送时间 |
| MsgType | String | 消息类型，固定为：event |
| Event | String | 事件类型<br>xpay_coin_pay_notify |
| OpenId | String | 用户openid |
| OutTradeNo | String | 业务订单号 |
| Env | Number | 环境配置0：现网环境（也叫正式环境） 1：沙箱环境 |
| WeChatPayInfo | Object | 微信支付信息 非微信支付渠道可能没有 |
| CoinInfo | Object | 代币参数信息 |

WeChatPayInfo内容如下：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| MchOrderNo | String | 微信支付商户单号 |
| TransactionId | String | 交易单号（微信支付订单号） |
| PaidTime | Number | 用户支付时间，Linux秒级时间戳 |

CoinInfo内容如下：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| Quantity | Number | 数量 |
| OrigPrice | Number | 物品原始价格 （单位：分） |
| ActualPrice | Number | 物品实际支付价格（单位：分） |
| Attach | String | 透传信息 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-31) 返回参数

| 字段 | 类型 | 是否必填 | 说明 |
| --- | --- | --- | --- |
| ErrCode | Number | 是 | 发送状态。0：成功，其他：失败 todo |
| ErrMsg | String | 否 | 错误原因，用于调试。在errcode非0 的情况下可以返回 |

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E9%80%80%E6%AC%BE%E6%8E%A8%E9%80%81xpay-refund-notify) 退款推送xpay_refund_notify

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-32) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| ToUserName | String | 小程序原始ID |
| FromUserName | String | 该事件消息的openid，道具发货场景固定为微信官方的openid |
| CreateTime | Number | 消息发送时间 |
| MsgType | String | 消息类型，固定为：event |
| Event | String | 事件类型<br>xpay_refund_notify |
| OpenId | String | 用户openid |
| WxRefundId | String | 微信退款单号 |
| MchRefundId | String | 商户退款单号 |
| WxOrderId | String | 退款单对应支付单的微信单号 |
| MchOrderId | String | 退款单对应支付单的商户单号 |
| RefundFee | Number | 退款金额，单位分 |
| RetCode | Number | 退款结果，0为成功，非0为失败 |
| RetMsg | String | 退款结果详情，失败时为退款失败的原因 |
| RefundStartTimestamp | Number | 开始退款时间，秒级时间戳 |
| RefundSuccTimestamp | Number | 结束退款时间，秒级时间戳 |
| WxpayRefundTransactionId | String | 退款单的微信支付单号 |
| RetryTimes | Number | 重试次数，从0开始。重试间隔为2 4 8 16...最多15次 |
| TeamInfo | Object | 拼团信息 |

TeamInfo内容如下：

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| ActivityId | String | 活动id |
| TeamId | String | 团id |
| TeamType | Number | 团类型1-支付全部，拼成退款 |
| TeamAction | 0-创团 1-参团 |  |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-32) 返回参数

| 字段 | 类型 | 是否必填 | 说明 |
| --- | --- | --- | --- |
| ErrCode | Number | 是 | 发送状态。0：成功，其他：失败 todo |
| ErrMsg | String | 否 | 错误原因，用于调试。在errcode非0 的情况下可以返回 |

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E7%94%A8%E6%88%B7%E6%8A%95%E8%AF%89%E6%8E%A8%E9%80%81xpay-complaint-notify) 用户投诉推送xpay_complaint_notify

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%AF%B7%E6%B1%82%E5%8F%82%E6%95%B0-33) 请求参数

| 字段 | 类型 | 说明 |
| --- | --- | --- |
| ToUserName | String | 小程序原始ID |
| FromUserName | String | 该事件消息的openid，道具发货场景固定为微信官方的openid |
| CreateTime | Number | 消息发送时间 |
| MsgType | String | 消息类型，固定为：event |
| Event | String | 事件类型<br>xpay_complaint_notify |
| OpenId | String | 用户openid |
| WxOrderId | String | 微信单号 |
| MchOrderId | String | 商户单号 |
| ComplaintTime | Number | 投诉时间，秒级时间戳 |
| RetryTimes | Number | 重试次数，从0开始。重试间隔为2 4 8 16...最多15次 |
| RequestId | String | 请求编号 |

#### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E8%BF%94%E5%9B%9E%E5%8F%82%E6%95%B0-33) 返回参数

| 字段 | 类型 | 是否必填 | 说明 |
| --- | --- | --- | --- |
| ErrCode | Number | 是 | 发送状态。0：成功，其他：失败 todo |
| ErrMsg | String | 否 | 错误原因，用于调试。在errcode非0 的情况下可以返回 |

## [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#_2-4-%E7%AD%BE%E5%90%8D%E8%AF%A6%E8%A7%A3) 2.4.签名详解

用户态签名和支付签名在基础库wx.requestVirtualPayment和服务器API中都会涉及

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%94%AF%E4%BB%98%E7%AD%BE%E5%90%8D-2) 支付签名

签名算法伪代码为：

```text
paySig = to_hex(hmac_sha256(appKey,uri + '&' + signData))
```

| 参数 | wx API | 服务器API |
| --- | --- | --- |
| appKey | 可通过小程序MP查看：虚拟支付 -> 基本配置 -> 基础配置中的沙箱AppKey和现网AppKey。注意：记得根据env值选择不同AppKey，env = 0对应现网AppKey，env = 1对应沙箱AppKey | 同理 |
| signData | 基础库的signData字段 | api的post body |
| uri | 固定填requestVirtualPayment | 举例：对于https://api.weixin.qq.com/xpay/query_user_balance来说，uri = /xpay/query_user_balance |

可参考下面的calc_pay_sig函数

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E7%94%A8%E6%88%B7%E6%80%81%E7%AD%BE%E5%90%8D-2) 用户态签名

签名算法伪代码为：

```text
signature = to_hex(hmac_sha256(sessionKey,signData))
```

| 参数 | wx API | 服务器API |
| --- | --- | --- |
| sessionKey | [session_key](https://developers.weixin.qq.com/minigame/dev/guide/open-ability/login.html) | 同理 |
| signData | 基础库的signData字段 | api的post body |

## [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E5%8F%82%E8%80%83%E7%9A%84python%E8%84%9A%E6%9C%AC) 参考的python脚本

以调用query_user_balance接口为例，签名计算如下：

```python
#!/usr/bin/python
# -*- coding: utf-8 -*-
""" pay_sig签名算法计算示例 """

import hmac
import hashlib
import json
import time

def calc_pay_sig(uri, post_body, appkey):
    """ pay_sig签名算法
      Args:
     uri - 当前请求的API的uri部分，不带query_string 例如：/xpay/query_user_balance
          post_body - http POST的数据包体
          appkey    - 对应环境的AppKey
      Returns:
          支付请求签名pay_sig
    """
    need_sign_msg = uri + '&' + post_body
    pay_sig = hmac.new(key = appkey.encode('utf-8'), msg = need_sign_msg.encode('utf-8'),
                       digestmod=hashlib.sha256).hexdigest()
    return pay_sig

def calc_signature(post_body, session_key):
    """ 用户登录态signature签名算法
      Args:
          post_body   - http POST的数据包体
          session_key - 当前用户有效的session_key，参考auth.code2Session接口
      Returns:
          用户登录态签名signature
    """
    need_sign_msg = post_body
    signature = hmac.new(key = session_key.encode('utf-8'), msg = need_sign_msg.encode('utf-8'),
                       digestmod=hashlib.sha256).hexdigest()
    return signature

# uri，切记不可带参数，即去掉"?"及后面的部分
# 如果是基础库的wx.requestVirtualPayment，uri固定为requestVirtualPayment
uri = '/xpay/query_user_balance'

# 此处appkey为假设值，实际使用应根据支付环境(env参数)替换为对应的AppKey
appkey = "12345"

# 注意：JSON数据序列化结果，不同语言/版本结果可能不同
# 所以示例为了保证稳定性，直接用其中一个序列化的版本
# 实际使用时只需要保证，参与签名的post_body和真正发起http请求的一致即可
"""
# 不同接口要求的Post Body参数不一样，此处以query_user_balance接口为例(和uri对应）
post_body = json.dumps({
    "openid": "xxx",
    "user_ip": "127.0.0.1",
    "env": 0
})
"""
post_body = '{"openid": "xxx", "user_ip": "127.0.0.1", "env": 0}'

# step1. pay_sig签名计算（支付请求签名算法）
pay_sig = calc_pay_sig(uri, post_body, appkey)
print("pay_sig:", pay_sig)

# 若实际请求返回pay_sig签名不对，根据以下步骤排查：
# 1. 确认算法：uri、post_body、appkey写死以上参数，确保你的签名算法和示例calc_pay_sig结果完全一致
# 2. 确认参数：
#    - uri不可带参数（即"?"及后续部分全部舍去）
#    - post_body必须和真正发起HTTP请求的post body完全一致
#    - appkey必须是与请求中对应的环境匹配（env参数决定）
assert pay_sig == "c37809f27c6d7fd1837ad2500a04512b66b34fd793a39a385fade56dca89a4b5"

# step2. signature签名计算（用户登录态签名算法）
# session_key需要为当前用户有效session_key（参考auth.code2Session接口获取）
# 此处写死方便复现算法
session_key = "9hAb/NEYUlkaMBEsmFgzig=="
signature = calc_signature(post_body, session_key)
print("signature:", signature)

# 若实际请求返回signature签名不对，参考随后的“90010-signature签名错误问题排查思路”进行排查
assert signature == "089d9e8dc5d308977360c4b79ec600a93d736802802a807d634192328032f6c7"
```

## [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#_2-5-Windows%E5%AE%A2%E6%88%B7%E7%AB%AF%E6%94%AF%E4%BB%98%E8%83%BD%E5%8A%9B) 2.5.Windows客户端支付能力

能力介绍：目前腾讯旗下的媒体均可支持播放短剧小程序，C端用户可以在浏览Windows客户端媒体时观看短剧，并完成支付流程。

### [\#](https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/virtual-payment.html\#%E6%8E%A5%E5%85%A5%E6%AD%A5%E9%AA%A4%EF%BC%9A) 接入步骤：

1.调用 wx.getSystemInfo 或 wx.getDeviceInfo 接口，获取 platform 字段

2.兼容 “windows”平台也走到支付接口

3.使用微信开发者工具 - 真机调试能力，在 Windows客户端测试即可

```text
//代码示例参考如下：支付方法同时兼容android和windows操作系统
if(wx.getSystemInfoSync().platform == 'android' || wx.getSystemInfoSync().platform == 'windows') {
    wx.requestVirtualPayment({...})
}
```

Windows 客户端正常支付通路如下：

![](https://res8.wxqcloud.qq.com.cn/wxdoc/296b0056-8940-43f1-9709-556355237b83.png)

开发者未适配Windows客户端的异常通路示意如下：

![](https://res8.wxqcloud.qq.com.cn/wxdoc/648278a4-3d1d-4e3f-a912-341b6f0998db.png)
- 1.1.开通条件

- 1.2.开通入口

- 1.3.开通流程


  - 第一步：阅读协议

  - 第二步：提交商户相关资料开通商户号

  - 第三步：账户状态查询及资料审核

  - 第四步：进行账户验证

  - 第五步：扫码签约

  - 第六步：进入商户管理后台进行账单/订单查询，代币/道具配置及资金管理

- 2.1.时序图


  - 道具直购流程图

  - 道具直购注意事项

  - 代币充值流程图

  - 代币充值注意事项

- 2.2.wx API

- 2.3.服务器API


  - 用户态签名

  - 支付签名

  - 错误码

  - queryuserbalance

  - currency_pay

  - query_order

  - cancelcurrencypay

  - notifyprovidegoods

  - present_currency

  - download_bill

  - refund_order

  - createwithdraworder

  - querywithdraworder

  - startuploadgoods

  - queryuploadgoods

  - startpublishgoods

  - querypublishgoods

  - querybizbalance

  - querytransferaccount

  - queryadverfunds

  - createfundsbill

  - bindtransferaccout

  - queryfundsbill

  - queryrecoverbill

  - getcomplaintlist

  - getcomplaintdetail

  - getnegotiationhistory

  - response_complaint

  - complete_complaint

  - uploadvpfile

  - getuploadfile_sign

  - downloadadverfundsorder

- 消息推送


  - 推送响应格式说明

  - 道具发货推送xpaygoodsdeliver_notify

  - 代币支付推送xpaycoinpay_notify

  - 退款推送xpayrefundnotify

  - 用户投诉推送xpaycomplaintnotify

- 2.4.签名详解


  - 支付签名

  - 用户态签名

- 参考的python脚本

- 2.5.Windows客户端支付能力


  - 接入步骤：