<?php

namespace SplCSV;

abstract class AbstractSplClass {
    protected $handle;
    protected $file;
    protected $separator = ',';
    protected $enclosure = '"';

    public function __construct($file, $open_mode = 'r+', $bTouch = false) {
        $this->inspection($file, $bTouch);

        $this->handle = new \SplFileObject($file, $open_mode);
        $this->handle->setFlags(\SplFileObject::DROP_NEW_LINE);
        $this->file = $file;
    }

    public function inspection($file, $bTouch) {
        if ((!$file || !file_exists($file)) && $bTouch == false) {
            return false;
        } else {
            if (!file_exists($file)) {
                touch($file);
            }
        }

        if (!is_readable($file)) {
            return false;
        }

        if (pathinfo($file, PATHINFO_EXTENSION) != 'csv') {
            return false;
        }

        return true;
    }

    public function __destruct() {
        $this->handle = null;
    }

    public function setDelimiter($separator) {
        $this->separator = $separator;
    }

    public function setEnclosure($enclosure) {
        $this->enclosure = $enclosure;
    }
}
