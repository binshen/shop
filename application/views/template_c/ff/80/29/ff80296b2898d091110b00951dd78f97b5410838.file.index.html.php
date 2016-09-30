<?php /* Smarty version Smarty-3.1.16, created on 2016-09-07 17:16:14
         compiled from "application/views/index.html" */ ?>
<?php /*%%SmartyHeaderCode:17825981857b41527b99e98-91505063%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ff80296b2898d091110b00951dd78f97b5410838' => 
    array (
      0 => 'application/views/index.html',
      1 => 1473239769,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17825981857b41527b99e98-91505063',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_57b41527c4de18_72402031',
  'variables' => 
  array (
    'data' => 0,
    'wxappId' => 0,
    'wxtimestamp' => 0,
    'wxnonceStr' => 0,
    'wxsignature' => 0,
    'userID' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57b41527c4de18_72402031')) {function content_57b41527c4de18_72402031($_smarty_tpl) {?><?php if (!is_callable('smarty_function_site_url')) include '/var/www/html/shop/application/libraries/smarty/plugins/function.site_url.php';
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link href="/res/css/main.css" rel="stylesheet" type="text/css" />


</head>

<body>

<div class="layout_index">

    <div class="buy_box p_m_tb"><button class="btn btn_buy" id="show">我要买</button></div>

    <!-弹出->
    <div class="buy_box p_l_tb" id="buy_detail" style="display:none">

        <div class="pop_close"><a class="i_close" id="hide"><span class="a"></span><span class="b"></span></a></div>

        <div id="tab">
            <ul class="list">
                <li class="col-m-3 col-s-3"><img src="/uploadfiles/products/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['bg_pic'];?>
<?php $_tmp2=ob_get_clean();?><?php echo $_tmp2;?>
" class="goods_pic" /></li>
                <li class="col-m-8 col-s-8">
                    <p class="overflow_h"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
<?php $_tmp3=ob_get_clean();?><?php echo $_tmp3;?>
</p><p class="c_orange">￥<span id="price"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['price'];?>
<?php $_tmp4=ob_get_clean();?><?php echo $_tmp4;?>
</span></p>
                </li>
            </ul>

            <ul class="list">
                <li class="col-m-3 col-s-3">购买数量</li>
                <li class="col-m-9 col-s-9 goods_num">
                    <button class="reduce off" id="min">-</button>
                    <input class="value on" id="text_box" type="text" value="1" readonly>
                    <button class="plus on" id="add">+</button>
                </li>
            </ul>

        </div>

        <div class="prize_tips line p_m_b m_m_b p_lr"><span>奖</span>将宝贝推荐给好友，好友每购买一次，您可获得33元红包哦！您可到”会员中心”查看并提现~</div>
        <button class="btn btn_buy" onclick="javascript:next();">下一步</button>

    </div>


    <div class="pd_box">
        <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['desc'];?>
<?php $_tmp5=ob_get_clean();?><?php echo $_tmp5;?>

    </div>
</div>
<a class="btn_all" href="<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'product/my_order'),$_smarty_tpl);?>
<?php $_tmp6=ob_get_clean();?><?php echo $_tmp6;?>
"><span>全部订单</span></a>
</body>
<script src="/res/js/jquery-1.11.0.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#hide").click(function(){
            $("#buy_detail").hide();
        });
        $("#show").click(function(){
            $("#buy_detail").show();
        });
    });
</script>
<script type="text/javascript">
    $(function(){
        $("#add").click(function(){
            $("#text_box").val(parseInt($("#text_box").val())+1)
            $("#min").addClass('on').removeClass('off');
        })
        $("#min").click(function(){
            if($("#text_box").val() == 2){
                $("#min").addClass('off').removeClass('on');
            }
            if($("#text_box").val() > 1){
                $("#text_box").val(parseInt($("#text_box").val())-1)
            }
        })
    })
</script>
<script>
    function next(){
        pid = "<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
<?php $_tmp7=ob_get_clean();?><?php echo $_tmp7;?>
";
        pd_id = "<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['pd_id'];?>
<?php $_tmp8=ob_get_clean();?><?php echo $_tmp8;?>
";
        qty = $("#text_box").val();
        url = "<?php ob_start();?><?php echo smarty_function_site_url(array('url'=>'product/buy_pro'),$_smarty_tpl);?>
<?php $_tmp9=ob_get_clean();?><?php echo $_tmp9;?>
/"+pid+'/'+pd_id+'/'+qty;
        window.location.href = url;
    }

    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: '<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['wxappId']->value;?>
<?php $_tmp10=ob_get_clean();?><?php echo $_tmp10;?>
', // 必填，公众号的唯一标识
        timestamp:<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['wxtimestamp']->value;?>
<?php $_tmp11=ob_get_clean();?><?php echo $_tmp11;?>
, // 必填，生成签名的时间戳
        nonceStr: '<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['wxnonceStr']->value;?>
<?php $_tmp12=ob_get_clean();?><?php echo $_tmp12;?>
', // 必填，生成签名的随机串
        signature: '<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['wxsignature']->value;?>
<?php $_tmp13=ob_get_clean();?><?php echo $_tmp13;?>
',// 必填，签名，见附录1
        jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });

    wx.ready(function () {
        wx.checkJsApi({
            jsApiList: [
                'onMenuShareTimeline',
                'onMenuShareAppMessage'
            ]
        });

        //分享朋友圈
        wx.onMenuShareTimeline({
            title: '<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
<?php $_tmp14=ob_get_clean();?><?php echo $_tmp14;?>
', // 分享标题
            link: 'http://shop.7drlb.com/product/index/26?userID=<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['userID']->value;?>
<?php $_tmp15=ob_get_clean();?><?php echo $_tmp15;?>
', // 分享链接
            imgUrl: 'http://shop.7drlb.com/uploadfiles/products/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['bg_pic'];?>
<?php $_tmp16=ob_get_clean();?><?php echo $_tmp16;?>
', // 分享图标
            success: function () {
                // 用户确认分享后执行的回调函数
            },

            cancel: function () {
                // 用户取消分享后执行的回调函数
            }

        });

        //发送朋友
        wx.onMenuShareAppMessage({
            title: '<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
<?php $_tmp17=ob_get_clean();?><?php echo $_tmp17;?>
', // 分享标题
            desc: '<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
<?php $_tmp18=ob_get_clean();?><?php echo $_tmp18;?>
', // 分享描述
            link: 'http://shop.7drlb.com/product/index/26?userID=<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['userID']->value;?>
<?php $_tmp19=ob_get_clean();?><?php echo $_tmp19;?>
', // 分享链接
            imgUrl: 'http://shop.7drlb.com/uploadfiles/products/<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value['bg_pic'];?>
<?php $_tmp20=ob_get_clean();?><?php echo $_tmp20;?>
', // 分享图标
            type: 'link', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
            },

            cancel: function () {
                // 用户取消分享后执行的回调函数
            }

        });


    });
    wx.error(function (res) {
        alert('wx.error: '+JSON.stringify(res));
    });


</script>
</html><?php }} ?>
