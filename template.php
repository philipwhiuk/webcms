<?php
abstract class Template {
  protected $data;

  function __construct($data, $page = null) {
    $this->data = $data;
    $this->registerPageData($page);
  }

  function registerPageData() {}

  abstract function display();
}
