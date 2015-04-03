<h3>Basic Fields</h3>
<table class="wp-list-table widefat fixed posts">
	<thead>
		<tr>
			<th>Field</th>
			<th>Value</th>
			<th>Shortcode</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php	foreach($FieldsArr as $k=>$v):?>
	<?php	$Opt=get_option('DynamicContactInfo_'.$k,true);
			$Opt=($Opt==1) ? '' : $Opt;?>
			<tr>
				<td><?php echo $v?></td>
				<td><?php echo $Opt?></td>
				<td><code>[DynamicContactInfo <?php echo $k?>]</code></td>
				<td><a href="admin.php?page=dynamic-contact-details&edit=<?php echo $k?>"><img src="<?php echo plugins_url()?>/dynamic-contact-info/img/update.png" alt="Update" title="Update"/></a></td>
			</tr>
	<?php endforeach;?>		
	</tbody>
</table>