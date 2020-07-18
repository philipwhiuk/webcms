  <?php
class Menu_Main_Menu_List_View extends Page_Renderable {
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
          'title' => $menu->title
        );
      }
      $templateClass = $theme->getTemplate("Menu_Main_Menu_List_View");
      $template = new $templateClass(array(
        'menus' => $menus,
        'adminUrl' => Site::getPageUrl($menuPage,"menu/list/admin")
      ));
      return $template;
  }
}
