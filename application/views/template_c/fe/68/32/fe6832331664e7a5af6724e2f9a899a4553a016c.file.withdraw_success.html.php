<?php /* Smarty version Smarty-3.1.16, created on 2016-08-22 08:51:15
         compiled from "application/views/withdraw_success.html" */ ?>
<?php /*%%SmartyHeaderCode:57147608657b7c3f1895e38-89709164%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fe6832331664e7a5af6724e2f9a899a4553a016c' => 
    array (
      0 => 'application/views/withdraw_success.html',
      1 => 1471826681,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '57147608657b7c3f1895e38-89709164',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_57b7c3f18d1519_12385965',
  'variables' => 
  array (
    'fund' => 0,
    'cdate' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b7c3f18d1519_12385965')) {function content_57b7c3f18d1519_12385965($_smarty_tpl) {?><?php if (!is_callable('smarty_function_site_url')) include '/var/www/html/shop/application/libraries/smarty/plugins/function.site_url.php';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>提现申请已提交</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link href="/res/css/main.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="layout p_l_t">


    <ul class="list">
        <li class="col-s-3 col-m-3">提现申请</li>
        <li class="col-s-9 col-m-9 t_right t_size_m">￥<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['fund']->value;?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
</li>
    </ul>

    <ul class="list">
        <li class="col-s-3 col-m-3 c_gray">类型</li>
        <li class="col-s-9 col-m-9 t_right">提现申请</li>
        <li class="col-s-3 col-m-3 c_gray">时间</li>
        <li class="col-s-9 col-m-9 t_right"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['cdate']->value;?>
<?php $_tmp2=ob_get_clean();?><?php echo $_tmp2;?>
</li>
        <li class="col-s-3 col-m-3 c_gray">状态</li>
        <li class="col-s-9 col-m-9 t_right c_green">提现处理中</li>
    </ul>


    <div class="b_bar">
        <p class="p_lr p_l_b c_gray t_size_s t_center">申请兑奖后，工作人员将核实您的奖品红包，<br/>信息核实无误后的7个工作日内，<br/>兑换红包金额将充值至您的微信“钱包”中，请注意查收。</p>

        <a class="btn btn_orange" href="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'product/fund_detail'),$_smarty_tpl);?>
<?php $_tmp3=ob_get_clean();?><?php echo $_tmp3;?>
">返回</a></div>

    </div>

</body>
</html><?php }} ?>
