# 五笔编码查询 

## 说明 

* 一共收集了 70322 条文字数据，包括常用汉字、不常用汉字及部分偏旁部首的五笔编码。
* 返回的数据包括拼音、Unicode 编码、86版五笔字型编码、98版五笔字型编码、08版五笔字型编码、中国大陆笔顺、中国台湾笔顺。
* 86版五笔字型编码返回为数组，使用第一个即可。
* 由于不同输入法的词库有所不同，部分文字可能不会正常打出。

## 安装与使用

### 安装：

```sh
composer require vvk/wubi
```

### 使用：

```shell
use Vvk\Wubi\Wubi;
$obj = new Wubi();
$result = $obj->getCoding('中国');
print_r($result);
/*
返回结果：
Array
(
    [中] => Array
        (
            [text] => 中
            [pinyin] => zhōng
            [unicode] => U+4E2D
            [wubi86] => Array
                (
                    [0] => k
                    [1] => kh
                    [2] => khk
                )

            [wubi98] => khk
            [wubi06] => khk
            [stroke_order_zh_cn] => 2512
            [stroke_order_zh_tw] => 2512
        )

    [国] => Array
        (
            [text] => 国
            [pinyin] => guó
            [unicode] => U+56FD
            [wubi86] => Array
                (
                    [0] => l
                    [1] => lgy
                    [2] => lgyi
                )

            [wubi98] => lgyi
            [wubi06] => lgyi
            [stroke_order_zh_cn] => 25112141
            [stroke_order_zh_tw] => 25112141
        )
)
*/
```

