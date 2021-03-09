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

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 *
 * @package Zyan\WorkWeChat\WorkWeChat\User
 *
 * @author 读心印 <aa24615@qq.com>
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        $app['department'] = function ($app) {
            return new DepartmentClient($app);
        };

        $app['user'] = function ($app) {
            return new UserClient($app);
        };
    }
}
