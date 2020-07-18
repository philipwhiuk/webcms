<?php
class User_Main_Role_List_Admin extends Page_Renderable {
  function __construct($roles) {
    $this->roles = $roles;
  }

  function render($theme, $page) {
      $roles = array();
      foreach ($this->roles as $role) {
        $roles[] = array(
          'name' => $role->name,
          'viewUrl' => Site::getPageUrl(Page::forModule('user'),'role/item/'.$role->id.'/view'),
          'editUrl' => Site::getPageUrl(Page::forModule('user'),'role/item/'.$role->id.'/edit'),
          'deleteUrl' => Site::getPageUrl(Page::forModule('user'),'role/item/'.$role->id.'/delete')
        );
      }
      $templateClass = $theme->getTemplate('User_Main_Role_List_Admin');
      $template = new $templateClass(array(
        'roles' => $roles,
        'viewUrl' =>  Site::getPageUrl(Page::forModule('user'),'role/list/view'),
        'newUrl' =>  Site::getPageUrl(Page::forModule('user'),'role/item/new')
      ));
      return $template;
  }
}
