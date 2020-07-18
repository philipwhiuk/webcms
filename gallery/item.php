<?php
class Gallery_Item {
  public $id;
  public $gallery;
  public $src;

  static function getById($id) {
    $statement = DB::getConnection()->prepare("SELECT * from gallery_item where id = ?");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Gallery_Item");
    $statement->execute(array($id));
    if ($statement->rowCount() < 1) {
      throw new Exception("GALLERY_ITEM_NOT_FOUND");
    }
    return $statement->fetch(PDO::FETCH_CLASS);
  }

  static function getByGallery($gallery) {
    $statement = DB::getConnection()->prepare("SELECT * from gallery_item where gallery = ?");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Gallery_Item");
    $statement->execute(array($gallery));
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }

  static function getAll() {
    $statement = DB::getConnection()->prepare("SELECT * from gallery_item");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Gallery_Item");
    $statement->execute(array());
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }
}
