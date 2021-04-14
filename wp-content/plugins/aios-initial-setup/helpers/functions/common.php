<?php

if (! function_exists('replace_non_digits')) {
  /**
   * Replace first special character with DOT
   *
   * @param $number
   * @param string $replacements
   * @return string|string[]|null
   */
  function replace_non_digits($number, $replacements = '.')
  {
    return preg_replace('/[^A-Za-z0-9\-]/', $replacements, $number);
  }
}


if (! function_exists('')) {
  /**
   * Check if needle is in content
   *
   * @param $content
   * @param $needle
   * @return bool
   */
  function str_exists($content, $needle)
  {
    return strpos($content, $needle) !== false;
  }
}


if (! function_exists('phone_wrapper')) {
  /**
   * This phone wrapper, wraps site information for info
   *
   * @param $options
   * @param $data
   * @param $country_code
   * @param $country_code_show
   * @param $content
   * @param $default_content
   * @return string
   */
  function site_info_phone_wrapper($options, $data, $country_code, $country_code_show, $content, $default_content)
  {
    $countryCode = ! empty($options[$country_code]) ? '+' . $options[$country_code] . '.' : '+1.';
    $showCountryCode = ! empty($options[$country_code_show]) ? $options[$country_code_show] : 'no';
    $displayCountryCode = $showCountryCode == 'yes' ? $countryCode : '';
    $phone_number = ! empty($countryCode) ? str_replace('+1', '', $options[$data]) : $options[$data];
    $phone_number = replace_non_digits($phone_number);

    if (str_exists($content, $default_content)) {
      $content = str_replace($default_content, $displayCountryCode .  $phone_number, $content);
      $output = '[ai_phone unwrap_em=true href="' . $countryCode . $phone_number . '"]' . $content . '[/ai_phone]';
    } else {
      $output = '[ai_phone unwrap_em=true href="' . $countryCode . $phone_number . '"]' . $content . '<span class="mobile-number client-phone">' . $displayCountryCode . $phone_number . '[/ai_phone]';
    }

    return $output;
  }
}

if (! function_exists('shortcode_exists')) {
  /**
   * Whether a registered shortcode exists named $tag
   *
   * @since 3.6.0
   *
   * @global array $shortcode_tags List of shortcode tags and their callback hooks.
   *
   * @param string $tag Shortcode tag to check.
   * @return bool Whether the given shortcode exists.
   */
  function shortcode_exists($tag) {
    global $shortcode_tags;
    return array_key_exists($tag, $shortcode_tags);
  }
}

if (! function_exists('is_in_array')) {
  /**
   * Check if value is in assoc array
   * @param $array
   * @param $key
   * @param $key_value
   * @return string
   */
  function is_in_array($array, $key, $key_value){
    $within_array = 'no';

    if (! is_array($array)) {
      return $within_array;
    }

    foreach ($array as $k => $v){
      if (is_array($v)){
        $within_array = is_in_array($v, $key, $key_value);
        if($within_array === 'yes'){
          break;
        }
      } else {
        if ($v === $key_value && $k === $key) {
          $within_array = 'yes';
          break;
        }
      }
    }

    return $within_array;
  }
}

if (! function_exists('assoc_array_flip')) {
  /**
   * Flip array this is not same for the array_flip
   * This will make the associative array from value to key and vice versa
   *
   * @param $a
   * @return array|bool
   */
  function assoc_array_flip($a) {
    if( is_string( $a ) ) return true;
    $new = [];
    foreach ($a as $k => $v) {
      foreach( $v as $sv ) {
        $new[$sv] = $k;
      }
    }

    return $new;
  }
}

if (! function_exists('is_assoc_array')) {
  /**
   * Check if array is recursive or assoc
   *
   * @param $array
   * @return bool
   */
  function is_assoc_array($array) {
    if (is_array($array)) {
      return array_keys($array) !== range(0, count($array) - 1);
    }

    return false;
  }
}

if (! function_exists('implode_recursive')) {
  /**
   * Glue recursive
   *
   * @param array $array
   * @param string|null $glue
   * @param bool $include_keys
   * @param bool $trim_all
   * @return false|string|string[]|null
   */
  function implode_recursive(array $array = [], string $glue = null, $include_keys = false, $trim_all = true) {
    $glued_string = '';

    // Recursively iterates array and adds key/value to glued string
    array_walk_recursive($array, function($value, $key) use ($glue, $include_keys, &$glued_string){
      $include_keys and $glued_string .= $key.$glue;
      $glued_string .= $value.$glue;
    });

    // Removes last $glue from string
    strlen($glue) > 0 and $glued_string = substr($glued_string, 0, -strlen($glue));

    // Trim ALL whitespace
    $trim_all and $glued_string = preg_replace("/(\s)/ixsm", '', $glued_string);

    return $glued_string;
  }
}

if (! function_exists('get_image_sizes')) {
  /**
   * Get size information for all currently-registered image sizes.
   *
   * @global $_wp_additional_image_sizes
   * @uses   get_intermediate_image_sizes()
   * @return array $sizes Data for all currently-registered image sizes.
   */
  function get_image_sizes() {
    global $_wp_additional_image_sizes;

    $sizes = [];

    foreach ( get_intermediate_image_sizes() as $_size ) {
      if (in_array($_size, ['thumbnail', 'medium', 'medium_large', 'large'])) {
        $sizes[$_size]['width']  = get_option("{$_size}_size_w");
        $sizes[$_size]['height'] = get_option("{$_size}_size_h");
        $sizes[$_size]['crop']   = (bool) get_option("{$_size}_crop");
      } elseif (isset($_wp_additional_image_sizes[$_size])) {
        $sizes[$_size] = [
          'width'  => $_wp_additional_image_sizes[$_size]['width'],
          'height' => $_wp_additional_image_sizes[$_size]['height'],
          'crop'   => $_wp_additional_image_sizes[$_size]['crop'],
        ];
      }
    }

    return $sizes;
  }

  /**
   * Get size information for a specific image size.
   *
   * @uses   get_image_sizes()
   * @param  string $size The image size for which to retrieve data.
   * @return bool|array $size Size data about an image size or false if the size doesn't exist.
   */
  function get_image_size($size) {
    $sizes = get_image_sizes();

    if (isset($sizes[$size])) {
      return $sizes[$size];
    }

    return false;
  }

  /**
   * Get the width of a specific image size.
   *
   * @uses   get_image_size()
   * @param  string $size The image size for which to retrieve data.
   * @return bool|string $size Width of an image size or false if the size doesn't exist.
   */
  function get_image_width($size) {
    if (! $size = get_image_size($size)) {
      return false;
    }

    if (isset($size['width'])) {
      return $size['width'];
    }

    return false;
  }

  /**
   * Get the height of a specific image size.
   *
   * @uses   get_image_size()
   * @param  string $size The image size for which to retrieve data.
   * @return bool|string $size Height of an image size or false if the size doesn't exist.
   */
  function get_image_height($size) {
    if (! $size = get_image_size($size)) {
      return false;
    }

    if ( isset( $size['height'] ) ) {
      return $size['height'];
    }

    return false;
  }

  /**
   * Lists all sizes in UL
   *
   * @return string output as lists.
   * @uses   get_image_size()
   */
  function get_image_sizes_output() {
    $sizes = get_image_sizes();
    $html = '<ul>';
    foreach ($sizes as $k => $v) {
      $html .= '<li>
				<strong>' . $k . '</strong> (
				Width: ' . $v['width'] . ' | 
				Height: ' . $v['height'] . ' | 
				Crop: ' . ( $v['crop'] == 1 ? 'true' : 'false' ) . ')
			</li>';
    }
    $html .= '</ul>';

    return $html;
  }
}

/**
 * Recursively removes a folder along with all its files and directories
 *
 * @param String $path
 */
if (! function_exists('rrmdir')) {
  function rrmdir($path) {
    // Open the source directory to read in files
    $i = new DirectoryIterator($path);
    foreach($i as $f) {
      if($f->isFile()) {
        unlink($f->getRealPath());
      } else if(!$f->isDot() && $f->isDir()) {
        rrmdir($f->getRealPath());
      }
    }
    rmdir($path);
  }
}

/**
 * Extract email from string
 *
 * @param $string
 * @return mixed
 */
if (! function_exists('extractEmailFromString')) {
  function extractEmailFromString($string){
    preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $string, $matches);
    return $matches[0] ?? [];
  }
}
/**
 * Extract phone numbers from string
 *
 * @param $string
 * @return mixed
 */
if (! function_exists('extractPhoneNumbersFromString')) {
  function extractPhoneNumbersFromString($string){
    preg_match_all("/(?:(?:\+?([1-9]|[0-9][0-9]|[0-9][0-9][0-9])\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([0-9][1-9]|[0-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?/", $string, $matches);
    return $matches[0] ?? [];
  }
}
