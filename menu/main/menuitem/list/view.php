  <?php
class Menu_Main_MenuItem_List_View extends Page_Renderable {
  function __construct($menus) {
    $this->menus = $menus;
  }

  function render($theme, $page) {
      $menuPage = Page::forModule("menu");
      $menus = array();
      foreach ($this->menus as $menu) {
        $menus[] = array(
          'title' => $menu->title
        );
      }
      $templateClass = $theme->getTemplate("Menu_Main_List_View");
      $template = new $templateClass(array(
        'menus' => $menus,
        'adminUrl' => Site::getPageUrl($menuPage,"list/admin")
      ));
      return $template;
  }
}
