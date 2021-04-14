<?php

namespace AiosInitialSetup\App\Modules\SiteNavigationSchema;

class Module
{
  /**
   * Module constructor.
   */
  public function __construct()
  {
    add_action('wp_head', [$this, 'addSiteNavigationSchema']);
  }

  public function addSiteNavigationSchema()
  {
    $registeredMenus = get_registered_nav_menus();
    $menu_name = 'primary-menu';
    $locations = get_nav_menu_locations();

    if (isset($locations[$menu_name]) && in_array('Primary Menu', $registeredMenus)) {
      $menu = wp_get_nav_menu_object($locations[$menu_name]);
      $menuItems = wp_get_nav_menu_items($menu->term_id, ['order' => 'ASC', 'orderby' => 'menu']);
      $navDecode = json_decode(json_encode($menuItems), true);

      $navItems = [];
      foreach ($navDecode as $item_list) {
        $navItems[] = [
          '@type' => 'SiteNavigationElement',
          'name' => $item_list['title'],
          'url' => $item_list['url']
        ];
      }

      $arr_nav_schema = json_encode([
        '@context' => 'https://schema.org',
        '@graph' => [[$navItems]]
      ], JSON_PRETTY_PRINT);

      echo '<script type="application/ld+json">' . $arr_nav_schema . '</script>';
    }
  }
}

new Module();
