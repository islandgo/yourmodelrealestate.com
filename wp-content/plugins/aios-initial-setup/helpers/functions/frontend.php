<?php

if (! function_exists('is_custom_field_banner')) {
  /**
   * Check if Custom Metabox Banner is Enabled
   *
   * @param $obj - this need to be a queried object
   * @return bool
   */
  function is_custom_field_banner($obj)
  {
    // Check if from 404 page
    $aios_banner_not_found = get_option('aios-metaboxes-banner-not-found', []);

    // if (isset($aios_banner_not_found['404 Pages']) && $aios_banner_not_found['404 Pages'] === '404 Pages' && is_404()) {
    if (isset($aios_banner_not_found['404 Pages']) && is_404()) {
      return true;
    }

    // Check if obj is object, only post type and taxonomy will return object
    if (!is_object($obj)) {
      return false;
    }

    // Get Object Type then return false if empty
    $object_type = ! is_null($obj->post_type) ? $obj->post_type : (! is_null($obj->taxonomy) ? $obj->taxonomy : '');
    if(! empty($object_type)) {
      $aios_banner_post_types = get_option('aios-metaboxes-banner-post-types', []);
      $aios_banner_taxonomies = get_option('aios-metaboxes-banner-taxonomies', []);

      $aios_banner_post_types = ! empty($aios_banner_post_types) ? assoc_array_flip($aios_banner_post_types) : $aios_banner_post_types;
      $aios_banner_taxonomies = ! empty($aios_banner_taxonomies) ? assoc_array_flip($aios_banner_taxonomies) : $aios_banner_taxonomies;

      // force empty var to array
      $banner_metaboxes = array_merge_recursive((array)$aios_banner_post_types, (array)$aios_banner_taxonomies);
      $banner_metaboxes = array_filter((array)$banner_metaboxes);

      if(array_key_exists($object_type, $banner_metaboxes)) {
        return true;
      }
    }

    // Check if is archive of post type
    if (is_archive()) {
      $aios_banner_post_types_archive = get_option('aios-metaboxes-banner-post-types-archive', []);

      if (isset($aios_banner_post_types_archive['banner'])) {
        foreach ($aios_banner_post_types_archive['banner'] as $banner) {
          if ($obj->name === $banner) {
            return true;
          }
        }
      }
    }

    return false;
  }
}
