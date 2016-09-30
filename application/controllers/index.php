<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
//		$this->load->model('newsdetail_model');
		
    }
    
    function _remap($method,$params = array())
	{
		if(!$this->session->userdata('openid') )
    	{
    		redirect(site_url('login'));
    	}
		else
		{
			return call_user_func_array(array($this, $method), $params);
		}
	}
	
	
	/**
	 * 
	 * 
	 */
	public function index()
	{
		$data['news']= $this->newsdetail_model->getremlim();
		$this->load->view('index.php',$data);
	}
	
	
}
