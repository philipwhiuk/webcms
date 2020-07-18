<?php
class Config {
  static function load() {
    include "config.settings.php";
    if (empty($settings)) {
      throw new Exception("Config not defined");
    }
    return new Config($settings);
  }

  function __construct($settings) {
    $this->settings = $settings;
  }

  function getProperty($property) {
    if (empty($this->settings[$property])) {
      throw new Exception("Config property '".$property."' not defined");
    }
    return $this->settings[$property];
  }

}
