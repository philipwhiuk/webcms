<?php
class Facebook_Module extends Module {
  function __construct() {
    Content_Module::registerHook($this, 'share');
  }

  function onContentHookRender($content, $theme, $page) {
    $hook = new Facebook_Hook_Content($content);
    return $hook->render($theme, $page);
  }

  function getAppID() {
    return Site::getConfigProperty('facebook_appid');
  }
}
?>
