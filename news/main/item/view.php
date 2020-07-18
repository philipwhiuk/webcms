<?php
class News_Main_Item_View extends Page_Renderable {
    function __construct($news) {
      $this->news = $news;
      $this->canEdit = Site::userHasPermission(
        Site::getUser(),
        News_Module::getPermissionOptions('item/'.$this->news->id.'/edit'));
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("News_Main_Item_View");
        //TODO: Control title visibility
        $template = new $templateClass(array(
          'title' => $this->news->title,
          'intro' => $this->news->intro,
          'body' => $this->news->body,
          'canEdit' => $this->canEdit,
          'editUrl' => Site::getPageUrl(Page::forModule("news"),'item/'.$this->news->id."/edit")
        ));
        return $template;
    }
}
