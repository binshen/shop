
<div class="pageContent">
    <form enctype="multipart/form-data" class="pageForm required-validate" onsubmit="return iframeCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="55">
        	<fieldset style="width: 95%">
        	    <dl>
        			<dt>用户名称：</dt>
        			<dd>
						<input type="hidden" name="id" value="<?php if(!empty($id)) echo $id;?>">
						<?php echo $head->name;?>
        			</dd>
        		</dl>

				<dl>
					<dt>电话：</dt>
					<dd>
						<?php echo $head->phone;?>
					</dd>
				</dl>

				<dl>
					<dt>性别：</dt>
					<dd>
						<?php
						if($head->sex == 1) echo '男';
						if($head->sex == 2) echo '女';
						?>
					</dd>
				</dl>

				<dl>
					<dt>邮箱：</dt>
					<dd>
						<?php echo $head->mail;?>
					</dd>
				</dl>



        	</fieldset>



	</form>
</div>
<script>
	var total = 0
	$('.xiaoji').each(function(){
		total += parseInt($(this).html());
	})
	$("#total").html(total)
	$(".fahuo",navTab.getCurrentPanel())
		.button()
		.click(function( event ) {
			event.preventDefault();
		});
</script>


