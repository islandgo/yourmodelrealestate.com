<?php

namespace AiosInitialSetup\App\Widgets;

class Controller
{
  /**
   * Controller constructor.
   */
  public function __construct()
  {
    add_action('admin_enqueue_scripts', [$this, 'assets']);
    add_action('admin_head', [$this, 'widgets']);
    add_action('wp_enqueue_scripts', [$this, 'frontend']);
  }

  /**
   * Add assets on widget page
   */
  public function assets()
  {
    if (get_current_screen()->base === 'widgets') {
      // Add thickbox
      add_thickbox();

      // Enqueue plugin assets
      wp_enqueue_style('aios-all-widgets-admin-widgets', AIOS_INITIAL_SETUP_RESOURCES . 'css/widgets.min.css');
      wp_enqueue_script('aios-all-widgets-admin-widgets', AIOS_INITIAL_SETUP_RESOURCES . 'js/widgets.min.js', ['jquery'], time(), true);

      // Enqueue Dropdown Select as Standalone
      wp_enqueue_style('aios-bootstrap-dropdown-select', 'https://resources.agentimage.com/libraries/css/bootstrap-dropdown.min.css');
      wp_enqueue_script('aios-bootstrap-dropdown-select', 'https://resources.agentimage.com/libraries/js/bootstrap-dropdown.min.js', ['jquery']);
      wp_enqueue_style('aios-bootstrap-select', 'https://resources.agentimage.com/libraries/css/aios-bootstrap-select.min.css');
      wp_enqueue_script('aios-bootstrap-select', 'https://resources.agentimage.com/libraries/js/aios-bootstrap-select.min.js', ['jquery']);
    }
  }

  /**
   * Add inline script to widgets page
   */
  public function widgets() {
    if (get_current_screen()->base === 'widgets') {
      echo '<script>
        function pbcw_isNumberKey(evt){
          var charCode = (evt.which) ? evt.which : event.keyCode
          return !(charCode > 31 && (charCode < 48 || charCode > 57));
        }
      </script>';
    }
  }

  /**
   * Fallback: Enqueue Assets
   * Option should be checked on initial setup -> libraries
   */
  public function frontend()
  {
    if (! empty(get_option('aios-all-widgets-setting-fields'))) {
      wp_enqueue_style('aios-slick-style', 'https://resources.agentimage.com/libraries/css/slick.min.css');
      wp_enqueue_script('aios-slick-script', 'https://resources.agentimage.com/libraries/js/slick.min.js', ['jquery']);
    }
  }
}

new Controller();
