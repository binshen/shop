<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 2016/5/1
 * Time: 11:47
 */
class Ajax extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ajax_model');
    }

   function get_product($flag,$page=2,$type=-1,$limit=6){
       $data=$this->ajax_model->get_product($flag,$page,$type,$limit);
       echo json_encode($data);
   }

    /** 这里捞取省份信息 */
    public function getprovince(){
        $data=$this->ajax_model->getprovince();
        echo json_encode($data);
    }

    /** 这里捞取城市信息 */
    public function getcity($code){
        $data=$this->ajax_model->getcity($code);
        echo json_encode($data);
    }

    /** 这里捞取县区信息 */
    public function getarea($code){
        $data=$this->ajax_model->getarea($code);
        echo json_encode($data);
    }

    /** 这里保存订单信息 */
    function save_order($address_id,$pid){
        $data=$this->ajax_model->save_order($address_id,$pid);
        echo json_encode($data);
    }

    /** 这里保存订单信息 */
    function get_order($page=2,$status=null){
        $data=$this->ajax_model->get_order($page,$status);
        echo json_encode($data);
    }

    /** 这里修改默认地址 */
    function default_address($address_id){
        $data=$this->ajax_model->default_address($address_id);
        echo json_encode($data);
    }

    /** 这里做发货提醒 */
    function change_remind($id){
        $data=$this->ajax_model->change_remind($id);
        echo json_encode($data);
    }

    /** 这里做保存收藏 */
    function save_house($id){
        $data=$this->ajax_model->save_house($id);
        echo json_encode($data);
    }

    /** 捞取收藏信息 */
    function get_house($page=1){
        $data=$this->ajax_model->get_house($page);
        echo json_encode($data);
    }

    public function notify()
    {
        $this->load->model('product_model');
        $msg = array();
        $postStr = file_get_contents('php://input');
        $msg = (array)simplexml_load_string($postStr, 'SimpleXMLElement',LIBXML_NOCDATA);

        $order_num = $msg['out_trade_no'];
        $openid = $msg['openid'];
        $rs = $this->product_model->confirm_order($order_num,$openid);
        echo $rs;

    }
}