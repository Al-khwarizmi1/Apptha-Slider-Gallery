<?php
/*
 ***********************************************************/
/**
 * @name          : Apptha Slider Gallery.
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

function asgallGallery_install()
{
  global $wpdb;
    // set tablename settings, albums, photos
    $table_appgallSettings		= $wpdb->prefix . 'asgall_settings_menu';
    $table_appgallAlbum		    = $wpdb->prefix . 'asgallalbum';
    $table_appgallPhotos		= $wpdb->prefix . 'asgallphotos';
    $table_appgallGallery		= $wpdb->prefix . 'asgallgallery';
    
    $sfound = false;
    $afound = false;
    $pfound = false;
    $gfound = false;
    $found = true;
    foreach ($wpdb->get_results("SHOW TABLES;", ARRAY_N) as $row)
    {
        if ($row[0] == $table_appgallSettings) $sfound = true;
        if ($row[0] == $table_appgallAlbum) $afound = true;
        if ($row[0] == $table_appgallPhotos) $pfound = true;
        if ($row[0] == $table_appgallGallery) $gfound = true;
    }

    // add charset & collate like wp core
    $charset_collate = '';

    if ( version_compare(mysql_get_server_info(), '4.1.0', '>=') )
    {
        if ( ! empty($wpdb->charset) )
        $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
        if ( ! empty($wpdb->collate) )
        $charset_collate .= " COLLATE $wpdb->collate";
    }

          if (!$sfound)
            {
               $sql = " CREATE TABLE IF NOT EXISTS ".$table_appgallSettings." (
               		  `sno`  int(2) , 	
					  `asgall-slide-photo-width` int(2) NOT NULL DEFAULT '144',
					  `asgall-slide-photo-height` int(2) NOT NULL DEFAULT '144',
					  `asgall-alb-cols` int(2) NOT NULL DEFAULT '4',
					  `asgall-alb-rows` int(2) NOT NULL DEFAULT '1',
					  `asgall-alb-photo-width` int(2) NOT NULL DEFAULT '144',
					  `asgall-alb-photo-Height` int(2) NOT NULL DEFAULT '144',
					  `asgall-alb-vspace` int(2) NOT NULL DEFAULT '6',
					  `asgall-alb-hspace` int(2) NOT NULL DEFAULT '6',
					  `asgall-general-share-pho` int(2) NOT NULL DEFAULT '1',
					  `asgall-general-fac-com` int(2) NOT NULL DEFAULT '1',
					  `asgall-general-download` int(2) NOT NULL DEFAULT '1',
					  `asgall_facebook_api` varchar(29) NOT NULL,
					  `asgall-photo-tumb-w` int(2) NOT NULL DEFAULT '144',
					  `asgall-photo-tumb-h` int(2) NOT NULL DEFAULT '144',
					  `asgall-photo-gene-w` int(2) NOT NULL DEFAULT '800',
					  `asgall-photo-gene-h` int(2) NOT NULL DEFAULT '450',
					  `asgall-slider` int(2) NOT NULL DEFAULT '0',
  					  `asgall-slider-type` int(2) NOT NULL DEFAULT '0'
					) ENGINE=InnoDB DEFAULT CHARSET=latin1 ";
			
			    $insert_sql =  " INSERT INTO ".$table_appgallSettings." (`sno` ,`asgall-slide-photo-width`, `asgall-slide-photo-height`,  `asgall-alb-cols`, `asgall-alb-rows`, `asgall-alb-photo-width`, `asgall-alb-photo-Height`, `asgall-alb-vspace`, `asgall-alb-hspace`, `asgall-general-share-pho`, `asgall-general-fac-com`, `asgall-general-download`, `asgall_facebook_api`, `asgall-photo-tumb-w`, `asgall-photo-tumb-h`, `asgall-photo-gene-w`, `asgall-photo-gene-h`, `asgall-slider`, `asgall-slider-type`)
			                     VALUES (1,600, 400, 4, 1, 144, 144, 6, 6, 1, 1, 1, '', 144, 144, 600, 400, 0, 0)";		    
          		$res = $wpdb->get_results($sql);
          		$res = $wpdb->get_results($insert_sql);
          	}
            
          if (!$afound)
            {
		         $sql = "CREATE TABLE ".$table_appgallAlbum."  (
		          `asgallAlbum_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		          `asgallAlbum_name` varchar(100) NOT NULL,
		          `asgallAlbum_description` text NOT NULL,
		          `asgallAlbum_image` varchar(50) NOT NULL,
		          `asgallAlbum_status` varchar(100) NOT NULL,
		          `asgallAlbum_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		          `asgallGallery_id` int(11),
		          `is_delete` int(2) NOT NULL DEFAULT '0'
		          ) $charset_collate;";
     	   	 $res = $wpdb->get_results($sql);
           }
            

             if (!$gfound)
            {
		         $sql = "CREATE TABLE ".$table_appgallGallery."  (
		          `asgallGallery_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		          `asgallGallery_name` varchar(100) NOT NULL,
		          `asgallGallery_status` varchar(100)
		            ) $charset_collate;";
     	    $res = $wpdb->get_results($sql);
            }

            if (!$pfound)
            {
              $sql =  " CREATE TABLE IF NOT EXISTS ".$table_appgallPhotos." (
			  `asgallPhoto_id` int(5) NOT NULL AUTO_INCREMENT,
			  `asgallAlbum_id` int(5) NOT NULL,
			  `asgallAlbum_cover` varchar(10) NOT NULL,
			  `asgallFeaturedCover` int(2) NOT NULL DEFAULT '0',
			  `asgallPhoto_tname` varchar(200) ,
			  `asgallPhoto_name` varchar(200) NOT NULL,
			  `asgallPhoto_desc` text NOT NULL,
			  `asgallPhoto_image` varchar(50) NOT NULL,
			  `asgallPhoto_status` varchar(10) NOT NULL,
			  `asgallPhoto_sorting` int(4) NOT NULL,
			  `asgallPhoto_hitcount` double NOT NULL,
			  `asgallPhoto_date` date NOT NULL,
		      `is_active` int(2) NOT NULL DEFAULT '1',
			  `is_delete` int(2) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`asgallPhoto_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1  " ;
		      $res = $wpdb->get_results($sql);
            }
             $site_url = get_option('siteurl');  //Getting the site domain path
            
 $page_found  = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."posts where post_content='[asgall]'");
 if (empty($page_found)) {
$mac_gallery_page    =  "INSERT INTO ".$wpdb->prefix."posts(`post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`)
        VALUES
                    (1, NOW(), NOW(), '[asgall]', 'Photo Gallery', '', 'publish', 'closed', 'open', '', 'photo-gallery', '', '', 'NOW()','NOW()', '','', '$site_url/?page_id=',0, 'page', '', 0)";

		$res_macpage       =  $wpdb->get_results($mac_gallery_page );
		$res_macpage_id    =  $wpdb->get_var("select ID from ".$wpdb->prefix."posts ORDER BY ID DESC LIMIT 0,1");
		$upd_macPage       =  "UPDATE ".$wpdb->prefix."posts SET post_parent='$videoId',guid='$site_url/?page_id=$res_macpage_id' WHERE ID='$res_macpage_id'";
		$rst_updated       =  $wpdb->get_results($upd_macPage);
		 } 
           // (36, 1, '2011-11-09 12:09:50', '2011-11-09 12:09:50', '[asgall type=popular]\r\nAlbums :\r\n[asgall]', 'Banner Slider', '', 'publish', 'open', 'open', '', 'banner-slider', '', '', '2011-11-11 11:32:17', '2011-11-11 11:32:17', '', 0, 'http://192.168.1.25/wp_dev/slider_gallery/?page_id=36', 0, 'page', '', 0),
		 
}
function create_asgall_folder()
{
      $structure = dirname(dirname(dirname(__FILE__))).'/uploads/apptha-slider-gallery';

    if (is_dir($structure))
    {

    }
    else
    {
        mkdir($structure , 0777);
    }
}
?>