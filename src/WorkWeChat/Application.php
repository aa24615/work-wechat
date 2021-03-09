<?php

/*
 * This file is part of the zyan/work-wechat.
 *
 * (c) 读心印 <aa24615@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zyan\WorkWeChat\WorkWeChat;

use Zyan\WorkWeChat\Kernel\ServiceContainer;

/**
 * Class Application.
 *
 * @package Zyan\WorkWeChat\WorkWeChat
 *
 * @property \Zyan\WorkWeChat\WorkWeChat\Login\Client $login
 * @property \Zyan\WorkWeChat\WorkWeChat\User\DepartmentClient $department
 * @property \Zyan\WorkWeChat\WorkWeChat\User\UserClient $user
 * @property \Zyan\WorkWeChat\WorkWeChat\Corp\Client $corp
 * @property \Zyan\WorkWeChat\WorkWeChat\Apps\Client $apps
 *
 * @author 读心印 <aa24615@qq.com>
 */

class Application extends ServiceContainer
{
    protected $providers = [
        Login\ServiceProvider::class,
        User\ServiceProvider::class,
        Corp\ServiceProvider::class,
        Apps\ServiceProvider::class
    ];
}
