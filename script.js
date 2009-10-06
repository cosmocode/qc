
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
