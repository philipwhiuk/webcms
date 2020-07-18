<?php
class Facebook_Hook_Content implements Hook {
  function __construct($content) {
    $this->content = $content;
  }
  function render($theme, $page) {
      $url = Site::getFullPageUrl(Page::forModule('content'),'item/'.$this->content->id.'/view');
      $encodedUrl = Site::getFullPageEncodedUrl(Page::forModule('content'),'item/'.$this->content->id.'/view');
      $templateClass = $theme->getTemplate("Facebook_Hook_Content");
      $template = new $templateClass(array(
        'website' => Site::getTitle(),
        'title' => $this->content->title,
        'appId' => Facebook_Module::getAppID(),
        'language' => 'en_GB',
        'url' => $url,
        'encodedUrl' => $encodedUrl
      ), $page);
      return $template;
  }
}
