<?php

namespace AiosInitialSetup\Config;

trait Modules
{
  /**
   * @param $moduleName
   * @param $moduleValue
   * @param $moduleAutoload
   * @return bool
   */
  public function set_transient_module($moduleName, $moduleValue, $moduleAutoload)
  {
    return set_transient('asis_initial_setup_advanced_setting_' . $moduleName, $moduleValue, $moduleAutoload);
  }

  /**
   * @param $moduleName
   * @return mixed
   */
  public function get_transient_module($moduleName)
  {
    return get_transient('asis_initial_setup_advanced_setting_' . $moduleName);
  }

  /**
   * Return list of default modules.
   *
   * @since 1.0.0
   * @return array
   */
  public function defaultLists()
  {
    $aiosDefaultModules = [
      'activity-logs' => ['require-plugin' => 'no'],
      'add-grayscale-image' => ['require-plugin' => 'no'],
      'default-settings' => ['require-plugin' => 'no'],
      'duplicate-posts-page' => ['require-plugin' => 'no'],
      'dead-link-disabler' => ['require-plugin' => 'no'],
      'remove-auto-p' => ['require-plugin' => 'no'],
      'aios_email_notification_metabox' => ['require-plugin' => 'no'],
      'simplepie-filters' => ['require-plugin' => 'no'],
      'yoast-breadcrumbs-fix' => ['require-plugin' => 'no'],
      'coming-soon-generator' => ['require-plugin' => 'no'],
      'idxb-titles' => ['require-plugin' => 'no'],
      'login-attempts' => ['require-plugin' => 'no'],
      'allow-shortcodes-in-action-attributes' => ['require-plugin' => 'no'],
      'auto-enable-banner-on-post-types' => ['require-plugin' => 'no'],
      'site-navigation-schema' => ['require-plugin' => 'no'],
      'rest-api-link-disabler' => ['require-plugin' => 'no']
    ];

    return $aiosDefaultModules;
  }

  /**
   * Returns updated list of default plugins
   *
   * @since 2.5.4
   * @return array
   */
  public function pluginDependent()
  {
    if (! function_exists('is_plugin_active')) {
      require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    // Lists of updated default modules
    $updated_default_modules = $this->defaultLists();

    // BEGIN: Set default/Update Options
    if ($this->get_transient_module('modules')) {

      // Check if plugin is active: Contact Form 7
      if (is_plugin_active('contact-form-7/wp-contact-form-7.php')) {
        $updated_default_modules['contact-form-7-config-validation']['require-plugin']          = 'no';
        $updated_default_modules['contact-form-7-email-template']['require-plugin']             = 'no';
        $updated_default_modules['contact-form-7-fix-date-field']['require-plugin']             = 'no';
        $updated_default_modules['contact-form-7-fix-formdata-compatibility']['require-plugin'] = 'no';
        $updated_default_modules['contact-form-7-form-submissions']['require-plugin']           = 'no';
      } else {
        $updated_default_modules['contact-form-7-config-validation']['require-plugin']          = 'yes';
        $updated_default_modules['contact-form-7-email-template']['require-plugin']             = 'yes';
        $updated_default_modules['contact-form-7-fix-date-field']['require-plugin']             = 'yes';
        $updated_default_modules['contact-form-7-fix-formdata-compatibility']['require-plugin'] = 'yes';
        $updated_default_modules['contact-form-7-form-submissions']['require-plugin']           = 'yes';
      }

      //  Check if plugin is active: Cyclone Slider
      if (is_plugin_active('cyclone-slider/cyclone-slider.php')) {
        $updated_default_modules['cyclone-slider-2-override-defaults']['require-plugin'] = 'no';
      } else {
        $updated_default_modules['cyclone-slider-2-override-defaults']['require-plugin'] = 'yes';
      }

      // Check if plugin is active: IHF
      if (is_plugin_active('optima-express/iHomefinder.php')) {
        $updated_default_modules['ihf-extra-configuration']['require-plugin'] 				= 'no';
        $updated_default_modules['ihf-fixes']['require-plugin']				 				        = 'no';
        $updated_default_modules['ihf-fix-location-field-bleeding']['require-plugin'] = 'no';
        $updated_default_modules['ihf-remove-yoast-opengraph']['require-plugin'] 			= 'no';
        $updated_default_modules['ihf-remove-title-filters']['require-plugin'] 				= 'no';
      } else {
        $updated_default_modules['ihf-extra-configuration']['require-plugin'] 				= 'yes';
        $updated_default_modules['ihf-fixes']['require-plugin']				 				        = 'yes';
        $updated_default_modules['ihf-fix-location-field-bleeding']['require-plugin'] = 'yes';
        $updated_default_modules['ihf-remove-yoast-opengraph']['require-plugin'] 			= 'yes';
        $updated_default_modules['ihf-remove-title-filters']['require-plugin'] 				= 'yes';
      }

      // Check if plugin is active: Cyclone Slider && IH
      if (is_plugin_active('cyclone-slider/cyclone-slider.php') && is_plugin_active('optima-express/iHomefinder.php')) {
        $updated_default_modules['ihf-cyclone-slider-conflict-fix']['require-plugin'] = 'no';
      } else {
        $updated_default_modules['ihf-cyclone-slider-conflict-fix']['require-plugin'] = 'yes';
      }

      // Check if plugin is active: AIOS Listings
      if (is_plugin_active('AIOS_Listings/listing_module.php.php')) {
        $updated_default_modules['site-adjustments']['require-plugin'] 	= 'no';
      } else {
        $updated_default_modules['site-adjustments']['require-plugin'] 	= 'yes';
      }

      // Check if plugin is active: TINYMCE
      if (is_plugin_active('tinymce-advanced/tinymce-advanced.php')) {
        $updated_default_modules['tinymce-config']['require-plugin'] 	= 'no';
      } else {
        $updated_default_modules['tinymce-config']['require-plugin'] 	= 'yes';
      }

      // Check if plugin is active: ZERO SPAM
      if (is_plugin_active('zero-spam/zero-spam.php')) {
        $updated_default_modules['zero-spam-default-settings']['require-plugin'] 	= 'no';
      } else {
        $updated_default_modules['zero-spam-default-settings']['require-plugin'] 	= 'yes';
      }
    }

    return $updated_default_modules;
  }
}
