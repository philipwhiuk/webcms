<?php
class Gallery_Module extends Module {

  static $itemViewTypes = array('view','edit','delete');
  static $listViewTypes = array('view','admin');
  static $itemRequestTypes = array('get','update');
  /**
   * Sample paths:
   * item/1/view
   * list/view
   */
  function resolveMainRequest($action, $request) {
     if ($request == '') {
       return $action;
     } else if ($action == '') {
       return $request;
     }
     $actionPath = explode('/', $action);
     if ($actionPath[0] == 'item') {
       if ($actionPath[1] != 'new') {
         return $actionPath[0].'/'.$actionPath[1].'/'.$request;
       } else {
         return $action.'/'.$request;
       }
     } elseif ($actionPath[0] == 'gallery') {
       if ($actionPath[1] != 'new') {
         return $actionPath[0].'/'.$actionPath[1].'/'.$request;
       } else {
         return $action.'/'.$request;
       }
     } elseif ($actionPath[0] == 'list') {
       return $actionPath[0].'/'.$request;
     }
     throw new Exception('GALLERY_RESOLVE_FAILED_BAD_VIEW_METHOD');
   }

  function getPermissionOptions($resolvedRequest) {
    return Module::getBasePermissionOptions('gallery', array('item','gallery'), array('list'), $resolvedRequest);
  }

  function getMain($resolvedRequest) {
    $actionPath = explode('/', $resolvedRequest);

    if ($actionPath[0] == 'item') {
      if ($actionPath[1] == 'new') {
        $viewClass = 'Gallery_Main_Item_New';
        return new $viewClass();
      } else {
        $item = Gallery_Item::getById((int) $actionPath[1]); //TODO: Probably belongs in controller
        $viewType = $actionPath[2];
        if (in_array($viewType, self::$itemViewTypes)) {
          $viewClass = 'Gallery_Main_Item_'.$viewType;
        } else {
          $viewClass = 'Gallery_Main_Item_'.self::$itemViewTypes[0];
        }
        return new $viewClass($item);
      }
    } elseif ($actionPath[0] == 'gallery') {
      if ($actionPath[1] == 'new') {
        $viewClass = 'Gallery_Main_Gallery_New';
        return new $viewClass();
      } else {
        $item = Gallery_Gallery::getById((int) $actionPath[1]); //TODO: Probably belongs in controller
        $viewType = $actionPath[2];
        if (in_array($viewType, self::$itemViewTypes)) {
          $viewClass = 'Gallery_Main_Gallery_'.$viewType;
        } else {
          $viewClass = 'Gallery_Main_Gallery_'.self::$itemViewTypes[0];
        }
        return new $viewClass($item);
      }
    } elseif ($actionPath[0] == 'list') {
      $items = Gallery_Gallery::getAll(); //TODO: Probably belongs in controller
      $viewType = $actionPath[1];
      if (in_array($viewType, self::$listViewTypes)) {
        $viewClass = 'Gallery_Main_List_'.$viewType;
      } else {
        $viewClass = 'Gallery_Main_List_'.self::$listViewTypes[0];
      }
      return new $viewClass($items);
    } else {
      throw new BadRouteException();
    }
  }

  function getBlock($action) {
    $actionPath = explode('/', $action);

    if ($actionPath[0] == 'item') {
      $item = Gallery_Item::getById($actionPath[1]); //TODO: Probably belongs in controller
      $viewType = $actionPath[2];
      if (in_array($viewType, self::$itemViewTypes)) {
        $viewClass = 'Gallery_Block_Item_'.$viewType;
      } else {
        $viewClass = 'Gallery_Block_Item_'.self::$itemViewTypes[0];
      }
      return new $viewClass($item);
    } elseif ($actionPath[0] == 'gallery') {
      $items = Gallery_Gallery::getById($actionPath[1]); //TODO: Probably belongs in controller
      $viewType = $actionPath[2];
      if (in_array($viewType, self::$listViewTypes)) {
        $viewClass = 'Gallery_Block_Gallery_'.$viewType;
      } else {
        $viewClass = 'Gallery_Block_Gallery_'.self::$itemViewTypes[0];
      }
      return new $viewClass($items);
    } elseif ($actionPath[0] == 'list') {
      $items = Gallery_Gallery::getAllByTitle(); //TODO: Probably belongs in controller
      $viewType = $actionPath[1];
      if (in_array($viewType, self::$listViewTypes)) {
        $viewClass = 'Gallery_Block_List_'.$viewType.'_Block';
      } else {
        $viewClass = 'Gallery_Block_List_'.self::$listViewTypes[0];
      }
      return new $viewClass($items);
    } else {
      throw new Exception('GALLERY_BLOCK_CONTROLLER_FETCH_FAILURE');
    }
  }

  /**
   * Sample paths:
   * item/1/update
   */
  function getRequestHandler($request) {
    $requestPath = explode('/', $request);
    if ($requestPath[0] == 'item') {
      if ($requestPath[1] == 'create') {
        $requestHandlerClass = 'Gallery_API_Item_Create';
        return new $requestHandlerClass();
      } else {
        $item = Gallery_Item::getById($requestPath[1]); //TODO: Probably belongs in controller
        $requestType = $requestPath[2];
        if (in_array($requestType, self::$itemRequestTypes)) {
          $requestHandlerClass = 'Gallery_API_Item_'.$requestType;
        } else {
          $requestHandlerClass = 'Gallery_API_Item_'.self::$itemRequestTypes[0];
        }
        return new $requestHandlerClass($item);
      }
    } elseif ($requestPath[0] == 'gallery') {
      if ($requestPath[1] == 'create') {
        $requestHandlerClass = 'Gallery_API_Gallery_Create';
        return new $requestHandlerClass();
      } else {
        $item = Gallery_Gallery::getById($requestPath[1]); //TODO: Probably belongs in controller
        $requestType = $requestPath[2];
        if (in_array($requestType, self::$itemRequestTypes)) {
          $requestHandlerClass = 'Gallery_API_Gallery_'.$requestType;
        } else {
          $requestHandlerClass = 'Gallery_API_Gallery_'.self::$itemRequestTypes[0];
        }
        return new $requestHandlerClass($item);
      }
    } else {
      throw new Exception('GALLERY_BAD_REQUEST_TYPE');
    }
  }
}
