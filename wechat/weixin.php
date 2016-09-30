<?php
define("TOKEN", "qihang");
$wechatObj = new wechatCallbackapiTest();
if (isset($_GET['echostr'])) {
    $wechatObj->valid();
}else{
    $wechatObj->responseMsg();
}

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
		//$echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }
	
	
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	
	/*private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}*/

    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            /*$fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
            $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";*/
			$RX_TYPE = trim($postObj->MsgType);
			switch ($RX_TYPE)
            {
                case "text":
                    $resultStr = $this->receiveText($postObj);
                    break;
                case "event":
                    $resultStr = $this->receiveEvent($postObj);
                   	break;
                default:
                    $resultStr = "unknow msg type: ".$RX_TYPE;
                    break;
            }
			echo $resultStr;
			
        }else{
            echo "";
            exit;
        }
    }
	
	private function receiveText($object)
    {
		$fromUsername = $object->FromUserName;
		$toUsername = $object->ToUserName;
		$keyword = strtolower(trim($object->Content));
		$time = time();
		
		require_once 'responseNews.func.inc.php';			
		switch($keyword){
			
			
			default:
				
				$contentStr = "欢迎关注启航双语幼儿园";
				$resultStr =  _response_text($object,$contentStr);
				break;
		}
		return 	$resultStr;	
    }

	
	//事件类别
	private function receiveEvent($object)
    {
        $fromUsername = $object->FromUserName;
		$toUsername = $object->ToUserName;
		$keyword = trim($object->Content);
		$time = time();
		$textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0</FuncFlag>
					</xml>";
        switch ($object->Event)
        {
            case "subscribe"://关注事件，回复关注欢迎语
			
                require_once 'responseNews.func.inc.php';
				$contentStr = "欢迎关注启航双语幼儿园";
				$resultStr =  _response_text($object,$contentStr);
                break;
        }
		return $resultStr;
    }
}
 


?>