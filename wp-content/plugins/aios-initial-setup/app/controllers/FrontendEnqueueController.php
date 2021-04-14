<?php

namespace AiosInitialSetup\App\Controllers;

class FrontendEnqueueController
{
  /**
   * FrontendEnqueue constructor.
   */
  public function __construct()
  {
    add_action('wp_default_scripts', [$this, 'replace_scripts'], -1);
    add_action('wp_enqueue_scripts', [$this, 'enqueue_cdn_libraries']);
    add_filter('script_loader_tag', [$this, 'script_filter'], 10, 2);

    // Add user navigated from same domain
    add_filter('body_class', [$this, 'navigateOnSameDomainAndPostTypeSlug'], 11);

    // fallback: body_class navigateOnSameDomainAndPostTypeSlug
    add_action('wp_footer', [$this, 'domainReferer'], 10);

    // Disabled lazy load by default in WordPress 5.5.x or higher
    add_filter('wp_lazy_loading_enabled', '__return_false');
  }

  // Pre-register scripts on 'wp_default_scripts' action, they won't be overwritten by $wp_scripts->add().
  private function set_script( $scripts, $handle, $src, $deps = [], $ver = false, $in_footer = false ) {
    $script = $scripts->query( $handle, 'registered' );

    if ( $script ) {
      // If already added
      $script->src  = $src;
      $script->deps = $deps;
      $script->ver  = $ver;
      $script->args = $in_footer;

      unset( $script->extra['group'] );

      if ( $in_footer ) {
        $script->add_data( 'group', 1 );
      }
    } else {
      // Add the script
      if ( $in_footer ) {
        $scripts->add( $handle, $src, $deps, $ver, 1 );
      } else {
        $scripts->add( $handle, $src, $deps, $ver );
      }
    }
  }

  /**
   * Replace jQuery Scripts
   *
   * @param $scripts
   */
  public function replace_scripts($scripts)
  {
    $jQueryMigrate = get_option('aios-jquery-migrate', []);

    if ((is_admin() && (isset($jQueryMigrate['admin']) && $jQueryMigrate['admin'] === '1')) || (!is_admin() && (!isset($jQueryMigrate['frontend']) || ($jQueryMigrate['frontend'] ?? '0' !== '1')))) {
      $assets_url = AIOS_INITIAL_SETUP_RESOURCES . 'js/';

      $this->set_script( $scripts, 'jquery-migrate', $assets_url . 'jquery-migrate/jquery-migrate-1.4.1-wp.js', [], '1.4.1-wp' );
      $this->set_script( $scripts, 'jquery-core', $assets_url . 'jquery/jquery-1.12.4-wp.js', [], '1.12.4-wp' );
      $this->set_script( $scripts, 'jquery', false, ['jquery-core', 'jquery-migrate'], '1.12.4-wp' );

      // All the jQuery UI stuff comes here.
      $this->set_script( $scripts, 'jquery-ui-core', $assets_url . 'jquery-ui/core.min.js', ['jquery'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-effects-core', $assets_url . 'jquery-ui/effect.min.js', ['jquery'], '1.11.4-wp', 1 );

      $this->set_script( $scripts, 'jquery-effects-blind', $assets_url . 'jquery-ui/effect-blind.min.js', ['jquery-effects-core'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-effects-bounce', $assets_url . 'jquery-ui/effect-bounce.min.js', ['jquery-effects-core'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-effects-clip', $assets_url . 'jquery-ui/effect-clip.min.js', ['jquery-effects-core'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-effects-drop', $assets_url . 'jquery-ui/effect-drop.min.js', ['jquery-effects-core'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-effects-explode', $assets_url . 'jquery-ui/effect-explode.min.js', ['jquery-effects-core'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-effects-fade', $assets_url . 'jquery-ui/effect-fade.min.js', ['jquery-effects-core'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-effects-fold', $assets_url . 'jquery-ui/effect-fold.min.js', ['jquery-effects-core'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-effects-highlight', $assets_url . 'jquery-ui/effect-highlight.min.js', ['jquery-effects-core'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-effects-puff', $assets_url . 'jquery-ui/effect-puff.min.js', ['jquery-effects-core', 'jquery-effects-scale'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-effects-pulsate', $assets_url . 'jquery-ui/effect-pulsate.min.js', ['jquery-effects-core'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-effects-scale', $assets_url . 'jquery-ui/effect-scale.min.js', ['jquery-effects-core', 'jquery-effects-size'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-effects-shake', $assets_url . 'jquery-ui/effect-shake.min.js', ['jquery-effects-core'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-effects-size', $assets_url . 'jquery-ui/effect-size.min.js', ['jquery-effects-core'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-effects-slide', $assets_url . 'jquery-ui/effect-slide.min.js', ['jquery-effects-core'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-effects-transfer', $assets_url . 'jquery-ui/effect-transfer.min.js', ['jquery-effects-core'], '1.11.4-wp', 1 );

      $this->set_script( $scripts, 'jquery-ui-accordion', $assets_url . 'jquery-ui/accordion.min.js', ['jquery-ui-core', 'jquery-ui-widget'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-ui-autocomplete', $assets_url . 'jquery-ui/autocomplete.min.js', ['jquery-ui-menu', 'wp-a11y'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-ui-button', $assets_url . 'jquery-ui/button.min.js', ['jquery-ui-core', 'jquery-ui-widget'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-ui-datepicker', $assets_url . 'jquery-ui/datepicker.min.js', ['jquery-ui-core'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-ui-dialog', $assets_url . 'jquery-ui/dialog.min.js', ['jquery-ui-resizable', 'jquery-ui-draggable', 'jquery-ui-button', 'jquery-ui-position'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-ui-draggable', $assets_url . 'jquery-ui/draggable.min.js', ['jquery-ui-mouse'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-ui-droppable', $assets_url . 'jquery-ui/droppable.min.js', ['jquery-ui-draggable'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-ui-menu', $assets_url . 'jquery-ui/menu.min.js', ['jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-position'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-ui-mouse', $assets_url . 'jquery-ui/mouse.min.js', ['jquery-ui-core', 'jquery-ui-widget'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-ui-position', $assets_url . 'jquery-ui/position.min.js', ['jquery'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-ui-progressbar', $assets_url . 'jquery-ui/progressbar.min.js', ['jquery-ui-core', 'jquery-ui-widget'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-ui-resizable', $assets_url . 'jquery-ui/resizable.min.js', ['jquery-ui-mouse'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-ui-selectable', $assets_url . 'jquery-ui/selectable.min.js', ['jquery-ui-mouse'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-ui-selectmenu', $assets_url . 'jquery-ui/selectmenu.min.js', ['jquery-ui-menu'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-ui-slider', $assets_url . 'jquery-ui/slider.min.js', ['jquery-ui-mouse'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-ui-sortable', $assets_url . 'jquery-ui/sortable.min.js', ['jquery-ui-mouse'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-ui-spinner', $assets_url . 'jquery-ui/spinner.min.js', ['jquery-ui-button'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-ui-tabs', $assets_url . 'jquery-ui/tabs.min.js', ['jquery-ui-core', 'jquery-ui-widget'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-ui-tooltip', $assets_url . 'jquery-ui/tooltip.min.js', ['jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-position'], '1.11.4-wp', 1 );
      $this->set_script( $scripts, 'jquery-ui-widget', $assets_url . 'jquery-ui/widget.min.js', ['jquery'], '1.11.4-wp', 1 );

      // This just updates the dependency of `jquery-touch-punch`.
      $this->set_script( $scripts, 'jquery-touch-punch', false, ['jquery-ui-widget', 'jquery-ui-mouse'], '0.2.2', 1 );
    }
  }

  /**
   * Enqueue CDN libraries.
   *
   * @since 2.8.6
   *
   * @access public
   */
  public function enqueue_cdn_libraries() {
    $enqueue_cdn = get_option('aios-enqueue-cdn');
    $quick_search = get_option('aios-quick-search');

    wp_register_style('aios-initial-setup-google-font', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800');
    wp_register_style('agentimage-font', 'https://resources.agentimage.com/fonts/agentimage.font.icons.css');

    if ($enqueue_cdn['bootstrap_no_components_css'] ?? '' === 1) {
      wp_register_style('aios-starter-theme-bootstrap', 'https://resources.agentimage.com/bootstrap/bootstrap.noicons.min.css');
    } else {
      wp_register_style('aios-starter-theme-bootstrap', 'https://resources.agentimage.com/bootstrap/bootstrap.min.css');
    }

    wp_register_style('aios-starter-theme-popup-style', 'https://resources.agentimage.com/libraries/css/aios-popup.min.css');
    wp_register_style('aios-video-plyr', 'https://resources.agentimage.com/libraries/css/plyr.min.css');
    wp_register_style('aios-initial-setup-frontend-style', AIOS_INITIAL_SETUP_RESOURCES . 'css/frontend.min.css');

    // Enqueue jQuery wp_enqueue array('jquery') - first make sure that jquery file is include in the header
    wp_enqueue_script('jquery');
    wp_register_script('aios-starter-theme-bowser', 'https://resources.agentimage.com/libraries/js/bowser-scripts.js', ['jquery']);
    wp_register_script('aios-starter-theme-crossbrowserselector', 'https://resources.agentimage.com/libraries/js/browser-selector.min.js', ['jquery']);
    wp_register_script('aios-starter-theme-placeholders', 'https://resources.agentimage.com/libraries/js/placeholders.min.js', ['jquery']);

    // SEO-friendly and self-initializing lazyloader for images (including responsive images picture/srcset)
    wp_register_script('aios-lazysizes', 'https://resources.agentimage.com/libraries/js/lazysizes.min.js');

    // Support picture element, srcset and sizes attributes
    wp_register_script('aios-picturefill','https://resources.agentimage.com/libraries/js/picturefill.min.js');
    wp_register_script('aios-video-plyr', 'https://resources.agentimage.com/libraries/js/plyr.js');
    wp_register_script('aios-starter-theme-mobile-iframe-fix', 'https://resources.agentimage.com/libraries/js/mobile-iframe-fix.js', ['jquery']);
    wp_register_script('aios-starter-theme-html5', 'https://resources.agentimage.com/libraries/js/html5.js', ['jquery']);
    wp_register_script('aios-starter-theme-bootstrap-js', 'https://resources.agentimage.com/bootstrap/bootstrap.min.js', ['jquery']);
    wp_register_script('aios-nav-double-tap', 'https://resources.agentimage.com/libraries/js/jquery.nav-tab-double-tap.min.js', ['jquery']);
    wp_register_script('aios-starter-theme-popup', 'https://resources.agentimage.com/libraries/js/aios-popup.min.js', ['jquery']);
    wp_register_script('aios-default-functions', 'https://resources.agentimage.com/libraries/js/aios-default-libraries.min.js', [], null, true);
    wp_register_script('aios-initial-setup-frontend-scripts', 'https://resources.agentimage.com/libraries/js/aios-initial-setup-frontend.min.js', ['jquery'], time(), true);

    // Required Assets: Enqueue Agentimage Font
    wp_enqueue_style('agentimage-font');
    wp_enqueue_style('aios-initial-setup-google-font');
    wp_enqueue_style('aios-starter-theme-bootstrap');

    // Required Assets: Javascripts
    wp_enqueue_script('aios-starter-theme-bowser' );
    wp_enqueue_script('aios-starter-theme-crossbrowserselector' );

    wp_enqueue_script('aios-starter-theme-placeholders');

    // Placeholder for IE9
    if (function_exists('wp_script_add_data')) {
      wp_script_add_data('aios-starter-theme-placeholders', 'conditional', 'lt IE 9');
    }

    wp_enqueue_script('aios-starter-theme-html5');

    // HTML5 Shiv for IE9
    if (function_exists('wp_script_add_data')) {
      wp_script_add_data('aios-starter-theme-html5', 'conditional', 'lt IE 9');
    }

    wp_enqueue_script( 'aios-lazysizes' );
    wp_enqueue_script( 'aios-picturefill' );

    // Bootsrap JS
    if ($quick_search['disabled_bootstrap'] ?? '' !== 1) {
      wp_enqueue_script('aios-starter-theme-bootstrap-js');
    }

    // Collection of functions
    wp_enqueue_script('aios-default-functions');

    // Enqueue Doubletap
    wp_enqueue_script('aios-nav-double-tap');

    // Enqueue Magnific PopUp Plugin
    wp_enqueue_script('aios-starter-theme-popup');


    // Enqueue conditional assets
    wp_register_style('aios-utilities-style', 'https://resources.agentimage.com/libraries/css/aios-utilities.min.css');
    wp_register_style('aios-animate-style', 'https://resources.agentimage.com/libraries/css/animate.min.css');
    wp_register_style('aios-slick-style', 'https://resources.agentimage.com/libraries/css/slick.min.css');
    wp_register_style('aios-swiper-style', 'https://resources.agentimage.com/libraries/css/swiper.min.css');
    wp_register_style('aios-simplebar-style', 'https://resources.agentimage.com/libraries/css/simplebar.min.css');
    wp_register_style('aios-aos-style', 'https://resources.agentimage.com/libraries/css/aos.min.css');
    wp_register_style('aios-bootstrap-select', 'https://resources.agentimage.com/libraries/css/aios-bootstrap-select.min.css');

    wp_register_script('aios-autosize-script', 'https://resources.agentimage.com/libraries/js/autosize.min.js', ['jquery']);
    wp_register_script('aios-chain-height-script', 'https://resources.agentimage.com/libraries/js/jquery.chain-height.min.js', ['jquery']);
    wp_register_script('aios-elementpeek-script', 'https://resources.agentimage.com/libraries/js/jquery.elementpeek.min.js', ['jquery']);
    wp_register_script('aios-splitNav-script', 'https://resources.agentimage.com/libraries/js/aios-split-nav.min.js', ['jquery']);
    wp_register_script('aios-slick-script', 'https://resources.agentimage.com/libraries/js/slick.min.js', ['jquery']);
    wp_register_script('aios-swiper-script', 'https://resources.agentimage.com/libraries/js/swiper.min.js', ['jquery']);
    wp_register_script('aios-simplebar-script', 'https://resources.agentimage.com/libraries/js/simplebar.min.js', ['jquery']);
    wp_register_script('aios-aos-script', 'https://resources.agentimage.com/libraries/js/aos.min.js', ['jquery']);
    wp_register_script('aios-sidebar-navigation-script', 'https://resources.agentimage.com/libraries/js/jquery.sidenavigation.min.js', ['jquery']);
    wp_register_script('aios-bootstrap-select', 'https://resources.agentimage.com/libraries/js/aios-bootstrap-select.min.js', ['jquery']);
    wp_register_script('aios-quick-search-js', 'https://resources.agentimage.com/libraries/js/aios-quick-search.min.js', ['jquery'], null, true);

    if (is_singular() && get_option('thread_comments')) {
      wp_enqueue_script( 'comment-reply' );
    }

    if ($enqueue_cdn['utilities'] ?? '' === 1) {
      wp_enqueue_style('aios-utilities-style');
    }

    if ($enqueue_cdn['animate'] ?? '' === 1) {
      wp_enqueue_style('aios-animate-style');
    }

    if ($enqueue_cdn['autosize'] ?? '' === 1) {
      wp_enqueue_script('aios-autosize-script');
    }

    if ($enqueue_cdn['chainHight'] ?? '' === 1) {
      wp_enqueue_script('aios-chain-height-script');
    }

    if ($enqueue_cdn['elementpeek'] ?? '' === 1) {
      wp_enqueue_script('aios-elementpeek-script');
    }

    if ($enqueue_cdn['sidebar_navigation'] ?? '' === 1) {
      wp_enqueue_script('aios-sidebar-navigation-script');
    }

    if ($enqueue_cdn['slick'] ?? '' === 1) {
      wp_enqueue_style('aios-slick-style');
      wp_enqueue_script('aios-slick-script');
    }

    if ($enqueue_cdn['swiper'] ?? '' === 1) {
      wp_enqueue_style('aios-swiper-style');
      wp_enqueue_script('aios-swiper-script');
    }

    if ($enqueue_cdn['simplebar'] ?? '' === 1) {
      wp_enqueue_style('aios-simplebar-style');
      wp_enqueue_script('aios-simplebar-script');
    }

    if ($enqueue_cdn['aos'] ?? '' === 1) {
      wp_enqueue_style('aios-aos-style');
      wp_enqueue_script('aios-aos-script');
    }

    if ($enqueue_cdn['splitNav'] ?? '' === 1)
      wp_enqueue_script('aios-splitNav-script');

    if ($enqueue_cdn['videoPlyr'] ?? '' === 1) {
      wp_enqueue_style('aios-video-plyr');
      wp_enqueue_script('aios-video-plyr');
    }

    // Quick Search
    if ($quick_search['enabled'] ?? '' !== '') {
      wp_enqueue_style('aios-bootstrap-select');
      wp_enqueue_script('aios-bootstrap-select');
      wp_enqueue_script('aios-quick-search-js');
      wp_localize_script('aios-quick-search-js', 'aios_qs_ajax', [get_site_url() . '/31jislt2xAmlqApY8aDhWbCzmonLuOZp']);
    }

    // Required Assets: CSS Popup Style
    wp_enqueue_style('aios-starter-theme-popup-style');

    // Enqueue initial setups assets
    wp_enqueue_script('aios-initial-setup-frontend-scripts');
    wp_enqueue_style('aios-initial-setup-frontend-style');


    // Enqueue generate page css
    $generatePages = get_option('aios-generate-pages', []);

    if (! empty($generatePages)) {
      if (isset($generatePages['about'])) {
        wp_enqueue_style('aios-generated-about-page', AIOS_INITIAL_SETUP_RESOURCES . "css/{$generatePages['about']}.min.css");
      }

      if (isset($generatePages['contact'])) {
        wp_enqueue_style('aios-generated-contact-page', AIOS_INITIAL_SETUP_RESOURCES . "css/{$generatePages['contact']}.min.css");
      }
    }
  }

  /**
   * Add custom attributes to enqueued scripts
   *
   * @param $tag
   * @param $handle
   * @return mixed
   * @since 4.5.6
   *
   * @access public
   */
  public function script_filter($tag, $handle) {
    if ($handle === 'aios-picturefill') {
      $tag = str_replace(' src', ' async src', $tag);
    } elseif ($handle === 'aios-lazysizes') {
      $tag = str_replace(' src', ' async src', $tag);
    }

    return $tag;
  }

  /**
   * Add class of post type and post name
   * Add class if http referrer is same domain
   *
   * @since 4.3.0
   * @access public
   * @param array $classes - available classes for body
   * @return array
   */
  public function navigateOnSameDomainAndPostTypeSlug($classes)
  {
    global $post;
    if (isset($post)) {
      $classes[] = "post-{$post->post_type}-{$post->post_name}";
    }

    if (isset($_SERVER['HTTP_REFERER'])) {
      if (strpos($_SERVER['HTTP_REFERER'], home_url()) !== false) {
        $classes[] = 'user-navigated-from-a-page-on-the-site';
      }
    }

    return $classes;
  }

  /**
   * Add fallback for caching enabled "if site referer same domain"
   *
   * @return void
   * @since 4.3.0
   * @access public
   */
  public function domainReferer()
  {
    echo '<script>
        var docRef = (  document.referrer == undefined ? "" :  document.referrer );
        if ( document.referrer.indexOf( "' . home_url() . '" ) !== -1 && !document.body.classList.contains( "user-navigated-from-a-page-on-the-site" ) ) document.body.className += " user-navigated-from-a-page-on-the-site";
      </script>';
  }
}

new FrontendEnqueueController();
