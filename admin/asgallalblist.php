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
//Pagination
                                function listPagesNoTitle($args) { //Pagination
                                    if ($args) {
                                        $args .= '&echo=0';
                                    } else {
                                        $args = 'echo=0';
                                    }
                                    $pages = wp_list_pages($args);
                                    echo $pages;
                                }

                                function findStart($limit) { //Pagination
                                    if (!(isset($_REQUEST['pages'])) || ($_REQUEST['pages'] == "1")) {
                                        $start = 0;
                                        $_GET['pages'] = 1;
                                    } else {
                                        $start = ($_GET['pages'] - 1) * $limit;
                                    }
                                    return $start;
                                }

                                /*
                                 * int findPages (int count, int limit)
                                 * Returns the number of pages needed based on a count and a limit
                                 */

                                function findPages($count, $limit) { //Pagination
                                    $pages = (($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1;
                                    if ($pages == 1) {
                                        $pages = '';
                                    }
                                    return $pages;
                                }

                                /*
                                 * string pageList (int curpage, int pages)
                                 * Returns a list of pages in the format of "Ã‚Â« < [pages] > Ã‚Â»"
                                 * */

                                function pageList($curpage, $pages) {
                                    //Pagination
                                    $page_list = "";
                                    if ($search != '') {

                                        $self = '?page=' . slideAlbum;
                                    } else {
                                        $self = '?page=' . slideAlbum;
                                    }

                                    /* Print the first and previous page links if necessary */
                                    if (($curpage != 1) && ($curpage)) {
                                        $page_list .= "  <a href=\"" . $self . "&pages=1\" title=\"First Page\"><<</a> ";
                                    }

                                    if (($curpage - 1) > 0) {
                                        $page_list .= "<a href=\"" . $self . "&pages=" . ($curpage - 1) . "\" title=\"Previous Page\"><</a> ";
                                    }

                                    /* Print the numeric page list; make the current page unlinked and bold */
                                    for ($i = 1; $i <= $pages; $i++) {
                                        if ($i == $curpage) {
                                            $page_list .= "<b>" . $i . "</b>";
                                        } else {
                                            $page_list .= "<a href=\"" . $self . "&pages=" . $i . "\" title=\"Page " . $i . "\">" . $i . "</a>";
                                        }
                                        $page_list .= " ";
                                    }

                                    /* Print the Next and Last page links if necessary */
                                    if (($curpage + 1) <= $pages) {
                                        $page_list .= "<a href=\"" . $self . "&pages=" . ($curpage + 1) . "\" title=\"Next Page\">></a> ";
                                    }

                                    if (($curpage != $pages) && ($pages != 0)) {
                                        $page_list .= "<a href=\"" . $self . "&pages=" . $pages . "\" title=\"Last Page\">>></a> ";
                                    }
                                    $page_list .= "</td>\n";

                                    return $page_list;
                                }

                                /*
                                 * string nextPrev (int curpage, int pages)
                                 * Returns "Previous | Next" string for individual pagination (it's a word!)
                                 */

                                function nextPrev($curpage, $pages) { //Pagination
                                    $next_prev = "";

                                    if (($curpage - 1) <= 0) {
                                        $next_prev .= "Previous";
                                    } else {
                                        $next_prev .= "<a href=\"" . $_SERVER['PHP_SELF'] . "&pages=" . ($curpage - 1) . "\">Previous</a>";
                                    }

                                    $next_prev .= " | ";

                                    if (($curpage + 1) > $pages) {
                                        $next_prev .= "Next";
                                    } else {
                                        $next_prev .= "<a href=\"" . $_SERVER['PHP_SELF'] . "&pages=" . ($curpage + 1) . "\">Next</a>";
                                    }
                                    return $next_prev;
                                }

                                //End of Pagination
  $folder   = dirname(dirname(plugin_basename(__FILE__)));

$i=0;
$viewSetting = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "asgall_settings_menu");
 $count_result = mysql_query("SELECT * FROM " . $wpdb->prefix . "asgallalbum WHERE is_delete=0");
 //print_r($count_result);exit;
$site_url = get_bloginfo('url');
$limit =20;
$start = findStart($limit);
                                    if ($_REQUEST['pages'] == 'viewAll') {
                                        $w = '';
                                    }
                                    else if(!isset($_REQUEST['pages']))
                                    {
                                     $w= '';
                                    }
                                    else {
                                        $w = "LIMIT " . $start . "," . $limit;
                                    }
			
                                    $count = mysql_num_rows($count_result);
                                    /* Find the number of pages based on $count and $limit */
                                    $pages = findPages($count, $limit);
                                    /* Now we use the LIMIT clause to grab a range of rows */

$res = $wpdb->get_results("SELECT * ,asgallGallery_name  FROM " . $wpdb->prefix . "asgallalbum ," . $wpdb->prefix . "asgallgallery  where ". $wpdb->prefix . "asgallgallery.".asgallGallery_id."=". $wpdb->prefix . "asgallalbum." . asgallGallery_id. " and is_delete=0 ORDER BY asgallAlbum_id DESC" );
 //echo "<pre>"; print_r($res); echo "<pre>";


$album ='';
 $uploadDir = wp_upload_dir();
            $path = $uploadDir['baseurl'].'/apptha-slider-gallery';
?>

<script src="<?php echo $site_url . '/wp-content/plugins/'.$folder.'/js/macGallery.js'; ?>" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder; ?>/js/macGallery.js"></script>
<script type="text/javascript">
// starting the script on page load
dragdr(document).ready(function(){

	imagePreview();
});

 
 </script>
<table cellspacing="0" cellpadding="0" border="1" class="mac_gallery">
<tr>

<th class="checkall"><input type="checkbox" name="checkAll" id="checkAll" class="checkall" onclick="javascript:checkasgall('all_action',this)"></th>
<th class="image">Image</th>
<th class="name">Album Name</th>
<th class="desc">Description</th>
<th class="on">Status</th>
<th class="albumid">Album Id</th>
<!--  <th class="albumid">Gallery Name</th>  -->
<th class="gallery"></th>
<th class="gallery"></th>
</tr>
            
<?php             
foreach($res as $results)
{
	$file_image =  $uploadDir['basedir'] . '/apptha-slider-gallery/' .$results->asgallAlbum_image;
	$site_url = get_bloginfo('url');
	$results->macGallery_id = 1;
	$style = 'style="display:none;"';
   $album .= "<tr>
  <td class='checkall'>";
 
  $album .= "<input type='checkbox' class='checkSing' name='checkList[]' class='others' value='$results->asgallAlbum_id' ></td>";
 	 if(file_exists($file_image) && $results->asgallAlbum_image != '')
         {
        $temp_img   =  explode('_',$results->asgallAlbum_image);
        $get_ext    =  explode('.',$temp_img[1]);
        $get_albimg =  $temp_img[0].'_albumthumb.'.$get_ext[1];
        $album .="<td><a href='javascript:void(0)' id='$path/$get_albimg' class='preview' >
                  <img src='$path/$get_albimg' width='40' height='20' /></a></td>";
         }
         else if(!file_exists($file_image)){
         	$album .="<td><a href='javascript:void(0)' id='$site_url/wp-content/plugins/$folder/uploads/star.jpg' class='preview'>
             <img src='$site_url/wp-content/plugins/$folder/uploads/star.jpg' width='40' height='20' /></a></td>";
         }
 else
         {
           $album .="<td><a href='javascript:void(0)' id='$site_url/wp-content/plugins/$folder/images/default_star.gif' class='preview'>
             <img src='$site_url/wp-content/plugins/$folder/images/default_star.gif' width='40' height='20' /></a></td>";

         }
          $album .="<td class='macName'>
                    <div id='albName_".$results->asgallAlbum_id."'>".$results->asgallAlbum_name."</div>
                    <div class='delView'><a onClick=albumNameform($results->asgallAlbum_id) title='Edit' style='cursor:pointer;'>Quick Edit</a></div></td>";
         $album .="<td style='width:30%'><div id='displayAlbum_".$results->asgallAlbum_id."' style='text-align:justify' >".$results->asgallAlbum_description."</div>";
         $album .="<form name='macUptform' method='POST'><span $style id='showAlbumedit_$results->asgallAlbum_id'>";
                 $album .= '
    <div style="margin:0;padding:0;border:none"><input type="text"
           name="macedit_name_'.$results->asgallAlbum_id.'" id="macedit_name_'.$results->asgallAlbum_id.'" size="15" value="'.$results->asgallAlbum_name.'" ></div>';

    $album .= '<div><textarea name="asgallAlbum_desc_'.$results->asgallAlbum_id.'"  id="asgallAlbum_desc_'.$results->asgallAlbum_id.'" rows="6" cols="27" >'.$results->asgallAlbum_description.'</textarea></div>';
//    $div .= '<div style="margin:0;padding:0;border:none"><input type="text"  name="macedit_pageid_'.$asgallAlbum_id.'"   value="'.$fet_res->asgallAlbum_pageid.'" id="macedit_pageid_'.$asgallAlbum_id.'" size="5">';
    $album .='<input type="button"  name="updateMac_name" value="Update" onclick="updAlbname('.$results->asgallAlbum_id.')" class="button-secondary action";>
             <input type="button" onclick="CancelAlbum('.$results->asgallAlbum_id.')"   value="Cancel" class="button-secondary action">
            </div>';
    
         $album .=" </span></td>";

        if($results->asgallAlbum_status == 'ON')
        {
           $album .= "<td><div name='status_bind' id='status_bind_$results->asgallAlbum_id'  style='text-align:left'><img src='$site_url/wp-content/plugins/$folder/images/tick.png' width='16' height='16' onclick=asgallAlbum_status('OFF',$results->asgallAlbum_id) style='cursor:pointer'  /></div></td>";
        }
        else
        {
           $album .= "<td><div name='status_bind' id='status_bind_$results->asgallAlbum_id'  style='text-align:left'><img src='$site_url/wp-content/plugins/$folder/images/publish_x.png' width='16' height='16' onclick=asgallAlbum_status('ON',$results->asgallAlbum_id) style='cursor:pointer' /></div></td>";
        }
           $album .="<td style='text-align:left'>$results->asgallAlbum_id</td> ";

         //  $album .="<td style='text-align:left'>$results->macGallery_name</td> ";

            $album .="<td><a href='$site_url/wp-admin/admin.php?page=slidePhotos&action=viewPhotos&galid=$results->macGallery_id&albid=$results->asgallAlbum_id'>View Images</a>
         
                     
                    </td>";
           $album .="<td>
           <a href='$site_url/wp-admin/admin.php?page=slidePhotos&galid=$results->macGallery_id&albid=$results->asgallAlbum_id'>Add Images</a>
                     
                    </td></tr>";
         
 $i++;
}
$album .='</table>';
$pagelist = pageList($_REQUEST['pages'], $pages);
if($count > $limit)
{
$album .='<div align="right">'. $pagelist.'<span><a href="'.$site_url.'/wp-admin/upload.php?page=slideAlbum&pages=viewAll">View All</a></span></div>';
}
echo $album;
?>