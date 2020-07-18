<?php
class User_User {
  public $id;
  public $username;
  public $password_hash;
  public $email;

  static function getById($id) {
    $statement = DB::getConnection()->prepare("SELECT id, username from user where id = ?");
    $statement->setFetchMode(PDO::FETCH_CLASS, "User_User");
    $statement->execute(array($id));
    if ($statement->rowCount() < 1) {
      throw new Exception("USER_NOT_FOUND");
    }
    return $statement->fetch(PDO::FETCH_CLASS);
  }

  static function getByUsername($username) {
    $statement = DB::getConnection()->prepare("SELECT id, username, email from user where username = ?");
    $statement->setFetchMode(PDO::FETCH_CLASS, "User_User");
    $statement->execute(array($username));
    $result = $statement->fetch(PDO::FETCH_CLASS);
    return $result;
  }

  static function getUserWithHashByUsername($username) {
    $statement = DB::getConnection()->prepare("SELECT id, username, password_hash from user where username = ?");
    $statement->setFetchMode(PDO::FETCH_CLASS, "User_User");
    $statement->execute(array($username));
    if ($statement->rowCount() < 1) {
      return null;
    }
    return $statement->fetch(PDO::FETCH_CLASS);
  }

  static function getAll() {
    $statement = DB::getConnection()->prepare("SELECT * from user");
    $statement->setFetchMode(PDO::FETCH_CLASS, "User_User");
    $statement->execute(array());
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }

  static function setResetPasswordToken($id, $resetToken, $resetTokenExpiry) {
    $statement = DB::getConnection()->prepare('UPDATE user SET reset_password_token = ?, reset_password_expiry = ? where id = ?');
    $statement->execute(array($resetToken, $resetTokenExpiry, $id));
    $response = new stdClass();
    return $statement->rowCount() == 1;
  }

  static function updatePassword($id, $passwordHash) {
    $statement = DB::getConnection()->prepare('UPDATE user SET password_hash = ? WHERE id = ?');
    $statement->execute(array($passwordHash, $id));
    $response = new stdClass();
    return $statement->rowCount() == 1;
  }

  static function generateToken($length){
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet);

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[random_int(0, $max-1)];
    }

    return $token;
  }
}
