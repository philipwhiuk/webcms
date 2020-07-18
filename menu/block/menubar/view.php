<?php
class Menu_Block_MenuBar_View extends Page_Renderable {
    function __construct($menubar, $position = 'main') {
      $this->menubar = $menubar;
      $this->position = $position;
    }

    function load($page) {
      $allMenus = Menu_Menu::getByMenuBar($this->menubar->id);
      $menus = array();
      foreach ($allMenus as $menu) {
        $active = false;
        $allMenuItemsForMenu = Menu_MenuItem::getByMenu($menu->id);
        $menuItems = array();
        foreach ($allMenuItemsForMenu as $menuItem) {
          $permissionOptions = Site::resolvePagePermissions($menuItem->path);
          if (Site::userHasPermission(Site::getUser(), $permissionOptions)) {
            if (Site::getPathRequest() == $menuItem->path || $page->path == $menuItem->path) {
              $active = true;
              $menuItem->active = true;
            }
            $menuItems[] = $menuItem;
          }
        }
        if (count($menuItems) > 0) {
          $menus[] = array(
            'active'=> $active,
            'menuInfo' => $menu,
            'items' => $menuItems
          );
        }
      }
      $this->menus = $menus;
    }
    function render($theme, $page) {
      if ($theme->hasTemplate("Menu_Block_MenuBar_{$this->position}_View")) {
        $templateClass = $theme->getTemplate("Menu_Block_MenuBar_{$this->position}_View");
      } else {
        $templateClass = $theme->getTemplate("Menu_Block_MenuBar_Main_View");
      }
      $template = new $templateClass(array(
        'title' => $this->menubar->title,
        'menus' => $this->menus
      ));
      return $template;
    }
}
