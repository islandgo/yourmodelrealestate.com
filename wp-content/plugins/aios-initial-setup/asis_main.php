<?php
/**
 * Plugin Name: AIOS Initial Setup
 * Description: Initial Setup for Agent Image Open Source Website.
 * Version: 5.4.8
 * Author: Agent Image
 * Author URI: https://www.agentimage.com/
 * License: Proprietary
 */

namespace AiosInitialSetup;

// Define Var
if(! defined('WPCF7_AUTOP')) define('WPCF7_AUTOP', false);
if(! defined('AIOS_LEADS_NAME')) define('AIOS_LEADS_NAME', 'aios_leads');
if(! defined('AIOS_LEADS_VERSION')) define('AIOS_LEADS_VERSION', '1.0.4');

// Define paths
if(! defined('AIOS_INITIAL_SETUP_VERSION')) define('AIOS_INITIAL_SETUP_VERSION', '5.2.1');
if(! defined('AIOS_INITIAL_SETUP_URL')) define('AIOS_INITIAL_SETUP_URL', plugin_dir_url( __FILE__ ));
if(! defined('AIOS_INITIAL_SETUP_RESOURCES')) define('AIOS_INITIAL_SETUP_RESOURCES', AIOS_INITIAL_SETUP_URL . 'resources/');
if(! defined('AIOS_INITIAL_SETUP_DIR')) define('AIOS_INITIAL_SETUP_DIR', realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR);
if(! defined('AIOS_INITIAL_SETUP_MODULES')) define('AIOS_INITIAL_SETUP_MODULES', AIOS_INITIAL_SETUP_DIR . 'app' . DIRECTORY_SEPARATOR . 'modules');
if(! defined('AIOS_INITIAL_SETUP_VIEWS')) define('AIOS_INITIAL_SETUP_VIEWS', AIOS_INITIAL_SETUP_DIR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);

require 'FileLoader.php';

$fileLoader = new FileLoader();
$fileLoader->load_files([
  'vendor/autoload',
  'config/Config',
  'config/Forms',
  'config/Modules',
  'config/Generate',
]);
$fileLoader->load_directory('helpers/functions');
$fileLoader->load_directory('helpers/traits');
$fileLoader->load_directory('helpers/classes');
$fileLoader->load_directory('database');
$fileLoader->load_directory('backward-compatibility');
$fileLoader->load_files([
  'app/App',
  'app/InitialSetup',
  'app/SiteInfo',
]);

// Load App
$app = new App\App(__FILE__);

// Load Controllers
$fileLoader->load_directory('app/controllers');

// Load Module
$fileLoader->load_files(['ModulesLoader']);

// Load Widgets if aios all widgets is not active
if (function_exists('is_plugin_active')) {
  if (! is_plugin_active('aios-all-widgets/taw_main.php.php')) {
    $fileLoader->load_files(['app/widgets/Helpers', 'app/widgets/Controller']);
    $fileLoader->load_file_in_directories('app' . DIRECTORY_SEPARATOR . 'widgets', 'widget.php');
  } else {
    $fileLoader->load_files(['app/widgets/Notifications']);
  }
}
