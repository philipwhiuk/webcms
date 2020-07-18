<?php
class Email_Email {
  public $id;
  public $user;
  public $subject;
  public $datetime;

  static function getByUserByDate($user) {
      $statement = DB::getConnection()->prepare("SELECT * from email WHERE user = ? ORDER by datetime DESC");
      $statement->setFetchMode(PDO::FETCH_CLASS, "Email_Email");
      $statement->execute(array($user));
      return $statement->fetchAll(PDO::FETCH_CLASS);
  }
}
