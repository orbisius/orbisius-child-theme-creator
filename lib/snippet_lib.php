<?php
$snippet_lib_loader = new orbisius_ctc_cloud_lib;

add_action( 'admin_init', array( $snippet_lib_loader, 'init' ) );

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
	public $api_url	= 'http://orb-ctc.qsandbox.com/';
	
	/*
	 * API which returns with autocomplete suggestions
	 */
	public $api_autocomplete	= '?orb_cloud_lib_data[cmd]=item.list&orb_cloud_lib_data[query]=';
	
	/*
	 * API which returns search results
	 */
	public $api_search	= '?orb_cloud_lib_data[cmd]=item.list&orb_cloud_lib_data[query]=';
	
	
	public $api_add		= '?orb_cloud_lib_data[cmd]=item.add&orb_cloud_lib_data[title]=test&&orb_cloud_lib_data[content]=some_data';

	/**
	 * Add snippet librabry actions
	 */
	public function init() {
		// Snippet autocomplete ajax hook
		add_action( 'wp_ajax_cloud_autocomplete', [$this, 'cloud_autocomplete'] );
		// Snippet search ajax hook
		add_action( 'wp_ajax_cloud_search', [$this, 'cloud_search'] );
		// Add a New Snippet ajax hook
		add_action( 'wp_ajax_cloud_add', [$this, 'cloud_add'] );
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

}