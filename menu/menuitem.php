<?php
class Menu_MenuItem {
  public $id;
  public $menu_order;
  public $title;
  public $path;
  public $link;
  public $active = false; //TODO: Work this out

  static function getById($id) {
    $statement = DB::getConnection()->prepare("SELECT * from menu_item where id = ? ORDER BY menu_order");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Menu_MenuItem");
    $statement->execute(array($id));
    if ($statement->rowCount() < 1) {
      throw new Exception("MENU_ITEM_NOT_FOUND");
    }
    return $statement->fetch(PDO::FETCH_CLASS);
  }

  static function getByMenu($menuId) {
    $statement = DB::getConnection()->prepare("SELECT * from menu_item where menu = ? ORDER BY menu_order");
    $statement->execute(array($menuId));
    return $statement->fetchAll(PDO::FETCH_CLASS, "Menu_MenuItem");
  }

  static function getAll() {
    $statement = DB::getConnection()->prepare("SELECT * from menu_item");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Menu_MenuItem");
    $statement->execute(array());
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }

  function __construct() {
    $this->link = Site::getPathUrl($this->path);
  }
}
