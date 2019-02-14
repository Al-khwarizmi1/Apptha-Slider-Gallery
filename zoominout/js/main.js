(function($) {
    function open(src) {
        var firstZoom = true;

        $("#iviewer").fadeIn().trigger('fadein');

        var viewer = $("#iviewer .viewer").
            width($(window).width() - 80).
            height($(window).height()).
            iviewer({
                src : src,
                ui_disabled : true,
                zoom : 'fit',
                initCallback : function() {
                    var self = this;

                },
                onZoom : function() {
                    if (!firstZoom) return;

                    $("#iviewer .loader").fadeOut();
                    $("#iviewer .viewer").fadeIn();
                    firstZoom = true;
                }
            }
        );

        $("#iviewer .zoomin").click(function(e) {
            e.preventDefault();
            viewer.iviewer('zoom_by', 1);
        });

        $("#iviewer .zoomout").click(function(e) {
            e.preventDefault();
            viewer.iviewer('zoom_by', -1);
        });
    }

    function close() {
        $("#iviewer").fadeOut().trigger('fadeout');
    }

    $('#go').click(function(e) {
        e.preventDefault();
        var src = $(this).attr('href');
        open(src);
    });

    $("#iviewer .close").click(function(e) {
        e.preventDefault();
        close();
    });

    $("#iviewer").bind('fadein', function() {
        $(window).keydown(function(e) {
            if (e.which == 27) close();
        });
    });
})(jQuery);


(function(c){var a=["DOMMouseScroll","mousewheel"];c.event.special.mousewheel={setup:function(){if(this.addEventListener){for(var d=a.length;d;){this.addEventListener(a[--d],b,false)}}else{this.onmousewheel=b}},teardown:function(){if(this.removeEventListener){for(var d=a.length;d;){this.removeEventListener(a[--d],b,false)}}else{this.onmousewheel=null}}};c.fn.extend({mousewheel:function(d){return d?this.bind("mousewheel",d):this.trigger("mousewheel")},unmousewheel:function(d){return this.unbind("mousewheel",d)}});function b(f){var d=[].slice.call(arguments,1),g=0,e=true;f=c.event.fix(f||window.event);f.type="mousewheel";if(f.wheelDelta){g=f.wheelDelta/120}if(f.detail){g=-f.detail/3}d.unshift(f,g);return c.event.handle.apply(this,d)}})(jQuery);

