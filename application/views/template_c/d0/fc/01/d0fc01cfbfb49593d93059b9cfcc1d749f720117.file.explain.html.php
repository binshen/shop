<?php /* Smarty version Smarty-3.1.16, created on 2016-09-20 17:20:48
         compiled from "application/views/explain.html" */ ?>
<?php /*%%SmartyHeaderCode:141411163657b6c362ae19b7-22892715%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd0fc01cfbfb49593d93059b9cfcc1d749f720117' => 
    array (
      0 => 'application/views/explain.html',
      1 => 1474362729,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '141411163657b6c362ae19b7-22892715',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_57b6c362b1f937_52538006',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b6c362b1f937_52538006')) {function content_57b6c362b1f937_52538006($_smarty_tpl) {?><?php if (!is_callable('smarty_function_site_url')) include '/var/www/html/shop/application/libraries/smarty/plugins/function.site_url.php';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>活动明细</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link href="/res/css/main.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="layout">
    <h3 class="explain_t">三级分销奖励规则</h3>
    <div class="explain_box">
        <p>奖励分现金和红包积分两种。现金可联系客服提现，红包积分可在下次购物时以等值的方式（1分=1元）抵用。</p>
        <div style="width:300px;margin:0 auto;padding-bottom:15px"><img src="/res/images/explain_p.png" width="300" /></div>
        <p>首次购买商品，无现金和红包奖励：</p>
        <p>一级好友通过你分享的链接完成商品购买，每购买一个商品，你可获得20元现金和13个积分的红包奖励。</p>
        <p>二级好友通过他朋友分享的链接完成商品购买，每购买一个商品，你可获得6元现金和5个积分的红包奖励。</p>
        <p>三级好友通过他朋友分享的链接完成商品购买，每购买一个商品，你可获得2元现金和1个积分的红包奖励。</p>
        <p>三级以上的好友购买商品。你将不再获取任何现金和红包奖励。</p>
        <h4>退货细则</h4>
        <p>客户申请退货将需要承担该笔业务产生的所有上级获得的现金奖励、积分奖励及来回运费，具体请联系客服。</p>

    </div>

    <div class="b_bar"><a class="btn btn_green" href="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'product/user_center'),$_smarty_tpl);?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
">返回</a></div>

</div>

</body>
</html><?php }} ?>
