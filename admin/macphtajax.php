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

$maceditId = $_REQUEST['macEdit'];
$site_url = get_bloginfo('url');
$uploadDir = wp_upload_dir();
$path = $uploadDir['basedir'].'/apptha-slider-gallery';
?>
<?php
 if($_REQUEST['macdeleteId'] != '')
 {
    $asgallPhoto_id = $_REQUEST['macdeleteId'];
    //$photoImg    = $wpdb->get_var("SELECT asgallPhoto_image FROM " . $wpdb->prefix . "asgallphotos WHERE asgallPhoto_id='$asgallPhoto_id' ");
    $deletePhoto  = $wpdb->get_results("UPDATE " . $wpdb->prefix . "asgallphotos  SET `is_delete` = 1 WHERE asgallPhoto_id='$asgallPhoto_id'");
    $photoAlbid    = $wpdb->get_var("SELECT  asgallAlbum_id FROM " . $wpdb->prefix . "asgallphotos WHERE asgallPhoto_id='$asgallPhoto_id' ");
    $total1 = $wpdb->get_results("SELECT asgallPhoto_id FROM  " . $wpdb->prefix . "asgallphotos   WHERE asgallAlbum_id = $photoAlbid AND  is_delete = 0  ",ARRAY_A);
									
								$stop =  count($total1 ); 
								
								for($i = 0 ; $i< $stop ; $i++ )
								{
									 $id =	$total1[$i]['asgallPhoto_id'];
								  $sql = "UPDATE " . $wpdb->prefix . "asgallphotos  SET  asgallPhoto_sorting =   $i  WHERE asgallPhoto_id = $id"  ;
								    
									$wpdb->query($sql);
									
								}
    /*$total = $photoImg->total;
    $albid = $photoImg->asgallAlbum_id;
    for($i=0;$i<=$total;$i++)
    {
    	$deletePhoto  = $wpdb->get_results("UPDATE " . $wpdb->prefix . "asgallphotos  SET `asgallPhoto_sorting` = $total WHERE asgallAlbum_id='$albid' and `is_delete`=0");
    }*/
  
}
  else if(($_REQUEST['asgallPhoto_desc']) != '')
 {
     $asgallPhoto_desc = $_REQUEST['asgallPhoto_desc'] ;
     $asgallPhoto_id   = $_REQUEST['asgallPhoto_id'];
     $sql = $wpdb->query("UPDATE " . $wpdb->prefix . "asgallphotos SET `asgallPhoto_desc` = '$asgallPhoto_desc' WHERE `asgallPhoto_id` = '$asgallPhoto_id'");
 echo $asgallPhoto_desc;
 }
  else if($_REQUEST['macdelAlbum'] != '')
 {
        $asgallAlbum_id = $_REQUEST['macdelAlbum'];
        $alumImg = $wpdb->get_var("SELECT asgallAlbum_image FROM " . $wpdb->prefix . "asgallAlbum WHERE asgallAlbum_id='$asgallAlbum_id' ");
        $delete = $wpdb->query("DELETE FROM " . $wpdb->prefix . "asgallAlbum WHERE asgallAlbum_id='$asgallAlbum_id'");
        $path1 = "$path/";
        unlink($path1.$alumImg);
        $extense = explode('.', $alumImg);
        unlink($path1.$asgallAlbum_id.'alb.'.$extense[1]);
        //Photos respect to album deleted
        $photos  =$wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "asgallphotos WHERE asgallAlbum_id='$asgallAlbum_id' ");

        foreach ($photos as $albPhotos)
        {

        $asgallPhoto_id = $albPhotos->asgallPhoto_id;
        $photoImg    = $wpdb->get_var("SELECT asgallPhoto_image FROM " . $wpdb->prefix . "asgallphotos WHERE asgallPhoto_id='$asgallPhoto_id' ");
        $deletePhoto  = $wpdb->get_results("DELETE FROM " . $wpdb->prefix . "asgallphotos WHERE asgallPhoto_id='$asgallPhoto_id'");
        $path1 = "$path/";
            unlink($path1 . $photoImg);
            $extense = explode('.', $photoImg);
            unlink($path1 . $asgallPhoto_id . '.' . $extense[1]);
        }
 }
  else if($_REQUEST['macedit_phtid'] != '')
 {
   	$macedit_name = addslashes($_REQUEST['macedit_name']);
           $macedit_desc = addslashes($_REQUEST['macedit_desc']);
      $macedit_id   = $_REQUEST['macedit_phtid'];
     ?>
    
     <?php 
      $sql = $wpdb->get_results("UPDATE " . $wpdb->prefix . "asgallphotos SET `asgallPhoto_name` = '$macedit_name', `asgallPhoto_desc` = '$macedit_desc' WHERE `asgallPhoto_id` = '$macedit_id'");
      
      
      
      
      echo "success";
 }
?>