<?php

namespace Zyan\WorkWeChat\Kernel\Support;

class Params
{
    public static function _d2st()
    {
        return 'a'.rand(1000000, 9999999);
    }

    public static function random()
    {
        return time();
    }
}
