<?php

namespace AiosInitialSetup\App\Controllers;

use MatthiasMullie\Minify\CSS;
use MatthiasMullie\Minify\JS;

class MinifyController
{
  /**
   * minify folder and url
   *
   * @access private
   */
  private $aiosmin_dir;
  private $aiosmin_url;

  /**
   * Array of styles/scripts to be minify
   *
   * @access private
   */
  private $minifyCSS;
  private $minifyJS;

  /**
   * MinifyController constructor.
   */
  public function __construct()
  {
    $enqueue_cdn = get_option('aios-enqueue-cdn', []);
    $aios_minified_resources = $enqueue_cdn['aios_minified_resources'] ?? 0;

    if ((int) $aios_minified_resources === 1) {
      $this->aiosmin_dir = WP_CONTENT_DIR . '/aiosmin';
      $this->aiosmin_url = WP_CONTENT_URL . '/aiosmin';
      $this->minifyCSS = [
        'agentimage-font',
        'aios-starter-theme-bootstrap',
        'aios-starter-theme-popup-style',
        'aios-video-plyr',
        'aios-utilities-style',
        'aios-animate-style',
        'aios-slick-style',
        'aios-swiper-style',
        'aios-simplebar-style',
        'aios-aos-style',
        'aios-bootstrap-select',
      ];
      $this->minifyJS = [
        'aios-starter-theme-bowser',
        'aios-starter-theme-crossbrowserselector',
        'aios-starter-theme-placeholders',
        'aios-lazysizes',
        'aios-picturefill',
        'aios-starter-theme-html5',
        'aios-default-functions',
        'aios-starter-theme-bootstrap-js',
        'aios-starter-theme-mobile-iframe-fix',
        'aios-bootstrap-select',
        'aios-slick-script',
        'aios-initial-setup-frontend-scripts',
        'aios-initial-setup-cf7-fix-date-field',
        'aios_initial_setup_dead_link_disabler',
        'aios-initial-setup-idxb-titles',
        'aios-nav-double-tap',
        'aios-starter-theme-popup',
        'aios-mobile-header-widget-navigation',
        'aios-mobile-header-main',
        'aios-autosize-script',
        'aios-chain-height-script',
        'aios-elementpeek-script',
        'aios-splitNav-script',
        'aios-swiper-script',
        'aios-simplebar-script',
        'aios-sidebar-navigation-script',
        'aios-aos-script',
        // 'aios-quick-search-js',don't include this wp_localize from different functions
      ];

      if (get_transient('aiosmin') === 'minified' && file_exists($this->aiosmin_dir)) {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_libraries'], 10);
        add_action('wp_enqueue_scripts', [$this, 'dequeue_libraries'], 1000);
      } else {
        add_action('wp_head', [$this, 'minify_assets'], 10);
      }
    }
  }

  /**
   * Enqueue CDN libraries.
   *
   * @return void
   * @since 3.9.1
   *
   * @access public
   */
  public function enqueue_libraries() {
    wp_enqueue_style('aios-bundle', $this->aiosmin_url . '/aios-bundle.css');
    wp_enqueue_script('aios-header-bundle', $this->aiosmin_url . '/aios-header-bundle.js', ['jquery']);
    wp_enqueue_script('aios-footer-bundle', $this->aiosmin_url . '/aios-footer-bundle.js', ['jquery'], null, true);
  }

  /**
   * Dequeue list of styles that will be minify
   *
   * @return void
   * @since 3.9.1
   *
   * @access public
   */
  public function dequeue_libraries() {
    foreach ($this->minifyCSS as $file) {
      wp_dequeue_style($file);
    }

    foreach ($this->minifyJS as $file) {
      wp_dequeue_script($file);
    }
  }

  /**
   * Minify Assets
   *
   * @return void
   * @since 3.9.1
   * @access public
   */
  public function minify_assets() {
    /**
     * Check if folder and file exists then
     * create folder and files
     * use for minify assets
     */
    if (! file_exists($this->aiosmin_dir)) {
      wp_mkdir_p($this->aiosmin_dir);
    }

    $cssPath = $this->aiosmin_dir . '/aios-bundle.css';
    $jsHeaderPath = $this->aiosmin_dir . '/aios-header-bundle.js';
    $jsFooterPath = $this->aiosmin_dir . '/aios-footer-bundle.js';

    if (! file_exists($cssPath)) {
      fopen($cssPath, 'w');
    }

    if (! file_exists($jsHeaderPath)) {
      fopen($jsHeaderPath, 'w');
    }

    if (! file_exists($jsFooterPath)) {
      fopen($jsFooterPath, 'w');
    }

    // Minify CSS
    $styles = wp_styles();
    $styles_registered = $styles->registered;
    $styles_queue = $styles->queue;
    $minifierCSS = new CSS();
    $minifiedCSSPath = $cssPath;

    /**
     * Support for old starter theme
     * Force to change when compiled
     */
    $enqueue_cdn = get_option( 'aios-enqueue-cdn' );
    if (isset($enqueue_cdn['bootstrap_no_components_css'])) {
      $styles_registered['aios-starter-theme-bootstrap']->src = 'https://resources.agentimage.com/bootstrap/bootstrap.noicons.min.css';
    } else {
      $styles_registered['aios-starter-theme-bootstrap']->src = 'https://resources.agentimage.com/bootstrap/bootstrap.min.css';
    }

    foreach ($this->minifyCSS as $file) {
      if (in_array($file, $styles_queue)) {
        $src = $styles_registered[$file]->src;
        if (! empty($src)) {
          $content = $this->curl($src);
          $minifierCSS->add($content);
        }
      }
    }

    $minifierCSS->minify($minifiedCSSPath);

    /** Minify Javascript */
    $scripts = wp_scripts();
    $scripts_registered = $scripts->registered;
    $scripts_queue = $scripts->queue;
    $scripts_in_footer = $scripts->in_footer;
    $minifierJSHeader = new JS();
    $minifiedJSHeaderPath = $jsHeaderPath;
    $minifierJSFooter = new JS();
    $minifiedJSFooterPath = $jsFooterPath;

    /** Header */
    foreach ($this->minifyJS as $file ) {
      if (in_array($file, $scripts_queue)) {
        $src = $scripts_registered[$file]->src;
        if (! empty($src)) {
          $content = $this->curl($src);
          if (in_array($file, $scripts_in_footer)) {
            $minifierJSFooter->add($content);
          } else {
            $minifierJSHeader->add($content);
          }
        }
      }
    }

    $minifierJSHeader->minify($minifiedJSHeaderPath);
    // $minifierJSHeader->gzip($minifiedJSHeaderPath);
    $minifierJSFooter->minify($minifiedJSFooterPath);
    // $minifierJSFooter->gzip($minifiedJSFooterPath);

    // set transient this transient will let the minifier know if it needs to minify a new batch
    /**
     * MINUTE_IN_SECONDS  = 60 (seconds)
     * HOUR_IN_SECONDS    = 60 * MINUTE_IN_SECONDS
     * DAY_IN_SECONDS     = 24 * HOUR_IN_SECONDS
     * WEEK_IN_SECONDS    = 7 * DAY_IN_SECONDS
     * MONTH_IN_SECONDS   = 30 * DAY_IN_SECONDS
     * YEAR_IN_SECONDS    = 365 * DAY_IN_SECONDS
     * set_transient( 'special_query_results', $special_query_results, 12 * HOUR_IN_SECONDS );
     */

    $enqueue_cdn = get_option('aios-enqueue-cdn');
    $expiration = $enqueue_cdn['expiration'] ?? 0;
    $expiration = $expiration === 999 ? 0 : $expiration;

    // $expiration * 24 * 60 * 60 - days/hours/minutes/seconds
    set_transient('aiosmin', 'minified', $expiration);
  }

  /**
   * Curl Data
   *
   * @param $url
   * @return bool|string
   */
  private function curl($url)
  {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
  }
}

new MinifyController();
