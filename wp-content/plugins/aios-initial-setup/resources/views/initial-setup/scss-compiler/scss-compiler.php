<?php
if ($scssCompiler !== 'no') :
  $scss_location = $scssCompilerOptions['scss_location'] ?? '';
  $css_location = $scssCompilerOptions['css_location'] ?? '';
  $compiling_mode = $scssCompilerOptions['compiling_mode'] ?? '';
  $source_map_mode = $scssCompilerOptions['source_map_mode'] ?? '';
  $error_display = $scssCompilerOptions['error_display'] ?? '';
  $disabled_auto_enqueue = $scssCompilerOptions['disabled_auto_enqueue'] ?? '';
  ?>
  <!-- BEGIN: Row Box -->
  <div class="wpui-row wpui-row-box">
    <div class="wpui-col-md-3">
      <p><span class="wpui-settings-title">Configure Paths</span></p>
    </div>
    <div class="wpui-col-md-9">
      <p class="mt-0">Add paths this will run path under active theme "aios-starter-theme-child/scss" without front and trailing slash</p>
      <?php
      echo $fields->input_field( array(
        'row'           => false,
        'label'         => true,
        'label_value'   => 'SCSS Location',
        'helper_value'  => 'Default: themes/ACTIVE_THEME/ "scss"',
        'name' 		    => 'scss_compiler[scss_location]',
        'class' 	    => '',
        'value' 	    => $scss_location,
        'placeholder'   => 'scss',
        'type' 			=> 'text',
      ) );

      echo $fields->input_field( array(
        'row'           => false,
        'label'         => true,
        'label_value'   => 'CSS Location',
        'helper_value'  => 'Default: themes/ACTIVE_THEME/ "css"',
        'name' 		    => 'scss_compiler[css_location]',
        'class' 	    => '',
        'value' 	    => $css_location,
        'placeholder'   => 'css',
        'type' 			=> 'text',
      ) );
      ?>
    </div>
  </div>
  <!-- END: Row Box -->
  <!-- BEGIN: Row Box -->
  <div class="wpui-row wpui-row-box">
    <div class="wpui-col-md-3">
      <p><span class="wpui-settings-title">Compiling Options</span></p>
    </div>
    <div class="wpui-col-md-9">
      <p class="mt-0">Choose how you would like SCSS and source maps to be compiled and how you would like the plugin to handle errors</p>
      <?php
      echo $fields->select([
        'row' => false,
        'label' => true,
        'label_value' => 'Compiling Mode',
        'name' => 'scss_compiler[compiling_mode]',
        'class' => '',
        'value' => $compiling_mode,
        'options' => [
          'Leafo\ScssPhp\Formatter\Compressed' => 'Compressed',
          'Leafo\ScssPhp\Formatter\Expanded' => 'Expanded',
          'Leafo\ScssPhp\Formatter\Nested' => 'Nested',
          'Leafo\ScssPhp\Formatter\Compact' => 'Compact',
          'Leafo\ScssPhp\Formatter\Crunched' => 'Crunched',
          'Leafo\ScssPhp\Formatter\Debug' => 'Debug'
        ]
      ]);

      echo $fields->select([
        'row' => false,
        'label' => true,
        'label_value' => 'Source Map Mode	',
        'name' => 'scss_compiler[source_map_mode]',
        'class' => '',
        'value' => $source_map_mode,
        'options' => [
          'SOURCE_MAP_NONE' => 'None',
          'SOURCE_MAP_INLINE' => 'Inline',
          'SOURCE_MAP_FILE' => 'File'
        ]
      ]);

      echo $fields->select([
        'row' => false,
        'label' => true,
        'label_value' => 'Error Display',
        'name' => 'scss_compiler[error_display]',
        'class' => '',
        'value' => $error_display,
        'options' => [
          'show' => 'Show in Header',
          'show-logged-in' => 'Show to Logged In Users',
          'hide' => 'Print to Log',
        ]
      ]);
      ?>
    </div>
  </div>
  <!-- END: Row Box -->

  <!-- BEGIN: Row Box -->
  <?php
  echo $fields->input_field([
    'row_title' => 'Disabled auto enqueue',
    'helper_value' => 'but you can still enqueue with handle name without css such "filename-one-style, also you need to change wp_enqueue_scripts priority not less than 12. For starter theme child change priority of "ai_starter_theme_enqueue_child_assets" from 11 to 13',
    'name' => 'scss_compiler[disabled_auto_enqueue]',
    'options' => [
      'yes' => 'disabled'
    ],
    'value' => $disabled_auto_enqueue,
    'type' => 'checkbox',
    'is_single' => true
  ]);
  ?>
  <!-- END: Row Box -->

  <div class="wpui-row wpui-row-submit">
    <div class="wpui-col-md-12">
      <div class="form-group">
        <input type="submit" class="save-option-ajax wpui-secondary-button text-uppercase" value="Save Changes">
      </div>
    </div>
  </div>
<?php else:?>
  <!-- BEGIN: Row Box -->
  <div class="wpui-row wpui-row-box">
    <div class="wpui-col-md-12">
      <p><span class="wpui-settings-title">
                SCSS Module is not running.
            </span></p>
    </div>
  </div>
  <!-- END: Row Box -->
<?php endif;?>
