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
	 * Gets autocomplete suggestions from API based on data sent to the API
	 * 
	 * @return	JSON array 
	 */
	public function orbisius_ctc_cloud_autocomplete()
	{
		if (isset($_POST['term']))
		{
			$search_for_term	= $_POST['term'];
				
			$url			= 'http://eiguide.com/scrap/snippetLib.php?term=' . $search_for_term;
				
			$response		= wp_remote_get(esc_url_raw($url));
			$api_response	= wp_remote_retrieve_body($response);
			
			echo $api_response;
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
			
			$url			= 'http://eiguide.com/scrap/snippetLibSearch.php?search=' . $search_for;
			
			$response		= wp_remote_get(esc_url_raw($url));
			$api_response	= json_decode(wp_remote_retrieve_body($response), true);
			
			var_dump($api_response);
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
			
			$url			= '' . $snippetTitle . 'text=' . $snippetText;
		
			$response		= wp_remote_get(esc_url_raw($url));
			$api_response	= json_decode(wp_remote_retrieve_body($response), true);
		
			var_dump($api_response);
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