<?php
class Menu_Main_Menu_Item_Edit extends Page_Renderable {
    function __construct($menu) {
      $this->menu = $menu;

      $menuBars = array();
      $menuBarObjs = Menu_MenuBar::getAll();
      foreach ($menuBarObjs as $menuBarObj) {
        $menuBars[$menuBarObj->id] = $menuBarObj->title;
      }
      $this->form = new Form();
      $this->form->id = 'menu-edit-'.$this->menu->id;
      $this->form->fields = array(
        new Form_TextField('Title', 'title', $this->menu->title, 'Enter title',
          array()),
        new Form_Select('Menu Bar', 'menu_bar', $this->menu->menu_bar, 'Select menu',
          $menuBars),
        new Form_TextField('Menu Order', 'menu_order', $this->menu->menu_order, '',
          array())
      );
      $this->form->submitText = 'Save';
      $this->form->submitUrl = Site::getApiUrl('menu','menu/item/'.$this->menu->id.'/update');
      $this->form->finishText = 'Back to View';
      $this->form->finishUrl = Site::getPageUrl(Page::forModule('menu'),'menu/item/'.$this->menu->id.'/view');
      $this->form->redirectOnSuccess = false;
      $this->form->successFeedback = 'Updated menu';
      $this->form->failureFeedback = 'Failed to update menu';
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("Menu_Main_Menu_Item_Edit");
        $template = new $templateClass(array(
          'form' => $this->form->render($theme, $page)
        ));
        return $template;
    }
}
