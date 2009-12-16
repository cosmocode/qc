
/**
 * extend index object function to add quality icons to all pages
 */
index.saved_treeattach = index.treeattach;
index.treeattach = function(obj){
    index.saved_treeattach(obj);

    var items = getElementsByClass('wikilink1',obj,'a');
    for(var i=0; i<items.length; i++){
        var elem = items[i];

        var img       = document.createElement('img');
        img.src       = DOKU_BASE+'lib/plugins/qc/icon.php?id='+elem.title+'&type=small';
        img.alt       = '';
        img.className = 'qc_smallicon';
        elem.parentNode.appendChild(img);
    }
}


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
