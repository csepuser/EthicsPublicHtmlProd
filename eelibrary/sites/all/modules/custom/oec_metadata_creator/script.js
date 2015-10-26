$(function() {
	create_oec_metadata_validation();
});

function create_oec_metadata_validation() {
    $('#oec-metadata-create-form #edit-meta-publisher, #oec-metadata-create-form #edit-meta-translated-authors').focus(function() {
	    var text = $(this).val();
	    if(jQuery.trim(text) == 'National Academy of Engineering, Online Ethics Center') {
		$(this).val('');
	    } 
	}).blur(function() {
		var text = $(this).val();
		if(!jQuery.trim(text)) {
		    $(this).val('National Academy of Engineering, Online Ethics Center');
		} 		
	    });
}
