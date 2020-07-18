<?php
class Block extends Page_Renderable {
  static $VISIBILITY_OPTIONS = array(
    'all' => 'All Pages',
    'selected' => 'Selected Pages',
    'not-selected' => 'All But Selected Pages',
    'none' => 'No Pages');

  static function getById($id) {
    $statement = DB::getConnection()->prepare("SELECT * from block where id = ?");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Block");
    $statement->execute(array($id));
    if ($statement->rowCount() < 1) {
      throw new Exception("BLOCK_NOT_FOUND");
    }
    return $statement->fetch(PDO::FETCH_CLASS);
  }

  static function getAll() {
    $statement = DB::getConnection()->prepare("SELECT * from block");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Block");
    $statement->execute(array());
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }

  static function getAllByTitle() {
    $statement = DB::getConnection()->prepare("SELECT * from block ORDER BY title");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Block");
    $statement->execute(array());
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }

  static function getBlocksForPage($page) {
    $statement = DB::getConnection()->prepare("SELECT * from block WHERE
      visibility = 'all'
      OR (visibility = 'selected' AND id IN (SELECT block from page_block where page = ?))
      OR (visibility = 'not-selected' AND id NOT IN (SELECT block from page_block where page = ?))");
    $statement->execute(array($page, $page));
    $results = $statement->fetchAll(PDO::FETCH_CLASS, 'Block');
    return $results;
  }

  public $id;
  public $title;
  public $module;
  public $action;
  public $location;
  public $visibility;

  function __construct() {
    $this->blockModule = Module::getLoadedByName($this->module);
  }

  function load($page) {
    $this->blockView = $this->blockModule->getBlock($this->action, $page);
  }

  function render($theme, $page) {
    return $this->blockView->render($theme, $page);
  }

}
