<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 前台用户登陆控制器
 * 
 * @package		app
 * @subpackage	core
 * @category	controller
 * @author		
 *
 */
class Login extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
		include FCPATH.'wechat/wechat_api.php';
		$this->load->model('wechats_model');
    }
    
    //默认公司简介画面
    public function index()
    {
		//发起用户授权
        //
		//redirect(wechat_oauth::post_oauth("snsapi_userinfo"));
		redirect(wechat_oauth::post_oauth("snsapi_base"));
		//本地测试
		//redirect('login/oauth?code=1111');
		
    	
    }
	
	public function oauth(){
		if (isset($_GET['code'])){
			$code = $_GET["code"];
			//获取oppenid;
			$res=wechat_oauth::get_openid($code);
			$openid = $res->openid;
			if(!empty($openid)){
				$user_info['openid'] = $openid;
				//$user_info['username'] = $user["username"];
				
				//print_r($this->session->userdata('user_openid'));
				//获取用户信息
				$access_token=wechat_access_token::get_access_token();
				$user_info2=wechat_user::get_user_info($access_token,$openid);
				//print_r($user_info2);
				//die;
				if($user_info2->subscribe=="1"){
				
					$this->session->set_userdata($user_info);
					if(!empty($user_info2->openid)){
						//插入用户信息
						$user=$this->wechats_model->get($openid);
						if($user){
							
						}
						else{
							$user_data['openid']=$user_info2->openid;
							$user_data['nickname']=$user_info2->nickname;
							$user_data['sex']=$user_info2->sex;
							$user_data['city']=$user_info2->city;
							$user_data['province']=$user_info2->province;
							$user_data['country']=$user_info2->country;
							$user_data['headimgurl']=$user_info2->headimgurl;
							//$user_data['privilege']=!empty($user_info2->privilege)?$user_info2->privilege:'';
							$user_data['unionid']=!empty($user_info2->unionid)?$user_info2->privilege:'';
							$user_data['createdate']=time();
							//$user_data['subscribe']=1;
							$user_data['isyz']=0;
							$this->wechats_model->add($user_data);
						}
					}
					redirect('index');
					exit;
					
				}else{
					redirect('subscribe');
					exit;
				}
				
				
			}
			else{
				echo "获取失败";
			}
			
			exit;
			
		}else{
			echo "NO CODE";
		}
	}

}
