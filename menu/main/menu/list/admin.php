<?php
class Menu_Main_Menu_List_Admin extends Page_Renderable {
  function __construct($menus) {
    $this->menus = $menus;
    $menubars = Menu_MenuBar::getAll();
    $this->menubars = array();
    foreach ($menubars as $menubar) {
      $this->menubars[$menubar->id] = $menubar;
    }
  }

  function render($theme, $page) {
      $menuPage = Page::forModule("menu");
      $menus = array();
      foreach ($this->menus as $menu) {
        $menus[] = array(
          'menu_bar' => $this->menubars[$menu->menu_bar]->title,
          'title' => $menu->title,
          'editUrl' => Site::getPageUrl($menuPage,"menu/item/".$menu->id."/edit"),
          'deleteUrl' => Site::getPageUrl($menuPage,"menu/item/".$menu->id."/delete")
        );
      }
      $templateClass = $theme->getTemplate("Menu_Main_Menu_List_Admin");
      $template = new $templateClass(array(
        'menus' => $menus,
        'viewUrl' =>  Site::getPageUrl($menuPage,"menu/list/view"),
        'newUrl' =>  Site::getPageUrl($menuPage,"menu/item/new")
      ));
      return $template;
  }
}
