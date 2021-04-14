<?php
/**
* This will initialize the plugin
*
* @since 4.1.4
*/

namespace AiosInitialSetup\App\Modules\ScssCompiler;

class Development{

  /**
   * Constructor
   *
   * @since 4.1.4
   *
   * @access public
   */
  public function __construct() {
    $this->add_actions();
  }

  /**
   * Add Actions.
   *
   * @since 4.1.4
   *
   * @access protected
   */
  protected function add_actions() {
    /*
     * Define unsuspended event and schedule.
     * ==== MUST COME BEFORE WP CRON JOB INITIALIZATION ====
     */
    add_filter('cron_schedules', [$this, 'add_cron_schedules']);
    add_action('aios_scss_compiler_development_event', [$this, 'development_handler']);

    // Initialize WP Cron jobs
    add_action('admin_init', [$this, 'activate_cron']);
    register_deactivation_hook('AIOS Initial Setup', [$this, 'deactivate_cron']);

    // Register options
    add_action('admin_menu', [$this, 'register_settings']);

    // AJAX Action to Development mode on
    add_action('wp_ajax_aisis_scss_development', [$this, 'aisis_scss_development']);

    // AJAX Action to Unuspend UC
    add_action('wp_ajax_aisis_scss_production', [$this, 'aisis_scss_production']);

    // Add notification if uc page is suspended
    add_action('wp_footer', [$this, 'admin_notifications'], 10);
  }

  /**
   * Development mode on
   *
   * @since 4.1.4
   *
   * @return void
   * @access public
   */
  public function development() {
    update_option('aios_scss_compiler_development', 'on');
    update_option('aios_scss_compiler_development_timestamp', time());
  }

  /**
   * Production mode on
   *
   * @since 4.1.4
   *
   * @return void
   * @access public
   */
  public function production() {
    update_option('aios_scss_compiler_development', 'off');
  }

  /**
   * Check scss compiler if activate
   *
   * @return bool
   * @access public
   * @since 4.1.4
   *
   */
  public function is_activated() {
    $activation = get_option('aios_scss_compiler_development', 'off');
    return ($activation == 'on') ? false : true;
  }

  /**
   * Get number of minutes left.
   *
   * @return float|int
   * @access public
   * @since 4.1.4
   *
   */
  public function get_remaining_minutes_in_suspension() {
    $past = get_option('aios_scss_compiler_development_timestamp', time());
    $present = time();

    return (540 - round(abs($present-$past) / 60,2));
  }

  /**
   * Activate cron on plugin activation
   *
   * @since 4.1.4
   *
   * @return void
   * @access public
   */
  public function activate_cron() {
    wp_schedule_event(time(), 'aios-scss-compiler-every-minute', 'aios_scss_compiler_development_event');
    update_option('aios_scss_compiler_development_cron_activation', 'on');
  }

  /**
   * Deactivate cron job if plugins deactivate
   *
   * @since 4.1.4
   *
   * @return void
   * @access public
   */
  public function deactivate_cron() {
    wp_clear_scheduled_hook('aios_scss_compiler_development_event');
    update_option('aios_scss_compiler_development_cron_activation', '');
  }

  /**
   * Register Compiler Options
   *
   * @since 4.1.4
   *
   * @return void
   * @access public
   */
  public function register_settings() {
    register_setting('aios-intial-setup-scss-compiler-options', 'aios_scss_compiler_development');
    register_setting('aios-intial-setup-scss-compiler-options', 'aios_scss_compiler_development_timestamp');
  }

  /**
   * Development Handler
   *
   * @since 4.1.4
   *
   * @return void
   * @access public
   */
  public function development_handler() {
    if ($this->get_remaining_minutes_in_suspension() < 0 && !$this->is_activated()) $this->production();
  }

  /**
   * Add cron schedule
   *
   * @param $schedules
   * @return void
   * @access public
   * @since 4.1.4
   *
   */
  public function add_cron_schedules($schedules) {
    if (! isset( $schedules["aios-scss-compiler-every-minute"])) {
      $schedules["aios-scss-compiler-every-minute"] = [
        'interval' => 1*60,
        'display' => __('Every minute')
      ];
    }
    return $schedules;
  }

  /**
   * Turn on development mode
   *
   * @return void
   * @access public
   * @since 4.1.4
   *
   */
  public function aisis_scss_development() {

    $notification = [];
    $notification[] = 'development';

    update_option('aios_scss_compiler_development', 'on');
    update_option('aios_scss_compiler_development_timestamp', time());

    echo json_encode($notification);
    die();
  }

  /**
   * Turn off development mode
   *
   * @return void
   * @access public
   * @since 4.1.4
   *
   */
  public function aisis_scss_production() {
    $notification = [];
    $notification[] = 'production';

    update_option('aios_scss_compiler_development', 'off');
    update_option('aios_scss_compiler_development_timestamp', '');

    echo json_encode($notification);
    die();
  }

  /**
   * Additional notifications
   *
   * @since 4.1.4
   *
   * @access public
   */
  public function admin_notifications() {
    $is_active = get_option( 'aios_scss_compiler_development', '' );

    if ($is_active == 'on') {
      echo '<div class="wpui-minimalist-notifications wpui-position-bottom wpui-warning"><strong>Warning</strong>: Development mode is ON!<span class="wpui-close"></span></div>';
    }
  }
}

new Development();
