( function() {

	var app = {
		
		initNavigation: function() {
			var $nav = jQuery( '#nav' );
			if ( $nav.length > 0 ) $nav.navTabDoubleTap();
		},
		initFeaturedProperties: function() {
			/* Put featured properties code here */

			$(".featured-property-slick").slick({
				slidesToShow: 3,
				dots: false,
				// arrows: false,
				focusOnSelect: true
			});
		},
		initFeaturedCommunities: function() {
			/* Put featured communities code here */
		},
		initTestimonials: function() {
			/* Put testimonials code here */
		},
		initQuickSearch: function() {
			/* Put quick search code here */
		},
		initCustomVideos: function() {
			var mainVideoSelector = '.feature-slick-video';
			$('.main-slick-video').slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: false,
				fade: true,
				asNavFor: mainVideoSelector
			  });

			$(mainVideoSelector).slick({
				slidesToShow: 3,
				slidesToScroll: 1,
				asNavFor: '.main-slick-video',
				dots: false,
				arrows: false,
				focusOnSelect: true
			});
			$('.slick-action .slick-next').click(function() {
				$(mainVideoSelector).slick('slickNext');
			});
			$('.slick-action .slick-prev').click(function() {
				$(mainVideoSelector).slick('slickPrev');
			});
		}
		
	}

	
	jQuery(document).ready( function() {
		
		/* Initialize navigation */
		app.initNavigation();
		
		/* Initialize featured properties */
		app.initFeaturedProperties();

		/* Initialize featured communities */
		app.initFeaturedCommunities();
		
		/* Initialize testimonials */
		app.initTestimonials();
		
		/* Initialize quick search */
		app.initQuickSearch();

		/* Initialize quick search */
		app.initCustomVideos();
		
	});
	
	jQuery(window).on('load', function(){


	})


})();