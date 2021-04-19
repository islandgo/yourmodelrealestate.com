( function() {

	var app = {

		aosInit: function() {

			setTimeout(function(){
				AOS.init();
			}, 1000);
		},

		initDetectScroll: function() {
			if( jQuery(window).width() > 991 && jQuery(window).scrollTop()  > 56 ) {
				jQuery('header.header').addClass('show-fixed animated fadeInDown');
			} else {
				jQuery('header.header').removeClass('show-fixed animated fadeInDown');
			}
		},

		initNavSlide: function(){
			jQuery('#nav li .sub-menu, #nav2 li .sub-menu').css('display','none');
                
            jQuery("#nav li, #nav2 li").hover(
                function() {
                    jQuery(this).find("ul.sub-menu").eq(0).animate({"height": "show", "opacity": "show"}, 600, "swing");
                },
                function() {
                    jQuery(this).find("ul.sub-menu").eq(0).hide();
                },
			);
		},
		
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
				focusOnSelect: true,
				responsive: [
					{
						breakpoint: 992,
						settings: {
						slidesToShow: 2,
						slidesToScroll: 1,
						}
					},
				]
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

		app.aosInit();

		app.initNavSlide();
		
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

	jQuery(window).on('scroll', function(){
		app.initDetectScroll();
	})


})();