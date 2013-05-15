
function plugin_qc_toggle(e){
    var out = jQuery('#plugin__qc__out');
    if(!out) return;

    // extract needed params from the icon src URL
    var param = e.target.src.split('?');

    // it's shown currently -> disable
    if(out.css('display') != 'none'){
        out.hide();
        return;
    }

    // it's not shown currently -> fetch
    out.html('loading...');
    out.show();

    jQuery.get(DOKU_BASE + 'lib/plugins/qc/pageinfo.php', function(data) {
        out.html(data);
    });
}

jQuery(function(){
    var icon = jQuery('#plugin__qc__icon');
    icon.click(plugin_qc_toggle);
    icon.css('cursor', 'pointer');
});
