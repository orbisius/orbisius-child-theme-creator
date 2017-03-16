/**
 * Used for the Snippet Library
 */
jQuery(document).ready(function($) {
	/**
	 * Snippets search autocomplete suggestions
	 * 
	 * Returns suggestions from remote source
	 * Suggestions are based on the characters typed in the input field
	 * 
	 * Expects id TITLE in the response
	 * 
	 */
	$( "#search_text" ).autocomplete( {
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
	 * Search for a snippet button
	 * 
	 * On click:	searches for a snippet title matching the criteria from the input field
	 * 
	 * On success:	shows a new text box with the returned data
	 * 
	 */
	$('#snippet_search_btn').on("click", function() {
		/**
		 * Holds the value of the input field
		 */
		var search = $("#search_text").val();
		
		if (search.trim() !== '') {
			$.ajax({
				//dataType: "json",
				type : "post",
				url: ajaxurl,
				data: {
					action: "snippet_search",
					"search":search
					},
				success: function (data)
				{
					if (data != '[]') {
						$("#found_snippet_text").show().val(data).focus();
					}
				}
			});
		}
	});
	
	/**
	 * Add a new snippet button
	 * 
	 * On click:	Displays title and text fields
	 * 
	 */
	$('#new_snippet_btn').on("click", function() {
		$('.new_snippet_wrapper').show("slow");
	});
	
	/**
	 * Save a new snippet button
	 * 
	 * On click:	If title is missing, cannot proceed
	 * 		If text is missing, asks for confirmation to proceed
	 * 
	 */
	$('.snippet_save').on("click", function() {
		 var title	= $('#add_snippet_title').val();
		 
		 var text	= $('#add_snippet_text').val();
		 
		 /*
		  * Snippet cannot be added without a Title
		  * 
		  * Snippet can be added without text
		  * 
		  */
		if (title == '') {
			alert('Please, enter Snippet Title');
			$('#add_snippet_title').focus();
			return;
		}
		else if (text == '') {
			 $("#snippet_confirm_dialog").dialog( {
				dialogClass: 'no-close',
				modal: true,
				buttons: [{
						text: "OK",
						"class": 'button-primary',
						click: function() {
							// send information to API 
						}
					},
					{
						text: "No",
						"class": 'button',
						click: function() { 
							$(this).dialog("close"); 
						}
					}],
				close: function(event, ui) {
					$('#add_snippet_text').focus();
				}
			 });
		}
	});
});