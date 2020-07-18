<?php
class Content_Formatter {
  static $macros = array();

  static function registerMacro($key, $type, $value) {
    self::$macros[] = array('key' => $key, 'type' => $type, 'value' => $value);
  }
  static function format($text, $additionalMacros = array()) {
    $newText = $text;
    foreach(self::$macros as $macro) {
      $newText = self::processMacro($newText, $macro);
    }
    foreach($additionalMacros as $macro) {
      $newText = self::processMacro($newText, $macro);
    }
    return $newText;
  }

  static function processMacro($text, $macro) {
    switch ($macro['type']) {
      case 'date':
        $replaceText = date('jS F Y',$macro['value']);
        break;
      default:
        $replaceText = $macro['value'];
    }
    return str_replace('%'.$macro['key'].'%', $replaceText, $text);
  }
}

 ?>
