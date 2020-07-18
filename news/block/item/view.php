<?php
class News_Block_Item_View extends Page_Renderable {
    function __construct($news) {
      $this->news = $news;
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("News_Block_Item_View");
        $template = new $templateClass(array('title' => $this->news->title, 'intro' => $this->news->intro));
        return $template;
    }
}
