<?php
require_once '../init.php';

$read = new SplCSV\Reader('read_line.csv');
$data = $read->read('2');
print_r($data);
echo '<br/>';
$data = $read->read('50');
print_r($data);