function modify_search_target() {
    $('#header #search-theme-form').submit(function() {
	    var search_str = $('#edit-search-theme-form-1').val();
	    if(jQuery.trim(search_str)) {
		window.location = '/ecodes/search-codes?field_contents_value='+search_str+'&title='+search_str+'&title_1='+search_str;
	    } else {
		alert('Please enter a valid search term.');
	    }
	    return false;
	});

    $('#inner-search-form').submit(function() {
	    var search_str = $('#inner-search-text').val();
	    if(jQuery.trim(search_str)) {
		window.location = '/ecodes/search-codes?field_contents_value='+search_str+'&title='+search_str+'&title_1='+search_str;
	    } else {
		alert('Please enter a valid search term.');
	    }
	    return false;
	});
}

$(function(){
	modify_search_target();
    });