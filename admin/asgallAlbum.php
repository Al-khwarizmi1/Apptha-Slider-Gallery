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

class macManage {


    function macManage() {

        if ($_REQUEST['action'] == 'editAlbum') {
            updateAlbum();
        } else {
            controller();
        }
    }
}


function controller() {
        global $wpdb, $site_url, $folder;
        $site_url = get_bloginfo('url');
        $folder   = dirname(dirname(plugin_basename(__FILE__)));
       
        $pageURL  = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        $split_title = $wpdb->get_var("SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name='get_wpappslider_key'");
        $get_title = unserialize($split_title);
        $strDomainName = $site_url;
        preg_match("/^(http:\/\/)?([^\/]+)/i", $strDomainName, $subfolder);
        preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $subfolder[2], $matches);
        $customerurl = $matches['domain'];
        $customerurl = str_replace("www.", "", $customerurl);
        $customerurl = str_replace(".", "D", $customerurl);
        $customerurl = strtoupper($customerurl);
        $get_key     = asgall_macgal_generate($customerurl);
    $macSet   = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "macsettings");
    $mac_album_count = $wpdb->get_var("SELECT count(*) FROM " . $wpdb->prefix . "asgallAlbum");
    
    if (isset($_REQUEST['doaction_album']))
     {
        if (isset($_REQUEST['action_album']) == 'delete')
         {
            for ($i = 0; $i < count($_POST['checkList']); $i++)
            {
                $asgallAlbum_id = $_POST['checkList'][$i];
                $alumImg = $wpdb->get_var("SELECT asgallAlbum_image FROM " . $wpdb->prefix . "asgallalbum WHERE asgallAlbum_id='$asgallAlbum_id' ");
                $delete = $wpdb->query("UPDATE " . $wpdb->prefix . "asgallalbum  SET  is_delete = 1 WHERE asgallAlbum_id='$asgallAlbum_id'");
                //define(upload, "$path/");

                //unlink(upload . $asgallAlbum_id . 'alb.' . $extense[1]);

               // $phtImg = $wpdb->get_results("SELECT asgallPhoto_image FROM " . $wpdb->prefix . "asgallphotos WHERE asgallAlbum_id='$asgallAlbum_id'");
               // $uploadDir = wp_upload_dir();
              //  $path = $uploadDir['basedir'].'/apptha-slider-gallery';
            
               // foreach($phtImg as $phtImgs)
               // {
               //unlink($path.'/'.$phtImgs->macPhoto_image);
               // $extense  = explode('.', $phtImgs->macPhoto_image);
               // $phtalbid = explode('_',$extense[0]);
               // unlink($path.'/'.$phtalbid[0]. '.' . $extense[1]);
              //  }
 $wpdb->query("UPDATE " . $wpdb->prefix . "asgallphotos  SET  is_delete = 1 WHERE asgallAlbum_id='$asgallAlbum_id'");
             }
            $msg = 'Album/s Deleted Successfully';
        }
    }
?>
    <link rel='stylesheet' href='<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder ?>/css/style.css' type='text/css' />
    <script type="text/javascript" src="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder; ?>/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder; ?>/js/macGallery.js"></script>
    <script type="text/javascript" src="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder; ?>/js/mac_preview.js" ></script>
    <script type="text/javascript">

        var site_url = '<?php echo $site_url; ?>';
        var url = '<?php echo $site_url; ?>';
        var mac_folder = '<?php echo $folder; ?>';
        var pages  = '<?php echo $_REQUEST['pages']; ?>';
        var get_title = '<?php echo $get_title['title'];?>';
        var title_value = '<?php echo $get_key ?>';
        var dragdr = jQuery.noConflict();
         dragdr(document).ready(function(dragdr) {
       // asgallAlbum(pages)
         });
    </script>
    <script src="<?php echo $site_url . '/wp-content/plugins/'.$folder.'/js/jquery-pack.js'; ?>" type="text/javascript"></script>
<link href="<?php echo $site_url . '/wp-content/plugins/'.$folder.'/css/facebox_admin.css';?>" media="screen" rel="stylesheet" type="text/css" />
<script src="<?php echo $site_url . '/wp-content/plugins/'.$folder.'/js/facebox_admin.js'; ?>" type="text/javascript"></script>
<script src="<?php echo $site_url . '/wp-content/plugins/'.$folder.'/js/jquery.colorbox.js';?>"></script>
<script type="text/javascript">

    dragdr(document).ready(function($) {
      dragdr('a[rel*=facebox]').facebox()
    })
</script>
<script type="text/javascript">

  function checkasgall(frm,chkall)
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

  
        var dragdr = jQuery.noConflict();
        jQuery(function(){
            dragdr("#asgallAlbum_submit").click(function() {
                // Made it a local variable by using "var"
                var asgallAlbum_name = document.getElementById("asgallAlbum_name").value;
                var macGallery_name = document.getElementById("macGallery_name").value;
                if(macGallery_name == "0"){
                    document.getElementById("error_glry").innerHTML = 'Please Select Any Gallery ';
                    return false;
                }
                else if(asgallAlbum_name == ""){
                    document.getElementById("error_alb").innerHTML = 'Please Enter the Album ';
                    return false;
                }
          

            });
        });


        function vaildateAlbumFields(){
             alert('error');
             return false;
        var albumName = document.getElementById("asgallAlbum_name").value;
        albumName = albumName.trim();
        if(albumName == ''){
        	 document.getElementById("error_alb_name").innerHTML = 'Please Enter the Album Name ';
        	 document.getElementById("asgallAlbum_name").focus();
        	 return false;
            }
        else{
        	document.getElementById("error_alb_name").innerHTML = '';
            }
        return true;
            
     }
    </script>

         <h3 style="float:left;width:200px;padding-top: 10px">Add New Album</h3>
         <?php
if (isset($_REQUEST['asgallAlbum_submit']))
        {
            $uploadDir = wp_upload_dir();
            $path = $uploadDir['basedir'].'/apptha-slider-gallery';
            $asgallAlbum_name        = filter_input(INPUT_POST, 'asgallAlbum_name');
            $asgallAlbum_description = filter_input(INPUT_POST, 'asgallAlbum_description');
            $current_image        = $_FILES['asgallAlbum_image']['name'];
            $macGallery_id =  1;
           // filter_input(INPUT_POST, 'macGallery_name');
            $get_albname =  $wpdb->get_var("SELECT asgallAlbum_name FROM " . $wpdb->prefix . "asgallalbum WHERE asgallAlbum_name like '%$asgallAlbum_name%'");
            
            if(!$get_albname)
            {
        
            $sql = $wpdb->query("INSERT INTO " . $wpdb->prefix . "asgallalbum
                    (`asgallAlbum_name`, `asgallAlbum_description`,`asgallAlbum_image`,`asgallAlbum_status`,`asgallAlbum_date`,`asgallGallery_id`,`is_delete`) VALUES
                    ('$asgallAlbum_name', '$asgallAlbum_description', '','ON',NOW(),$macGallery_id, 0 )");
    
            }
            else
            {
                echo "<script> alert('Album name already exist');</script>";
            }
   }
  
$options = get_option('get_wpappslider_key');
if ( !is_array($options) )
{
  $options = array('title'=>'', 'show'=>'', 'excerpt'=>'','exclude'=>'');
}
if(isset($_POST['submit_license']))
    {
       $options['title'] = strip_tags(stripslashes($_POST['get_license']));

       update_option('get_wpappslider_key', $options);
    }

         if($get_title['title'] != $get_key)
        {
        ?>
    <p><a href="#mydiv" rel="facebox"><img src="<?php echo $site_url . '/wp-content/plugins/'.$folder.'/images/licence.png'?>" align="right"></a>
 <a href="http://www.apptha.com/shop/checkout/cart/add/product/69" target="_blank"><img src="<?php echo $site_url . '/wp-content/plugins/'.$folder.'/images/buynow.png'?>" align="right" style="padding-right:5px;"></a>
</p>

<div id="mydiv" style="display:none;width:500px;background:#fff;">
<form method="POST" action=""  onSubmit="return validateKey()">
    <h2 align="center">License Key</h2>
   <div align="center"><input type="text" name="get_license" id="get_license" size="58" value="" />
   <input type="submit" name="submit_license" id="submit_license" value="Save"/></div>
</form>
</div>
    
<script>
   
    function validateKey()
           {
        	   var Licencevalue = document.getElementById("get_license").value;
                   if(Licencevalue == "" || Licencevalue !="<?php echo $get_key ?>"){
            	   alert('Please enter valid license key');
            	   return false;
        	   }
                   else
                       {
                            alert('Valid License key is entered successfully');
            	           return true;
                       }

           }
</script>
<div id="oops" style="display:none">
<p><strong>Oops! you will not be able to create more than one album with the free version.</strong></p>
<p>However you can play with the default album</p>
<ul>
    <li> - You can add n number of photos to the default album</li>
    <li> - You can rename the default photo album</li>
    <li> - You can use widgets to show the photos from the default album</li>
</ul>
<p>Please purchase the <a href="http://www.apptha.com/category/extension/Wordpress/Mac-Photo-Gallery" target="_blank">license key</a> to use complete features of this plugin.</p>
</div>
<?php } //else { ?>
 <div class="clear"></div>
 <?php if ($msg) {
 ?>
            <div  class="updated below-h2">
                <p><?php echo $msg; ?></p>
            </div>
<?php } ?>
 <div name="form_album" name="left_content" class="left_column">
            <form name="asgallAlbum" method="POST" id="asgallAlbum" enctype="multipart/form-data"  ><div class="form-wrap">

                    <div class="form-asgallAlbum">
                        <label for="asgallAlbum_name">Album Name</label>
                        <input name="asgallAlbum_name" id="asgallAlbum_name" type="text" value="" size="40" aria-required="true" />
                        <div id="error_alb_name" style="color:red"></div>
                        <p><?php _e('The album name is how it appears on your site.'); ?></p>
                        
                    </div>

                    <div class="form-asgallAlbum">
                        <label for="asgallAlbum_description">Album Description</label>
                        <textarea name="asgallAlbum_description" id="asgallAlbum_description" rows="5" cols="30"></textarea>
                        <p><?php _e('The description is for the album.'); ?></p>
                    </div>
                    <!-- Gallery functionality written by Ishak -->
                 <!--    <div class="form-asgallAlbum">
                    <label for="asgallAlbum_image">Select Gallery</label>


						<select name="macGallery_name" id="macGallery_name">
							<option value="0">-- Select Gallery Here --</option>

							<?php
							$albRst = $wpdb->get_results("SELECT * FROM  " . $wpdb->prefix . "asgallgallery");
							foreach ($albRst as $albRsts) {
							?>
							<option value="<?php echo $albRsts->macGallery_id; ?>"><?php echo $albRsts->macGallery_name; ?></option>

							<?php
							}
							?>
						</select>

                    <p><?php _e('Select any gallery for the album.'); ?></p>
                    <div id="error_glry" style="color:red"></div>
                </div>
				 -->
    <!--  <p class="submit"><a href="#oops" rel="oops">
    	<input type="submit" class="button" name="asgallAlbum_submit" id="asgallAlbum_submit" value="<?php echo 'Add new Album'; ?>" /></a>
    </p>
     -->
    
<p class="submit"><input type="submit" onclick="return vaildateAlbumFields1()" class="button" name="asgallAlbum_submit" id="asgallAlbum_submit1" value="<?php echo 'Add new Album'; ?>" /></a></p>

            </div></form>
    </div>
<?php //} ?>
    <div class="right_column">
                       <form name="all_action" id="all_action" action="" method="POST" onSubmit="return deleteAlbums();" ><div class="alignleft actions">
                           <?php //if($get_title['title'] == $get_key) {?>
                        <select name="action_album" id="action_album">
                            <option value="" selected="selected"><?php _e('Bulk Actions'); ?></option>
                            <option value="delete"><?php _e('Delete'); ?></option>
                        </select>
                               <span id="ApplybutErroMsg" style="color: red;" ></span>
                        <input type="submit" value="<?php esc_attr_e('Apply'); ?>" name="doaction_album" id="doaction_album" class="button-secondary action" />
                         <?php //}?>  <?php wp_nonce_field('bulk-tags'); ?>
            </div>

            <div id="bind_asgallAlbum">

               <?php require_once(dirname(__FILE__) . '/asgallalblist.php'); ?>

            </div>
            <script type="text/javascript">
            function vaildateAlbumFields1(){

            	 var albumName = document.getElementById("asgallAlbum_name").value;
                 albumName = albumName.trim();
                 if(albumName == ''){
                	 document.getElementById("asgallAlbum_name").value = '';
                 	 document.getElementById("error_alb_name").innerHTML = 'Please Enter the Album Name ';
                 	 document.getElementById("asgallAlbum_name").focus();
                 	 return false;
                     }
                 else{
                 	document.getElementById("error_alb_name").innerHTML = '';
                     }
                 return true;
                 
             }
				function deleteAlbums(){
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
                                       
					var album_delete= confirm('Are you sure to delete album/s ?');
                                        
						if (album_delete){
                                               return true;
						}
						else{
							return false;
						}
					}
					
				
				</script>
				</form>
    </div>

<?php   }?>