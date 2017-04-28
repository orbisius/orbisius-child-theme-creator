<?php

/**
 * Autocomplete
 * Search for a snippet
 * Add a snippet
 * 
 */
class orbisius_ctc_cloud_lib {
    /**
     * @var string	Url of remote API
     */
    public $api_url	= '';
    public $live_api_url = 'https://orbisius.com/';
    public $dev_api_url	= 'http://orb-ctc.qsandbox.com/';
    public $staging_api_url	= 'http://orb-ctc.qsandbox.com/';
    private $tabs = [];

    /*
     * API which returns with autocomplete suggestions
     */
    public $api_autocomplete	= '?orb_cloud_lib_data[cmd]=item.list&orb_cloud_lib_data[query]=';

    /*
     * API which returns search results
     */
    public $api_search	= '?orb_cloud_lib_data[cmd]=item.list&orb_cloud_lib_data[query]=';


    public $api_add		= '?orb_cloud_lib_data[cmd]=item.add&orb_cloud_lib_data[title]=test&&orb_cloud_lib_data[content]=some_data';

    public function __construct() {
        if ( !empty( $_SERVER['DEV_ENV'])) {
            $this->api_url = $this->dev_api_url;
        } elseif ( !empty($_SERVER['HTTP_HOST']) 
                && (stripos($_SERVER['HTTP_HOST'], 'orb-ctc.qsandbox.com') !== false)) {
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
                'id' => 'orb_ctc_ext_cloud_lib_account',
                'label' => __( 'Account', 'orbisius-child-theme-creator' ),
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

        wp_register_script( 'orbisius_ctc_cloud_lib', plugins_url("/addons/cloud_lib/assets/custom.js", ORBISIUS_CHILD_THEME_CREATOR_MAIN_PLUGIN_FILE), array('jquery', ),
            filemtime( plugin_dir_path( ORBISIUS_CHILD_THEME_CREATOR_MAIN_PLUGIN_FILE ) . "/addons/cloud_lib/assets/custom.js" ), true);
        wp_enqueue_script( 'orbisius_ctc_cloud_lib' );

        //Custom styles for snippet library
        wp_register_style('orbisius_ctc_cloud_lib', plugins_url("/addons/cloud_lib/assets/custom.css", ORBISIUS_CHILD_THEME_CREATOR_MAIN_PLUGIN_FILE), null,
            filemtime( plugin_dir_path( ORBISIUS_CHILD_THEME_CREATOR_MAIN_PLUGIN_FILE ) . "/addons/cloud_lib/assets/custom.css" ), true );
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
    }

    /**
     * Send request to API and get response
     * 
     * @return JSON array	response from the api
     */
    public function get_remote($url) {
            $response		= wp_remote_get(esc_url_raw($url));
            $api_response	= wp_remote_retrieve_body($response);

            return $api_response;
    }

    /**
     * Gets autocomplete suggestions from API based on data sent to the API
     * 
     * @return	JSON API's response
     */
    public function cloud_autocomplete() {
            if (isset($_POST['term'])) {
                    $search_for_term	= sanitize_text_field($_POST['term']);

                    $url	= $this->api_url . $this->api_autocomplete . $search_for_term;

                    wp_send_json($this->get_remote($url));
            }
    }

    /**
     * Sends search request to API
     *
     *@return	JSON API's response
    */
    public function cloud_search() {
            if (isset($_POST['search'])) {
                    $search_for	= sanitize_text_field($_POST['search']);

                    $url		= $this->api_url . $this->api_search . $search_for;

                    wp_send_json($this->get_remote($url));
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
            if (isset($_POST['title'])) {
                    $snippetTitle	= sanitize_text_field($_POST['title']);

                    if (isset($_POST['text'])) {
                            $snippetText	=  sanitize_text_field($_POST['text']);
                    }
                    $url	= 'http://orb-ctc.qsandbox.com/?orb_cloud_lib_data[cmd]=item.add&orb_cloud_lib_data[title]='. $snippetTitle . '&&orb_cloud_lib_data[content]=' . $snippetText;
                    //$url	= $this->api_url . '' . $snippetTitle . 'text=' . $snippetText;

                    wp_send_json($this->get_remote($url));
            }
    }

    /**
     * Updates snippet
     */
    public function cloud_save() {

    }

    /**
     * Deletes snippet
     */
    public function cloud_delete() {

    }

    public function get_current_tab_id() {
        $cur_tab_id = empty($_REQUEST['tab']) ? $this->tabs[0]['id'] : wp_kses( $_REQUEST['tab'], [] );
        return $cur_tab_id;
    }
    
    public function render_tabs() {
        $url = admin_url( 'themes.php?page=orbisius_child_theme_creator_theme_editor_action' );
                
        $cur_tab_id = $this->get_current_tab_id();
        
        ?>
            <h2 class="nav-tab-wrapper">
                <?php foreach ( $this->tabs as $tab_rec ) : ?>
                    <?php 
                    $tab_url = add_query_arg( 'tab', $tab_rec['id'], $url );
                    $extra_tab_css = $tab_rec['id'] == $cur_tab_id ? 'nav-tab-active' : '';
                    ?>
                    <a href="<?php echo esc_url( $tab_url ); ?>" class="nav-tab <?php echo $extra_tab_css;?>"><?php echo $tab_rec['label'];?></a>
                <?php endforeach; ?>
            </h2>
        <?php
    }
    
    public function render_tab_content( $tab_id = '' ) {
        $tab_id = empty($tab_id) ? $this->get_current_tab_id() : $tab_id;
        
        $method_name = 'render_tab_content_' . $tab_id;
        
        if (method_exists( $this, $method_name)) {
            $this->$method_name();
        } else {
            echo "Invalid tab method.";
        }
    }
    
    public function render_tab_content_orb_ctc_ext_cloud_lib_search() {
        ?>
        <!-- Search Snippets -->
        <input class="selector" id="search_text"></input>
        <input class="button button-primary" type="button" id="snippet_search_btn" value="Search" />
        
        <br />
        <div class="found_snippet">
            <strong>Snippet:</strong>
            <textarea class="widefat" id="found_snippet_text"></textarea>
            <strong>Title:</strong>
            <input class="widefat" type="text" id="found_snippet_title"></textarea>
        </div>
        <!-- /Search Snippets -->
        <?php
    }
    
    
    public function render_tab_content_orb_ctc_ext_cloud_lib_add() {
        ?>
         <!--New Snippet--> 
        
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
                    <input class="button" type="button button-primary" id="snippet_save_btn" value="Save">
            <?php endif; ?>
        </div>
        
        <!-- Confirm dialog -->
        <div id="snippet_confirm_dialog" title="">
            <p>Are you sure you want to save a Snippet without any content?</p>
        </div>
        <!-- /Confirm dialog -->
        <!-- /New Snippet -->

        <?php
    }
    
    public function render_ui() {
        ?>
        <!-- Snippet Library Wrapper -->
            <div class="snippet_wrapper">
                    <h3>Orbisius Cloud Library</h3>

                    <?php $this->render_tabs(); ?>
                    <br/>
                    <?php $this->render_tab_content(); ?>
            </div>
            <!-- /Snippet Library Wrapper -->
        <?php
    }
}