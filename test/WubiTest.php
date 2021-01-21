<?php

include '../vendor/autoload.php';

use Vvk\Wubi\Wubi;
$obj = new Wubi();
$result = $obj->getCoding('中国');
print_r($result);