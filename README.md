# Moonpie MP Virtual Pay

WeChat Mini Program Virtual Payment for EasyWeChat

微信小程序虚拟支付 for EasyWeChat

## Installation

```bash
composer require moonpie/mp-virtual-pay
```

## Usage

### Basic Example

```php
use Moonpie\EasyWechat\VirtualPay\Client;

// Initialize the client
$config = [
    'app_id' => 'your-app-id',
    'secret' => 'your-secret',
    // other config options
];

$client = new Client($config);

// Use the virtual payment features
$result = $client->processPayment($orderData);
```

## Requirements

- PHP >= 7.4
- easywechat/easywechat: ^4.0

## License

MIT License - see [LICENSE](LICENSE) for details.

---

## 安装

```bash
composer require moonpie/mp-virtual-pay
```

## 使用

### 基本示例

```php
use Moonpie\EasyWechat\VirtualPay\Client;

// 初始化客户端
$config = [
    'app_id' => 'your-app-id',
    'secret' => 'your-secret',
    // 其他配置选项
];

$client = new Client($config);

// 使用虚拟支付功能
$result = $client->processPayment($orderData);
```

## 要求

- PHP >= 7.4
- easywechat/easywechat: ^4.0

## 许可证

MIT 许可证 - 详情请参见 [LICENSE](LICENSE)。