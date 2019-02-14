<?php

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

class appslider_gallery {

	function asgalEffectgallery($arguments= array())
	{
	    global $wpdb;
	    static $photoView = 0;
	    static $k = 0;
	    static $m = 0;    
	         // Assign to avoid duplication
	    $div            =  ''; // Assign the return div
	    $asgall_albumid = '';  // Assign to check album from post/gallery
	   
        $site_url       = get_bloginfo('url');
        $folder         = dirname(plugin_basename(__FILE__));
        $uploadDir      = wp_upload_dir();
        $path           = $uploadDir['baseurl'] . '/apptha-slider-gallery';
        $asgallSettings = $wpdb->get_results("SELECT * FROM ". $wpdb->prefix ."asgall_settings_menu", ARRAY_N); // Full settings get form the admin
        $rightArrow     =  dirname($uploadDir['baseurl']).'/plugins/apptha-slider-gallery/images/next-horizontal.png';
        $leftArrow      =  dirname($uploadDir['baseurl']).'/plugins/apptha-slider-gallery/images/prev-horizontal.png';

        $pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
				if ($_SERVER["SERVER_PORT"] != "80")
				{
				    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
				}
				else
				{
				    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
				}

		$table1 = $wpdb->prefix ."asgallphotos";
        $table2 = $wpdb->prefix ."asgallalbum";
	    if ($_REQUEST['albid'] != '') {
            $asgall_albumid = $_REQUEST['albid'];        //If  request the album from the gallery display page
        }
         if ($arguments['albid'] != '') {
            $asgall_albumid = $arguments['albid'];     //If  request is from post/page
        }
       ?>
       <link rel="stylesheet" type="text/css" media="all" href="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder; ?>/css/frontasgall.css" />
           <?php
       if($arguments['type'] != '')
       {
       	switch ($arguments['type'])
         {
			case popular:
			  $sliderPhotos = $wpdb->get_results("SELECT  asgallPhoto_id, asgallPhoto_desc, asgallPhoto_name ,asgallPhoto_image  FROM " . $wpdb->prefix . "asgallphotos  WHERE  is_delete =0 and asgallPhoto_status = 'ON' ORDER BY asgallPhoto_hitcount DESC" ); // Getting album photos
			  break;
			case recent:
			   $sliderPhotos = $wpdb->get_results("SELECT  asgallPhoto_id,  asgallPhoto_desc, asgallPhoto_name ,asgallPhoto_image  FROM " . $wpdb->prefix . "asgallphotos  WHERE  is_delete =0 and asgallPhoto_status = 'ON' ORDER BY asgallPhoto_date DESC" ); // Getting album photos

			  break;
			case featured:
			  $sliderPhotos = $wpdb->get_results("SELECT  asgallPhoto_id,  asgallPhoto_desc, asgallPhoto_name ,asgallPhoto_image  FROM " . $wpdb->prefix . "asgallphotos  WHERE  is_delete =0 and asgallPhoto_status = 'ON' and asgallFeaturedCover = 1" ); // Getting album photos

			  break;
			default:

         }
         ?>

 
<?php
 $div .='<style>
   .ad-gallery .ad-image-wrapper {

   height:'.$asgallSettings[0][2].'px;
   }

   </style>';
 if(count($sliderPhotos) == 0)
{
	$div .= 'No images for the slider';
}
else 
{
 $div .='<div id="gallery" class="ad-gallery">
<div class="ad-image-wrapper">
 </div>
<div class="ad-controls">
      </div>';
     $div .=' <div class="ad-nav">
        <div class="ad-thumbs">
          <ul class="ad-thumb-list">';
foreach ($sliderPhotos as $values) {
          	$extens     = explode('.',$values->asgallPhoto_image);
          	$thumbimg   = $values->asgallPhoto_id.'_sliderthumb.'.$extens[1];
          	$photoName  = $values->asgallPhoto_name;
          	$photoDesc  = $values->asgallPhoto_desc;
                $file_thumb = $uploadDir['basedir'] . '/apptha-slider-gallery/'  . $thumbimg;
                $file_hover = $uploadDir['basedir'] . '/apptha-slider-gallery/' . $values->asgallPhoto_image;

                                   if (file_exists($file_hover))
                                    {
                                      $file_hover = $path.'/'.$values->asgallPhoto_image;
                                      
                                    }
                                    else
                                    {
                                         $file_hover = $site_url . '/wp-content/plugins/' . dirname(plugin_basename(__FILE__)) . '/uploads/no-photo.png';
                                    }
                                   if (file_exists($file_thumb))
                                    {
                                       $file_thumb = $path . '/' . $thumbimg;
                                      
                                    }
                                    else
                                    {
                                         $file_thumb = $site_url . '/wp-content/plugins/' . dirname(plugin_basename(__FILE__)) . '/uploads/no-photo.png';
                                    }
                                    
              $div .='<li>
              <a href="'.$file_hover.'">
                <img src="'.$file_thumb.'" title="'.$photoName.'"  class="asgall_slidethumb">
              </a></li>';
            
            }

           $div .='</ul>
        </div>
      </div>
    </div>';
           } // if else close
     } // Slider else ends


        elseif( isset( $_REQUEST['pid'] ) && ($k == 0) && !$photoView){
// **********************************    SHOW SINGLE PHOTO  ***************************************************************
         $photoView = 1;
	      $goback    = $pageURL;
          $goback    = explode('&pid', $goback);
          $url       = $goback[0]."&pid=";
          
                $psno = $limit = $photoId =(int)$_GET['pid'];

		       $albId = $_REQUEST['albid'];
		       $photosno = (int)$_REQUEST['photonumberis'];
		     
       $limit--;
 	  $psql = "SELECT * FROM " . $wpdb->prefix . "asgallphotos  WHERE  is_delete =0 and asgallPhoto_status = 'ON'
	                   AND  asgallAlbum_id = $albId AND  asgallPhoto_sorting = $limit LIMIT  1";
	
	
	 	   $picaAlbumPhotosList = $wpdb->get_results($psql); // Getting album photos
	       $numOffetched = count($picaAlbumPhotosList);

	if($numOffetched){
		  $picaAlbName = $wpdb->get_results(  "SELECT count(*)  as total  , asgallAlbum_name  FROM $table1 as p  , $table2 as a  WHERE p.`asgallAlbum_id` = $albId and a.`asgallAlbum_id` = $albId  AND p.is_delete = 0"); 
	      $photoflag = 0;
	       $total = $picaAlbName[0]->total;
	       $albname  = $picaAlbName[0]->asgallAlbum_name ;

	        $url = $goback[0].'&pid=';
	        
	  		if($photoId <= 1 )
	  		{
	  			$leftArrowId = 0;
	  		}
	  		else{
	  			$leftArrowId = $photoId - 1;
	  		}
	  		if($total <= $photoId )
	  		{
	  			$rightArrowId = 0;
	  		}
	  		else{
	  			$rightArrowId = $photoId + 1;
	  		}

	  		 $imgId  =  $picaAlbumPhotosList[0]->asgallPhoto_id ;
             $photoName =  $picaAlbumPhotosList[0]->asgallPhoto_name;

            // $ldescr =  $picaAlbumPhotosList[0]->macPhoto_desc ;
             $originalPhotoName = $picaAlbumPhotosList[0]->asgallPhoto_image;
			 $extension = explode('.', $originalPhotoName);
	      	 $originalPhotoName = $imgId.'_singlethumb.'.$extension[1];
	      	 $get_count   = $wpdb->get_var("SELECT asgallPhoto_hitcount FROM " . $wpdb->prefix . "asgallphotos WHERE asgallPhoto_id='$imgId' ");
             $upd_count   = $get_count+1;  
             $sql = $wpdb->query("UPDATE " . $wpdb->prefix . "asgallphotos SET `asgallPhoto_hitcount` = '$upd_count' WHERE `asgallPhoto_id` = '$imgId'");
	         $descr = $originalPhotoName;
			 $phtid = $imgId ;
			  $asgallPhoto_desc = $picaAlbumPhotosList[0]->asgallPhoto_desc;
		      $extension = explode('.', $picaAlbumPhotosList[0]->asgallPhoto_image);
              $imgPath   = $picaAlbumPhotosList[0]->asgallPhoto_id."_singlethumb.".$extension[1];
              $photourl  = $site_url.'/wp-content/uploads/apptha-slider-gallery/'.$imgPath;

?>
		  <script type="text/javascript">
			function showsliding(url ,photonum ,photoid , flag){
            photoid = parseInt(photoid);
	    	photonum = parseInt(photonum);
	    //	alert('photo id '+photoid+'  ---- ph noumb'+photonum);
	        if(flag == 'left'){
	       
	    	photonum = (photonum-1)+'&redir=#showSinglephoto';
	        }

	        if(flag == 'right'){
	        	
	        	photonum = (photonum+1)+'&redir=#showSinglephoto';

	        }
            //asgallHitcount(photoid);
	    	document.getElementById('photonumberis').value = photonum ;
			document.submitalbum.action =url+photonum;
			document.forms["submitalbum"].submit();

		}
		function gotoalbpage(url)
		{
			window.location = url;
		}

</script>
	     <form name="submitalbum" action="" method="post" >
		  <input type="hidden" value="" id="photonumberis" name="photonumberis" />
	      </form> 
<!--  TITLE AND PHOTO COUNT -->
		
		
<!--  FULL SCREEN ZOOM EFFECT -->
        <?php
        $div .='<div id="showSinglephoto"><div  class="asgall_phtcount">';
		$div .='<a href ="'.$goback[0].'">'.$albname.'</a> > '.$photoName . ' > Photos '.$photosno. ' of ' .$total.'</div>';
		
		$div .='<div class="get-border clearfix"><div style="float:left;padding-right:5px;padding-bottom:2px;"><div class="asgallProperty">';
		$div .='<img src="'.$site_url.'/wp-content/plugins/'.$folder.'/images/fullscreen.png">';
		$div .="<span><a href='$photourl' id='go'>Full Screen</a></span></div></div>";
	  	$div .='<div id="iviewer">
	        <div class="loader"></div>';

	       $div .='<div class="viewer"></div>';
	        $div .='<ul class="controls">
	            <li class="close"></li>
	            <li class="zoomin"></li>
	            <li class="zoomout"></li>
	        </ul>
	    </div> <div class="separator">&nbsp;</div>';
	 	?>
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder; ?>/zoominout/style.css" />
<!--  ENDS FULL SCREEN ZOOM EFFECT -->
		<?php
		$fbapi  = trim($asgallSettings[0][12]); // FB APIid;
		$ldescr = $picaAlbumPhotosList[0]->asgallPhoto_desc ;
		$p_link = $photourl;
		$fbUrl = 'http://www.facebook.com/dialog/feed?app_id='.$fbapi.'&description='.$ldescr.'&picture='.$p_link.'&link='.urlencode($pageURL).'&name='.$descr.'&message=Comments&redirect_uri='.urlencode($pageURL);

		$div .=  '<script type="text/javascript" src="'.$site_url.'/wp-content/plugins/'.$folder.'/zoominout/js/jquery.js"></script>';
		$div .=  '<script type="text/javascript" src="'.$site_url.'/wp-content/plugins/'.$folder.'/zoominout/js/jqueryui.js"></script>';
		$div .=  '<script type="text/javascript" src="'.$site_url.'/wp-content/plugins/'. $folder.'/zoominout/js/jquery.iviewer.js"></script>';
		$div .=  '<script type="text/javascript" src="'.$site_url.'/wp-content/plugins/'.$folder.'/zoominout/js/main.js"></script>';
	// SHARE AND DOWNLOAD LINK //
		 $downloadImg = $site_url.'/wp-content/plugins/'.$folder.'/asgallDownload.php?imgname='.$imgPath;
		 if($asgallSettings[0][11] == 1) {

		$div .='<div style="float:left;padding-right:5px"><div class="asgallProperty">';
		$div .='<img src="'.$site_url.'/wp-content/plugins/'.$folder.'/images/download.png">';
		$div .='<span><a href = "'.$downloadImg.'">Download </a></span></div></div><div class="separator">&nbsp;</div>';
		 } if($asgallSettings[0][9] == 1) {

		$div .='<div style="float:left;padding-right:5px;"><div class="asgallProperty">';
		$div .='<img src="'.$site_url.'/wp-content/plugins/'.$folder.'/images/share.png">';
		$div .='<span><a class="links" title="Facebook Share" href="'.$fbUrl.'" target="_blank" > Share</a><span></div></div><div class="separator">&nbsp;</div>';
		 }
		 $div .='<div style="float:right;padding-right:5px;font-size: 12px;">Views : '. $get_count.'</div>';
$div .= '</div>';

// ENDS SHARE AND DOWNLOAD LINK
		$div .='<div class="asgallClear"></div>';
		//$div .='<div class="asgallRight">'.$albname.' > '.$photoName.'</div>';
		
		$div .='<table class="photoTable"><tr>';

		$div .="<td class='asgallArrow' align='center' width='45'>";
		 if($leftArrowId){  // show left arrow
		 $div .="<img src='$leftArrow' onclick=showsliding('$url','$photosno','$leftArrowId','left')>";
		 }//if end
		$div .='</td>';
	
   		 $div .="<td class='asgallArrow' id='asphotoSize' align='center'  style='height:400px;'>";
   		  $div .='<img src='.$path."/". $originalPhotoName.' alt="'.$photoName.'"  />';
		// $div .='<img src='.$path."/". $picaAlbumPhotosList[0]->asgallPhoto_tname.' alt="'.$photoName.'" width="100%"  />';
	   	 $div .="</td>";
	
		$div .="<td  class='asgallArrow' align='center' width='45'>";
		if($rightArrowId){ // show right arrow
		 $div .="<img src='$rightArrow' onclick=showsliding('$url','$photosno','$rightArrowId','right')>";
		     } //if for photosno right arrow
	    $div .="</td>";


		 $div .='<div class="asgallClear"></div>';
		// $div .= '</tr><tr><td colspan="3" align="center" class="asgallArrow"><div class="asgallPname">Views : '. $get_count.'</div></td></tr>';
		// $div .= '</tr><tr><td colspan="3" align="center" class="asgallArrow"><div class="asgallPname">'. $photoName.'</div></td></tr>';
		// $div .= '</tr><tr><td colspan="3" align="center" class="asgallArrow"><div class="clearfix "style="width:99%;padding:0px 3px;background:whiteSmoke;"><div class="asgallPname" style="text-align:right;float:right;padding:0 5px 0 0px">Views : '. $get_count.'</div><div class="asgallPname1" style="text-align:left;float:left;padding:0 0 0 5px">'. $photoName.'</div></div></td>';
		if($asgallPhoto_desc != '')
		{
        $div .= '<tr><td colspan="3" align="center" class="asgallArrow"><div class="asgallDesc">'. $asgallPhoto_desc.'</div></td></tr>';
		}
// FACEBOOK COMMENTS
	    // $div .='<div id="fb-root"></div>
//<html xmlns:fb="http://ogp.me/ns/fb#">';
/*$div .='<div id="fb-root"></div>';
	    $div .='<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>';

	 	 if($asgallSettings[0][10] == 1) {
	 	 	$div .= '<tr><td colspan="3" align="left" class="asgallArrow"><h1 class="asgallheading">Comments</h1></td></tr>';
	  	 $div .='<tr><td colspan="3" align="left" class="asgallArrow">
                     <fb:comments  numposts="10" width="629" xid="photo'.'.'.$picaPhtid.'"
                     href="'.$pageURL.'" title="'.$photoName.'" media = "{src = "http://iseofirm.net/ptest/wordpress/env6/wordpress/wp-content/uploads/apptha-slider-gallery/25_photothumb.JPG"}">
                     </fb:comments>';
                   // $div .='<fb:comments href="'.$pageURL.'" num_posts="2" width="500" xid="photo'.'.'.$picaPhtid.'"></fb:comments>';
	  	  $div .= '</td></tr>';
	 } // Facebook comments
	 */
      
         
	 $div .= '</tr></table></div>';
	}//if($imgId) end hear
	else{

		echo "<script> gotoalbpage('$goback[0]'); </script>" ;
	}

 } // if is end hear
 // ********************************** ENDING SHOW SINGLE PHOTO  ***************************************************************

// ********************************** SHOW PHOTOS IN SELECTED ALBUM  ***************************************************************

	 elseif($asgall_albumid != '' && !($_REQUEST['pid'])){

	 	  $getAlbumid = $asgall_albumid;
 		//  $j=0;
 		  $albumnDetail = $wpdb->get_row("SELECT asgallAlbum_name,asgallAlbum_status FROM " . $wpdb->prefix . "asgallalbum WHERE asgallAlbum_id='$getAlbumid' AND is_delete=0 ");
		  $asgallPhotos = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "asgallphotos WHERE asgallAlbum_id='$getAlbumid' AND asgallPhoto_status='ON' AND is_delete=0 ORDER BY asgallPhoto_sorting ");
          $div .= '<style type="text/css">
           .asgallPhoto_spacing {margin-right:'.$asgallSettings[0][8].'px;margin-bottom: '.$asgallSettings[0][7].'px;float:left;position:relative;width:144px !important;} </style>';
          ?>
         <script type="text/javascript">
			function showsinglephotopage<?php echo $k;?>(url , phid , photonum, albid, pageid)
			{
			  var getnum = <?php echo $k;?>;

                          

	          document.getElementById('photonumberis'+getnum).value = photonum ;
	          //alert(document.getElementById('photonumberis1').value);
           
                      
                  	<?php 
               				global $wp_rewrite;
               		
               				 if($wp_rewrite->using_permalinks() && $_GET['albid'] == ''){ ?>
               				   	
               				 url = url+'?albid='+albid+'&pid='+photonum;
               				 <?php   }    	
		
	                 else if($_GET['albid'] == '')  {  	?>
	                 url = url+'&albid='+albid+'&pid='+photonum;
                       <?php  } else {   			?>
                       url = url+'&pid='+photonum;
                <?php  } ?>
              
              //asgallHitcount(phid);
	          document.submitalbum<?php echo $k;?>.action =url;

	          document.forms["submitalbum<?php echo $k;?>"].submit();

			}
			function showalbumname(myid){
				document.getElementById(myid).style.display = 'block';
        	}
	        function dontshowalbumname(myid){
				document.getElementById(myid).style.display = 'none';
	        }
 		 </script>
   		<form name="submitalbum<?php echo $k;?>" action="" method="post" >
		  <input type="hidden" value="" id="photonumberis<?php echo $k;?>" name="photonumberis" />
		</form>
          <?php
          if($albumnDetail->asgallAlbum_status == 'OFF')
          {

          	  $div .= '<div> Album does not exist/enable!!!</div>';
          }
	      else if(count($asgallPhotos) == 0)
         {
         	$div .= '<div>Images are not exist/enabled</div>';
         }
          else
          {
         $div .= '<div><h3 class="asgallheading">'.$albumnDetail->asgallAlbum_name.' :</h3></div>';
     
                            $pageURL = $pageURL;
                      
         foreach ($asgallPhotos as $renderPhotos)
	        {
	        	$photoId    = explode('_',$renderPhotos->asgallPhoto_image);
	        	$extens     = explode('.',$photoId[1]);
	        	$phtImage   = $photoId[0].'_photothumb.'.$extens[1];
	        	$file_image = $uploadDir['basedir'] . '/apptha-slider-gallery/' . $phtImage;
	        	$asgallPhoto_id = $renderPhotos->asgallPhoto_id;
	        	$photoName = $renderPhotos->asgallPhoto_name;
	        	$albid     = $renderPhotos->asgallAlbum_id;
	        	$asgallPhoto_sorting   = $renderPhotos->asgallPhoto_sorting+1;
	        	$getpageId = $_REQUEST['page_id'];
	        	$twidth = $asgallSettings[0][13];
		        $theight = $asgallSettings[0][14];
                        
	        	

	                            if (file_exists($file_image)) {
	                                $file_image = $path . '/' . $phtImage;
	                            } else {
	                                $file_image = $site_url . '/wp-content/plugins/' . dirname(plugin_basename(__FILE__)) . '/uploads/no-photo.png';
	                            }
	            $div .=  '<div onmouseover="showalbumname('.$albid.$j.')" onmouseout="dontshowalbumname('.$albid.$j.')" href="javascript:void(0)" class="asgallPhoto_spacing" >';

	            $div .=  '<a  onclick=showsinglephotopage'.$k.'("'.$pageURL.'","'.$asgallPhoto_id.'","'.$asgallPhoto_sorting.'","'.$albid.'","'.$getpageId.'") title="'.$photoName.'" >
	            <img src="'.$file_image.'" /></a>';
	            $div .= "<div id=$albid$j class='pica-show-albumname'><span>$photoName</span></div></div>";
	            $j++;
	            if($j % $asgallSettings[0][3] == 0) { $div .= '<div style="clear:both"></div>'; }
	       } // FOR LOOP
	        $div .='<div style="clear:both"></div>';
	      } // Else condition of album enable
	      $k++;
	    }   // IF END

 // ********************************** ENDING SHOW PHOTOS IN SELECTED ALBUM  ***************************************************************


      else if(!($_REQUEST['pid']))
       {
// ********************************** SHOW ALBUMS  ***************************************************************
   require_once( dirname(__FILE__) . '/asgallPagination.php');
       	 $i=0;
         $div .= '<style type="text/css">
        .asgall_spacing {width:'.$asgallSettings[0][5].'px;padding-right:'.$asgallSettings[0][7].'px;padding-bottom: '.$asgallSettings[0][8].'px;} </style>';

            $limit = $asgallSettings[0][3]*$asgallSettings[0][4];
            $sql   = mysql_query("SELECT * FROM " . $wpdb->prefix . "asgallalbum WHERE asgallAlbum_status='ON' AND is_delete=0 ");
            $start = findStart($limit);
            $w     = "LIMIT " . $start . ", " . $limit;
            $count = mysql_num_rows($sql);
            /* Find the number of pages based on $count and $limit */
            $pages = findPages($count, $limit);
            /* Now we use the LIMIT clause to grab a range of rows */

         $asgallAlbums = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "asgallalbum WHERE asgallAlbum_status='ON' AND is_delete=0 $w"); // Getting album name
         if(count($asgallAlbums) == 0)
         {
         	$div .= '<div> Please enable the albums</div>';
         }
         else
         {
           if($asgallSettings[0][17] == 0)
			{
				$typeid =  $asgallSettings[0][18];
				switch ($typeid)
                {
			case 0:
			   $sliderPhotos = $wpdb->get_results("SELECT  asgallPhoto_id, asgallPhoto_desc, asgallPhoto_name ,asgallPhoto_image  FROM " . $wpdb->prefix . "asgallphotos  WHERE  is_delete =0 and asgallPhoto_status = 'ON' ORDER BY asgallPhoto_hitcount DESC" ); // Getting album photos
			   break;
			case 1:
			   $sliderPhotos = $wpdb->get_results("SELECT  asgallPhoto_id,  asgallPhoto_desc, asgallPhoto_name ,asgallPhoto_image  FROM " . $wpdb->prefix . "asgallphotos  WHERE  is_delete =0 and asgallPhoto_status = 'ON' ORDER BY asgallPhoto_id DESC" ); // Getting album photos
 			   break;
			case 2:
			   $sliderPhotos = $wpdb->get_results("SELECT  asgallPhoto_id,  asgallPhoto_desc, asgallPhoto_name ,asgallPhoto_image  FROM " . $wpdb->prefix . "asgallphotos  WHERE  is_delete =0 and asgallPhoto_status = 'ON' and asgallFeaturedCover = 1" ); // Getting album photos
			   break;
			  default:
                }
		?>

<?php
 $div .='<style>
   .ad-gallery .ad-image-wrapper {

   height:'.$asgallSettings[0][2].'px;
   }

   </style>';
 if(count($sliderPhotos) == 0)
{
	$div .= 'No images for the slider';
}
else 
{
 $div .='<div id="gallery" class="ad-gallery">
<div class="ad-image-wrapper">
 </div>
<div class="ad-controls">
      </div>';
     $div .=' <div class="ad-nav">
        <div class="ad-thumbs">
          <ul class="ad-thumb-list">';
 foreach ($sliderPhotos as $values) {
          	$extens     = explode('.',$values->asgallPhoto_image);
          	$thumbimg   = $values->asgallPhoto_id.'_sliderthumb.'.$extens[1];
          	$photoName  = $values->asgallPhoto_name;
          	$photoDesc  = $values->asgallPhoto_desc;
                $file_thumb = $uploadDir['basedir'] . '/apptha-slider-gallery/'  . $thumbimg;
                $file_hover = $uploadDir['basedir'] . '/apptha-slider-gallery/' . $values->asgallPhoto_image;

                                   if (file_exists($file_hover))
                                    {
                                      $file_hover = $path.'/'.$values->asgallPhoto_image;
                                      
                                    }
                                    else
                                    {
                                         $file_hover = $site_url . '/wp-content/plugins/' . dirname(plugin_basename(__FILE__)) . '/uploads/no-photo.png';
                                    }
                                   if (file_exists($file_thumb))
                                    {
                                       $file_thumb = $path . '/' . $thumbimg;
                                      
                                    }
                                    else
                                    {
                                         $file_thumb = $site_url . '/wp-content/plugins/' . dirname(plugin_basename(__FILE__)) . '/uploads/no-photo.png';
                                    }
                                    
              $div .='<li>
              <a href="'.$file_hover.'">
                <img src="'.$file_thumb.'" title="'.$photoName.'"  class="asgall_slidethumb">
              </a></li>';
            }
           

           $div .='</ul>
        </div>
      </div>
    </div>';
} // if else close
           } // If slider enable 
   
         	$div .= '<div><h1 class="asgallheading" style="padding-bottom:5px !important;">Albums : </h1></div>';
         foreach ($asgallAlbums as $renderAlbum)
	        {
	        	$photoId    = explode('_',$renderAlbum->asgallAlbum_image);
	        	$extens     = explode('.',$photoId[1]);
	        	$albumImage = $photoId[0].'_albumthumb.'.$extens[1];
	        	$file_image = $uploadDir['basedir'] . '/apptha-slider-gallery/' . $albumImage;
	        	$date       = explode(' ',$renderAlbum->asgallAlbum_date);
	        	$exp_date   = explode('-',$date[0]);
	            $asgallPhtcount = $wpdb->get_row("SELECT count(*) as total, asgallPhoto_image FROM " . $wpdb->prefix . "asgallphotos WHERE asgallAlbum_id='$renderAlbum->asgallAlbum_id' and `is_delete` =0 and asgallPhoto_status = 'ON'"); // Getting album name
	            $asgallCount = $asgallPhtcount->total;
	            $twidth = $asgallSettings[0][5];
		        $theight = $asgallSettings[0][6];
$pageid = $_GET['page_id'];
	            if($renderAlbum->asgallAlbum_image == '' && $asgallCount == '0')
	                            {
	                            $file_image = $site_url . '/wp-content/plugins/' . dirname(plugin_basename(__FILE__)) . '/images/nocover.jpg';

	                            }
	                            else if($renderAlbum->asgallAlbum_image == '' && $asgallCount != '0')
	                            {
	                            	  $get_image  = explode('_',$asgallPhtcount->asgallPhoto_image);
	                            	  $extension  = explode('.',$get_image[1]);
	                            	  $phototumb  = $get_image[0].'_albumthumb.'.$extension[1];
	                            	  $file_image = $path . '/' . $phototumb;
	                            }
	                            else if (file_exists($file_image)) {
	                                $file_image = $path . '/' . $albumImage;
	                              }
	                            else
	                            {
	                            	$file_image = $site_url . '/wp-content/plugins/' . dirname(plugin_basename(__FILE__)) . '/images/nocover.jpg';
	                            }


   if($pageid != '')
              {
              $url = $pageURL.'&albid='.$renderAlbum->asgallAlbum_id;
              }
              else
              {
              $url = $pageURL.'?albid='.$renderAlbum->asgallAlbum_id;
              }
	           $div .=  '<div class="asgall_spacing"><a href="'.$url.'"><img class="asgall-shadow" src="'.$file_image.'" width="'.$twidth.'" height="'.$theight.'"  /></a>';
	           $div .=  '
	                  <div class="as_albumname"><a href="'.$pageURL.'&albid='.$renderAlbum->asgallAlbum_id.'">'.$renderAlbum->asgallAlbum_name.'</a></div>
                      <div class="asgall-album-date">'.  $post_date = date('M d, Y', strtotime($renderAlbum->asgallAlbum_date)).'</div>
                      <div class="asgall-album-date">photos: '.$asgallCount.'</div>
	                  </div>';
	           $i++;
	           if($i % $asgallSettings[0][3] == 0) { $div .= '<div style="clear:both"></div>'; }
	       } // For each ends
	        $div .='<div style="clear:both"></div>';
	        $pagelist = pageList($_GET['pages'], $pages, $_GET['albid']);
            $div .= '<div align="center">' . $pagelist . '</div>';
           
         } // else of count greaterthan one
       } // main if condition of album listing
// ********************************** ENDING OF SHOW ALBUMS  ***************************************************************
  $option_title = $wpdb->get_var("SELECT option_value FROM " . $wpdb->prefix . "options WHERE option_name='get_wpappslider_key'");
    $get_title = unserialize($option_title);
    $strDomainName = $site_url;
           preg_match("/^(http:\/\/)?([^\/]+)/i", $strDomainName, $subfolder);
	preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $subfolder[2], $matches);
	$customerurl = $matches['domain'];
	$customerurl = str_replace("www.", "", $customerurl);
	$customerurl = str_replace(".", "D", $customerurl);
	$customerurl = strtoupper($customerurl);
	$get_option_title = asgall_macgal_generate($customerurl);
if ($get_title['title'] != $get_option_title) {
     $div .='<div align="right" class="get_asgall" style="display:block;">'.apiKey_asgall().'</div>';
    } 
      
       return $div;

	} // End of Function

} // End of the class