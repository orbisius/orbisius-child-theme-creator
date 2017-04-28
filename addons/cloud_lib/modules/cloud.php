<?php

$obj = new orbisius_ctc_cloud_lib();
    
add_action( 'admin_init', array( $obj, 'admin_init' ) );
add_action( 'orbisius_child_theme_creator_editors_ext_action_left_start', [ $obj, 'render_ui' ] );

