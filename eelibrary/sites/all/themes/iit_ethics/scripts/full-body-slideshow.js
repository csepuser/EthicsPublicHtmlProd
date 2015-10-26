(function($){
	$(document).ready(function(){

        if ($('.full-body-slideshow .flexslider').length > 0) {
            var currentMedia = $('#media-check').css('font-family').replace(/^['"]+|\s+|\\|(;\s?})+|['"]$/g, '');
            var newMedia = '';
            var $slides = $('.full-body-slideshow .slides li');

            if (currentMedia === 'smartphone_portrait' || currentMedia === 'smartphone_landscape' || currentMedia === 'tablet_portrait') {
                $slides.each(function(){
                    $('.slide-image', $(this)).prependTo($('.slideshow-item', $(this)));
                });
            }

            $(window).resize(function(){
                newMedia = $('#media-check').css('font-family').replace(/^['"]+|\s+|\\|(;\s?})+|['"]$/g, '');

                if (currentMedia !== newMedia) {
                    var newMediaType = (newMedia === 'smartphone_portrait' || newMedia === 'smartphone_landscape' || newMedia === 'tablet_portrait') ? 'mobile' : 'notmobile';
                    var currentMediaType = (currentMedia === 'smartphone_portrait' || currentMedia === 'smartphone_landscape' || currentMedia === 'tablet_portrait') ? 'mobile' : 'notmobile';

                    if (currentMediaType === 'notmobile' && newMediaType === 'mobile') {
                        //Going from not moblie to mobile
                        //console.log('to mobile');
                        $slides.each(function(){
                            $('.slide-image', $(this)).prependTo($('.slideshow-item', $(this)));
                        });

                    } else if (currentMediaType === 'mobile' && newMediaType === 'notmobile') {
                        //Going from mobile to not moblie
                        //console.log('from mobile');
                        $slides.each(function(){
                            $('.slide-image', $(this)).appendTo($('.slideshow-item', $(this)));
                        });
                    }
                    
                    currentMedia = newMedia;
                }
            });
        }

	});
})(jQuery);