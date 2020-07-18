<?php
class User_Module extends Module {
  static $objectTypes = array('user','role','group');
  static $itemViewTypes = array('view','edit','delete');
  static $listViewTypes = array('view','admin');
  static $itemRequestTypes = array('get','update','create','delete');
  static $otherViewTypes = array('login','logout');
  static $actions = array('login','logout','changepassword','sendresetemail','resetpassword');
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
    throw new Exception('USER_RESOLVE_FAILED_BAD_VIEW_METHOD');
  }

  function getPermissionOptions($resolvedRequest) {
    $root = Page::forModule('user')->path;
    $actionPath = explode('/', $resolvedRequest);
    if (in_array($actionPath[0], self::$objectTypes)) {
      return self::getObjectPermissions($resolvedRequest, $root);
    } else {
      return array($root.'/'.$resolvedRequest);
    }
  }

  function getObjectPermissions($resolvedRequest, $root) {
    $options = array('*',$root.'/*');
    $actionPath = explode('/', $resolvedRequest);
    foreach (self::$objectTypes as $objectType) {
      if ($actionPath[0] == $objectType) {
        $options[] = $root.'/'.$objectType.'/*';
        if ($actionPath[1] != 'new') {
          $options[] = $root.'/'.$objectType.'/*/'.$actionPath[2];
          $options[] = $root.'/'.$objectType.'/'.$actionPath[1].'/'.$actionPath[2];
        } else {
          $options[] = $root.'/'.$objectType.'/new';
        }
        return $options;
      }
    }
  }

  function getMain($resolvedRequest) {
    $actionPath = explode('/', $resolvedRequest);
    if ($actionPath[0] == 'login') {
      return new User_Main_Login();
    } elseif ($actionPath[0] == 'logout') {
      return new User_Main_Logout();
    } elseif ($actionPath[0] == 'resetpassword') {
      return new User_Main_ResetPassword();
    } elseif ($actionPath[0] == 'changepassword') {
      return new User_Main_ChangePassword();
    } elseif ($actionPath[0] == 'configure2fa') {
      return new User_Main_Configure2FA();
    } elseif ($actionPath[0] == 'sendresetemail') {
      return new User_Main_SendResetEmail();
    } elseif (in_array($actionPath[0], self::$objectTypes)) {
      $itemClass = 'User_'.$actionPath[0];
      if ($actionPath[1] == 'item') {
        if ($actionPath[2] == 'new') {
          $viewClass = 'User_Main_'.$actionPath[0].'_Item_New';
          return new $viewClass();
        } else {
          $item = $itemClass::getById($actionPath[2]); //TODO: Probably belongs in controller
          $viewType = $actionPath[3];
          if (in_array($viewType, self::$itemViewTypes)) {
            $viewClass = 'User_Main_'.$actionPath[0].'_Item_'.$viewType;
          } else {
            $viewClass = 'User_Main_'.$actionPath[0].'_Item_'.self::$itemViewTypes[0];
          }
          return new $viewClass($item);
        }
      } elseif ($actionPath[1] == 'list') {
        $items = $itemClass::getAll(); //TODO: Probably belongs in controller
        $viewType = $actionPath[2];
        if (in_array($viewType, self::$listViewTypes)) {
          $viewClass = 'User_Main_'.$actionPath[0].'_List_'.$viewType;
        } else {
          $viewClass = 'User_Main_'.$actionPath[0].'_List_'.self::$listViewTypes[0];
        }
        return new $viewClass($items);
      } else {
        throw new BadRouteException();
      }
    } else {
      throw new BadRouteException();
    }
  }

  /**
   * Sample paths:
   * item/1/update
   */
  function getRequestHandler($request) {
    $requestPath = explode('/', $request);
    if (in_array($requestPath[0], self::$actions)) {
      $requestHandlerClass = 'User_API_'.$requestPath[0];
      return new $requestHandlerClass();
    } elseif (in_array($requestPath[0], self::$objectTypes)) {
      $itemClass = 'User_'.$requestPath[0];
      if ($requestPath[1] == 'item') {
        if ($requestPath[2] == 'create') {
          $requestHandlerClass = 'User_API_'.$requestPath[0].'_Item_Create';
          return new $requestHandlerClass();
        } else {
          $item = $itemClass::getById($requestPath[2]); //TODO: Probably belongs in controller
          $requestType = $requestPath[3];
          if (in_array($requestType, self::$itemRequestTypes)) {
            $requestHandlerClass = 'User_API_'.$requestPath[0].'_Item_'.$requestType;
          } else {
            $requestHandlerClass = 'User_API_'.$requestPath[0].'_Item_'.self::$itemRequestTypes[0];
          }
          return new $requestHandlerClass($item);
        }
      }
    } else {
      throw new Exception('USER_BAD_REQUEST_TYPE');
    }
  }
}
