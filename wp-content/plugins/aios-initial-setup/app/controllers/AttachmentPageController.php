<?php

namespace AiosInitialSetup\App\Controllers;

class AttachmentPageController
{
  /**
   * AttachmentPage constructor.
   */
  public function __construct()
  {
    add_filter('wp_unique_post_slug_is_bad_attachment_slug', '__return_true', 100);
    add_action('template_redirect', [$this, 'redirect_attachment_page'], 2);
    add_filter('wp_handle_upload_prefilter',[$this, 'validate_image_size']);
  }

  /**
   * Add Actions.
   *
   * @return bool
   * @since 3.2.9
   *
   * @access public
   */
  public function redirect_attachment_page()
  {
    if (! is_attachment()) {
      return false;
    }

    $url = wp_get_attachment_url(get_queried_object_id());

    if (! empty($url)) {
      $this->do_attachment_redirect($url);
      return true;
    }

    return false;
  }

  /**
   * Performs the redirect from the attachment page to the image file itself.
   *
   * @since 3.2.9
   *
   * @param string $attachment_url The attachment image url.
   *
   * @return void
   */
  public function do_attachment_redirect($attachment_url)
  {
    header('X-Redirect-By: AgentImage');
    wp_redirect($attachment_url, 301);
    exit;
  }

  /**
   * Check if PNG and limit to 300kb
   *
   * @param $file
   * @return array
   */
  public function validate_image_size( $file ) {
    $image = getimagesize($file['tmp_name']);
    $size = filesize($file['tmp_name']);

    if ($size > 300000 && $image['mime'] === 'image/png') {
      $file['error'] = "PNG file are too large. Maximum file size is 300kb, uploaded image is " . $this->formatBytes($size);
    }

    return $file;
  }

  /**
   * Convert bytes to KB/MB/GB
   *
   * @param $bytes
   * @return string
   */
  private function formatBytes($bytes) {
    if ($bytes >= 1073741824) {
      return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
      return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
      return number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
      return $bytes . ' bytes';
    } elseif ($bytes == 1) {
      return '1 byte';
    } else {
      return '0 bytes';
    }
  }
}

new AttachmentPageController();
