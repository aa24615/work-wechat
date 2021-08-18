<?php
/*
 * This file is part of the zyan/work-wechat.
 *
 * (c) 读心印 <aa24615@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zyan\WorkWeChat\Kernel;

use GuzzleHttp\Client;
use Zyan\WorkWeChat\Kernel\Support\Cookie;

/**
 * Class BaseClient.
 *
 * @package Zyan\WorkWeChat\Kernel
 *
 * @author 读心印 <aa24615@qq.com>
 */
class BaseClient
{
    protected $app;

    protected $baseUri = 'https://work.weixin.qq.com/';

    /**
     * BaseClient constructor.
     * @param ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
        $this->http = new Client([
            'base_uri' => $this->baseUri,
            'timeout' => $this->app->getConfig()['http']['timeout'],
            'http_errors' => false,
            'verify' => false,
            'headers' => [
                "user-agent" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36",
                "referer" => $this->baseUri."wework_admin/loginpage_wx?from=myhome"
            ]
        ]);
    }

    /**
     * httpGet.
     *
     * @param string $url
     * @param array $data
     * @param string $returnType
     *
     * @return array|string
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function httpGet(string $url, array $data = [], $returnType = 'array')
    {
        $cookie = $this->getCookieStr();

        $response = $this->http->get($url, [
            'query' => $data,
            'headers' => [
                'cookie' => $cookie
            ]
        ]);

        $code = $response->getStatusCode();

        if ($code != 200) {
            return ['error' => -1,'msg' => 'http'.$code];
        }

        $this->headers = $response->getHeaders();

        $body = $response->getBody()->getContents();


        if ($returnType == 'array') {
            $body = json_decode($body, true);
            if (empty($body)) {
                return ['error' => -1];
            } else {
                return $body;
            }
        } else {
            return $body;
        }
    }

    /**
     * httpPost.
     *
     * @param string $url
     * @param array $params
     * @param string $returnType
     *
     * @return array|string
     *
     * @author 读心印 <aa24615@qq.com>
     */

    public function httpPost(string $url, array $params = [], $returnType = 'array')
    {
        $cookie = $this->getCookieStr();

        $response = $this->http->post($url, [
            'form_params' => $params,
            'headers' => [
                'cookie' => $cookie
            ]
        ]);

        $code = $response->getStatusCode();

        if ($code != 200) {
            return ['error' => -1,'msg' => 'http:'.$code];
        }

        $this->headers = $response->getHeaders();

        $body = $response->getBody()->getContents();


        if ($returnType == 'array') {
            $body = json_decode($body, true);
            if (empty($body)) {
                return ['error' => -1];
            } else {
                return $body;
            }
        } else {
            return $body;
        }
    }


    /**
     * curlCookie.
     *
     * @param string $url
     * @param array $data
     * @param array $header
     *
     * @return string
     *
     * @author 读心印 <aa24615@qq.com>
     */

    public function curlCookie(string $url, array $data = [], array $header = [])
    {
        $url = $this->baseUri.$url.(!empty($data) ? '?'.http_build_query($data) : '');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    /**
     * curlCookie2.
     *
     * @param string $url
     * @param array $header
     *
     * @return string
     *
     * @author 读心印 <aa24615@qq.com>
     */

    public function curlCookie2(string $url, array $header = [])
    {
        $url = $this->baseUri.$url;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }


    /**
     * getCookieStr.
     *
     * @return string
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function getCookieStr($name = 'cookie')
    {
        $data = $this->app['cache']->get($name);

        $str = '';

        if (is_array($data)) {
            $str = Cookie::jojn($data);
        }

        return $str;
    }
}
