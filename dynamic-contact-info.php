<?php 
/*
Plugin Name:Dynamic Contact Info

Description:This plugin will make your site's contact info dynamic even if your theme does not support dynamic contact info.

Author:Sukhchain Singh

Author URI:http://www.sukhchain.tk

Version:1.8

*/
add_action('admin_menu','con_nav');
function con_nav()
{
	add_menu_page('Dynamic Contact Info','Dynamic Contact Info','manage_options','dynamic-contact-details','con_de_fun',plugins_url().'/dynamic-contact-info/img/menu.png',2000);
	add_submenu_page('dynamic-contact-details','Donate to author','Donate','manage_options','dci-donate','dci_donate_fun');
}
function dci_donate_fun()
{
	echo '<h2>Donate</h2><br /><a href="http://www.sukhchain.tk/donate-online/" target="_blank">Donate Now</a>';
}
add_action('admin_init','DCI_STYLE');
function DCI_STYLE()
{
	wp_register_style('DCI-CSS',plugins_url().'/dynamic-contact-info/css/style.css');
	wp_enqueue_style('DCI-CSS');
}
register_activation_hook(__FILE__,'DCI_Install_Fun');
function DCI_Install_Fun()
{
	add_option('DynamicContactInfoCustomFields','');
	wp_enqueue_script('jquery');
}

function con_de_fun()
{
	echo '<h2>Dynamic Contact Info</h2>';
	if(isset($_GET['msg']) && $_GET['msg']==1)
		echo '<div id="message" class="updated below-h2"><p>Record Updated.</p></div>';
	
	$CustomFlds=get_option('DynamicContactInfoCustomFields');
	if(isset($_GET['del']))
	{
		unset($CustomFlds[$_GET['del']]);
		update_option('DynamicContactInfoCustomFields',$CustomFlds);
		echo '<script>window.location="admin.php?page=dynamic-contact-details&msg=1"</script>';
	}
	$FieldsArr=array('tel'=>'Telephone','email'=>'Email','fax'=>'Fax','mobile'=>'Mobile','addr-1'=>'Address Line 1','addr-2'=>'Address Line 2','country'=>'Country','state'=>'State','city'=>'City','postcode'=>'Postcode','dob'=>'Date Of Birth');
	
	if(!empty($CustomFlds))
		$FieldsArr2=array_merge($FieldsArr,$CustomFlds);
	else
		$FieldsArr2=$FieldsArr;
	asort($FieldsArr2);
	
	if(isset($_GET['edit']))
	{
		$Edt=$_GET['edit'];
		$Opt=get_option('DynamicContactInfo_'.$Edt,true);
		$Opt=($Opt==1) ? '' : $Opt;
		echo '<form method="post"><input type="hidden" name="update_to" value="'.$Edt.'"/><ul style="width:32%;">';
		echo '<li>Update <b>'.$Edt.'</b>&nbsp;<input type="text" name="update" value="'.$Opt.'"/></li>';
		echo '<li><input type="submit" value="Update" class="button button-primary button-large" style="margin-right: 20px; float: right;"/></li></ul></form>';
	}
	elseif(!isset($_GET['edit']))
		require_once 'fields-list.php';
	if(!empty($_POST))
	{
		if(!isset($_POST['update_to']))
		{
			$CustomFlds1=get_option('DynamicContactInfoCustomFields');
			$CustomFlds=array($_POST['fld_shortcode']=>$_POST['fld_name']);
			$SaveIt=$CustomFlds;
			if(is_array($CustomFlds1))
				$SaveIt=array_merge($CustomFlds1,$CustomFlds);
			update_option('DynamicContactInfoCustomFields',$SaveIt);
			update_option('DynamicContactInfo_'.$_POST['fld_shortcode'],$_POST['fld_val']);
		}
		else
		{
			update_option('DynamicContactInfo_'.$_POST['update_to'],$_POST['update']);
		}
		echo '<script>window.location="admin.php?page=dynamic-contact-details&msg=1"</script>';
	}	
}
add_shortcode('DCI','ContactInfo_Fun');
function ContactInfo_Fun($atts)
{
	extract(shortcode_atts(array(
			"field" => '',
		), $atts));
	return get_option('DynamicContactInfo_'.$field,true);
}
?>