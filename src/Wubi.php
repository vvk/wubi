<?php

/**
 * 编码文件格式：
 * 第一列：汉字
 * 第二列：拼音
 * 第三列：Unicode 编码
 * 第四列：86版五笔字型编码（需依国家标准字形校对）
 * 第五列：98版五笔字型编码（需依国家标准字形校对）
 * 第六列：06版五笔字型编码（需依国家标准字形校对）
 * 第七列：中国大陆笔顺（需依国家标准字形和规范笔顺校对）
 * 第八列：中国台湾笔顺（与“CNS11643中文標準交換碼全字庫”数据同步）
 * Class Vvk\Wubi\Wubi
 */

namespace Vvk\Wubi;

class Wubi
{
	protected $codingFile;
	protected $codingData = [];
	protected $fieldMap = [
	    0 => 'text',
        1 => 'pinyin',
        2 => 'unicode',
        3 => 'wubi86',
        4 => 'wubi98',
        5 => 'wubi06',
        6 => 'stroke_order_zh_cn',
        7 => 'stroke_order_zh_tw',
    ];

	public function __construct(string $codingFile = '')
	{
	    if (empty($codingFile)) {
	        $this->codingFile = dirname(__FILE__).DIRECTORY_SEPARATOR.'wubi_pinyin_unicode_data';
        }

        if (!file_exists($this->codingFile)) {
            throw new \Exception('codingFile '.$this->codingFile.' is not exists.');
        }
	}

    /**
     * 获取编码
     * @param string $text
     * @return array
     */
    public function getCoding(string $text)
    {
        if (empty($text)) {
            return [];
        }
        $text = $this->filterText($text);
        if (empty($text)) {
            return [];
        }

        $codingData = $this->readCodingData();
        $length = mb_strlen($text);
        $result = [];
        for ($i = 0; $i < $length; $i++) {
            $char = trim(mb_substr($text, $i, 1));
            if (isset($result[$char]) || empty($char)) {
                continue;
            }
            $result[$char] = $codingData[$char] ?? [];
            if (!empty($result[$char])) {
                $result[$char]['wubi86'] = empty($result[$char]['wubi86']) ? [] : explode(',', $result[$char]['wubi86']);
            }
        }
        $result = array_filter($result);
        return $result;
	}

    /**
     * 过滤非汉字
     * @param  string $text
     * @return string
     */
    protected function filterText(string $text)
    {
        if (empty($text)) {
            return $text;
        }

        $partten = '/[^\x{4e00}-\x{9fa5}]/u';
        return preg_replace($partten, '', $text);
    }

    /**
     * 获取编码数据
     * @return array
     */
	protected function readCodingData():array
    {
        if (!empty($this->codingData)) {
            return $this->codingData;
        }

        $fp = fopen($this->codingFile, 'r');
        while (!feof($fp)) {
            $row = fgets($fp);
            $row = trim($row);
            $arr = explode('|', $row);
            $item = [];
            foreach ($this->fieldMap as $index => $field) {
                $item[$field] = $arr[$index] ?? '';
            }
            $this->codingData[$item['text']] = $item;
        }
        fclose($fp);
        return $this->codingData;
    }
}