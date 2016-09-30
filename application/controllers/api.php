<?php
/**
 * Created by PhpStorm.
 * User: yaobin
 * Date: 16/8/18
 * Time: 13:25
 */

/**
 * 接口控制器
 *
 * @package		app
 * @subpackage	core
 * @category	controller
 * @author		yaobin<645894453@qq.com>
 *
 */
class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function get_pro_byid($id){
        $project = $this->sysconfig_model->chenck_pro($id);
        echo $project;
    }

//    public function authorize() {
//        $open_id = $this->session->userdata('openid');
//        if(empty($open_id)) {
//            if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
//                $code = $_GET['code'];
//                if(empty($code)){
//                    $url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
//                    redirect("https://open.weixin.qq.com/connect/oauth2/authorize?appid=".APP_ID."&redirect_uri=".urlencode($url)."&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect");
//                } else {
//                    $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.APP_ID.'&secret='.APP_SECRET.'&code='.$code.'&grant_type=authorization_code';
//                    $result = file_get_contents($url);
//                    $jsonInfo = json_decode($result, true);
//                    $open_id = $jsonInfo['openid'];
//                    if(!empty($open_id)) {
//                        $this->session->set_userdata('openid', $open_id);
//                    }
//                }
//            }
//        }
//        $uri = "http://www.funmall.com.cn/b_house/index/";
//        if(!empty($open_id)) {
//            //file_get_contents('http://www.funmall.com.cn/api/update_weixin_user/' . $open_id);
//            $uri .= $open_id . '/';
//            $funmallDB = $this->load->database("funmall", True);
//            $funmallDB->from('wx_user');
//            $funmallDB->where('open_id', $open_id);
//            $funmallDB->order_by('updated DESC');
//            $wxUser = $funmallDB->get()->row_array();
//            if(!empty($wxUser)) {
//                $uri .= $wxUser['broker_id'] . '/';
//            }
//        }
//        redirect($uri);
//    }

    public function view_art($broker_id) {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            $code = $_GET['code'];
            if(empty($code)){
                $url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
                redirect("https://open.weixin.qq.com/connect/oauth2/authorize?appid=".APP_ID."&redirect_uri=".urlencode($url)."&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect");
            } else {
                $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.APP_ID.'&secret='.APP_SECRET.'&code='.$code.'&grant_type=authorization_code';
                $result = file_get_contents($url);
                $jsonInfo = json_decode($result, true);
                $open_id = $jsonInfo['openid'];

                $this->funmall_model->bindBroker($open_id, $broker_id);
                file_get_contents('http://www.funmall.com.cn/api/update_weixin_user/' . $open_id);

                $uri = "http://www.funmall.com.cn/api/view_art/" . $open_id . "/" . $broker_id;
                redirect($uri);
            }
        }
    }

    public function index() {
        $echoStr = $_GET["echostr"];
        if(isset($echoStr)) {
            if($this->checkSignature()){
                echo $echoStr;
                exit;
            }
        } else {
            $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

            if (!empty($postStr)){
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $RX_TYPE = trim($postObj->MsgType);
                $result = "";
                switch ($RX_TYPE) {
                    case "text":
                        $result = $this->receiveText($postObj);
                        break;
                    case "event":
                        $result = $this->receiveEvent($postObj);
                        break;
                    case "image":
                        //$result = $this->receiveImage($postObj);
                        break;
                    default:
                        $result = "Unknow msg type: ".$RX_TYPE;
                        break;
                }
                echo $result;
                exit;
            } else {
                echo "";
                exit;
            }
        }
    }


    private function checkSignature() {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = 'ada823k21812jasd123dfg6fsdf';
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if($tmpStr == $signature){
            return true;
        } else {
            return false;
        }
    }

    private function receiveEvent($object) {
        switch ($object->Event) {
            case "subscribe":
                $FromUserName = str_replace("", "", $object->FromUserName);
                if (!empty($object->EventKey)){
//                    $this->sysconfig_model->test(str_replace("qrscene_", "", $object->EventKey));
                    $parent_id = str_replace("qrscene_", "", $object->EventKey);
                    $this->sysconfig_model->bindUesr($FromUserName, $parent_id);
                }else{
                    $this->sysconfig_model->bindUesr($FromUserName);
                }
                break;
            case "unsubscribe":
                break;
            case "SCAN":
                break;
            case "CLICK":
                break;
            case "VIEW":
                break;
            case "LOCATION":
                break;
        }
//        return $this->transmitText($object, $content);
    }

    private function transmitText($object, $content) {
        $textTpl = "
			<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[text]]></MsgType>
				<Content><![CDATA[%s]]></Content>
				<FuncFlag>0</FuncFlag>
			</xml>
		";
        return sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
    }

    private function transmitNews($object, $arr_item) {
        if(!is_array($arr_item))
            return;

        $itemTpl = "
			<item>
		        <Title><![CDATA[%s]]></Title>
		        <Description><![CDATA[%s]]></Description>
		        <PicUrl><![CDATA[%s]]></PicUrl>
		        <Url><![CDATA[%s]]></Url>
    		</item>
		";
        $item_str = "";
        foreach ($arr_item as $item)
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);

        $newsTpl = "
		<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[news]]></MsgType>
		<Content><![CDATA[]]></Content>
		<ArticleCount>%s</ArticleCount>
		<Articles>$item_str</Articles>
		</xml>
		";
        return sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item));
    }


    public function post($url, $post_data, $timeout = 300){
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/json;encoding=utf-8',
                'content' => urldecode(json_encode($post_data)),
                'timeout' => $timeout
            )
        );
        $context = stream_context_create($options);
        return file_get_contents($url, false, $context);
    }


    public function get_access_token() {
        $this->load->config('wxpay_config');
        $appid = $this->config->item('appid');
        $secret = $this->config->item('appsecret');
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}";
        $response = file_get_contents($url);
        return json_decode($response)->access_token;
    }

    public function get_or_create_ticket($id = '', $action_name = 'QR_SCENE') {
        $access_token = $this->get_access_token();
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token;
        @$post_data->expire_seconds = 2592000;
        @$post_data->action_name = $action_name;
        @$post_data->action_info->scene->scene_id = $id;
        $ticket_data = json_decode($this->post($url, $post_data));
        $ticket = $ticket_data->ticket;
        $img_url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($ticket);
        $data['img'] = $img_url;
        $this->load->view('scan.php',$data);
//        return $ticket;
    }

}