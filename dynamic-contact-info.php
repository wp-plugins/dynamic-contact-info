<?php 
/*
Plugin Name:Dynamic Contact Info

Description:This plugin will make your site's contact info dynamic even if your theme does not support dynamic contact info.

Author:Sukhchain Singh

Author URI:http://www.sukhchain.tk


Version:1.1

*/
define('DCINAME','DynamicContactInfo');
add_action('admin_menu','con_nav');
function con_nav()
{
	add_menu_page('Dynamic Contact Info','Dynamic Contact Info','manage_options','dynamic-contact-details','con_de_fun',plugins_url().'/dynamic-contact-info/img/menu.png',2000);
}
function con_de_fun()
{
	
	$FieldsArr=array('tel'=>'Telephone','email'=>'Email','fax'=>'Fax','mobile'=>'Mobile','addr-1'=>'Address Line 1','addr-2'=>'Address Line 2','country'=>'Country','postcode'=>'Postcode');
	echo '<h2>Dynamic Contact Info</h2>';
	if(isset($_GET['msg']))
		echo '<div id="message" class="updated below-h2"><p>Record Updated.</p></div>';
	
	if(isset($_GET['edit']))
	{
		$Edt=$_GET['edit'];
		$Opt=get_option('DynamicContactInfo_'.$Edt,true);
		$Opt=($Opt==1) ? '' : $Opt;
		echo '<form method="post"><input type="hidden" name="update_to" value="'.$Edt.'"/><ul style="width:32%;">';
		echo '<li>Update '.$FieldsArr[$Edt].'&nbsp;<input type="text" name="update" value="'.$Opt.'"/></li>';
		echo '<li><input type="submit" value="Update" class="button button-primary button-large" style="margin-right: 20px; float: right;"/></li></ul></form>';
	}
	elseif(!isset($_GET['edit']))
	{
		echo '<table class="wp-list-table widefat fixed posts">
				<thead>
				<tr>
					<th>Field</th>
					<th>Value</th>
					<th>Shortcode</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>';
		foreach($FieldsArr as $k=>$v)
		{
			$Opt=get_option('DynamicContactInfo_'.$k,true);
			$Opt=($Opt==1) ? '' : $Opt;
			echo '<tr>
					<td>'.$v.'</td>
					<td>'.$Opt.'</td>
					<td><code>[DynamicContactInfo '.$k.']</code></td>
					<td><a href="admin.php?page=dynamic-contact-details&edit='.$k.'">Edit</a></td>
				</tr>';
		}		
		echo '</tbody>
			</table>';
	}
	if(!empty($_POST))
	{
		update_option('DynamicContactInfo_'.$_POST['update_to'],$_POST['update']);
		echo '<script>window.location="admin.php?page=dynamic-contact-details&msg=1"</script>';
	}	
}
add_shortcode('DynamicContactInfo','ContactInfo_Fun');
function ContactInfo_Fun($atts)
{
	return get_option('DynamicContactInfo_'.$atts[0],true);
}
?>