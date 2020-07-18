<?php
class Member_Config {
  public $key;
  public $text;

  static function getByKey($key) {
    $statement = DB::getConnection()->prepare("SELECT * from `member_config` where `key` = ?");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Member_Config");
    $statement->execute(array($key));
    if ($statement->rowCount() < 1) {
      throw new Exception("MEMBER_CONFIG_NOT_FOUND");
    }
    return $statement->fetch(PDO::FETCH_CLASS);
  }

}
