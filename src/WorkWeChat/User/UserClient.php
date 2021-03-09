<?php

/*
 * This file is part of the zyan/work-wechat.
 *
 * (c) 读心印 <aa24615@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zyan\WorkWeChat\WorkWeChat\User;

use Zyan\WorkWeChat\Kernel\BaseClient;

/**
 * Class UserClient.
 *
 * @package Zyan\WorkWeChat\WorkWeChat\User
 *
 * @author 读心印 <aa24615@qq.com>
 */
class UserClient extends BaseClient
{
    /**
     * 获取员工列表.
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


        return $this->httpPost('wework_admin/contacts/member/cache?'.http_build_query($params));
    }
}
