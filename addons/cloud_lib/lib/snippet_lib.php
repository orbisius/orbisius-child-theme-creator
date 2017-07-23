<?php

/**
 * Autocomplete
 * Search for a snippet
 * Add a snippet
 * 
 */
class orbisius_ctc_cloud_lib {
    /**
     * @var string	Url of remote API. The plugin will dynamically pick one
     */
    public $api_url	= '';
    public $live_api_url = 'https://orbisius.com/';
    public $dev_api_url	= 'http://orb-ctc.qsandbox.com/';
//    public $dev_api_url	= 'http://orbclub.com.clients.com/';
    public $staging_api_url = 'http://orb-ctc.qsandbox.com/';
    private $tabs = [];

    /*
     * API which returns with autocomplete suggestions
     */
    public $api_autocomplete	= '?orb_cloud_lib_data[cmd]=item.list&orb_cloud_lib_data[query]=';

    /*
     * API which returns search results
     */
    public $api_search	= '?orb_cloud_lib_data[cmd]=item.list&orb_cloud_lib_data[query]=';

    /*
     * API which adds a new snippet
     */
    public $api_add		= '?orb_cloud_lib_data[cmd]=item.add&orb_cloud_lib_data[title]=test&&orb_cloud_lib_data[content]=some_data';
    
    /*
     * API which updates a snippet
     */
    public $api_update		= '?orb_cloud_lib_data[cmd]=item.update&orb_cloud_lib_data[id]=id&&orb_cloud_lib_data[title]=test&&orb_cloud_lib_data[content]=some_data';
	
    /*
     * API which deletes a snippet
     */
    public $api_delete		= '?orb_cloud_lib_data[cmd]=item.delete&orb_cloud_lib_data[id]=id';
    
    /*
     * API which returns all snippets
     */
    public $api_list_all	= '?orb_cloud_lib_data[cmd]=item.list';

    public function __construct() {
        if ( !empty( $_SERVER['DEV_ENV'])) {
            $this->api_url = $this->dev_api_url;
        } elseif ( !empty($_SERVER['HTTP_HOST']) 
                && (stripos($_SERVER['HTTP_HOST'], '.qsandbox.com') !== false)) {
            $this->api_url = $this->staging_api_url;
        } elseif ( !empty($_SERVER['HTTP_HOST'])
                && (stripos($_SERVER['HTTP_HOST'], '.clients.com') !== false)) {
            $this->api_url = $this->staging_api_url;
        } else {
            $this->api_url = $this->live_api_url;
        }

        // We need to initialize the tabs here because we're using __ method
        // for future internationalization.
        $tabs = [
            [
                'id' => 'orb_ctc_ext_cloud_lib_search',
                'label' => __( 'Search', 'orbisius-child-theme-creator' ),
            ],
            [
                'id' => 'orb_ctc_ext_cloud_lib_add',
                'label' => __( 'Add', 'orbisius-child-theme-creator' ),
            ],
            [
                'id' => 'orb_ctc_ext_cloud_lib_manage',
                'label' => __( 'Manage', 'orbisius-child-theme-creator' ),
            ],
            [
                'id' => 'orb_ctc_ext_cloud_lib_signup',
                'label' => __( 'Sign Up', 'orbisius-child-theme-creator' ),
            ],
            [
                'id' => 'orb_ctc_ext_cloud_lib_account',
                'label' => __( 'Account', 'orbisius-child-theme-creator' ),
            ],
            [
                'id' => 'orb_ctc_ext_cloud_lib_about',
                'label' => __( 'About', 'orbisius-child-theme-creator' ),
            ],
        ];
        
        $this->tabs = $tabs;
    }
        
    /**
     * Add snippet librabry actions
     */
    public function enqueue_assets() {
        wp_enqueue_script( 'jquery-ui-dialog' );
        wp_enqueue_script( 'jquery-ui-autocomplete' );
        wp_enqueue_script('jquery-ui-tabs');
        
        wp_register_script( 'orbisius_ctc_cloud_lib', plugins_url("/addons/cloud_lib/assets/custom.js", ORBISIUS_CHILD_THEME_CREATOR_MAIN_PLUGIN_FILE), array('jquery', ),
            filemtime( plugin_dir_path( ORBISIUS_CHILD_THEME_CREATOR_MAIN_PLUGIN_FILE ) . "/addons/cloud_lib/assets/custom.js" ), true);
        wp_enqueue_script( 'orbisius_ctc_cloud_lib' );

        //Custom styles for snippet library
        wp_register_style('orbisius_ctc_cloud_lib', plugins_url("/addons/cloud_lib/assets/custom.css", ORBISIUS_CHILD_THEME_CREATOR_MAIN_PLUGIN_FILE), null,
            filemtime( plugin_dir_path( ORBISIUS_CHILD_THEME_CREATOR_MAIN_PLUGIN_FILE ) . "/addons/cloud_lib/assets/custom.css" ), false );
        wp_enqueue_style('orbisius_ctc_cloud_lib');
    }
    
    /**
     * Add snippet librabry actions
     */
    public function admin_init() {
        add_action( 'orbisius_child_theme_creator_admin_enqueue_scripts', [$this, 'enqueue_assets'] );
        
        add_action( 'wp_ajax_cloud_autocomplete', [$this, 'cloud_autocomplete'] );
        add_action( 'wp_ajax_nopriv_cloud_autocomplete', [$this, 'cloud_autocomplete'] );
        
        // Snippet search ajax hook
        add_action( 'wp_ajax_cloud_search', [$this, 'cloud_search'] );
        add_action( 'wp_ajax_nopriv_cloud_search', [$this, 'cloud_search'] );
        
        // Add a New Snippet ajax hook
        add_action( 'wp_ajax_cloud_add', [$this, 'cloud_add'] );
        add_action( 'wp_ajax_nopriv_cloud_add', [$this, 'cloud_add'] );
        
        // Update a Snippet ajax hook
        add_action( 'wp_ajax_cloud_update', [$this, 'cloud_update'] );
        add_action( 'wp_ajax_nopriv_cloud_update', [$this, 'cloud_update'] );
        
        // Delete a Snippet ajax hook
        add_action( 'wp_ajax_cloud_delete', [$this, 'cloud_delete'] );
        add_action( 'wp_ajax_nopriv_cloud_delete', [$this, 'cloud_delete'] );
    }

    /**
     * Makes a request to API and get response
     * @return JSON array	response from the api
     */
    public function call($url, $req_params = []) {
        // Prepend user's api key if any.
        if (!empty($req_params['orb_cloud_lib_data']['api_key'])) {
            $user_api = orbisius_child_theme_creator_user::get_instance();
            $api_key = $user_api->api_key();
            
            if (!empty($api_key)) {
                $req_params['orb_cloud_lib_data']['api_key'] = $api_key;
            }
        }
        
        $res = new orbisius_child_theme_creator_result();
        
        $wp_req_params = [
            'method' => 'POST',
            'timeout' => 20,
            'redirection' => 5,
            'blocking' => true,
            'body' => $req_params,
        ];
        
        $response = wp_remote_post($url, $wp_req_params);
        
        if ( is_wp_error( $response ) ) {
           $res->msg( $response->get_error_message() );
        } else {
            $api_response = wp_remote_retrieve_body($response);
            $res->status(1);
            $res->data('result', $api_response);
        }

        return $res;
    }

    /**
     * Gets autocomplete suggestions from API based on data sent to the API
     * @return	JSON API's response
     */
    public function cloud_autocomplete() {
        if (!empty($_REQUEST['term'])) {
            $search_for_term = sanitize_text_field($_REQUEST['term']);
            $url = $this->api_url . $this->api_autocomplete . $search_for_term;
            $req_res = $this->call($url);
            wp_send_json($req_res->is_success() ? $req_res->data('result') : $req_res);
        }
    }

    /**
     * Sends search request to API
     *@return	JSON API's response
    */
    public function cloud_search() {
        if (!empty($_REQUEST['search'])) {
            $search_for	= sanitize_text_field($_REQUEST['search']);
            $url = $this->api_url . $this->api_search . $search_for;
            $req_res = $this->call($url);
            wp_send_json($req_res);
        }
    }

    /**
     * Adds a new snippet
     * 
     * MUST send a title to the API
     * Text is optional
     * 
     * @return	JSON array with API's response
     */
    public function cloud_add() {
        if (!empty($_REQUEST['text'])) {
            
            $title = orbisius_child_theme_creator_get_request('title');
            $title = sanitize_text_field($title);
            
            $text = orbisius_child_theme_creator_get_request('text');
            $text = sanitize_text_field($text);

            $params = [
                'orb_cloud_lib_data' => [
                    'cmd' => 'item.add',
                    'title' => $title,
                    'content' => $text,
                ]
            ];
            
            $url = $this->api_url;
            $req_res = $this->call($url, $params);
            wp_send_json($req_res);
        }
    }

    /**
     * Updates a snippet by ID
     * 
     * MUST send an ID to the API
     * 
     * @return	JSON array with API's response
     */
    public function cloud_update() {
    	if (isset($_POST['id'])) {
    		$snippetId	=  sanitize_text_field($_POST['id']);
    		
    		if (isset($_POST['title'])) {
    			$snippetTitle	= sanitize_text_field($_POST['title']);
    		}
    	
    		if (isset($_POST['text'])) {
    			$snippetText	=  sanitize_text_field($_POST['text']);
    		}
    		
    		$url	= 'http://orb-ctc.qsandbox.com/?orb_cloud_lib_data[cmd]=item.update&orb_cloud_lib_data[id]='. $snippetId . '&orb_cloud_lib_data[title]='. $snippetTitle . '&&orb_cloud_lib_data[content]=' . $snippetText;
    		//$url	= $this->api_url . '' . $snippetTitle . 'text=' . $snippetText;
    	
    		wp_send_json($this->call($url));
    	}
    }

    /**
     * Deletes snippet by id
     * 
     * MUST send an ID to the API
     */
    public function cloud_delete() {
    	if (isset($_POST['id'])) {
    		$id	= sanitize_text_field($_POST['id']);
    	
    		$url	= 'http://orb-ctc.qsandbox.com/?orb_cloud_lib_data[cmd]=item.delete&orb_cloud_lib_data[id]='. $id;
    		//$url	= $this->api_url . '' . $id . 'text=' . $snippetText;
    		
    		wp_send_json($this->call($url));
    	}
    }

    public function get_current_tab_id() {
        $cur_tab_id = empty($_REQUEST['tab']) ? $this->tabs[0]['id'] : wp_kses( $_REQUEST['tab'], [] );
        return $cur_tab_id;
    }
    
    /**
     * 
     */
    public function render_tabs() {
        $url = admin_url( 'themes.php?page=orbisius_child_theme_creator_theme_editor_action' );
        $cur_tab_id = $this->get_current_tab_id();
        ?>
        <div id="tabs">
             <h2 class="nav-tab-wrapper"> 
                <ul>
                    <?php foreach ( $this->tabs as $tab_rec ) : ?>
                        <?php
                        if (!$this->should_render_tab($tab_rec)) {
                            continue;
                        }
                        
                        $tab_url = add_query_arg( 'tab', $tab_rec['id'], $url );
                        $extra_tab_css = $tab_rec['id'] == $cur_tab_id ? 'nav-tab-active' : '';
                        ?>
                        <!--                     <a href="<?php //echo esc_url( $tab_url ); ?>" class="nav-tab <?php // echo $extra_tab_css;?>"><?php //echo $tab_rec['label'];?></a> -->

                        <li><a href="<?php echo '#' . $tab_rec['id']; ?>"><?php echo $tab_rec['label'];?></a></li>
                    <?php endforeach; ?>
                </ul>
             </h2>
        <?php
    }
    
    /**
     * 
     * @param str $tab_id
     */    
    public function render_tab_content( $tab_id = '' ) {
    	$tab_id = empty($tab_id) ? $this->get_current_tab_id() : $tab_id; 
        
        $method_name = 'render_tab_content_' . $tab_id;
        
        if (method_exists( $this, $method_name)) {
            $this->$method_name();
        } else {
            echo "<!-- OCTC:Error: Invalid tab method. -->";
        }
    }
    
    public function render_tab_content_orb_ctc_ext_cloud_lib_search() {
        ?>
        <!-- Search Snippets -->
       <div id="orb_ctc_ext_cloud_lib_search" class="tabcontent">
        <span class="descr">Start typing the title of your snippet to see suggestions</span>
        <br />
        <input class="selector" id="search_text"></input>
        <input class="button button-primary" type="button" id="snippet_search_btn" value="Search" />
        
        <div class="found_snippet">
            <span class="label">Title:</span>
            <input class="widefat" type="text" id="found_snippet_title"></textarea>
            <br />
            <span class="label">Snippet:</span>
            <textarea class="widefat" id="found_snippet_text"></textarea>
        </div>
        </div>
        
        <!-- /Search Snippets -->
        <?php
    }
    
    
    public function render_tab_content_orb_ctc_ext_cloud_lib_add() {
        ?>
         <!--New Snippet--> 
        <div id="orb_ctc_ext_cloud_lib_add" class="tabcontent">
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
                   <!-- <input class="button" type="button button-primary" id="snippet_save_btn" value="Save"> -->
                     <input class="button button-primary" type="button" id="snippet_save_btn" value="Save"> 
            <?php endif; ?>
        </div>
        <!-- /New Snippet -->
        <!-- Confirm dialog save snippet -->
        <div id="snippet_confirm_dialog" title="">
            <p>Are you sure you want to save a snippet without any content?</p>
        </div>
        <!-- /Confirm dialog save snippet -->
        </div>

        <?php
    }
    
    /**
     * Manage snippets tab view
     * 
     * Shows all available snippets with View, Edit and Delete button
     */
    public function render_tab_content_orb_ctc_ext_cloud_lib_manage() {
         $all_snippets = $this->get_user_snippets();
         ?>
         <div id="orb_ctc_ext_cloud_lib_manage" class="tabcontent">
         <!-- Manage snippets -->
         <div class="manage_snippets">
            <h3>My Snippets</h3>
            <div class="manage_snippets_table_wrapper">
                <table>
                   <?php foreach( $all_snippets["data"] as $key) { ?>
                   <tr data-id="<?php echo $key['id']; ?>" data-title="<?php echo $key['title']; ?>" data-content="<?php echo $key['content']; ?>">
                      <td id="td_title"><?php echo $key['title']; ?></td>
                      <td><!--<input class="button snippet_view_btn" type="button" value="View"></td>
                      <td><input class="button snippet_edit_btn" type="button" value="Edit"></td>-->	                    
                      <input class="button snippet_edit_view_btn" type="button" value="View / Edit"></td>
                      <td><input class="button snippet_delete_btn" type="button" value="Delete"></td>
                   </tr><?php } ?>
                </table>
            </div>

            <!-- Edit snippet window -->
            <div id="edit_snippet">
                   <h3>Edit Snippet</h3>
                   <input class="edit_title">
                   <br />
                   <textarea class="edit_content"></textarea>
                   <br />
                   <br />
            </div>
             <!-- /Edit snippet window -->

            <!-- View snippet window -->
            <div id="view_snippet">
                <h3>View Snippet</h3>
                <input class="view_title">
                <br />
                <textarea class="view_content"></textarea>
                <br />
                <br />
               <!-- /View snippet window -->
            </div>
            <!-- /View snippet window -->
        </div>
        <!-- /Manage snippets -->  
         
         <!-- Delete snippet confirm dialog -->
        <div id="snippet_confirm_dialog_delete" title="">
            <p>Are you sure you want to delete this snippet with title <span class="delete_snippet_title"></span>?</p>
        </div>
        <!-- /Delete snippet confirm dialog -->
        </div>
         <?php
    }
    
    /**
     * About tab view
     * 
     * Shows all available snippets with View, Edit and Delete button
     */
    public function render_tab_content_orb_ctc_ext_cloud_lib_signup() {
        ?>
         <div id="orb_ctc_ext_cloud_lib_signup" class="tabcontent">
            <div class="orb_ctc_ext_cloud_lib_signup_wrapper">
                <h3>Sign up</h3>
                <div class="">
                    <form name="orb_ctc_signup_form" id="loginform" method="post">
                            <p>
                                <label for="user_login">Username or Email Address<br />
                                <input type="text" name="log" id="user_login" class="input" value="" size="20" /></label>
                            </p>
                            <p>
                                <label for="user_pass">Password<br />
                                <input type="password" name="pwd" id="user_pass" class="input" value="" size="20" /></label>
                            </p>
                            <p class="submit">
                                <input type="submit" name="wp-submit" id="wp-submit"
                                       class="button button-primary button-large" value="Join" />
                            </p>
                    </form>
                </div>
            </div> <!-- /orb_ctc_ext_cloud_lib_signup_wrapper -->  
        </div>
        <?php
    }
    
    /**
     * About tab view
     * 
     * Shows all available snippets with View, Edit and Delete button
     */
    public function render_tab_content_orb_ctc_ext_cloud_lib_account() {
        $user_api = orbisius_child_theme_creator_user::get_instance();
        $api_key = $user_api->api_key();
        
        ?>
         <div id="orb_ctc_ext_cloud_lib_account" class="tabcontent">
            <div class="orb_ctc_ext_cloud_lib_account_wrapper">
                <h3>Account</h3>
                <div class="">
                    Orbisius API Key <?php echo $api_key; ?>
                </div>
            </div> <!-- /orb_ctc_ext_cloud_lib_account_wrapper -->  
        </div>
        <?php
    }
    
    /**
     * About tab view
     * 
     * Shows all available snippets with View, Edit and Delete button
     */
    public function render_tab_content_orb_ctc_ext_cloud_lib_about() {
         ?>
         <div id="orb_ctc_ext_cloud_lib_about" class="tabcontent">
            <div class="orb_ctc_ext_cloud_lib_about_wrapper">
                <h3>About</h3>
                <div class="">
                    Orbisius Cloud library is a service that allows you to store your snippets, license keys in the cloud.
                    With your Orbisius account you can store up to 10 snippets.
                </div>
            </div> <!-- /orb_ctc_ext_cloud_lib_about_wrapper -->  
        </div>
         <?php
    }
    
    /**
     * Manage snippets tab
     * Displays all present snippets
     * 
     * @return array	decoded response from API
     */
    public function get_user_snippets() {
        $params = [
            'orb_cloud_lib_data' => [
                'cmd' => 'item.list',
            ]
        ];

        $json_api_response = $this->call($this->api_url, $params);
        
        return $this->decode_response( $json_api_response );
    }
    
    /**
     * 
     * @param str $json_api_response
     * @return array
     */
    public function decode_response($json_api_response) {
        $def_res = new orbisius_child_theme_creator_result();
        $json = empty($json_api_response) || ! is_scalar($json_api_response)
                ? $def_res->to_array()
                : json_decode( $json_api_response, true );
        return $json;
    }
    
    /**
     * Performs some checks to decide which tabs to show when the user hasn't
     * joined Orbisius.
     * if the api key exists skip signup tab if it doesn't leave only about & signup tabs
     * @param array $tab_rec
     */
    public function should_render_tab($tab_rec = []) {
        $user_api = orbisius_child_theme_creator_user::get_instance();
        $api_key = $user_api->api_key();
        $render = 1;
        
        if (!empty($api_key)) {
            if (preg_match('#signup#si', $tab_rec['id'])) {
                $render = 0;
            }
        } else {
            if (!preg_match('#signup|about#si', $tab_rec['id'])) {
                $render = 0;
            }
        }
        
        return $render;
    }
    
    /**
     * 
     * @param array $ctx
     */
    public function render_ui($ctx = []) {
        $place = empty($ctx['place']) ? 'left' : $ctx['place'];
        $user_api = orbisius_child_theme_creator_user::get_instance();
        $api_key = $user_api->api_key();
        ?>
        <div class="orb_cloud_lib_wrapper_<?php echo $place;?>" class="orb_cloud_lib_wrapper orb_cloud_lib_wrapper_<?php echo $place;?>">
            <div class="snippet_wrapper">
                <h3>Orbisius Cloud Library</h3>
                <?php $this->render_tabs(); ?>
                <br/>
                <?php
                    foreach ( $this->tabs as $tab_rec ) {
                        if (!$this->should_render_tab($tab_rec)) {
                            continue;
                        }
                        
                        $this->render_tab_content( $tab_rec['id'] );
                    }
                ?>
            </div>
        </div> <!-- /Snippet Library Wrapper -->
        <?php
    }
}