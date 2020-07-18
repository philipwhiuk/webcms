<?php
class Theme_Main_List_View {
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
      $templateClass = $theme->getTemplate("Theme_Main_List_View");
      $template = new $templateClass(array(
        'items' => $items,
        'adminUrl' => Site::getPageUrl(Page::forModule("theme"),"list/admin")
      ));
      return $template;
  }
}
