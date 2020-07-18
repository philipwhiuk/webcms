<?php
class Menu_Main_MenuItem_List_Admin extends Page_Renderable {
  function __construct($menuItems) {
    $this->menuItems = $menuItems;

    $menus = Menu_Menu::getAll();
    $this->menus = array();
    foreach ($menus as $menu) {
      $this->menus[$menu->id] = $menu;
    }

    $menubars = Menu_MenuBar::getAll();
    $this->menubars = array();
    foreach ($menubars as $menubar) {
      $this->menubars[$menubar->id] = $menubar;
    }
  }

  function render($theme, $page) {
      $menuPage = Page::forModule("menu");
      $menuItems = array();
      foreach ($this->menuItems as $menuItem) {
        $menu = $this->menus[$menuItem->menu];
        $menuItems[] = array(
          'menu_bar' => $this->menubars[$menu->menu_bar]->title,
          'menu' => $menu->title,
          'title' => $menuItem->title,
          'editUrl' => Site::getPageUrl($menuPage,"menuitem/item/".$menuItem->id."/edit"),
          'deleteUrl' => Site::getPageUrl($menuPage,"menuitem/item/".$menuItem->id."/delete")
        );
      }
      $templateClass = $theme->getTemplate("Menu_Main_MenuItem_List_Admin");
      $template = new $templateClass(array(
        'menuItems' => $menuItems,
        'viewUrl' =>  Site::getPageUrl($menuPage,"menuitem/list/view"),
        'newUrl' =>  Site::getPageUrl($menuPage,"menuitem/item/new")
      ));
      return $template;
  }
}
