<?php
class Page_Main_Item_New extends Page_Renderable {
    function __construct() {
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("Page_Main_Item_New");
        $template = new $templateClass(array(
          'apiCreateUrl' => Site::getApiUrl("page","item/create")
        ));
        return $template;
    }
}
