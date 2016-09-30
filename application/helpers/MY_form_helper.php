<?php
/**
 * 返回AJAX提交表单后的JSON
 * $callbackType 默认的参数"closeCurrent"可以用于关闭当前窗体，'forward'跳转到$forwardUrl的网址。
 * 成功返回格式：{"statusCode":"200", "message":"操作成功", "navTabId":"navNewsLi", "forwardUrl":"", "callbackType":"closeCurrent"}
 * 失败返回格式:{"statusCode":"300", "message":"操作失败"}
 */
function form_submit_json($statusCode,$message,$navTabId="",$forwardUrl="",$callbackType="closeCurrent"){
    $returnType['statusCode'] =  $statusCode;
    $returnType['message'] = $message;
    $returnType['navTabId'] = $navTabId;
    $returnType['forwardUrl'] = $forwardUrl;
    $returnType['callbackType'] = $callbackType;
    echo (json_encode($returnType));
}

function alert_msg($msg,$url){
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'><script>alert('$msg');window.location.href='$url';</script>";
}

function cutstr_html($string,$length=0,$ellipsis='…'){
	$string=strip_tags($string);
	$string=preg_replace('/\n/is','',$string);
	$string=preg_replace('/ |　/is','',$string);
	$string=preg_replace('/&nbsp;/is','',$string);
	preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/",$string,$string);
	if(is_array($string)&&!empty($string[0])){
		if(is_numeric($length)&&$length){
			$string=join('',array_slice($string[0],0,$length)).$ellipsis;
		}else{
			$string=implode('',$string[0]);
		}
	}else{
		$string='';
	}
	return $string;
}



function clearHtml($content){
	$content=preg_replace("/<a[^>]*>/i","",$content);
	$content=preg_replace("/<\/a>/i","",$content);
	$content=preg_replace("/<div[^>]*>/i","",$content);
	$content=preg_replace("/<\/div>/i","",$content);
	$content=preg_replace("/<!--[^>]*-->/i","",$content);//注释内容
	$content=preg_replace("/style=.+?['|\"]/i",'',$content);//去除样式
	$content=preg_replace("/class=.+?['|\"]/i",'',$content);//去除样式
	$content=preg_replace("/id=.+?['|\"]/i",'',$content);//去除样式
	$content=preg_replace("/lang=.+?['|\"]/i",'',$content);//去除样式
	$content=preg_replace("/width=.+?['|\"]/i",'',$content);//去除样式
	$content=preg_replace("/height=.+?['|\"]/i",'',$content);//去除样式
	$content=preg_replace("/border=.+?['|\"]/i",'',$content);//去除样式
	$content=preg_replace("/face=.+?['|\"]/i",'',$content);//去除样式
	$content=preg_replace("/face=.+?['|\"]/",'',$content);//去除样式 只允许小写 正则匹配没有带 i 参数
	return $content;
}


function createlockid($name=NULL){
	$lockid=uniqid(microtime(), TRUE).rand(1,10000); 
	if(!empty($name)){
		$lockid=$name.uniqid($name, TRUE).rand(1,10000); 	
	}
	return md5($lockid);
}