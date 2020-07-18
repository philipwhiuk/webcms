<?php
class Menu_Menu {
  public $id;
  public $title;

  static function getById($id) {
    $statement = DB::getConnection()->prepare("SELECT * from menu where id = ?");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Menu_Menu");
    $statement->execute(array($id));
    if ($statement->rowCount() < 1) {
      throw new Exception("MENU_NOT_FOUND");
    }
    return $statement->fetch(PDO::FETCH_CLASS);
  }

  static function getByMenuBar($menu_bar) {
    $statement = DB::getConnection()->prepare("SELECT * from menu where menu_bar = ? ORDER BY menu_order");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Menu_Menu");
    $statement->execute(array($menu_bar));
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }

  static function getAll() {
    $statement = DB::getConnection()->prepare("SELECT * from menu");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Menu_Menu");
    $statement->execute(array());
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }

  static function getAllByTitle() {
    $statement = DB::getConnection()->prepare("SELECT * from menu ORDER BY title");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Menu_Menu");
    $statement->execute(array());
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }
}
