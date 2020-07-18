<?php
class Gallery_Gallery {
  public $id;
  public $title;

  static function getById($id) {
    $statement = DB::getConnection()->prepare("SELECT * from gallery where id = ?");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Gallery_Gallery");
    $statement->execute(array($id));
    if ($statement->rowCount() < 1) {
      throw new Exception("GALLERY_NOT_FOUND");
    }
    return $statement->fetch(PDO::FETCH_CLASS);
  }

  static function getAll() {
    $statement = DB::getConnection()->prepare("SELECT * from gallery ORDER BY title");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Gallery_Gallery");
    $statement->execute(array());
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }
}
