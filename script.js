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
            jQuery(this).after(img).andSelf().addClass("qc_check_applied");
        });
    }

});

function plugin_qc_toggle(e){
    var out = $('plugin__qc__out');
    if(!out) return;

    // extract needed params from the icon src URL
    var param = e.target.src.split('?');

    // it's shown currently -> disable
    if(out.style.display != 'none'){
        out.style.display = 'none';
        return;
    }

    // it's not shown currently -> fetch
    out.innerHTML = 'loading...';
    out.style.display = '';

    var ajax = new sack(DOKU_BASE + 'lib/plugins/qc/pageinfo.php');
    ajax.AjaxFailedAlert = '';
    ajax.encodeURIString = false;
    ajax.elementObj = out;
    ajax.runAJAX(param[1]);

}

addInitEvent(function(){
    var icon = $('plugin__qc__icon');
    if(!icon) return;
    addEvent(icon,'click',plugin_qc_toggle);
    icon.style.cursor = 'pointer';
});
