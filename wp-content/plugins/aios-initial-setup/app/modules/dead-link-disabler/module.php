<?php
/**
 * Name: Disable Right Click And Inspect Element
 * Description: Prevent user from user right click or f12
 */

namespace AiosInitialSetup\App\Modules\DeadLinkDisabler;

class Module
{
  public function __construct()
  {
    add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
  }

  public function enqueue_assets()
  {
    wp_register_script('aios_initial_setup_dead_link_disabler', plugin_dir_url(__FILE__) . '/js/aios-initial-setup-dead-link-disabler.js');
    wp_enqueue_script('aios_initial_setup_dead_link_disabler');
  }
}

new Module();
