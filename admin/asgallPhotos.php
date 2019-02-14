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
?>
<!-- Adding Buy now and Apply licence button in photos page  -->
<?php
global $wpdb;
$folder   = dirname(dirname(plugin_basename(__FILE__)));
$site_url = get_bloginfo('url');
	
require_once(dirname(dirname(__FILE__)) . '/asgallDirectory.php');

class macPhotos {
	var $base_page = '?page=appsliderPage';
	function macPhotos() {
		maccontroller();
	}
}

function maccontroller() {
	global $wpdb, $site_url, $folder;
	$site_url = get_bloginfo('url');
	$folder = dirname(dirname(plugin_basename(__FILE__)));
	?>
<link rel='stylesheet'
	href='<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder ?>/css/style.css'
	type='text/css' />
<script
	type="text/javascript"
	src="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder; ?>/js/jquery-1.3.2.js"></script>

<script
	type="text/javascript"
	src="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder; ?>/js/swfupload/swfupload.js"></script>
<script
	type="text/javascript"
	src="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder; ?>/js/jquery.swfupload.js"></script>
<script
	type="text/javascript"
	src="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder; ?>/js/jquery-ui-1.7.1.custom.min.js"></script>
<script
	type="text/javascript"
	src="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder; ?>/js/mac_preview.js"></script>

<script src="<?php echo $site_url . '/wp-content/plugins/'.$folder.'/js/macGallery.js'; ?>" type="text/javascript"></script>

<script type="text/javascript">
        var site_url,mac_folder,numfiles;
        site_url = '<?php echo $site_url; ?>';
        var url = '<?php echo $site_url; ?>';
        mac_folder  = '<?php echo $folder; ?>';
        keyApps = '<?php echo $configXML->keyApps; ?>';
        videoPage = '<?php echo $meta; ?>';
        var dragdr = jQuery.noConflict();
                function GetSelectedItem() {
                  //  alert(document.frm1.asgallAlbum_name.length);
                  // len2 = document.frm2.macGallery_name.length;
                 // for (i = 0; i < len2; i++) {
                  //  if (document.frm2.macGallery_name[i].selected) {
                    //    galId = document.frm2.macGallery_name[i].value;
                  //  }
               // }
                len = document.frm1.asgallAlbum_name.length;
                
                i = 0;
                chosen = "none";
                for (i = 0; i < len; i++) {
                    if (document.frm1.asgallAlbum_name[i].selected) {
                        chosen = document.frm1.asgallAlbum_name[i].value;
                    }
                }
               
                galId = 1;
                //alert('galid= '+galid);
                //window.location = 'google.com';
              //  alert(site_url+"/wp-admin/admin.php?page=picaPhotos&galid="+galId+"&albid="+chosen);
               window.location = site_url+"/wp-admin/admin.php?page=slidePhotos&galid="+galId+"&albid="+chosen;

            }

            function GallerySelectedItem() {
                  
                  //var galId  = document.getElementById('macGallery_name').selectedIndex;
                  len2 = document.frm2.macGallery_name.length;
                  for (i = 0; i < len2; i++) {
                    if (document.frm2.macGallery_name[i].selected) {
                        galId = document.frm2.macGallery_name[i].value;
                    }
                } galid = 1;
                  window.location = site_url+"/wp-admin/admin.php?page=slidePhotos&galid="+galId;
              }

       window.onload = function()
       {
          //alert(document.getElementById('asgallAlbum_name').value);
           if (document.getElementById('asgallAlbum_name').value == 0 ||document.getElementById('asgallAlbum_name').value == -1)
           {
        	   document.getElementById('swfupload-control').style.visibility='hidden';
           }
           else
           {
        	   document.getElementById('swfupload-control').style.visibility='visible';
           }
       }
    </script>
<script type="text/javascript">
var QueueCountApptha = 0;
    dragdr(document).ready(function(){
    if(document.getElementById('mac-test-list'))
                {
               dragdr("#mac-test-list").sortable({
                handle : '.handle',
                update : function () {
                    var order =dragdr('#mac-test-list').sortable('serialize');
                   
                     dragdr("#info").load(site_url+"/wp-content/plugins/"+mac_folder+"/admin/process-sortable.php?"+order);

                   }

                });
    }

           dragdr('#swfupload-control').swfupload({

     upload_url: site_url+"/wp-content/plugins/"+mac_folder+"/admin/asgallUpload.php?albumId=<?php echo $_REQUEST['albid'] ?>",
                
                file_post_name: 'uploadfile',
                file_size_limit : 0,
                file_types : "*.jpg;*.png;*.jpeg;*.gif",
                file_types_description : "Image files",
                file_upload_limit : 20,
                flash_url : site_url+"/wp-content/plugins/"+mac_folder+"/js/swfupload/swfupload.swf",
                button_image_url : site_url+'/wp-content/plugins/'+mac_folder+'/js/swfupload/wdp_buttons_upload_114x29.png',
                button_width : 114,
                button_height : 29,
                button_placeholder :dragdr('#button')[0],
                debug: false
            })
            .bind('fileQueued', function(event, file){
                var listitem='<li id="'+file.id+'" >'+
                    'File: <em>'+file.name+'</em> ('+Math.round(file.size/1024)+' KB) <span class="progressvalue" ></span>'+
                    '<div class="progressbar" ><div class="progress" ></div></div>'+
                    '<p class="status" >Pending</p>'+
                    '<span class="cancel" >&nbsp;</span>'+
                    '</li>';

                dragdr('#log').append(listitem);

               dragdr('li#'+file.id+' .cancel').bind('click', function(){
                    var swfu =dragdr.swfupload.getInstance('#swfupload-control');
                    swfu.cancelUpload(file.id);
                    dragdr('li#'+file.id).slideUp('fast');
                });
                // start the upload since it's queued
                dragdr(this).swfupload('startUpload');
            })
            .bind('fileQueueError', function(event, file, errorCode, message){
                alert('Size of the file '+file.name+' is greater than limit');

            })
        .bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
               dragdr('#queuestatus').text('Files Selected: '+numFilesSelected+' / Queued Files: '+QueueCountApptha);
                numfiles = numFilesQueued;
                totalQueues = numFilesSelected;
                i=1;
                j=numfiles;
            })
            .bind('uploadStart', function(event, file){

                dragdr('#log li#'+file.id).find('p.status').text('Uploading...');
               dragdr('#log li#'+file.id).find('span.progressvalue').text('0%');
               dragdr('#log li#'+file.id).find('span.cancel').hide();
            })
            .bind('uploadProgress', function(event, file, bytesLoaded){
                //Show Progress

                var percentage=Math.round((bytesLoaded/file.size)*100);
               dragdr('#log li#'+file.id).find('div.progress').css('width', percentage+'%');
               dragdr('#log li#'+file.id).find('span.progressvalue').text(percentage+'%');
            })
        .bind('uploadSuccess', function(event, file, serverData){
                var item=dragdr('#log li#'+file.id);
                QueueCountApptha++;
               
                item.find('div.progress').css('width', '100%');
                item.find('span.progressvalue').text('100%');
                item.addClass('success').find('p.status').html('Done!!!');
                jQuery('#queuestatus').text('Files Selected: '+totalQueues+' / Queued Files: '+QueueCountApptha);
        	 })
            
    
            .bind('uploadComplete', function(event, file){
                // upload has completed, try the next one in the queue
                dragdr(this).swfupload('startUpload');
                if(j == i)
                    {
                 macPhotos(numfiles,'<?php echo $_REQUEST['albid'] ?>');
                    }
                    i++
            })

        });
    </script>
<script type="text/javascript">
        function checkallPhotos(frm,chkall)
        {
            var j=0;
            comfList123 = document.forms[frm].elements['checkList[]'];
            checkAll = (chkall.checked)?true:false; // what to do? Check all or uncheck all.

            // Is it an array
            if (comfList123.length) {
                if (checkAll) {
                    for (j = 0; j < comfList123.length; j++) {
                        comfList123[j].checked = true;
                    }
                }
                else {
                    for (j = 0; j < comfList123.length; j++) {
                        comfList123[j].checked = false;
                    }
                }
            }
            else {
                /* This will take care of the situation when your
    checkbox/dropdown list (checkList[] element here) is dependent on
    a condition and only a single check box came in a list.
                 */
                if (checkAll) {
                    comfList123.checked = true;
                }
                else {
                    comfList123.checked = false;
                }
            }

            return;
        }


    </script>


<script type="text/javascript">
// starting the script on page load
dragdr(document).ready(function(){

	imagePreview();
});

 
 </script>


<style type="text/css">
#swfupload-control p {
	margin: 10px 5px;
	font-size: 11px;
	width: 100%;
}

#log {
	margin: 0;
	padding: 0;
	width: 100%;
}

#log li {
	list-style-position: inside;
	margin: 2px;
	border: 1px solid #ccc;
	padding: 10px;
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
	color: #333;
	background: #fff;
	position: relative;
}

#log li .progressbar {
	border: 1px solid #333;
	height: 5px;
	background: #fff;
}

#log li .progress {
	background: #999;
	width: 0%;
	height: 5px;
}

#log li p {
	margin: 0;
	line-height: 18px;
}

#log li.success {
	border: 1px solid #339933;
	background: #ccf9b9;
}

#log li span.cancel {
	position: absolute;
	top: 5px;
	right: 5px;
	width: 20px;
	height: 20px;
	background: url('../cancel.png') no-repeat;
	cursor: pointer;
}
#mydiv{background:#fff;width:500px;height:100px;}
</style>
</head>
<body>
<?php
if ($_REQUEST['action'] == 'viewPhotos')
{
		$albid = $_REQUEST['albid'];
	if ($_REQUEST['asgallPhotoid'] != '') {
		$asgallPhotoid = $_REQUEST['asgallPhotoid'];
		$photoImg = $wpdb->get_var("SELECT asgallPhoto_image FROM " . $wpdb->prefix . "asgallphotos WHERE asgallPhoto_id='$asgallPhotoid' ");
		$delete = $wpdb->query("DELETE FROM " . $wpdb->prefix . "asgallphotos WHERE asgallPhoto_id='$asgallPhotoid'");

		// $path = '../wp-content/plugins/'.$folder.'/uploads/';
		$uploadDir = wp_upload_dir();
		$path = $uploadDir['basedir'].'/apptha-slider-gallery';
		unlink($path .'/'.$photoImg);
		$extense = explode('.', $photoImg);
		unlink($path . $asgallPhotoid . '.' . $extense[1]);
}
	if (isset($_REQUEST['action_photos']) == 'Delete'  && count($_POST['checkList']) )   {

		//	echo "<pre>";			print_r($_POST);			echo "<pre>";
			
			switch($_REQUEST['action_photos']){
				
				case 'Delete' : {
										
									$albidis = $_GET["albid"];
								    if(intval(in_array($_POST['featuredimgname'] , $_POST['checkList']))){  // upload featured img name if u delete it
								   	
								      $wpdb->query("UPDATE " . $wpdb->prefix . "asgallalbum  SET  macFeaturedImage = 0 WHERE asgallAlbum_id='$albidis'");
								    }
									if(intval(in_array($_POST['albumimgname'] , $_POST['checkList']) ) ){  // upload album img name if u delete it
								   	
								       $wpdb->query("UPDATE " . $wpdb->prefix . "asgallalbum  SET  asgallAlbum_image =   0 WHERE asgallAlbum_id='$albidis'");
								    }
										
									for ($k = 0; $k < count($_POST['checkList']); $k++) {
										$asgallPhoto_id = $_POST['checkList'][$k];
										
											 $wpdb->query("UPDATE " . $wpdb->prefix . "asgallphotos  SET  is_delete = 1 WHERE asgallPhoto_id='$asgallPhoto_id'");
										
									}
				$total1 = $wpdb->get_results("SELECT asgallPhoto_id FROM  " . $wpdb->prefix . "asgallphotos   WHERE asgallAlbum_id = $albidis AND  is_delete = 0  ",ARRAY_A);
									
								$stop =  count($total1 ); 
								
								for($i = 0 ; $i< $stop ; $i++ )
								{
									 $id =	$total1[$i]['asgallPhoto_id'];
								  $sql = "UPDATE " . $wpdb->prefix . "asgallphotos  SET  asgallPhoto_sorting =   $i  WHERE asgallPhoto_id = $id"  ;
								    
									$wpdb->query($sql);
											
								}
				$msg = 'Photos Deleted Successfully';					
				}break;
				case 'Featured' : {      
							
									$val = $_POST['subaction_photos'];
									
											
									$table = $wpdb->prefix . "asgallphotos";
									$data = array('asgallFeaturedCover' => $val );
									
									for ($k = 0; $k < count($_POST['checkList']); $k++) {
										
										$where = array( 'asgallPhoto_id' => $_POST['checkList'][$k]);
										$wpdb->update( $table, $data, $where, $format = null, $where_format = null );
										
									}
					
				$msg = 'Updated Successfully';	
				}break; 
				case 'Status' : {
								$val = $_POST['subaction_photos'];
								if($val){
									$val = 'ON';
								}
								else 
									$val = 'OFF';
						$table = $wpdb->prefix . "asgallphotos";
						$data = array('asgallPhoto_status' => $val );
						
						for ($k = 0; $k < count($_POST['checkList']); $k++) {
							
							$where = array( 'asgallPhoto_id' => $_POST['checkList'][$k]);
							$wpdb->update( $table, $data, $where, $format = null, $where_format = null );
							
						}
					
				$msg = 'Updated Successfully';	
				}break; 
					
					
					
				
			}	//switch end hear
			
			
			
			
		}


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

	function pageList($curpage, $pages, $albid) {
		//Pagination
		$page_list = "";
		if ($search != '') {

			$self = '?page=' . slidePhotos . '&action=viewPhotos' . '&albid=' . $albid;
		} else {
			$self = '?page=' . slidePhotos . '&action=viewPhotos' . '&albid=' . $albid;
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
	?>
	<link rel='stylesheet' href='<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder ?>/css/style.css' type='text/css' />
	
	<div class="wrap nosubsub"
		style="width: 98%; float: left; margin-right: 15px; align: center">
		<div id="icon-upload" class="icon32">
			<br />
		</div>
		
		
		<?php if ($msg) {
 ?>
            <div  class="updated below-h2">
                <p><?php echo $msg; ?></p>
            </div>
<?php } ?>
		<div class="clear"></div>
		<?php
		 $uploadDir = wp_upload_dir();
			 $file_image =  $uploadDir['basedir'] . '/apptha-slider-gallery/' .$asgallAlbum->asgallAlbum_image;
			 $path = $uploadDir['baseurl'].'/apptha-slider-gallery';
			 $site_url = get_bloginfo('url');
		
		if($_REQUEST['albid'] != '' && $_REQUEST['albid']!='0')
		{
			
			$albid = $_REQUEST['albid'];
			$asgallAlbum = $wpdb->get_row("SELECT * ,asgallGallery_name FROM " . $wpdb->prefix . "asgallalbum," . $wpdb->prefix . "asgallgallery where ". $wpdb->prefix . "asgallgallery.".	asgallGallery_id."=". $wpdb->prefix . "asgallalbum." . 	asgallGallery_id . " and asgallAlbum_id='$albid' and is_delete=0 ORDER BY asgallAlbum_id DESC");
			$asgallPhtcount = $wpdb->get_row("SELECT count(*) as total, asgallPhoto_image FROM " . $wpdb->prefix . "asgallphotos WHERE asgallAlbum_id='$albid' and `is_delete` =0 and asgallPhoto_status = 'ON'"); // Getting album name
	           
			$picaAlbumList = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "asgallalbum WHERE is_delete=0");
			$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
				if ($_SERVER["SERVER_PORT"] != "80")
				{
				    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
				} 
				else 
				{
				    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
				}
				$copyofurl = $pageURL;	
			$pageURL =	explode('albid',$pageURL);
					
					
				
			?>
		<h4>
         <!--   <div class="lfloat">Featured Photo</div>     Displaying Featured image -->
			<div>
			<?php  
				
			if($asgallAlbum->asgallAlbum_image){
						
						$albumImgName =  $asgallAlbum->asgallAlbum_image;
						$albumImgName =  explode('_',$albumImgName );
						$albumImgName =  $albumImgName[0];
					}
					else{   // if album photo is not set then defalut we give first photo to album
						
						$aid = $_GET['albid'];
						$sql = "SELECT  asgallPhoto_id ,  asgallPhoto_image FROM ". $wpdb->prefix ."asgallphotos where asgallAlbum_id = $aid AND is_delete = 0 GROUP BY asgallAlbum_id ";
						$newRes   =   $wpdb->get_results($sql,ARRAY_A);
					
					   $idis     = $newRes[0]['asgallPhoto_id'];
						$listItem = array(); 
						$tab = $wpdb->prefix ."asgallphotos" ;
					    $imgname =  $newRes[0]['asgallPhoto_image'];
					    if($imgname){
					     $sql2 = " UPDATE  ". $wpdb->prefix ."asgallalbum  SET asgallAlbum_image = '$imgname'  WHERE asgallAlbum_id = $aid" ;
					    $wpdb->query("UPDATE $tab SET  asgallAlbum_cover = 'ON'  WHERE `asgallPhoto_id` = $idis");
					    $wpdb->query($sql2);
					   	?>
						<script type="text/javascript"> 
						// alert('form submit');
						 window.location =  '<?php echo $copyofurl ; ?>'; 
						 </script>
						<?php 
					    }
					
					}
					
					
		?>
		
			<div style="float:left">Album Name : </div>
			<div style="float:left;color: #448abd;"><?php echo $asgallAlbum->asgallAlbum_name; ?></div>
			<div class="clear"></div>
		</h4>
		<?php
		if($asgallAlbum->asgallAlbum_image)
	                            {
	                            	  $get_image  = explode('_',$asgallAlbum->asgallAlbum_image);
	                            	  $extension  = explode('.',$get_image[1]);
	                            	  $phototumb  = $get_image[0].'_albumthumb.'.$extension[1];
	                            	  $file_image = $path . '/' . $phototumb;
	                            }
	                           
	                            else
	                            {
	                            	$file_image = $site_url . '/wp-content/plugins/apptha-slider-gallery/images/nocover.jpg';
	                            }

		
		 
		 ?>
   		<img src="<?php echo $file_image; ?>"
			width="100" height="100" />

<div style="float: right; width: 80%">
		
		<form name="asgallPhotos" id="asgallPhotos" method="POST" onsubmit="return deleteImages();">
			
		<input type="hidden" name="featuredimgname"  id="featuredimgname"   value="<?php echo $featuredImgName; ?>" >
		<input type="hidden" name="albumimgname"    value="<?php echo $albumImgName; ?>"    >	
		
				<select name="action_photos"  id="action_photos" style="float: left" onchange ="displaysubaction()" >
					<option  value="bulk" selected="selected">
					<?php _e('Bulk Actions'); ?>
					</option>
					<option  value="Featured">
					<?php _e('Featured Photos'); ?>
					</option>
					<option  value="Status">
					<?php _e('Status'); ?>
					</option>
					<option  value="Delete">
					<?php _e('Delete'); ?>
					</option>
				</select>
				<select name='subaction_photos' id='subaction_photos' style="display: none;float: left;" >
					<option value="1" >Enable</option>
					<option value="0" >Disable</option>
				</select>
				
				<input type="submit" value="<?php esc_attr_e('Apply'); ?>"
					name="doaction_photos" id="doaction_photos"
					class="button-secondary action"  onclick="return checkemptyaction('asgallPhotos')" />
                              
				<span id="ApplybutErroMsg" style="color: red;" ></span>

Select Album <select onchange="displaySelectedAlbum(this.value,'<?php echo $pageURL[0] ; ?>')" >
					<?php

					$numOfTimes =  count($picaAlbumList);

						foreach($picaAlbumList as $key => $value ){
							 if( $value->asgallAlbum_id == $albid)
							 {
							 	 $isselect =  "selected='selected'";
							 }
							else {$isselect = ''; }
				echo "<option  $isselect value=".$value->asgallAlbum_id."  >".$value->asgallAlbum_name."</option>" ;
						}

					?>
			</select>
		
		
                                  <ul class="alignright actions">
	<li><a
						href="<?php echo $site_url ?>/wp-admin/admin.php?page=slidePhotos&albid=<?php echo $asgallAlbum->asgallAlbum_id; ?>&galid=<?php echo 1;  // echo $asgallAlbum->macGallery_id; ?>"
						class="gallery_btn">Add Photos</a></li>

				</ul>

				<!--<div id="info">Waiting for update</div>-->
	<script type="text/javascript">


	function displaySelectedAlbum(idval , pageurl){

		//alert(idval+'-------'+ pageurl);
		window.location = pageurl+'albid='+idval;
		

	}
				function deleteImages(){
					if(document.getElementById('action_photos').selectedIndex == 3)
					{
						var answer = confirm('Are you sure to delete photo/s ?');
						if (answer){
							return true;
						}
						else{
							return false;
						}
					}
					else if(document.getElementById('action_photos').selectedIndex == 0)
					{
					return false;
					}

				}
				function checkemptyaction(formnameis){

					if(!document.getElementById('action_photos').selectedIndex){
						document.getElementById('ApplybutErroMsg').innerHTML = 'Please select Action';
						
						return false;
					}
					
					chks = document.getElementsByName('checkList[]');
					//alert(chks.length);
					var hasChecked = false;
					for (var i = 0; i < chks.length; i++)
					{
						if (chks[i].checked)
						{
						hasChecked = true;
						break;
						}
					}
					if(!hasChecked)
					 { 
						document.getElementById('ApplybutErroMsg').innerHTML = 'Please Select Check box'; 
						
						 return false;
					 }	 
					else
					{  document.getElementById('ApplybutErroMsg').innerHTML = '';
					}	
					return true;
				}
				function displaysubaction(){
					 var showsubact = document.getElementById('action_photos').selectedIndex;
					
					if(showsubact == 1 || showsubact == 2 ){
						document.getElementById('ApplybutErroMsg').innerHTML = '';		
						document.getElementById('subaction_photos').style.display = 'block'; 
					}
					else{
						// alert(showsubact+'---'+document.getElementById('subaction_photos').style.display);
						 document.getElementById('ApplybutErroMsg').innerHTML = '';
						}
				}
				</script>
				<table cellspacing="0" cellpadding="0" border="1"
					class="mac_gallery">
					<thead>
						<tr>
							<th style="width: 5%">Sort</th>
							<th class="maccheckPhotos_all"
								style="width: 5%; text-align: center;"><input type="checkbox"
								name="maccheckPhotos" id="maccheckPhotos" class="maccheckPhotos"
								onclick="checkallPhotos('asgallPhotos',this);" /></th>
							<th class="macname" style='max-width: 30%; text-align: left'>Name</th>
							<th class="macimage" style='width: 10%; text-align: left'>Image</th>
							<th class="macdesc" style='width: 30%; text-align: left'>Description</th>
							<th class="macon" style='width: 10%'>Album Cover</th>
							<th class="macon" style='width: 10%'>Featured Photos</th>
							<th class="macon" style='width: 10%; text-align: center'>Sorting</th>
							<th class="macon" style='width: 10%; text-align: center'>Status</th>
						</tr>
					</thead>
					<tbody id="mac-test-list" class="list:post">
					<?php
					$site_url = get_bloginfo('url');
					/* Pagination */

					$limit = 20;
					  $sql = mysql_query("SELECT * FROM " . $wpdb->prefix . "asgallphotos WHERE asgallAlbum_id='$albid' AND is_delete = 0 ORDER BY asgallPhoto_sorting ASC");
					$start = findStart($limit);
					
					if($_REQUEST['pages']== 'viewAll')
					{
						$w= '';
					}
					else
					{

						$w = "LIMIT " . $start . "," . $limit;
					}

					$count = mysql_num_rows($sql);
					/* Find the number of pages based on $count and $limit */
					$pages = findPages($count, $limit);
					/* Now we use the LIMIT clause to grab a range of rows */
					$result = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "asgallphotos WHERE asgallAlbum_id='$albid' AND is_delete =0   ORDER BY asgallPhoto_sorting DESC $w");
					$album = '';

					if(count($result) == '0')
					{
						echo '<tr><td colspan="8" style="text-align: center;">No photos</td></tr>';
					}
					else
					{

                                            
						foreach ($result as $results)
						{   
						//echo "<pre>";	print_r($results); echo "<pre>";
                                                    $style = 'style="display:none;"';
                                                  
				$album .= "<tr class='$j' id='listItem_$results->asgallPhoto_id'>
                               <td class='mac_sort_arrow'><img src='$site_url/wp-content/plugins/$folder/images/arrow.png' alt='move' width='16' height='16' class='handle' /></td>
                               <td class='checkPhotos_all' style='text-align: center'><input type=hidden id=asgallPhoto_id name=asgallPhoto_id value='$results->asgallPhoto_id' >
                               <input type='checkbox' class='checkSing' name='checkList[]' class='others' value='$results->asgallPhoto_id' ></td>

                               <td class='macName'style='text-align: left' ><div id='asgallPhotos_$results->asgallPhoto_id' onclick=photosNameform($results->asgallPhoto_id); style='cursor:pointer'>" . $results->asgallPhoto_name . "</div>
                               <form name='macPhotoform' method='POST'>
                               <span $style id='showPhotosedit_$results->asgallPhoto_id'>";
                                $album .= '<input type="text" name="macPhoto_name_'.$results->asgallPhoto_id.'" id="macPhoto_name_'.$results->asgallPhoto_id.'" >
    <input type="submit" name="updatePhoto_name" value="Update" onclick="updPhotoname('.$results->asgallPhoto_id.')">' ;
                              $album .= " </span>
                               <div class='delView'></div></td>";

							if ($results->asgallPhoto_image == '')
							{
								$album .="<td  style='width:10%;align=center'>
                    <a id='$site_url/wp-content/plugins/$folder/images/default_star.gif' class='preview' alt='Edit'  href='javascript:void(0)'>
                     <img src='$site_url/wp-content/plugins/$folder/images/default_star.gif' width='40' height='20' /></a></td>";
							} else
							{
								$temp_img   =  explode('_',$results->asgallPhoto_image);
        						$get_ext    =  explode('.',$temp_img[1]);
       							$get_albimg =  $temp_img[0].'_photothumb.'.$get_ext[1];

					$album .="<td  style='width:10%;align=center'>
                    <a id='$site_url/wp-content/uploads/apptha-slider-gallery/$get_albimg' class='preview' alt='Edit' href='javascript:void(0)'>
                    <img src='$site_url/wp-content/uploads/apptha-slider-gallery/$get_albimg' width='40' height='20' /></a></td>";
							}

							$album .="<td style='width:30%'><div id='display_txt_" . $results->asgallPhoto_id . "'>" . $results->asgallPhoto_desc . "</div>
                             <a id='displayText_" . $results->asgallPhoto_id . "' href='javascript:phototoggle($results->asgallPhoto_id);'>Edit</a>
                             <div id='toggleText" . $results->asgallPhoto_id . "' style='display: none'>
                             <textarea name='asgallPhoto_desc' id='asgallPhoto_desc_" . $results->asgallPhoto_id . "' rows='6' cols='30' >$results->asgallPhoto_desc</textarea><br />
                             <input type='button' onclick='javascript:macdesc_updt($results->asgallPhoto_id);' value='Update'>
                             </div></td>";
                        

							if ($results->asgallAlbum_cover == 'ON')
							{
								$album .= "<td align='center'><div id='albumCover_bind_$results->asgallPhoto_id' style='text-align:center'>
                            <img src='$site_url/wp-content/plugins/$folder/images/tick.png' width='16' height='16' style='cursor:pointer;text-align:center' onclick=macAlbcover_status('OFF',$albid,$results->asgallPhoto_id) /></div></td>";
							} else
							{
								$album .= "<td align='center'>
							<div id='albumCove_bind_$results->asgallPhoto_id' style='text-align:center'>
                            <img src='$site_url/wp-content/plugins/$folder/images/publish_x.png' width='16' height='16' style='cursor:pointer;text-align:center' onclick=macAlbcover_status('ON',$albid,$results->asgallPhoto_id) /></div>
                            </td>";
							}
						if ($results->asgallFeaturedCover)
							{
								$album .= "<td align='center'><div id='albumCover_bind_$results->asgallPhoto_id' style='text-align:center'>
                            <img src='$site_url/wp-content/plugins/$folder/images/tick.png' width='16' height='16' style='cursor:pointer;text-align:center' onclick=macAlbcover_status('0',$albid,$results->asgallPhoto_id,1) /></div></td>";
							} else
							{
								$album .= "<td align='center'>
							<div id='albumCove_bind_$results->asgallPhoto_id' style='text-align:center'>
                            <img src='$site_url/wp-content/plugins/$folder/images/publish_x.png' width='16' height='16' style='cursor:pointer;text-align:center' onclick=macAlbcover_status('1',$albid,$results->asgallPhoto_id,1) /></div>
                            </td>";
							}
							
							$album .="<td style='text-align:center'>$results->asgallPhoto_sorting</td>";
							if ($results->asgallPhoto_status == 'ON')
							{
								$album .= "<td><div id='photoStatus_bind_$results->asgallPhoto_id' style='text-align:center'>
                            <img src='$site_url/wp-content/plugins/$folder/images/tick.png' width='16' height='16' style='cursor:pointer' onclick=asgallPhoto_status('OFF',$results->asgallPhoto_id) /></div></td>";
							}
							
							else
							{
								$album .= "<td><div id='photoStatus_bind_$results->asgallPhoto_id' style='text-align:center'>
                            <img src='$site_url/wp-content/plugins/$folder/images/publish_x.png' width='16' height='16' style='cursor:pointer' onclick=asgallPhoto_status('ON',$results->asgallPhoto_id) /></div></td></tr>";
							}
						} // for loop
					}  // else for record exist
					$pagelist = pageList($_GET['pages'], $pages, $_GET['albid']);

					echo $album;
					?>
					</tbody>
				</table>
			</form>
			<div align="right">
			<?php echo $pagelist; ?>
			<?php
			if($count > $limit )
			{ ?>
				<a
					href="<?php echo $site_url?>/wp-admin/admin.php?page=slidePhotos&action=viewPhotos&albid=<?php echo $albid;?>&pages=viewAll">See
					All</a>
			</div>
			<?php
			}
			?>

			<?php   ?>
			<?php }
			else
			{
				?>
			<div style="padding-top: 20px">No albums is selected. Please Go to
				back and select the respective album to view images</div>
				<?php
			}
			?>

		</div>

	</div>
	<?php
} else {
	?>
	<div class="wrap nosubsub clearfix">
		
		<div class="clear">
			<div style="width: 30%; float: left; margin-right: 15px;">
				<h3>Select The Album To Upload Photos</h3>
				<div class="clear"></div>
                                <!--  Displaying all galleries from database -->
				<form name="frm2" method="POST">
					<div class="macLeft">
				<!-- 	
					<p><b></>Select Gallery</b></p>
					<select name="macGallery_name" id="macGallery_name" onchange="GallerySelectedItem()">
							<option value="0">-- Select Gallery Here --</option>
							<?php
							
							$galId = $_REQUEST['galid'];
							$galId = 1;
							$glryRst = $wpdb->get_results("SELECT * FROM  " . $wpdb->prefix . "asgallgallery");
							foreach ($glryRst as $glryRsts) {

							?>
							<option value="<?php echo $glryRsts->asgallGallery_id; ?>" <?php if($glryRsts->asgallGallery_id == $galId) { ?>selected="selected" <?php }?>><?php echo $glryRsts->asgallGallery_name; ?></option>
							<?php
							}
							?>
						</select>
				 -->
						</div>
				</form>
				<div class="clear"></div><br/>
					<!--  Displaying all galleries from database -->
                                 <div id="album-control">
				<form name="frm1">
					<div class="macLeft">
					<!--<p><b>Choose Album For Upload Photos</b></p> -->
						<select name="asgallAlbum_name" id="asgallAlbum_name"
							onchange="GetSelectedItem()">
							<option value="0">--- Select Album Here ---</option>
							<?php
							
							$galId=$_REQUEST['galid'];
							$galId = 1;
							if (($_REQUEST['albid']) != '') {
								$albid = $_REQUEST['albid'];
							}
							$albRst = $wpdb->get_results("SELECT * FROM  " . $wpdb->prefix . "asgallalbum where asgallGallery_id=$galId AND is_delete=0");
							foreach ($albRst as $albRsts) {
								if ($albid == $albRsts->asgallAlbum_id) {
									$selected = 'selected = "selected"';
								} else {
									$selected = '';
								}
								?>
							<option value="<?php echo $albRsts->asgallAlbum_id; ?>"
							<?php echo $selected ?>>
								<?php echo $albRsts->asgallAlbum_name; ?>
							</option>
							<?php
							}
							?>
						</select>
					</div>
					
				</form></div><div class="clear"></div><br/>
                                        <div class="macLeft" style="padding-left: 5px"> <a href="<?php echo $site_url.'/wp-admin/admin.php?page=slideAlbum'?>">Create New Album</a></div>
				<div id="swfupload-control" class="left_align">
					<p>Upload multiple image files(jpg, jpeg, png, gif)</p>
				    Upto 20 files can upload on single click<input type="button" id="button" />
					<p id="queuestatus"></p>
					<ol id="log"></ol>
				</div>
				<?php
				if($_REQUEST['albid'] != '0' && $_REQUEST['albid'] != '' && $_REQUEST['albid'] != '-1' )
				{
					?>
					<script type="text/javascript">
						document.getElementById('swfupload-control').style.visibility='visible';
					</script>

				<?php }
				else
				{
				?>
				<script type="text/javascript">
						document.getElementById('swfupload-control').style.visibility='hidden';
					</script>
				<?php } ?>

			</div>

			<div name="bind_asgallPhotos" id="bind_asgallPhotos" class="bind_asgallPhotos" style="float: left;"></div>
		</div>

		<input type="hidden" name="bind_value" id="bind_value" value="0" />
	</div>
	<?php
}
}
?>