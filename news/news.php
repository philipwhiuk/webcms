<?php
class News_News {
  public $id;
  public $title;
  public $text;

  static function getById($id) {
    $statement = DB::getConnection()->prepare("SELECT * from news where id = ?");
    $statement->setFetchMode(PDO::FETCH_CLASS, "News_News");
    $statement->execute(array($id));
    if ($statement->rowCount() < 1) {
      throw new Exception("NEWS_NOT_FOUND");
    }
    return $statement->fetch(PDO::FETCH_CLASS);
  }

  static function getAll() {
    $statement = DB::getConnection()->prepare("SELECT * from news");
    $statement->setFetchMode(PDO::FETCH_CLASS, "News_News");
    $statement->execute(array());
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }

  static function getLatest($count) {
    $statement = DB::getConnection()->prepare("SELECT * from news ORDER BY publish_date LIMIT ?");
    $statement->setFetchMode(PDO::FETCH_CLASS, "News_News");
    $statement->bindParam(1, $count, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }

  static function getAllByTitle() {
    $statement = DB::getConnection()->prepare("SELECT * from news ORDER BY title");
    $statement->setFetchMode(PDO::FETCH_CLASS, "News_News");
    $statement->execute(array());
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }
}
