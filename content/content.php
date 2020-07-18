<?php
class Content_Content {

  static function getById($id) {
    $statement = DB::getConnection()->prepare("SELECT * from content where id = ?");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Content_Content");
    $statement->execute(array($id));
    if ($statement->rowCount() < 1) {
      throw new Exception("CONTENT_NOT_FOUND");
    }
    return $statement->fetch(PDO::FETCH_CLASS);
  }

  static function getAll() {
    $statement = DB::getConnection()->prepare("SELECT * from content");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Content_Content");
    $statement->execute(array());
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }

  static function getAllByTitle() {
    $statement = DB::getConnection()->prepare("SELECT * from content ORDER BY title");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Content_Content");
    $statement->execute(array());
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }

  public $id;
  public $title;
  public $text;
}
