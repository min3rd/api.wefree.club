<?php

namespace App\Util;

class ParameterUtils
{
    public static function Exist($source, $key, $default = false){
        if(!isset($source[$key])){
            return $default;
        }
        return $source[$key];
    }
}
