<?php
require_once '../autoload.php';

$csv = ParseFileSpl\Csv::getInstance();
// 读取
$iterator = $csv->read('csv_read.csv', 5, 2); // 读取
$data = array();
foreach ($iterator as $line) {
    $data[] = $line;
}
print_r($data);

// 写入
//$iterator = $csv->put(__DIR__. '/csv_write.csv', array('2ssss', 'ddd', '33fgfg3'), 'a+');

// 导出
//$csv->export(__DIR__.'/csv_export.csv', array(
//    array('value1', 'value2', 'value3'),
//    array('value4', 'value5', 'value6'),
//));
