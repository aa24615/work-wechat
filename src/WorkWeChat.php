<?php
/*
 * This file is part of the zyan/work-wechat.
 *
 * (c) 读心印 <aa24615@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zyan\WorkWeChat;

use Zyan\WorkWeChat\WorkWeChat\Application;

/**
 * Class WorkWeChat.
 *
 * @package Zyan\WorkWeChat
 *
 * @author 读心印 <aa24615@qq.com>
 */
class WorkWeChat
{
    /**
     * config.
     *
     * @param array $config
     *
     * @return \Zyan\WorkWeChat\WorkWeChat\Application
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public static function config(array $config = [])
    {
        return new Application($config);
    }
}
