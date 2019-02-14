/*
 * Facebox (for jQuery)
 * version: 1.1 (03/01/2008)
 * @requires jQuery v1.2 or later
 *
 * Examples at http://famspam.com/facebox/
 *
 * Licensed under the MIT:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2007, 2008 Chris Wanstrath [ chris@ozmm.org ]
 *
 * Usage:
 *
 *  jQuery(document).ready(function() {
 *    jQuery('a[rel*=facebox]').facebox()
 *  })
 *
 *  <a href="#terms" rel="facebox">Terms</a>
 *    Loads the #terms div in the box
 *
 *  <a href="terms.html" rel="facebox">Terms</a>
 *    Loads the terms.html page in the box
 *
 *  <a href="terms.png" rel="facebox">Terms</a>
 *    Loads the terms.png image in the box
 *
 *
 *  You can also use it programmatically:
 *
 *    jQuery.facebox('some html')
 *
 *  This will open a facebox with "some html" as the content.
 *
 *    jQuery.facebox(function() { ajaxes })
 *
 *  This will show a loading screen before the passed function is called,
 *  allowing for a better ajax experience.
 *
 */


var apptha = jQuery.noConflict();

(function(apptha) {
  apptha.facebox = function(data, klass) {
    apptha.facebox.init()
    apptha.facebox.loading()
    apptha.isFunction(data) ? data.call(apptha) : apptha.facebox.reveal(data, klass)

  }


    apptha.facebox.settings = {
    loading_image : 'loadinfo.gif',
    close_image   : 'close.png',
    image_types   : [ 'png', 'jpg', 'jpeg', 'gif' ],
    facebox_html  : '\<div id="popup_overlay" style="display:none;background:black;opacity:0.8;filter: alpha(opacity=80);position:absolute;width:100%;z-index:45646"></div>\
 <div id="facebox" style="z-index:999999;display:none;"> \
<div class="popup"> \
    	<table style="width:940px;"> \
        <tbody> \
           <tr> \
            <td class="b"/> \
    	    <td class="body"> \
<div class="mac-close-image"> \
        <a href="#" class="close" title="close"> \
            </a> \
      </div> \
    	   <div class="appthaContent" id="appthaContent" style="width:920px;margin:0 auto;"> \
              </div> \
             </td> \
            </tbody> \
      </table> \
    </div> \
  </div>'
  }

  apptha.facebox.loading = function() {

    if (apptha('#facebox .loading').length == 1) return true

    apptha('#facebox .appthaContent').empty()
    apptha('#facebox .body').children().hide().end().
      append('<div class="loading" style="margin:0 auto;"></div>')

    var pageScroll = apptha.facebox.getPageScroll()
    apptha('#facebox').css({
      top:	pageScroll[1] + (apptha.facebox.getPageHeight() / 10),
      left:	pageScroll[0]
    }).show()
apptha('#popup_overlay').css({
      top:	0,
      left:	pageScroll[0],
      height: apptha(document).height()
    }).show()

    apptha(document).bind('keydown.facebox', function(e) {
      if (e.keyCode == 27) apptha.facebox.close()
    })
  }

  apptha.facebox.reveal = function(data, klass) {

    if (klass) apptha('#facebox .appthaContent').addClass(klass)

    apptha('#facebox .appthaContent').append(data)

    apptha('#facebox .loading').remove()


    apptha('#facebox .body').children().fadeIn('normal')
  }

  apptha.facebox.close = function() {
    apptha("#popup_overlay").hide();
     //apptha('#facebox .content').html('')
    apptha(document).trigger('close.facebox')
    return false
  }

  apptha(document).bind('close.facebox', function() {
    apptha(document).unbind('keydown.facebox')
    apptha('#facebox').fadeOut(function() {
      apptha('#facebox .appthaContent').removeClass().addClass('appthaContent');


    })
  })

  apptha.fn.facebox = function(settings) {
    apptha.facebox.init(settings)

    var image_types = apptha.facebox.settings.image_types.join('|')
    image_types = new RegExp('\.' + image_types + 'apptha', 'i')

    function click_handler() {
      apptha("#popup_overlay").show();
      apptha.facebox.loading(true)

      // support for rel="facebox[.inline_popup]" syntax, to add a class
      var klass = this.rel.match(/facebox\[\.(\w+)\]/)
      if (klass) klass = klass[1]

      // div
      if (this.href.match(/#/)) {
        var url    = window.location.href.split('#')[0]
        var target = this.href.replace(url,'')

        apptha.facebox.reveal(apptha(target).clone().show(), klass)

      // image
      } else if (this.href.match(image_types)) {
        var image = new Image()
        image.onload = function() {
          apptha.facebox.reveal('<div class="image"><img src="' + image.src + '" /></div>', klass)
        }
        image.src = this.href

      // ajax
      } else {

        apptha.get(this.href, function(data) {apptha.facebox.reveal(data, klass)})
      }

      return false
    }

    this.click(click_handler)
    return this
  }

  apptha.facebox.init = function(settings) {
    if (apptha.facebox.settings.inited) {
      return true
    } else {
      apptha.facebox.settings.inited = true
    }

    if (settings) apptha.extend(apptha.facebox.settings, settings)
    apptha('body').append(apptha.facebox.settings.facebox_html)

    var preload = [ new Image(), new Image() ]
    preload[0].src = apptha.facebox.settings.close_image
    preload[1].src = apptha.facebox.settings.loading_image

    apptha('#facebox').find('.b:first, .bl, .br, .tl, .tr').each(function() {
      preload.push(new Image())
      preload.slice(-1).src = apptha(this).css('background-image').replace(/url\((.+)\)/, 'apptha1')
    })

    apptha('#facebox .close').click(apptha.facebox.close)
    apptha('#facebox .close_image').attr('src', apptha.facebox.settings.close_image)
  }

  // getPageScroll() by quirksmode.com
  apptha.facebox.getPageScroll = function() {
    var xScroll, yScroll;
    if (self.pageYOffset) {
      yScroll = self.pageYOffset;
      xScroll = self.pageXOffset;
    } else if (document.documentElement && document.documentElement.scrollTop) {	 // Explorer 6 Strict
      yScroll = document.documentElement.scrollTop;
      xScroll = document.documentElement.scrollLeft;
    } else if (document.body) {// all other Explorers
      yScroll = document.body.scrollTop;
      xScroll = document.body.scrollLeft;
    }
    return new Array(xScroll,yScroll)
  }

  // adapter from getPageSize() by quirksmode.com
  apptha.facebox.getPageHeight = function() {
    var windowHeight
    if (self.innerHeight) {	// all except Explorer
      windowHeight = self.innerHeight;
    } else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
      windowHeight = document.documentElement.clientHeight;
    } else if (document.body) { // other Explorers
      windowHeight = document.body.clientHeight;
    }
    return windowHeight
  }
})(jQuery);
