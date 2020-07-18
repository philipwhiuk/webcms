<?php
class Theme {
  private $name;

  static function getByName($name) {
    $statement = DB::getConnection()->prepare(
      "SELECT * FROM theme WHERE name = ?");
    $statement->setFetchMode(PDO::FETCH_CLASS, 'Theme');
    $statement->execute(array($name));
    if ($statement->rowCount() < 1) {
      throw new Exception("THEME_NOT_FOUND");
    }
    return $statement->fetch(PDO::FETCH_CLASS);
  }

  static function getById($id) {
    $statement = DB::getConnection()->prepare(
      "SELECT * FROM theme WHERE id = ?");
    $statement->setFetchMode(PDO::FETCH_CLASS, 'Theme');
    $statement->execute(array($id));
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }

  static function getAllByName() {
    $statement = DB::getConnection()->prepare(
      "SELECT * FROM theme ORDER BY name");
    $statement->setFetchMode(PDO::FETCH_CLASS, 'Theme');
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_CLASS);
  }

  function templateToThemeClass($template) {
    return 'Theme_'.$this->name.'_'.$template.'_Template';
  }

  function templateToThemeFile($template) {
    $clazz = $this->templateToThemeClass($template);
    return str_replace("_","/",strtolower($clazz)).'.php';
  }

  function hasTemplate($template) {
    $filename = $this->templateToThemeFile($template);
    return file_exists($filename);
  }

  function getTemplate($template) {
    if ($this->hasTemplate($template)) {
      return $this->templateToThemeClass($template);
    } else if($this->name != "default") {
      return Theme::getByName('default')->getTemplate($template);
    } else {
      throw new Exception("THEME_TEMPLATE_NOT_FOUND");
    }
  }
}
