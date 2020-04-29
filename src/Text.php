<?php
/**
 * Description:
 * Author: wangyongdong
 * DateTime: 2020/4/22 14:48
 */

namespace ParseFileSpl;

use ParseFileSpl\Facade\ParseFacade;

class Text
{
    public static function getInstance() {
        $facade = new ParseFacade();
        return $facade::text();
    }

}