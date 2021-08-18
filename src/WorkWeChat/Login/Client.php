<?php
/*
 * This file is part of the zyan/work-wechat.
 *
 * (c) 读心印 <aa24615@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zyan\WorkWeChat\WorkWeChat\Login;

use Zyan\WorkWeChat\Kernel\BaseClient;
use Zyan\WorkWeChat\Kernel\Support\Cookie;
use Zyan\WorkWeChat\Kernel\Support\Params;

/**
 * Class Client.
 *
 * @package Zyan\WorkWeChat\WorkWeChat\Login
 *
 * @author 读心印 <aa24615@qq.com>
 */
class Client extends BaseClient
{
    /**
     * 获取登录二维码key.
     *
     * @return array
     *
     * @author 读心印 <aa24615@qq.com>
     *
     */
    private function getKey()
    {
        $params = [
            'r' => Params::random(),
            'login_type' => 'login_admin',
            'callback' => 'wwqrloginCallback',
            'redirect_uri' => 'https://work.weixin.qq.com/wework_admin/loginpage_wx?pagekey=1614996011736462&from=myhome',
            'crossorigin' => 1
        ];

        return $this->httpGet('wework_admin/wwqrlogin/get_key', $params);
    }

    /**
     * 获取登录二维码.
     *
     * @return array
     *
     * @author 读心印 <aa24615@qq.com>
     *
     */

    public function getQrcode()
    {
        $res = $this->getKey();
        $key = $res['data']['qrcode_key'];

        return [
            'qrcode_key' => $key,
            'qrcode_url' => $this->baseUri."wwqrlogin/qrcode/{$key}?login_type=login_admin"
        ];
    }

    /**
     * 获取登录状态.
     *
     * @param string $qrcode_key;
     *
     * @return array
     *
     * @author 读心印 <aa24615@qq.com>
     *
     */

    public function getStatus(string $qrcode_key)
    {
        $params = [
            'r' => time(),
            'status' => '',
            'qrcode_key' => $qrcode_key
        ];

        return $this->httpGet('wework_admin/wwqrlogin/check', $params);
    }

    /**
     * 获取登录cookie.
     *
     * @param string $auth_code
     * @param string $qrocde_key
     *
     * @return boolean
     *
     * @author 读心印 <aa24615@qq.com>
     */

    public function getCookie(string $auth_code, string $qrocde_key)
    {
        $params = [
            'code' => $auth_code,
            'wwqrlogin' => 1,
            'qrcode_key' => $qrocde_key,
            'auth_source' => 'SOURCE_FROM_WEWORK',
            '_r' => 190,
//            'redirect_uri' => 'https://work.weixin.qq.com/wework_admin/frame',
//            'url_hash' => '#customer/tagconfig'
        ];

        $data = $this->curlCookie('wework_admin/loginpage_wx', $params);

        $cookie = Cookie::find($data);
        $this->app['cache']->set('cookie_temp', $cookie);

        preg_match_all("/location:(.*)/im", $data, $matches);

        $location = ltrim(trim($matches[1][0]), '/');

        return $this->getCookie2($location);
    }

    /**
     * 获取登录cookie2.
     *
     * @param string $location
     *
     * @return boolean
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function getCookie2(string $location)
    {
        $cookieStr = $this->getCookieStr('cookie_temp');
        $header = ['cookie:'.$cookieStr];

        $data = $this->curlCookie2($location, $header);

        $cookie = Cookie::find($data);

        $this->app['cache']->set('cookie', $cookie);

        return $this->isLogin($cookie);
    }


    /**
     * 判断是否登录成功.
     *
     * @param array $cookie
     *
     * @return boolean
     *
     * @author 读心印 <aa24615@qq.com>
     */

    private function isLogin(array $cookie)
    {
        $isLogin = false;
        foreach ($cookie as $v) {
            if ($v['name'] == 'wwrtx.sid') {
                $isLogin = true;
                break;
            }
        }

        return $isLogin;
    }
}
