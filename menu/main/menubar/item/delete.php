<?php
class Menu_Main_MenuBar_Item_Delete extends Page_Renderable {
    function __construct($item) {
      $this->item = $item;
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("Menu_Main_MenuBar_Item_Delete");
        $template = new $templateClass(array(
          'id' => $this->item->id,
          'title' => $this->item->title,
          'apiDeleteUrl' => Site::getApiUrl("menu","menubar/item/".$this->item->id."/delete"),
          'viewUrl' => Site::getPageUrl(Page::forModule("menu"),"menubar/item/".$this->item->id."/view"),
          'editUrl' => Site::getPageUrl(Page::forModule("menu"),"menubar/item/".$this->item->id."/edit")
        ));
        return $template;
    }
}
