<?php

namespace AiosInitialSetup\App\Controllers;

use AiosInitialSetup\Helpers\Classes\MetaboxPostType;
use AiosInitialSetup\Helpers\Classes\MetaboxTaxonomy;

class AdminMetaboxController
{
  /**
   * AdminMetabox constructor.
   */
  public function __construct()
  {
    add_action('admin_init', [$this, 'init_custom_metaboxes'], 10);
    add_action('widgets_init', [$this, 'register_sidebar'], 11);
  }

  /**
   * Initialize Metaboxes
   */
  public function init_custom_metaboxes()
  {
    // Metaboxes for post types && This will also change the layout
    $aios_custom_title_post_types = get_option('aios-metaboxes-custom-title-post-types', []);
    $aios_banner_post_types = get_option('aios-metaboxes-banner-post-types', []);

    $aios_custom_title_post_types = !empty($aios_custom_title_post_types) ? assoc_array_flip($aios_custom_title_post_types) : $aios_custom_title_post_types;
    $aios_banner_post_types = !empty($aios_banner_post_types) ? assoc_array_flip($aios_banner_post_types) : $aios_banner_post_types;

    // force empty var to array
    $post_type_metaboxes = array_merge_recursive((array) $aios_custom_title_post_types, (array) $aios_banner_post_types);
    $post_type_metaboxes = array_filter($post_type_metaboxes);

    // Force to add testimonials
    $post_type_metaboxes = apply_filters('aios-default-metaboxes', $post_type_metaboxes);

    if (! is_null($post_type_metaboxes)) {
      foreach ($post_type_metaboxes as $k => $v) {
        $is_editor_support = post_type_supports($k, 'editor');
        new MetaboxPostType((string) $k, (array) $v, $is_editor_support);
      }
    }

    // Metaboxes for taxonomies && This will also change the layout
    $aios_custom_title_taxonomies = get_option('aios-metaboxes-custom-title-taxonomies', []);
    $aios_banner_taxonomies = get_option('aios-metaboxes-banner-taxonomies', []);

    $aios_custom_title_taxonomies = ! empty($aios_custom_title_taxonomies) ? assoc_array_flip($aios_custom_title_taxonomies) : $aios_custom_title_taxonomies;
    $aios_banner_taxonomies = ! empty($aios_banner_taxonomies) ? assoc_array_flip($aios_banner_taxonomies) : $aios_banner_taxonomies;

    // Force empty var to array
    $taxonomies_metaboxes = array_merge_recursive((array) $aios_custom_title_taxonomies, (array) $aios_banner_taxonomies);
    $taxonomies_metaboxes = array_filter($taxonomies_metaboxes);

    if (! is_null($taxonomies_metaboxes)) {
      foreach ($taxonomies_metaboxes as $k => $v) {
        new MetaboxTaxonomy((string) $k, (array) $v);
      }
    }
  }

  /**
   * Add widget
   */
  public function register_sidebar()
  {
    if (function_exists('register_sidebar')) {
      register_sidebar([
        'name' => 'AIOS Inner Pages Banner',
        'id' => 'aios-inner-pages-banner',
        'description' => 'Widgets in this area will show at the fold.',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
      ]);
    }
  }
}

new AdminMetaboxController();
