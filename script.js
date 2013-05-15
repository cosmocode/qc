/**
 * Add the QC info to the sitemap
 */
function plugin_qc_enhance($data){
    $data.find('div.li a.wikilink1').each(function(){
        var $link = jQuery(this);
        var img = document.createElement('img');
        img.src = DOKU_BASE + 'lib/plugins/qc/icon.php?id=' + $link.attr('title') + '&type=small';
        img.alt = '';
        img.className = 'qc_smallicon';
        $link.parent().append(img);
    });
}


/**
 * Override the sitemap initialization
 *
 * ugly, but currently not differently doable
 */
dw_index = jQuery('#index__tree').dw_tree({deferInit: true,
    load_data: function (show_sublist, $clicky) {
        jQuery.post(
            DOKU_BASE + 'lib/exe/ajax.php',
            $clicky[0].search.substr(1) + '&call=index',
            function (data) {
                $data = jQuery(data);
                plugin_qc_enhance($data);
                show_sublist($data);
            },
            'html'
        );
    }
});

jQuery(function () {
    // add stuff to the sitemap tree
    plugin_qc_enhance(jQuery('#index__tree'));

    /**
     * Open/Close the QC panel
     */
    jQuery('#plugin__qc__icon')
        .css('cursor', 'pointer')
        .click(function () {
            var $out = jQuery('#plugin__qc__out');
            var on = $out.is(':visible');
            $out.dw_toggle(on, function () {
                if (off) {
                    $out.html('loading...').load(jQuery('#plugin__qc__icon').attr('src').split('?'));
                }
            });
        });
});
