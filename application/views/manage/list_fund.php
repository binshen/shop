<form id="pagerForm" method="post" action="<?php echo site_url('manage/list_fund')?>">
	<input type="hidden" name="pageNum" value="<?php echo $pageNum;?>" />
	<input type="hidden" name="numPerPage" value="<?php echo $numPerPage;?>" />
	<input type="hidden" name="num" value="<?php echo $num;?>" />
	<input type="hidden" name="openid" value="<?php echo $openid;?>" />
	<input type="hidden" name="orderField" value="<?php echo $this->input->post('orderField');?>" />
	<input type="hidden" name="orderDirection" value="<?php echo $this->input->post('orderDirection');?>" />
</form>

<div class="pageHeader">
	<form onsubmit="return navTabSearch(this);" action="<?php site_url('manage/list_fund')?>" method="post">
		<div class="searchBar">
			<table class="searchContent" id="search_purchase_order">
				<tr>
					<td><label>订单编号：</label><input type="text" size="16" name="num" value="<?php echo $num;?>" /></td>
					<td><label>用户ID：</label><input type="text" size="16" name="openid" value="<?php echo $openid;?>" /></td>
				</tr>
			</table>
			<div class="subBar">
				<ul>
					<li><div class="button"><div class="buttonContent"><button id="clear_search">清除查询</button></div></div></li>
					<li><div class="buttonActive"><div class="buttonContent"><button type="submit">执行查询</button></div></div></li>
				</ul>
			</div>
		</div>
	</form>
</div>

<div class="pageContent">
	<div layoutH="88" id="list_warehouse_in_print">
	<table class="list" width="100%" targetType="navTab" asc="asc" desc="desc">
		<thead>
			<tr>
				<th>用户ID</th>
				<th width="120">来源订单</th>
				<th width="90">来源用户ID</th>
				<th width="120">层级</th>
				<th width="120">金额</th>
				<th width="120">创建时间</th>
			</tr>
		</thead>
		<tbody>
            <?php          
                if (!empty($res_list)):
            	    foreach ($res_list as $row):		               
            ?>		            
            			<tr target="id" rel=<?php echo $row->id; ?>>
            				<td><?php echo $row->openid;?></td>
            				<td><?php echo $row->order_num;?></td>
            				<td><?php echo $row->target_openid;?></td>
            				<td><?php echo $row->lev;?></td>
            				<td><?php echo $row->fund;?></td>
            				<td><?php echo $row->cdate;?></td>
            			</tr>
            <?php 
            		endforeach;
            	endif;
            ?>
		</tbody>
	</table>
	</div>
	<div class="panelBar" >
		<div class="pages">
			<span>显示</span>
			<select name="numPerPage" class="combox" onchange="navTabPageBreak({numPerPage:this.value})">
				<option value="20" <?php echo $this->input->post('numPerPage')==20?'selected':''?>>20</option>
				<option value="50" <?php echo  $this->input->post('numPerPage')==50?'selected':''?>>50</option>
				<option value="100" <?php echo $this->input->post('numPerPage')==100?'selected':''?>>100</option>
				<option value="200" <?php echo $this->input->post('numPerPage')==200?'selected':''?>>200</option>
			</select>
			<span>条，共<?php  echo $countPage;?>条 总计:<font color="red">￥<?php echo $sum_fund;?></font> 已提现:<font color="red">￥<?php echo $tixian;?></font></span>
		</div>		
		<div class="pagination" targetType="navTab" totalCount="<?php echo $countPage;?>" numPerPage="<?php echo $numPerPage;?>" pageNumShown="10" currentPage="<?php echo $pageNum;?>"></div>
	</div>
</div>

<script>
	//清除查询
	$('#clear_search',navTab.getCurrentPanel()).click(function(){
		$(".searchBar",navTab.getCurrentPanel()).find("input").each(function(){
			$(this).val("");
		});
		$(".searchBar",navTab.getCurrentPanel()).find("select option").each(function(index){
			if($(this).val() == "")
			{
				$(this).attr("selected","selected");
			}
		});
	});
</script>