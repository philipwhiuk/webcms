<?php
class LiveSettings {
  static function get() {
    $statement = DB::getConnection()->prepare("SELECT * from livesettings");
    $statement->execute();
    $liveSettings = $statement->fetch(PDO::FETCH_ASSOC);
    return new LiveSettings($liveSettings);
  }

  private $settings;

  function __construct($settings) {
    $this->settings = $settings;
  }

  function getSetting($setting) {
    if (empty($this->settings[$setting])) {
      throw new Exception("Live setting '".$setting."' not defined");
    }
    return $this->settings[$setting];
  }
}
