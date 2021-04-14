<?php
/**
 * Name: Rest API URL(Disabled)
 * Description: This option will help to validate the site from https://html5.validator.nu/
 */

namespace AiosInitialSetup\App\Modules\RestApiLinkDisabler;

class Module
{
  /**
   * Module constructor.
   */
  public function __construct()
  {
    add_action('after_setup_theme', [$this, 'remove_rest_api_link']);
  }

  public function remove_rest_api_link()
  {
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
  }
}

new Module();
