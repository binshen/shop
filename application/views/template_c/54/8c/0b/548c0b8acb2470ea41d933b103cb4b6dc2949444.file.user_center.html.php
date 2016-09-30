<?php /* Smarty version Smarty-3.1.16, created on 2016-09-12 13:48:33
         compiled from "application/views/user_center.html" */ ?>
<?php /*%%SmartyHeaderCode:150565446457b6bcc1326872-99553592%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '548c0b8acb2470ea41d933b103cb4b6dc2949444' => 
    array (
      0 => 'application/views/user_center.html',
      1 => 1473659314,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '150565446457b6bcc1326872-99553592',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_57b6bcc135eaf0_53352742',
  'variables' => 
  array (
    'headimgurl' => 0,
    'nickname' => 0,
    'data' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b6bcc135eaf0_53352742')) {function content_57b6bcc135eaf0_53352742($_smarty_tpl) {?><?php if (!is_callable('smarty_function_site_url')) include '/var/www/html/shop/application/libraries/smarty/plugins/function.site_url.php';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>我的奖品</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link href="/res/css/main.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="layout">
    <div class="user">
        <span class="user_pic"><img src="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['headimgurl']->value;?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
" /> </span>
        <em><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['nickname']->value;?>
<?php $_tmp2=ob_get_clean();?><?php echo $_tmp2;?>
</em>
        <ul class="account clear_fix">
            <li class="a1">
                <em><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['fund'];?>
<?php $_tmp3=ob_get_clean();?><?php echo $_tmp3;?>
</em>
                <p>账户余额</p>
            </li>
            <li class="a2">
                <em><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['allow']['allow_fund'];?>
<?php $_tmp4=ob_get_clean();?><?php echo $_tmp4;?>
</em>
                <p>可提现金额</p>
            </li>
            <li class="a3">
                <em><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['score'];?>
<?php $_tmp5=ob_get_clean();?><?php echo $_tmp5;?>
分</em>
                <p>商品积分</p>
            </li>
            <li class="a4">
                <em><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['allow']['allow_score'];?>
<?php $_tmp6=ob_get_clean();?><?php echo $_tmp6;?>
分</em>
                <p>可用积分</p>
            </li>
        </ul>
    </div>

    <ul class="oper_l">

        <li class="clear_fix" url="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'product/fund_detail'),$_smarty_tpl);?>
<?php $_tmp7=ob_get_clean();?><?php echo $_tmp7;?>
">
            <div class="col-m-8 col-s-8">账户明细</div>
            <div class="col-m-4 col-s-4">
                <em class="i_size_s f_right"><a class="i_arrow"><span class="a"></span><span class="b"></span></a></em>
            </div>
        </li>

        <li class="clear_fix" url="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'product/score_detail'),$_smarty_tpl);?>
<?php $_tmp8=ob_get_clean();?><?php echo $_tmp8;?>
">
            <div class="col-m-8 col-s-8">积分明细</div>
            <div class="col-m-4 col-s-4">
                <em class="i_size_s f_right"><a class="i_arrow"><span class="a"></span><span class="b"></span></a></em>
            </div>
        </li>

        <li class="clear_fix" url="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'product/withdraw'),$_smarty_tpl);?>
<?php $_tmp9=ob_get_clean();?><?php echo $_tmp9;?>
">
            <div class="col-m-8 col-s-8">提现</div>
            <div class="col-m-4 col-s-4">
                <em class="i_size_s f_right"><a class="i_arrow"><span class="a"></span><span class="b"></span></a></em>
            </div>
        </li>
    </ul>


    <div class="b_bar"><a class="btn btn_white" href="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'product/explain'),$_smarty_tpl);?>
<?php $_tmp10=ob_get_clean();?><?php echo $_tmp10;?>
">活动说明 >></a></div>


</div>

</body>
<script src="/res/js/jquery-1.11.0.min.js"></script>
<script>
    $(".oper_l li").click(function(){
        location.href = $(this).attr('url')
    });
</script>
</html>
<?php }} ?>
