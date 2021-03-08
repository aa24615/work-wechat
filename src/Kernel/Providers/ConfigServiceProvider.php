<?php

/*
 * This file is part of the zyan/work-wechat.
 *
 * (c) 读心印 <aa24615@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zyan\WorkWeChat\Kernel\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Zyan\WorkWeChat\Kernel\Config;

/**
 * Class ConfigServiceProvider.
 *
 * @package Zyan\WorkWeChat\Kernel\Providers
 *
 * @author 读心印 <aa24615@qq.com>
 */
class ConfigServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        !isset($pimple['config']) && $pimple['config'] = function ($app) {
            return new Config($app->getConfig());
        };
    }
}
