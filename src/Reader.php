<?php

namespace SplCSV;

/**
 * Class Import
 * @package SplCSV
 * Created on 2018/5/4 17:45
 * Created by wangyongdong
 */
class Reader extends AbstractSplClass {
    /**
     * @var bool|int
     */
    private $lastLine = false;

    /**
     * @var bool|int
     */
    private $currentLine = false;

    /**
     * @param string $file
     * @param string $open_mode
     */
    public function __construct($file, $open_mode = 'r+') {
        parent::__construct($file, $open_mode);
    }

    /**
     * 最后行数
     * @return int
     */
    public function getLastLine() {
        if ($this->lastLine !== false) {
            return $this->lastLine;
        }

        $this->handle->seek($this->handle->getSize());
        $lastLine = $this->handle->key();

        $this->handle->rewind();

        return $this->lastLine = $lastLine > 0 ? $lastLine+1 : $lastLine;
    }

    /**
     * 当前行数
     * @return int
     */
    public function getCurrentLine() {
        return $this->handle->key()+1;
    }

    /**
     * 读取csv
     * @param int $length
     * @param int $start
     * @return array
     */
    public function read($length = 0, $start = 0) {
        $length = $length ? $length : $this->getLastLine();
        $start = $this->currentLine > 0 ? $this->currentLine : $start;
        $start = ($start < 0) ? 0 : $start;

        $data = array();
        $this->handle->seek($start);
        while ($length-- && !$this->handle->eof()) {
            $rowData = $this->getCurrentRow();
            if(!$this->isEmpty($rowData)) {
                $data[] = $rowData;
            }
        }
        return $data;
    }

    /**
     * 获取当前行内容
     * @return array
     */
    public function getCurrentRow() {
        $current = $this->handle->current();
        $data = str_getcsv($current, $this->separator, $this->enclosure);
        $this->currentLine = $this->getCurrentLine();
        $this->handle->next();

        return $data;
    }

    /**
     * 判断内容是否为空
     * @param $row
     * @return bool
     */
    protected function isEmpty($row) {
        if ($row === array(null)) {
            return true;
        } elseif (array_filter($row) === array()) {
            return true;
        }
        return false;
    }

}
