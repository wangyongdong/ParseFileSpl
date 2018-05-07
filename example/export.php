<?php
require_once '../init.php';
$arr = array(
    array('value1', 'value2', 'value3'),
    array('value4', 'value5', 'value6'),
);
SplCSV\Export::output($arr, __DIR__.'/write.csv');