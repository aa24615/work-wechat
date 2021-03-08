<?php
/*
 * This file is part of the zyan/work-wechat.
 *
 * (c) 读心印 <aa24615@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zyan\WorkWeChat\WorkWeChat\Corp;

use Zyan\WorkWeChat\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 获取企业信息.
     *
     * @return array
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function getCorp()
    {
        $url = 'wework_admin/frame';
        $res = $this->httpGet($url, [], 'string');

        preg_match_all('#window.settings =(.*)var __JS_LOAD#iUs', $res, $match);

        $body = $match[1][0] ?? '';
        $body = substr(trim($body), 0, -1);

        $data = json_decode($body, true);


        return $data;
    }
}
