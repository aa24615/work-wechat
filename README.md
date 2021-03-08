

# zyan/work-wechat

模拟企业微信后台

- 获取qrcode
- 登录获取cookie
- 获取通讯录
- 获取应用列表
- 创建应用
- 设置侧边栏

等等

## 要求

1. php >= 7.3
2. Composer

## 安装

```shell
composer require zyan/work-wechat -vvv
```
## 用法

```php
use Zyan\WorkWeChat\WorkWeChat;

//默认配置 可选 
$config = [
    'cache' => [ //缓存 目前仅支持 file redis 
        'default' => 'file',
        'stores' => [
            'file' => [
                'driver' => 'file',
                'path' => './chache',
            ],
            'redis' => [
                'driver' => 'redis',
                'host' => '127.0.0.1',
                'port' => 6379,
                'password' => null
            ]
        ]
    ]
];

$work = WorkWeChat::config($config);
```

获取登录二维码

```php
$work->login->getQrcode();

/**
return
Array
(
    [qrcode_key] => eb67102ca70843de //二维码的key
    [qrcode_url] => https://work.weixin.qq.com/wwqrlogin/qrcode/eb67102ca70843de?login_type=login_admin
)
*/
```

通过企业微信扫码后 查询登录状态

```php
$work->login->getStatus($qrcode_key)

/**
return

Array
(
    [data] => Array
        (
            [status] => QRCODE_SCAN_NEVER //登录状态
            [auth_source] => SOURCE_FROM_WEWORK
            [corp_id] => 0
            [code_type] => 2
            [clientip] => 183.17.231.150
            [confirm_clientip] => 
        )

)

QRCODE_SCAN_NEVER 等待扫码
QRCODE_SCAN_FAIL 取消操作
QRCODE_SCAN_ING 已扫码,等待确认
QRCODE_SCAN_SUCC 已确认 登录

*/


```

当登录状态为QRCODE_SCAN_SUCC时 获取cookie

```php

$isLogin = $work->login->getCookie($auth_code, $qrcode_key);

//返回是否登录成功 true 为成功

//$auth_code 为授权 code 在 QRCODE_SCAN_SUCC时 会返回

//您不需要去处理cookie 因为系统已经帮你处理好了
//默认会将cookie转为array保存file缓存中


```

获取企业信信息
```php
$work->corp->getCorp();

```




更多操作
```php

//获取所有应用列表
$work->apps->getList();

//获取部门列表
$work->department->getList();

```

php完整示例 请查看 [tests/test.php](tests/test.php) 中 

前端交互示例暂无


## 参与贡献

1. fork 当前库到你的名下
3. 在你的本地修改完成审阅过后提交到你的仓库
4. 提交 PR 并描述你的修改，等待合并
> 注: 本项目同时发布在gitee 请使用github提交      
> github: https://github.com/aa24615/work-wechat

## License

[MIT license](https://opensource.org/licenses/MIT)
