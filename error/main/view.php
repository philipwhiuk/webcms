<?php
class Error_Main_View {
  function __construct() {
  }
  function render($theme, $page) {
      $templateClass = $theme->getTemplate("Error_Main_View");
      $template = new $templateClass(array(
        'error_code' => CMS_DEBUG ? Site::getError()->getMessage() : null,
        'trace' => CMS_DEBUG ? Site::getError()->getTraceAsString() : null
      ));
      return $template;
  }
}
