<?php
/*
Plugin Name: Apptha Slider Gallery
Plugin URI: http://www.apptha.com/category/extension/Wordpress/Apptha-Slider-Gallery
Description: Apptha Slider Gallery contains easy shortcodes to insert albums, photos and slider in your blog. Apptha Slider Gallery gives your friends or website visitors the ability to download full-resolution pictures, and  they can  share your photos using  Facebook comments and share.
Version:1.0
Author: Apptha
Author URI: http://www.apptha.com
License: GNU General Public License version 2 or later; see LICENSE.txt
*/

/* The first loading page of the Mac Photo Gallery these contain admin setting too */
require_once("asgallGallery.php"); // Front view of the Mac Photo Gallery

    global $t;
    global $e;
    global $d;

       $t=1;
       $e=1;
       $d=1;
      
function asgall_Slidergallery($content)
 {
    $content = preg_replace_callback('/\[asgall ([^]]*)\y]/i', 'appslider_Render', $content); //Mac Photo Gallery Page
    return $content;
 }

function appslider_Render($content)
 {
    global $wpdb;
    $pageClass = new appslider_gallery();
    $returnGallery = $pageClass->asgalEffectgallery($content);
    return  $returnGallery;
 }
 
function appsliderPage()
 {
add_menu_page('Apptha Slider Gallery', 'Apptha Slider Gallery', '4', 'slideAlbum', 'show_appslideMenu',get_bloginfo('url').'/wp-content/plugins/'.dirname(plugin_basename(__FILE__)).'/images/icon.png');
//add_submenu_page("asgallAlbum", "Mac Gallery", "Galleries",4, "macGallery","show_asgallMenu");
add_submenu_page('slideAlbum', 'Albums', 		'Albums',   4, 'slideAlbum',  'show_appslideMenu');
add_submenu_page('slideAlbum', 'Image upload', 'Upload Photos', 'manage_options', 'slidePhotos', 'show_appslideMenu');
//add_submenu_page('asgallAlbum', 'Tags', 'Tags', 'manage_options', 'asgalltags', 'show_asgallMenu');
add_submenu_page('slideAlbum', 'Settings', 'Settings', 'manage_options', 'slideSettings', 'show_appslideMenu');
 }
   
    
function show_appslideMenu()
 {
 ?>	 
        <h2 class="nav-tab-wrapper">
        <!--  <a id="asgallGallery" href="?page=asgallGallery" class="nav-tab">Gallery</a>  -->
        <a id="slideAlbum"  href="?page=slideAlbum" class="nav-tab">Albums</a>
        <a id="slidePhotos" href="?page=slidePhotos&albid=0" class="nav-tab">
       <?php  if($_GET['action']== 'viewPhotos')
        		echo 'View Photos';	
        	  else 
        	  	echo 'Upload Photos';
        ?>
        </a>
       <!--  <a id="asgalltags"   href="?page=asgalltags" class="nav-tab">Tags</a> -->
        <a id="slideSettings" href="?page=slideSettings" class="nav-tab">Settings</a></h2>
        
        
         <div style="background-color:#ECECEC;padding: 10px;margin-top:10px;border: #ccc 1px solid">
         <strong> Note : </strong>Apptha Slider Gallery can be easily inserted to the Post / Page by adding the following code :<br><br>
                 (i)   <strong>[asgall]</strong>  - Use this code to show entire gallery, use only once in a page/post.<br>
                 (ii)   <strong> [asgall albid=1]</strong> - Use this code to display photos from particular album [Here '1' is the AlbumId]<br>
                 (iii) <strong> [asgall type=popular]</strong> - Use this code to display slider without albums, the photos are sorted based on type[Two other types are  <strong> type=recent </strong>  or  <strong> type=featured </strong> ] , use only once in particular page/post.
         </div>
   
            <script type="text/javascript">
          	  document.getElementById("<?php echo $_GET['page']; ?>").className = 'nav-tab nav-tab-active';
			</script>
	<?php 		       
    switch ($_GET['page'])
    {
        case 'slideAlbum' :
            include_once (dirname(__FILE__) . '/admin/asgallAlbum.php'); // admin functions
            $macManage = new macManage();
            break;
        case 'slidePhotos' :
            include_once (dirname(__FILE__) . '/admin/asgallPhotos.php'); // admin functions
            $macPhotos = new macPhotos();
            break;
        case 'slideSettings' :
            include_once (dirname(__FILE__) . '/asgallSlider.php'); // admin functions
            asgallSettings();
            break;
        case 'asgalltags' :
	    include_once (dirname(__FILE__) . '/admin/asgallTags.php'); // admin functions
            break;
            
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


// Admin Setting For Mac Photo Gallery

function asgall_get_domain($url)
    {
      $pieces = parse_url($url);
      $domain = isset($pieces['host']) ? $pieces['host'] : '';
      if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
        return $regs['domain'];
      }
      return false;
    }
    

function asgallSettings() {
            global $wpdb;
            $folder   = dirname(plugin_basename(__FILE__));
            $site_url = get_bloginfo('url');
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

?>
    <script>
     function checkIsNumber(evt) {   // settings textbox numbers validation
        evt = (evt) ? evt : window.event
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {

             status = "This field accepts numbers only."
            return false
        }

        status = ""
        return true
    }
    function checkIsEmpty(getid){

    	  var textboxval = document.getElementById(getid).value;
    	  textboxval = textboxval.trim();
    	  var isshow ;
    	 var notSubmit = 1;
    	  if(textboxval == '' ){

    		  		isshow = 'block';
    		  		document.getElementById('picaformnotSumit').value = notSubmit;
    		  		 document.getElementById(getid+'-error-msg').style.display = isshow;
    		  		 document.getElementById(getid).focus();
    		  		return false;
    	  }
    	  else if(textboxval == 0 ){

		  		isshow = 'block';
		  		document.getElementById('picaformnotSumit').value = notSubmit;
		  		 document.getElementById(getid+'-error-msg').style.display = isshow;
		  		 document.getElementById(getid+'-error-msg').value = '';
		  		 document.getElementById(getid).focus();
		  		document.getElementById(getid+'-error-msg').innerHTML = 'Please Enter >0';
		  		return false;
	  }
    	  else{
        	  		isshow = 'none';
        	  		notSubmit = 0;
        	  		document.getElementById('picaformnotSumit').value = notSubmit;
        	  		document.getElementById(getid+'-error-msg').style.display = isshow;
       	  }

    }
 
       function mac_settings_validation()
       {
                // Made it a local variable by using "var"
           var issubmit = parseInt(document.getElementById('picaformnotSumit').value);
           if(issubmit){
							return false;
            }
           else
               	return true;


       }
           function validateKey()
           {
        	   var Licencevalue = document.getElementById("get_license").value;
        	   if(Licencevalue == ""||Licencevalue !="<?php echo $get_key ?>"){
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
    <link rel="stylesheet" href="<?php echo $site_url . '/wp-content/plugins/' . dirname(plugin_basename(__FILE__)) . '/css/style.css'; ?>">
    <script src="<?php echo $site_url . '/wp-content/plugins/'.$folder.'/js/macGallery.js'; ?>" type="text/javascript"></script>
      <?php
 
$isupdated = 0;
  if(isset($_REQUEST['asgallSet_upt']))            //  isset($_REQUEST['asgallSet_upt']) saving settings tab values after click on update button
  {
    $settingColumns =  $wpdb->get_results('SHOW COLUMNS  FROM '. $wpdb->prefix . 'asgall_settings_menu');
     $settingColumns = array('sno',   'asgall-slide-photo-width',   'asgall-slide-photo-height',   'asgall-alb-cols',     'asgall-alb-rows',     'asgall-alb-photo-width',     'asgall-alb-photo-Height',     'asgall-alb-vspace',     'asgall-alb-hspace',     'asgall-general-share-pho',      'asgall-general-download',         'asgall_facebook_api',     'asgall-photo-tumb-w',     'asgall-photo-tumb-h',     'asgall-photo-gene-w',     'asgall-photo-gene-h','asgall-slider','asgall-slider-type');
     $uploaddata = array();
     for( $i = 0 ; $i < count($settingColumns) ; $i++ ){
	    	
	    $uploaddata[$settingColumns[$i]] = trim($_REQUEST[$settingColumns[$i]]);
      		
      }
      $uploaddata['sno'] = 1;  
      $tableName = $wpdb->prefix."asgall_settings_menu";
      $wpdb->update( $tableName , $uploaddata , array( 'sno' => 1)  );
	  $msg ='Updated Successfully';
	 
  }
   if( isset($_POST['Photos_Resize'] ))      //resize the images  isset($_POST['asgallSet_upt_gener'] )
  {
  
  	 $tablename = $wpdb->prefix."asgall_settings_menu";
  	
  	 $settingValues =  $wpdb->get_results("SELECT  *   FROM $tablename " ,ARRAY_A );
  	 // echo "<pre>";print_r($settingValues);echo "<pre>";
  	
  	 
  	 $colNames = array('asgall-slide-photo-width','asgall-slide-photo-height','asgall-alb-photo-width','asgall-alb-photo-Height','asgall-photo-tumb-w','asgall-photo-tumb-h','asgall-photo-gene-w','asgall-photo-gene-h');
  	 
 	 $numOfTimes = count($colNames);
  	 $findValues = array();
  	 $updateintable = array();  // use to update in table
  	 for($i = 0 ; $i < $numOfTimes ; $i++ )
  	 {		
  	 	  // echo $i.'***** '.$settingValues[0][$colNames[$i]]	.'=='.  $_REQUEST[$colNames[$i]]."<br/>";
  	 	$isstore =  $settingValues[0][$colNames[$i]] - $_REQUEST[$colNames[$i]]."<br/>"; ;
  	 	     $isstore = intval($isstore);
  	 		 if($isstore){
  	 		 	
  	 			$updateintable[$colNames[$i]] = $_REQUEST[$colNames[$i]] ;
  	 		 	$findValues[] = $i;
  	 		 	 
  	 		 }
  	 		 	
  	 }
  	  $tableName = $wpdb->prefix."asgall_settings_menu";
      $wpdb->update( $tableName , $updateintable , array( 'sno' => 1)  );
     
  	    // echo "<pre>";  print_r($_REQUEST); echo "</pre>"; 
  	 	// echo "<pre>";  print_r($updateintable); echo "</pre>";
  	 	
  	
   //	echo "<pre>";  print_r($findValues); echo "</pre>";
   
  	   $c = count($findValues);
  	 
  	   
  	 if($c)
  	 {	sort($findValues);
  	 	$changeColNames = array();
  	 	
  	 	for($j = 0 ; $j < $c ; $j++ )
  	 	{
  	 		
  	 		$changeColNames[] = $colNames[$findValues[$j]];
  	 		//$updateintable[$colNames[$findValues[$j]]] = $_REQUEST[$colNames[$j]] ;
  	 	
  	 	}
  	 	
  	
     $allPhotsData = array();	
  	 	for ($i = 0 ; $i< $c ; $i++)
  	 	{   
  	 		 $value = intval($findValues[$i]);  
  	 		 
  	 		
  	 		 if($value % 2 == 0){   // if changed value start with even then  
  	 			
  	 			if(in_array($value+1 , $findValues)){   // if he change same photo W & H 
  	 				
	  	 			$colW = $_REQUEST[$colNames[$value]];  //taking W value
	  	 			$colH = $_REQUEST[$colNames[$value+1]]; // Taking HEIGHT VALU
	  	 			
	  	 			$allPhotsData[$i] = array('name' => $changeColNames[$i], 'width' => $colW , 'height' => $colH);
	  	 			$i++; 	//deleting height value
  	 			}
  	 			else{   // if he chane only Height 
  	 				$colW = $_REQUEST[$colNames[$value]];
  	 				$colH =  $settingValues[0][$colNames[$value+1]];
  	 				$allPhotsData[$i] = array('name' => $changeColNames[$i], 'width' => $colW , 'height' => $colH);
  	 				
  	 			}
  	 		}
  	 		else{  			// if changed value is odd then 
  	 			
  	 			if(in_array( ($value-1) , $findValues)){
  	 				
	  	 			$colW = $_REQUEST[$colNames[$value-1]];
	  	 			$colH = $_REQUEST[$colNames[$value]];
	  	 			$allPhotsData[$i] = array('name' => $changeColNames[$i], 'width' => $colW , 'height' => $colH);
	  	 			
  	 			}
  	 			else{   $colW =  $settingValues[0][$colNames[$value-1]]; 
  	 					$colH = $_REQUEST[$colNames[$value]];
  	 					$allPhotsData[$i] = array('name' => $changeColNames[$i], 'width' => $colW , 'height' => $colH);
  	 					
  	 			}
  	 			
  	 		}
  	 	
  	 	}//for end
  	 	
  	 }//if end	
  
  	//echo "<pre>"; print_r($allPhotsData);	echo "<pre>";
  	    
  echo "<input type='hidden' value='$site_url' name ='mysiteurl' id='mysiteurl' />  ";
  echo "<input type='hidden' value='$folder' name ='pliginfoulder' id='pliginfoulder' />  ";
  if(is_array($allPhotsData))
  {
 	foreach($allPhotsData as $key => $values){
 	 
  	 echo "<script type='text/javascript'>
  	 photos_regenerate('photoResize','$values[name]', '$values[width]' ,'$values[height]' );
  	 </script>";
  
 	}
  }  	 
 
     
   }// IF END FOR RESIZE THUMBNILS

   $viewSetting = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "asgall_settings_menu" , ARRAY_A);
   

  	        if($get_title['title'] != $get_key)
        {
        ?>
<script>
var url = '<?php echo $site_url; ?>';
</script>
<link href="<?php echo $site_url . '/wp-content/plugins/'.$folder.'/css/facebox_admin.css';?>" media="screen" rel="stylesheet" type="text/css" />
<script src="<?php echo $site_url . '/wp-content/plugins/'.$folder.'/js/facebox_admin.js'; ?>" type="text/javascript"></script>
<script src="<?php echo $site_url . '/wp-content/plugins/'.$folder.'/js/macGallery.js'; ?>" type="text/javascript"></script>

<script type="text/javascript">
 var apptha = jQuery.noConflict();
    apptha(document).ready(function(apptha) {
      apptha('a[rel*=facebox]').facebox()
    })
</script>
 <div style="padding:20px 0px 40px 0px;"><a href="#mydiv" rel="facebox"><img src="<?php echo $site_url . '/wp-content/plugins/'.$folder.'/images/licence.png'?>" align="right"></a>
 <a href="http://www.apptha.com/shop/checkout/cart/add/product/69" target="_blank"><img src="<?php echo $site_url . '/wp-content/plugins/'.$folder.'/images/buynow.png'?>" align="right" style="padding-right:5px;"></a>
</div>

<div id="mydiv" style="display:none">
<form method="POST" action="" onSubmit="return validateKey()">
    <h2 align="center">License Key</h2>
   <div align="right"><input type="text" name="get_license" id="get_license" size="58" />
   <input type="submit" name="submit_license" id="submit_license" value="Save" /></div>
</form>
</div>
<?php } ?>
  		
  <?php if ($msg) {
 ?>
            <div  class="updated below-h2" style="background-color: lightYellow;border-color: #E6DB55;float: left;margin: 1% 0px;width: 98%;" >
                <p><?php echo $msg; ?></p>
            </div>
<?php } ?>
		<div class="clear"></div>
	
        <form name="macSet" method="POST" onsubmit="return mac_settings_validation();" action="">
        <input type="hidden" value="" id="picaformnotSumit" name="picaformnotSumit" />

            <div class="macSettings">
                <div align="right">
                  <span style="display: block;">
                       <input style="margin-right: 35px;" class='button-primary' name='Photos_Resize' id='Photos_Resize' type='submit' value='Photos Resize' />
               
                      <input style="margin-right: 35px;" class='button-primary' name='asgallSet_upt' id='asgallSet_upt' type='submit' value='Update' />
                        </span>
                  <span style="text-align: right; float: right; display: block;">
                      <input readonly="readonly" size="50" style="margin-right: 30px;display:none; background-color: white; border:none; margin-top:10px;color: green;;" name='PhotosResizeMsg' id='PhotosResizeMsg' type="text" value='Click Here to Photos Resize' onclick="showphotosreziemes()" />
                  </span>
                </div>
                <div class="clear"></div>
                <table style="margin-right: 10px;">

                        <caption class="header"><?php _e('Albums Settings','apptha'); ?> </caption>

                    <tr>
                        <td><span>No of Columns</span></td>
                        <td><input type="text" name="asgall-alb-cols" id="asgall-alb-cols" onblur="checkIsEmpty('asgall-alb-cols')" onKeyPress="return checkIsNumber(event)"  value="<?php echo $viewSetting['asgall-alb-cols']; ?>">
                         <span style="display: none;color: red;"   id="asgall-alb-cols-error-msg" >Please Enter Col Value </span>
                        </td>
                         

                    </tr>
                    <tr>
                        <td><span>No of Rows</span></td>
                        <td><input type="text" name="asgall-alb-rows" id="asgall-alb-rows" onblur="checkIsEmpty('asgall-alb-rows')" onKeyPress="return checkIsNumber(event)" value="<?php echo $viewSetting['asgall-alb-rows']; ?>">
                        <span style="display: none;color: red;"   id="asgall-alb-rows-error-msg" >Please Enter Row Value </span>
                        </td>
                   </tr>
                   
                    <tr>
                        <td><span>Slider</span></td>
                      <td> <input type="radio" value="0" name="asgall-slider" id="asgall-slider"   <?php if($viewSetting['asgall-slider'] == '0')  { echo 'checked="checked" '; }  ?> /> Enable &nbsp;&nbsp; 
                       <input type="radio"  value="1" name="asgall-slider" id="asgall-slider"   <?php if($viewSetting['asgall-slider'] == '1')  { echo 'checked="checked" '; } ?> /> Disable </br>
                      </td>
                   </tr>
                    <tr>
                        <td><span>Slider Image Order</span></td>
                    <td> <input type="radio" value="0" name="asgall-slider-type" id="asgall-slider-type"   <?php if($viewSetting['asgall-slider-type'] == '0')  { echo 'checked="checked" '; }  ?> /> Popular 
                     <input type="radio"  value="1" name="asgall-slider-type" id="asgall-slider-type"   <?php if($viewSetting['asgall-slider-type'] == '1')  { echo 'checked="checked" '; } ?> /> Recent
                      <input type="radio" value="2" name="asgall-slider-type" id="asgall-slider-type"   <?php if($viewSetting['asgall-slider-type'] == '2')  { echo 'checked="checked" '; }  ?> /> Featured
                       </td>
                   </tr>
                   
                   
                   <tr>
                     		<td><span>Size Of Photo</span></td>
                        <td > 
                            Width&nbsp;
                        <input type="text"  onfocus="showClickMessage(id)"  name="asgall-alb-photo-width" id="asgall-alb-photo-width" size="3" maxlength="3"  onblur="checkIsEmpty('asgall-alb-photo-width')" onKeyPress="return checkIsNumber(event)"  value="<?php echo $viewSetting['asgall-alb-photo-width'];  ?>" >px  	&nbsp;&nbsp;Height&nbsp;&nbsp;
                         <span style="display: none;color: red;"   id="asgall-alb-photo-width-error-msg" >Please Enter Width </span>

       			<input type="text" onfocus="showClickMessage(id)"  name="asgall-alb-photo-Height" id="asgall-alb-photo-Height" size="3" maxlength="3"  onblur="checkIsEmpty('asgall-alb-photo-Height')" onKeyPress="return checkIsNumber(event)"   value="<?php echo $viewSetting['asgall-alb-photo-Height'];  ?>" >px
                         <span style="display: none;color: red;"   id="asgall-alb-photo-Height-error-msg" >Please Enter Height </span>

                        </td>
                        
                    </tr>
                    <tr>
                     	<td><span>Vertical Space</span></td>
                        <td > 
                            <input type="text"  id="asgall-alb-vspace" name="asgall-alb-vspace" onblur="checkIsEmpty('asgall-alb-vspace')" onKeyPress="return checkIsNumber(event)" maxlength="3" value="<?php echo $viewSetting['asgall-alb-vspace'];  ?>" >px
       				<span style="display: none;color: red;"   id="asgall-alb-vspace-error-msg" >Please Enter Vspace </span>
                        </td>
                        
                    </tr>
                    <tr>
                     		<td><span>Horizontal  Space</span></td>
	                        <td> 
	                            <input type="text"  name="asgall-alb-hspace" id="asgall-alb-hspace"  onblur="checkIsEmpty('asgall-alb-hspace')" onKeyPress="return checkIsNumber(event)" maxlength="3"  value="<?php echo $viewSetting['asgall-alb-hspace'];  ?>" >px
                                    <span style="display: none;color: red;"   id="asgall-alb-hspace-error-msg" >Please Enter Hspace </span>
	                        </td>
                    </tr>
                </table>

 <table style="margin-right: 10px;">

             <caption class="header"><?php _e('Slider Settings','apptha'); ?> </caption>
                    <tr>
                     	<td><span>Size Of Photo</span></td>
                        <td > 
                         Width&nbsp;<input type="text"  onfocus="showClickMessage(id)" name="asgall-slide-photo-width" id="asgall-slide-photo-width" size="3" onblur="checkIsEmpty('asgall-slide-photo-width')" onKeyPress="return checkIsNumber(event)" maxlength="3" value="<?php echo $viewSetting['asgall-slide-photo-width'];  ?>">px
                            <span style="display: none;color: red;"   id="asgall-slide-photo-width-error-msg" >Please Enter Width </span>
       			 &nbsp;&nbsp;Height&nbsp;&nbsp;<input onfocus="showClickMessage(id)" type="text" id="asgall-slide-photo-height" name="asgall-slide-photo-height" size="3" onblur="checkIsEmpty('asgall-slide-photo-height')" onKeyPress="return checkIsNumber(event)" maxlength="3"  value="<?php echo $viewSetting['asgall-slide-photo-height'];  ?>" >px
                            <span style="display: none;color: red;"   id="asgall-slide-photo-height-error-msg" >Please Enter Height </span>
                        </td>
                        
                    </tr>
                   
                  </table>
           <!--      <table>
                    
                        <caption>Tags Settings</caption>
                   
  					<tr>
                        <td><span>No of Columns</span></td>
                        <td><input type="text" name="tag-col-number" id="asgallrow" value="<?php echo $viewSetting->asgallrow; ?>"></td>
                    </tr>
                    <tr>
                        <td><span>No of Rows</span></td>
                        <td><input type="text" name="asgallimg_page" id="asgallimg_page" value="<?php echo $viewSetting->asgallimg_page; ?>"></td>
                    </tr> 
                    <tr>
                        <td><span>Text-align </span></td>
                        <td>
                               <select name="tags-text-align" id="tags-text-align">
                               			<option>right </option>
                               			<option>left </option>
                               			<option>center </option>
                               			<option>justify </option>
                               			
                               </select>
                        </td>
                    </tr>                        

                    <tr>
                        <td><span>Font-size: </span></td>
                        <td>
                        	<select>
                        	 <?php  for($i = 9 ; $i <17 ; $i++) { ?>
                        			<option id="<?php echo $i; ?>" ><?php echo $i; ?></option>
                        			
                        	<?php   } ?>		
                        	
                        	</select>px
                        
                        </td>
                    </tr>
                    <tr>
                        <td><span>Text-decoration</span></td>
                        <td><select name="asgallDir">
                                <option <?php  if ($viewSetting->macDir == '1') { echo 'selected="selected"'; } ?> value="1" > Underline</option>
                                <option <?php if ($viewSetting->asgallDir == '0') { echo 'selected="selected"';  } ?>value="0">None</option>
                        </select></td>
                    </tr>
                     

                </table>
          -->       
                <table>
                    
                        <caption>General Settings</caption>
                    <tr>
                    	<td><span>Share Photos</span></td>
                        <td>	<?php $flag = 1; ?>
                        		<input type="radio" value="1" name="asgall-general-share-pho" id="asgall-general-share-pho"   <?php if($viewSetting['asgall-general-share-pho'])  { echo 'checked="checked" '; $flag = 0;}  ?> /> Enable &nbsp;&nbsp; 
                        		
                        		<input type="radio"  value="0" name="asgall-general-share-pho" id="asgall-general-share-pho"   <?php if($flag)  { echo 'checked="checked" '; } ?> /> Disable 
                        </td>
                    </tr> 
                    <!-- <tr>
                    	<td><span>Face Book comments </span></td>
                        <td>	<?php //$flag = 1; ?>
                        		<input type="radio"  value="1" name="asgall-general-fac-com" id="asgall-general-fac-com"     <?php //if($viewSetting['asgall-general-fac-com'])  { echo 'checked="checked" '; $flag = 0;}  ?> /> Enable &nbsp;&nbsp;
                        		
                        		<input type="radio" value="0" name="asgall-general-fac-com" id="asgall-general-fac-com"     <?php //if($flag)  { echo 'checked="checked" '; } ?>   /> Disable
                        </td>
                    </tr>  -->
                     
  					<tr>
                        <td><span>Download</span></td>
                        <td>	<?php $flag = 1; ?>
                        		<input type="radio"   value="1" name="asgall-general-download" id="asgall-general-download"     <?php if($viewSetting['asgall-general-download'])  { echo 'checked="checked" '; $flag = 0;}  ?> /> Enable &nbsp;&nbsp; 
                        		
                        		<input type="radio"  value="0" name="asgall-general-download" id="asgall-general-download"       <?php if($flag)  { echo 'checked="checked" '; } ?>  /> Disable 
                        </td>
                    </tr>
                    <!--  <tr>
                        <td><span>Show Albums in Slider Page ?</span></td>
                        <td>	<?php //$flag = 1; ?>
                        		<input type="radio" value="1" name="asgall-general-show-alb" id="asgall-general-show-alb"   <?php //if($viewSetting['asgall-general-show-alb'])  { echo 'checked="checked" '; $flag = 0;}  ?>  /> Enable &nbsp;&nbsp; 
                        		
                        		<input type="radio" value="0" name="asgall-general-show-alb" id="asgall-general-show-alb"   <?php //if($flag)  { echo 'checked="checked" '; } ?>  /> Disable 
                        </td>
                    </tr>  -->
                  <!--    <tr>
                        <td><span>Show Tags</span></td>
                        <td>
                        		<input type="radio" name="asgall-general-download" id="asgall-general-download"  /> Enable &nbsp;&nbsp; 
                        		
                        		<input type="radio" name="mac-general-download" id="mac-general-download"  /> Disable 
                        </td>
                    </tr>
                   --> 
                     <tr>
                        <td><span> Facebook API Id</span></td>
                        <td><input type="text" name="asgall_facebook_api" id="asgall_facebook_api" value="<?php echo $viewSetting['asgall_facebook_api']; ?>"><br />
                            <div style="font-size:8pt">To create new ID, <a href="https://developers.facebook.com/apps" target="_blank">Facebook App</a></div>
                            
                        </td>
                   
                     </tr>

                </table>
                 <table>
                    
                        <caption>Photo Settings</caption>
	                    <tr>
	                    	<td><span>Generate Thumbnails Size</span></td>
	                       
	                        <td > 
	                            Width&nbsp;<input type="text"  onfocus="showClickMessage(id)"  name="asgall-photo-tumb-w" id="asgall-photo-tumb-w" size="3" maxlength="3" onblur="checkIsEmpty('asgall-photo-tumb-w')" onKeyPress="return checkIsNumber(event)" value="<?php echo $viewSetting['asgall-photo-tumb-w'];  ?>"  >px
                                    <span style="display: none;color: red;"   id="asgall-photo-tumb-w-error-msg" >Please Enter Width </span>
	       			    &nbsp;&nbsp;Height&nbsp;&nbsp;<input onfocus="showClickMessage(id)"  type="text"  name="asgall-photo-tumb-h" id="asgall-photo-tumb-h" size="3" maxlength="3"  onblur="checkIsEmpty('asgall-photo-tumb-h')" onKeyPress="return checkIsNumber(event)" value="<?php echo $viewSetting['asgall-photo-tumb-h'];  ?>"  >px
                                    <span style="display: none;color: red;"   id="asgall-photo-tumb-h-error-msg" >Please Enter Height </span>
	                        </td>
	                         
	                    </tr> 
	                    <tr>
	                    	<td><span>Single Photo View Stage Size</span></td>
	                       
	                        <td > 
	                            Width&nbsp;<input type="text"  onfocus="showClickMessage(id)"  name="asgall-photo-gene-w" id="asgall-photo-gene-w" size="3" maxlength="4" onblur="checkIsEmpty('asgall-photo-gene-w')" onKeyPress="return checkIsNumber(event)" value="<?php echo $viewSetting['asgall-photo-gene-w'];  ?>"  >px
                                     <span style="display: none;color: red;"   id="asgall-photo-gene-w-error-msg" >Please Enter Width </span>
	       			   &nbsp;&nbsp;Height&nbsp;&nbsp;<input onfocus="showClickMessage(id)"  type="text"  id="asgall-photo-gene-h" name="asgall-photo-gene-h" size="3" onblur="checkIsEmpty('asgall-photo-gene-h')" onKeyPress="return checkIsNumber(event)" maxlength="4"   value="<?php echo $viewSetting['asgall-photo-gene-h'];  ?>"  >px
                                    <span style="display: none;color: red;"   id="asgall-photo-gene-h-error-msg" >Please Enter Height </span>
	                        </td>
	                         
	                    </tr> 
                   </table>
                
                


               
                <div align="right"> <p class='submit'><input style="margin-right: 32px;" class='button-primary' name='asgallSet_upt' id='asgallSet_upt' type='submit' value='Update'></p></div>
            </div>
        </form>
   
<?php

}


//End of Album Setting page
 function asgall_loadsettings_values() {
 global $wpdb;

 $insertDefault = $wpdb->query("INSERT INTO " . $wpdb->prefix . "asgallalbum (`asgallAlbum_id`, `asgallAlbum_name`, `asgallAlbum_description`, `asgallAlbum_image`, `asgallAlbum_status`, `asgallAlbum_date`,`asgallGallery_id`,`is_delete`) VALUES
 (1, 'First Album', 'This is my first album ', '', 'ON', NOW(), 1, 0)");
 $insertGalleryDefault = $wpdb->query("INSERT INTO " . $wpdb->prefix . "asgallgallery (`asgallGallery_id`, `asgallGallery_name`, `asgallGallery_status`) VALUES
 (1, 'Default Gallery', 'ON')");
                        }

 $lookupObj = array();
 $chars_str;
 $chars_array = array();

function asgall_macgal_generate($domain)
{
$code=asgall_macgal_encrypt($domain);
$code = substr($code,0,25)."CONTUS";
return $code;
}

 // Include the respective page based of the page request in url
  function encrypt() {
        $iv = iv();
        $encryptKey = get_option('EncriptionKey');
         $data = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, 'appthaslider', 'Powered By <a href="http://www.apptha.com/" target="_blank">Apptha</a>', MCRYPT_MODE_ECB, $iv);
         return base64_encode($data);
     }
 
      function iv() {
         $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
         $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
         return $iv;
     }

     
 function apiKey_asgall() {
 $const = "+fKIAPT7CCcFHvkVYoXS5J8SQ3KKhLIybStOQZIumfexdp5FUHcL2x+wtCgrR9S7yPgE6B2r0x3wnvNXrBRqtj588gTqu17cYHkDyuSPZPM=";
    	   $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    	  $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    	       $const = base64_decode($const);
    	       if (conf__PHSHOP_MACDOC_EXTENSION != 1)
    	         $val =  mcrypt_decrypt(MCRYPT_RIJNDAEL_128, "appthaslider", $const, MCRYPT_MODE_ECB, $iv);
    	       return $val;
    	      
    	   }
function asgall_macgal_encrypt($tkey) {

$message =  "EW-ASGMP0EFIL9XEV8YZAL7KCIUQ6NI5OREH4TSEB3TSRIF2SI1ROTAIDALG-JW";

	for($i=0;$i<strlen($tkey);$i++){
$key_array[]=$tkey[$i];
}
	$enc_message = "";
	$kPos = 0;
        $chars_str =  "WJ-GLADIATOR1IS2FIRST3BEST4HERO5IN6QUICK7LAZY8VEX9LIFEMP0";
	for($i=0;$i<strlen($chars_str);$i++){
$chars_array[]=$chars_str[$i];
}
	for ($i = 0; $i<strlen($message); $i++) {
		$char=substr($message, $i, 1);

		$offset = asgall_macgal_getOffset($key_array[$kPos], $char);
		$enc_message .= $chars_array[$offset];
		$kPos++;
		if ($kPos>=count($key_array)) {
			$kPos = 0;
		}
	}

	return $enc_message;
}
function asgall_macgal_getOffset($start, $end) {

    $chars_str =  "WJ-GLADIATOR1IS2FIRST3BEST4HERO5IN6QUICK7LAZY8VEX9LIFEMP0";
	for($i=0;$i<strlen($chars_str);$i++){
$chars_array[]=$chars_str[$i];
}

	for ($i=count($chars_array)-1;$i>=0;$i--) {
		$lookupObj[ord($chars_array[$i])] = $i;

	}

	$sNum = $lookupObj[ord($start)];
	$eNum = $lookupObj[ord($end)];

	$offset = $eNum-$sNum;

	if ($offset<0) {
		$offset = count($chars_array)+($offset);
	}

	return $offset;
}
  /* Function to invoke install player plugin */

                        function asgall_macGallery_installFile()
                        {

                            require_once(dirname(__FILE__) . '/asgallInstall.php');
                            asgallGallery_install();
                        }

                        /* Function to uninstall player plugin */

                        function appslider_deinstall()
                        {
                            global $wpdb, $wp_version;
                            $table_appgallSettings = $wpdb->prefix . 'asgall_settings_menu';
                            $table_appgallAlbum = $wpdb->prefix . 'asgallalbum';
                            $table_appgallPhotos = $wpdb->prefix . 'asgallphotos';
                            $table_appgallGallery = $wpdb->prefix . 'asgallgallery';
                             $wpdb->query("DROP TABLE IF EXISTS `" . $table_appgallSettings . "`");
                             $wpdb->query("DROP TABLE IF EXISTS `" . $table_appgallAlbum . "`");
                             $wpdb->query("DROP TABLE IF EXISTS `" . $table_appgallPhotos . "`");
                             $wpdb->query("DROP TABLE IF EXISTS `" . $table_appgallGallery . "`");
                             $uploadDir = wp_upload_dir();
		$path = $uploadDir['basedir'].'/apptha-slider-gallery/';
		if(is_dir($path)){
		chmod($path , 0777);
		$photos =  opendir($path);

		while($content = readdir($photos)  )
		{
		if($content != '.' && $content != '..') {

		$deleteis = $path.$content;
		unlink($deleteis);
		}
		}

		 }
}

                        /* Function to activate player plugin */

                        function appslider_activate() {
                            asgall_loadsettings_values();
                            
                             create_asgall_folder();
                        }

                        register_activation_hook(plugin_basename(dirname(__FILE__)) . '/asgallSlider.php', 'asgall_macGallery_installFile');
                        register_activation_hook(__FILE__, 'appslider_activate');
                        register_uninstall_hook(__FILE__, 'appslider_deinstall');

                        /* Function to deactivate player plugin */

                        function appslider_deactivate()
                        {
                             global $wpdb;
                             $wpdb->query("DELETE FROM " . $wpdb->prefix . "posts WHERE post_content='[macGallery]'");
                             $wpdb->query("DELETE FROM " . $wpdb->prefix . "posts WHERE post_content='[macGroup]'");
                        }

                        register_deactivation_hook(__FILE__, 'appslider_deactivate');
                        add_shortcode('asgall', 'appslider_Render');
//gallery group functionality
                        //add_shortcode('macGroup', 'CONTUS_macGalleryRender');
// CONTENT FILTER
                        add_filter('the_content', 'asgall_Slidergallery');

                        //gallery group functionality
                        //add_filter('the_content', 'Macgallerygroup');
// OPTIONS MENU
                        add_action('admin_menu', 'appsliderPage');
    function asgall_setplayerscripts() 
    { 
	$site_url = get_bloginfo('url'); 
	  $folder         = dirname(plugin_basename(__FILE__));          
            ?>
            <!--[if lt IE 7 ]> <html lang="en" class="ie6 ielt7 ielt8 ielt9"> <![endif]-->

<!--[if IE 7 ]>    <html lang="en" class="ie7 ielt8 ielt9"> <![endif]-->

<html lang="en" class="ie8 ielt9">

<!--[if (gte IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
  <link rel="stylesheet" type="text/css" media="all" href="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder; ?>/zoominout/iestyle.css" />
   
  <script type="text/javascript" src="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder; ?>/slider/js/jquery164.js"></script>
  <script type="text/javascript" src="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder; ?>/slider/js/asgall-slider.js"></script>
  <link rel="stylesheet" type="text/css" media="all" href="<?php echo $site_url; ?>/wp-content/plugins/<?php echo $folder; ?>/slider/asgall-slider.css" />
 <script	type="text/javascript">
var jquery = jQuery.noConflict();
jquery(function() {
  var galleries = jquery('.ad-gallery').adGallery();
  galleries[0].settings.effect = 'fade';

  jquery('#toggle-slideshow').click(
    function() {
      galleries[0].slideshow.toggle();
      return false;
    }
  );
  jquery('#toggle-description').click(
    function() {
      if(!galleries[0].settings.description_wrapper) {
        galleries[0].settings.description_wrapper = $('#descriptions');
      } else {
        galleries[0].settings.description_wrapper = false;
      }
      return false;
    }
  );
});
</script>
<?php }
add_action('wp_head', 'asgall_setplayerscripts');
?>
