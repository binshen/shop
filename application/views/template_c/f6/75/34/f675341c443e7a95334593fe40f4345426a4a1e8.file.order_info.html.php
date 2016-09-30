<?php /* Smarty version Smarty-3.1.16, created on 2016-09-21 13:36:00
         compiled from "application/views/order_info.html" */ ?>
<?php /*%%SmartyHeaderCode:62178837457b414d9f052f8-62012471%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f675341c443e7a95334593fe40f4345426a4a1e8' => 
    array (
      0 => 'application/views/order_info.html',
      1 => 1474436130,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '62178837457b414d9f052f8-62012471',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_57b414da0a46d6_13830615',
  'variables' => 
  array (
    'data' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b414da0a46d6_13830615')) {function content_57b414da0a46d6_13830615($_smarty_tpl) {?><?php if (!is_callable('smarty_function_site_url')) include '/var/www/html/shop/application/libraries/smarty/plugins/function.site_url.php';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>订单详情</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link href="/res/css/main.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="layout">

    <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['data']->value['main']['status']==1) {?><?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
<div class="state">待付款</div><?php ob_start();?><?php }?><?php $_tmp2=ob_get_clean();?><?php echo $_tmp2;?>

    <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['data']->value['main']['status']==2) {?><?php $_tmp3=ob_get_clean();?><?php echo $_tmp3;?>
<div class="state">已付款</div><?php ob_start();?><?php }?><?php $_tmp4=ob_get_clean();?><?php echo $_tmp4;?>

    <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['data']->value['main']['status']==3) {?><?php $_tmp5=ob_get_clean();?><?php echo $_tmp5;?>
<div class="state">待收货</div><?php ob_start();?><?php }?><?php $_tmp6=ob_get_clean();?><?php echo $_tmp6;?>

    <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['data']->value['main']['status']==-1) {?><?php $_tmp7=ob_get_clean();?><?php echo $_tmp7;?>
<div class="state">已关闭</div><?php ob_start();?><?php }?><?php $_tmp8=ob_get_clean();?><?php echo $_tmp8;?>


    <ul class="list">
        <li class="line2 m_m_b clear_fix"><p class="col-m-3 col-s-3">订单编号：</p><p class="col-m-9 col-s-9"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['main']['num'];?>
<?php $_tmp9=ob_get_clean();?><?php echo $_tmp9;?>
</p></li>
        <li class="line2 m_m_b clear_fix"><p class="col-m-3 col-s-3">商户名称：</p><p class="col-m-9 col-s-9">七星博士电商平台</p></li>
        <li class="line2 m_l_b">
            <div class="clear_fix"><p class="col-m-3 col-s-3">收  货  人：</p><p class="col-m-9 col-s-9"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['main']['add_name'];?>
<?php $_tmp10=ob_get_clean();?><?php echo $_tmp10;?>
</p></div>
            <div class="clear_fix"><p class="col-m-3 col-s-3">收货地址：</p><p class="col-m-9 col-s-9"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['main']['f_name'];?>
<?php $_tmp11=ob_get_clean();?><?php echo $_tmp11;?>
 <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['main']['g_name'];?>
<?php $_tmp12=ob_get_clean();?><?php echo $_tmp12;?>
 <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['main']['h_name'];?>
<?php $_tmp13=ob_get_clean();?><?php echo $_tmp13;?>
 <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['main']['address'];?>
<?php $_tmp14=ob_get_clean();?><?php echo $_tmp14;?>
 <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['main']['zip'];?>
<?php $_tmp15=ob_get_clean();?><?php echo $_tmp15;?>
</p></div>
        </li>
        <li class="col-m-3 col-s-3 m_l_b"><img src="/uploadfiles/products/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['detail'][0]['bg_pic'];?>
<?php $_tmp16=ob_get_clean();?><?php echo $_tmp16;?>
" class="goods_pic" /></li>
        <li class="col-m-9 col-s-9">
            <p class="overflow_h"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['detail'][0]['pro_name'];?>
<?php $_tmp17=ob_get_clean();?><?php echo $_tmp17;?>
</p><p class="c_orange"><span class="f_right">x <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['detail'][0]['qty'];?>
<?php $_tmp18=ob_get_clean();?><?php echo $_tmp18;?>
</span>￥<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['detail'][0]['price'];?>
<?php $_tmp19=ob_get_clean();?><?php echo $_tmp19;?>
</p>
        </li>
        <li class="line2 clear">
            <p class="t_right">合计金额：<span class="c_orange">￥<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['detail'][0]['price']*$_smarty_tpl->tpl_vars['data']->value['detail'][0]['qty'];?>
<?php $_tmp20=ob_get_clean();?><?php echo $_tmp20;?>
</span></p>
            <p class="t_right">积分抵扣：<span class="c_orange">-￥<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['main']['score'];?>
<?php $_tmp21=ob_get_clean();?><?php echo $_tmp21;?>
</span></p>
            <p class="t_right">实付金额：<span class="c_orange t_size_m">￥<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['detail'][0]['price']*$_smarty_tpl->tpl_vars['data']->value['detail'][0]['qty']-$_smarty_tpl->tpl_vars['data']->value['main']['score'];?>
<?php $_tmp22=ob_get_clean();?><?php echo $_tmp22;?>
</span></p>
        </li>

    </ul>
    <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['data']->value['express']) {?><?php $_tmp23=ob_get_clean();?><?php echo $_tmp23;?>

    <ul class="time_l">
        <li class="time_l_l"></li>
            <?php ob_start();?><?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['express']['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
?><?php $_tmp24=ob_get_clean();?><?php echo $_tmp24;?>

            <li class="col-m-2 col-s-2 t_center"><span class="point_1_off"></span></li>
            <li class="col-m-10 col-s-10 line c_gray">
                <p><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['context'];?>
<?php $_tmp25=ob_get_clean();?><?php echo $_tmp25;?>
</p>
                <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['time'];?>
<?php $_tmp26=ob_get_clean();?><?php echo $_tmp26;?>

            </li>
            <?php ob_start();?><?php } ?><?php $_tmp27=ob_get_clean();?><?php echo $_tmp27;?>

    </ul>
    <?php ob_start();?><?php }?><?php $_tmp28=ob_get_clean();?><?php echo $_tmp28;?>

    <div class="b_bar"><a class="btn btn_orange" href="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'product/my_order'),$_smarty_tpl);?>
<?php $_tmp29=ob_get_clean();?><?php echo $_tmp29;?>
">返回</a></div>

</div>

<script src="/res/js/jquery-1.11.0.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    $('.point_1_off:eq(0)').removeClass('point_1_off').addClass('point_1')
    $('.c_gray:eq(0)').removeClass('c_gray').addClass('c_green')
</script>


<script>
    a = $('.t_size_m').html().replace('￥','');
    a = parseFloat(a).toFixed(2)
    $('.t_size_m').html('￥'+a)


</script>
</body>
</html><?php }} ?>
