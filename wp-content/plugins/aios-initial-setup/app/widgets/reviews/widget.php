<?php

namespace AiosInitialSetup\App\Widgets\Reviews;

use WP_Widget;

class Widget extends WP_Widget
{
  private $documentationUrl;

  /**
   * Widget constructor.
   *
   * @param $id_base
   * @param $name
   * @param array $widget_options
   * @param array $control_options
   * @param string $documentationUrl
   */
  public function __construct($id_base, $name, $widget_options = [], $control_options = [], $documentationUrl = '')
  {
    $this->documentationUrl = $documentationUrl;
    parent::__construct($id_base, $name, $widget_options, $control_options);
  }

  /**
   * @param array $instance
   */
  public function form($instance)
  {
    $title = esc_attr($instance['title'] ?? '');
    $limit = esc_attr($instance['limit'] ?? '');
    $excerpt_limit = esc_attr($instance['excerpt_limit'] ?? '');
    $html = $instance['html'] ?? '';

    $output = '<div class="aios-all-widgets-help ">
			<a class="thickbox" href="' . $this->documentationUrl . '?TB_iframe=true&width=600&height=550"><span class="ai-question-o"></span>How do I use this widget?</a>
		</div>';

    $output .= '<p>
			<label for="'.$this->get_field_id('title').'">Title:</label><br />
			<input id="'.$this->get_field_id('title').'" class="widefat" name="'.$this->get_field_name('title').'" type="text" value="'.$title.'"/>
		</p>';

    $output .= '<p>
			<label for="'.$this->get_field_id('limit').'">Limit:</label><br />
			<input id="'.$this->get_field_id('limit').'" class="widefat" name="'.$this->get_field_name('limit').'" type="number" value="'.$limit.'" />
		</p>';

    $output .= '<p>
			<label for="'.$this->get_field_id('excerpt_limit').'">Excerpt Limit:</label><br />
			<input id="'.$this->get_field_id('excerpt_limit').'" class="widefat" name="'.$this->get_field_name('excerpt_limit').'" type="number" value="'.$excerpt_limit.'" />
		</p>';

    $output .= '<p>
			<lable for="'.$this->get_field_id('fp_html').'">HTML:</label><br />
			<textarea id="'.$this->get_field_id('fp_html').'" style="width:100%; height:300px;" name="'.$this->get_field_name('html').'">'.$html.'</textarea>
		</p>';

    echo $output;
  }

  /**
   * @param array $new_instance
   * @param array $old_instance
   * @return array
   */
  public function update($new_instance, $old_instance)
  {
    $instance = $old_instance;

    $instance['title'] = strip_tags($new_instance['title']);
    $instance['limit'] = strip_tags($new_instance['limit']);
    $instance['excerpt_limit'] = strip_tags($new_instance['excerpt_limit']);
    $instance['html'] = $new_instance['html'];

    return $instance;
  }

  /**
   * Outputs the content of the widget
   * Using global wpdb avoid issue not displaying reviews if certain plugin exists
   *
   * @param array $args
   * @param array $instance
   */
  public function widget($args, $instance)
  {
    global $wpdb;

    $table_name = $wpdb->prefix . 'posts';
    $query = "SELECT SQL_CALC_FOUND_ROWS $table_name.ID FROM $table_name  WHERE 1=1  AND $table_name.post_type = 'wpcr3_review' AND ($table_name.post_status = 'publish' OR $table_name.post_status = 'private')  ORDER BY $table_name.post_date DESC";
    $results = $wpdb->get_results($query, OBJECT);

    preg_match('/\[review_loopstart]([^#]+)\[review_loopend]/', $instance['html'], $match);

    if (! empty($results)) {
      $posts = '';
      $count = 1;
      $limit = ! empty($instance['limit']) ? $instance['limit'] : count($results);
      $excerpt_limit = ! empty($instance['excerpt_limit']) ? $instance['excerpt_limit'] : 150;

      foreach ($results as $k => $v) {
        $results_id = $v->ID;
        $full_content = get_post_field('post_content', $results_id);
        $excerpt = substr(strip_tags(get_post_field('post_content', $results_id)), 0, $excerpt_limit);
        $dots = strlen($full_content) > $excerpt_limit ? '...' : '';
        $rate_value = get_post_meta($results_id, 'wpcr3_review_rating', true);

        switch ($rate_value){
          case '1' : $width = '20%';
            break;
          case '2' : $width = '40%';
            break;
          case '3' : $width = '60%';
            break;
          case '4' : $width = '80%';
            break;
          case '5' : $width = '100%';
            break;
          default : $width = '0%';
        }

        $rating = '<div class="wpcr3_review_ratingValue">
          <div class="wpcr3_rating_style1">
            <div class="wpcr3_rating_style1_base ">
              <div class="wpcr3_rating_style1_average" style="width:'.$width.';">
              </div>
            </div>
          </div>
        </div>';

        $parent = get_post_meta( $results_id, 'wpcr3_review_post', true );
        $parent_permalink = get_permalink( $parent );
        $review_jumplink = $parent_permalink . '#wpcr3_id_' . $results_id;
        $to_loop = $match[1];
        $review_arr = [
          '[review_title]' => get_post_meta($results_id, 'wpcr3_review_title', true),
          '[review_name]' => get_post_meta($results_id, 'wpcr3_review_name', true),
          '[review_email]' => get_post_meta($results_id, 'wpcr3_review_email', true),
          '[review_link]' => $review_jumplink,
          '[review_rating]' => $rating,
          '[review_website]' => get_post_meta($results_id, 'wpcr3_review_website', true),
          '[full_content]' => $full_content,
          '[excerpt]' => $excerpt . $dots
        ];
        $posts .= strtr($to_loop, $review_arr);

        // Limit
        if ($count === $limit) {
          break;
        }

        $count++;
      }

      $html = preg_replace('/\[review_loopstart]([^#]+)\[review_loopend]/U', $posts, $instance['html'], 1);
      $html = str_replace('[stylesheet_directory]', get_stylesheet_directory_uri(), $html);

      echo $args['before_widget'] . (! empty($title) ? $args['before_title'] . apply_filters('widget_title', $title) . $args['after_title'] : '') . $html . $args['after_title'];
    } else {
      echo 'No Reviews Found.';
    }
  }
}

add_action('widgets_init', function () {
  register_widget(new Widget(
    'testimonial_reviews',
    'AIOS Customer Reviews To Widget',
    ['description' => 'This widget displays Reviews submitted through the WP Customer Reviews Plugin.'],
    [],
    AIOS_INITIAL_SETUP_RESOURCES . 'views/documentation/reviews.html'
  ));
});
