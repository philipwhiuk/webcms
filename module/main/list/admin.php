<?php
class Module_Main_List_Admin extends Page_Renderable {
  function __construct($items) {
    $this->items = $items;
  }

  function render($theme, $page) {
      $items = array();
      foreach ($this->items as $item) {
        $items[] = array(
          'name' => $item->name
        );
      }
      $templateClass = $theme->getTemplate("Module_Main_List_Admin");
      $template = new $templateClass(array(
        'items' => $items,
        'viewUrl' => Site::getPageUrl(Page::forModule("module"),"list/view")
      ));
      return $template;
  }
}
