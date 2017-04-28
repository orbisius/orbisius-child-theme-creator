<?php

class orbisius_child_theme_creator_ext_mod_cloud {
    public function render_tabs() {
        $url = admin_url( 'themes.php?page=orbisius_child_theme_creator_theme_editor_action' );
        
        $tabs = [
            [
                'id' => 'orb_ctc_ext_cloud_lib_search',
                'label' => __( 'Search' ),
            ],
            [
                'id' => 'orb_ctc_ext_cloud_lib_add',
                'label' => __( 'Add' ),
            ],
            [
                'id' => 'orb_ctc_ext_cloud_lib_manage',
                'label' => __( 'Manage' ),
            ],
            [
                'id' => 'orb_ctc_ext_cloud_lib_account',
                'label' => __( 'Account' ),
            ],
        ];
                
        $cur_tab_id = empty($_REQUEST['tab']) ? $tabs[0]['id'] : wp_kses( $_REQUEST['tab'], [] );
        
        ?>
            <h2 class="nav-tab-wrapper">
                <?php foreach ( $tabs as $tab_rec ) : ?>
                    <?php 
                    $tab_url = add_query_arg( 'tab', $tab_rec['id'], $url );
                    $extra_tab_css = $tab_rec['id'] == $cur_tab_id ? 'nav-tab-active' : '';
                    ?>
                    <a href="<?php echo esc_url( $tab_url ); ?>" class="nav-tab <?php echo $extra_tab_css;?>"><?php echo $tab_rec['label'];?></a>
                <?php endforeach; ?>
            </h2>
        <?php
    }
    public function render_ui() {
        ?>
        <!-- Snippet Library Wrapper -->
            <div class="snippet_wrapper">
                    <h3>Snippet Library</h3>

                    <?php $this->render_tabs(); ?>
                    
                    <!-- New Snippet -->
                    <input class="button" type="button" id="new_snippet_btn" value="Add a New Snippet">
                    <br />
                    <br />
                    <div class="new_snippet_wrapper">
                            <?php if ( ! orbisius_child_theme_creator_is_pro_installed() ) : ?>
                                    <span>Please, log in to add a snippet</span>
                                    <a class="pro_Add_On" href="//orbisius.com/products/wordpress-plugins/orbisius-child-theme-creator-pro/?utm_source=<?php echo $slug_area; ?>&utm_medium=action_screen&utm_campaign=product" target="_blank" title="[new window]">Pro Addon</a>
                            <?php endif; ?>
                            <?php if ( ! orbisius_child_theme_creator_is_pro_installed() ) : ?>
                                    <textarea class="widefat" id="add_snippet_text"></textarea>
                                    <br />
                                    <strong>Title</strong>
                                    <input type="text" id="add_snippet_title">
                                    <input class="button" type="button" id="snippet_save_btn" value="Save">
                            <?php endif; ?>
                    </div>
                    <!-- Confirm dialog -->
                    <div id="snippet_confirm_dialog" title="">
                            <p>Are you sure you want to save a Snippet without any content?</p>
                    </div>
                    <!-- /Confirm dialog -->
                    <!-- /New Snippet -->

                    <br />
                    <!-- Search Snippets -->
                    <input class="selector" id="search_text"></input>
                    <input class="button button-primary" type="button" id="snippet_search_btn" value="Search">
                    <br />
                    <br />
                    <div class="found_snippet">
                            <strong>Snippet:</strong>
                            <textarea class="widefat" id="found_snippet_text"></textarea>
                            <strong>Title:</strong>
                            <input class="widefat" type="text" id="found_snippet_title"></textarea>
                    </div>
                    <!-- /Search Snippets -->
            </div>
            <!-- /Snippet Library Wrapper -->
        <?php
    }
}

