# favorite
收藏

jQuery监听文件上传实现进度条效果http://www.imooc.com/article/5879

var xhr=new XMLHttpRequest(); xhr.upload.onprogress=function(e){}
var xhrOnProgress=function(fun) { 
xhrOnProgress.onprogress = fun; //绑定监听 //使用闭包实现监听绑
 return function() { //通过$.ajaxSettings.xhr();获得XMLHttpRequest对象
 var xhr = $.ajaxSettings.xhr(); //判断监听函数是否为函数
 if (typeof xhrOnProgress.onprogress !== 'function') return xhr; //如果有监听函数并且xhr对象支持绑定时就把监听函数绑定上去
 if (xhrOnProgress.onprogress && xhr.upload) { xhr.upload.onprogress = xhrOnProgress.onprogress; } return xhr; } }
$.ajax({ url: url, type: 'POST', xhr:xhrOnProgress(function(e){ var percent=e.loaded / e.total;//计算百分比 var percentComplete = ((e.loaded / e.total) || 0) * 100; }) });


jQuery的deferred对象详解 - 阮一峰的网络日志
http://www.ruanyifeng.com/blog/2011/08/a_detailed_explanation_of_jquery_deferred_object.html


禁止google自动跳转hk
https://www.google.com/ncr

css sprite 
http://css.spritegen.com/

win事件查看
eventvwr.exe

融云
http://www.rongcloud.cn/docs/

PHPGTK
http://gtk.php.net/download.php?language=en-US


http://winbinder.org/download.php

WinBinder让phper可以在window系统开发桌面软件
WinBinder 是一种开源的 PHP 动态扩展(.dll)，也算是脚本编程语言，为php在window下的开发提供用户界面UI，它负责调用window的API接口。其运行 PHP 程序员轻松地使用PHP 创建 Windows 应用程序。当然，这个只能在 Windows 下运行。本身是一个软件，php程序员可以通过这个软件开发界面。官方网站说得很不错，无须编译php.只要保存文件扩展为.phpw，然后用 php.exe打开就可以运行。

下载解压最新版
\WinBinder.2010.10.14\phpcode\examples，任找一个.phpw扩展名的文件
选择打开方式为： 
WinBinder.2010.10.14\binaries\php533\php-win.exe

