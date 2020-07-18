<?php
class Content_Module extends Module {

  static $itemViewTypes = array('view','edit','delete');
  static $listViewTypes = array('view','admin');
  static $itemRequestTypes = array('get','update');
  static $hooks = array();

  static function registerHook($module,$type) {
    self::$hooks[$type][$module->name] = $module;
  }

  static function getHooks($type) {
    return self::$hooks[$type];
  }
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
     throw new Exception("CONTENT_RESOLVE_FAILED_BAD_VIEW_METHOD");
   }

  function getPermissionOptions($resolvedRequest) {
    return Module::getBasePermissionOptions('content', array('item'), array('list'), $resolvedRequest);
  }

  function getMain($resolvedRequest) {
    $actionPath = explode("/", $resolvedRequest);

    if ($actionPath[0] == "item") {
      if ($actionPath[1] == "new") {
        $viewClass = "Content_Main_Item_New";
        return new $viewClass();
      } else {
        $item = Content_Content::getById($actionPath[1]); //TODO: Probably belongs in controller
        $viewType = $actionPath[2];
        if (in_array($viewType, self::$itemViewTypes)) {
          $viewClass = "Content_Main_Item_".$viewType;
        } else {
          $viewClass = "Content_Main_Item_".self::$itemViewTypes[0];
        }
        return new $viewClass($item);
      }
    } elseif ($actionPath[0] == "list") {
      $items = Content_Content::getAllByTitle(); //TODO: Probably belongs in controller
      $viewType = $actionPath[1];
      if (in_array($viewType, self::$listViewTypes)) {
        $viewClass = "Content_Main_List_".$viewType;
      } else {
        $viewClass = "Content_Main_List_".self::$listViewTypes[0];
      }
      return new $viewClass($items);
    } else {
      throw new BadRouteException();
    }
  }

  function getBlock($action) {
    $actionPath = explode("/", $action);

    if ($actionPath[0] == "item") {
      $item = Content_Content::getById($actionPath[1]); //TODO: Probably belongs in controller
      $viewType = $actionPath[2];
      if (in_array($viewType, self::$itemViewTypes)) {
        $viewClass = "Content_Block_Item_".$viewType;
      } else {
        $viewClass = "Content_Block_Item_".self::$itemViewTypes[0];
      }
      return new $viewClass($item);
    } elseif ($actionPath[0] == "list") {
      $items = Content_Content::getAllByTitle(); //TODO: Probably belongs in controller
      $viewType = $actionPath[1];
      if (in_array($viewType, self::$listViewTypes)) {
        $viewClass = "Content_Block_List_".$viewType."_Block";
      } else {
        $viewClass = "Content_Block_List_".self::$listViewTypes[0];
      }
      return new $viewClass($items);
    } else {
      throw new Exception("CONTENT_BLOCK_CONTROLLER_FETCH_FAILURE");
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
        $requestHandlerClass = "Content_API_Item_Create";
        return new $requestHandlerClass();
      } else {
        $item = Content_Content::getById($requestPath[1]); //TODO: Probably belongs in controller
        $requestType = $requestPath[2];
        if (in_array($requestType, self::$itemRequestTypes)) {
          $requestHandlerClass = "Content_API_Item_".$requestType;
        } else {
          $requestHandlerClass = "Content_API_Item_".self::$itemRequestTypes[0];
        }
        return new $requestHandlerClass($item);
      }
    } else {
      throw new Exception("CONTENT_BAD_REQUEST_TYPE");
    }
  }
}
