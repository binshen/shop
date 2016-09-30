<?php /* Smarty version Smarty-3.1.16, created on 2016-09-13 15:33:25
         compiled from "application/views/withdraw.html" */ ?>
<?php /*%%SmartyHeaderCode:68901280357b7bc8d534536-87219749%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7369b2adfd14da612ec498520c3b97189d9fba4f' => 
    array (
      0 => 'application/views/withdraw.html',
      1 => 1473661232,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '68901280357b7bc8d534536-87219749',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_57b7bc8d5671e1_99983525',
  'variables' => 
  array (
    'surplus' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b7bc8d5671e1_99983525')) {function content_57b7bc8d5671e1_99983525($_smarty_tpl) {?><?php if (!is_callable('smarty_function_site_url')) include '/var/www/html/shop/application/libraries/smarty/plugins/function.site_url.php';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>申请提现</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link href="/res/css/main.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="layout p_l_t">

    <ul class="list">
        <li>将获得的红包兑换至微信“钱包”</li>
    </ul>

    <form action="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'product/save_withdraw'),$_smarty_tpl);?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
" method="post">
        <ul class="list">
            <li>提现金额</li>
            <li class="p_l_tb"><span class="f_left t_size_m">￥</span><input type="number" class="money" name="money" value="" /></li>
            <li><span class="c_gray">可提现余额：￥<?php ob_start();?><?php if (!$_smarty_tpl->tpl_vars['surplus']->value) {?><?php $_tmp2=ob_get_clean();?><?php echo $_tmp2;?>
0<?php ob_start();?><?php }?><?php $_tmp3=ob_get_clean();?><?php echo $_tmp3;?>
<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['surplus']->value;?>
<?php $_tmp4=ob_get_clean();?><?php echo $_tmp4;?>
</span> <a href="javascript:all_surplus();" class="c_orange">全部申请兑换</a></li>

            <li>联系电话(非常重要)</li>
            <li class="p_l_tb"><input type="number" class="money" name="phone" value="" style="width:100%" placeholder=""/></li>
        </ul>
    </form>

    <div class="b_bar">
        <p class="p_lr p_l_b c_gray t_size_s t_center">申请兑奖后，工作人员将核实您的奖品红包，<br/>信息核实无误后的7个工作日内，<br/>兑换红包金额将充值至您的微信“钱包”中，请注意查收。</p>

        <button class="btn btn_orange" onclick="javascript:save_withdraw();">提交申请</button></div>

    </div>

</body>
<script src="/res/js/jquery-1.11.0.min.js"></script>
<script>

    function all_surplus(){
        surplus = '<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['surplus']->value;?>
<?php $_tmp5=ob_get_clean();?><?php echo $_tmp5;?>
'
        $('[name="money"]').val(surplus)
    }

    function save_withdraw(){
        surplus = '<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['surplus']->value;?>
<?php $_tmp6=ob_get_clean();?><?php echo $_tmp6;?>
'
        phone = $('[name="phone"]').val().toString()
        
        var pattern = /^1[3|4|5|7|8]\d{9}$/;
        if(isNaN(parseInt($('.money').val()))){
            alert("请输入数字");
            $('[name="money"]').val('')
            return;
        }
        if(parseInt($('[name="money"]').val()) <= 0){
            alert('提现金额不能小于0');
            return;
        }
        if(parseInt($('[name="money"]').val()) > parseInt(surplus)){
            alert('提现金额不能大于余额');
            return;
        }

        if(!pattern.test(phone)){
            alert('请输入正确的手机号码');
            return;
        }
        
        $('form').submit();
    }


</script>
</html><?php }} ?>
