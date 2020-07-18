<?php
class Block_Main_Item_Delete extends Page_Renderable {
    function __construct($news) {
      $this->news = $news;
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate('News_Main_Item_Delete');
        $template = new $templateClass(array(
          'id' => $this->news->id,
          'title' => $this->news->title,
          'intro' => $this->news->intro,
          'body' => $this->news->body,
          'apiDeleteUrl' => Site::getApiUrl('news','item/'.$this->news->id.'/delete'),
          'viewUrl' => Site::getPageUrl(Page::forModule('news'),'item/'.$this->news->id.'/view'),
          'editUrl' => Site::getPageUrl(Page::forModule('news'),'item/'.$this->news->id.'/edit')
        ));
        return $template;
    }
}
