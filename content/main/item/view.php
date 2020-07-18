<?php
class Content_Main_Item_View extends Page_Renderable {
    function __construct($content) {
      $this->content = $content;
      $this->formattedText = Content_Formatter::format($this->content->text);
      $this->canEdit = Site::userHasPermission(
        Site::getUser(),
        Content_Module::getPermissionOptions('item/'.$this->content->id.'/edit'));
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("Content_Main_Item_View");
        //TODO: Control title visibility
        $shareHooks = array();
        foreach (Content_Module::getHooks('share') as $shareHook) {
          $shareHooks[] = $shareHook->onContentHookRender($this->content, $theme, $page);
        }
        $template = new $templateClass(array(
          'title' => $this->content->title,
          'text' => $this->formattedText,
          'showTitle' => $this->content->showTitle != 0,
          'canEdit' => $this->canEdit,
          'editUrl' => Site::getPageUrl(Page::forModule("content"),'item/'.$this->content->id."/edit"),
          'shareHooks' => $shareHooks
        ));
        return $template;
    }
}
