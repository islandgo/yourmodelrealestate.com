( function() {

	var app = {
		
		initNavigation: function() {
			var $nav = jQuery( '#nav' );
			if ( $nav.length > 0 ) $nav.navTabDoubleTap();
		},
		initFeaturedProperties: function() {
			/* Put featured properties code here */
			var featuredPropertiesSlick = ".featured-property-slick";
			$(featuredPropertiesSlick).slick({
				slidesToShow: 3,
				dots: false,
				arrows: false,
				focusOnSelect: true
			});
			$('.hp-featured-properties .slick-next').click(function() {
				$(featuredPropertiesSlick).slick('slickNext');
			});
			$('.hp-featured-properties .slick-prev').click(function() {
				$(featuredPropertiesSlick).slick('slickPrev');
			});
		},
		initFeaturedCommunities: function() {
			/* Put featured communities code here */
		},
		initTestimonials: function() {
			/* Put testimonials code here */
			var testimonialSlick = ".testimonial-slick";
			$(testimonialSlick).slick({
				slidesToShow: 1,
				dots: true,
				arrows: false,
				focusOnSelect: true
			});
			console.log(234);
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
			$('.hp-featured-videos .slick-next').click(function() {
				$(mainVideoSelector).slick('slickNext');
			});
			$('.hp-featured-videos .slick-prev').click(function() {
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