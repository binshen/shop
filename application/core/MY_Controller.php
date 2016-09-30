<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 扩展业务控制器   
 */

class MY_Controller extends CI_Controller
{
	/**
	 * MY_Controller constructor.
     */
	public function __construct ()
    {
        parent::__construct();
        date_default_timezone_set('PRC');
        $this->cismarty->assign('base_url',base_url());//url路径
//$this->session->sess_destroy();die;
		$this->load->config('wxpay_config');
		$appid = $this->config->item('appid');
		$secret = $this->config->item('appsecret');

		if(!$this->session->userdata('openid')){
			if(empty($_GET['code'])){
				$url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
				$url = urlencode($url);
				redirect("https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$url}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect");
			}else{
				$j_access_token = file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$secret}&code={$_GET['code']}&grant_type=authorization_code");
				$a_access_token = json_decode($j_access_token,true);
				$openid = $a_access_token["openid"];

				//获取用户基本信息
				$rs = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}");
				$rs = json_decode($rs,true);
				$access_token = $rs['access_token'];
				$rs = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN");
				$rs = json_decode($rs,true);

				$this->sysconfig_model->check_openid($openid);
				if($rs['subscribe'] != 1){
					$userID = $_GET['userID'] ? $_GET['userID'] : '';
					$r_url = 'api/get_or_create_ticket/'.$userID;
					redirect(site_url($r_url));
					exit();
				}
				$this->session->set_userdata('openid', $openid);
				$this->session->set_userdata('headimgurl', $rs['headimgurl']);
				$this->session->set_userdata('nickname', $rs['nickname']);
			}
		}
    }


//
//	public function check_openid($openid){
//		$user_info = $this->db2->select()->from('user_info')->where('openid',$openid)->get()->row_array();
//
//		$rs = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}");
//		$rs = json_decode($rs,true);
//		$access_token = $rs['access_token'];
//		$rs = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN");
//		$rs = json_decode($rs,true);
//
//		if($rs['subscribe'] < 1){
//			return -1;
//		}
//		$this->session->set_userdata('headimgurl', $rs['headimgurl']);
//		if($user_info){
//			$this->session->set_userdata('username',$user_info['name']);
//		}else{
//
//			$data = array(
//				'name'=>$rs['nickname'],
//				'sex'=>$rs['sex'],
//				'openid'=>$openid
//			);
//			$this->db2->insert('user_info',$data);
//
//			$this->session->set_userdata('username',$rs['nickname']);
//		}
//		return 1;
//	}



	//重载smarty方法assign
	public function assign($key,$val) {
        $this->cismarty->assign($key,$val);
    }  

    
	//重载smarty方法display
    public function display($html) {
        $this->cismarty->display($html);  
    }

    
    /**
     * 树状结构菜单
     **/
    public function subtree($arr,$id=0,$lev=1)
    {
    	static $subs = array();
    	foreach($arr as $v){
    		if((int)$v['parent_id']==$id){
    		    $v['lev'] = $lev;
    		    $subs[]=$v;
    		    $this->subtree($arr,$v['id'],$lev+1);
    		}
    	}
    	return $subs;
    }
	
	/**
     * 获取页码列表
     * 例如<上一页>...56789<下一页>
     * @param int $total 总页数
     * @param int $current 当前页
     * @param int $page_list_size 显示页码个数
     * @return array 显示页码的数组
     **/
    public function get_page_list($total,$current,$page_list_size = '7')
    {
	    $page= array();
		if($total<$page_list_size){
			for($i=1;$i<=$total;$i++){
				$page[]=$i;
			}
		}else{
			if($current <= ceil($page_list_size/2)){
			//当前页小于居中页码，则正常打印
				for($i=1;$i<=$page_list_size;$i++){
					$page[]=$i;
				}
				
			}else if($current > ($total - ceil($page_list_size/2))){
			//最后几页正常打印
				for($i=0;$i<$page_list_size;$i++){
					$page[]=$total-$i;
				}
				$page = array_reverse($page);
			}else{
				for($i=$current-floor($page_list_size/2);$i<=$current+floor($page_list_size/2);$i++){
					$page[]=$i;
				}
			}
		}
		//return array_reverse($page);
		return $page;
    }

	public function buildWxData(){
		$signPackage = $this->wxjssdk->wxgetSignPackage();
		//变量
		$this->cismarty->assign('wxappId',$signPackage["appId"]);
		$this->cismarty->assign('wxtimestamp',$signPackage["timestamp"]);
		$this->cismarty->assign('wxnonceStr',$signPackage["nonceStr"]);
		$this->cismarty->assign('wxsignature',$signPackage["signature"]);
	}

	private function wxcreateNonceStr($length = 16) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for ($i = 0; $i < $length; $i++) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}
		return $str;
	}
}


/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */