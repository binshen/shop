<?php /* Smarty version Smarty-3.1.16, created on 2016-09-23 15:24:29
         compiled from "application/views/my_order.html" */ ?>
<?php /*%%SmartyHeaderCode:197908453557b414e132eca2-54127082%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a32975e3085014f39b32c3151b739a671a037df1' => 
    array (
      0 => 'application/views/my_order.html',
      1 => 1474615465,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '197908453557b414e132eca2-54127082',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_57b414e1408985_22111869',
  'variables' => 
  array (
    'telPhone' => 0,
    'data' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b414e1408985_22111869')) {function content_57b414e1408985_22111869($_smarty_tpl) {?><?php if (!is_callable('smarty_function_site_url')) include '/var/www/html/shop/application/libraries/smarty/plugins/function.site_url.php';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>会员中心</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link href="/res/css/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="layout">
        <div class="member_nav clear_fix m_l_b"><p class="menu">全部订单</p><a class="phone" href="tel:<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['telPhone']->value;?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
"><span>客服电话</span><img src="/res/images/i_phone.png" /></a></div>
        <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['data']->value) {?><?php $_tmp2=ob_get_clean();?><?php echo $_tmp2;?>

        <?php ob_start();?><?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
?><?php $_tmp3=ob_get_clean();?><?php echo $_tmp3;?>

        <ul class="list">
            <li class="col-m-3 col-s-3 m_l_b"><img src="/uploadfiles/products/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['bg_pic'];?>
<?php $_tmp4=ob_get_clean();?><?php echo $_tmp4;?>
" class="goods_pic" /></li>
            <li class="col-m-9 col-s-9">
                <p class="overflow_h"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['pro_name'];?>
<?php $_tmp5=ob_get_clean();?><?php echo $_tmp5;?>
  ￥<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['price'];?>
<?php $_tmp6=ob_get_clean();?><?php echo $_tmp6;?>
 x <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['qty'];?>
<?php $_tmp7=ob_get_clean();?><?php echo $_tmp7;?>
</p>
                <p>
                    <span class="f_right c_gray">
                        <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['row']->value['status']==1) {?><?php $_tmp8=ob_get_clean();?><?php echo $_tmp8;?>
<font color="red">待付款</font><?php ob_start();?><?php }?><?php $_tmp9=ob_get_clean();?><?php echo $_tmp9;?>

                        <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['row']->value['status']==2) {?><?php $_tmp10=ob_get_clean();?><?php echo $_tmp10;?>
已付款<?php ob_start();?><?php }?><?php $_tmp11=ob_get_clean();?><?php echo $_tmp11;?>

                        <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['row']->value['status']==3) {?><?php $_tmp12=ob_get_clean();?><?php echo $_tmp12;?>
<font color="green">已发货</font><?php ob_start();?><?php }?><?php $_tmp13=ob_get_clean();?><?php echo $_tmp13;?>

                        <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['row']->value['status']==-1) {?><?php $_tmp14=ob_get_clean();?><?php echo $_tmp14;?>
<font color="red">已关闭</font><?php ob_start();?><?php }?><?php $_tmp15=ob_get_clean();?><?php echo $_tmp15;?>

                    </span>实付款： <span class="c_orange">￥<?php ob_start();?><?php echo round(($_smarty_tpl->tpl_vars['row']->value['price']*$_smarty_tpl->tpl_vars['row']->value['qty']-$_smarty_tpl->tpl_vars['row']->value['score']),2);?>
<?php $_tmp16=ob_get_clean();?><?php echo $_tmp16;?>
</span>
                </p>
            </li>
            <li class="add">
                <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['row']->value['status']==1) {?><?php $_tmp17=ob_get_clean();?><?php echo $_tmp17;?>
<a class="btn_red f_right" href="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'product/pay'),$_smarty_tpl);?>
<?php $_tmp18=ob_get_clean();?><?php echo $_tmp18;?>
/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
<?php $_tmp19=ob_get_clean();?><?php echo $_tmp19;?>
">付款</a><?php ob_start();?><?php }?><?php $_tmp20=ob_get_clean();?><?php echo $_tmp20;?>

                <!--<?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['row']->value['status']==3) {?><?php $_tmp21=ob_get_clean();?><?php echo $_tmp21;?>
<a class="btn_red f_right" href="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'product/confirm_receive'),$_smarty_tpl);?>
<?php $_tmp22=ob_get_clean();?><?php echo $_tmp22;?>
/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
<?php $_tmp23=ob_get_clean();?><?php echo $_tmp23;?>
">确认收货</a><?php ob_start();?><?php }?><?php $_tmp24=ob_get_clean();?><?php echo $_tmp24;?>
-->
                <a class="btn_gray f_right" href="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'product/order_info'),$_smarty_tpl);?>
<?php $_tmp25=ob_get_clean();?><?php echo $_tmp25;?>
/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
<?php $_tmp26=ob_get_clean();?><?php echo $_tmp26;?>
">订单详情</a>
                <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['row']->value['status']==1) {?><?php $_tmp27=ob_get_clean();?><?php echo $_tmp27;?>
<a class="btn_red f_right" href="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'product/del_order'),$_smarty_tpl);?>
<?php $_tmp28=ob_get_clean();?><?php echo $_tmp28;?>
/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
<?php $_tmp29=ob_get_clean();?><?php echo $_tmp29;?>
">删除订单</a><?php ob_start();?><?php }?><?php $_tmp30=ob_get_clean();?><?php echo $_tmp30;?>

            </li>
        </ul>
        <?php ob_start();?><?php } ?><?php $_tmp31=ob_get_clean();?><?php echo $_tmp31;?>

        <?php ob_start();?><?php } else { ?><?php $_tmp32=ob_get_clean();?><?php echo $_tmp32;?>

        <p class="t_center p_l_tb">抱歉~暂无您的订单记录...</p>
        <?php ob_start();?><?php }?><?php $_tmp33=ob_get_clean();?><?php echo $_tmp33;?>

        <div class="b_bar"><a class="btn btn_orange" href="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'product/index/26'),$_smarty_tpl);?>
<?php $_tmp34=ob_get_clean();?><?php echo $_tmp34;?>
">返回首页</a></div>
    </div>
</body>
</html><?php }} ?>
