





<style type="text/css">
	.file-box{ position:relative;width:340px}
	.btn{ background-color:#FFF; border:1px solid #CDCDCD;height:21px; width:70px;}
	.file{ position:absolute; top:0; right:80px; height:24px; filter:alpha(opacity:0);opacity: 0;width:300px }
</style>
<div class="pageContent">
	<form method="post" enctype="multipart/form-data" action="<?php echo site_url('manage/save_withdraw');?>" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone);">
		<div class="pageFormContent" layoutH="55">
			<fieldset style="width: 95%">
				<dl>
					<dt>电话：</dt>
					<dd>
						<?php echo $phone;?>
						<input type="hidden" name="id" value="<?php echo $id?>">
					</dd>
				</dl>

				<dl>
					<dt>金额：</dt>
					<dd>
						<?php echo $fund;?>
					</dd>
				</dl>

				<dl>
					<dt>创建时间：</dt>
					<dd>
						<?php echo $cdate;?>
					</dd>
				</dl>

				<dl>
					<dt>状态：</dt>
					<dd>
						<select class="combox" name="type">
							<option value="2" <?php if($type == 2) echo 'selected="selected"';?>>申请中</option>
							<option value="3" <?php if($type == 3) echo 'selected="selected"';?>>已完成</option>
						</select>
					</dd>
				</dl>

				<dl class="nowrap">
					<dt>备注：</dt>
					<dd>
						<textarea name="remark"><?php echo $remark?></textarea>
					</dd>
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


