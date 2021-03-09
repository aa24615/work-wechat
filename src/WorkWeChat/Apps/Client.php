<?php
/*
 * This file is part of the zyan/work-wechat.
 *
 * (c) 读心印 <aa24615@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zyan\WorkWeChat\WorkWeChat\Apps;

use Zyan\WorkWeChat\Kernel\BaseClient;
use Zyan\WorkWeChat\Kernel\Support\Params;

/**
 * Class Client.
 *
 * @package Zyan\WorkWeChat\WorkWeChat\Apps
 *
 * @author 读心印 <aa24615@qq.com>
 */


class Client extends BaseClient
{
    /**
     * 获取所有应用.
     *
     * @return array
     *
     * @author 读心印 <aa24615@qq.com>
     */

    public function getList()
    {
        $params = [
            'lang' => 'zh_CN',
            'f' => 'json',
            'ajax' => 1,
            'timeZoneInfo[zone_offset]' => -8,
            'random' => Params::random()
        ];

        return $this->httpPost("wework_admin/getCorpApplication?".http_build_query($params));
    }

    /**
     * 创建内部应用.
     *
     * @param string $name
     * @param string $description
     * @param string $logoImage
     * @param array $visiblePid
     *
     * @return array
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function addOpenApiApp(string $name, string $description, string $logoImage, array $visiblePid = [])
    {
        $params = [
            'lang' => 'zh_CN',
            'f' => 'json',
            'ajax' => 1,
            'timeZoneInfo[zone_offset]' => -8,
            'random' => Params::random()
        ];

        $data = [
            "name" => $name,
            "description" => $description,
            "english_name" => "",
            "english_description" => "",
            "app_open" => 1,
            "logoimage" => $logoImage,
            "visible_pid" => $visiblePid,
            "visible_vid" => [],
            "_d2st" => Params::_d2st()
        ];


        $url = 'wework_admin/apps/addOpenApiApp?'.http_build_query($params);

        return $this->httpPost($url, $data);
    }


    /**
     * 应用详情.
     *
     * @param int $appId
     *
     * @return array
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function getOpenApiApp(int $appId)
    {
        $params = [
            'lang' => 'zh_CN',
            'f' => 'json',
            'ajax' => 1,
            'timeZoneInfo[zone_offset]' => -8,
            'random' => Params::random(),
            'app_id' => $appId
        ];

        $url = "wework_admin/apps/getOpenApiApp?".http_build_query($params);
        return $this->httpGet($url);
    }


    /**
     * 应用设为开启状态.
     *
     * @param int $appId
     *
     * @return array
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function saveOpenApiApp(int $appId)
    {
        $params = [
            'lang' => 'zh_CN',
            'f' => 'json',
            'ajax' => 1,
            'timeZoneInfo[zone_offset]' => -8,
            'random' => Params::random()
        ];

        $data = [
            "app_open" => "true",
            "app_id" => $appId,
            "_d2st" => Params::_d2st()
        ];

        $url = "wework_admin/apps/getOpenApiApp?".http_build_query($params);
        return $this->httpPost($url, $data);
    }

    /**
     * 删除应用.
     *
     * @param int $appId
     * @param string $appOpenId
     *
     * @return
     *
     * @author 读心印 <aa24615@qq.com>
     */

    public function delOpenApiApp(int $appId, $appOpenId)
    {
        $params = [
            'lang' => 'zh_CN',
            'f' => 'json',
            'ajax' => 1,
            'timeZoneInfo[zone_offset]' => -8,
            'random' => Params::random()
        ];

        $data = [
            "app_id" => $appId,
            "app_open_id" => $appOpenId,
            "app_type" => "APP_TYPE_MSG",
            "_d2st" => Params::_d2st()
        ];

        $url = 'wework_admin/apps/delOpenApiApp?'.http_build_query($params);
        //有问题,请勿用
        //return $this->httpPost($url, $data);
    }

    /**
     * 获取可信域名txt文件验证.
     *
     * @return array
     *
     * @author 读心印 <aa24615@qq.com>
     */

    public function getDomainOwnershipVerifyInfo()
    {
        $params = [
            'lang' => 'zh_CN',
            'f' => 'json',
            'ajax' => 1,
            'timeZoneInfo[zone_offset]' => -8,
            'random' => Params::random(),
            '_d2st' => Params::_d2st()
        ];

        $url = 'wework_admin/apps/getDomainOwnershipVerifyInfo?'.http_build_query($params);
        return $this->httpGet($url);
    }
}
