<?php
class Page_Main_Item_Edit extends Page_Renderable {
    function __construct($content) {
      $this->content = $content;
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("Page_Main_Item_Edit");
        $template = new $templateClass(array(
          'id' => $this->content->id,
          'title' => $this->content->title,
          'path' => $this->content->path,
          'module' => $this->content->module,
          'defaultAction' => $this->content->defaultAction,
          'apiUpdateUrl' => Site::getApiUrl("page","item/".$this->content->id."/update")
        ));
        return $template;
    }
}
