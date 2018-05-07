<?php

namespace SplCSV;

/**
 * Class Export
 * @package SplCSV
 * Created on 2018/5/7 10:38
 * Created by wangyongdong
 */
class Export {
    /*
     * @var string
     */
    public static $filename;

    /**
     * @param array $array
     * @param string $filename
     * @return bool
     */
    public static function output(array $array, $filename) {
        if(!is_array($array)) {
            return false;
        }
        if(empty($filename)) {
            return false;
        }
        self::$filename = $filename;

        self::process($array);
    }

    /**
     * @param array $array
     * @return string
     */
    public static function process(array $array) {
        $sOut = null;
        foreach ($array as $key => $value) {
            $sRow = null;
            foreach ($value as $row) {
                $sRow .= '"' . $row . '",';
            }
            $sOut .= trim($sRow, ',') . "\n";
        }
        self::outputCsv($sOut);
    }

    /**
     * @param $sOut
     * @return bool
     */
    public static function outputCsv($sOut) {
        if(empty($sOut)) {
            return false;
        }
        $sOut = mb_convert_encoding($sOut, 'gb2312');
        self::$filename = mb_convert_encoding(self::$filename, 'gb2312');
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:filename=".self::$filename);
        echo $sOut;
        die();
    }
}
