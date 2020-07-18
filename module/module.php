<?php
class Module_Module extends Module {

  static $listViewTypes = array('view','admin');

  function resolveMainRequest($action, $request) {
     if ($request == "") {
       return $action;
     } else if ($action == "") {
       return $request;
     }
     $actionPath = explode("/", $action);
     if ($actionPath[0] == 'list') {
       return $actionPath[0].'/'.$request;
     }
     throw new Exception("MODULE_RESOLVE_FAILED_BAD_VIEW_METHOD");
   }

  function getPermissionOptions($resolvedRequest) {
    return Module::getBasePermissionOptions('content', array('item'), array('list'), $resolvedRequest);
  }

  function getMain($resolvedRequest) {
    $actionPath = explode("/", $resolvedRequest);

    if ($actionPath[0] == "list") {
      $items = Module::getAllByName(); //TODO: Probably belongs in controller
      $viewType = $actionPath[1];
      if (in_array($viewType, self::$listViewTypes)) {
        $viewClass = "Module_Main_List_".$viewType;
      } else {
        $viewClass = "Module_Main_List_".self::$listViewTypes[0];
      }
      return new $viewClass($items);
    } else {
      throw new BadRouteException();
    }
  }

}
