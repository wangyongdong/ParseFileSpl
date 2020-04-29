<?php

namespace ParseFileSpl\FAbstract;

use ParseFileSpl\Exception\FileException;

/**
 * Class SplAbstract
 * @package ParseFileSpl\FAbstract
 */
abstract class SplAbstract {
    /**
     * @var filepath
     */
    protected $file;

    /**
     * @param string $file
     * @param bool $bTouch
     *
     * @return bool
     * @throws FileException
     */
    public function verifyFile($file, $bTouch = true) {
        $this->file = $file;

        if ($bTouch && !file_exists($this->file)) {
            touch($this->file);
        }

        if (!$this->handle->isReadable()) {
            throw new FileException("The file `{$file}` is not readable." . error_get_last()['message']);
            die();
        }

        if(!$this->handle->isWritable()) {
            throw new FileException("The file `{$file}` is not writable." . error_get_last()['message']);
            die();
        }

        return true;
    }

    /**
     * 设置自动在文本末尾添加换行符
     * SplFileObject::READ_AHEAD    倒带/继续阅读。
     * SplFileObject::DROP_NEW_LINE 在行尾放置换行符。
     * SplFileObject::SKIP_EMPTY    跳过文件中的空行。这需要READ_AHEAD启用该标志，才能按预期工作。
     * SplFileObject::READ_CSV      将行读取为CSV行。
     */
    public function setFlags() {
        $this->handle->setFlags(\SplFileObject::READ_AHEAD | \SplFileObject::SKIP_EMPTY | \SplFileObject::DROP_NEW_LINE);

        if($this->handle->getExtension() == 'csv') {
            $this->handle->setFlags(\SplFileObject::READ_CSV);

            list($this->delimiter, $this->enclosure, $this->escape) = $this->handle->getCsvControl();
        }
    }
}