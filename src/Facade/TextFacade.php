<?php

namespace ParseFileSpl\Facade;

use NoRewindIterator;

/**
 * Class TextFacade
 * @package ParseFileSpl\Facade
 */
class TextFacade extends \ParseFileSpl\FAbstract\FileSpl {

    /**
     * @param int $length
     * @param int $start
     *
     * @return \Generator|int
     */
    public function reader($length = 0, $start = 0)
    {
        $length = $this->getLength($length);
        $this->getStart($start);

        $count = 0;
        while ($length-- && $this->handle->valid()) {
            $rowData = $this->handle->current();
            if (!empty($rowData)) {
                yield $rowData;
            }
            $this->currentLine = $this->getCurrentLine();
            $this->handle->next();
            $count++;
        }

        return $count;
    }

    /**
     * @param string $file
     * @param int    $length
     * @param int    $start
     * @param string $mode
     *
     * @return NoRewindIterator
     * @throws \Exception
     */
    public function read($file, $length = 0, $start = 0, $mode = 'r+') {
        parent::create($file, $mode);

        return new NoRewindIterator($this->reader($length, $start));
    }

    /**
     * @param string $file
     * @param string $strem
     * @param string $mode
     *
     * @return int
     * @throws \Exception
     */
    public function put($file, $strem, $mode = 'a+') {
        parent::create($file, $mode);

        if(is_array($strem)) {
            // 二维数组
            array_map(function($row) {
                $this->handle->fwrite($row."\r\n");
            }, $strem);
        } else {
            return $this->handle->fwrite($strem."\r\n");
        }
    }
}