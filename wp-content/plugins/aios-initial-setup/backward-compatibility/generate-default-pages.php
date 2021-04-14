<?php

use AiosInitialSetup\Config\Generate;

class aios_initial_setup_generate_default_pages
{
  use Generate;

  public function generate_default_pages($id)
  {
    $this->generateDefaultPages($id);
  }
}
