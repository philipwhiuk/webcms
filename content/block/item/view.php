<?php
class Content_Block_Item_View extends Page_Renderable {
    function __construct($content) {
      $this->content = $content;
      $this->formattedText = Content_Formatter::format($this->content->text);
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("Content_Block_Item_View");
        $template = new $templateClass(array('title' => $this->content->title, 'text' => $this->formattedText));
        return $template;
    }
}
