<?php

namespace ParseFileSpl\Facade;

use NoRewindIterator;

/**
 * Class CsvFacade
 * @package ParseFileSpl\Facade
 */
class CsvFacade extends \ParseFileSpl\FAbstract\FileSpl {
    /**
     * the field delimiter (one character only).
     *
     * @var string
     */
    protected $delimiter = ',';

    /**
     * the field enclosure character (one character only).
     *
     * @var string
     */
    protected $enclosure = '"';

    /**
     * the field escape character (one character only).
     *
     * @var string
     */
    protected $escape = '\\';

    /**
     * @param int $length
     * @param int $start
     *
     * @return \Generator
     */
    public function reader($length = 0, $start = 0)
    {
        $length = $this->getLength($length);
        $this->getStart($start);

        while ($length-- && $this->handle->valid()) {
            $rowData = $this->handle->current();
            if (!$this->isEmpty($rowData)) {
                yield $rowData;
            }
            $this->currentLine = $this->getCurrentLine();
            $this->handle->next();
        }
    }

    /**
     * @param string $file
     * @param int $length
     * @param int $start
     *
     * @return \NoRewindIterator
     * @throws \Exception
     */
    public function read($file, $length = 0, $start = 0) {
        parent::create($file, 'r+');

        return new NoRewindIterator($this->reader($length, $start));
    }

    /**
     * @param string  $file
     * @param array  $aFields
     * @param string $mode
     *
     * @return int
     * @throws \Exception
     */
    public function put($file, array $aFields, $mode = 'a+') {
        parent::create($file, $mode);

        if (count($aFields) == count($aFields, 1)) {
            // 一维数组
            return $this->handle->fputcsv($aFields, $this->delimiter, $this->enclosure);
        } else {
            // 二维数组
            array_map(function($fields) {
                $this->handle->fputcsv($fields, $this->delimiter, $this->enclosure);
            }, $aFields);
        }
    }

    /**
     * @param string  $aField
     * @param array $array
     *
     * @return bool
     */
    public function export($file, array $aField) {
        $this->file = $file;

        $this->rowToStr($aField);
    }

    /**
     * @param array $aFields
     */
    public function rowToStr(array $aFields) {
        $sOut = null;
        foreach ($aFields as $value) {
            $sRow = null;
            foreach ($value as $row) {
                $sRow .= '"' . $row . '",';
            }
            $sOut .= trim($sRow, ',') . "\n";
        }
        $this->sendHeaders($sOut);
    }

    /**
     * @param $sOut
     * @return bool
     */
    public function sendHeaders($sOut) {
        if(empty($sOut)) {
            return false;
        }
        $sOut = mb_convert_encoding($sOut, 'gb2312');
        $this->file = mb_convert_encoding($this->file, 'gb2312');
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:filename=".$this->file);
        echo $sOut;
        die();
    }

}