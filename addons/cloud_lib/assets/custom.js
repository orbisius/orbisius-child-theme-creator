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
	 * Expects JSON array
	 * 
	 */
	$( "#search_text" ).autocomplete( {
		source: function (request, response) {
			$.ajax({
				dataType: "json",
				type : 'post',
				url: ajaxurl,
				data: {
					action: "cloud_autocomplete",
					term: request.term,
				},
				success: function(data) {
					data	= $.parseJSON(data);
					
					response($.map(data.data, function(item) {
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
	 * On success:	shows a new text box with the returned data - content and title
	 * 
	 */
	$('#snippet_search_btn').on("click", function() {
		/**
		 * Holds the value of the input field
		 */
		var search = $("#search_text").val().trim();
		
		if (search !== '') {
			$.ajax({
				//dataType: "json",
				type : "post",
				url: ajaxurl,
				data: {
					action: "cloud_search",
					"search":search
				},
				//success: function (data) {
				success: function(data) {
					data	= $.parseJSON(data);
					
					$.map(data.data, function(item) {
						if (item != '[]') {
							$('.found_snippet').show();
							$("#found_snippet_text").val(item.content).focus();
							$("#found_snippet_title").val(item.title).focus();
						}
					});
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
	$('#snippet_save_btn').on("click", function() {
		 var title	= $('#add_snippet_title').val().trim();
		 
		 var text	= $('#add_snippet_text').val().trim();
		 
		 /**
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
						text: "Yes",
						"class": 'button-primary',
						click: function() {
							$(this).dialog("close"); 
							save_snippet(title, text);
						}
					},
					{
						text: "No",
						"class": 'button',
						click: function() { 
							$(this).dialog("close");
							$('#add_snippet_text').focus();
						}
					}],
				close: function(event, ui) {
					//$('#add_snippet_text').focus();
				}
			 });
		}
		else
		{
			save_snippet(title, text);
		}
	});
	
	/**
	 * Saves a new snippet
	 * 
	 * @param title
	 * @param text
	 */
	function save_snippet(title, text) {
		$.ajax({
			//dataType: "json",
			type : "post",
			url: ajaxurl,
			data: {
				action: "cloud_add",
				"title": title,
				"text": text
			},
			success: function (data) {
				data	= $.parseJSON(data);
			
				if (data.status == '1') {
					alert(data.msg);
				}
				else {
					alert("Problem occurred");
				}
			}
		});
	}
});