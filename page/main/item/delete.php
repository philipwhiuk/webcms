<?php
class Page_Main_Item_Delete extends Page_Renderable {
    function __construct(page) {
      $this->page = $page;
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("Page_Main_Item_Delete");
        $template = new $templateClass(array(
          'id' => $this->page->id,
          'title' => $this->page->title,
          'apiDeleteUrl' => Site::getApiUrl("page","item/".$this->page->id."/delete")
        ));
        return $template;
    }
}
