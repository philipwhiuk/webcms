<?php
class User_Permission {
  public $user;
  public $path;

  static function permissionExists($user, $pathOptions) {
    $optionPlaceholders = str_repeat ('?, ',  count ($pathOptions) - 1) . '?';
    $statement = DB::getConnection()->prepare("SELECT * from user_permission where user = ? AND path IN ($optionPlaceholders)");
    $params = $pathOptions;
    array_unshift($params, $user);
    $statement->execute($params);
    if ($statement->rowCount() > 0) {
      return true;
    }
    return false;
  }
}
