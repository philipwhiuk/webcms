<?php
class News_Main_List_Admin extends Page_Renderable {
  function __construct($items) {
    $this->items = $items;
  }

  function render($theme, $page) {
      $items = array();
      foreach ($this->items as $item) {
        $items[] = array(
          'title' => $item->title,
          'viewUrl' => Site::getPageUrl(Page::forModule("news"),"item/".$item->id."/view"),
          'editUrl' => Site::getPageUrl(Page::forModule("news"),"item/".$item->id."/edit"),
          'deleteUrl' => Site::getPageUrl(Page::forModule("news"),"item/".$item->id."/delete")
        );
      }
      $templateClass = $theme->getTemplate("News_Main_List_Admin");
      $template = new $templateClass(array(
        'items' => $items,
        'viewUrl' =>  Site::getPageUrl(Page::forModule("news"),"list/view"),
        'newUrl' =>  Site::getPageUrl(Page::forModule("news"),"item/new")
      ));
      return $template;
  }
}
