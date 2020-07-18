<?php
class Page extends Renderable {

  static function getById($id) {
    $statement = DB::getConnection()->prepare("SELECT * from page where id = ?");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Page");
    $statement->execute(array($id));
    if ($statement->rowCount() < 1) {
      throw new Exception("PAGE_NOT_FOUND");
    }
    return $statement->fetch(PDO::FETCH_CLASS);
  }

  static function getAll() {
    $statement = DB::getConnection()->prepare("SELECT * from page");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Page");
    $statement->execute(array());
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }

  static function getAllByTitle() {
    $statement = DB::getConnection()->prepare("SELECT * from page ORDER BY title");
    $statement->setFetchMode(PDO::FETCH_CLASS, "Page");
    $statement->execute(array());
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }

  static function getByPath($path) {
    if ($path === null || $path === "") {
      return Site::getDefaultPage();
    } else {
      $statement = DB::getConnection()->prepare("SELECT * from page where path = ?");
      $statement->setFetchMode( PDO::FETCH_CLASS, 'Page');
      $statement->execute(array($path));
      if ($statement->rowCount() < 1) {
        return Site::getPageNotFoundPage($path);
      }
      $result = $statement->fetch(PDO::FETCH_CLASS);
      return $result;
    }
  }

  static function forModule($module) {
    $statement = DB::getConnection()->prepare("SELECT * from page where module = ? AND defaultAction = ''");
    $statement->setFetchMode( PDO::FETCH_CLASS, 'Page');
    $statement->execute(array($module));
    if ($statement->rowCount() < 1) {
      throw new Exception("PAGE_NO_CANONICAL_PAGE_FOR_MODULE");
    }
    $result = $statement->fetch(PDO::FETCH_CLASS);
    return $result;
  }

  public $id;
  public $title;
  public $path;
  public $module;
  public $defaultAction;
  private $headElements = array();
  private $bodyElements = array();

  function resolveRequest($request) {
    $mainModule = Module::getLoadedByName($this->module);
    return $mainModule::resolveMainRequest($this->defaultAction, $request);
  }

  function getPermissionOptions($pageRequest) {
    $mainModule = Module::getLoadedByName($this->module);
    return $mainModule->getPermissionOptions($pageRequest);
  }

  function loadAs($request) {
      $mainModule = Module::getLoadedByName($this->module);
      $this->main = $mainModule->getMain($request);
      $this->fetchBlocks();
  }

  function loadAsDefault() {
      $mainModule = Module::getLoadedByName($this->module);
      $this->main = $mainModule->getMain($this->defaultAction);
      $this->fetchBlocks();
  }

  function fetchBlocks() {
    $blocks = Block::getBlocksForPage($this->id);
    $this->blocks = array();
    foreach ($blocks as $block) {
      try {
        $block->load($this);
        $this->blocks[] = $block;
      } catch (Exception $e) {
        if (CMS_DEBUG) {
          throw $e;
        }
      }
    }
  }

  function registerHeadElements($html) {
    $this->headElements[] = $html;
  }

  function registerBodyElements($html) {
    $this->bodyElements[] = $html;
  }

  function render($theme) {
    $templateClass = $theme->getTemplate("Page");
    $blocks = array();
    foreach ($this->blocks as $block) {
      $blocks[$block->location][] = $block->render($theme, $this);
    }
    $main = $this->main->render($theme, $this);
    return new $templateClass(array(
      'site_title' => Site::getTitle(),
      'page_title' => $this->title,
      'head_elements' => $this->headElements,
      'body_elements' => $this->bodyElements,
      'blocks' => $blocks,
      'main' => $main,
    ));
  }

}
