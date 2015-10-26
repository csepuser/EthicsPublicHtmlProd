// Home Page Javascript
(function($){

	$(document).ready(function(){

		// Initial On Ready Setup
		var currentMedia = $('#media-check').css('font-family').replace(/^['"]+|\s+|\\|(;\s?})+|['"]$/g, '');
		var newMedia = '';
		var $theWindow = $(window);
		var $menu = $('#header-wrapper nav.block-menu-block');
		var globalHeaderHeight;
		var collegeHeaderHeight;
		var windowHeight;
		var $bgImgs = $('img', '#hero-wrapper');
		//var aspectRatio = $bg.width() / $bg.height();
		var aspectRatio = 1.77777777777778;
		var $theViewport = $('#hero-wrapper');
		var SLIDESHOW_ACTIVE = 1;
		var SLIDESHOW_TRANSITION_TIME = 1; //in seconds
		var SLIDESHOW_IMG_TIME = 15; //in seconds
		var availableImgWidths = [ 700, 1140, 1600, 1920 ];


		// Setup Menu Button and Menu
		$('#iit-department-header-branding').append('<div id="button-menu-button">');
		if (currentMedia === 'smartphone_portrait' || currentMedia === 'smartphone_landscape' || currentMedia === 'tablet_portrait') {
			$menu.css('display', 'none');
			$menu.addClass('closed');
		}
		
		$('#button-menu-button').click(function(evt){
			if ($menu.hasClass('open')) {
				$menu.slideUp(400);
				$menu.removeClass('open');
				$menu.addClass('closed');
			} else {
				$menu.slideDown(400);
				$menu.removeClass('closed');
				$menu.addClass('open');
			}
    	});


		// Set initial heights after menu has been set so height is properly calculated
		globalHeaderHeight = $('.region-iit-global-header').height();
		collegeHeaderHeight = $('#header-wrapper').height();
		windowHeight = $theWindow.height();


		// Randomly set one bg image slide to the active slide
		$bgImgs.eq(Math.floor((Math.random() * $bgImgs.length))).addClass('active-slide');


		//load images from data-src attribute
		function setBgImgSource() {
			var window_w = $theWindow.width();

			$bgImgs.each(function(){
				var currentImgWidth = parseInt($(this).attr('data-width'));
				if (!currentImgWidth || ((currentImgWidth < window_w) && (currentImgWidth < availableImgWidths[availableImgWidths.length - 1]))) {
					var chosenImgWidth = availableImgWidths[availableImgWidths.length - 1 ];

					for (var i = 0; i < availableImgWidths.length; i++) {
						if (availableImgWidths[i] >= window_w) {
							chosenImgWidth = availableImgWidths[i];
							break;
						}
					};

					$(this).attr('src', ($(this).attr('data-src') + chosenImgWidth + '.jpg'));
					$(this).attr('data-width', chosenImgWidth);
				}					
			});
		}
		setBgImgSource();

		
		// Home Page Background Next Image
		function homePageBackgroundNext() {
    		var $activeImg = $('img.active-slide', '#hero-wrapper');
    		var $nextImg = $activeImg.next('img').length ? $activeImg.next('img') : $('#hero-wrapper img:first');
    
    		$activeImg.addClass('lastactive-slide');
    
    		$nextImg.css({opacity: 0.0}).addClass('active-slide').animate({opacity: 1.0}, SLIDESHOW_TRANSITION_TIME * 1000, function(){
        	$activeImg.removeClass('active-slide lastactive-slide');
    		}); 
		}
		
		if ($bgImgs.length > 1 && SLIDESHOW_ACTIVE === 1) {
            // More than 1 image in slideshow and set to active -> start animation
            setInterval(homePageBackgroundNext, SLIDESHOW_IMG_TIME * 1000);
        }


		// On Resize Function Declarations
		function checkMediaForMenu() {
            var newMediaType = (newMedia === 'smartphone_portrait' || newMedia === 'smartphone_landscape' || newMedia === 'tablet_portrait') ? 'mobile' : 'notmobile';
            var currentMediaType = (currentMedia === 'smartphone_portrait' || currentMedia === 'smartphone_landscape' || currentMedia === 'tablet_portrait') ? 'mobile' : 'notmobile';

            if (currentMediaType === 'notmobile' && newMediaType === 'mobile') {
                //Going from not moblie to mobile
                //console.log('to mobile');
                $menu.css('display', 'none');
                $menu.removeClass('open').addClass('closed');

            } else if (currentMediaType === 'mobile' && newMediaType === 'notmobile') {
                //Going from mobile to not moblie
                //console.log('from mobile');
                $menu.css('display', 'block');
                $menu.removeClass('closed').addClass('open');
            }
		}

		function resizeViewport() {
			globalHeaderHeight = $('.region-iit-global-header').height();
			collegeHeaderHeight = $('#header-wrapper').height();
			windowHeight = $(window).height();

			if (collegeHeaderHeight > 165) {
				collegeHeaderHeight = 160;
			}

			$('#hero-wrapper').height(windowHeight - globalHeaderHeight - collegeHeaderHeight);
		}

		function resizeBg() {
			if (($theViewport.width() / $theViewport.height()) < aspectRatio) {
				$bgImgs.each(function(){
					$(this).removeClass('bgwidth').addClass('bgheight');
				});
			} else {
				$bgImgs.each(function(){
					$(this).removeClass('bgheight').addClass('bgwidth');
				});
			}
		}

		function centerImg() {
			$bgImgs.each(function(){
				if ($(this).hasClass('bgwidth')) {
					var bgHeightDiff = ($theViewport.width() / aspectRatio) - $theViewport.height();
					//var bgHeightDiff = $(this).height() - $theViewport.height();
					if (bgHeightDiff > 0) {
						$(this).css('top', ((bgHeightDiff / -2) + 'px'));
						$(this).css('left', '0px');
					}
				} else {
					var bgWidthDiff = ($theViewport.height() * aspectRatio) - $theViewport.width();
					//var bgWidthDiff = $(this).width() - $theViewport.width();
					if (bgWidthDiff > 0) {
						$(this).css('left', ((bgWidthDiff / -2) + 'px'));
						$(this).css('top', '0px');
					}
				}
			});

		}


		// On Resize Code
		$theWindow.resize(function(){
			newMedia = $('#media-check').css('font-family').replace(/^['"]+|\s+|\\|(;\s?})+|['"]$/g, '');
			
			if (currentMedia !== newMedia) {
				// Run Code that needs to run when media query changes
                checkMediaForMenu();
                
                currentMedia = newMedia;
            }
			
			resizeViewport();
			setBgImgSource();
			resizeBg();
			centerImg();

		}).resize();

	}); //end ready function

})(jQuery);