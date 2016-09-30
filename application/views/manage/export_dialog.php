
<style type="text/css">
    .file-box{ position:relative;width:340px}
    .btn{ background-color:#FFF; border:1px solid #CDCDCD;height:21px; width:70px;}
    .file{ position:absolute; top:0; right:80px; height:24px; filter:alpha(opacity:0);opacity: 0;width:300px }
</style>
<div class="pageContent">
    <form method="get"action="<?php echo site_url('manage/export_order');?>" class="pageForm required-validate">
        <div class="pageFormContent" layoutH="58">
            <div class="unit">
                <label>状态：</label>
                <select class="combox" name="status">
                    <option value="">-全部-</option>
                    <option value="1">待付款</option>
                    <option value="2">待发货</option>
                    <option value="3">已完成</option>
                    <option value="-1">已关闭</option>
                </select>
            </div>
            <div class="unit">
                <label>开始日期：</label>
                <input type="text" name="s_date" class="date required" readonly/>
            </div>
            <div class="unit">
                <label>结束日期：</label>
                <input type="text" name="e_date" class="date required" readonly/>
            </div>
        </div>
        <div class="formBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit" class="icon-save">导出</button></div></div></li>
                <li><div class="button"><div class="buttonContent"><button type="button" class="close icon-close">取消</button></div></div></li>
            </ul>
        </div>
    </form>
</div>
<script>

</script>