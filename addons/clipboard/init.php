<?php

$c = new orb_ctc_addon_clipboard();
add_action('orbisius_child_theme_creator_admin_enqueue_scripts', [ $c, 'admin_enqueue_scripts' ]);

class orb_ctc_addon_clipboard {
    function admin_enqueue_scripts() {
        wp_register_script( 'orb_ctc_addon_clipboard', plugins_url("addons/clipboard/share/clipboard-js/dist/clipboard.min.js", ORBISIUS_CHILD_THEME_CREATOR_MAIN_PLUGIN_FILE), array('jquery', ),
                    filemtime( plugin_dir_path( ORBISIUS_CHILD_THEME_CREATOR_MAIN_PLUGIN_FILE ) . "addons/clipboard/share/clipboard-js/dist/clipboard.min.js" ), true);
        wp_enqueue_script( 'orb_ctc_addon_clipboard' );
        
        wp_register_script( 'orb_ctc_addon_clipboard_main', plugins_url("addons/clipboard/assets/main.js", ORBISIUS_CHILD_THEME_CREATOR_MAIN_PLUGIN_FILE), array('jquery', 'orb_ctc_addon_clipboard', ),
                    filemtime( plugin_dir_path( ORBISIUS_CHILD_THEME_CREATOR_MAIN_PLUGIN_FILE ) . "addons/clipboard/assets/main.js" ), true);
        wp_enqueue_script( 'orb_ctc_addon_clipboard_main' );
    }

}