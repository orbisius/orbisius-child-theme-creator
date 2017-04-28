<?php

require_once( __DIR__ . '/lib/snippet_lib.php' );
require_once( __DIR__ . '/modules/cloud.php' );

$obj = new orbisius_child_theme_creator_ext_mod_cloud();
add_action( 'orbisius_child_theme_creator_editors_ext_action_left_start', [ $obj, 'render_tabs' ] );
