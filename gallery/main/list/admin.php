<?php
class Gallery_Main_List_Admin extends Page_Renderable {
  function __construct($gallerys) {
    $this->gallerys = $gallerys;
  }

  function render($theme, $page) {
      $gallerys = array();
      foreach ($this->gallerys as $gallery) {
        $gallerys[] = array(
          'title' => $gallery->title,
          'viewUrl' => Site::getPageUrl(Page::forModule("gallery"),"gallery/".$gallery->id."/view"),
          'editUrl' => Site::getPageUrl(Page::forModule("gallery"),"gallery/".$gallery->id."/edit"),
          'deleteUrl' => Site::getPageUrl(Page::forModule("gallery"),"gallery/".$gallery->id."/delete")
        );
      }
      $templateClass = $theme->getTemplate("Gallery_Main_List_Admin");
      $template = new $templateClass(array(
        'gallerys' => $gallerys,
        'viewUrl' =>  Site::getPageUrl(Page::forModule("gallery"),"list/view"),
        'newUrl' =>  Site::getPageUrl(Page::forModule("gallery"),"item/new")
      ));
      return $template;
  }
}
