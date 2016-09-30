<?php

class wechat_oauth
{
    private static $appid = 'wx73b70de7ace04705';
    private static $appsecret = "c588f1d5aaff2653dae3d49cf44219fe";

    public static function post_oauth($snsapi_userinfo)
    {
        $redirect_uri = urlencode("http://test41.kssina.com/index.php/login/oauth");
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . self::$appid . "&redirect_uri=" . $redirect_uri . "&response_type=code&scope=" . $snsapi_userinfo . "&state=STATE#wechat_redirect";
        //echo $url;die;
        return $url;
    }

    public static function get_openid($code)
    {
        $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . self::$appid . '&secret=' . self::$appsecret . '&code=' . $code . '&grant_type=authorization_code';
        $res_http = wechat_common::get_http($get_token_url);
        //本地测试
        //$res_http='{"access_token":"ACCESS_TOKEN","expires_in":7200,"refresh_token":"REFRESH_TOKEN","openid":"openid","scope":"SCOPE","unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"}';
        $res = json_decode($res_http);
        //写入日志
        //wechat_common::write_log("D:/phproot/fruit/wechat/logs/wechat_oauth.txt",date("Y-m-d H:i:s")."\r\n".$res_http."\r\n");
        wechat_common::write_log(dirname(__FILE__) . "/logs/wechat_oauth_" . date("Y-m-d") . ".txt", date("Y-m-d H:i:s") . "\r\n" . $res_http . "\r\n");

        return $res;
    }

}


class wechat_access_token
{
    private static $appid = 'wx73b70de7ace04705';
    private static $appsecret = "c588f1d5aaff2653dae3d49cf44219fe";

    public function get_access_token()
    {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(file_get_contents(dirname(__FILE__) . "/access_token.json"));
        if ($data->expire_time < time()) {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . self::$appid . "&secret=" . self::$appsecret;
            $res_http = wechat_common::get_http($url);
            wechat_common::write_log(dirname(__FILE__) . "/logs/wechat_access_token_" . date("Y-m-d") . ".txt", date("Y-m-d H:i:s") . "\r\n" . $res_http . "\r\n");
            $res = json_decode($res_http);
            $access_token = $res->access_token;
            if ($access_token) {
                $data->expire_time = time() + 7000;
                $data->access_token = $access_token;
                $fp = fopen(dirname(__FILE__) . "/access_token.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $access_token = $data->access_token;
        }
        return $access_token;
    }
}

class wechat_user
{

    public function __construct()
    {

    }


    public static function get_user_info($access_token, $openid)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
        $res_http = wechat_common::get_http($url);
        wechat_common::write_log(dirname(__FILE__) . "/logs/wechat_user_" . date("Y-m-d") . ".txt", date("Y-m-d H:i:s") . "\r\n" . $res_http . "\r\n");
        $res = json_decode($res_http);//返回对象
        //$res = json_decode($this->httpGet($url),true);//返回数组
        return $res;
    }

}

class wechat_jssdk
{
    private static $appid = 'wx73b70de7ace04705';
    private static $appsecret = "c588f1d5aaff2653dae3d49cf44219fe";

    public function __construct()
    {
    }

    public static function getSignPackage()
    {
        $jsapiTicket = wechat_jssdk::getJsApiTicket();
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $timestamp = time();
        $nonceStr = wechat_jssdk::createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);
        $signPackage = array(
            "appid" => self::$appid,
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    private static function createNonceStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private static function getJsApiTicket()
    {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(file_get_contents(dirname(__FILE__) . "/jsapi_ticket.json"));
        if ($data->expire_time < time()) {
            $accessToken = wechat_access_token::get_access_token();
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode(wechat_common::get_http($url));
            $ticket = $res->ticket;
            if ($ticket) {
                $data->expire_time = time() + 7000;
                $data->jsapi_ticket = $ticket;
                $fp = fopen(dirname(__FILE__) . "/jsapi_ticket.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $ticket = $data->jsapi_ticket;
        }

        return $ticket;
    }

}


class wechat_common
{

    public static function get_http($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

    public static function write_log($file, $content)
    {
        $fp = fopen($file, "a+");
        fwrite($fp, $content);
        fclose($fp);
    }

}