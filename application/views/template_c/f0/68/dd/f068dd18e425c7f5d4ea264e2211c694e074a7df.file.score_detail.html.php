<?php /* Smarty version Smarty-3.1.16, created on 2016-08-20 10:46:42
         compiled from "application/views/score_detail.html" */ ?>
<?php /*%%SmartyHeaderCode:110820317057b7bb400a2264-47796651%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f068dd18e425c7f5d4ea264e2211c694e074a7df' => 
    array (
      0 => 'application/views/score_detail.html',
      1 => 1471658955,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '110820317057b7bb400a2264-47796651',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_57b7bb4013e012_23264013',
  'variables' => 
  array (
    'data' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b7bb4013e012_23264013')) {function content_57b7bb4013e012_23264013($_smarty_tpl) {?><?php if (!is_callable('smarty_function_site_url')) include '/var/www/html/shop/application/libraries/smarty/plugins/function.site_url.php';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>积分明细</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link href="/res/css/main.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="layout">


    <div class="prize_bar">总收益<span class="c_yellow"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['all'];?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
分</span> 剩余<span class="c_yellow"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['surplus'];?>
<?php $_tmp2=ob_get_clean();?><?php echo $_tmp2;?>
分</span></div>
<div id="order_list">
    <?php ob_start();?><?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['res_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
?><?php $_tmp3=ob_get_clean();?><?php echo $_tmp3;?>

    <ul class="list3 m_l_t">
        <li class="col-m-6 col-s-6"><p><font color="blue"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
<?php $_tmp4=ob_get_clean();?><?php echo $_tmp4;?>
</font> 购买 <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['product_name'];?>
<?php $_tmp5=ob_get_clean();?><?php echo $_tmp5;?>
 <p>￥<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['price'];?>
<?php $_tmp6=ob_get_clean();?><?php echo $_tmp6;?>
 x <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['qty'];?>
<?php $_tmp7=ob_get_clean();?><?php echo $_tmp7;?>
</p></p><p class="c_gray t_size_s">2016-06-07 11:23:53</p></li>
        <li class="col-m-6 col-s-6 t_right">
            <p>
                <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['row']->value['score']>0) {?><?php $_tmp8=ob_get_clean();?><?php echo $_tmp8;?>

                <font color="green">+<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['score'];?>
<?php $_tmp9=ob_get_clean();?><?php echo $_tmp9;?>
</font>
                <?php ob_start();?><?php } else { ?><?php $_tmp10=ob_get_clean();?><?php echo $_tmp10;?>

                <font color="red"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['score'];?>
<?php $_tmp11=ob_get_clean();?><?php echo $_tmp11;?>
</font>
                <?php ob_start();?><?php }?><?php $_tmp12=ob_get_clean();?><?php echo $_tmp12;?>

            </p>
                <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['row']->value['type']==2) {?><?php $_tmp13=ob_get_clean();?><?php echo $_tmp13;?>

                    <p class="c_green t_size_s">购买商品抵扣</p>
                <?php ob_start();?><?php }?><?php $_tmp14=ob_get_clean();?><?php echo $_tmp14;?>


        </li>
    </ul>
    <?php ob_start();?><?php } ?><?php $_tmp15=ob_get_clean();?><?php echo $_tmp15;?>

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

        $.getJSON("<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'product/score_detail_ajax'),$_smarty_tpl);?>
<?php $_tmp16=ob_get_clean();?><?php echo $_tmp16;?>
/"+page,function(data){

            html='';
            if (data!=1){
                data.res_list.forEach(function (item) {
                    html+='<ul class="list3 m_l_t">'
                    html+='<li class="col-m-6 col-s-6"><p><font color="blue">'+item.name+'</font> 购买 '+ item.product_name +'<p>￥'+ item.price +' x '+ item.qty +'</p></p><p class="c_gray t_size_s">'+item.cdate+'</p></li>'
                    html+='<li class="col-m-6 col-s-6 t_right">'

                    if(item.score > 0){
                        html+='<p><font color="green">+'+item.score+'</font></p>'
                    }else{
                        html+='<p><font color="red">'+item.score+'</font></p>'
                    }

                    if(item.type == 2){
                        html+='<p class="c_green t_size_s">购买商品抵扣</p>'
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
