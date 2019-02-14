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

/* Upload the photos to the album */

class SimpleImage {
   var $image;
   var $image_type;

   function load($filename) {
      $filename = str_replace("%20"," ",$filename);
     
      $image_info = getimagesize($filename);
       $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
        
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
      }
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image,$filename);
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image,$filename);
      }
      if( $permissions != null) {
         chmod($filename,777);
     
      }
   }
   function output($image_type=IMAGETYPE_JPEG) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image);
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image);
      }
   }
   function getWidth() {
   
  		$width = imagesx($this->image);
  		return $width;
   }
   function getHeight() {
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
         $this->resize($width,$height);
   }
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100;
      $this->resize($width,$height);
   }
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;
   }
} // class is end hear

require_once(dirname(dirname(__FILE__)) . '/asgallDirectory.php');
global $wpdb;
$albumId = $_REQUEST['albumId'];
$uploadDir = wp_upload_dir();

$path = $uploadDir['basedir'].'/apptha-slider-gallery';
$uploaddir = "$path/";

function resizeNewThumbniles($width , $height , $k ,$uploaddir){
	
	global  $wpdb;  $image = new SimpleImage();
	
	 $asgall_settings_menuList = $wpdb->get_results(" select asgallPhoto_id , asgallPhoto_tname, asgallPhoto_image  from " . $wpdb->prefix . "asgallphotos WHERE is_delete='0' ORDER BY asgallPhoto_id DESC  ", ARRAY_A);
	 $twidth = $width;
	 $theight = $height;
switch($k){
	  			
	  			case 1 :    $thumbType = '_slider';
	  					break;
	  			case 2 : 	 $thumbType = '_albumthumb';
	  					break;
	  			case 3 :	 $thumbType = '_photothumb'; 
	  					break;
	  			case 4 : 	  $thumbType = '_singlethumb';
	  			 break;
	  		}
		
	foreach($asgall_settings_menuList as $key => $value ){
	$imgname =	$value['asgallPhoto_tname'];// get name of imgage
	$imgexten = $value['asgallPhoto_image'];
	$imgtype = explode('.', $imgexten);   // get type like .jpeg , .png  ...
	  $image_info = $uploaddir.$imgname; // full path of image 
	   $imgid = $value['asgallPhoto_id'];
	   $thumbfile = $imgid.$thumbType.'.'.$imgtype[1];
	// echo  $filePath = $uploaddir . $thumbfile;
	  $filePath =$uploaddir.$thumbfile;
	  
	$filePath = str_replace(" ","%20",$filePath);
	$image->load($image_info);  //sending upload img not any thumbs  for get information ab img
	 $imgW = $image->getWidth();
      $imgH = $image->getHeight();
	      	
	//echo '<script>alert('.$imgW.');</script>';
	 			if($imgW >= $twidth && $imgH >= $theight)
	 			{
	 				 $image->resize($twidth,$theight);
	 			} 
	  			else if($imgW >= $twidth)
		    	{
		    		
		    		$image->resizeToWidth($twidth);
                   
		    	}
		
		       else if( $imgH >= $theight) {
		       		
		       	     $image->resizeToHeight($theight);
                    
		        }  
	 				   
			if (file_exists($filePath)) {
				
		    		unlink( $filePath);  // it delete the prev image in dir
		    	
		    } 
			 $filePath = str_replace("%20"," ",$filePath);
			
			  $image->save($filePath); 
			
			} 
		
	}  // function is end hear
  
  if(isset($_REQUEST['photoThumbGenerate']) )
  {  
  	  $image = new SimpleImage();
  //	print_r($uploadDir);
  $resizetype =  $_REQUEST['photoResize']; 
   $width =  intval($_REQUEST['width']); 
   $height = intval($_REQUEST['height']);

  	 $thumb1 = strrpos($resizetype , "slide" , 0);  //it is for featured images
    $thumb2 = strrpos($resizetype , "alb" , 0);     // it is for album img
 	$thumb3 = strrpos($resizetype , "photo-tumb" , 0);     // it is for photos 
    $thumb4 = strrpos($resizetype , "photo-gene" , 0);    // it is for single photo
   
   	for($k = 1 ; $k< 5 ; $k++ ){
  
   		$thumb = "thumb$k";
   		 
   		if($$thumb)
   		{
   			  	resizeNewThumbniles($width ,$height, $k ,$uploaddir);
   		}
   		
   		
   	}
    echo 'Photo resize success';
  }
   

if($albumId !='')
{

		$file = $uploaddir . basename($_FILES['uploadfile']['name']);
		$size=$_FILES['uploadfile']['size'];
		
		if($size>10485760)
		{
			echo "error file size > 1 MB";
			unlink($_FILES['uploadfile']['tmp_name']);
			exit;
		}
		 
	 $image = new SimpleImage();
     $image->load($_FILES['uploadfile']['tmp_name']);
		   //print_r($_FILES);

 //if(photoThumbGenerate)
if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file) && $albumId !='0')
{
     $macimage = $_FILES['uploadfile']['name'];
     $macname = explode('.',$macimage);
     $storing_macname = addslashes($macname[0]);
     $uploadDb =  $wpdb->query("INSERT INTO " . $wpdb->prefix . "asgallphotos
(`asgallAlbum_id`, `asgallPhoto_tname`, `asgallPhoto_name`, `asgallPhoto_desc`, `asgallPhoto_image`, `asgallPhoto_status`, `asgallPhoto_sorting`, `asgallPhoto_hitcount`, `asgallPhoto_date`) VALUES
($albumId, '$macimage' , '$storing_macname', '', '$macimage', 'ON', 0, 1, NOW())");
       $lastid = $wpdb->insert_id;
       
       $album_image = $wpdb->get_var("select asgallPhoto_image from " . $wpdb->prefix . "asgallphotos WHERE asgallPhoto_id='$lastid'");
 if ( strlen($album_image) < 50 )
       {
       	
       	$filenameext = explode('.',$album_image);	
       }
       else{
       		$kk = strrev($album_image);
       		$filenameext = $album_image_ext = explode('.',$album_image);
     		$filenameext[(int) $filenameextcount - 1] = strrev($album_image_ext[0]);
       	
       }
     
       $filenameextcount = count($filenameext);
       
       $picasettings = $wpdb->get_results(" select * from " . $wpdb->prefix . "asgall_settings_menu ", ARRAY_N);
           
                $bigfile = $lastid . "." . $filenameext[(int) $filenameextcount - 1];
                $path = $uploaddir.$album_image;
                define(contus, "$uploaddir/");
                   // Start of Single Thumb
                    $image->load($_FILES['uploadfile']['tmp_name']);
                $thumbfile = $lastid . "_singlethumb." . $filenameext[(int) $filenameextcount - 1];     // for showing single image with big size
		                 $twidth = $picasettings[0][15];
		                 $theight = $picasettings[0][16];
		                 $imgW = $image->getWidth();
                         $imgH = $image->getHeight();
		    if($imgW >= $twidth || $imgH >= $theight )
		    {

		    	if($imgW >= $imgH && $imgW >= $twidth)
		    	{
		    		 $image->resizeToWidth($twidth);
                     $image->save($uploaddir . $thumbfile);
		    	}
		
		       else if($imgH >= $imgW && $imgH >= $theight) {
		       	     $image->resizeToHeight($theight);
                     $image->save($uploaddir . $thumbfile);
		        }  
		    }
		       else {
		       	     $image->resize($imgW,$imgH);
                     $image->save($uploaddir . $thumbfile);
		            }
                
                 // End of Single Thumb
                 
                 
                     $thumbfile = $lastid . "_slider." . $filenameext[(int) $filenameextcount - 1]; //for feature images in front page
                      $get_file =   $thumbfile;
	                 $twidth = $picasettings[0][1];
	                 $theight = $picasettings[0][2];
	                 $image->load($_FILES['uploadfile']['tmp_name']);
	                 $imgW = $image->getWidth();
                     $imgH = $image->getHeight();
	                
			if($imgW >= $twidth || $imgH >= $theight )
		    {

		    	if($imgW >= $imgH && $imgW >= $twidth)
		    	{
		    		 $image->resizeToWidth($twidth);
                     $image->save($uploaddir . $thumbfile);
		    	}
		
		       else if($imgH >= $imgW && $imgH >= $theight) {
		       	     $image->resizeToHeight($theight);
                     $image->save($uploaddir . $thumbfile);
		        }  
		    }
		       else {
		       	     $image->resize($imgW,$imgH);
                     $image->save($uploaddir . $thumbfile);
		            }
               
                // End of Slider Big image
                   $image->load($_FILES['uploadfile']['tmp_name']);
            	 $thumbfile = $lastid . "_albumthumb." . $filenameext[(int) $filenameextcount - 1];   //for album img in front page  
		         $twidth = $picasettings[0][5];
                 $theight = $picasettings[0][6];
                
                 $imgW = $image->getWidth();
                 $imgH = $image->getHeight();
if($imgW >= $twidth || $imgH >= $theight )
		    {

		    	if($imgW >= $imgH)
		    	{
		    		 $image->resizeToWidth($twidth);
                     $image->save($uploaddir . $thumbfile);
		    	}
		
		       else if($imgH >= $imgW) {
		       	     $image->resizeToHeight($theight);
                     $image->save($uploaddir . $thumbfile);
		        }  
		    }
		       else {
		       	     $image->resize($imgW,$imgH);
                     $image->save($uploaddir . $thumbfile);
		            }
         
				 // End of Album Thumb
                
                $thumbfile = $lastid . "_photothumb." . $filenameext[(int) $filenameextcount - 1];     // for showing single image with big size
                $image->load($_FILES['uploadfile']['tmp_name']);
		        $twidth = $picasettings[0][13];
		        $theight = $picasettings[0][14];
                     $imgW = $image->getWidth();
                     $imgH = $image->getHeight();
	                
			if($imgW >= $twidth || $imgH >= $theight )
		    {

		    	if($imgW >= $imgH && $imgW >= $twidth)
		    	{
		    		 $image->resizeToWidth($twidth);
                     $image->save($uploaddir . $thumbfile);
		    	}
		
		       else if($imgH >= $imgW && $imgH >= $theight) {
		       	     $image->resizeToHeight($theight);
                     $image->save($uploaddir . $thumbfile);
		        }  
		    }
		       else {
		       	     $image->resize($imgW,$imgH);
                     $image->save($uploaddir . $thumbfile);
		            }
		     // End of photo Thumb
		            
                     $thumbfile = $lastid . "_sliderthumb." . $filenameext[(int) $filenameextcount - 1]; //for feature images in front page
                     
	                 $twidth = 116;
	                 $theight = 76;
	                 $image->load($_FILES['uploadfile']['tmp_name']);
	                 $imgW = $image->getWidth();
                     $imgH = $image->getHeight();
	                
			if($imgW >= $twidth || $imgH >= $theight )
		    {

		    	if($imgW >= $imgH)
		    	{
		    		 $image->resizeToWidth($twidth);
                     $image->save($uploaddir . $thumbfile);
		    	}
		
		       else if($imgH >= $imgW) {
		       	     $image->resizeToHeight($theight);
                     $image->save($uploaddir . $thumbfile);
		        }  
		    }
		       else {
		       	     $image->resize($imgW,$imgH);
                     $image->save($uploaddir . $thumbfile);
		            }
               
                // End of Slider Thumb
              
                
			$exten = $filenameext[(int) $filenameextcount - 1];
			$sortval =  $wpdb->get_var("SELECT COUNT(*) FROM  " . $wpdb->prefix . "asgallphotos WHERE `asgallAlbum_id` = $albumId  and is_delete = 0");
            $sqlQ = "UPDATE " . $wpdb->prefix . "asgallphotos SET   asgallPhoto_image='$get_file', `asgallPhoto_sorting`= ($sortval - 1)  WHERE asgallPhoto_id=$lastid";
		    $upd = $wpdb->query($sqlQ);
   
}
else
{
        echo "error ".$_FILES['uploadfile']['error']." --- ".$_FILES['uploadfile']['tmp_name']." %%% ".$file."($size)";
}
}
?>