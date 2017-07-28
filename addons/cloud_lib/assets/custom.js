/**
 * Used for the Snippet Library
 */
jQuery(document).ready(function($) {
    $('.snippet_copy_btn').on('click', function (e) {
        
    } );
    
    $('#orb_ctc_ext_cloud_lib_account_log_out').on('click', function (e) {
        e.preventDefault();
        
        var res_container = $('.orb_ctc_ext_cloud_lib_signup_wrapper').find('.result');
        res_container.html('Please, wait');
        var params = {};
        
        $.ajax({
            type : 'post',
            url: ajaxurl + '?action=orb_ctc_log_out',
            data: params,
            success: function(json) {
                if (json.status) {
                    res_container.html('Please, wait');
                    window.location.reload();
                } else {
                    res_container.html(json.msg);
                }
            }
        });
    } );
    
    $('.orb_ctc_signup_form').on('submit', function (e) {
        e.preventDefault();
        var params = $(this).serialize();
        
        if ($('#orb_ctc_pass').val() != $('#orb_ctc_pass2').val() ) {
            alert('Error: Passwords do not match');
            return false;
        }

        var submit_btn = $(this).find(':submit');
        var res_container = $('.orb_ctc_ext_cloud_lib_signup_wrapper').find('.result');
        res_container.html('Please, wait');
        submit_btn.hide();
        
        $.ajax({
            type : 'post',
            url: ajaxurl + '?action=orb_ctc_signup',
            data: params,
            success: function(json) {
                if (json.status) {
                    res_container.html('Please, wait');
                    window.location.reload();
                } else {
                    res_container.html(json.msg);
                    submit_btn.show();
                }
            }
        });
        
        return false;
    })
    
    $('.orb_ctc_login_form').on('submit', function (e) {
        e.preventDefault();
        var params = $(this).serialize();
        
        var submit_btn = $(this).find(':submit');
        var res_container = $('.orb_ctc_ext_cloud_lib_signup_wrapper').find('.result');
        res_container.html('Please, wait');
        submit_btn.hide();
        
        $.ajax({
            type : 'post',
            url: ajaxurl + '?action=orb_ctc_login',
            data: params,
            success: function(json) {
                if (json.status) {
                    res_container.html('Please, wait');
                    window.location.reload();
                } else {
                    res_container.html(json.msg);
                    submit_btn.show();
                }
            }
        });
        
        return false;
    })
	/**
	 * Snippets search autocomplete suggestions
	 * 
	 * Returns suggestions from remote source
	 * Suggestions are based on the characters typed in the input field
	 * 
	 * Expects JSON array
	 * @see https://stackoverflow.com/questions/9656523/jquery-autocomplete-with-callback-ajax-json
	 */
	 $( "#search_text" ).autocomplete( {
            minLength: 3,
            open: function() {
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            },
            source: function (request, response) {
                $.ajax({
                    type : 'post',
                    url: ajaxurl,
                    data: {
                        action: "cloud_autocomplete",
                        term: request.term,
                    },
                    success: function(json) {
                        response($.map(json.data, function(item) {
                            return {
                                value: item.id,
                                label: item.title
                            };
                        }));
                    },
                    select: function (event, ui) {
                      //  return false;
                    }
                });
            },
	});
	
	/**
	 * Search for a snippet button
	 */
	$('#snippet_search_btn').on("click", function() {
		var search = $("#search_text").val().trim();
	    
		if (search !== '') {
		    search_snippets(search);
		}
		else
        	{
		    $("#search_text").focus();
        	}
		
	});
	
	/**
	 * Press enter to search for a snippet
	 */
	$('#search_text').keypress(function(e) {
		if(e.keyCode == 13)
		{
		// e.preventDefault();
		//  sendSelected(this.value);
		//  $(this).autocomplete('close');
		var search = $("#search_text").val().trim();
	    
		if (search !== '') {
		    search_snippets(search);
		}
		else
        	{
    		    $("#search_text").focus();
        	}
	    }
	});
	
	/**
	 * Search for a snippet button
	 * 
	 * On click:	searches for a snippet title matching the criteria from the input field
	 * 
	 * On success:	shows a new text box with the returned data - content and title
	 * 
	 */
	//$('#snippet_search_btn').on("click", function() {
	$( "#search_text" ).on( "autocompleteselect", function( event, ui ) {
		/**
		 * Holds the value of the input field
		 */
		//var search = $("#search_text").val().trim();
		var search	= ui.item.label;
		if (search !== '') {
		    search_snippets(search);
		}
		else
		{
		    $("#search_text").focus();
		}
	});
	
	function search_snippets (search) {
	    $.ajax({
		//dataType: "json",
		type : "post",
		url: ajaxurl,
		data: {
			action: "cloud_search",
			"search":search
		},
		//success: function (data) {
		success: function(json) {
                    if (json.status) {
                        if (json.data.length > 0) {
                            $.map(json.data, function(item) {
                                if (item != '[]') {
                                    $('.found_snippet').show();
                                    $("#found_snippet_text").val(item.content).focus();
                                    $("#found_snippet_title").val(item.title).focus();
                                }
                            });
                        }
                    }
		}
	});
	}
	
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
            snippet_update(0, title, text);
	});
	
	/**
	 * Delete a snippet by id button
	 * 
	 */
	$('#manage_snippets_table').on("click", '.snippet_delete_btn', function() {
		var id		= $(this).parents('tr').data('id');
		var title	= $(this).parents('tr').data('title');
		
		$('.delete_snippet_title').text(title);
		
		$("#snippet_confirm_dialog_delete").dialog( {
        		dialogClass: 'snippet_confirm_dialog_delete',
        		modal: true,
        		resizable: false,
        		draggable: false,
        		buttons: [{
        				text: "Yes",
        				"class": 'button-primary',
        				click: function() {
        					$(this).dialog("close"); 
        					delete_snippet(id);
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
                    $('.snippet_delete_btn').blur();
        		}
		});
	});
	
	/**
	 * Delete snippet by id
	 * 
	 * @param id
	 * 
	 */
	function delete_snippet(id) {
            $("tr[data-id='" + id + "']").remove();
//            $("tr[data-id='" + id + "']").fadeOut(300, function() { $(this).remove(); });
            
            if ($('#manage_snippets_table tr.snippet_row').length - 1 <= 0) {
                $('#no_snippets_row').show();
            } else {
                $('#no_snippets_row').hide();
            }

            $.ajax({
		url: ajaxurl,
		data: {
                    action: "cloud_delete",
                    id: id
		},
		success: function (json) {
                    if (json.status) {
                        
                    } else {
                        alert(json.msg);
                    }
		}
            });
	}
	
	/**
	 * Edit snippet button
	 * 
	 * Displays Edit snippet window
	 * 
	 */
	$('.snippet_edit_btn').on("click", function() {
		var id		= $(this).parents('tr').data('id');
		var title	= $(this).parents('tr').data('title');
		var content	= $(this).parents('tr').data('content');
		
		$('.edit_title').val(title);
		$('.edit_content').val(content);
		//$('.edit_snippet').show();
        	
		$("#edit_snippet").dialog( {
                    dialogClass: 'edit_snippet',
                    modal: true,
                    resizable: false,
                    buttons: [
                        {
                            text: "Save",
                            "class": 'button-primary',
                            click: function() {
                                    var newTitle = $('.edit_title').val();
                                    var newContent = $('.edit_content').val();
                                    $(this).dialog("close"); 
                                    snippet_update(id, newTitle, newContent);
                            }
                        },
                        {
                            text: "Close",
                            "class": 'button',
                            click: function() { 
                                    $(this).dialog("close");
                            }
                        }
                    ],
                    close: function(event, ui) {
                    }
            });
	});
	
	/**
	 * Edit / view window combined
	 * 
	 */
	$('#manage_snippets_table').on("click", '.snippet_edit_view_btn', function() {
		var id		= $(this).parents('tr').data('id');
		var title	= $(this).parents('tr').data('title');
		var content	= $(this).parents('tr').data('content');
		
		$('.edit_title').val(title);
		$('.edit_content').val(content);
		//$('.edit_snippet').show();
    	
		$("#edit_snippet").dialog( {
                    dialogClass: 'edit_snippet',
                    modal: true,
                    resizable: false,
                    draggable: false,
                    buttons: [/*{
                                    text: "Copy",
                                    //"class": 'button',
                                    click: function() {
                                    }
                            },*/
                            {
                                    text: "Update",
                                    "class": 'button-primary',
                                    click: function() {
                                            var newTitle = $('.edit_title').val();
                                            var newContent = $('.edit_content').val();
                                            $(this).dialog("close"); 
                                            snippet_update(id, newTitle, newContent);
                                    }
                            },
                            {
                                    text: "Close",
                                    "class": 'button',
                                    click: function() { 
                                            $(this).dialog("close");
                                    }
                            }],
                    close: function(event, ui) {
                         $('.snippet_edit_view_btn').blur();
                    }
		});
	});
	
	function snippet_update(id, title, text) {
            var $row_to_update = $("tr[data-id='" + id + "']");
            
            if (id <= 0) {
                $('#no_snippets_row').hide();
                $row_to_update = $('#manage_snippets_table tr.snippet_row:first').clone().show();
            }

            $row_to_update.find('.snippet_title').html('Please, wait...');
            $row_to_update.find('.snippet_content').empty().hide();
            $('#manage_snippets_table').append($row_to_update);

            $.ajax({
                url: ajaxurl,
                data: {
                    action: "orb_ctc_addon_cloud_lib_cloud_update",
                    id : id,
                    title : title,
                    text : text
                },
                success: function (json) {
                    if (json.status) {
                       $row_to_update.data('id', json.data.id);
                       $row_to_update.data('title', title );
                       $row_to_update.data('content', text);
                       $row_to_update.find('.snippet_title').html(title);
                       $row_to_update.find('.snippet_content').html(text);
                       $row_to_update.find('.snippet_content').show();
                    } else {
                        alert("Error: " + json.msg);
                    }
                }
            });
        }
	
	/**
	 * View snippet button
	 * 
	 * Displays View snippet window
	 * 
	 */
	$('.snippet_view_btn').on("click", function() {
		
		//var id	= $(this).parents('tr').data('id');
		var title	= $(this).parents('tr').data('title');
		var content	= $(this).parents('tr').data('content');
		
		$('.view_title').val(title);
		$('.view_content').val(content);
		//$('.edit_snippet').show();
        	
		$("#view_snippet").dialog( {
    		dialogClass: 'view_snippet',
    		modal: true,
    		resizable: false,
    		buttons: [{
    				text: "Copy",
    				"class": 'button-primary',
    				click: function() {
    					$(this).dialog("close"); 
    					//todo make copy button actually work
    				}
    			},
    			{
    				text: "Close",
    				"class": 'button',
    				click: function() { 
    					$(this).dialog("close");
    				}
    			}],
    		close: function(event, ui) {
    		}
		});
	});
	
        $( function() {
            $( "#tabs" ).tabs();
          } );
})(jQuery);