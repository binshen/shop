<style type="text/css">
.file-box{ position:relative;width:300px}
.btn{ background-color:#FFF; border:1px solid #CDCDCD;height:21px; width:70px;}
.file{ position:absolute; top:0; right:80px; height:24px; filter:alpha(opacity:0);opacity: 0;width:270px }

</style>
<div class="pageContent">
    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('manage/save_product');?>" class="pageForm required-validate" onsubmit="return iframeCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="55">
        	<fieldset style="width: 95%">
        	    <dl>
        			<dt>产品名称：</dt>
        			<dd>
						<input type="hidden" name="id" value="<?php if(!empty($id)) echo $id;?>">
						<input name="name" type="text" class="required" value="<?php if(!empty($name)) echo $name;?>" />
        			</dd>
        		</dl>

				<dl>
					<dt>照片：</dt>
					<dd>
						<div class="file-box">
							<input type="hidden" name="old_img" value="<?php if(!empty($bg_pic)) echo $bg_pic;?>" />
							<input type='text' id='textfield' class='txt' value="<?php if(!empty($bg_pic)) echo $bg_pic;?>" />
							<input type='button' class='btn' value='浏览...' />
							<input type="file" name="userfile" class="file" id="fileField"  onchange="document.getElementById('textfield').value=this.value" />
						</div>
					</dd>
				</dl>

				<dl class="nowrap">
					<dt>图片预览：</dt>
					<dd id="img"><?php if(!empty($bg_pic)):?><img height="100px" src="<?php echo base_url().'uploadfiles/products/'.$bg_pic;?>" /><?php endif;?></dd>
				</dl>

				<dl>
					<dt>产品状态：</dt>
					<dd>
						<select name="status" class="combox">
							<option value="1" <?php if(!empty($status) && $status == 1) echo 'selected="selected"';?>>销售中</option>
							<option value="-1" <?php if(!empty($status) && $status == -1) echo 'selected="selected"';?>>下架</option>
						</select>
					</dd>
				</dl>

        	</fieldset>
			<fieldset>
				<table class="list nowrap itemDetail" addButton="添加价格" width="100%" >
					<thead>
					<tr>
						<th type="text" width="80" name="size[]"  fieldClass="required" size="30">规格</th>
						<th type="file_class" name="price[]" fieldClass="required" size="10" width="120">价格</th>
						<th type="file_class" name="s_price[]" fieldClass="required" size="10" >运费</th>
						<th type="del" width="30">操作</th>
					</tr>
					</thead>
					<tbody class="tbody" id="file_list">
					<?php if(!empty($list)):?>
						<?php foreach($list as $k=>$v):?>
							<tr class="unitBox" id="<?php echo "olda".$v->id;?>">
								<td><input type="text" class="required" size='30' name="size[]" value="<?php echo $v->size?>"></td>
								<td><input type="text" class="required" size='10' name="price[]" value="<?php echo $v->price?>"></td>
								<td><input type="text" class="required" size='10' name="s_price[]" value="<?php echo $v->s_price?>"></td>
								<td><a class="btnDel" href="javascript:$('#olda<?php echo $v->id;?>').remove();void(0);"><span>删除</span></a></td>
							</tr>
						<?php endforeach;?>

					<?php endif;?>
					</tbody>
				</table>
			</fieldset>

			<fieldset>
				<legend>产品详情</legend>
				<dl class="nowrap">
					<dd><textarea class="editor" name="desc" rows="22" cols="100" upImgUrl="<?php echo site_url('manage/upload_pic')?>" upImgExt="jpg,jpeg,gif,png"  ><?php if(!empty($desc)) echo $desc;?></textarea></dd>
				</dl>
			</fieldset>

        </div>
        <div class="formBar">
    		<ul>
    			<li><div class="buttonActive"><div class="buttonContent"><button type="submit" class="icon-save">保存</button></div></div></li>
    			<li><div class="button"><div class="buttonContent"><button type="button" class="close icon-close">取消</button></div></div></li>
    		</ul>
        </div>
	</form>
</div>

<script>
	$("#fileField").change(function(){
		var objUrl = getObjectURL(this.files[0]);
		if (objUrl) {
			html = '<img height="100px" src="'+objUrl+'" />';
			$("#img").html(html) ;
		}
	}) ;
	//建立一個可存取到該file的url
	function getObjectURL(file) {
		var url = null ;
		if (window.createObjectURL!=undefined) { // basic
			url = window.createObjectURL(file) ;
		} else if (window.URL!=undefined) { // mozilla(firefox)
			url = window.URL.createObjectURL(file) ;
		} else if (window.webkitURL!=undefined) { // webkit or chrome
			url = window.webkitURL.createObjectURL(file) ;
		}
		return url ;
	}
</script>

