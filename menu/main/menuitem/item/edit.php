<?php
class Menu_Main_MenuItem_Item_Edit extends Page_Renderable {
    function __construct($menuItem) {
      $this->menuItem = $menuItem;

      $menus = array();
      $menuObjs = Menu_Menu::getAll();
      foreach ($menuObjs as $menuObj) {
        $menus[$menuObj->id] = $menuObj->title;
      }

      $this->form = new Form();
      $this->form->id = 'menuItem-edit-'.$this->menuItem->id;
      $this->form->fields = array(
        new Form_TextField('Title', 'title', $this->menuItem->title, 'Enter title',
          array()),
        new Form_TextField('Path', 'path', $this->menuItem->path, 'Enter path',
          array()),
        new Form_Select('Menu', 'menu', $this->menuItem->menu, 'Select menu',
          $menus),
        new Form_TextField('Menu Order', 'menu_order', $this->menuItem->menu_order, '',
          array())
      );
      $this->form->submitText = 'Save';
      $this->form->submitUrl = Site::getApiUrl('menu','menuitem/item/'.$this->menuItem->id.'/update');
      $this->form->finishText = 'Back to View';
      $this->form->finishUrl = Site::getPageUrl(Page::forModule('menu'),'menuitem/item/'.$this->menuItem->id.'/view');
      $this->form->redirectOnSuccess = false;
      $this->form->successFeedback = 'Updated menu item';
      $this->form->failureFeedback = 'Failed to update menu item';
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("Menu_Main_MenuItem_Item_Edit");
        $template = new $templateClass(array(
          'form' => $this->form->render($theme, $page)
        ));
        return $template;
    }
}
