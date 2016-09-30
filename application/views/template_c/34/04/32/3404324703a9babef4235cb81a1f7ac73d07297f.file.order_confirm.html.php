<?php /* Smarty version Smarty-3.1.16, created on 2016-09-08 13:33:55
         compiled from "application/views/order_confirm.html" */ ?>
<?php /*%%SmartyHeaderCode:149882017857b414cab39436-88926810%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3404324703a9babef4235cb81a1f7ac73d07297f' => 
    array (
      0 => 'application/views/order_confirm.html',
      1 => 1473312818,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '149882017857b414cab39436-88926810',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_57b414cac84700_39171890',
  'variables' => 
  array (
    'data' => 0,
    'qty' => 0,
    'score' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b414cac84700_39171890')) {function content_57b414cac84700_39171890($_smarty_tpl) {?><?php if (!is_callable('smarty_function_site_url')) include '/var/www/html/shop/application/libraries/smarty/plugins/function.site_url.php';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>待付款订单</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link href="/res/css/main.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="layout p_l_t" id="main">
    <form action="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'product/save_order'),$_smarty_tpl);?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
" method="post">
        <input type="hidden" name="address_id" <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['data']->value['address']) {?><?php $_tmp2=ob_get_clean();?><?php echo $_tmp2;?>
value="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['address']['id'];?>
<?php $_tmp3=ob_get_clean();?><?php echo $_tmp3;?>
"<?php ob_start();?><?php }?><?php $_tmp4=ob_get_clean();?><?php echo $_tmp4;?>
>
        <input type="hidden" name="pid" value="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['detail']['id'];?>
<?php $_tmp5=ob_get_clean();?><?php echo $_tmp5;?>
">
        <input type="hidden" name="price" value="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['detail']['de_price'];?>
<?php $_tmp6=ob_get_clean();?><?php echo $_tmp6;?>
">
        <input type="hidden" name="qty" value="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['qty']->value;?>
<?php $_tmp7=ob_get_clean();?><?php echo $_tmp7;?>
">
        <input type="hidden" name="pd_id" value="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['detail']['pd_id'];?>
<?php $_tmp8=ob_get_clean();?><?php echo $_tmp8;?>
">



    <ul class="list">
        <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['data']->value['address']) {?><?php $_tmp9=ob_get_clean();?><?php echo $_tmp9;?>

        <li class="col-m-11 col-s-11">
            <p><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['address']['name'];?>
<?php $_tmp10=ob_get_clean();?><?php echo $_tmp10;?>
 <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['address']['phone'];?>
<?php $_tmp11=ob_get_clean();?><?php echo $_tmp11;?>
</p><p><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['address']['f_name'];?>
<?php $_tmp12=ob_get_clean();?><?php echo $_tmp12;?>
 <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['address']['g_name'];?>
<?php $_tmp13=ob_get_clean();?><?php echo $_tmp13;?>
  <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['address']['h_name'];?>
<?php $_tmp14=ob_get_clean();?><?php echo $_tmp14;?>
 <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['address']['address'];?>
<?php $_tmp15=ob_get_clean();?><?php echo $_tmp15;?>
</p>
        </li>
        <li class="col-m-1 col-s-1">
            <p class="lh_xl t_right"><div class="i_size_m f_right m_l_t"><a href="javascript:add_address();" class="i_arrow"><span class="a"></span><span class="b"></span></a></div></p>
        </li>
        <?php ob_start();?><?php } else { ?><?php $_tmp16=ob_get_clean();?><?php echo $_tmp16;?>

        <li class="col-m-9 col-s-9">
            <p class="lh_m">新增收货地址</p>
        </li>
        <li class="col-m-3 col-s-3"><a href="javascript:add_address();" class="i_plus f_right"><span class="a"></span><span></span></a></li>
        <?php ob_start();?><?php }?><?php $_tmp17=ob_get_clean();?><?php echo $_tmp17;?>

    </ul>

    <ul class="list">
        <li class="col-m-3 col-s-3"><img src="/uploadfiles/products/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['detail']['bg_pic'];?>
<?php $_tmp18=ob_get_clean();?><?php echo $_tmp18;?>
" class="goods_pic" /></li>
        <li class="col-m-9 col-s-9">
            <p class="overflow_h"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['detail']['name'];?>
<?php $_tmp19=ob_get_clean();?><?php echo $_tmp19;?>
</p>
            <p class="c_orange"><span class="f_right">x<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['qty']->value;?>
<?php $_tmp20=ob_get_clean();?><?php echo $_tmp20;?>
</span>￥<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['detail']['de_price'];?>
<?php $_tmp21=ob_get_clean();?><?php echo $_tmp21;?>
</p>
        </li>
    </ul>

    <ul class="list">
        <li class="col-m-8 col-s-8">使用积分<input type="number" name="score" value="0" class="gold_in"/>个<p class="c_gray t_size_s">（可用积分:<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['score']->value;?>
<?php $_tmp22=ob_get_clean();?><?php echo $_tmp22;?>
）</p></li>
        <li class="col-m-4 col-s-4 t_right" id="score_p">-￥00.00</li>
    </ul>
    </form>

    <p class="p_lr c_orange" >需支付金额：￥<span class="t_size_m shengyu"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['detail']['de_price']*$_smarty_tpl->tpl_vars['qty']->value;?>
<?php $_tmp23=ob_get_clean();?><?php echo $_tmp23;?>
</span></p>
    <div class="b_bar"><button class="btn btn_orange" onclick="javascript:save_order();">去支付</button></div>
</div>



<div class="layout p_l_t" style="display:none;" id="edit_address">

    <ul class="list">
        <li class="col-s-2 col-m-2">姓名</li>
        <li class="col-s-9 col-m-9">
            <input type="text" id="1" name="name" placeholder="姓名" value="<?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['data']->value['address']) {?><?php $_tmp24=ob_get_clean();?><?php echo $_tmp24;?>
<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['address']['name'];?>
<?php $_tmp25=ob_get_clean();?><?php echo $_tmp25;?>
<?php ob_start();?><?php }?><?php $_tmp26=ob_get_clean();?><?php echo $_tmp26;?>
" class="address_in" />
        </li>
    </ul>

    <ul class="list">
        <li class="col-s-2 col-m-2">电话</li>
        <li class="col-s-9 col-m-9">
            <input type="text" id="2" name="phone" placeholder="电话" value="<?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['data']->value['address']) {?><?php $_tmp27=ob_get_clean();?><?php echo $_tmp27;?>
<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['address']['phone'];?>
<?php $_tmp28=ob_get_clean();?><?php echo $_tmp28;?>
<?php ob_start();?><?php }?><?php $_tmp29=ob_get_clean();?><?php echo $_tmp29;?>
" class="address_in">
        </li>
    </ul>

    <ul class="list">
        <li class="col-s-2 col-m-2">地区</li>
        <li class="col-s-10 col-m-10">
            <div class="address_select">
                <select name="province" class="col-m-4 col-s-4 address_s" onchange="change_province(this)">
                    <option value="">-选择省份-</option>
                    <?php ob_start();?><?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['province']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
?><?php $_tmp30=ob_get_clean();?><?php echo $_tmp30;?>

                    <option value="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['code'];?>
<?php $_tmp31=ob_get_clean();?><?php echo $_tmp31;?>
" ><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
<?php $_tmp32=ob_get_clean();?><?php echo $_tmp32;?>
</option>
                    <?php ob_start();?><?php } ?><?php $_tmp33=ob_get_clean();?><?php echo $_tmp33;?>

                </select>
                <select name="city" class="col-m-4 col-s-4 address_s" onchange="change_city(this)">
                    <option value="">-选择城市-</option>
                    <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['data']->value['city']) {?><?php $_tmp34=ob_get_clean();?><?php echo $_tmp34;?>

                        <?php ob_start();?><?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['city']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
?><?php $_tmp35=ob_get_clean();?><?php echo $_tmp35;?>

                        <option value="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['code'];?>
<?php $_tmp36=ob_get_clean();?><?php echo $_tmp36;?>
"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
<?php $_tmp37=ob_get_clean();?><?php echo $_tmp37;?>
</option>
                        <?php ob_start();?><?php } ?><?php $_tmp38=ob_get_clean();?><?php echo $_tmp38;?>

                    <?php ob_start();?><?php }?><?php $_tmp39=ob_get_clean();?><?php echo $_tmp39;?>

                </select>
                <select name="area" class="col-m-4 col-s-4 address_s">
                    <option value="">-选择地区-</option>
                    <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['data']->value['area']) {?><?php $_tmp40=ob_get_clean();?><?php echo $_tmp40;?>

                        <?php ob_start();?><?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['area']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
?><?php $_tmp41=ob_get_clean();?><?php echo $_tmp41;?>

                        <option value="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['code'];?>
<?php $_tmp42=ob_get_clean();?><?php echo $_tmp42;?>
"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
<?php $_tmp43=ob_get_clean();?><?php echo $_tmp43;?>
</option>
                        <?php ob_start();?><?php } ?><?php $_tmp44=ob_get_clean();?><?php echo $_tmp44;?>

                    <?php ob_start();?><?php }?><?php $_tmp45=ob_get_clean();?><?php echo $_tmp45;?>

                </select>
            </div>
        </li>
    </ul>

    <ul class="list">
        <li class="col-s-2 col-m-2">地址</li>
        <li class="col-s-10 col-m-10">
            <input type="text" id="4" name="address" value="<?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['data']->value['address']) {?><?php $_tmp46=ob_get_clean();?><?php echo $_tmp46;?>
<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['address']['address'];?>
<?php $_tmp47=ob_get_clean();?><?php echo $_tmp47;?>
<?php ob_start();?><?php }?><?php $_tmp48=ob_get_clean();?><?php echo $_tmp48;?>
" class="address_in" placeholder="地址">
        </li>
    </ul>

    <ul class="list">
        <li class="col-s-2 col-m-2">邮编</li>
        <li class="col-s-7 col-m-7">
            <input type="text" id="5" name="zip" value="<?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['data']->value['address']) {?><?php $_tmp49=ob_get_clean();?><?php echo $_tmp49;?>
<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['address']['zip'];?>
<?php $_tmp50=ob_get_clean();?><?php echo $_tmp50;?>
<?php ob_start();?><?php }?><?php $_tmp51=ob_get_clean();?><?php echo $_tmp51;?>
" class="address_in" placeholder="邮编(选填)">
        </li>
        <li class="col-s-3 col-m-3 c_gray t_right">（此项选填）</li>
    </ul>
    <div class="b_bar"><button class="btn btn_green" onclick="javascript:save_address();">保存</button></div>

</div>
<a class="btn_all" href="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'product/my_order'),$_smarty_tpl);?>
<?php $_tmp52=ob_get_clean();?><?php echo $_tmp52;?>
"><span>全部订单</span></a>
</body>
<script src="/res/js/jquery-1.11.0.min.js"></script>
<script>
    function add_address(){
        $("#main").hide();
        $("#edit_address").show();
    }

    function save_address(){
        name = $('[name="name"]').val()
        phone = $('[name="phone"]').val()
        provice_code = $('[name="province"]').val()
        city_code = $('[name="city"]').val()
        area_code = $('[name="area"]').val()
        address = $('[name="address"]').val()
        zip = $('[name="zip"]').val()

//        
        post_data = {name:name,phone:phone,provice_code:provice_code,city_code:city_code,area_code:area_code,address:address,zip:zip}
//        

        $.post("<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'product/save_address'),$_smarty_tpl);?>
<?php $_tmp53=ob_get_clean();?><?php echo $_tmp53;?>
",post_data,function(data){
            if(data == 1){
                location.reload()
//                $("#edit_address").hide();
//                $("#main").show();
            }else{
                alert('添加失败');
            }
        })

    }

    function change_province(obj){
        if($(obj).val()){
            $.getJSON("<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'ajax/getcity'),$_smarty_tpl);?>
<?php $_tmp54=ob_get_clean();?><?php echo $_tmp54;?>
/"+$(obj).val(),function(data){
                city_html = '<option value="">-选择城市-</option>';
                data.forEach(function (item) {
                    city_html += '<option value="'+item.code+'">'+item.name+'</option>'
                })

                $("[name='city']").html(city_html)
                $('[name="area"]').val('');
            })
        }else{
            $("[name='city']").html('<option value="">-选择城市-</option>')
            $("[name='area']").html('<option value="">-选择地区-</option>')
            $('[name="city"]').val('');
            $('[name="area"]').val('');

        }
    }

    function change_city(obj){
        if($(obj).val()){
            $.getJSON("<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'ajax/getarea'),$_smarty_tpl);?>
<?php $_tmp55=ob_get_clean();?><?php echo $_tmp55;?>
/"+$(obj).val(),function(data){
                area_html = '<option value="">-选择地区-</option>';
                data.forEach(function (item) {
                    area_html += '<option value="'+item.code+'">'+item.name+'</option>'
                })

                $("[name='area']").html(area_html)
                $('[name="area"]').val('');
            })
        }else{
            $("[name='area']").html('<option value="">-选择地区-</option>')
            $('[name="area"]').val('');
        }
    }

    <?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['data']->value['address']) {?><?php $_tmp56=ob_get_clean();?><?php echo $_tmp56;?>

    $('[name="province"]').val('<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['address']['provice_code'];?>
<?php $_tmp57=ob_get_clean();?><?php echo $_tmp57;?>
')
    $('[name="city"]').val('<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['address']['city_code'];?>
<?php $_tmp58=ob_get_clean();?><?php echo $_tmp58;?>
')
    $('[name="area"]').val('<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['address']['area_code'];?>
<?php $_tmp59=ob_get_clean();?><?php echo $_tmp59;?>
')
    <?php ob_start();?><?php }?><?php $_tmp60=ob_get_clean();?><?php echo $_tmp60;?>


    function save_order(){
        if(!$("[name='address_id']").val()){
            alert('请输入收货地址');
            return;
        }
        $('form').submit();
    }

    $('.gold_in').blur(function(){
        score = parseInt($(this).val());
        if(!score){
            score = 0
            $(this).val(0)
        }
        total_price = '<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['detail']['de_price']*$_smarty_tpl->tpl_vars['qty']->value;?>
<?php $_tmp61=ob_get_clean();?><?php echo $_tmp61;?>
';
        total_price_float = new Number(total_price)
        total_price = parseInt(total_price);
        total_score = '<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['score']->value;?>
<?php $_tmp62=ob_get_clean();?><?php echo $_tmp62;?>
';
        total_score = parseInt(total_score)

        if(score > total_score || score > total_price){
            if(total_score > total_price){
                $(this).val(total_price)
                score = total_price
            }else{
                $(this).val(total_score)
                score = total_score
            }
        }
        $("#score_p").html('-￥'+score);

        $('.c_orange .shengyu').html((total_price_float - score).toFixed(2));
    })

    $(".gold_in").trigger("blur");

</script>
</html><?php }} ?>
