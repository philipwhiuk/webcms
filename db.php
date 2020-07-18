<?php
class DB {
  private static $connection;

  static function getConnection() {
    if (self::$connection == null) {
      $config = Site::getConfigProperty("db_config");
      self::$connection = new PDO($config['dsn'], $config['user'], $config['password'], array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_PERSISTENT => true));
    }
    return self::$connection;
  }
}
