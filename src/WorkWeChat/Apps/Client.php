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
            'random' => time()
        ];

        return $this->httpPost("wework_admin/getCorpApplication?lang=zh_CN&f=json&ajax=1&timeZoneInfo%5Bzone_offset%5D=-8&random=".time());
    }
}
