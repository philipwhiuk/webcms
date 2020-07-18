<?php
class User_Role {
  public $id;
  public $name;
  public $description;

  static function getById($id) {
    $statement = DB::getConnection()->prepare("SELECT * from user_role where id = ?");
    $statement->setFetchMode(PDO::FETCH_CLASS, "User_Role");
    $statement->execute(array($id));
    if ($statement->rowCount() < 1) {
      throw new Exception("USER_ROLE_NOT_FOUND");
    }
    return $statement->fetch(PDO::FETCH_CLASS);
  }

  static function getAll() {
    $statement = DB::getConnection()->prepare("SELECT * from user_role");
    $statement->setFetchMode(PDO::FETCH_CLASS, "User_Role");
    $statement->execute(array());
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }
}
