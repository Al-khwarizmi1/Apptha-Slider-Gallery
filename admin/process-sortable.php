<?php
 /***********************************************************/
/**
 * @name          : Mac Doc Photogallery.
 * @version	      : 2.5
 * @package       : apptha
 * @subpackage    : mac-doc-photogallery
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license	      : GNU General Public License version 2 or later; see LICENSE.txt
 * @abstract      : The core file of calling Mac Photo Gallery.
 * @Creation Date : June 20 2011
 * @Modified Date : September 30 2011
 * */

/*
 ***********************************************************/

require_once(dirname(dirname(__FILE__)) . '/asgallDirectory.php');

/* This is where you would inject your sql into the database
   but we're just going to format it and send it back
*/
$macPhoto_id = $_REQUEST['macPhoto_id'];
$totalCount = count($_GET['listItem']);
  
$totalCount--;
foreach ($_GET['listItem'] as $position => $item) :
	$sql[] =$wpdb->query("UPDATE " . $wpdb->prefix . "asgallphotos SET `asgallPhoto_sorting` = '$totalCount'  WHERE `asgallPhoto_id` = $item");
	 
	--$totalCount;
endforeach;
?>