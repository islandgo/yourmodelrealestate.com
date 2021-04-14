<?php
/**
 * Name: Allow Shortcodes In Action Attribute
 * Description: Wordpress 5.0.1 disabled shortcodes in <form> action attributes. This module allows it
 */

namespace AiosInitialSetup\App\Modules\AllowShortcodesInActionAttributes;

class Module
{

  /**
   * Constructor
   *
   * @since 4.7.3
   *
   * @access private
   */
  public function __construct()
  {
    add_filter('wp_kses_allowed_html', [$this, 'wp_kses_allowed_html'], 10, 2);
  }

  /**
   * Allows shortcodes in action attribute
   *
   * @param $allowedPostTags
   * @param $context
   * @return mixed
   * @since 4.7.3
   *
   * @access private
   */
  public function wp_kses_allowed_html ($allowedPostTags, $context)
  {
    if ($context === 'post') {
      $allowedPostTags['form']['action'] = 1;
    }

    return $allowedPostTags;
  }
}

new Module();
