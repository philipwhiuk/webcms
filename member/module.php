<?php
class Member_Module extends Module {
  function __construct() {
    Content_Formatter::registerMacro("MEMBER_COUNT","number",Member_Member::getCount());
    Content_Formatter::registerMacro("MEMBER_WOMEN_PERCENTAGE","number",Member_Member::getPercentageWomen());
  }

  function resolveMainRequest($action, $request) {
    if ($request == '') {
      return $action;
    } else if ($action == '') {
      return $request;
    }
  }

  function getPermissionOptions($resolvedRequest) {
    $options = array('*');
    $root = Page::forModule('member')->path;
    $actionPath = explode('/', $resolvedRequest);
    if ($actionPath[0] == 'self') {
      $options[] = $root.'self/*';
      $options[] = $root.'self/'.$actionPath[1];
    } elseif ($actionPath[0] == 'person') {
      $options[] = $root.'person/*';
      $options[] = $root.'person/'.$actionPath[1].'/*';
      $options[] = $root.'person/'.$actionPath[1].'/'.$actionPath[2];
    } elseif ($actionPath[0] == 'emails') {
      $options[] = $root.'emails/*';
      $options[] = $root.'emails/'.$actionPath[1].'/*';
      $options[] = $root.'emails/'.$actionPath[1].'/'.$actionPath[2];
    } elseif ($actionPath[0] == 'membership') {
      $options[] = $root.'membership/*';
      $options[] = $root.'membership/'.$actionPath[1].'/*';
      $options[] = $root.'membership/'.$actionPath[1].'/'.$actionPath[2];
    } elseif ($actionPath[0] == 'cardrequest') {
      $options[] = $root.'cardrequest/*';
      $options[] = $root.'cardrequest/'.$actionPath[1];
    }
    return $options;
  }

  function getMain($resolvedRequest) {
    $actionPath = explode('/', $resolvedRequest);
     if ($actionPath[0] == 'self') {
       if ($actionPath[1] == "view") {
         return new Member_Main_Self_View(Site::getUser());
       } elseif ($actionPath[1] == "view") {
         return new Member_Main_Self_Edit(Site::getUser());
       }
     } elseif ($actionPath[0] == 'person') {
       if ($actionPath[2] == "view") {
         return new Member_Main_Person_View(User_User::getById($actionPath[1]));
       } elseif ($actionPath[1] == "view") {
         return new Member_Main_Person_Edit(User_User::getById($actionPath[1]));
       }
     }
     throw new Exception("MEMBER_RESOLVE_FAILED_BAD_VIEW_METHOD");
   }
}
