<?php
class Menu_Block_Menu_View extends Page_Renderable {
    function __construct($menu) {
      $this->menu = $menu;
      $allMenuItems = Menu_MenuItem::getByMenu($menu->id);
      $menuItems = array();
      foreach ($allMenuItems as $menuItem) {
        if (Site::userHasPermission(Site::getUser(), array($menuItem->path))) {
          $menuItems[] = $menuItem;
        }
      }
      $this->menuItems = $menuItems;
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("Menu_Block_Menu_View");
        $template = new $templateClass(array('title' => $this->menu->title, 'menuItems' => $this->menuItems));
        return $template;
    }
}
