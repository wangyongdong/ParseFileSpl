<?php

namespace SplCSV;

/**
 * Class Writer
 * @package SplCSV
 * Created on 2018/5/7 10:15
 * Created by wangyongdong
 */
class Writer extends AbstractSplClass {

    /**
     * @param string $file
     * @param string $open_mode
     * @param bool   $bTouch
     */
    public function __construct($file, $open_mode = 'r+', $bTouch = true) {
        parent::__construct($file, $open_mode, $bTouch);
    }

    /**
     * 数组
     * @param array $row
     * @return int
     */
    public function writeRow(array $row) {
//        if (is_string($row)) {
//            $row = explode(',', $row);
//            $row = array_map('trim', $row);
//        }
        return $this->handle->fputcsv($row, $this->separator, $this->enclosure);
    }

    /**
     * 多维数据
     * @param array $array
     */
    public function writeArray(array $array) {
        foreach ($array as $key => $value) {
            $this->writeRow($value);
        }
    }

}
