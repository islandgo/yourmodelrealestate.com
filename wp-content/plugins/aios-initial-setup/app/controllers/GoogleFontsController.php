<?php

namespace AiosInitialSetup\App\Controllers;

class GoogleFontsController
{
  private $fonts;

  /**
   * GoogleFonts constructor.
   */
  public function __construct()
  {
    // add_action('wp_enqueue_scripts', [$this, 'compress_google_fonts'], 100);
    // add_action('wp_head', [$this, 'google_fonts_render'], 7);
  }

  /**
   * Get all google fonts then concatenate to one line
   *
   * @since 4.4.5
   * @access public
   */
  public function compress_google_fonts() {
    global $wp_styles;
    $search_for = 'fonts.googleapis.com/css?family';
    $google_fonts = [];

    foreach ($wp_styles->registered as $name=>$style) {
      $src = $style->src;

      if (strpos( $src, $search_for ) !== false) {
        wp_dequeue_style($name);

        $url_components = parse_url($src);
        parse_str( $url_components[ 'query' ], $vars );
        $font_family = $vars['family'];
        $font_family = explode( '|', $font_family );
        $font_count = count( $font_family );

        if ($font_count > 1)  {
          foreach ($font_family as $v) {
            $google_fonts[] = str_replace('italic', 'i', $v);
          }
        } else {
          $google_fonts[] = str_replace('italic', 'i', $font_family[0]);
        }
      }
    }

    $concatenated_arr = [];

    foreach ($google_fonts as $google_font) {
      $google_font = explode(':', $google_font);

      if (isset($concatenated_arr[$google_font[0]])) {
        $exists_weight = explode(',', $concatenated_arr[$google_font[0]]);
        $weight = explode(',', $google_font[1]);
        $merge_weight = array_merge($weight, $exists_weight);
        $unique_weight = array_unique($merge_weight);
        $implode_weight = implode(',', $unique_weight);
        $concatenated_arr[$google_font[0]] = $implode_weight;
      } else {
        $concatenated_arr[$google_font[0]] = $google_font[1];
      }
    }

    $new_contactenated_arr = [];
    foreach ($concatenated_arr as $k => $v) {
      $new_contactenated_arr[] = $k . ':' . $v;
    }

    // Concatenate Google fonts
    $concatenated = urlencode( implode( '|', $new_contactenated_arr ) );

    // let's dequeue style
    wp_dequeue_style( 'aios-starter-theme-concatenated-google-fonts' );

    $this->fonts = 'https://fonts.googleapis.com/css?family=' . $concatenated;
  }

  /**
   * Make your Google Fonts render faster
   * Page test: https://www.webpagetest.org/video/compare.php?tests=190214_5S_353d1e658663bfe996ceaee8093aa578%2C190214_VQ_e6c965dc8137d95b37234e93840f13ce&thumbSize=200&ival=1000&end=visual
   *
   * @since 4.4.5
   * @access public
   */
  public function google_fonts_render() {
    echo '<!-- Speed up Google Fonts rendering -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
    <link rel="preload" as="style" href="' . $this->fonts . '" crossorigin="anonymous">
    <script type="text/javascript">
    !function(e,n,t){"use strict";var o="' . $this->fonts . '",r="__3perf_googleFonts_8c2ab";function c(e){(n.head||n.body).appendChild(e)}function a(){var e=n.createElement("link");e.href=o,e.rel="stylesheet",c(e)}function f(e){if(!n.getElementById(r)){var t=n.createElement("style");t.id=r,c(t)}n.getElementById(r).innerHTML=e}e.FontFace&&e.FontFace.prototype.hasOwnProperty("display")?(t[r]&&f(t[r]),fetch(o).then(function(e){return e.text()}).then(function(e){return e.replace(/@font-face {/g,"@font-face{font-display:swap;")}).then(function(e){return t[r]=e}).then(f).catch(a)):a()}(window,document,localStorage);
    </script>
    <!-- End of Speed up Google Fonts rendering -->';
  }
}

new GoogleFontsController();
