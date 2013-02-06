jQuery(function () {

    var isSitemap = false;

    jQuery(document).ajaxComplete(function (e) {
        if (isSitemap) {
            qc_check_for_sitemap();
        }
    });

    /**
     * To ensure that the function qc_check_for_sitemap() runs only in sitemap
     */
    var url = document.URL.split("?");
    if (url.length > 1) {
        var param = url[1].split("&"); // split the get Parameter
        var paramLength = param.length;
        for (var i=0; i<paramLength; i++) {
            var paramValue = param[i].split("=");

            if (paramValue[0] == 'do' && paramValue[1] == 'index') {
                isSitemap = true;
                qc_check_for_sitemap();
                break;
            }
        }
    }

     /**
     * extend index object function to add quality icons to all pages
     */
    function qc_check_for_sitemap() {
        jQuery(".wikilink1:not(.qc_check_applied)").each(function () {
            var img       = document.createElement('img');
            img.src       = DOKU_BASE+'lib/plugins/qc/icon.php?id='+jQuery(this).attr('title')+'&type=small';
            img.alt       = '';
            img.className = 'qc_smallicon';
            jQuery(this).append(img).andSelf().addClass("qc_check_applied");
        });
    }


    jQuery("#plugin__qc__closed").live("click", function (e) {
        jQuery.ajax({
            url: DOKU_BASE + 'lib/plugins/qc/pageinfo.php?id=' + jQuery(this).attr('title'),
            success: function(result){
                jQuery('#plugin__qc__closed').append(result);
                jQuery('#plugin__qc__closed').attr("id", 'plugin__qc__open');
            }
        });

        e.preventDefault();
        return false;
    });

    jQuery("#qc_fixme").live("click", function(e) {
        jQuery(".icon").each(function() {
            if (jQuery(this).attr('alt') === "FIXME") {
                jQuery('html, body').animate({scrollTop: jQuery(this).offset().top});
                return false;
            }
        });
        e.preventDefault();
        return false;
    });

});
