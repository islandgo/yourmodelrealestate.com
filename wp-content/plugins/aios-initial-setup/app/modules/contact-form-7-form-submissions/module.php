<?php

namespace AiosInitialSetup\App\Modules\ContactFormSubmissions;

use AiosInitialSetup\Config\Config;
use ReflectionClass;
use ReflectionException;
use WP_Query;
use WP_REST_Request;
use WP_REST_Response;

class Module
{
  use Config;

  /**
   * Run class
   *
   * @return void
   */
  public function __construct()
  {
    add_action('admin_menu', [$this, 'render_sub_pages'], 11);
    add_action('wpcf7_mail_sent', [$this, 'wpcf7_insert_post']);
    add_action('wp_ajax_delete_leads', [$this, 'delete_leads']);
    add_action('init', [$this, 'export_leads']);
  }

  /**
   * Add sub menu page
   *
   * @since 3.8.0
   *
   * @access public
   */
  public function render_sub_pages()
  {
    $loginScreen = $this->loginScreen();

    add_menu_page(
      'Contact Form 7 Leads - AgentImage Plugin',
      $loginScreen['title'] . ' CF7 Leads',
      'manage_options',
      'aios-cf7-store-messages',
      [$this, 'render'],
      $loginScreen['icon'],
      93
    );
  }

  /**
   * Fallback: Render sub menu page
   *
   * @since 3.8.0
   *
   * @access public
   */
  public function render()
  {
    include_once AIOS_INITIAL_SETUP_VIEWS . 'email-leads' . DIRECTORY_SEPARATOR . 'index.php';
  }

  /**
   * Insert post to custom post type
   *
   * @param $WPCF7_ContactForm
   * @return void
   * @throws ReflectionException
   * @since 3.8.0
   *
   */
  public function wpcf7_insert_post($WPCF7_ContactForm)
  {
    $title = trim(preg_replace('/\s*\([^)]*\)/', '', $WPCF7_ContactForm->title));
    $category = preg_replace("![^a-z0-9]+!i", "-", $title);
    $wpcf7 = \WPCF7_ContactForm:: get_current();
    $submission = \WPCF7_Submission::get_instance();

    if ($submission) {
      $data = $submission->get_posted_data();
      $dataSkip = ['_wpcf7', '_wpcf7_version', '_wpcf7_locale', '_wpcf7_unit_tag', '_wpcf7_container_post', 'zerospam_key'];
      $inputSingle = ['text', 'email', 'textarea'];
      $firstName = $data['your-first-name']
              . $data['your-fname']
              . $data['fname']
              . $data['firstName']
              . $data['first-name']
              . $data['TxtFirstName']
              . $data['f-name']
              . $data['about-fname']
              . $data['listings-fname'];
      $middleName = $data['your-middle-name']
              . $data['your-mname']
              . $data['mname']
              . $data['middleName']
              . $data['middle-name']
              . $data['TxtMiddleName']
              . $data['m-name'];
      $lastName = $data['your-last-name']
              . $data['your-lname']
              . $data['lname']
              . $data['lastName']
              . $data['last-name']
              . $data['TxtLastName']
              . $data['l-name']
              . $data['about-name']
              . $data['listings-lname'];
      $fullName = $data['your-name']
              . $data['your-fullname']
              . $data['fullname']
              . $data['full_name']
              . $data['TxtFullName']
              . $data['about-name']
              . $data['git-name']
              . $data['listings-name']
              . $data['contact-name'];
      $name = ! empty($fullName) ? $fullName : $firstName . ' ' . trim($middleName . ' ' . $lastName);
      $email = $data['your-email']
              . $data['email']
              . $data['email-address']
              . $data['TxtEmailAddress']
              . $data['git-email']
              . $data['about-email']
              . $data['contact-email']
              . $data['listings-email']
              . $data['join-email'];
      $phone = $data['your-phone']
              . $data['phone']
              . $data['phone-number']
              . $data['TxtPhoneNumber']
              . $data['git-phone']
              . $data['about-phone']
              . $data['contact-phone']
              . $data['listings-phone'];
      $message = $data['your-message']
              . $data['message']
              . $data['TxtMessage']
              . $data['git-message']
              . $data['about-message']
              . $data['listings-message']
              . $data['contact-message'];
      $formTag = $this->accessProtected($wpcf7, 'scanned_form_tags');

      /** List of input used */
      $meta = $this->accessProtected($submission, 'meta');

      /** List of page url, time, and ip of user */
      $page_source = str_replace(get_site_url(), '', $meta['url']);
      $date_created = date("m/d/Y h:i:s A", $meta['timestamp']);
      $bodyArr = [];
      foreach ($data as $k => $v) {
        if (!in_array($k, $dataSkip) && !empty($v)) {
          foreach ($formTag as $kf) {
            if ($kf->name == $k) {
              if (in_array($kf->baseType, $inputSingle)) {
                $labels = (!empty($kf->labels) ? $kf->labels : ucwords(preg_replace("![^a-z0-9]+!i", " ", $kf->name)));
              } else {
                $labels = ucwords(preg_replace("![^a-z0-9]+!i", " ", $kf->name));
              }

              $bodyArr[][$labels] = is_array($v) ? join(', ', $v) : $v;
            }
          }
        }
      }

      $bodyArr['browser'] = $meta['user_agent'];
      $bodyArr['remote_ip'] = $meta['remote_ip'];

      /**
       * Insert to Database Table
       */
      global $wpdb;
      $wpdb->insert($wpdb->prefix . AIOS_LEADS_NAME, [
        'title' => $title,
        'category' => $category,
        'client_name' => $name,
        'client_email' => $email,
        'client_phone' => $phone,
        'client_message' => $message,
        'client_body' => serialize($bodyArr),
        'remote_ip' => $meta['remote_ip'],
        'page_source' => $page_source,
        'date' => $date_created,
        'created_at' => date("Y-m-d H:i:s")
      ]);
    }
  }

  /**
   * Access protected property
   *
   * @param $obj (array) - Object Array
   * @param $prop (string) - Property you want to access
   *
   * @return mixed
   * @throws ReflectionException
   * @since 3.8.0
   */
  public function accessProtected($obj, $prop)
  {
    $reflection = new ReflectionClass($obj);
    $property = $reflection->getProperty($prop);
    $property->setAccessible(true);
    return $property->getValue($obj);
  }

  /**
   * Delete Leads
   */
  public function delete_leads()
  {
    if (isset($_POST['data']) && ! empty($_POST['data'])) {
      global $wpdb;
      $table_name = $wpdb->prefix . AIOS_LEADS_NAME;
      $ids = implode(',', array_map('absint', $_POST['data']));
      $wpdb->query("DELETE from $table_name WHERE id IN($ids)");
    }

    echo json_encode(['Deleted']);
    die();
  }

  /**
   * Export Leads
   */
  public function export_leads()
  {
    error_reporting(0);
    if (strpos($_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], str_replace(['http://', 'https://'], '', get_site_url() . '/aios/leads/export')) !== false) {

      // Get SQL data
      global $wpdb;
      $table_name = $wpdb->prefix . AIOS_LEADS_NAME;
      $query = "(SELECT * FROM $table_name)";
      $wpdb->query($query);
      $prepare = $wpdb->prepare("
        $query
        ORDER BY id DESC
        LIMIT %d OFFSET %d",
        10000,
        0
      );
      $results = $wpdb->get_results($prepare, OBJECT);

      $data = ['No leads to be exported.'];

      if (! empty($results)) {
        // prepare the data set
        $data = [['Name', 'Email', 'Form', 'Phone', 'Message', 'Page Source', 'Date']];

        foreach ($results as $row) {
          $client_body = maybe_unserialize($row->client_body);
          $client_html = $client_body;

          if (is_array($client_body)) {
            // Get browser and remote_ip then unset
            $browser = $client_body['browser'];
            unset($client_body['browser']);
            $remote_ip = $client_body['remote_ip'];
            unset($client_body['remote_ip']);

            // Reset data
            $client_html = "Form Details\n";

            foreach ($client_body as $arr) {
              $client_html .= !empty($arr) ? key($arr) . ': ' . $arr[key($arr)] . "\n" : '';
            }

            // Other Data
            $client_html .= "\nOther Info\n
Browser: {$browser}\n
Remote IP: {$remote_ip}\n
Page Source: {$row->page_source}\n
Date: {$row->date}\n";
          } else {
            $client_html = preg_replace('/^ +/m', '', $client_html); // Remove space from start of each new line
            $client_html = str_replace('<br>', "\n", $client_html); // Change BR to newline
            $client_html = str_replace('<span class="full-logs-details-title mt-0">Form Details</span>', "Form Details\n", $client_html); // Change end of span from new line
            $client_html = strip_tags($client_html); // Strip tags
          }

          // Let's extract email if client_email doesn't exists
          $email = $row->client_email ?? '';
          if (empty($email)) {
            $emails = extractEmailFromString($client_html);

            if (count($emails) > 0) {
              $email = $emails[0];
            }
          }

          // Let's extract phone if client_phone doesn't exists
          $phoneNumber = $row->client_phone ?? '';
          if (empty($phoneNumber)) {
            $phoneNumbers = extractPhoneNumbersFromString($client_html);

            if (count($phoneNumbers) > 0) {
              $phoneNumber = implode(', ', $phoneNumbers);
            }
          }

          $data[] = [
            $row->client_name,
            $email,
            $row->category,
            $phoneNumber,
            $row->message,
            $row->page_source,
            $row->date,
            isset($_GET['full-details']) ? $client_html : ''
          ];
        }

      }

      header( 'Content-Type: application/csv' );
      header( 'Content-Disposition: attachment; filename="' . 'aios-leads-cf7-' . date("m-d-Y") . '.csv' . '";' );

      // clean output buffer
      ob_end_clean();

      $handle = fopen( 'php://output', 'w' );

      // use keys as column titles
      foreach ( $data as $value ) {
        fputcsv( $handle, $value , ',' );
      }

      fclose( $handle );

      // flush buffer
      ob_flush();

      // use exit to get rid of unexpected output afterward
      exit;
    }
  }
}

new Module();
