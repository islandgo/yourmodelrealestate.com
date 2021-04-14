<?php

namespace AiosInitialSetup\App\Controllers;

use AiosInitialSetup\Config\Config;

class DashboardController
{
  use Config;

  /**
   * DashboardController constructor.
   */
  public function __construct()
  {
    $loginScreen = get_option('aios_custom_login_screen');
    $loginScreen = ! empty($loginScreen) ? $loginScreen : 'default';

    if ($loginScreen !== 'thedesignpeople') {
      add_action('admin_init', [$this, 'get_agentimage_details'], 12);
      add_action('wp_dashboard_setup', [$this, 'amnwidget'], 999);
    }
  }

  /**
   * Global declare $jsondata_ai_detail but this need to be transfer once init.dashboard.class.php is used
   *
   * @since 3.8.8
   */
  public function get_agentimage_details(){
    $jsondata_ai_detail = get_transient('jsondata_ai_detail');
    $jsondata_ai_detail = $jsondata_ai_detail !== false ? $jsondata_ai_detail : $this->dashboardData();
    set_transient( 'jsondata_ai_detail', $jsondata_ai_detail, 72 * HOUR_IN_SECONDS );
  }

  /**
   * Add dashboard meta box
   *
   * @since 3.8.8
   */
  public function amnwidget() {
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');

    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    remove_meta_box('dashboard_secondary', 'dashboard', 'side');
    remove_meta_box('agent_image_news-dashboard-widget', 'dashboard', 'side');

    add_meta_box(
      'amnwidget',
      'Agent Image News',
      [$this, 'amn_widget_display'],
      'dashboard',
      'side',
      'high'
    );
  }

  /**
   * Callback function for Agent Image News
   *
   * @since 3.8.8
   */
  public function amn_widget_display() {
    $jsondata_ai_detail = get_transient('jsondata_ai_detail', []);

    // Get RSS Feed(s)
    require_once(ABSPATH . WPINC . '/feed.php');

    $maximum_number_of_items_to_show = 3;
    $subtitle = $jsondata_ai_detail['sub-title'] ?? 'Real Estate Website Design';
    $sales = $jsondata_ai_detail['phone']['sales'] ?? '1.800.979.5799';
    $support = $jsondata_ai_detail['phone']['support'] ?? '1.877.317.4111';

    $feed_content = '<div class="amw-logo">
        <a href="//www.agentimage.com/" target="_blank" class="amw-logo-link">
            <em class="ai-font-agentimage-logo"></em>
            <span class="amw-sub">' . $subtitle . '</span>
        </a>
        <div class="amn-contact-details">
            <span class="sales-btn">
                Sales
                <a href="tel:' . $sales . '"><i class="ai-font-phone"></i> ' . $sales . '</a>
            </span>
            <span class="support-btn">
                Support
                <a href="//www.agentimage.com/support/" class="ai-num-dark"><i class="ai-font-phone"></i> ' . $support . '</a>
            </span>
        </div>
      </div>';

    // Get a SimplePie feed object from the specified feed source.
    $rss = fetch_feed($jsondata_ai_detail['feed_uri']);

    $max_items = 0;
    $rss_items = [];
    // Checks that the object is created correctly
    if (! is_wp_error($rss)) {
      // Figure out how many total items there are.
      $max_items = $rss->get_item_quantity($maximum_number_of_items_to_show);

      // Build an array of all the items, starting with element 0( i.e. first element ).
      $rss_items = $rss->get_items(0, $max_items);
    }

    if ($max_items == 0) {
      $feed_content = '<div class="no-items-to-show">Refresh to load news.</div>';
    } else {
      $feed_content .= '<div class="rss-widget"><ul>';
      foreach ($rss_items as $rss_item) {
        $enclosure = $rss_item->get_enclosure();
        $rss_item_title = $rss_item->get_title();
        $rss_item_page_url = $rss_item->get_permalink();
        $rss_item_date = $rss_item->get_date('M j, Y');

        $rss_item_content = $rss_item->get_content();

        // featuredimage - inserted using add_filter rss
        $regex = sprintf('/\<img class="rss-ai-feed" src="%s(.*?)"\>/', $jsondata_ai_detail['feed_image_regex']);
        preg_match($regex, $rss_item_content, $featured_image);

        /** Fallback */
        if (empty($featured_image)) {
          $regex = '/\<img class="rss-ai-feed" src="(.*?)"\>/';
          preg_match($regex, $rss_item_content, $featured_image);
        }

        // Cut off the rss_item_content and strip html tags
        $rss_item_excerpt = strip_tags($rss_item_content);
        if (($char_count = strlen($rss_item_excerpt)) > 250) {
          // Cut characters
          $rss_item_excerpt = substr( $rss_item_excerpt, 0, 250 );
          // Remove up until the last occurence of a space
          $rss_item_excerpt = substr( $rss_item_excerpt, 0, strrpos( $rss_item_excerpt, ' ' ) );
          // Add ellipsis
          $rss_item_excerpt .= '...';
        }

        // <canvas width="300" height="100" style="background-image: url( https://www.agentimage.com/' . $featured_image[1] . ' );"></canvas>
        $feed_content .= '<li>
          <div class="rssTitle">
            <a class="rsswidget" href="' . $rss_item_page_url . '" target="_blank">' . $rss_item_title . '</a>
            <span class="rss-date">' . $rss_item_date . '</span>
          </div>
          <div class="rssContainer">
            <div class="rssSummaryImg">
              <a class="rsswidget" href="' . $rss_item_page_url . '" target="_blank">
                <canvas width="300" height="100" style="background-image: url(' . $featured_image[1] . ');"></canvas>
              </a>
            </div>
            <div class="rssSummary">' . $rss_item_excerpt . '</div>
          </div>
        </li>';
      }
      $feed_content .= '</ul></div>';
    }
    $feed_content .= '<a href="//www.agentimage.com/blog/" target="_blank" class="amn-more-tips">More Real Estate Marketing Tips</a>';
    echo $feed_content;
  }
}

new DashboardController();
