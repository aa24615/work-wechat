<?php
/*
 * This file is part of the zyan/work-wechat.
 *
 * (c) 读心印 <aa24615@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zyan\WorkWeChat\Kernel\Cache;

use Doctrine\Common\Cache\PhpFileCache;
use Doctrine\Common\Cache\PredisCache;
use Zyan\WorkWeChat\Kernel\ServiceContainer;

class CacheManager
{
    public $cache;

    /**
     * CacheManager constructor.
     * @param ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;

        $name = $this->app['config']->cache['default'];
        $drivers = $this->app['config']->cache['stores'];


        if ($drivers[$name]['driver'] == 'file') {
            $this->cache = new PhpFileCache($drivers[$name]['path']);
        }

        if ($drivers[$name]['driver'] == 'redis') {
            $client = new \Predis\Client();
            $this->cache = new PredisCache($client);
        }
    }

    /**
     * getFileDriver.
     *
     * @return PhpFileCache
     *
     * @author 读心印 <aa24615@qq.com>
     */

    public function getFileDriver()
    {
        $drivers = $this->app['config']->cache['stores'];

        return new PhpFileCache($drivers['file']['path']);
    }

    /**
     * getRedisDriver.
     *
     * @return PredisCache
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function getRedisDriver()
    {
        $drivers = $this->app['config']->cache['stores'];

        $password = $drivers['redis']['password'];

        $client = new \Predis\Client([
            'scheme' => 'tcp',
            'host' => $drivers['redis']['host'],
            'port' => $drivers['redis']['port'],
        ]);

        !is_null($password) && $client->auth($password);

        return new PredisCache($client);
    }

    /**
     * getDefaultDriver.
     *
     * @return string
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function getDefaultDriver()
    {
        return $this->app['config']->cache['default'];
    }

    /**
     * driver.
     *
     * @return PredisCache|PhpFileCache
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function driver()
    {
        $driver = $this->getDefaultDriver();

        if ($driver == 'file') {
            $obj = $this->getFileDriver();
        }

        if ($driver == 'redis') {
            $obj = $this->getRedisDriver();
        }


        return $obj;
    }




    /**
     * Set the default log driver name.
     *
     * @param string $name
     *
     */
    public function setDefaultDriver($name)
    {
        $this->app['config']->cache['default'] = $name;
    }


    /**
     * set.
     *
     * @param string $name
     * @param mixed $value
     *
     * @return boolean
     *
     * @author 读心印 <aa24615@qq.com>
     */

    public function set(string $name, $value)
    {
        return $this->driver()->save($name, $value);
    }

    /**
     * get.
     *
     * @param string $name
     *
     * @return mixed
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public function get(string $name)
    {
        return $this->driver()->fetch($name);
    }
}
