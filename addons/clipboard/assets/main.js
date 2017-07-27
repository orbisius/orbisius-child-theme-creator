/**
 * Used for the Snippet Library
 */
jQuery(document).ready(function($) {
    try {
        var clipboard = new Clipboard('.orb_ctc_copy_btn');

        clipboard.on('success', function(e) {
            console.log(e);
        });

        clipboard.on('error', function(e) {
            alert('copy failed');
            console.log(e);
        });
    } catch (e) {
        console && console.log("orbisius child theme creator addon: Clipboard.js wasn't loaded");
    }
})(jQuery);