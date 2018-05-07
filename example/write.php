<?php
require_once '../init.php';
$writer = new SplCSV\Writer(__DIR__. '/write.csv');
$arr_1 = array('column1', 'column2', 'column3');
$writer->writeRow($arr_1);
$arr_2 = array(
    array('value1', 'value2', 'value3'),
    array('value4', 'value5', 'value6'),
    array('value7', 'value8', 'value9'),
);
$writer->writeArray($arr_2);

