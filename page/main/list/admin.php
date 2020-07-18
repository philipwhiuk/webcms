<?php
class Page_Main_List_Admin extends Page_Renderable {
  function __construct($pages) {
    $this->pages = $pages;
  }

  function render($theme, $page) {
      $pages = array();
      foreach ($this->pages as $page) {
        $pages[] = array(
          'title' => $page->title,
          'viewUrl' => Site::getPageUrl(Page::forModule("page"),"item/".$page->id."/view"),
          'editUrl' => Site::getPageUrl(Page::forModule("page"),"item/".$page->id."/edit"),
          'deleteUrl' => Site::getPageUrl(Page::forModule("page"),"item/".$page->id."/delete")
        );
      }
      $templateClass = $theme->getTemplate("Page_Main_List_Admin");
      $template = new $templateClass(array(
        'pages' => $pages,
        'viewUrl' =>  Site::getPageUrl(Page::forModule("page"),"list/view"),
        'newUrl' =>  Site::getPageUrl(Page::forModule("page"),"item/new")
      ));
      return $template;
  }
}
