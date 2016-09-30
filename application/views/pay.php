<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>支付订单</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link href="/res/css/main.css" rel="stylesheet" type="text/css" />
</head>

<body>
<script src="/res/js/jquery-1.11.0.min.js"></script>
<?php
$jsApiParameters = $parameters;//参数赋值
?>
<script type="text/javascript">

    //我在这里选择了前台只要支付成功将单号传递更新数据
    //        $.get('<?php //echo site_url('product/notify').'/'.$pubid?>//',function(data){
    //            alert(data);
    //        });


    //调用微信JS api 支付my_info
    function jsApiCall()
    {
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest',
            <?php echo $jsApiParameters; ?>,
            function(res){
                WeixinJSBridge.log(res.err_msg);

                if(res.err_msg == "get_brand_wcpay_request:ok" ){
                    alert('支付成功');
                    location.href='<?php echo base_url().'product/order_info/'.$orderid;?>';

//                    $.get('<?php //echo site_url('product/notify').'/'.$pubid;?>//',function(ret){
//                        if(ret==1){
//                            alert('支付成功');
//                            //成功后返回我的订单页面
//                            location.href='<?php //echo base_url().'product/order_info/'.$orderid;?>//';
//                        }else{
//                            alert(ret)
//                        }
//                    });

                }else
                {
                    alert('支付失败');
                }
            }
        );
    }

    function callpay()
    {

        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        }else{
            jsApiCall();
        }
    }
</script>

<div class="layout p_l_t">

    <ul class="list">
        <li class="col-m-3 col-s-3">订单编号</li>
        <li class="col-m-9 col-s-9"><?php echo $pubid;?></li>
    </ul>

    <ul class="list">
        <li class="col-m-3 col-s-3">商品名称</li>
        <li class="col-m-9 col-s-9">
            <?php
            if($productList!=1){
                foreach ($productList as $key=>$value){
                    if($key!=0){
                        echo ',';
                    }
                    echo $value['pro_name'];
                }
            }
            ?>
        </li>
    </ul>

    <ul class="list">
        <li class="col-m-3 col-s-3">商户名称</li>
        <li class="col-m-9 col-s-9">七星博士电商平台</li>
    </ul>

    <ul class="list">
        <li class="col-m-3 col-s-3">支付金额</li>
        <li class="col-m-9 col-s-9 c_orange">￥<?php echo $fee;?></li>
    </ul>


    <div class="b_bar"><button class="btn btn_orange" onclick="javascript:callpay();">确认支付</button></div>

</div>
<a class="btn_all" href="<?php echo site_url('product/my_order') ?>"><span>全部订单</span></a>
</body>


</html>