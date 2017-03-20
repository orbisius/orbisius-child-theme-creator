<?php
$snippet_lib_loader = new orbisius_ctc_cloud_lib;

add_action( 'admin_init', array( $snippet_lib_loader, 'orbisius_ctc_init_actions_cloud_lib' ) );

/**
 * Autocomplete
 * Search for a snippet
 * Add a snippet
 * 
 */
class orbisius_ctc_cloud_lib {
	
	/**
	 * @var string	Url to remote
	 */
	public $api_url	= 'http://eiguide.com/scrap/';
	
	/*
	 * Name of file on the API which returns with autocomplete suggestions
	 */
	public $api_autocomplete_file	= 'snippetLib.php';
	
	/*
	 * Name of file on the API which returns search results
	 */
	public $api_snippet_search_file = 'snippetLibSearch.php';

	/**
	 * Load jQuery widgets
	 */
	public function __construct()
	{
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script( 'jquery-ui-dialog' );
	}
	
	/**
	 * Add snippet librabry actions
	 */
	public function orbisius_ctc_init_actions_cloud_lib()
	{
		// Snippet autocomplete ajax hook
		add_action( 'wp_ajax_orbisius_ctc_cloud_autocomplete', [$this, 'orbisius_ctc_cloud_autocomplete'] );
		// Snippet search ajax hook
		add_action( 'wp_ajax_orbisius_ctc_cloud_search', [$this, 'orbisius_ctc_cloud_search'] );
		// Add a New Snippet ajax hook
		add_action( 'wp_ajax_orbisius_ctc_cloud_add', [$this, 'orbisius_ctc_cloud_add'] );
	}
	
	/**
	 * Send request to API and get response
	 * 
	 * @return response from the api
	 */
	public function orbisius_ctc_get_remote($url)
	{
		$response		= wp_remote_get(esc_url_raw($url));
		$api_response	= wp_remote_retrieve_body($response);
		
		return $api_response;
	}
	
	/**
	 * Gets autocomplete suggestions from API based on data sent to the API
	 * 
	 * @return	JSON array 
	 */
	public function orbisius_ctc_cloud_autocomplete()
	{
		if (isset($_POST['term']))
		{
			$search_for_term	= $_POST['term'];
				
			$url				= $this->api_url . $this->api_autocomplete_file . '?term=' . $search_for_term;
			
			echo $this->orbisius_ctc_get_remote($url);
		}
		
		wp_die();
	}
	
	/**
	 * Sends search request to API
	 *
	 *@return	array parsed from the JSON response of the API
	*/
	public function orbisius_ctc_cloud_search()
	{
		if (isset($_POST['search']))
		{
			$search_for	= $_POST['search'];
			
			$url		= $this->api_url . $this->api_snippet_search_file . '?search=' . $search_for;
			
			var_dump($this->orbisius_ctc_get_remote($url));
		}
		
		wp_die();
	}
	
	/**
	 * Adds a new snippet
	 * 
	 * MUST send a title to the API
	 * Text is optional
	 * 
	 * @return	array	parsed from the JSON response of the API
	 * 			string	if there is no title and request to the API was not sent
	 * 
	 *  @todo	return string with API's response - either Succcessful or Unsuccessful
	 */
	public function orbisius_ctc_cloud_add()
	{
		if (isset($_POST['title']))
		{
			$snippetTitle	= $_POST['title'];
			
			if (isset($_POST['text']))
			{
				$snippetText	=  $_POST['text'];
			}
			
			$url			= $this->api_url . '' . $snippetTitle . 'text=' . $snippetText;
		
			var_dump($this->orbisius_ctc_get_remote($url));
		}
		else
		{
			echo "Please, enter Snippet Title";
		}
		
		wp_die();
	}
	
	/**
	 * Updates snippet
	 */
	public function orbisius_ctc_cloud_save()
	{
	
	}
	
	/**
	 * Deletes snippet
	 */
	public function orbisius_ctc_cloud_delete()
	{
		
	}

}