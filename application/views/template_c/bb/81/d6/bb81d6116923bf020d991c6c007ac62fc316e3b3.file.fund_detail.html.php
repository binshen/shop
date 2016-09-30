<?php /* Smarty version Smarty-3.1.16, created on 2016-09-06 10:24:09
         compiled from "application/views/fund_detail.html" */ ?>
<?php /*%%SmartyHeaderCode:168861123057b6ca4288e6b5-64438234%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bb81d6116923bf020d991c6c007ac62fc316e3b3' => 
    array (
      0 => 'application/views/fund_detail.html',
      1 => 1473128634,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '168861123057b6ca4288e6b5-64438234',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_57b6ca428bd975_66529617',
  'variables' => 
  array (
    'data' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b6ca428bd975_66529617')) {function content_57b6ca428bd975_66529617($_smarty_tpl) {?><?php if (!is_callable('smarty_function_site_url')) include '/var/www/html/shop/application/libraries/smarty/plugins/function.site_url.php';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>账户明细</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link href="/res/css/main.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="layout">


    <div class="prize_bar">总收益<span class="c_yellow">￥<?php ob_start();?><?php if (!$_smarty_tpl->tpl_vars['data']->value['all']) {?><?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
0<?php ob_start();?><?php }?><?php $_tmp2=ob_get_clean();?><?php echo $_tmp2;?>
<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['all'];?>
<?php $_tmp3=ob_get_clean();?><?php echo $_tmp3;?>
</span> 余额<span class="c_yellow">￥<?php ob_start();?><?php if (!$_smarty_tpl->tpl_vars['data']->value['surplus']) {?><?php $_tmp4=ob_get_clean();?><?php echo $_tmp4;?>
0<?php ob_start();?><?php }?><?php $_tmp5=ob_get_clean();?><?php echo $_tmp5;?>
<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['surplus'];?>
<?php $_tmp6=ob_get_clean();?><?php echo $_tmp6;?>
</span></div>
<div id="order_list">
    <?php ob_start();?><?php if (!$_smarty_tpl->tpl_vars['data']->value['res_list']) {?><?php $_tmp7=ob_get_clean();?><?php echo $_tmp7;?>

    <p class="t_center p_l_tb">抱歉~暂无收益...</p>
    <?php ob_start();?><?php }?><?php $_tmp8=ob_get_clean();?><?php echo $_tmp8;?>

    <?php ob_start();?><?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['res_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
?><?php $_tmp9=ob_get_clean();?><?php echo $_tmp9;?>

    <ul class="list3 m_l_t">
        <li class="col-m-6 col-s-6">
            <p>
                <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['row']->value['type']!=1) {?><?php $_tmp10=ob_get_clean();?><?php echo $_tmp10;?>

                <font color="blue">申请提现</font><p class="c_gray t_size_s"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['cdate'];?>
<?php $_tmp11=ob_get_clean();?><?php echo $_tmp11;?>
</p>
                <?php ob_start();?><?php } else { ?><?php $_tmp12=ob_get_clean();?><?php echo $_tmp12;?>

                <font color="blue"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
<?php $_tmp13=ob_get_clean();?><?php echo $_tmp13;?>
</font> 购买 <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['product_name'];?>
<?php $_tmp14=ob_get_clean();?><?php echo $_tmp14;?>
 <p>￥<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['price'];?>
<?php $_tmp15=ob_get_clean();?><?php echo $_tmp15;?>
 x <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['qty'];?>
<?php $_tmp16=ob_get_clean();?><?php echo $_tmp16;?>
</p></p><p class="c_gray t_size_s"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['cdate'];?>
<?php $_tmp17=ob_get_clean();?><?php echo $_tmp17;?>

                <?php ob_start();?><?php }?><?php $_tmp18=ob_get_clean();?><?php echo $_tmp18;?>

            </p>
        </li>
        <li class="col-m-6 col-s-6 t_right">
            <p>
                <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['row']->value['fund']>0) {?><?php $_tmp19=ob_get_clean();?><?php echo $_tmp19;?>

                <font color="green">+<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['fund'];?>
<?php $_tmp20=ob_get_clean();?><?php echo $_tmp20;?>
</font>
                <?php ob_start();?><?php } else { ?><?php $_tmp21=ob_get_clean();?><?php echo $_tmp21;?>

                <font color="red"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['fund'];?>
<?php $_tmp22=ob_get_clean();?><?php echo $_tmp22;?>
</font>
                <?php ob_start();?><?php }?><?php $_tmp23=ob_get_clean();?><?php echo $_tmp23;?>

            </p>
                <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['row']->value['type']==2) {?><?php $_tmp24=ob_get_clean();?><?php echo $_tmp24;?>

                    <p class="c_green t_size_s">提现处理中</p>
                <?php ob_start();?><?php }?><?php $_tmp25=ob_get_clean();?><?php echo $_tmp25;?>

                <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['row']->value['type']==3) {?><?php $_tmp26=ob_get_clean();?><?php echo $_tmp26;?>

                    <p class="c_green t_size_s">兑换金额已进入微信钱包</p>
                <?php ob_start();?><?php }?><?php $_tmp27=ob_get_clean();?><?php echo $_tmp27;?>

        </li>
    </ul>
    <?php ob_start();?><?php } ?><?php $_tmp28=ob_get_clean();?><?php echo $_tmp28;?>

    <!--<ul class="list3 m_l_t">-->
        <!--<li class="col-m-6 col-s-6"><p>XXX奖品名称</p><p class="c_gray t_size_s">2016-06-07 11:23:53</p></li>-->
        <!--<li class="col-m-6 col-s-6 t_right">-->
            <!--<p>-200</p>-->
            <!--<p class="c_green t_size_s">兑奖处理中</p>-->
        <!--</li>-->
    <!--</ul>-->
    <!--<ul class="list3 m_l_t">-->
        <!--<li class="col-m-6 col-s-6"><p>XXX奖品名称</p><p class="c_gray t_size_s">2016-06-07 11:23:53</p></li>-->
        <!--<li class="col-m-6 col-s-6 t_right"><p>-200</p><p class="c_orange t_size_s">兑换金额已进入微信钱包</p></li>-->
    <!--</ul>-->

</div>
    <div class="b_bar">
        <button class="btn btn_white" id="get_more">加载更多</button>
        <input type="hidden" name="page" id="page" value="2">
    </div>

    </div>

</body>
<script src="/res/js/jquery-1.11.0.min.js"></script>
<script>
    $("#get_more").click(function () {
        var page=$("#page").val();
        $.getJSON("<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'product/fund_detail_ajax'),$_smarty_tpl);?>
<?php $_tmp29=ob_get_clean();?><?php echo $_tmp29;?>
/"+page,function(data){
            html='';
            if (data!=1){
                data.res_list.forEach(function (item) {
                    html+='<ul class="list3 m_l_t">'
                    if(item.type == 1){
                        html+='<li class="col-m-6 col-s-6"><p><font color="blue">'+item.name+'</font> 购买 '+ item.product_name +'<p>￥'+ item.price +' x '+ item.qty +'</p></p><p class="c_gray t_size_s">'+item.cdate+'</p></li>'
                    }else{
                        html+='<li class="col-m-6 col-s-6"><p><font color="blue">申请提现</font></p><p class="c_gray t_size_s">'+ item.cdate +'</p></li>'
                    }
                    html+='<li class="col-m-6 col-s-6 t_right">'

                    if(item.fund > 0){
                        html+='<p><font color="green">+'+item.fund+'</font></p>'
                    }else{
                        html+='<p><font color="red">'+item.fund+'</font></p>'
                    }
                    if(item.type == 2){
                        html+='<p class="c_green t_size_s">提现处理中</p>'
                    }
                    if(item.type == 3){
                        html+='<p class="c_green t_size_s">兑换金额已进入微信钱包</p>'
                    }

                    html += '</li></ul>'
                })
                $("#order_list").append(html);
                pageint=parseInt(page)+1;
                $("#page").val(pageint);
            } else{
                $('.b_bar').html('<button class="btn btn_white">已无更多信息</button>')
//                $("#get_product").html('已无更多信息')
            }

        });
    })
</script>
</html><?php }} ?>
