<?php

namespace AiosInitialSetup\App;

use AiosInitialSetup\Config\Config;
use AiosInitialSetup\Database\Leads;
use AiosInitialSetup\Config\Modules as ConfigModules;

class App
{
  use Config,
    ConfigModules;

  /**
   * App constructor.
   *
   * @param $file
   */
  public function __construct($file)
  {
    // Plugin install and uninstall process
    register_activation_hook($file, [$this, 'install']);
    register_deactivation_hook($file, [$this, 'uninstall']);

    // Register and Create Table
    add_action('admin_init', [$this, 'register_transient_plugin']);
    add_action('plugins_loaded', [$this, 'databaseLeads']);

    // Admin UI Scripts
    add_action('admin_enqueue_scripts', [$this, 'userInterface'], 11);
    add_action('wp_enqueue_scripts', [$this, 'loggedInUserInterface'], 11);

    // Admin Menus
    add_action('admin_menu', [$this, 'edit_admin_menus'], 99);
    add_action('admin_menu', [$this, 'main_tab_menu'], 9);

    // Fix issues with color picker in WordPress version 5.5.x or higher
    if (is_admin()){
      add_action('wp_default_scripts', [$this, 'wp_default_custom_scripts']);
    }
  }

  /**
   * Fix issues with color picker in WordPress version 5.5.x or higher
   *
   * @param $scripts
   * @since 5.2.8
   */
  public function wp_default_custom_scripts($scripts)
  {
    $scripts->add('wp-color-picker', '/wp-admin/js/color-picker.js', ['iris'], false, 1);

    did_action('init') && $scripts->localize(
      'wp-color-picker',
      'wpColorPickerL10n',
      [
        'clear' => __('Clear'),
        'clearAriaLabel' => __('Clear Color'),
        'defaultString' => __('Default'),
        'defaultAriaLabel' => __('Select Default Color'),
        'pick' => __('Select Color'),
        'defaultLabel' => __('Color Value'),
      ]
    );
  }

  /**
   * Plugin Installation.
   *
   * @since 1.0.0
   */
  public function install()
  {
    // Update permalink and blog description
    update_option('permalink_structure','/%postname%/');
    update_option('blogdescription','');

    // Update `Medium` size to fit mobile view
    update_option( 'medium_size_w', 400 ); // Max Width
    update_option( 'medium_size_h', 400 ); // Max Height

    // Install Leads Table
    if (get_option(AIOS_LEADS_NAME . '_version')) {
      $table = new Leads();
      $table->table(AIOS_LEADS_VERSION);
    }

    // Update option to enable classic editor
    if (empty(get_option('aios-modules-classic-editor-install', ''))) {
      $aios_initial_setup_modules = get_option('aios_initial_setup_modules');
      $aios_initial_setup_modules['classic-editor'] = 'yes';

      update_option('aios_initial_setup_modules', $aios_initial_setup_modules);
      update_option('aios-modules-classic-editor-install', 'installed');
    }

    // Classic editor module
    if (is_multisite()) {
      add_network_option(null, 'classic-editor-replace', 'classic');
      add_network_option(null, 'classic-editor-allow-sites', 'disallow');
    }

    add_option('classic-editor-replace', 'classic');
    add_option('classic-editor-allow-users', 'disallow');
  }

  /**
   * Plugin Uninstalling.
   *
   * @since 1.0.0
   */
  public function uninstall()
  {
    // Classic editor module
    if (is_multisite()) {
      delete_network_option(null, 'classic-editor-replace');
      delete_network_option(null, 'classic-editor-allow-sites');
    }

    delete_option('classic-editor-replace');
    delete_option('classic-editor-allow-users');
  }

  /**
   * Register transient
   *
   * @since 2.5.4
   *
   * @access public
   */
  public function register_transient_plugin()
  {
    if (! $this->get_transient_module('modules')) {
      $this->set_transient_module('modules', true, false);
    }
  }

  /**
   * Check if database need to be updated.
   *
   * @since 4.1.1
   */
  public function databaseLeads()
  {
    if (get_option(AIOS_LEADS_NAME . '_version') !== AIOS_LEADS_VERSION) {
      $table = new Leads();
      $table->table(AIOS_LEADS_VERSION);
    }
  }

  /**
   * Enqueue scripts and styles
   *
   * @since 2.8.6
   */
  public function userInterface()
  {
    $admin_page_id = get_current_screen()->id;

    // Enqueue Agentimage Font
    wp_enqueue_style('agentimage-font', 'https://resources.agentimage.com/fonts/agentimage.font.icons.css');

    // Google Font: Roboto Condensed and Roboto
    wp_enqueue_style('admin-uiux-google-font-roboto', 'https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap');

    // Enqueue Agentimage Utilities
    wp_enqueue_style('agentimage-utilities', 'https://resources.agentimage.com/libraries/css/aios-utilities.min.css');

    // Enqueue notification
    wp_enqueue_style('aios-sweetalert2-style', 'https://resources.agentimage.com/admin/css/swal.css');
    wp_enqueue_script('aios-sweetalert2-script', 'https://resources.agentimage.com/admin/js/sweetalert2.min.js');

    // Enqueue Classic WPUIKIT for old Listings
    // wp_enqueue_style('aios-wpuikit-classic-style', 'https://resources.agentimage.com/wpuikit/classics/wpuikit-classic.css');

    // Enqueue WPUIKIT
    wp_enqueue_style('aios-wpuikit-style', 'https://resources.agentimage.com/wpuikit/v1/wpuikit.min.css');
    wp_enqueue_script('aios-wpuikit-script', 'https://resources.agentimage.com/wpuikit/v1/wpuikit.min.js');

    // Enqueue WPUIKIT for Development
    // wp_enqueue_style('aios-wpuikit-style', AIOS_INITIAL_SETUP_RESOURCES . 'css/wpuikit.min.css', [], time());
    // wp_enqueue_script('aios-wpuikit-script', AIOS_INITIAL_SETUP_RESOURCES . 'js/wpuikit.min.js', [], time());

    // Enqueue ajax update
    wp_enqueue_script('aios-ajax-option-update-script', AIOS_INITIAL_SETUP_RESOURCES . 'js/ajax-options.min.js', ['jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'wp-api'], time());
    wp_localize_script('aios-ajax-option-update-script', 'ajaxurl', admin_url('admin-ajax.php'));

    // Support picture element, srcset and sizes attributes
    wp_enqueue_script('aios-picturefill', 'https://resources.agentimage.com/libraries/js/picturefill.min.js');

    if (strpos($admin_page_id, 'dashboard') !== false) {
      wp_enqueue_style('aios-initial-setup-dashboard-widget', AIOS_INITIAL_SETUP_RESOURCES . 'css/dashboard-widgets.min.css');
    }

    if (strpos($admin_page_id, 'aios-all-in-one') !== false || strpos($admin_page_id, 'aios-site-info') !== false) {
      if (function_exists('wp_enqueue_media')) {
        wp_enqueue_media();
      }

      wp_enqueue_style('wp-color-picker');
      wp_enqueue_script('wp-color-picker');

      // Alpha Color Picker
      wp_register_script('wp-color-picker-alpha', 'https://resources.agentimage.com/libraries/js/wp-color-picker-alpha.min.js', ['wp-color-picker']);
      wp_enqueue_script('wp-color-picker-alpha');
    }
  }

  /**
   * Enqueue scripts and styles for logged in users
   *
   * @since 4.1.4
   */
  public function loggedInUserInterface()
  {
    if (is_user_logged_in()) {
      wp_enqueue_style('wpuikit-aios-initial-setup-admin-style', 'https://resources.agentimage.com/admin/css/aios-all-in-one-admin.min.css');
      wp_enqueue_script('wpuikit-aios-initial-setup-admin-script', 'https://resources.agentimage.com/admin/js/aios-all-in-one-admin.min.js');
    }
  }

  /**
   * Edit Menu for aios all in one
   *
   * @since 2.8.6
   */
  public function edit_admin_menus()
  {
    global $menu;
    global $submenu;

    unset($submenu['aios-all-in-one'][0]);
  }

  /**
   * Create a main menu tab for all plugins.
   *
   * @since 2.8.6
   */
  public function main_tab_menu()
  {
    $loginScreen = $this->loginScreen();

    add_menu_page(
      $loginScreen['title'] . ' All in One',
      $loginScreen['title'] . ' All in One',
      'manage_options',
      'aios-all-in-one',
      [$this, 'renderDashboard'],
      $loginScreen['icon'],
      91
    );
  }
}
