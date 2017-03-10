/**
 * Used for the Snippet Library
 */
jQuery( document ).ready( function( $ ) {
	/**
	 * Autocomplete suggestions
	 * 
	 * Returns suggestions from remote source
	 * Suggestions are based on the characters typed in the input field
	 * 
	 * Expects id TITLE in the response
	 * 
	 */
	$( "#snippetLib" ).autocomplete({
		source: function (request, response) {
			$.ajax({
				dataType: "json",
				type : 'Get',
				url: '/wp-content/plugins/orbisius-child-theme-creator-feature_cloud_lib/lib/snippetLib.php',
				data:
				{
					term: request.term,
				},
				success: function (data)
				{
					response($.map(data, function(item) {
						return {
							label: item.title,
						};
					}));
				}
			});
		},
	});
	
	
	/**
	 * Search button
	 * 
	 * On click:	searches for a snippet title matching the criteria from the input field
	 * 
	 * On success:	shows a new text box with the returned data
	 * 
	 */
	$('#snippetLibSearch').on("click", function (){
		/**
		 * Holds the value of the input field
		 */
		var search = $("#snippetLib").val();
		
		if( search.trim() !== '' )
		{
			$.ajax({
				//dataType: "json",
				type : 'GET',
				url: '/wp-content/plugins/orbisius-child-theme-creator-feature_cloud_lib/lib/snippetLibSearch.php',
				data: {"search":search},
				success: function (data)
				{
					$("#snippetLibText").show().val(data).focus();
				}
			});
		}
	});
	
	/**
	 * Add new snippet button
	 * 
	 * On click:	
	 * 
	 * On success:	
	 * 
	 */
	$('#snippetNew').on("click", function (){
		$('.snippetNew').show("slow");
	});
});