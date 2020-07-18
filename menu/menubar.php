<?php
class Menu_MenuBar {
  public $id;
  public $title;

  static function getById($id) {
    $statement = DB::getConnection()->prepare("SELECT * from menubar where id = ?");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Menu_MenuBar");
    $statement->execute(array($id));
    if ($statement->rowCount() < 1) {
      throw new Exception("MENU_NOT_FOUND");
    }
    return $statement->fetch(PDO::FETCH_CLASS);
  }

  static function getAll() {
    $statement = DB::getConnection()->prepare("SELECT * from menubar");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Menu_MenuBar");
    $statement->execute(array());
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }

  static function getAllByTitle() {
    $statement = DB::getConnection()->prepare("SELECT * from menubar ORDER BY title");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Menu_MenuBar");
    $statement->execute(array());
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }
}
