<?php

$c = orb_ctc_addon_clipboard::get_instance();
add_action('orbisius_child_theme_creator_admin_enqueue_scripts', array( $c, 'admin_enqueue_scripts' ) );

class orb_ctc_addon_clipboard extends orbisius_child_theme_creator_singleton {
    function admin_enqueue_scripts() {
        wp_register_script( 'orb_ctc_addon_clipboard', 
            apply_filters('orbisius_child_theme_creator_filter_asset_src', "addons/clipboard/share/clipboard-js/dist/clipboard.min.js"), 
            array('jquery', ),
            apply_filters('orbisius_child_theme_creator_filter_asset_src', 
                "addons/clipboard/share/clipboard-js/dist/clipboard.min.js",
                array( 'last_mod' => 1 ) 
            ),
            true
        );
        wp_enqueue_script( 'orb_ctc_addon_clipboard' );
        
        wp_register_script( 'orb_ctc_addon_clipboard_main',
            apply_filters('orbisius_child_theme_creator_filter_asset_src', "addons/clipboard/assets/main.js"),
            array('jquery', 'orb_ctc_addon_clipboard', ),
            apply_filters('orbisius_child_theme_creator_filter_asset_src',
                "addons/clipboard/assets/main.js",
                array( 'last_mod' => 1 )
            ),
            true
        );
        wp_enqueue_script( 'orb_ctc_addon_clipboard_main' );
    }
}
