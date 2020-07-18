<?php
class Page_Module extends Module {

  static $itemViewTypes = array('view','edit','delete');
  static $listViewTypes = array('view','admin');
  static $itemRequestTypes = array('get','update');
  /**
   * Sample paths:
   * item/1/view
   * list/view
   */
  function resolveMainRequest($action, $request) {
    if ($request == "") {
      return $action;
    } else if ($action == "") {
      return $request;
    }
    $actionPath = explode("/", $action);
    if ($actionPath[0] == 'item') {
      if ($actionPath[1] != "new") {
        return $actionPath[0].'/'.$actionPath[1].'/'.$request;
      } else {
        return $action.'/'.$request;
      }
    } elseif ($actionPath[0] == 'list') {
      return $actionPath[0].'/'.$request;
    }
    throw new Exception("PAGE_RESOLVE_FAILED_BAD_VIEW_METHOD");
  }

  function getPermissionOptions($resolvedRequest) {
    return Module::getBasePermissionOptions('page', array('item'), array('list'), $resolvedRequest);
  }

  function getMain($resolvedRequest) {
    $actionPath = explode("/", $resolvedRequest);

    if ($actionPath[0] == "item") {
      if ($actionPath[1] == "new") {
        $viewClass = "Page_Main_Item_New";
        return new $viewClass();
      } else {
        $item = Page::getById($actionPath[1]); //TODO: Probably belongs in controller
        $viewType = $actionPath[2];
        if (in_array($viewType, self::$itemViewTypes)) {
          $viewClass = "Page_Main_Item_".$viewType;
        } else {
          $viewClass = "Page_Main_Item_".self::$itemViewTypes[0];
        }
        return new $viewClass($item);
      }
    } elseif ($actionPath[0] == "list") {
      $items = Page::getAllByTitle(); //TODO: Probably belongs in controller
      $viewType = $actionPath[1];
      if (in_array($viewType, self::$listViewTypes)) {
        $viewClass = "Page_Main_List_".$viewType;
      } else {
        $viewClass = "Page_Main_List_".self::$listViewTypes[0];
      }
      return new $viewClass($items);
    } else {
      throw new Exception("PAGE_BAD_VIEW_METHOD");
    }
  }

  /**
   * Sample paths:
   * item/1/update
   */
  function getRequestHandler($request) {
    $requestPath = explode("/", $request);
    if ($requestPath[0] == "item") {
      if ($requestPath[1] == "create") {
        $requestHandlerClass = "Page_API_Item_Create";
        return new $requestHandlerClass();
      } else {
        $item = Page::getById($requestPath[1]); //TODO: Probably belongs in controller
        $requestType = $requestPath[2];
        if (in_array($requestType, self::$itemRequestTypes)) {
          $requestHandlerClass = "Page_API_Item_".$requestType;
        } else {
          $requestHandlerClass = "Page_API_Item_".self::$itemRequestTypes[0];
        }
        return new $requestHandlerClass($item);
      }
    } else {
      throw new Exception("PAGE_BAD_REQUEST_TYPE");
    }
  }
}
