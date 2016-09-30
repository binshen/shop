<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 后台画面控制器
 *
 * @package		app
 * @subpackage	core
 * @category	controller
 * @author		yaobin<645894453@qq.com>
 *
 */
class Manage extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        ini_set('date.timezone','Asia/Shanghai');
        $this->load->model('manage_model');
        $this->load->library('image_lib');
        $this->load->helper('directory');
    }

    function _remap($method,$params = array())
    {
        if (!$this->session->userdata('username')) {
            if ($this->input->is_ajax_request()) {
                header('Content-type: text/json');
                echo '{
                        "statusCode":"301",
                        "message":"\u4f1a\u8bdd\u8d85\u65f6\uff0c\u8bf7\u91cd\u65b0\u767b\u5f55\u3002"
                    }';
            } else {
                redirect(site_url('manage_login/login'));
            }

        } else {
            return call_user_func_array(array($this, $method), $params);
        }
    }

    public function index()
    {
        $this->load->view('manage/index.php');
    }

    //===============================================public start==========================================//
    public function upload_pic(){
        $path = './././uploadfiles/others/';
        $path_out = '/uploadfiles/others/';
        $msg = '';

        //设置原图限制
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '1000';
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config);

        if($this->upload->do_upload('filedata')){
            $data = $this->upload->data();
            $targetPath = $path_out.$data['file_name'];
            $msg="{'url':'".$targetPath."','localname':'','id':'1'}";
            $err = '';
        }else{
            $err = $this->upload->display_errors();
        }
        echo "{'err':'".$err."','msg':".$msg."}";
    }


    //===============================================public end==========================================//

    public function list_product(){
        $data = $this->manage_model->list_product();
        $this->load->view('manage/list_product.php',$data);
    }

    public function add_product(){
        $this->load->view('manage/add_product.php');
    }

    public function edit_product($id){
        $data = $this->manage_model->get_product($id);
        $this->load->view('manage/add_product.php',$data);
    }

    public function save_product(){
        if($_FILES["userfile"]['name'] and $this->input->post('old_img')){//修改上传的图片，需要先删除原来的图片
            @unlink('./././uploadfiles/products/'.$this->input->post('old_img'));//del old img
        }else if(!$_FILES["userfile"]['name'] and !$this->input->post('old_img')){//未上传图片
            form_submit_json("300", "请添加图片");exit;
        }

        if(!$_FILES["userfile"]['name'] and $this->input->post('old_img')){//不修改图片信息
//            $data = $this->input->post();
//            unset($data['ajax']);
//            unset($data['old_img']);
            $data = array(
                'name'=>$this->input->post('name'),
                'cdate'=>date('Y-m-d H:i:s'),
                'desc'=>$this->input->post('desc'),
                'status'=>$this->input->post('status'),
                'recommend'=>$this->input->post('recommend'),
            );

            $rs = $this->manage_model->save_product($data);
        }else{
            $config['upload_path'] = './././uploadfiles/products';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '1000';
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            if($this->upload->do_upload()){
                $img_info = $this->upload->data();
                $data = array(
                    'name'=>$this->input->post('name'),
                    'cdate'=>date('Y-m-d H:i:s'),
                    'desc'=>$this->input->post('desc'),
                    'status'=>$this->input->post('status'),
                    'recommend'=>$this->input->post('recommend'),
                    'bg_pic'=> $img_info['file_name']
                );
                $rs = $this->manage_model->save_product($data);
            }else{
                form_submit_json("300", $this->upload->display_errors('<b>','</b>'));
                exit;
            }
        }


//        $rs = $this->manage_model->save_product();
        if ($rs === 1) {
            form_submit_json("200", "操作成功", "list_product");
        } else {
            form_submit_json("300", $rs);
        }
    }

//
//    /**
//     * 树状结构菜单
//     **/
//    public function subtree($arr,$id=0,$lev=1)
//    {
//        static $subs = array();
//        foreach($arr as $v){
//            if((int)$v['parent_id']==$id){
//                $v['lev'] = $lev;
//                $subs[]=$v;
//                $this->subtree($arr,$v['id'],$lev+1);
//            }
//        }
//        return $subs;
//    }

    public function list_order(){
        $data = $this->manage_model->list_order();
        $this->load->view('manage/list_order.php',$data);
    }

    public function edit_order($id){

        $data = $this->manage_model->get_order($id);
        $data['express'] = '';

        if($data['head']->express_num){
            $express = $this->getorder($data['head']->express,$data['head']->express_num);
            if(isset($express['data'])){
                $data['express'] = $express['data'];
            }else{
                $data['express'] = array(array('context'=>'暂无快递信息','time'=>date('Y-m-d H:i:s',time())));
            }
        }
        $this->load->view('manage/edit_order.php',$data);
    }

    public function save_order(){
        $rs = $this->manage_model->save_order();
        if ($rs === 1) {
            form_submit_json("200", "操作成功", "list_order");
        } else {
            form_submit_json("300", $rs);
        }
    }

    public function fahuo($id){
        $data = $this->manage_model->get_order($id);
        $data['express'] = $this->manage_model->get_express();
        $data['id'] = $id;
        $this->load->view('manage/fahuo_dialog.php',$data);
    }

    public function save_fahuo() {
        $ret = $this->manage_model->save_fahuo();
        if($ret == 1){
            form_submit_json("200", "操作成功", 'edit_order');
        } else {
            form_submit_json("300", "保存失败");
        }
    }


    /*
     * 采集网页内容的方法
     */
    private function getcontent($url){
        if(function_exists("file_get_contents")){
            $file_contents = file_get_contents($url);
        }else{
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $file_contents = curl_exec($ch);
            curl_close($ch);
        }
        return $file_contents;
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

    /*
     * 返回$data array      快递数组
     * @param $name         快递名称
     * 支持输入的快递名称如下
     * (申通-EMS-顺丰-圆通-中通-如风达-韵达-天天-汇通-全峰-德邦-宅急送-安信达-包裹平邮-邦送物流
     * DHL快递-大田物流-德邦物流-EMS国内-EMS国际-E邮宝-凡客配送-国通快递-挂号信-共速达-国际小包
     * 汇通快递-华宇物流-汇强快递-佳吉快运-佳怡物流-加拿大邮政-快捷速递-龙邦速递-联邦快递-联昊通
     * 能达速递-如风达-瑞典邮政-全一快递-全峰快递-全日通-申通快递-顺丰快递-速尔快递-TNT快递-天天快递
     * 天地华宇-UPS快递-新邦物流-新蛋物流-香港邮政-圆通快递-韵达快递-邮政包裹-优速快递-中通快递)
     * 中铁快运-宅急送-中邮物流
     * @param $order        快递的单号
     * $data['ischeck'] ==1   已经签收
     * $data['data']        快递实时查询的状态 array
     */
    public  function getorder($name,$order){
        $result = $this->getcontent("http://www.kuaidi100.com/query?type={$name}&postid={$order}");
        $result = json_decode($result);
        $data = $this->json_array($result);
        return $data;
    }

    //申请退款
    public function refund($id="")
    {
        if ($id == "") {
            //方便我手动调用退单
            $id = $this->uri->segment(3);
        }
        if (isset($id) && $id != "") {
            //1、取消订单可以退款。2、失败订单可以退款
            $pub = $this->manage_model->order_info($id);
            if ($pub['main']!=1 and $pub['main']['status'] == 5) {
                $listno = $pub['main']['num'];
                $fee = 0;
                if($pub['detail']==1){

                }
                foreach($pub['detail'] as $key => $value){
                    $fee += $value['price'] * $value['qty'];
                }
                $this->load->config('wxpay_config');
                $wxconfig['appid'] = $this->config->item('appid');
                $wxconfig['mch_id'] = $this->config->item('mch_id');
                $wxconfig['apikey'] = $this->config->item('apikey');
                $wxconfig['appsecret'] = $this->config->item('appsecret');
                $wxconfig['sslcertPath'] = $this->config->item('sslcertPath');
                $wxconfig['sslkeyPath'] = $this->config->item('sslkeyPath');
                $this->load->library('Wechatpay', $wxconfig);

                if (isset($listno) && $listno != "") {
                    $out_trade_no = $listno;
                    $total_fee = $fee * 100;
                    $refund_fee = $fee * 100;
                    //自定义商户退单号
                    $out_refund_no = $wxconfig['mch_id'] . date("YmdHis");
                    $result = $this->wechatpay->refund($out_trade_no, $out_refund_no, $total_fee, $refund_fee, $wxconfig['mch_id']);

                    //log::DEBUG(json_encode($result));
                    if (isset($result["return_code"]) && $result["return_code"] = "SUCCESS" && isset($result["result_code"]) && $result["result_code"] = "SUCCESS") {
                        $this->manage_model->update_order($id);
                        form_submit_json("200", "操作成功", 'edit_order');
                    }else{
                        form_submit_json("300", "退款失败");
                    }
                    //佣金状态更改为已退款

                    //form_submit_json("200", "操作成功", 'edit_order');
                }
            }
        }

    }

    public function list_user(){
        $data = $this->manage_model->list_user();
        $this->load->view('manage/list_user.php',$data);
    }

    public function edit_user($id){

        $data = $this->manage_model->get_user($id);
        $data['id']=$id;
        $this->load->view('manage/edit_user.php',$data);
    }

    /**
     *
     * ***************************************以下为联系电话*******************************************************************
     */

    public function list_tel()
    {
        $data = $this->manage_model->list_tel();
        $this->load->view('manage/list_tel.php',$data);
    }

    public function save_tel(){
        $rs = $this->manage_model->save_tel();
        if ($rs === 1) {
            form_submit_json("200", "操作成功", "list_tel");
        } else {
            form_submit_json("300", $rs);
        }
    }

    public function edit_tel($id){
        $data = $this->manage_model->get_tel($id);
        $this->load->view('manage/add_tel.php',$data);
    }

    public function list_withdraw(){
        $data = $this->manage_model->list_withdraw();
        $this->load->view('manage/list_withdraw.php',$data);
    }


    public function save_withdraw(){
        $rs = $this->manage_model->save_withdraw();
        if ($rs === 1) {
            form_submit_json("200", "操作成功", "list_withdraw");
        } else {
            form_submit_json("300", $rs);
        }
    }

    public function edit_withdraw($id){
        $data = $this->manage_model->get_withdraw($id);
        $this->load->view('manage/edit_withdraw.php',$data);
    }

    public function remark($id){
        $data = $this->manage_model->get_order($id);
        $this->load->view('manage/remark_dialog.php',$data['head']);
    }

    public function save_remark() {
        $ret = $this->manage_model->save_remark();
        if($ret == 1){
            form_submit_json("200", "操作成功", 'edit_order');
        } else {
            form_submit_json("300", "保存失败");
        }
    }

    public function list_fund(){
        $data = $this->manage_model->list_fund();
        $this->load->view('manage/list_fund.php',$data);
    }

    public function list_score(){
        $data = $this->manage_model->list_score();
        $this->load->view('manage/list_score.php',$data);
    }

    public function close_about($id){
        $rs = $this->manage_model->close_about($id);
        if ($rs === 1) {
            form_submit_json("200", "操作成功", "list_order", "", "");
        } else if($rs === -2){
            form_submit_json("300", '只有待发货状态才能关闭');
        }

        else {
            form_submit_json("300", $rs);
        }
    }

    public function export_dialog(){
        $this->load->view('manage/export_dialog.php');
    }

    public function export_order(){

        $rs = $this->manage_model->get_export_data();

        // 载入类库
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");

        $objPHPExcel->setActiveSheetIndex(0);

        // 第一行为字段名
        $fields_name = array('下单日期','付款日期','发货日期','订单号','物流单号','物流公司','商品名称','数量','单价','总金额','收货人','手机号码','收货地址');
        $col = 0;
        foreach ($fields_name as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }

        $fields = array('cdate','pdate','sdate','num','express_num','express_name','pro_name','qty','price','total','name','phone','address');
        // 数据内容
        $row = 2;
        foreach($rs as $data)
        {
            $col = 0;
            foreach ($fields as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }

            $row++;
        }

        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');

        // 发送下载
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="report_to_excel_'.date('Ymd').'.xls"');
        header('Cache-Control: max-age=0');

        $objWriter->save('php://output');

//        form_submit_json("200", "导出成功", 'list_order');
    }

}
