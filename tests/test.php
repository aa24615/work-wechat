<?php


require '../vendor/autoload.php';

use Technodelight\CliOpen\OsAdaptingFactory;
use Zyan\WorkWeChat\WorkWeChat;

$config = [
    'cache' => [
        'default' => 'file',
        'stores' => [
            'file' => [
                'driver' => 'file',
                'path' => './cache',
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



//print_r($work->config);exit;
//$res = $work->corp->getCorp();
//print_r($res);
//$res = $work->department->getList();
//$res = $work->apps->getList();
//
//print_r($res);exit;


$qrcode = $work->login->getQrcode();


$cliOpen = OsAdaptingFactory::create();
$cliOpen->open($qrcode['qrcode_url']);

$qrcode_key = $qrcode['qrcode_key'];

$getStatus = false;
while (!$getStatus) {
    $resStatus = $work->login->getStatus($qrcode_key);

    switch ($resStatus['data']['status']) {
        case 'QRCODE_SCAN_NEVER':
            cli_log('等待扫码');
            break;
        case 'QRCODE_SCAN_FAIL':
            cli_log('取消操作');
            break;
        case 'QRCODE_SCAN_ING':
            if (!isset($resStatus['data']['confirm_corpid'])) {
                cli_log('个人微信,已扫码');
            } else {
                cli_log('已扫码,等待确认');
            }
            break;
        case 'QRCODE_SCAN_SUCC':
            cli_log("已确认,获取cookie");
            $getStatus = true;
            $auth_code = $resStatus['data']['auth_code'];
            $res = $work->login->getCookie($auth_code, $qrcode_key);

            var_dump($res);
            if ($res) {
                $res = $work->corp->getCorp();
                print_r($res);
            }

            break;
        default:
            cli_log('未知状态');

    }
    sleep(1);
}




function cli_log($text)
{
    echo $text;
    echo PHP_EOL;
}
