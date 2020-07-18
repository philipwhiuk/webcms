<?php
class News_Module extends Module {

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
     } elseif ($actionPath[0] == 'list') {
       return $actionPath[0].'/'.$request;
     }
     throw new Exception('NEWS_RESOLVE_FAILED_BAD_VIEW_METHOD');
   }

  function getPermissionOptions($resolvedRequest) {
    return Module::getBasePermissionOptions('news', array('item'), array('list'), $resolvedRequest);
  }

  function getMain($resolvedRequest) {
    $actionPath = explode('/', $resolvedRequest);

    if ($actionPath[0] == 'item') {
      if ($actionPath[1] == 'new') {
        $viewClass = 'News_Main_Item_New';
        return new $viewClass();
      } else {
        $item = News_News::getById((int) $actionPath[1]); //TODO: Probably belongs in controller
        $viewType = $actionPath[2];
        if (in_array($viewType, self::$itemViewTypes)) {
          $viewClass = 'News_Main_Item_'.$viewType;
        } else {
          $viewClass = 'News_Main_Item_'.self::$itemViewTypes[0];
        }
        return new $viewClass($item);
      }
    } elseif ($actionPath[0] == 'list') {
      $items = News_News::getAllByTitle(); //TODO: Probably belongs in controller
      $viewType = $actionPath[1];
      if (in_array($viewType, self::$listViewTypes)) {
        $viewClass = 'News_Main_List_'.$viewType;
      } else {
        $viewClass = 'News_Main_List_'.self::$listViewTypes[0];
      }
      return new $viewClass($items);
    } else {
      throw new BadRouteException();
    }
  }

  function getBlock($action) {
    $actionPath = explode('/', $action);

    if ($actionPath[0] == 'item') {
      $item = News_News::getById($actionPath[1]); //TODO: Probably belongs in controller
      $viewType = $actionPath[2];
      if (in_array($viewType, self::$itemViewTypes)) {
        $viewClass = 'News_Block_Item_'.$viewType;
      } else {
        $viewClass = 'News_Block_Item_'.self::$itemViewTypes[0];
      }
      return new $viewClass($item);
    } elseif ($actionPath[0] == 'latest') {
      $items = News_News::getLatest($actionPath[1]); //TODO: Probably belongs in controller
      $viewType = $actionPath[2];
      if (in_array($viewType, self::$listViewTypes)) {
        $viewClass = 'News_Block_Latest_'.$viewType;
      } else {
        $viewClass = 'News_Block_Latest_'.self::$listViewTypes[0];
      }
      return new $viewClass($items);
    } elseif ($actionPath[0] == 'list') {
      $items = News_News::getAllByTitle(); //TODO: Probably belongs in controller
      $viewType = $actionPath[1];
      if (in_array($viewType, self::$listViewTypes)) {
        $viewClass = 'News_Block_List_'.$viewType.'_Block';
      } else {
        $viewClass = 'News_Block_List_'.self::$listViewTypes[0];
      }
      return new $viewClass($items);
    } else {
      throw new Exception('NEWS_BLOCK_CONTROLLER_FETCH_FAILURE');
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
        $requestHandlerClass = 'News_API_Item_Create';
        return new $requestHandlerClass();
      } else {
        $item = News_News::getById($requestPath[1]); //TODO: Probably belongs in controller
        $requestType = $requestPath[2];
        if (in_array($requestType, self::$itemRequestTypes)) {
          $requestHandlerClass = 'News_API_Item_'.$requestType;
        } else {
          $requestHandlerClass = 'News_API_Item_'.self::$itemRequestTypes[0];
        }
        return new $requestHandlerClass($item);
      }
    } else {
      throw new Exception('NEWS_BAD_REQUEST_TYPE');
    }
  }
}
