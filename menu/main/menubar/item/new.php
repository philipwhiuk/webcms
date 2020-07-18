<?php
class Menu_Main_MenuBar_Item_New extends Page_Renderable {
    function __construct() {
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("Menu_Main_MenuBar_Item_New");
        $template = new $templateClass(array(
          'apiCreateUrl' => Site::getApiUrl("menu","menubar/item/create")
        ));
        return $template;
    }
}
