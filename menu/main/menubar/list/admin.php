<?php
class Menu_Main_MenuBar_List_Admin extends Page_Renderable {
  function __construct($menus) {
    $this->menus = $menus;
  }

  function render($theme, $page) {
      $menuPage = Page::forModule("menu");
      $menus = array();
      foreach ($this->menus as $menu) {
        $menus[] = array(
          'title' => $menu->title,
          'editUrl' => Site::getPageUrl($menuPage,"menubar/item/".$menu->id."/edit"),
          'deleteUrl' => Site::getPageUrl($menuPage,"menubar/item/".$menu->id."/delete")
        );
      }
      $templateClass = $theme->getTemplate("Menu_Main_MenuBar_List_Admin");
      $template = new $templateClass(array(
        'menus' => $menus,
        'viewUrl' =>  Site::getPageUrl($menuPage,"menubar/list/view"),
        'newUrl' =>  Site::getPageUrl($menuPage,"menubar/item/new")
      ));
      return $template;
  }
}
