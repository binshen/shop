<?php

if (! defined('BASEPATH'))

    exit('No direct script access allowed');



/**

 * 系统设置模型

 * 可用于抓取系统初始数据以及定义系统变量和获取一些首页需要的信息

 */

class Sysconfig_model extends MY_Model

{

	protected $tables = array(

    );

    public function __construct ()
    {
        parent::__construct();

    }

    public function __destruct ()
    {
        parent::__destruct();
    }

//	public function check_openid($openid){
//		$user_info = $this->db->select()->from('user_info')->where('openid',$openid)->get()->row_array();
//
//		$this->load->config('wxpay_config');
//		$appid = $this->config->item('appid');
//		$secret = $this->config->item('appsecret');
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

	public function bindUesr($FromUserName, $parent_id = null){

		$rs = $this->db->select()->from('user_info')->where('openid',$FromUserName)->get()->row();
		if($rs && $parent_id){
			$parent_openid = $this->db->select('openid')->from('user_info')->where('id',$parent_id)->get()->row();
			$this->db->where('openid',$FromUserName);
			$this->db->update('user_info',array('parent_openid'=>$parent_openid->openid));
			return;
		}

		$data = array(
			'openid'=>$FromUserName,
			'cdate'=>date('Y-m-d H:i:s',time())
		);

		if($parent_id){
			$parent_openid = $this->db->select('openid')->from('user_info')->where('id',$parent_id)->get()->row();
			$data['parent_openid'] = $parent_openid->openid;
		}
		$this->db->insert('user_info',$data);
	}

	public function test($a){
		$data = array(
			'xml'=>$a,
			'cdate'=>date('Y-m-d H:i:s',time())
		);
		$this->db->insert('test',$data);
	}

	public function check_openid($openid){
		$rs = $this->db->select()->from('user_info')->where('openid',$openid)->get()->row();
		if(!$rs){
			$this->db->insert('user_info',array(
				'openid'=>$openid,
				'cdate'=>date('Y-m-d H:i:s',time())
			));
		}
	}

	

}



/* End of file sysconfig_model.php */

/* Location: ./application/models/sysconfig_model.php */