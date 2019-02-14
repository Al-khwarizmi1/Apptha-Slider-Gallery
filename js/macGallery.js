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

//For Showing the list of Album in adjacent
function asgallAlbum(pages)
{

if(pages == '')
{
    pages = 1;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
        document.getElementById('bind_asgallAlbum').innerHTML = xmlhttp.responseText
        imagePreview();
    }
  }
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/asgallalblist.php?pages='+pages,true);
xmlhttp.send();
 }

function macGallery(pages)
{

if(pages == '')
{
    pages = 1;
}

if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
        document.getElementById('bind_macGallery').innerHTML = xmlhttp.responseText
        imagePreview();
    }
  }
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/macgallerylist.php?pages='+pages,true);
xmlhttp.send();
 }

 //showing the name edit form
/*function albumNameform(asgallAlbum_id)
{
     
 if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
        document.getElementById('showAlbumedit_'+asgallAlbum_id).style.display="block";
        document.getElementById('showAlbumedit_'+asgallAlbum_id).innerHTML = xmlhttp.responseText
    }
  }
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/asgallajaxAlbum.php?asgallAlbumname_id='+asgallAlbum_id,true);
xmlhttp.send();

}*/

 
//Update the album name
function updAlbname(asgallAlbum_id)
{

var asgallAlbum_id = asgallAlbum_id;
var asgallAlbum_name   = document.getElementById('macedit_name_'+asgallAlbum_id).value;
var asgallAlbum_desc   = document.getElementById('asgallAlbum_desc_'+asgallAlbum_id).value;

  if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
      document.getElementById('albName_'+asgallAlbum_id).innerHTML = asgallAlbum_name;
      document.getElementById('displayAlbum_'+asgallAlbum_id).innerHTML = asgallAlbum_desc;
      document.getElementById('showAlbumedit_'+asgallAlbum_id).style.display="none";
    }
  }
 
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/asgallajaxAlbum.php?asgallAlbum_id='+asgallAlbum_id+'&asgallAlbum_name='+asgallAlbum_name+'&asgallAlbum_desc='+asgallAlbum_desc,true);
xmlhttp.send();
}
//updating gallery
//showing the name edit form
function galNameform(macGallery_id)
{

 if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
        document.getElementById('showGaledit_'+macGallery_id).style.display="block";
        document.getElementById('showGaledit_'+macGallery_id).innerHTML = xmlhttp.responseText
    }
  }
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/asgallajaxAlbum.php?macGallery_id='+macGallery_id,true);
xmlhttp.send();

}

//Update the Galery name
function updGalname(macGallery_id)
{
var macGallery_id = macGallery_id;
var macGal_name   = document.getElementById('macgaledit_name_'+macGallery_id).value;
 // alert(macGal_name);

  if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
    	//macGallery_name = xmlhttp.responseText;

      document.getElementById('macgaledit_name_'+macGallery_id).innerHTML = macGal_name;

      document.getElementById('showGaledit_'+macGallery_id).style.display="none";
      document.forms["all_action"].submit();
    }
  }
 //alert(macGallery_id+'----------'+macGal_name);
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/asgallajaxAlbum.php?macGallery_id='+macGallery_id+'&macGallery_name='+macGal_name,true);
xmlhttp.send();
}

//For Changing Mac Album Page id

function albumPageid(asgallAlbum_id)
{
  if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
        document.getElementById('showPageedit_'+asgallAlbum_id).innerHTML = xmlhttp.responseText
    }
  }
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/asgallajaxAlbum.php?asgallAlbumpage_id='+asgallAlbum_id,true);
xmlhttp.send();
}

//For Updating Mac Album Page id

function updPageid(asgallAlbum_id)
{

var asgallAlbum_pageid = document.getElementById('macedit_pageid_'+asgallAlbum_id).value;

 if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
      document.getElementById('macPageid_'+asgallAlbum_id).innerHTML = xmlhttp.responseText
    }
  }
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/asgallajaxAlbum.php?asgallAlbum_pageid='+asgallAlbum_pageid+'&asgallAlbum_id='+asgallAlbum_id,true);
xmlhttp.send();
}

//For changing the Album Status
 function asgallAlbum_status(status,asgallAlbum_id)
 {
   
  if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
       document.getElementById('status_bind_'+asgallAlbum_id).innerHTML = xmlhttp.responseText
    }
  }
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/asgallajaxAlbum.php?status='+status+'&albid='+asgallAlbum_id,true);
xmlhttp.send();
 }

// View Album description Update
function albumtoggle(asgallAlbum_id) {
	var albumele = document.getElementById("albumtoggleText_"+asgallAlbum_id);
	var albumtext = document.getElementById("albumdisplayText_"+asgallAlbum_id);
	if(albumele.style.display == "block") {
    		albumele.style.display = "none";
		albumtext.innerHTML = "Edit";
  	}
	else {
		albumele.style.display = "block";
		albumtext.innerHTML = "hide";
	}
}

function asgallAlbumdesc_updt(asgallAlbum_id)
{
var asgallAlbum_desc = document.getElementById('asgallAlbum_desc_'+asgallAlbum_id).value;
    if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
      document.getElementById('displayAlbum_'+asgallAlbum_id).innerHTML = xmlhttp.responseText
    }
  }
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/asgallajaxAlbum.php?asgallAlbum_desc='+asgallAlbum_desc+'&asgallAlbum_id='+asgallAlbum_id,true);
xmlhttp.send();
}
 //For changing the gallery status

 function macGallery_status(status,macGallery_id)
 {

  if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
       document.getElementById('galstatus_bind_'+macGallery_id).innerHTML = xmlhttp.responseText
    }
  }
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/macgalajax.php?status='+status+'&galid='+macGallery_id,true);
xmlhttp.send();
 }

function macdeleteAlbum(asgallAlbum_id)
{
  if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
        window.location = self.location;
    }
  }
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/macphtajax.php?macdelAlbum='+asgallAlbum_id,true);
xmlhttp.send();
}


//For Showing the Multiple Photo Upload in Adjacent
function macPhotos(numFilesQueued,albid)
{
    var show_pht = document.getElementById('bind_value').value;
    document.getElementById('bind_value').value = Number(show_pht)+Number(numFilesQueued);
    var rst_pht = document.getElementById('bind_value').value;
   
   if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
        document.getElementById('bind_asgallPhotos').innerHTML = xmlhttp.responseText
    }
  }
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/asgallajaxPhotos.php?queue='+rst_pht+'&albid='+albid,true);
xmlhttp.send();
 }
//For Delete from the upload images
function macdelAjax(macPhoto_id)
{
     if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
        document.getElementById('remve_macPhotos_'+macPhoto_id).innerHTML += xmlhttp.responseText;
        
    }
  }
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/asgallajaxAlbum.php?macDelid='+macPhoto_id,true);
xmlhttp.send();
}
//For showing the name,description box adjacent to photos

 function maceditPhotos(rst)
{
  if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
        document.getElementById('edit_macPhotos').innerHTML = xmlhttp.responseText
    }
  }
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/macphtajax.php?macEdit='+rst,true);
xmlhttp.send();
 }

//Update Name and Description

function upd_disphoto(queue,albid)
{

    for(i=1;i<=queue;i++)
    {
     var macedit_phtid = document.getElementById("macedit_id_"+i).value;
     var macedit_name  = document.getElementById("macedit_name_"+i).value;
     var macedit_desc  = document.getElementById("macedit_desc_"+i).value;
dragdr = jQuery.noConflict();
dragdr.ajax({
    method:"GET",
       url: site_url+'/wp-content/plugins/apptha-slider-gallery/admin/macphtajax.php',
       data : "macedit_phtid="+macedit_phtid+"&macedit_name="+macedit_name+"&macedit_desc="+macedit_desc,
       asynchronous:false,
       error: function(html){
    	  
            },
      success: function(html){
    	
          window.location = site_url+'/wp-admin/admin.php?page=slidePhotos&action=viewPhotos&albid='+albid;
           }
       });
  }
alert('Updated sucessfully');
  //window.location = site_url+'/wp-admin/admin.php?page=slidePhotos&action=viewPhotos&albid='+albid;
}

//Mac Individual Photo Delete
 function macdeletePhoto(macdeleteId)
 {
var agree=confirm("Are you sure you want to delete ?");
if (agree)
{
  if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
        document.getElementById('photo_delete_'+macdeleteId).style.visibility = 'hidden';
    }
  }
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/macphtajax.php?macdeleteId='+macdeleteId,true);
xmlhttp.send();
 }
 }


 function macdesEdit(macPhoto_id)
 {

  if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
        document.getElementById('edit_macDesc').innerHTML = xmlhttp.responseText
    }
  }
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/macphtajax.php?macphotoDesc_id='+macPhoto_id,true);
xmlhttp.send();
 }

 function photosNameform(macPhotos_id) {


        document.getElementById('showPhotosedit_'+macPhotos_id).style.display = 'block';
     
}
//showing the name edit form
function albumNameform(asgallAlbum_id)
{
  document.getElementById('showAlbumedit_'+asgallAlbum_id).style.display = 'block';
}


/* function photosNameform(macPhotos_id) {

  //alert(site_url);
  if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
       // alert(xmlhttp.responseText);
       //  document.getElementById('showPhotosedit_'+macPhotos_id).innerHTML= '<td style="margin:0 10px;border:none"><input type="text" name="macPhoto_name_145" id="macPhoto_name_145" ></td><td colspan="2" style="padding-top:10px;text-align:center;border:none"><input type="submit" name="updatePhoto_name" value="Update" onclick="updPhotoname(145)";></td>';

        document.getElementById('showPhotosedit_'+macPhotos_id).innerHTML = xmlhttp.responseText
       // alert(document.getElementById('showPhotosedit_'+macPhotos_id).innerHTML)
       
    }
  }
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/asgallajaxAlbum.php?macPhotoname_id='+macPhotos_id,true);
xmlhttp.send();
} */
 //Update the Photo name
function updPhotoname(macPhotos_id)
{

var macPhoto_name = document.getElementById('macPhoto_name_'+macPhotos_id).value;
//macPhoto_name = macPhoto_name.trim();

if(macPhoto_name == '')
    {
        //alert('not empty');
return false;
    }
    
 if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
       
      document.getElementById('asgallPhotos_'+macPhotos_id).innerHTML = xmlhttp.responseText;
      document.getElementById('showPhotosedit_'+macPhotos_id).style.display = 'none';
    }
  }
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/asgallajaxAlbum.php?macPhoto_name='+macPhoto_name+'&macPhotos_id='+macPhotos_id,true);
xmlhttp.send();
}
// View Photo description Update
function phototoggle(macPhoto_id) {
	var ele = document.getElementById("toggleText"+macPhoto_id);
     	var text = document.getElementById("displayText_"+macPhoto_id);
	if(ele.style.display == "block") {
    		ele.style.display = "none";
		text.innerHTML = "Edit";
  	}
	else {
		ele.style.display = "block";
		
	}
}

function macdesc_updt(macPhoto_id)
{
var asgallPhoto_desc = document.getElementById('asgallPhoto_desc_'+macPhoto_id).value;
var ele = document.getElementById("toggleText"+macPhoto_id);
	
    if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
      document.getElementById('display_txt_'+macPhoto_id).innerHTML = xmlhttp.responseText
      ele.style.display = "none";
    }
  }
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/macphtajax.php?asgallPhoto_desc='+asgallPhoto_desc+'&asgallPhoto_id='+macPhoto_id,true);

xmlhttp.send();
}
function macAlbcover_status(addCover,albumId,macPhoto_id , flag)  //falg is for featured img select
{
		
    if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {   
    	//alert(xmlhttp.responseText);
      window.location = self.location;
    }
  }
  // alert('addcover = '+addCover+'  album id = '+ albumId+' mac photo id=  '+macPhoto_id+ '  flag = '+  flag );
 if( flag ) 
	{  
	 xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/asgallajaxAlbum.php?featuredCover='+addCover+'&albumId='+albumId+'&macCovered_id='+macPhoto_id,true);
	} 
 else
 { 
	 xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/asgallajaxAlbum.php?albumCover='+addCover+'&albumId='+albumId+'&macCovered_id='+macPhoto_id,true);}
 
xmlhttp.send();
}
//Photos thumbniles are changeing

//Photos Status Changing
 /*function macPhoto_status(status,macPhoto_id)
{
  if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
       document.getElementById('photoStatus_bind_'+macPhoto_id).innerHTML = xmlhttp.responseText
    }
  } //kranthi
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/upload-file.php?changethumb='+status+'&macPhoto_id='+macPhoto_id,true);
xmlhttp.send();
}
*/

//Photos Status Changing
function asgallPhoto_status(status,macPhoto_id)
{
  if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
   xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4)
    {
       document.getElementById('photoStatus_bind_'+macPhoto_id).innerHTML = xmlhttp.responseText
    }
  }
xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/asgallajaxAlbum.php?status='+status+'&asgallPhoto_id='+macPhoto_id,true);
xmlhttp.send();
}

function CancelAlbum(asgallAlbum_id)
{
    document.getElementById('showAlbumedit_'+asgallAlbum_id).style.display="none";
}

function CancelGalllery(macGallery_id)
{
    document.getElementById('showGaledit_'+macGallery_id).style.display="none";
}

  // resize photos
function photos_regenerate(flagname , resizetype , width , height )
{
	
	var site_url = document.getElementById('mysiteurl').value;
	var mac_folder = document.getElementById('pliginfoulder').value;
        //alert(flagname+'------'+resizetype+'------'+width+'------'+height);
	 if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	   xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	  xmlhttp.onreadystatechange=function()
	  {
	    if (xmlhttp.readyState==4)
	    {
                alert('Resized Successfully');
	     //alert(xmlhttp.responseText);
	    //  document.getElementById('macPhotos_'+macPhotos_id).innerHTML = xmlhttp.responseText;
	    //  document.getElementById('showPhotosedit_'+macPhotos_id).style.display = 'none';
	    }
	  }
	xmlhttp.open("GET",site_url+'/wp-content/plugins/'+mac_folder+'/admin/asgallUpload.php?photoThumbGenerate='+flagname+'&photoResize='+resizetype+'&width='+width+'&height='+height,true);
	xmlhttp.send();
}
 var resizeval;
     function showClickMessage(textboxid){

       resizeval =  document.getElementById(textboxid).value;
  	   document.getElementById('PhotosResizeMsg').style.display = 'block';

     }

var flagForMse = 1;
function checkIsEmpty(getid){

	  var textboxval =  document.getElementById(getid).value;
	   textboxval = textboxval.trim();
	  var isshow ;
	 var notSubmit = 1;

	  if(textboxval == resizeval && flagForMse ){
		  //alert(resizeval);
		  document.getElementById('PhotosResizeMsg').style.display = 'none';
	  }
	  else{

		  flagForMse = 0;
	  }
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

