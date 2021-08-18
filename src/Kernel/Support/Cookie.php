<?php
/*
 * This file is part of the zyan/work-wechat.
 *
 * (c) 读心印 <aa24615@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zyan\WorkWeChat\Kernel\Support;

/**
 * Class Cookie.
 *
 * @package Zyan\WorkWeChat\Kernel\Support
 *
 * @author 读心印 <aa24615@qq.com>
 */
class Cookie
{
    /**
     * 从curl返回头中获取cookie.
     *
     * @param string $str
     *
     * @return array
     *
     * @author 读心印 <aa24615@qq.com>
     */

    public static function find(string $str)
    {
        preg_match_all("/[s]et-cookie:(.*?);/im", $str, $matches);
        $data = [];

        foreach ($matches[1] as $v) {
            $arr = explode('=', $v);
            $data[] = [
                'name' => trim($arr[0]),
                'value' => trim($arr[1])
            ];
        }
        return $data;
    }

    /**
     * 从array中拼接cookie.
     *
     * @param array $arr
     *
     * @return string
     *
     * @author 读心印 <aa24615@qq.com>
     */
    public static function jojn(array $arr)
    {
        $newArr = [];
        foreach ($arr as $v) {
            $newArr[] = join('=', [$v['name'],$v['value']]);
        }

        return join(';', $newArr);
    }
}
