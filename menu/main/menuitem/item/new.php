<?php
class Menu_Main_MenuItem_Item_New extends Page_Renderable {
    function __construct() {
      $menus = array();
      $menuObjs = Menu_Menu::getAll();
      foreach ($menuObjs as $menuObj) {
        $menus[$menuObj->id] = $menuObj->title;
      }
      $this->form = new Form();
      $this->form->id = 'menuItem-new';
      $this->form->fields = array(
        new Form_TextField('Title', 'title', '', 'Enter title',
          array()),
        new Form_TextField('Path', 'path', '', 'Enter path',
          array()),
        new Form_Select('Menu', 'menu', '', 'Select menu',
          $menus),
        new Form_TextField('Menu Order', 'menu_order', '', '',
          array())
      );
      $this->form->submitText = 'Add';
      $this->form->submitUrl = Site::getApiUrl("menu","menuitem/item/create");
      $this->form->redirectOnSuccess = false;
      $this->form->successFeedback = 'Added menu item';
      $this->form->failureFeedback = 'Failed to add menu item';
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("Menu_Main_MenuItem_Item_New");
        $template = new $templateClass(array(
          'form' => $this->form->render($theme, $page)
        ));
        return $template;
    }
}
