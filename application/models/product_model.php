<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: yaobin
 * Date: 2016/4/29
 * Time: 22:07
 *33eee
 */
class Product_model extends MY_Model
{
    public function __construct(){
        parent::__construct();
    }

    public function __destruct(){
        parent::__destruct();
    }

    public function get_product_info($id){
        $data = $this->db->select('a.*,min(b.price) price,b.id pd_id')->from('product a')
           ->join('product_detail b','a.id = b.pid','left')
           ->where('a.id',$id)->group_by('a.id')
           ->get()->row_array();
        return $data;
    }

    function save_address(){
        $openid = $this->session->userdata('openid');
        $data = $this->input->post();
        $data['default'] = 1;
        $data['openid'] = $openid;
        $this->get_address($openid);
        $this->db->trans_start();

        $this->db->where('openid',$openid)->update('address',array('default'=>2));
        $this->db->insert('address',$data);

        $this->db->trans_complete();//------结束事务
        if ($this->db->trans_status() === FALSE) {
            return -1;
        } else {
            return 1;
        }
    }

    function get_address($id){
        $openid=$this->session->userdata('openid');
        $default_address=$this->db->select()->from('address')
            ->where(array(
                'openid'=>$openid,
                'id'=> $id,
                'default'=>1
            ))->get()->row_array();

        return $default_address;
    }

    /** 这里显示订单信息 */
    function show_order(){
        $openid = $this->session->userdata('openid');

        $this->db->select('a.*,c.bg_pic,c.name pro_name,b.price,b.qty')
            ->from('order a')
            ->join('order_detail b','a.id=b.oid','left')
            ->join('product c','b.pid = c.id','left')
            ->join('product_detail d','b.pd_id = d.id','left')
            ->where('openid',$openid);
        $this->db->where('del',1);
        $this->db->order_by('a.id','desc');
        $data = $this->db->get()->result_array();

        return $data;
    }

    /** 这里显示订单详情 */
    function order_info($id){
        $openid = $this->session->userdata('openid');
        $data['main'] = $this->db->select('a.*,f.name f_name,g.name g_name,h.name h_name,b.name add_name,b.phone,b.address,b.zip')
            ->from('order a')->join('address b','b.id = a.address_id','left')
            ->join('province f','f.code = b.provice_code','left')
            ->join('city g','g.code = b.city_code','left')
            ->join('area h','h.code = b.area_code','left')
            ->where('a.id',$id)
            ->where('a.openid',$openid)->get()->row_array();

        $data['detail'] = $this->db->select('a.*,b.bg_pic,b.name pro_name,c.size de_size')
            ->from('order_detail a')
            ->join('product b','a.pid = b.id','left')
            ->join('product_detail c','a.pd_id = c.id','left')
            ->where('oid',$data['main']['id'])->get()->result_array();

        return $data;
    }

    function get_pro_info($pid,$pd_id){
        $openid = $this->session->userdata('openid');
        $detail = $this->db->select('a.*,c.size de_size,c.price de_price,c.id pd_id,bg_pic')->from('product a')
            ->join('product_detail c','c.pid = a.id','left')
            ->where(array(
                'a.id'=>$pid,
                'c.id'=>$pd_id
            ))
            ->get()->row_array();

        $data['detail'] = $detail;

        $address = $this->db->select('a.*,f.name f_name,g.name g_name,h.name h_name')->from('address a')
            ->join('province f','f.code = a.provice_code','left')
            ->join('city g','g.code = a.city_code','left')
            ->join('area h','h.code = a.area_code','left')

            ->where('a.openid',$openid)
            ->where('a.default',1)
            ->get()->row_array();

        $province = $this->db->select()->from('province')->get()->result_array();
        $data['province'] = $province;
        if($address){
            $city = $this->db->select()->from('city')->where('provincecode',$address['provice_code'])->get()->result_array();
            $area = $this->db->select()->from('area')->where('citycode',$address['city_code'])->get()->result_array();

            $data['city'] = $city;
            $data['area'] = $area;
        }else{
            $data['city'] = '';
            $data['area'] = '';
        }

        $data['address'] = $address;

        return $data;
    }

    function save_order(){
        $openid=$this->session->userdata('openid');
        $this->db->trans_start();

        $rs = $this->get_allow_fund_score();
        $score = $rs['allow_score'];

        if($this->input->post('score') > $score || $this->input->post('score') > $this->input->post('price')*$this->input->post('qty')){
            return -1;
        }

        //先新建order数据
        $order_data = array(
            'address_id'=>$this->input->post('address_id'),
            'num' => date("ymdHis",time()).mt_rand(1000,9999),
            'cdate' => date("y-m-d H:i:s",time()),
            'status' => 1,
            'openid' => $openid,
            'score' => $this->input->post('score')
        );
        $this->db->insert('order',$order_data);
        $order_id = $this->db->insert_id();
        $this->db->insert('order_detail',array(
            'oid'=>$order_id,
            'pid'=>$this->input->post('pid'),
            'price'=>$this->input->post('price'),
            's_price'=>0,
            'qty'=>$this->input->post('qty'),
            'pd_id'=>$this->input->post('pd_id')
        ));

        if($this->input->post('score') > 0){
            $this->db->insert('score_detail',array(
                'order_num'=>$order_data['num'],
                'openid'=>$openid,
                'cdate' => date("y-m-d H:i:s",time()),
                'score'=>$this->input->post('score') * -1,
                'type'=>2
            ));
        }


        $this->db->where('openid',$openid);
        $this->db->set('score', 'score-'.$this->input->post('score'), FALSE);
        $this->db->update('user_info');

        $this->db->trans_complete();//------结束事务
        if ($this->db->trans_status() === FALSE) {
            return -1;
        } else {
            return $order_id;
        }
    }

    public function confirm_order($order_num,$openid){
        $this->db->trans_start();
        $this->db->where('num',$order_num)->where('openid',$openid);
        $this->db->update('order',array('status'=>2,'pdate'=>date("y-m-d H:i:s",time())));

        $qty = 1;
        $rs = $this->db->select('qty')->from('order a')
            ->join('order_detail b','a.id = b.oid','left')->where('a.num',$order_num)->get()->row();
        if($rs){
            $qty = $rs->qty;
        }

        //一级-------------------------------------------------------------------------------------------------
        $openid1 = $this->db->select('parent_openid')->from('user_info')->where('openid',$openid)->get()->row();
        if($openid1){
            $openid1 = $openid1->parent_openid;
            $data1 = array(
                'order_num'=>$order_num,
                'target_openid'=>$openid,
                'openid'=>$openid1,
                'lev'=>1,
                'cdate'=>date("y-m-d H:i:s",time())
            );

            $data1_fund = $data1;
            $data1_score = $data1;
            $data1_fund['fund'] = 20 * $qty;
            $data1_score['score'] = 13 * $qty;

            $this->db->insert('fund_detail',$data1_fund);
            $this->db->insert('score_detail',$data1_score);

            $this->db->where('openid',$openid1);
            $this->db->set('fund', 'fund+'.$data1_fund['fund'], FALSE);
            $this->db->set('score', 'score+'.$data1_score['score'], FALSE);
            $this->db->update('user_info');

            //二级---------------------------------------------------------------------------------------------------------
            $openid2 = $this->db->select('parent_openid')->from('user_info')->where('openid',$openid1)->get()->row();
            if($openid2){
                $openid2 = $openid2->parent_openid;
                $data2 = array(
                    'order_num'=>$order_num,
                    'target_openid'=>$openid,
                    'openid'=>$openid2,
                    'lev'=>2,
                    'cdate'=>date("y-m-d H:i:s",time())
                );

                $data2_fund = $data2;
                $data2_score = $data2;
                $data2_fund['fund'] = 6 * $qty;
                $data2_score['score'] = 5 * $qty;

                $this->db->insert('fund_detail',$data2_fund);
                $this->db->insert('score_detail',$data2_score);

                $this->db->where('openid',$openid2);
                $this->db->set('fund', 'fund+'.$data2_fund['fund'], FALSE);
                $this->db->set('score', 'score+'.$data2_score['score'], FALSE);
                $this->db->update('user_info');


                //三级---------------------------------------------------------------------------------------------------------
                $openid3 = $this->db->select('parent_openid')->from('user_info')->where('openid',$openid2)->get()->row();
                if($openid3){
                    $openid3 = $openid3->parent_openid;
                    $data3 = array(
                        'order_num'=>$order_num,
                        'target_openid'=>$openid,
                        'openid'=>$openid3,
                        'lev'=>3,
                        'cdate'=>date("y-m-d H:i:s",time())
                    );

                    $data3_fund = $data3;
                    $data3_score = $data3;
                    $data3_fund['fund'] = 2 * $qty;
                    $data3_score['score'] = 1 * $qty;

                    $this->db->insert('fund_detail',$data3_fund);
                    $this->db->insert('score_detail',$data3_score);

                    $this->db->where('openid',$openid3);
                    $this->db->set('fund', 'fund+'.$data3_fund['fund'], FALSE);
                    $this->db->set('score', 'score+'.$data3_score['score'], FALSE);
                    $this->db->update('user_info');
                }

            }
        }

        $this->db->trans_complete();//------结束事务
        if ($this->db->trans_status() === FALSE) {
            return 'FAIL';
        } else {
            return 'SUCCESS';
        }
    }

    public function product_ids($id){
        $this->db->select('pid')->from('order_detail');
        $this->db->where('oid',$id);
        $ids = $this->db->get()->result_array();
        if (!$ids){
            $data['detail'] = 1;
        }else{
            $data['detail'] = $ids;
        }
        return $data;
    }

    public function get_telphone(){
        $this->db->select('tel')->from('phone')
            ->order_by('id','desc');
        $ids = $this->db->get()->row_array();
        if (!$ids){
            return null;
        }else{
           return $ids['tel'];
        }

    }

    public function get_userID($openid){
        $rs = $this->db->select('id')->from('user_info')->where('openid',$openid)->get()->row();
        if($rs)
            return $rs->id;
        else
            return null;

    }

    public function get_user_info(){
        $data = $this->db->select()->from('user_info')->where('openid',$this->session->userdata('openid'))->get()->row_array();
        $fund = $this->db->select('sum(fund) fund')->from('fund_detail')
            ->where('openid',$this->session->userdata('openid'))
//            ->where('status',1)
            ->get()->row();
        $score = $this->db->select('sum(score) score')->from('score_detail')
            ->where('openid',$this->session->userdata('openid'))
//            ->where('status',1)
            ->get()->row();
        $data['fund'] = $fund->fund?$fund->fund:0;
        $data['score'] = $score->score?$score->score:0;
        $data['allow'] = $this->get_allow_fund_score();
        return $data;
    }

    public function get_allow_fund_score(){
        $allow_fund = $this->db->select('sum(fund) fund')->from('fund_detail')
            ->where('openid',$this->session->userdata('openid'))
            ->where('status',1)
            ->get()->row();
        $allow_score = $this->db->select('sum(score) score')->from('score_detail')
            ->where('openid',$this->session->userdata('openid'))
            ->where('status',1)
            ->get()->row();
        return array(
            'allow_fund'=>$allow_fund->fund?$allow_fund->fund:0,
            'allow_score'=>$allow_score->score?$allow_score->score:0
        );
    }

    public function fund_detail($page){
        $limit = 6;
        $data['res_list'] = $this->db->select('a.*,b.name,d.qty qty,e.price price,f.name product_name')
            ->from('fund_detail a')
            ->join('address b','a.target_openid = b.openid and b.default=1','left')
            ->join('order c','a.order_num = c.num','left')
            ->join('order_detail d','c.id = d.oid','left')
            ->join('product_detail e','d.pd_id = e.id','left')
            ->join('product f','d.pid = f.id','left')
            ->where('a.openid',$this->session->userdata('openid'))
//            ->where('b.default',1)
            ->limit($limit, $offset = ($page - 1) * $limit)
            ->order_by('a.cdate','desc')
            ->get()->result_array();
        $all = $this->db->select('sum(fund) `all`')->from('fund_detail')
            ->where('openid',$this->session->userdata('openid'))
            ->where('`fund` >',0)
            ->get()->row();

        $data['all'] = $all->all;
        $data['surplus'] = $this->get_surplus();
        return $data;
    }
    
    public function score_detail($page){
        $limit = 6;
        $data['res_list'] = $this->db->select('a.*,b.name,d.qty qty,e.price price,f.name product_name')
            ->from('score_detail a')
            ->join('address b','a.target_openid = b.openid and b.default=1','left')
            ->join('order c','a.order_num = c.num','left')
            ->join('order_detail d','c.id = d.oid','left')
            ->join('product_detail e','d.pd_id = e.id','left')
            ->join('product f','d.pid = f.id','left')
            ->where('a.openid',$this->session->userdata('openid'))
//            ->where('b.default',1)
            ->limit($limit, $offset = ($page - 1) * $limit)
            ->order_by('a.cdate','desc')
            ->get()->result_array();
        $all = $this->db->select('sum(score) `all`')->from('score_detail')
            ->where('openid',$this->session->userdata('openid'))
            ->where('`score` >',0)
            ->get()->row();

        $surplus = $this->db->select('sum(score) surplus')->from('score_detail')
            ->where('openid',$this->session->userdata('openid'))
            ->get()->row();

        $data['all'] = $all->all;
        $data['surplus'] = $surplus->surplus;
        return $data;
    }

    public function get_surplus(){
        $surplus = $this->db->select('sum(fund) surplus')->from('fund_detail')
            ->where('openid',$this->session->userdata('openid'))
            ->get()->row();
        return $surplus->surplus;
    }

    public function save_withdraw(){
        $this->db->trans_start();
        $fund = $this->input->post('money');
        $openid = $this->session->userdata('openid');
        $phone = $this->input->post('phone');

        $rs = $this->get_allow_fund_score();
        $surplus = $rs['allow_fund'];

        if($fund > $surplus){
            return -1;
        }

        $data = array(
            'openid'=>$openid,
            'phone'=>$phone,
            'fund'=>-1*$fund,
            'type'=>2,
            'cdate'=>date("y-m-d H:i:s",time())
        );
        $this->db->insert('fund_detail',$data);

        $this->db->where('openid',$this->session->userdata('openid'));
        $this->db->set('fund', 'fund-'.$fund, FALSE);
        $this->db->update('user_info');

        $this->db->trans_complete();//------结束事务
        if ($this->db->trans_status() === FALSE) {
            return -2;
        } else {
            return 1;
        }
    }

    public function get_score(){
        $score = $this->db->select('sum(score) score')->from('score_detail')
            ->where('openid',$this->session->userdata('openid'))
            ->get()->row();
        return $score->score?$score->score:0;
    }

    public function del_order($id){
        $this->db->trans_start();
        $rs = $this->db->select('status,score,openid,num')->from('order')->where('id',$id)->get()->row();
        if($rs->status != 1){
            return;
        }
        if($rs->score > 0){
            $this->db->where('openid',$rs->openid);
            $this->db->set('score', 'score+'.$rs->score, FALSE);
            $this->db->update('user_info');

            $this->db->where('order_num',$rs->num);
            $this->db->delete('score_detail');
        }

        $this->db->where('id',$id);
        $this->db->delete('order');

        $this->db->trans_complete();//------结束事务
        if ($this->db->trans_status() === FALSE) {
            return -2;
        } else {
            return 1;
        }
    }

    public function confirm_receive($id){
        $this->db->where('id',$id);
        $this->db->update('order',array('status'=>4));
    }

    public function test($xml){
        $this->db->insert('test',array('cdate'=>date("y-m-d H:i:s",time()),'xml'=>$xml));
    }

    public function get_tel(){
        $rs = $this->db->select('tel')->from('phone')->get()->row();
        return $rs->tel;
    }
}