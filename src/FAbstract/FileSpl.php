<?php

namespace ParseFileSpl\FAbstract;

use ParseFileSpl\Exception\FileException;

/**
 * Class FileSpl
 * @package ParseFileSpl\FAbstract
 */
abstract class FileSpl extends SplAbstract {

    /**
     * @var \SplFileObject
     */
    protected $handle;

    /**
     * @var bool|int
     */
    protected $lastLine = false;

    /**
     * @var bool|int
     */
    protected $currentLine = false;

    /**
     * @param string $file
     * @param string $open_mode
     *
     * @throws \Exception
     */
    public function create($file, $open_mode = 'r+', $bTouch = false) {
        if ((!$file || !file_exists($file)) && $bTouch == false) {
            throw new FileException("The file `{$file}` does not exist." . error_get_last()['message']);
            die();
        }

        $this->handle = new \SplFileObject($file, $open_mode);

        $this->verifyFile($file, $bTouch);

        $this->setFlags();
    }

    /**
     * 最后行数
     * @return int
     */
    public function getLastLine()
    {
        if ($this->lastLine !== false) {
            return $this->lastLine;
        }

        $this->handle->seek($this->handle->getSize());
        $lastLine = $this->handle->key();

        $this->handle->rewind();

        return $this->lastLine = $lastLine > 0 ? $lastLine+1 : $lastLine;
    }

    public function getStart($start) {
        $start = $this->currentLine > 0 ? $this->currentLine : $start;
        $start = ($start-1 <= 0) ? 0 : $start-1;

        $this->handle->seek($start);

        return $start;
    }

    public function getLength($length) {
        return $length ? $length : $this->getLastLine();
    }

    /**
     * 当前行数
     * @return int
     */
    public function getCurrentLine()
    {
        return $this->handle->key()+1;
    }

    /**
     * 判断内容是否为空
     *
     * @param $row
     * @return bool
     */
    protected function isEmpty($row)
    {
        if (empty($row)) {
            return true;
        }
        if (is_array($row) && count($row) == 0) {
            return true;
        }
        if ($row === array(null)) {
            return true;
        }
        else if (array_filter($row) === array()) {
            return true;
        }
        return false;
    }
}