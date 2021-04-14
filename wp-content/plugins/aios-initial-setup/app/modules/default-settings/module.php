<?php

namespace AiosInitialSetup\App\Modules\DefaultSettings;

class Module
{
  /**
   * Module constructor.
   */
  public function __construct()
  {
    add_action('admin_enqueue_scripts', [$this, 'custom_admin_assets']);
    add_action('wp_loaded', [$this, 'update_options']);
  }

  /**
   * Set WP Admin->Settings->Discussion->Default article settings to false
   */
  public function update_options()
  {
    update_option('default_pingback_flag', 0);
    update_option('default_ping_status', 0);
    update_option('default_comment_status', 0);
  }


  public function custom_admin_assets()
  {
    wp_enqueue_script('jquery');
    wp_register_script('aios-initial-setup-default-settings', plugin_dir_url(__FILE__) . '/js/scripts.js');
    wp_enqueue_script('aios-initial-setup-default-settings');
  }
}

new Module();
