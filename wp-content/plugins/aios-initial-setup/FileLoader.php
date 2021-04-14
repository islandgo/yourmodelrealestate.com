<?php

namespace AiosInitialSetup;

class FileLoader
{
  /**
   * Loads all PHP files in a given directory.
   *
   * @param string $directory_name
   * @access public
   */
  public function load_directory($directory_name) {
    $path = trailingslashit(AIOS_INITIAL_SETUP_DIR . $directory_name);
    $file_names = glob($path . '*.php');
    foreach ($file_names as $filename) {
      if (file_exists($filename)) {
        require_once $filename;
      }
    }
  }

  /**
   * Loads specified PHP files from the plugin includes directory.
   *
   * @param array $file_names The names of the files to be loaded in the includes directory.
   * @access public
   */
  public function load_files($file_names = []) {
    foreach ($file_names as $file_name) {
      if (file_exists($path = AIOS_INITIAL_SETUP_DIR . $file_name . '.php')) {
        require_once $path;
      }
    }
  }

  /**
   * Load files inside directory
   *
   * @param $directory_name
   * @param $filename
   */
  public function load_file_in_directories($directory_name, $filename)
  {
    $directories = glob(AIOS_INITIAL_SETUP_DIR . $directory_name . DIRECTORY_SEPARATOR . '*');

    foreach ($directories as $directory) {
      if (strpos($directory, '.php') === false && file_exists($directory . DIRECTORY_SEPARATOR . $filename)) {
        require_once $directory . DIRECTORY_SEPARATOR . $filename;
      }
    }
  }
}
