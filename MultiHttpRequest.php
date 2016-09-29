<?php
/**
一个简单的多线程采集例子  Curl 多线程类 http://blog.eiodesign.com/archives/86
 * 使用方法：
 *
if ($arrayimageurl) {
set_time_limit (0);
$arrayimageurl = array_unique($arrayimageurl);
$attachs = [];
//图片大于6张，分组采集
if (count($arrayimageurl) > 6) {
$oldimglist = array_chunk($arrayimageurl, 6,true);
$mpurl = new \com\MultiHttpRequest();
foreach ($oldimglist as $key=>$value) {
$mpurl->set_urls($value);
$images = $mpurl->start();
if (is_array($images)) {
foreach ($images as $image_key => $image_value) {
if (!empty($image_value)) {
$attach = model('Upload','logic')->upload($image_value,['imgUrl'=>$image_key],'dwonFile')->getFileInfo();
if ($attach['state'] == 'SUCCESS') {
$imagereplace['oldimageurl'][] = $image_key;
$imagereplace['newimageurl'][] = $attach['url'];
$attachs[] = $attach;
}
}
unset($image_key,$image_value);
}
}
}
} else {
$mpurl = new \com\MultiHttpRequest();
$mpurl->set_urls($arrayimageurl);
$images = $mpurl->start();
if (is_array($images)) {
foreach ($images as $image_key => $image_value) {
if (!empty($image_value)) {
$attach = model('Upload','logic')->upload($image_value,['imgUrl'=>$image_key],'dwonFile')->getFileInfo();
if ($attach['state'] == 'SUCCESS') {
$imagereplace['oldimageurl'][] = $image_key;
$imagereplace['newimageurl'][] = $attach['url'];
$attachs[] = $attach;
}
}
unset($image_key,$image_value);
}
}
}
}
 */

namespace com;

class MultiHttpRequest {
    public $urls = array();
    public $curlopt_header = 0;
    public $method = "GET";

    function __construct($urls = false) {
        $this->urls = $urls;
    }

    function set_urls($urls) {
        $this->urls = $urls;
        return $this;
    }

    function is_return_header($b) {
        $this->curlopt_header = $b;
        return $this;
    }

    function set_method($m) {
        $this->medthod = strtoupper($m);
        return $this;
    }

    function start() {
        if(!is_array($this->urls) or count($this->urls) == 0){
            return false;
        }
        $curl = $text = array();
        // 创建批处理cURL句柄
        $handle = curl_multi_init();
        //增加和设置句柄
        foreach($this->urls as $k=>$v){
            $curl[$k] = $this->add_handle($handle, $v);
        }
        // 执行批处理句柄
        $this->exec_handle($handle);
        foreach($this->urls as $k=>$v){
            $text[$k] =  curl_multi_getcontent($curl[$k]);
            curl_multi_remove_handle($handle, $curl[$k]);
        }
        curl_multi_close($handle);

        return $text;
    }

    private function add_handle($handle, $url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_HEADER, $this->curlopt_header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_multi_add_handle($handle, $curl);
        return $curl;
    }

    private function exec_handle($handle) {
        $flag = null;
        do {
            curl_multi_exec($handle, $flag);
        } while ($flag > 0);
    }

    public function get_content($url){
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT,10);
        return curl_exec($ch);
    }
}