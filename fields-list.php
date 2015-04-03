<div class="wrap">
<?php if(isset($_GET['act']) && $_GET['act']=='add'):?>
	<form method="post">
		<ul class="DCIUL">
			<li><label>Field Name</label><input type="text" name="fld_name" /></li>
			<li><label>Field Shortcode</label><input type="text" name="fld_shortcode" /></li>
			<li><label>Field Value</label><input type="text" name="fld_val" /></li>
			<li><input type="submit" value="Save" class="button button-primary button-large" style="margin-right: 20px; float: right;"/></li>
		</ul>
	</form>
<?php else:?>
	<h2>Basic Fields&nbsp;<a href="admin.php?page=dynamic-contact-details&act=add" class="add-new-h2">Add New</a></h2>
	<table class="wp-list-table widefat fixed posts">
		<thead>
			<tr>
				<th width="3%">#</th>
				<th>Field</th>
				<th>Value</th>
				<th>Shortcode</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php	
		$Cnt=0;
		foreach($FieldsArr2 as $k=>$v):?>
		<?php	
			$Opt=get_option('DynamicContactInfo_'.$k,true);
			$Opt=($Opt==1) ? '' : $Opt;?>
			<tr>
				<td><?php echo $Cnt+1;?></td>
				<td><?php echo $v?></td>
				<td><?php echo $Opt?></td>
				<td><code>[DCI <?php echo $k?>]</code></td>
				<td>
					<a href="admin.php?page=dynamic-contact-details&edit=<?php echo $k?>"><img src="<?php echo plugins_url()?>/dynamic-contact-info/img/update.png" alt="Update" title="Update" width="16"/></a>
					<?php if(!in_array($v,$FieldsArr)):?>
						<a href="admin.php?page=dynamic-contact-details&del=<?php echo $k?>"><img src="<?php echo plugins_url()?>/dynamic-contact-info/img/delete.png" alt="Delete" title="Delete" width="16"/></a>
					<?php endif;?>
				</td>
			</tr>
		<?php $Cnt++;
		endforeach;?>		
		</tbody>
	</table>
</div>
<?php endif;?>