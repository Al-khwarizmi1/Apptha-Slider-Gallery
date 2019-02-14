<?php
/*
 ***********************************************************/
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
global $wpdb;

$folder   = dirname(dirname(plugin_basename(__FILE__)));
?>
<script type="text/javascript" src="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder; ?>/js/macGallery.js"></script>
<?php
   //print_r($_REQUEST); exit;
// Album Status Change
if($_REQUEST['albid'] != '')
{
    $mac_albId   = $_REQUEST['albid'];
    $mac_albStat = $_REQUEST['status'];
    if($_REQUEST['status'] == 'ON')
    {
       $alumImg = $wpdb->query("UPDATE " . $wpdb->prefix . "asgallalbum SET asgallAlbum_status='ON' WHERE asgallAlbum_id='$mac_albId'");
       echo "<img src='$site_url/wp-content/plugins/$folder/images/tick.png' style='cursor:pointer' width='16' height='16' onclick=asgallAlbum_status('OFF',$mac_albId)  />";
    }
    else
    {
        $alumImg = $wpdb->query("UPDATE " . $wpdb->prefix . "asgallalbum SET asgallAlbum_status='OFF' WHERE asgallAlbum_id='$mac_albId'");
        echo "<img src='$site_url/wp-content/plugins/$folder/images/publish_x.png' style='cursor:pointer' width='16' height='16' onclick=asgallAlbum_status('ON',$mac_albId)  />";
    }

}
// Photos status change respect to album
else if($_REQUEST['asgallPhoto_id'] != '')
{
    $asgallPhoto_id  = $_REQUEST['asgallPhoto_id'];
    $mac_photoStat = $_REQUEST['status'];
    if($_REQUEST['status'] == 'ON')
    {
      $photoImg = $wpdb->query("UPDATE " . $wpdb->prefix . "asgallphotos SET asgallPhoto_status='ON' WHERE asgallPhoto_id='$asgallPhoto_id'");
      echo "<img src='$site_url/wp-content/plugins/$folder/images/tick.png' style='cursor:pointer' width='16' height='16' onclick=asgallPhoto_status('OFF',$asgallPhoto_id)  />";
    }
    else
    {
        $photoImg = $wpdb->query("UPDATE " . $wpdb->prefix . "asgallphotos SET asgallPhoto_status='OFF' WHERE asgallPhoto_id='$asgallPhoto_id'");
        echo "<img src='$site_url/wp-content/plugins/$folder/images/publish_x.png' style='cursor:pointer' width='16' height='16' onclick=asgallPhoto_status('ON',$asgallPhoto_id)  />";
    }

}
else if($_REQUEST['macDelid'] != '')
{
    $asgallPhoto_id = $_REQUEST['macDelid'];
    $photoImg    = $wpdb->get_var("SELECT asgallPhoto_image FROM " . $wpdb->prefix . "asgallphotos WHERE asgallPhoto_id='$asgallPhoto_id' ");
    $uploadDir = wp_upload_dir();
    $path = $uploadDir['baseurl'];
    $path = "$path/";
                unlink($path . $photoImg);
            $extense = explode('.', $photoImg);
            unlink($path . $asgallPhoto_id . '.' .$extense[1]);
             $deletePhoto = $wpdb->get_results("DELETE FROM " . $wpdb->prefix . "asgallphotos WHERE asgallPhoto_id='$asgallPhoto_id'");
            echo '';

}
//   For photo edit form
else if($_REQUEST['macPhotoname_id'] != '')
{
    $asgallPhoto_id = $_REQUEST['macPhotoname_id'];
    $div = ' <td style="margin:0 10px;border:none"><input type="text" name="macPhoto_name_'.$asgallPhoto_id.'" id="macPhoto_name_'.$asgallPhoto_id.'" ></td>';
    $div .= '<td colspan="2" style="padding-top:10px;text-align:center;border:none"><input type="submit" name="updatePhoto_name" value="Update" onclick="updPhotoname('.$asgallPhoto_id.')";></td>' ;
    echo $div;
}

// Add as album cover from the photos
else if ($_REQUEST['macCovered_id'] != '')
{
$macPhotoid  = $_REQUEST['macCovered_id'];
$albumCover  = $_REQUEST['albumCover'];
$albumId     = $_REQUEST['albumId'];
$flag     = $_REQUEST['featuredCover'];
	//print_r($_REQUEST);


if(isset($flag)){     // FOR FEATURED IMAGE

	 $wpdb->query("UPDATE " . $wpdb->prefix . "asgallphotos SET asgallFeaturedCover = $flag  WHERE asgallPhoto_id='$macPhotoid' and asgallAlbum_id='$albumId'");
	
	// $wpdb->query("UPDATE " . $wpdb->prefix . "asgallphotos SET asgallFeaturedCover = $albumCover WHERE asgallPhoto_id='$macPhotoid' and asgallAlbum_id='$albumId'");
	
	    echo "<img src='$site_url/wp-content/plugins/$folder/images/tick.png' style='cursor:pointer' width='16' height='16' onclick=asgallPhoto_status(0,$macPhotoid)  />";
	
}
if($albumCover == 'ON')
{
     $albumCover    = $wpdb->query("UPDATE " . $wpdb->prefix . "asgallphotos SET asgallAlbum_cover='ON' WHERE asgallPhoto_id='$macPhotoid' and asgallAlbum_id='$albumId'");
     $albumCoveroff = $wpdb->query("UPDATE " . $wpdb->prefix . "asgallphotos SET asgallAlbum_cover='OFF' WHERE asgallPhoto_id !='$macPhotoid' and asgallAlbum_id='$albumId'");
     $photoImg      = $wpdb->get_var("SELECT asgallPhoto_image FROM " . $wpdb->prefix . "asgallphotos WHERE asgallPhoto_id='$macPhotoid' ");
     $addtoAlbum    = $wpdb->query("UPDATE " . $wpdb->prefix . "asgallalbum SET asgallAlbum_image='$photoImg' WHERE asgallAlbum_id='$albumId'");
     echo "<img src='$site_url/wp-content/plugins/$folder/images/tick.png' style='cursor:pointer' width='16' height='16' onclick=macAlbcover_status('OFF',$macPhotoid)  />";
}

}

// update photo name
else if($_REQUEST['macPhoto_name'] != '')
{
     $asgallPhoto_id =$_REQUEST['macPhotos_id'];
     
     $macPhoto_name =  addslashes($_REQUEST['macPhoto_name']);
     $sql = $wpdb->get_results("UPDATE " . $wpdb->prefix . "asgallphotos SET `asgallPhoto_name` = '$macPhoto_name' WHERE `asgallPhoto_id` = $asgallPhoto_id");
    // echo "UPDATE " . $wpdb->prefix . "asgallphotos SET `macPhoto_name` = '$macPhoto_name' WHERE `asgallPhoto_id` = $asgallPhoto_id";
    // exit;
     echo $macPhoto_name;
}

//Album name edit form
else if($_REQUEST['asgallAlbumname_id'] != '')
{
    $asgallAlbum_id = $_REQUEST['asgallAlbumname_id'];
    $fet_res = $wpdb->get_row("SELECT * FROM  " . $wpdb->prefix . "asgallalbum WHERE asgallAlbum_id='$asgallAlbum_id'");
    $div = '<form name="macUptform" method="POST">
    <div style="margin:0;padding:0;border:none"><input type="text"
           name="macedit_name_'.$asgallAlbum_id.'" id="macedit_name_'.$asgallAlbum_id.'" size="15" value="'.$fet_res->asgallAlbum_name.'" ></div>';

    $div .= '<div><textarea name="asgallAlbum_desc_'.$asgallAlbum_id.'"  id="asgallAlbum_desc_'.$asgallAlbum_id.'" rows="6" cols="27" >'.$fet_res->asgallAlbum_description.'</textarea></div>';
//    $div .= '<div style="margin:0;padding:0;border:none"><input type="text"  name="macedit_pageid_'.$asgallAlbum_id.'"   value="'.$fet_res->asgallAlbum_pageid.'" id="macedit_pageid_'.$asgallAlbum_id.'" size="5">';
    $div .='<input type="button"  name="updateMac_name" value="Update" onclick="updAlbname('.$asgallAlbum_id.')" class="button-secondary action";>
             <input type="button" onclick="CancelAlbum('.$asgallAlbum_id.')"   value="Cancel" class="button-secondary action">
            </div>';
    $div .= '</form/>' ;
    echo $div;
}

else if($_REQUEST['macGallery_id'] != '')
{
    $macGallery_id = $_REQUEST['macGallery_id'];
    $fet_res = $wpdb->get_row("SELECT * FROM  " . $wpdb->prefix . "asgallgallery WHERE macGallery_id='$_id'");
    $div = '<form name="macGalform" method="POST">
    <div style="margin:0;padding:0;border:none"><input type="text"
           name="macgaledit_name_'.$macGallery_id.'" id="macgaledit_name_'.$macGallery_id.'" size="15" value="'.$fet_res->macGallery_name.'" ></div>';


//    $div .= '<div style="margin:0;padding:0;border:none"><input type="text"  name="macedit_pageid_'.$asgallAlbum_id.'"   value="'.$fet_res->asgallAlbum_pageid.'" id="macedit_pageid_'.$asgallAlbum_id.'" size="5">';
    $div .='<input type="button"  name="updateGal_name" value="Update" onclick="return updGalname('.$macGallery_id.')" class="button-secondary action";>
             <input type="button" onclick="CancelGalllery('.$macGallery_id.')"   value="Cancel" class="button-secondary action">
            </div>';
    $div .= '</form/>' ;
    echo $div;

     $macGal_name =  addslashes($_REQUEST['macGallery_name']) ;
     $macGallery_id   = $_REQUEST ['macGallery_id'];

      //echo "UPDATE " . $wpdb->prefix . "macgallery SET `macGallery_name` = '" .$macGal_name. "' WHERE `macGallery_id` = ".$macGallery_id;

     $sql = $wpdb->query("UPDATE " . $wpdb->prefix . "asgallgallery SET `macGallery_name` = '" .$macGal_name. "' WHERE `macGallery_id` = ".$macGallery_id);

     echo $macGal_name;
}
//  Album description update
 else if($_REQUEST['macGallery_id'] != '')
{
    $macGal_name =  addslashes($_REQUEST['macGallery_name']) ;

      $macGallery_id   = $_REQUEST['macGallery_id'];
     $sql = $wpdb->query("UPDATE " . $wpdb->prefix . "asgallgallery SET `macGallery_name` = '$macGal_name' WHERE `macGallery_id` = '$macGallery_id'");
     //echo "UPDATE " . $wpdb->prefix . "macgallery SET `macGallery_name` = '$macGal_name' WHERE `macGallery_id` = '$macGallery_id'";
     echo $macGal_name;
}


else if($_REQUEST['asgallAlbum_id'] != '' )
{
      $asgallAlbum_id =   $_GET['asgallAlbum_id'];
      $asgallAlbum_name = $_GET['asgallAlbum_name'];
      $asgallAlbum_desc = $_GET['asgallAlbum_desc'];
      $sql = $wpdb->get_results("UPDATE " . $wpdb->prefix . "asgallalbum SET `asgallAlbum_name`='$asgallAlbum_name',`asgallAlbum_description` ='$asgallAlbum_desc'
    WHERE `asgallAlbum_id` = '$asgallAlbum_id'");

}

//  Album description update
 else
{
     $asgallAlbum_desc =  addslashes($_REQUEST['asgallAlbum_desc']) ;
     $asgallAlbum_id   = $_REQUEST['asgallAlbum_id'];
     $sql = $wpdb->query("UPDATE " . $wpdb->prefix . "asgallalbum SET `asgallAlbum_description` = '$asgallAlbum_desc' WHERE `asgallAlbum_id` = '$asgallAlbum_id'");
     echo $asgallAlbum_desc;
}

?>