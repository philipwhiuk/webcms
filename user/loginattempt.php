<?php
class User_LoginAttempt {
  public $id;
  public $user;
  public $datetime;
  public $success;

  static function add($user, $datetime, $success) {
    $statement = DB::getConnection()->prepare('INSERT INTO user_loginattempt (user, datetime, success) VALUES(?,?,?)');
    $statement->execute(array($user, $datetime, $success ? 1 : 0));
    if ($statement->rowCount() != 1) {
      throw new Exception("USER_LOGIN_ATTEMPT_STORAGE_FAILURE");
    }
  }

  static function getPreviousForUser($user) {
    $statement = DB::getConnection()->prepare("SELECT * from user_loginattempt where user = ? ORDER BY datetime LIMIT 1, 1");
    $statement->setFetchMode(PDO::FETCH_CLASS, "User_User");
    $statement->execute(array($username));
    $result = $statement->fetch(PDO::FETCH_CLASS);
    return $result;
  }
}
