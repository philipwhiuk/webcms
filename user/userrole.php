<?php
class User_UserRole {
    public $user;
    public $role;

    static function getByUser($user) {
      $statement = DB::getConnection()->prepare("SELECT * from user_userrole where user = ?");
      $statement->setFetchMode(PDO::FETCH_CLASS, "User_UserRole");
      $statement->execute(array($user));
      if ($statement->rowCount() < 1) {
        throw new Exception("USER_ROLE_NOT_FOUND");
      }
      return $statement->fetch(PDO::FETCH_CLASS);
    }

    static function getByRole($role) {
      $statement = DB::getConnection()->prepare("SELECT * from user_userrole where role = ?");
      $statement->setFetchMode(PDO::FETCH_CLASS, "User_UserRole");
      $statement->execute(array($role));
      return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    static function getAll() {
      $statement = DB::getConnection()->prepare("SELECT * from user_userrole");
      $statement->setFetchMode(PDO::FETCH_CLASS, "User_UserRole");
      $statement->execute(array());
      return $statement->fetchAll(PDO::FETCH_CLASS);
    }
}
