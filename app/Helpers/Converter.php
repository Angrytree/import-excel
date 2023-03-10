<?php

namespace App\Helpers;

class Converter {

    /**
     * Convert php.ini size strings such as 1M, 1K, 1G to bytes.
     */
    public static function toBytes($value) {
        if(is_numeric($value)) {
            return $value;
        }else {
            $length = strlen($value);
            $qty = substr($value, 0, $length - 1);
            $unit = strtolower(substr($value, $length - 1));
            switch ($unit) {
                case 'k':
                    $qty *= 1024;
                    break;
                case 'm':
                    $qty *= 1048576;
                    break;
                case 'g':
                    $qty *= 1073741824;
                    break;
            }
            return $qty;
        }
    }

}