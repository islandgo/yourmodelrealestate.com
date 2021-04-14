<?php

namespace AiosInitialSetup\App\Controllers;

class ShortcodeController
{
  /**
   * Shortcode constructor.
   */
  public function __construct()
  {
    add_action('admin_footer', [$this, 'widgetShortcode'], 101);
    // This hook is called during each page load, after the theme is initialized.
    add_action('after_setup_theme', [$this, 'shortcodeLists'], 20);
  }

  /**
   * Insert list of shortcode in widgets.
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function widgetShortcode() {
    $admin_page_id = get_current_screen()->id;
    $admin_page_contains = 'widgets';
    if (str_exists($admin_page_id, $admin_page_contains)) {
      echo '<div id="aios-shortcode-popup">
        <div class="_overlay"></div>
        <div class="aios-shortcode-popup-container">
          <div id="wpui-container">
            <div class="wpui-container">
              <h4>AIOS Shortcode <div class="_close"><em class="ai-font-x-sign""></em></div></h4>';
                require_once AIOS_INITIAL_SETUP_VIEWS . 'initial-setup' . DIRECTORY_SEPARATOR . 'shortcodes' . DIRECTORY_SEPARATOR . 'index.php';
      echo '</div>
          </div>
        </div>
      </div>';
    }
  }

  /**
   * Init Shortcodes after theme initialzie.
   *
   * @since 3.1.8
   * @access public
   * @return void
   */
  public function shortcodeLists()
  {
    // Force to remove old shortcodes and replace
    remove_shortcode('agentimage_credits');
    add_shortcode('agentimage_credits', [$this, 'credits_shortcode']);
    add_shortcode('blogurl', [$this, 'get_blogurl']);
    add_shortcode('current_url', [$this, 'get_current_url']);
    add_shortcode('agentimage_video', [$this, 'get_agentimage_video']);
    add_shortcode('aios_element', [$this, 'get_aios_element']);
    add_shortcode('iframe_async', [$this, 'get_iframe_async']);
    add_shortcode('mail_to', [$this, 'get_mail_to']);
    add_shortcode('ai_phone', [$this, 'get_ai_phone']);
    add_shortcode('currentYear', [$this, 'get_currentYear']);
    add_shortcode('sitemap', [$this, 'get_sitemap']);
    add_shortcode('stylesheet_directory', [$this, 'get_stylesheet_directory']);
    add_shortcode('template_directory', [$this, 'get_template_directory']);
    add_shortcode('aios-mortgage-calculator', [$this, 'mortgage_calculator_shortcode']);

    // filter the menu item output on frontend.
    add_filter('walker_nav_menu_start_el', [$this, 'start_el'], 20, 2);

    // Responsive images
    add_shortcode('aios_responsive_image',  [$this, 'aios_responsive_image_render']);

    // Custom Banner
    add_shortcode('aios_custom_banner',  [$this, 'aios_custom_banner_render']);
  }

  /**
   * Return Agentimage Copyright.
   *
   * @param $atts
   * @return string
   * @since 3.1.8
   * @access public
   */
  public function credits_shortcode($atts)
  {
    $atts = shortcode_atts([
      "credits" => "",
      "renew" => "false",
      "seo" => "false",
    ], $atts, 'agentimage_credits');

    // If SEO is true
    if ($atts['seo'] === 'true') {
      $v_credits = "Real Estate Website Design & Internet Marketing by <a target='_blank' href='https://www.agentimage.com' style='text-decoration:underline;font-weight:bold'>Agent Image</a>";
    } else {
      if ($atts['credits'] === '') {
        $v_credits = "Real Estate Website Design by <a target='_blank' href='https://www.agentimage.com' style='text-decoration:underline;font-weight:bold'>Agent Image</a>";
      } else {
        $v_credits = $atts['credits'];
      }
    }

    // Get credits
    $credits = get_option('ai_starter_theme_agentimage_credits');

    // Renew credits
    if ($atts['renew'] == "true" && $credits != $v_credits) {
      delete_option('ai_starter_theme_agentimage_credits');
    }

    // Add credits if not yet existing
    add_option('ai_starter_theme_agentimage_credits', $v_credits);

    // Use persistent credits if existing
    $persistent_credits = get_option('ai_starter_theme_agentimage_credits_persistent');
    if ($persistent_credits) {
      $credits = $persistent_credits;
    }

    return $credits;
  }

  /**
   * Return Domain.
   *
   * @since 3.1.8
   * @access public
   * @return string
   */
  public function get_blogurl()
  {
    return home_url();
  }

  /**
   * Return Current Page URL.
   *
   * @since 3.1.8
   * @access public
   * @return string
   */
  public function get_current_url()
  {
    return home_url(add_query_arg('_', false));
  }

  /**
   * Return Iframe Video with Placeholder.
   *
   * @param $atts
   * @return string
   * @since 3.1.8
   * @access public
   */
  public function get_agentimage_video($atts)
  {
    $args = shortcode_atts([
      'width' => 560,
      'height' => 315,
      'url'	=> 'https://player.vimeo.com/video/215609798'
    ], $atts);

    $markup = "<iframe width='{$args['width']}' height='{$args['height']}' src='{$args['url']}'></iframe>";
    return $markup;
  }

  /**
   * Return this return shortcode that doesn't accept by WordPress > 4.6.0.
   *
   * @param array $atts
   * @param null $content
   * @return string
   * @since 3.1.8
   * @access public
   */
  public function get_aios_element($atts = [], $content = null)
  {
    $atts = shortcode_atts([
      'element'         => '',
      'class'           => '',
      'width'           => '',
      'height'          => '',
      'style'           => '',
      'data-src'        => '',
      'data-class'      => '',
      'data-animation'  => '',
      'data-offset'     => ''
    ], $atts);

    $class = ! empty($atts['class']) ? ' class="' . $atts['class'] . '"' : '';
    $width = ! empty($atts['width']) ? ' width="' . $atts['width'] . '"' : '';
    $height = ! empty($atts['height']) ? ' height="' . $atts['height'] . '"' : '';
    $style = ! empty($atts['style']) ? ' style="' . $atts['style'] . '"' : '';
    $dataSrc	= ! empty($atts['dataSrc']) ? ' data-src="' . $atts['dataSrc'] . '"' : '';
    $dataClass	= ! empty($atts['dataClass']) ? ' data-class="' . $atts['dataClass'] . '"' : '';
    $dataAnimation = ! empty($atts['dataAnimation']) ? ' data-animation="' . $atts['dataAnimation'] . '"' : '';
    $dataOffset	= ! empty($atts['dataOffset']) ? ' data-offset="' . $atts['dataOffset'] . '"' : '';

    if (! empty($element)) {
      $content = '<' . $element
        . $class
        . $width
        . $height
        . $style
        . $dataSrc
        . $dataClass
        . $dataAnimation
        . $dataOffset .'>' . $content . '</' . $element . '>';
    }
    $content = str_replace('{{blogurl}}', get_site_url(), $content);
    $content = str_replace('{{theme_dir}}', get_stylesheet_directory_uri(), $content);
    $content = do_shortcode($content);

    return $content;
  }

  /**
   * Return load iframe after the page is fully loaded.
   *
   * @param $atts
   * @return string
   * @since 3.1.8
   * @access public
   */
  public function get_iframe_async($atts)
  {
    $atts = shortcode_atts([
      'src' => 'http://localhost/vip-clients/sallyforsterjones.com/',
      'width' => 700,
      'height' => 350,
      'id' => '',
      'class' => '',
      'additional' => '' //for additional attributes
    ], $atts);

    if ($atts['id'] !== '') {
      $atts['id'] = 'id="' . $atts['id'] . '"';
    }

    $iframe_output = '
				<iframe 
					websource="' . $atts['src'] . '"
					width="' . $atts['width'] . '"
					height="' . $atts['height'] . '"
					' . $atts['id'] . '
					class="aios-iframe ' . $atts['class'] . '"
					' . $atts['additional'] . '
				></iframe>
			';

    return $iframe_output;
  }

  /**
   * Return Email Address Obfuscated.
   *
   * @param $atts
   * @param null $content
   * @return string
   * @since 3.1.8
   * @access public
   */
  public function get_mail_to($atts, $content = null)
  {
    $atts = shortcode_atts([
      'email' => '',
      'class' => '',
    ], $atts);

    // Do character replacements in the email address
    $obfuscated_email = str_replace('@','(at)',$atts['email']);
    $obfuscated_email = str_replace('.','(dotted)',$obfuscated_email);

    // Replace instances of email address with the obfuscated version in the content
    $obfuscated_content = do_shortcode(str_replace($atts['email'], $obfuscated_email, $content));

    // Return output
    return '<a class="asis-mailto-obfuscated-email-hidden asis-mailto-obfuscated-email ' . $atts['class'] . '" data-value="' . $obfuscated_email . '">' . $obfuscated_content . '</a>';
  }

  /**
   * Return Phone Number.
   *
   * @param $atts
   * @param null $content
   * @return string
   * @since 3.1.8
   * @access public
   */
  public function get_ai_phone($atts, $content = null)
  {
    $atts = shortcode_atts([
      'filter' => true,
      'href' => '',
      'extension' => '',
      'convert_js' => false,
      'unwrap_em' => false,
      'class' => ''
    ], $atts);

    if ($atts['convert_js'] || $atts['convert_js'] === 'true') {
      if ($atts['extension'] != "") {
        $atts['extension'] = 'data-ext="' . $atts['extension'] .'"';
      }

      $disabled_filter = $atts['filter'] === 'false' ? 'data-filter="off"' : '';

      return '<em class="ai-mobile-phone" '.$disabled_filter.' data-href="'.$atts['href'].'" '.$atts['extension'].'>'.$content.'</em>';
    } else {
      $dialer = $atts['href'] . (! empty($atts['extension']) ? ',' . $atts['extension'] : '');
      $dialer = str_replace(" ","",$dialer);
      $class = ! empty( $class ) ? 'class="' . $atts['class'] . '"' : '';
      $html = '<a href="tel:' . $dialer . '" ' . $class . '>' . $content . '</a>';

      return $atts['unwrap_em'] || $atts['unwrap_em'] == 'true' ? $html : '<em class="ai-mobile-phone">' . $html . '</em>';
    }
  }

  /**
   * Return Current Year.
   *
   * @since 3.1.8
   * @access public
   * @return string
   */
  public function get_currentYear()
  {
    return date('Y');
  }

  /**
   * Return list of pages using wp_list_pages().
   *
   * @param $atts
   * @return string
   * @since 3.1.8
   * @access public
   */
  public function get_sitemap($atts)
  {
    if (! is_array($atts)) {
      $atts = [];
    }

    $defaults = [
      'sort_column' =>'post_title',
      'title_li' =>''
    ];

    $atts = array_merge($defaults, $atts);
    $atts['echo'] = false;

    return '<ul class="sitemap-list">' . wp_list_pages($atts) . '</ul>';
  }

  /**
   * Return Stylesheet Directory.
   * If child this will get the child directory
   *
   * @since 3.1.8
   * @access public
   * @return string
   */
  public function get_stylesheet_directory()
  {
    return get_stylesheet_directory_uri();
  }

  /**
   * Return Template Directory / Parent Direct.
   *
   * @since 3.1.8
   * @access public
   * @return string
   */
  public function get_template_directory()
  {
    return get_template_directory_uri();
  }

  /**
   * Return Mortgage Calculator
   *
   * @param $atts
   * @return string
   * @since 3.6.4
   * @access public
   */
  public function mortgage_calculator_shortcode($atts)
  {
    $atts = shortcode_atts([
      'years'		=> '',
      'interest'	=> '',
      'la'		=> '',
      'tax'		=> '',
      'insurance'	=> ''
    ], $atts, 'aios-mortgage-calculator');

    return '<div class="aios-mortgage-calculator-standalone">
	<p>Owning a home is a great investment and it is key to plan your mortgage payments ahead of time. Calculate your monthly mortgage using our free calculator below.</p>
	<form action="#" method="post" enctype="application/x-www-form-urlencoded" name="temps">
		<span class="aios-mortgage-calculator-standalone-form-reminder">Required fields are marked*</span>
		
		<div class="aios-mortgage-calculator-standalone-mort-row">
			<div class="aios-mortgage-calculator-standalone-full-input">
				<label>Length of Loan Years *</label>
				<input type="text" class="aios-mortgage-calculator-standalone-loan-years aios-mortgage-calculator-standalone-number" name="YR" value="' . $atts['years'] . '">
			</div> 
			<div class="aios-mortgage-calculator-standalone-full-input">
				<label>Interest Rate (%) *</label>
				<input type="text" class="aios-mortgage-calculator-standalone-interest-rate aios-mortgage-calculator-standalone-number" name="IR" value="' . $atts['interest'] . '">
			</div>
			<div class="aios-mortgage-calculator-standalone-half-input">
				<label>Loan Amount *</label>
				<input type="text" class="aios-mortgage-calculator-standalone-loan-amount aios-mortgage-calculator-standalone-number" name="LA" value="' . $atts['la'] . '">
			</div>
			<div class="aios-mortgage-calculator-standalone-half-input">
				<label>Annual Property Tax *</label>
				<input type="text" class="aios-mortgage-calculator-standalone-property-tax aios-mortgage-calculator-standalone-number" value="' . $atts['tax'] . '" name="AT" >
			</div>
			<div class="aios-mortgage-calculator-standalone-full-input">
				<label>Annual Insurance *</label>
				<input type="text" class="aios-mortgage-calculator-standalone-annual-insurance aios-mortgage-calculator-standalone-number" name="AI" value="' . $atts['insurance'] . '">
			</div>
			<div class="aios-mortgage-calculator-standalone-mortgage-buttons">
				<div class="aios-mortgage-calculator-standalone-half-input">
					<button type="reset" class="aios-mortgage-calculator-standalone-reset" value="Reset">Reset</button>
				</div>
				<div class="aios-mortgage-calculator-standalone-half-input">
					<button type="submit" class="aios-mortgage-calculator-standalone-calculate" value="Calculate">Calculate</button>
				</div>
			</div>   
		</div> 
		<div class="aios-mortgage-calculator-standalone-calculation-result">
			<div class="aios-mortgage-calculator-standalone-mort-row">
				<div class="aios-mortgage-calculator-standalone-half-input">
					<span>Monthly Principal + Interest:</span>
				</div>
				<div class="aios-mortgage-calculator-standalone-half-input">
					<input readonly type="text" name="PI">
				</div>
				<div class="aios-mortgage-calculator-standalone-half-input">
					<span>Monthly Tax:</span>
				</div>
				<div class="aios-mortgage-calculator-standalone-half-input">
						<input readonly type="text" name="MT">
				</div>
				<div class="aios-mortgage-calculator-standalone-half-input">
					<span>Monthly Insurance:</span>
				</div>
				<div class="aios-mortgage-calculator-standalone-half-input">
						<input readonly type="text" name="MI" >
				</div>
				<div class="aios-mortgage-calculator-standalone-half-input">
					<span>Total Payment:</span>
				</div>
				<div class="aios-mortgage-calculator-standalone-half-input">
						<input readonly type="text" name="MP">
				</div>
			</div>
		</div>
	</form>
	<div class="aios-mortgage-calculator-standalone-disclaimer">
		<p>DISCLAIMER: The information found in these calculators are to be used as a guide and is deemed reliable but not guaranteed. Please schedule an appointment today to find out more information about your loan.</p>
	</div>
</div>';
  }

  /**
   * Modifies the menu item display on frontend.
   *
   * @since 4.5.4
   *
   * @param string $item_output The original html.
   * @param object $item  The menu item being displayed.
   *
   * @return string Modified menu item to display.
   */
  public function start_el($item_output, $item)
  {
    // Rare case when $item is not an object, usually with custom themes.
    if (! is_object($item) || ! isset($item->object)) {
      return $item_output;
    }

    // if it isn't our custom object.
    if ('gs_sim' !== $item->object) {
      // check the legacy hack.
      if (isset($item->post_title) && 'FULL HTML OUTPUT' === $item->post_title) {
        // then just process as we used to.
        $item_output = do_shortcode(preg_replace("/https?:\/\/\[/", "[", $item->url));
      } else {
        $item_output = do_shortcode(preg_replace("/https?:\/\/\[/", "[", $item_output));
      }
      // if it is our object.
    } elseif (isset($item->description)) {
      // just process it.
      $item_output = do_shortcode($item->description);
    }

    return $item_output;
  }

  /**
   * This will output responsive images with srcset and sizes
   *
   * Sizes:
   *  - Medium resolution (default 400px x 400px max)
   *  - Medium Large resolution (default 768 x 768 max)
   *  - Large resolution (default 1024px x 1024px max)
   *  - Full resolution (original size uploaded) this will be fallback if width is greater input viewport size
   *
   * @param $atts
   * @return string
   * @since 4.5.6
   *
   */
  public function aios_responsive_image_render($atts)
  {
    $atts = shortcode_atts([
      'id' => '', // Image ID . Default: empty(required)
      'reset' => false, // Reset sizes and viewport
      'default_size' => 'full',
      'sizes' => '', // Sizes separated by commas(viewport is required). Default: medium,medium_large,large,full. Default: 400,768,1024
      'viewport' => '', // Width of monitor where to change the image sizez separated by commas(viewport is required). Default: 400,768,1024
      'id_name' => '', // ID attribute for img element
      'width' => '', // Width for img element
      'height' => '', // height for img element
      'class' => 'img-responsive', // Class attribute for img element. Default: img-responsive
      'alt' => '', // Use for custom alt, if empty this will get alt from upload images
      'lazyload' => false
    ], $atts, 'aios_responsive_image');

    // Check if ID is not empty and int
    if (empty($atts['id'])) {
      return 'ID must not be a non-empty string.';
    }

    if (! is_numeric($atts['id'])) {
      return 'ID must be numeric.';
    }

    // Width and Height
    $width = ! empty($atts['width']) ? 'width="' . $atts['width'] .'"' : '';
    $height = ! empty($atts['height']) ? 'height="' . $atts['height'] .'"' : '';

    // Let's match the sizes and viewport
    if ($atts['reset']) {
      $sizes = ! empty($atts['sizes']) ? explode(',', $atts['sizes']) : '';
      $viewport = ! empty($atts['viewport']) ? explode(',', $atts['viewport']) : '';
    } else {
      $sizes = explode(',', 'medium,medium_large,large' . (! empty($atts['sizes']) ? ',' . $atts['sizes'] : ''));
      $viewport = explode(',', '400,768,1024' . (! empty($atts['viewport']) ? ',' . $atts['viewport'] : ''));
    }

    if (count($sizes) != count($viewport)) {
      return 'Sizes and viewport must be equal separated by comma.';
    }

    // Check given id if exists
    $image = wp_get_attachment_image_src($atts['id'], $atts['default_size']);
    $image = wp_get_attachment_image_src($atts['id'], ($atts['reset'] ? (! empty($atts['default_size']) ? $atts['default_size'] : end($sizes)) : 'full' ));

    /** Enable lazyload */
    if ($atts['lazyload']) {
      $class = empty($atts['class']) ? $atts['class'] : 'lazyload ' . $atts['class'];
    } else {
      $class = '';
    }

    if ( $image ) {
      $image_set = $this->aios_responsive_image_srcs($atts['id'], $sizes, $viewport);
      $id_name = ! empty($atts['id_name']) ? 'id="' . $atts['id_name'] . '"' : '';
      $alt_tag = ! empty($atts['alt']) ? $atts['alt'] : $this->aios_responsive_image_alt($atts['id']);
      $alt_tag = ! empty($alt_tag) ? 'alt="' . $alt_tag . '"' : '';
      $output = '<picture>
					' . $image_set . '
					<img ' . $width . ' ' . $height . ' srcset="' . $image[0] . '" ' . $alt_tag . ' ' . $id_name . ' class="' . $class . '">
					<noscript><img src="' . $image[0] . '" ' . $alt_tag . ' ' . $id_name . ' class="' . $class . 	'"></noscript>
				</picture>';

      return $output;
    }

    return 'ID is not an image attachment.';
  }

  /**
   * Callback for [aios_responsive_image] shortcode to get each image link
   *
   * @param int $id - image ID
   * @param array $sizes - list of custom sizes
   *
   * @param $viewport
   * @return string
   * @since 4.5.6
   */
  private function aios_responsive_image_srcs($id, array $sizes, $viewport)
  {
    $arr = [];
    $count = 0;

    foreach ($sizes as $size) {
      $image_src = wp_get_attachment_image_src($id, $size);
      $arr[] = '<source srcset="'. $image_src[0] . '" media="(max-width: '. $viewport[$count] .'px)">';
      $count++;
    }

    return implode(array_reverse($arr));
  }

  /**
   * Callback for [aios_responsive_image] shortcode to get Alt value
   *
   * @since 4.5.6
   * @param int $id - image ID
   *
   * @return string
   */
  private function aios_responsive_image_alt($id)
  {
    return trim(strip_tags(get_post_meta($id, '_wp_attachment_image_alt', true)));
  }

  /**
   * Display Custom Banner
   *
   * @since 5.1.8
   * @param array $atts
   * @param null $content
   * @return string
   */
  public function aios_custom_banner_render($atts = [], $content = null)
  {
    $banner_image_default_id = get_option( 'aios-metaboxes-default-banner-image', '' );
    $banner_image_size = get_option( 'aios-metaboxes-default-banner-size', 'full' );
    $title = '';
    $sub_title = '';
    $banner_image= '';
    $post_type = '';
    $post_id = '';

    if (! is_null(get_queried_object()->post_type)) {
      $isCustomTitle = (int) get_post_meta(get_queried_object()->ID, 'aioscm_used_custom_title', true);
      $imgId = get_post_meta(get_queried_object()->ID, 'aioscm_banner', true);

      $title = $isCustomTitle === 1 ? get_post_meta(get_queried_object()->ID, 'aioscm_main_title', true) : get_the_title(get_queried_object()->ID);
      $sub_title = $isCustomTitle === 1 ? get_post_meta(get_queried_object()->ID, 'aioscm_sub_title', true) : '';
      $banner_image = wp_get_attachment_image_url((! empty($imgId) ? $imgId : $banner_image_default_id), $banner_image_size);

      $post_type = get_queried_object()->post_type;
      $post_id = get_queried_object()->ID;
    } elseif (! is_null(get_queried_object()->taxonomy)) {
      $taxonomy_meta = get_option('term_meta_' . get_queried_object()->term_id);

      $title = $taxonomy_meta['used_custom_title'] === 1 ? $taxonomy_meta['main_title'] : get_queried_object()->name;
      $sub_title = $taxonomy_meta['used_custom_title'] === 1 ? $taxonomy_meta['sub_title'] : '';
      $banner_image = wp_get_attachment_image_url((! empty($taxonomy_meta['banner']) ? $taxonomy_meta['banner'] : $banner_image_default_id), $banner_image_size);

      $post_type = get_queried_object()->name;
      $post_id = get_queried_object()->term_id;
    } elseif (is_archive()) {
      $banner_image= wp_get_attachment_image_url($banner_image_default_id, $banner_image_size);
      $post_type = get_queried_object()->name;
      $post_id = get_queried_object()->name;
    } elseif (is_404()) {
      $banner_image= wp_get_attachment_image_url($banner_image_default_id, $banner_image_size);
      $post_type = '404-not-found';
      $post_id = '404-not-found';
    }

    $content = strtr(html_entity_decode($content), [
      '[title]' => $title,
      '[sub_title]' => $sub_title,
      '[banner_image]' => $banner_image,
      '[post_type]' => $post_type,
      '[post_id]' => $post_id,
    ]);

    return strip_shortcodes(do_shortcode($content));
  }
}

new ShortcodeController();
