<?php
class Menu_Module extends Module {

  static $objectTypes = array('menubar','menu','menuitem');
  static $displayObjectTypes = array('list');
  static $menuBarViewTypes = array('view','edit');
  static $itemViewTypes = array('view','edit');
  static $listViewTypes = array('view','admin');
  static $itemRequestTypes = array('get','update');

  /**
   * Sample paths:
   * menubar/item/1/view
   * menubar/list/view
   */
  function resolveMainRequest($action, $request) {
    if ($request == "") {
      return $action;
    } else if ($action == "") {
      return $request;
    }
    $actionPath = explode("/", $action);
    if (in_array(self::$objectTypes,$actionPath[0])) {
      if ($actionPath[1] == 'item') {
        if ($actionPath[2] != 'new') {
          return $actionPath[0].'/item/'.$actionPath[2].'/'.$request;
        } else {
          return $action.'/'.$actionPath[1].'/new';
        }
      } else {
        return $actionPath[0].'/list/'.$request;
      }
    }
    throw new Exception("MENU_RESOLVE_FAILED_BAD_VIEW_METHOD");
  }

  function getPermissionOptions($resolvedRequest) {
    $root = Page::forModule('event')->path;
    $options = array('*',$root.'/*');
    $actionPath = explode('/', $resolvedRequest);
    foreach (self::$objectTypes as $objectType) {
      if ($actionPath[0] == $objectType) {
        $options[] = $root.'/'.$objectType.'/*';
        if ($actionPath[1] == 'item') {
          $options[] = $root.'/'.$objectType.'/item/*/'.$actionPath[2];
          if ($actionPath[2] != 'new') {
            $options[] = $root.'/'.$objectType.'/item/*/'.$actionPath[3];
            $options[] = $root.'/'.$objectType.'/item/'.$actionPath[2].'/'.$actionPath[3];
          } else {
            $options[] = $root.'/'.$objectType.'/new';
          }
        } else {
          foreach (self::$displayObjectTypes as $displayObjectType) {
            if ($actionPath[1] == $displayObjectType) {
              $options[] = $root.'/'.$objectType.'/'.$displayObjectType.'/*';
              $options[] = $root.'/'.$objectType.'/'.$displayObjectType.'/'.$actionPath[1];
            }
          }
        }
        return $options;
      }
    }
  }

  function getMain($resolvedRequest) {
    $actionPath = explode("/", $resolvedRequest);
    switch ($actionPath[0]) {
      case 'menu':
      case 'menubar':
      case 'menuitem':
        return $this->getMainForObjectType($actionPath[0], $actionPath);
      default:
        throw new BadRouteException("Unknown request $resolvedRequest");
    }
  }

  function getMainForObjectType($objectType, $actionPath) {
    if ($actionPath[1] == 'item') {
      if ($actionPath[2] == 'new') {
        $viewClass = 'Menu_Main_'.$objectType.'_Item_New';
        return new $viewClass();
      }
      $objectClass = 'Menu_'.$objectType;
      $item = $objectClass::getById($actionPath[2]); //TODO: Probably belongs in controller
      $viewType = $actionPath[3];
      if (in_array($viewType, self::$itemViewTypes)) {
        $viewClass = 'Menu_Main_'.$objectType.'_Item_'.$viewType;
      } else {
        $viewClass = 'Menu_Main_'.$objectType.'_Item_'.self::$itemViewTypes[0];
      }
      return new $viewClass($item);
    } else if ($actionPath[1] == 'list') {
      $objectClass = 'Menu_'.$objectType;
      $items = $objectClass::getAll();
      $viewType = $actionPath[2];
      if (in_array($viewType, self::$listViewTypes)) {
        $viewClass = 'Menu_Main_'.$objectType.'_List_'.$viewType;
      } else {
        $viewClass = 'Menu_Main_'.$objectType.'_List_'.self::$listViewTypes[0];
      }
      return new $viewClass($items);
    }
  }

  /**
   * Sample paths:
   * menu/1/view
   */
  function getBlock($action, $page) {
    $actionPath = explode("/", $action);

    if ($actionPath[0] == "menubar") {
      $menu = Menu_MenuBar::getById($actionPath[1]); //TODO: Probably belongs in controller
      $viewType = $actionPath[2];
      if (in_array($viewType, self::$menuBarViewTypes)) {
        $viewClass = "Menu_Block_MenuBar_".$viewType;
      } else {
        $viewClass = "Menu_Block_MenuBar_".self::$menuBarViewTypes[0];
      }
      if (!empty($actionPath[3])) {
        $block = new $viewClass($menu, $actionPath[3]);
      } else {
        $block = new $viewClass($menu);
      }
      $block->load($page);
      return $block;
    } elseif ($actionPath[0] == "menu") {
      $menu = Menu_Menu::getById($actionPath[1]); //TODO: Probably belongs in controller
      $viewType = $actionPath[2];
      if (in_array($viewType, self::$menuViewTypes)) {
        $viewClass = "Menu_Block_Menu_".$viewType;
      } else {
        $viewClass = "Menu_Block_Menu_".self::$menuViewTypes[0];
      }
      return new $viewClass($menu);
    } else {
      throw new Exception("MENU_RESOLVE_FAILED_BAD_BLOCK_VIEW_METHOD");
    }
  }

  function getRequestHandler($request) {
    $requestPath = explode('/', $request);
    if (in_array($requestPath[0], self::$objectTypes)) {
      if ($requestPath[1] == 'item') {
        if ($requestPath[2] == 'create') {
          $requestHandlerClass = 'Menu_API_'.$requestPath[0].'_Item_Create';
          return new $requestHandlerClass();
        }
        $class = 'Menu_'.$requestPath[0];
        $item = $class::getById((int) $requestPath[2]); //TODO: Probably belongs in controller
        $requestType = $requestPath[3];
        if (in_array($requestType, self::$itemRequestTypes)) {
          $requestHandlerClass = 'Menu_API_'.$requestPath[0].'_Item_'.$requestType;
        } else {
          $requestHandlerClass = 'Menu_API_'.$requestPath[0].'_Item_'.self::$itemRequestTypes[0];
        }
        return new $requestHandlerClass($item);
      }
    }
    throw new Exception('MENU_BAD_REQUEST_TYPE');
  }
}
