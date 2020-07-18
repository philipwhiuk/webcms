<?php
class Payment_Transaction {
  public $id;
  public $user;
  public $description;
  public $method;
  public $payment_identifier;


  static function getByUser($user) {
    $statement = DB::getConnection()->prepare("SELECT * from payment_transaction WHERE user = ?");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Payment_Transaction");
    $statement->execute(array($user));
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }
}
