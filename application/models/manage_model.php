<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 网站后台模型
 *
 * @package		app
 * @subpackage	core
 * @category	model
 * @author		yaobin<645894453@qq.com>
 *        
 */
class Manage_model extends MY_Model
{
    public function __construct ()
    {
        parent::__construct();
    }

    public function __destruct ()
    {
        parent::__destruct();
    }
    
    /**
     * 用户登录检查
     * 
     * @return boolean
     */
    public function check_login ($brokerOnly=true)
    {
        $login_id = $this->input->post('username');
        $passwd = $this->input->post('password');
        $this->db->from('admin');
        $this->db->where('username', $login_id);
        $this->db->where('passwd', sha1($passwd));
        if($brokerOnly) {
        	$this->db->where('admin_group <=', '2');
        }
        $rs = $this->db->get();
        if ($rs->num_rows() > 0) {
        	$res = $rs->row();
        	$user_info['user_id'] = $res->id;
            $user_info['username'] = $this->input->post('username');
            $user_info['group_id'] = $res->admin_group;
            $user_info['rel_name'] = $res->rel_name;
            $this->session->set_userdata($user_info);
            return true;
        } else {
			return false;
        }
    }
    
    /**
     * 修改密码
     * 
     */
    public function change_pwd ()
    {
        $login_id = $this->input->post('username');
        $newpassword = $this->input->post('newpassword');
        
		$rs=$this->db->where('username', $login_id)->update('admin', array('passwd'=>sha1($newpassword))); 
        if ($rs) {
            return 1;
        } else {
            return $rs;
        }
    }

	public function list_product(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
	
		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('product');
		if($this->input->post('name'))
			$this->db->like('name',$this->input->post('name'));
	
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
	
		$data['name'] = $this->input->post('name')?$this->input->post('name'):null;
		//list
		$this->db->select('*');
		$this->db->from('product');
		if($this->input->post('name')){
			$this->db->like('name',$this->input->post('name'));
		}
	
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}

	public function save_product($data_head){
//		$data_head = array(
//			'name'=>$this->input->post('name'),
//			'cdate'=>date('Y-m-d H:i:s'),
//			'desc'=>$this->input->post('desc'),
//			'status'=>$this->input->post('status'),
//			'recommend'=>$this->input->post('recommend'),
//		);

		$price = $this->input->post('price');
		$s_price = $this->input->post('s_price');
		$size = $this->input->post('size');
		$this->db->trans_start();

		if($this->input->post('id')){//edit
			$pid = $this->input->post('id');
			$this->db->where('id',$pid);
			$this->db->update('product',$data_head);

			$this->db->where('pid',$pid);
			$this->db->delete('product_detail');
		}else{//add
			$this->db->insert('product',$data_head);
			$pid = $this->db->insert_id();
		}

		foreach($size as $k=>$v){
			$data_line = array(
				'pid'=>$pid,
				'size'=>$v,
				'price'=>$price[$k],
				's_price'=>$s_price[$k],
			);
			$this->db->insert('product_detail',$data_line);
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return $this->db_error;
		} else {
			return 1;
		}
	}

	public function get_product($id){
		$this->db->from('product')->where('id', $id);
		$data = $this->db->get()->row_array();

		$data['list'] = $this->db->select()->from('product_detail')->where('pid',$id)->get()->result();
		return $data;
	}


	public function list_product_type(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;

		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('product_type');
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;

		//list
		$this->db->select('*');
		$this->db->from('product_type');
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$data['res_list'] = $this->db->get()->result_array();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}


	public function save_product_type(){
		$data = array(
			'name'=>$this->input->post('name'),
			'parent_id'=>$this->input->post('parent_id')?$this->input->post('parent_id'):0,
		);
		$this->db->trans_start();
		if($this->input->post('id')){//修改
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('product_type', $data);
		}else{//新增
			$data['cdate'] = date('Y-m-d H:i:s',time());
			$this->db->insert('product_type', $data);
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return $this->db_error;
		} else {
			return 1;
		}
	}

	//获取新闻列别，用于选择上级类别,如果存在id，则不取存在的类别，避免出现自己的上级目录是自己的死循环状况
	public function get_all_product_type($id){
		$this->db->select()->from('product_type');
		if($id)
			$this->db->where('id !=',$id);
		$data = $this->db->get()->result_array();
		return $data;
	}

	public function delete_product_type($id){
		$rs = $this->db->delete('product_type', array('id' => $id));
		if($rs){
			return 1;
		}else{
			return $this->db_error;
		}
	}

	public function get_product_type($id){
		$this->db->select('*')->from('product_type')->where('id', $id);
		$data = $this->db->get()->row_array();
		return $data;
	}

	public function get_product_type_list(){
		$this->db->select('*')->from('product_type');
		$data = $this->db->get()->result();
		return $data;
	}

	public function list_order(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;

		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('order');

		if($this->input->post('num'))
			$this->db->like('num',$this->input->post('num'));
		if($this->input->post('status'))
			$this->db->where('status',$this->input->post('status'));

		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;

		$data['num'] = $this->input->post('num')?$this->input->post('num'):null;
		$data['status'] = $this->input->post('status')?$this->input->post('status'):null;
		//list
		$this->db->select();
		$this->db->from('order a');

		if($this->input->post('num'))
			$this->db->like('num',$this->input->post('num'));
		if($this->input->post('status'))
			$this->db->where('status',$this->input->post('status'));

		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}

	public function get_order($id){
		$data['head'] = $this->db->select('a.*,b.name name,phone,address,zip,c.name province_name,d.name city_name,e.name area_name,f.name express_name')->from('order a')
			->join('address b','a.address_id=b.id','left')
			->join('province c','b.provice_code=c.code','left')
			->join('city d','b.city_code=d.code','left')
			->join('area e','b.area_code=e.code','left')
			->join('express f','a.express=f.express','left')
			->where('a.id',$id)->get()->row();

		$data['list'] = $this->db->select('a.*,,b.name product_name,c.size')->from('order_detail a')
			->join('product b','a.pid=b.id','left')
			->join('product_detail c','a.pd_id=c.id','left')

			->where('a.oid',$id)->get()->result();

		return $data;
	}

	public function get_express(){
		return $this->db->select()->from('express')->get()->result();
	}

	public function save_fahuo() {
		$this->db->trans_start();
		$express = $this->input->post('express');
		$express_num = $this->input->post('express_num');
		$id = $this->input->post('id');
		$this->db->where('id',$id)->update('order',array('express'=>$express,'express_num'=>$express_num,'status'=>3,'sdate'=>date('Y-m-d H:i:s')));

		$order_num = $this->db->select('num')->from('order')->where('id',$id)->get()->row();

		$this->db->where('order_num',$order_num->num);
		$this->db->set('status', 1);
		$this->db->update('fund_detail');

		$this->db->where('order_num',$order_num->num);
		$this->db->set('status', 1);
		$this->db->update('score_detail');


		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return -1;
		} else {
			return 1;
		}

	}

	/** 这里显示订单详情 */
	function order_info($id){

		$order_main=$this->db->select('a.*,f.name f_name,g.name g_name,h.name h_name,b.name add_name,b.phone,b.address,b.zip')->from('order a')
			->join('address b','b.id = a.address_id','left')
			->join('province f','f.code = b.provice_code','left')
			->join('city g','g.code = b.city_code','left')
			->join('area h','h.code = b.area_code','left')
			->where('a.id',$id)
			->get()->row_array();
		if (!$order_main){
			$data['main'] = 1;
		}else{
			$data['main'] = $order_main;
		}
		$order_detail=$this->db->select('a.*,b.bg_pic,b.name pro_name,c.size de_size')->from('order_detail a')
			->join('product b','a.pid = b.id','left')
			->join('product_detail c','a.pd_id = c.id','left')
			->where_in('oid',$order_main['id'])->get()->result_array();
		if (!$order_detail){
			$data['detail'] = 1;
		}else{
			$data['detail'] = $order_detail;
		}
		return $data;
	}

	function update_order($id){
		$this->db->where('id',$id)->update('order',array('status'=>6));
	}

	public function list_user(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;

		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('user_info');

		if($this->input->post('name'))
			$this->db->like('name',$this->input->post('name'));


		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;

		$data['name'] = $this->input->post('name')?$this->input->post('name'):null;

		//list
		$this->db->select();
		$this->db->from('user_info');

		if($this->input->post('name'))
			$this->db->like('name',$this->input->post('name'));

		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
		$data['res_list'] = $this->db->get()->result();

		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}

	public function get_user($id){
		$data['head'] = $this->db->select()->from('user_info')
			->where('id',$id)->get()->row();

		return $data;
	}

	/**
	 * 获取联系电话
	 */
	public function list_tel(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;

		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('phone');
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;

		//list
		$this->db->select('*');
		$this->db->from('phone');
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'asc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}

	/**
	 * 保存联系电话
	 */
	public function save_tel(){
		$this->db->trans_start();
		if($this->input->post('id')){//修改
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('phone', $this->input->post());
		}else{//新增
			$data = $this->input->post();
			$this->db->insert('phone', $data);
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return $this->db_error;
		} else {
			return 1;
		}
	}

	/**
	 * 删除联系电话
	 */
	public function delete_tel($id){
		$rs = $this->db->delete('phone', array('id' => $id));
		if($rs){
			return 1;
		}else{
			return $this->db_error;
		}
	}

	/**
	 * 获取联系电话
	 */
	public function get_tel($id){
		$this->db->select('*')->from('phone')->where('id', $id);
		$data = $this->db->get()->row();
		return $data;
	}


	/**
	 * 获取联系电话
	 */
	public function list_withdraw(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;

		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('fund_detail');
		$this->db->where_in('type',array(2,3));
		if($this->input->post('type'))
			$this->db->where('type',$this->input->post('type'));
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
		$data['type'] = $this->input->post('type')?$this->input->post('type'):null;

		//list
		$this->db->select('*');
		$this->db->from('fund_detail');
		$this->db->where_in('type',array(2,3));
		if($this->input->post('type'))
			$this->db->where('type',$this->input->post('type'));
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by('cdate','desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;
		return $data;
	}

	/**
	 * 保存联系电话
	 */
	public function save_withdraw(){
		$this->db->trans_start();
		if($this->input->post('id')){//修改
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('fund_detail', array(
				'type'=>$this->input->post('type'),
				'remark'=>$this->input->post('remark'),
			));
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return $this->db_error;
		} else {
			return 1;
		}
	}

	public function get_withdraw($id){
		$this->db->select('*')->from('fund_detail')->where('id', $id);
		$data = $this->db->get()->row_array();
		return $data;
	}

	public function save_remark() {
		$remark = $this->input->post('remark');
		$id = $this->input->post('id');

		$rs = $this->db->where('id',$id)->update('order',array('remark'=>$remark));
		if($rs)
			return 1;
		else
			return -1;
	}

	public function list_fund(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;

		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('fund_detail');
		$this->db->where_in('type',array(1,3));
		$this->db->where('openid !=','');
		if($this->input->post('num'))
			$this->db->where('order_num',$this->input->post('num'));
		if($this->input->post('openid'))
			$this->db->where('openid',$this->input->post('openid'));
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
		$data['num'] = $this->input->post('num')?$this->input->post('num'):null;
		$data['openid'] = $this->input->post('openid')?$this->input->post('openid'):null;
		//list
		$this->db->select('*');
		$this->db->from('fund_detail');
		$this->db->where_in('type',array(1,3));
		$this->db->where('openid !=','');
		if($this->input->post('num'))
			$this->db->where('order_num',$this->input->post('num'));
		if($this->input->post('openid'))
			$this->db->where('openid',$this->input->post('openid'));
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by('cdate','desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;

		$this->db->select('sum(fund) fund')->from('fund_detail')
			->where('type',1)->where('openid !=','');
		if($this->input->post('openid'))
			$this->db->where('openid',$this->input->post('openid'));
		$rs = $this->db->get()->row();
		$data['sum_fund'] = $rs->fund;

		$this->db->select('sum(fund) fund')->from('fund_detail');
		if($this->input->post('openid'))
			$this->db->where('openid',$this->input->post('openid'));
		$rs1 = $this->db->where('type',3)->get()->row();
		$data['tixian'] = $rs1->fund?$rs1->fund:0;
		return $data;
	}

	public function list_score(){
		// 每页显示的记录条数，默认20条
		$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
		$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;

		//获得总记录数
		$this->db->select('count(1) as num');
		$this->db->from('score_detail');
		$this->db->where('openid !=','');
		if($this->input->post('num'))
			$this->db->where('order_num',$this->input->post('num'));
		if($this->input->post('openid'))
			$this->db->where('openid',$this->input->post('openid'));
		$rs_total = $this->db->get()->row();
		//总记录数
		$data['countPage'] = $rs_total->num;
		$data['num'] = $this->input->post('num')?$this->input->post('num'):null;
		$data['openid'] = $this->input->post('openid')?$this->input->post('openid'):null;
		//list
		$this->db->select('*');
		$this->db->from('score_detail');
		$this->db->where('openid !=','');
		if($this->input->post('num'))
			$this->db->where('order_num',$this->input->post('num'));
		if($this->input->post('openid'))
			$this->db->where('openid',$this->input->post('openid'));
		$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
		$this->db->order_by('cdate','desc');
		$data['res_list'] = $this->db->get()->result();
		$data['pageNum'] = $pageNum;
		$data['numPerPage'] = $numPerPage;

		$this->db->select('sum(score) score')->from('score_detail')
			->where('type',1)->where('openid !=','');
		if($this->input->post('openid'))
			$this->db->where('openid',$this->input->post('openid'));
		$rs = $this->db->get()->row();
		$data['sum_score'] = $rs->score;

		$this->db->select('sum(score) score')->from('score_detail');
		if($this->input->post('openid'))
			$this->db->where('openid',$this->input->post('openid'));
		$rs1 = $this->db->where('type',2)->get()->row();
		$data['tixian'] = $rs1->score?$rs1->score:0;
		return $data;
	}

	public function close_about($id){
		$order_num = $this->db->select('num,status')->from('order')->where('id',$id)->get()->row();
		if($order_num->status != 2){
			return -2;
		}
		$this->db->trans_start();

		$this->db->where('order_num',$order_num->num);
		$this->db->delete('score_detail');

		$this->db->where('order_num',$order_num->num);
		$this->db->delete('fund_detail');

		$this->db->where('id',$id);
		$this->db->set('status', -1);
		$this->db->update('order');
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return $this->db_error;
		} else {
			return 1;
		}
	}

	public function get_export_data(){
		$this->db->select("a.*,b.price,b.qty,b.price*b.qty total,c.name pro_name,d.name name,d.phone phone,CONCAT(e.name,f.name,g.name,d.address) as address,h.name express_name",FALSE)
			->from('order a');
		$this->db->join('order_detail b','a.id=b.oid','left');
		$this->db->join('product c','b.pid=c.id','left');
		$this->db->join('address d','a.address_id=d.id','left');
		$this->db->join('province e','d.provice_code=e.code','left');
		$this->db->join('city f','d.city_code=f.code','left');
		$this->db->join('area g','d.area_code=g.code','left');
		$this->db->join('express h','a.express=h.express','left');
		if($_GET['status']){
			$this->db->where('a.status',$_GET['status']);
		}
		if($_GET['s_date']){
			$this->db->where("a.cdate >=",$_GET['s_date']);
		}

		if($_GET['e_date']){
			$this->db->where("a.cdate <=",$_GET['e_date']." 23:59:59");
		}

		return $this->db->get()->result();
	}

}
