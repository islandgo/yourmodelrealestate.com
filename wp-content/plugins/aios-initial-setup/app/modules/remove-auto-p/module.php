<?php

namespace AiosInitialSetup\App\Modules\RemoveAutoP;

class Module
{
  /**
   * Module constructor.
   */
  public function __construct()
  {
    if (get_option('aios_auto_p_metabox') !== false) {
      add_action('add_meta_boxes', [$this, 'modified_post_meta']);
      add_filter('save_post', [$this, 'modified_post_meta_save']);
      add_action('the_post', [$this, 'remove_wpautop']);
    }
  }

  /**
   *
   */
  public function modified_post_meta()
  {
    add_meta_box('wp_content_view', 'Content View', [$this, 'modified_post_meta_function'], 'page', 'side', 'high');
    add_meta_box('wp_content_view', 'Content View', [$this, 'modified_post_meta_function'], 'post', 'side', 'high');
  }

  /**
   * @param $post
   */
  public function modified_post_meta_function($post)
  {
    wp_nonce_field('wp_content_view', 'wp_content_view_nonce', true, true);
    ?>
    <div class="metabox-holder">
      <div class="metabox-row">
        <?php $post_disable_p = get_post_meta($post->ID, 'ai_post_page_p', true); ?>
        <input type="checkbox" id="ai_post_page_p"
          name="ai_post_page_p" <?php echo $post_disable_p === true ? 'checked="checked"' : '' ?> /> <label
          style="margin-top: -5px; display: inline-block;" for="ai_post_page_p">Remove Auto Paragraph?</label>
      </div>
    </div>
    <?php
  }

  /**
   * @param $post_id
   */
  public function modified_post_meta_save($post_id)
  {
    if (!isset($_POST['wp_content_view_nonce'])) {
      return;
    }

    if (!wp_verify_nonce($_POST['wp_content_view_nonce'], 'wp_content_view')) {
      return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
    }

    $ai_post_page_p = $_POST['ai_post_page_p'];
    update_post_meta($post_id, 'ai_post_page_p', $ai_post_page_p);
  }

  /**
   * @param $post
   */
  public function remove_wpautop($post)
  {
    if (get_post_meta($post->ID, 'ai_post_page_p', true) === "on" && !is_archive()) {
      remove_filter('the_content', 'wpautop');
    }
  }
}

new Module();
