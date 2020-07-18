<?php
class Content_Main_Item_Delete extends Page_Renderable {
    function __construct($content) {
      $this->content = $content;
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("Content_Main_Item_Delete");
        $template = new $templateClass(array(
          'id' => $this->content->id,
          'title' => $this->content->title,
          'text' => $this->content->text,
          'showTitle' => $this->content->showTitle != 0,
          'apiDeleteUrl' => Site::getApiUrl("content","item/".$this->content->id."/delete"),
          'viewUrl' => Site::getPageUrl(Page::forModule("content"),"item/".$this->content->id."/view"),
          'editUrl' => Site::getPageUrl(Page::forModule("content"),"item/".$this->content->id."/edit")
        ));
        return $template;
    }
}
