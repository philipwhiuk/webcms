<?php
class Site_Module extends Module {
  function resolveMainRequest($action, $request) {
    if ($request == "") {
      return $action;
    } else if ($action == "") {
      return $request;
    }
    throw new Exception("SITE_UNEXPECTED_RESOLUTION_REQUEST");
   }

  function getPermissionOptions($resolvedRequest) {
    $root = Page::forModule('site')->path;
    $actionPath = explode("/", $resolvedRequest);
    $options = array('*',$root.'/*',$root.'/'.$actionPath[0]);
    return $options;
  }

  function getMain($resolvedRequest) {
    return new Site_Main_Admin();
  }
}
