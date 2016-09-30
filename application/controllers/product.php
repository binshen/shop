<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: yaobin
 * Date: 2016/4/29
 * Time: 22:03
 */
class Product extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('CI_Wechat');
        $this->load->model('product_model');
        $this->buildWxData();
        $userID = $this->product_model->get_userID($this->session->userdata('openid'));
        $this->cismarty->assign('userID',$userID);
    }

    function index($id){
        $data = $this->product_model->get_product_info($id);
        $this->cismarty->assign('data',$data);
        $this->cismarty->display('index.html');
    }
    
    function product_main($flag=1){
        $data=$this->product_model->get_product_main($flag);
        $this->cismarty->assign('data',$data);
        $this->cismarty->display('product.html');
    }
    
    function product_list($id,$flag=1){
        $data=$this->product_model->get_product_list($id,$flag);
        $this->cismarty->assign('data',$data);
        $this->cismarty->display('product_list.html');
    }

    function product_info($id,$html_flag=-1){
        $data=$this->product_model->get_product_info($id);
        $this->cismarty->assign('html_flag',$html_flag);
        $this->cismarty->assign('data',$data);
        $this->cismarty->display('product_info.html');
    }


    function save_address(){
        $rs = $this->product_model->save_address();
        echo $rs;
    }

    function edit_address($id){
        $data = $this->product_model->get_address($id);
        $this->cismarty->assign('data',$data);
        $this->cismarty->display('edit_address.html');
    }

    function delete_address($id){
         $this->product_model->delete_address($id);
         redirect('product/my_address');
    }

    /** 这里保存订单信息 */
    function save_order(){
        $order_id = $this->product_model->save_order();
        if($order_id){
            redirect(site_url('product/pay').'/'.$order_id);
        }
    }

    /** 这里显示订单信息 */
    function show_order(){
        $data=$this->product_model->show_order();
        $tel = $this->product_model->get_tel();
        $this->cismarty->assign('data',$data);
        $this->cismarty->assign('tel',$tel);
        die($tel);
        $this->cismarty->display('my_order.html');
    }

    /** 这里显示订单详情 */
    function order_info($id){
        $data = $this->product_model->order_info($id);
        $data['express'] = '';
        if($data['main']['express']){
            $result = file_get_contents("http://www.kuaidi100.com/query?type={$data['main']['express']}&postid={$data['main']['express_num']}");
            $result = json_decode($result);
            $data['express'] = $this->json_array($result);
        }
        $this->cismarty->assign('data',$data);
        $this->cismarty->display('order_info.html');
    }

    /*
     * 解析object成数组的方法
     * @param $json 输入的object数组
     * return $data 数组
     */
    private function json_array($json){
        if($json){
            foreach ((array)$json as $k=>$v){
                $data[$k] = !is_string($v)?$this->json_array($v):$v;
            }
            return $data;
        }
    }


    /** 这里显示各种状态的订单 */
    function my_order(){
        $data=$this->product_model->show_order();

        $phone = $this->product_model->get_telphone();
        $this->cismarty->assign('telPhone',$phone);
        $this->cismarty->assign('data',$data);
        $this->cismarty->display('my_order.html');
    }

    function my_address(){
        $data=$this->product_model->my_address();
        $this->cismarty->assign('data',$data);
        $this->cismarty->display('my_address.html');
    }

    function feedback($id,$status=null){
        $data = $this->product_model->product_ids($id);
        $this->cismarty->assign('data',$data);
        $this->cismarty->assign('id',$id);
        $this->cismarty->assign('status',$status);
        $this->cismarty->display('feedback.html');
    }

    function save_feedback($status=null){
        $this->product_model->save_feedback();
        redirect('product/status_order/'.$status);
    }

    function delete_order($id,$status=null){
        $this->product_model->delete_order($id);
        if($status==1){
            redirect('product/status_order/1');
        }else{
            redirect('product/status_order/4');
        }
    }

    function show_express($id,$status=null){
        $data = $this->product_model->show_express($id);
        //die(var_dump($data));
        if($data['head']!=1){
            $express = $this->getorder($data['head']['express'],$data['head']['express_num']);
        }
        if(isset($express['data'])){
            $data['express'] = $express['data'];
        }else{
            $data['express'] = array(array('context'=>'暂无快递信息','time'=>date('Y-m-d H:i:s',time())));
        }
        $this->cismarty->assign('status',$status);
        $this->cismarty->assign('data',$data);
        $this->cismarty->display('express_info.html');
    }


    function buy_pro($pid,$pd_id,$qty){
        $data = $this->product_model->get_pro_info($pid,$pd_id);
        $rs = $this->product_model->get_allow_fund_score();
        $score = $rs['allow_score'];
        $this->cismarty->assign('score',$score);
        $this->cismarty->assign('pid',$pid);
        $this->cismarty->assign('pd_id',$pd_id);
        $this->cismarty->assign('qty',$qty);
        $this->cismarty->assign('data',$data);
        $this->cismarty->display('order_confirm.html');
    }

    public function pay($order_id){

        //微信支付配置的参数配置读取
        $this->load->config('wxpay_config');
        $wxconfig['appid']=$this->config->item('appid');
        $wxconfig['mch_id']=$this->config->item('mch_id');
        $wxconfig['apikey']=$this->config->item('apikey');
        $wxconfig['appsecret']=$this->config->item('appsecret');
        $wxconfig['sslcertPath']=$this->config->item('sslcertPath');
        $wxconfig['sslkeyPath']=$this->config->item('sslkeyPath');
        $this->load->library('Wechatpay',$wxconfig);
        //商户交易单号
        $order_data = $this->product_model->order_info($order_id);
        $out_trade_no = $order_data['main']['num'];
        $total_fee = 0;
        $body_info = "";
        $body_detail = 1;

        foreach($order_data['detail'] as $key => $value){
            $total_fee += $value['price'] * $value['qty'];
            if($key == 0){
                $body_info = $value['pro_name'].$value['de_size'];
            }else{
                $body_detail += 1;
            }
        }
        $total_fee = round($total_fee - $order_data['main']['score'],2);
        if($body_detail==1){
            $param['body'] = $body_info;
        }else{
            $param['body'] = $body_info.'等'.$body_detail.'个商品';
        }

        if($total_fee == 0){
            $this->product_model->confirm_order($out_trade_no,$this->session->userdata('openid'));
            redirect(site_url('product/my_order'));
        }

//        $param['attach'] = '0012';
        $param['detail'] = "摩瑞尔电商平台-".$out_trade_no;
        $param['out_trade_no'] = $out_trade_no;
        $param['total_fee'] = $total_fee * 100;
        $param["spbill_create_ip"] = $_SERVER['REMOTE_ADDR'];
        $param["time_start"] = date("YmdHis");
        $param["time_expire"] = date("YmdHis", time() + 600);
        $param["goods_tag"] = "摩瑞尔电商平台";
        $param["notify_url"] = base_url()."/ajax/notify";
        $param["trade_type"] = "JSAPI";
        $param["openid"] = $this->session->userdata('openid');

        //统一下单，获取结果，结果是为了构造jsapi调用微信支付组件所需参数
        $result = $this->wechatpay->unifiedOrder($param);
//        var_dump($result);die;

        //如果结果是成功的我们才能构造所需参数，首要判断预支付id

        if (isset($result["prepay_id"]) && !empty($result["prepay_id"])) {
            //调用支付类里的get_package方法，得到构造的参数
            $data['parameters'] = json_encode($this->wechatpay->get_package($result['prepay_id']));
            $data['notifyurl'] = $param["notify_url"];
            $data['fee'] = $total_fee;
            $data['productList'] = $order_data['detail'];
            $data['pubid'] = $out_trade_no;
            $data['orderid'] = $order_id;
            $this->load->view('pay', $data);
        }
//        $this->load->view('pay', $data);
    }

//    function notify($order_num)
//    {
//        if ($this->session->userdata('openid')) {
//            $rs = $this->product_model->confirm_order($order_num);
//            echo $rs;
//        }
//    }



    public function user_center(){
        $data = $this->product_model->get_user_info();
        $this->cismarty->assign('data',$data);
        $this->cismarty->assign('headimgurl',$this->session->userdata('headimgurl'));
        $this->cismarty->assign('nickname',$this->session->userdata('nickname'));
        $this->cismarty->display('user_center.html');
    }

    public function explain(){
        $this->cismarty->display('explain.html');
    }

    public function fund_detail($page = 1){
        $data = $this->product_model->fund_detail($page);
        $this->cismarty->assign('data',$data);
        $this->cismarty->display('fund_detail.html');
    }

    public function fund_detail_ajax($page){
        $data = $this->product_model->fund_detail($page);
        if($data['res_list']){
            echo json_encode($data);
        }else{
            echo 1;
        }
    }

    public function score_detail($page = 1){
        $data = $this->product_model->score_detail($page);
        $this->cismarty->assign('data',$data);
        $this->cismarty->display('score_detail.html');
    }

    public function score_detail_ajax($page){
        $data = $this->product_model->score_detail($page);
        if($data['res_list']){
            echo json_encode($data);
        }else{
            echo 1;
        }
    }

    public function withdraw(){
        $surplus = $this->product_model->get_allow_fund_score();
        $this->cismarty->assign('surplus',$surplus['allow_fund']);
        $this->cismarty->display('withdraw.html');
    }

    public function save_withdraw(){
        $rs = $this->product_model->save_withdraw();
        if($rs == 1){
            $this->cismarty->assign('cdate',date("y-m-d H:i:s",time()));
            $this->cismarty->assign('fund',$this->input->post('money'));
            $this->cismarty->display('withdraw_success.html');
        }else{
            redirect(site_url('product/user_center'));
        }
    }

    public function del_order($id){
        $this->product_model->del_order($id);
        redirect(site_url('product/my_order'));
    }

    public function confirm_receive($id){
        $this->product_model->confirm_receive($id);
        redirect(site_url('product/my_order'));
    }
}