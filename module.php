<?php
class Module {
  static $modules = array();

  static function loadModules() {
    $statement = DB::getConnection()->prepare(
      "SELECT CONCAT(name, '_Module') AS clazz, id, name FROM module");
    $statement->execute();
    $moduleData = $statement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_CLASSTYPE);
    foreach ($moduleData as $module) {
      self::$modules[$module->name] = $module;
    }
  }

  static function getAllByName() {
    $statement = DB::getConnection()->prepare(
      "SELECT CONCAT(name, '_Module') AS clazz, id, name FROM module ORDER BY name");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_CLASSTYPE);
  }

  static function getAllLoaded() {
    return self::$modules;
  }

  static function getLoadedByName($name) {
    if (empty(self::$modules[$name])) {
      throw new Exception("MODULE_NOT_LOADED");
    }
    return self::$modules[$name];
  }

  static function getBasePermissionOptions($moduleName, $objectTypes, $displayObjectTypes, $resolvedRequest) {
    $root = Page::forModule($moduleName)->path;
    $options = array('*',$root.'/*');
    $actionPath = explode("/", $resolvedRequest);
    foreach ($objectTypes as $objectType) {
      if ($actionPath[0] == $objectType) {
        $options[] = $root.'/'.$objectType.'/*';
        if ($actionPath[1] != "new") {
          $options[] = $root.'/'.$objectType.'/*/'.$actionPath[2];
          $options[] = $root.'/'.$objectType.'/'.$actionPath[1].'/'.$actionPath[2];
        } else {
          $options[] = $root.'/'.$objectType.'/new';
        }
        return $options;
      }
    }
    foreach ($displayObjectTypes as $displayObjectType) {
      if ($actionPath[0] == $displayObjectType) {
        $options[] = $root.'/'.$displayObjectType.'/*';
        $options[] = $root.'/'.$displayObjectType.'/'.$actionPath[1];
      }
      return $options;
    }
  }

  public $id;
  public $module;

  function resolveMainRequest($action, $request) {
      throw new Exception("MODULE_UNEXPECTED_RESOLUTION_REQUEST");
   }

  function getPermissionOptions($resolvedRequest) {
    throw new Exception("MODULE_UNEXPECTED_PERMISSIONS_REQUEST");
  }

  function getMain($resolvedRequest) {
    throw new Exception("MODULE_UNEXPECTED_MAIN_REQUEST");
  }

  function getBlock($action) {
    throw new Exception("MODULE_UNEXPECTED_BLOCK_REQUEST");
  }

  function getRequestHandler($request) {
    throw new Exception("MODULE_UNEXPECTED_API_REQUEST");
  }
}
