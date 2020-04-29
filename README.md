文件处理
=======

支持CSV、TXT文件处理，支持导入、导出、读取等方法操作。

主要依赖：

PHP SPL 中 [SplFileObject](http://php.net/manual/zh/class.splfileobject.php)  方法。
PHP generators [generators](https://www.php.net/manual/zh/language.generators.overview.php)  迭代器。

## 安装

使用 [composer](https://getcomposer.org/)：

```sh
composer require wangyongdong/ParseFileSpl
```

## 读取

读取 CSV 文件全部内容，传入文件:

```php
$csv = ParseFileSpl\Csv::getInstance();
// 读取
$iterator = $csv->read('csv_read.csv'); // 读取
$data = array();
foreach ($iterator as $line) {
    $data[] = $line;
}
print_r($data);
```

也可以支读取行到行，从第二行读取10行：

```php
$csv = ParseFileSpl\Csv::getInstance();
// 读取
$iterator = $csv->read('csv_read.csv', 10, 2); // 读取
$data = array();
foreach ($iterator as $line) {
    $data[] = $line;
}
print_r($data);
```

## 写入

写入数据支持二维数组：

```php
$csv = ParseFileSpl\Csv::getInstance();
$iterator = $csv->put(__DIR__. '/csv_write.csv', array('2ssss', 'ddd', '33fgfg3'), 'a+');
```

## 导出

导出数据到 CSV 文件，并输出到浏览器，传入多数组:

```php
$csv = ParseFileSpl\Csv::getInstance();
$csv->export(__DIR__.'/csv_export.csv', array(
   array('value1', 'value2', 'value3'),
   array('value4', 'value5', 'value6'),
));
```

> 具体可以查看 example
