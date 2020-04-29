<?php
require_once '../autoload.php';

$text = ParseFileSpl\Text::getInstance();
// 读取
$iterator = $text->read('text_read.txt', 2, 2); // 读取
$data = array();
foreach ($iterator as $line) {
    $data[] = $line;
}
print_r($data);

// 写入
//$text->put(__DIR__. '/text_write.txt', array('2ssss', 'ddd', '33fgfg3'), 'a+');