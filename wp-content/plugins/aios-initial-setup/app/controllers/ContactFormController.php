<?php

namespace AiosInitialSetup\App\Controllers;

class ContactFormController
{
  /**
   * ContactForm constructor.
   */
  public function __construct()
  {
    add_action('wp_print_styles', [$this, 'initial_setup_forms']);
  }

  /**
   * Enqueue scripts and styles for initial setup sub page
   *
   * @since 2.8.6
   *
   * @access public
   */
  public function initial_setup_forms() {
    $cf7_style = '';
    $cf7_bg = get_option('cf7_bg', '');
    $cf7_bg_hover = get_option('cf7_bg_hover', '');
    $cf7_text = get_option('cf7_text', '');
    $cf7_text_hover = get_option('cf7_text_hover', '');
    $cf7_response_style = get_option('cf7_response_style', '');

    $focus_indicator = (empty($cf7_response_style['focus-indicator']) ? '#66afe9' : $cf7_response_style['focus-indicator']);

    $cf7_style .= '<style>';

    $cf7_style .= '.ai-contact-wrap input.wpcf7-submit,
    .ai-default-cf7wrap input.wpcf7-submit,
    .error-forms input.wpcf7-submit {
      background: '. (empty($cf7_bg) ? '#444444' : $cf7_bg) .' !important;
      color: '. (empty($cf7_text) ? '#ffffff' : $cf7_text) .' !important;
    }
    
    .ai-contact-wrap input.wpcf7-submit:hover,
    .ai-default-cf7wrap input.wpcf7-submit:hover,
    .error-forms input.wpcf7-submit:hover {
      background: '. (empty($cf7_bg_hover) ? '#444444' : $cf7_bg_hover) .' !important;
      color: '. (empty($cf7_text_hover) ? '#ffffff' : $cf7_text_hover) .' !important;
    }';

    if (! empty($cf7_response_style)) {
      $cf7_style .= 'div.wpcf7-response-output,
      .wpcf7 form .wpcf7-response-output {
        color: ' . $cf7_response_style['text-color'] . ' !important;
        border: 2px solid ' . $cf7_response_style['border-color'] . ' !important;
      }

      div.wpcf7-mail-sent-ok,
      .wpcf7 form.sent .wpcf7-response-output {
        border: 2px solid ' . $cf7_response_style['success-border-color'] . ' !important;
      }

      div.wpcf7-mail-sent-ng,
      div.wpcf7-aborted,
      .wpcf7 form.failed .wpcf7-response-output,
      .wpcf7 form.aborted .wpcf7-response-output{
        border: 2px solid ' . $cf7_response_style['border-color'] . ' !important;
      }

      div.wpcf7-spam-blocked,
      .wpcf7 form.spam .wpcf7-response-output{
        border: 2px solid ' . $cf7_response_style['spam-border-color'] . ' !important;
      }

      div.wpcf7-validation-errors,
      div.wpcf7-acceptance-missing,
      .wpcf7 form.invalid .wpcf7-response-output,
      .wpcf7 form.unaccepted .wpcf7-response-output{
        border: 2px solid ' . $cf7_response_style['error-border-color'] . ' !important;
      }

      span.wpcf7-not-valid-tip {
        color: ' . $cf7_response_style['border-color'] . ' !important;
      }

      
      .use-floating-validation-tip span.wpcf7-not-valid-tip {
        border: 1px solid ' . $cf7_response_style['validation-tip-border-color'] . ' !important;
        background: ' . $cf7_response_style['validation-tip-background-color'] . ' !important;
        color: ' . $cf7_response_style['validation-tip-text-color'] . ' !important;
      }';
    }
    $cf7_style .= '
        .ai-default-cf7wrap input[type="text"]:focus, 
        .ai-default-cf7wrap input[type="tel"]:focus, 
        .ai-default-cf7wrap input[type="email"]:focus,
        .ai-default-cf7wrap select:focus,
        .ai-default-cf7wrap textarea:focus,
        .error-page-content-wrapper .error-forms input[type=text]:focus, 
        .error-page-content-wrapper .error-forms input[type=email]:focus, 
        .error-page-content-wrapper .error-forms input[type=phone]:focus,
        .error-page-content-wrapper .error-forms textarea:focus{
            border-color: '.$focus_indicator.';
            outline: 0;
            -webkit-box-shadow: inset 0 1px 1px '.$focus_indicator.', 0 0 8px '.$focus_indicator.';
            box-shadow: inset 0 0 1px '.$focus_indicator.', 0 0 8px '.$focus_indicator.';
    }
    ';
    $cf7_style .= '</style>';
    echo $cf7_style;
  }
}

new ContactFormController();
