/* global JSINFO, DOKU_BASE */

jQuery(function () {
    var $wrap = jQuery('#plugin__qc__wrapper');
    if (!$wrap.length) return;
    var $summary = $wrap.find('.summary');
    var $output = $wrap.find('.output').hide();

    // autoload the summary
    jQuery.post(
        DOKU_BASE + '/lib/exe/ajax.php',
        {
            call: 'plugin_qc_short',
            id: JSINFO['id']
        },
        function (data) {
            $summary.append(data);
        }
    );

    // load the full info on click
    $summary.click(function () {
        if ($output.html() == '') {
            $output.html('loading...');

            jQuery.post(
                DOKU_BASE + '/lib/exe/ajax.php',
                {
                    call: 'plugin_qc_long',
                    id: JSINFO['id']
                },
                function (data) {
                    $output.html(data);
                }
            );
        }
        $output.dw_toggle();
    })
        .css('cursor', 'pointer')
    ;
});
