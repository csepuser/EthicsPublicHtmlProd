jQuery(document).ready(function($) {
	$('nav.block-menu-block li').hover(function(){
		$(this).css("cursor", "pointer");
	}, function(){
		$(this).css("cursor", "auto");
	});
	$('nav.block-menu-block li').click(function(event){
		var location = $(this).children('a').attr('href');
		window.location.href = location;
	});
	$('nav.block-menu-block li a').click(function(event){
		event.stopPropagation();
	});
});