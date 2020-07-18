<?php
class Menu_Main_Menu_Item_New extends Page_Renderable {
    function __construct() {
      $this->menu = $menu;

      $menuBars = array();
      $menuBarObjs = Menu_MenuBar::getAll();
      foreach ($menuBarObjs as $menuBarObj) {
        $menuBars[$menuBarObj->id] = $menuBarObj->title;
      }
      $this->form = new Form();
      $this->form->id = 'menu-edit-'.$this->menu->id;
      $this->form->fields = array(
        new Form_TextField('Title', 'title', '', 'Enter title',
          array()),
        new Form_Select('Menu Bar', 'menu_bar', '', 'Select menu',
          $menuBars),
        new Form_TextField('Menu Order', 'menu_order', '', '',
          array())
      );
      $this->form->submitText = 'Save';
      $this->form->submitUrl = Site::getApiUrl("menu","menu/item/create");
      $this->form->redirectOnSuccess = false;
      $this->form->successFeedback = 'Added menu';
      $this->form->failureFeedback = 'Failed to add menu';
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("Menu_Main_Menu_Item_New");
        $template = new $templateClass(array(
          'form' => $this->form->render($theme, $page)
        ));
        return $template;
    }
}
