<?php
//文本回复
function _response_text($object,$content){
	$textTpl = "<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[%s]]></MsgType>
				<Content><![CDATA[%s]]></Content>
				<FuncFlag>%d</FuncFlag>
				</xml>";
	$FuncFlag = 0;
	$resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), "text", $content,$FuncFlag);
	return $resultStr;
}
//单图文
function  _response_news($object,$newsContent){
	$newsTplHead = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[news]]></MsgType>
					<ArticleCount>1</ArticleCount>
					<Articles>";
	$newsTplBody = "<item>
					<Title><![CDATA[%s]]></Title> 
					<Description><![CDATA[%s]]></Description>
					<PicUrl><![CDATA[%s]]></PicUrl>
					<Url><![CDATA[%s]]></Url>
					</item>";
	$newsTplFoot = "</Articles>
					<FuncFlag>[%s]</FuncFlag>
					</xml>";
	$header = sprintf($newsTplHead, $object->FromUserName, $object->ToUserName, time());
	
	
	$title = $newsContent['title'];
	$desc = $newsContent['description'];
	$picUrl = $newsContent['picUrl'];
	$url = $newsContent['url'];
	$body = sprintf($newsTplBody, $title, $desc, $picUrl, $url);
	
	$FuncFlag = 0;
	$footer = sprintf($newsTplFoot, $FuncFlag);
	
	return $header.$body.$footer;
}

//多图文
function _response_multiNews($object,$newsContent)
{
	$newsTplHead = "<xml>
				    <ToUserName><![CDATA[%s]]></ToUserName>
				    <FromUserName><![CDATA[%s]]></FromUserName>
				    <CreateTime>%s</CreateTime>
				    <MsgType><![CDATA[news]]></MsgType>
				    <ArticleCount>%s</ArticleCount>
				    <Articles>";
	$newsTplBody = "<item>
				    <Title><![CDATA[%s]]></Title> 
				    <Description><![CDATA[%s]]></Description>
				    <PicUrl><![CDATA[%s]]></PicUrl>
				    <Url><![CDATA[%s]]></Url>
				    </item>";
	$newsTplFoot = "</Articles>
					<FuncFlag>0</FuncFlag>
				    </xml>";

	$bodyCount = count($newsContent);
	$bodyCount = $bodyCount < 10 ? $bodyCount : 10;

	$header = sprintf($newsTplHead, $object->FromUserName, $object->ToUserName, time(), $bodyCount);
	
	foreach($newsContent as $key => $value){
		$body .= sprintf($newsTplBody, $value['title'], $value['description'], $value['picUrl'], $value['url']);
	}

	$FuncFlag = 0;
	$footer = sprintf($newsTplFoot, $FuncFlag);

	return $header.$body.$footer;
}

?>