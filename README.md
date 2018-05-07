SplCSV
=======

CSV文件处理，支持导入、导出、读取等方法操作。

主要依赖 PHP SPL 中 [SplFileObject](http://php.net/manual/zh/class.splfileobject.php)  方法。

## 安装

使用 [composer](https://getcomposer.org/)：

```sh
composer require wangyongdong/SplCSV
```

## 读取

读取 CSV 文件全部内容，传入文件:

```php
$read = new SplCSV\Reader('read_line.csv');
$data = $read->read();
print_r($data);
```

也可以支读取行到行，从第二行读取10行：

```php
$read = new SplCSV\Reader('read_line.csv');
$data = $read->read('10', '10');
print_r($data);
```

## 写入

写入支持两种数组，示例多维：

```php
$writer = new SplCSV\Writer(__DIR__. '/write.csv');
$arr_2 = array(
    array('A1', 'A2', 'A3'),
    array('A4', 'A5', 'A6'),
    array('A7', 'A8', 'A9'),
);
$writer->writeArray($arr_2);
```

也可以传入一位数组:

```php
$writer = new SplCSV\Writer(__DIR__. '/write.csv');
$arr_1 = array('B1', 'B2', 'B3');
$writer->writeRow($arr_1);
```

## 导出

导出数据到 CSV 文件，并输出到浏览器，传入多数组:

```php
$arr = array(
    array('C1', 'C2', 'C3'),
    array('C4', 'C5', 'C6'),
);
SplCSV\Export::output($arr, __DIR__.'/write.csv');
```

> 具体可以查看 example 里