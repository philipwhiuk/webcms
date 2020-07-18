<?php
class Menu_Main_MenuBar_Item_Edit extends Page_Renderable {
    function __construct($item) {
      $this->item = $item;
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("Menu_Main_MenuBar_Item_Edit");
        $template = new $templateClass(array(
          'id' => $this->item->id,
          'title' => $this->item->title,
          'apiUpdateUrl' => Site::getApiUrl("menu","menubar/item/".$this->item->id."/update"),
          'viewUrl' => Site::getPageUrl(Page::forModule("menu"),"menubar/item/".$this->item->id."/view")
        ));
        return $template;
    }
}
