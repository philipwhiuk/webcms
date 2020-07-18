<?php
class User_Main_Role_Item_View extends Page_Renderable {
    function __construct($role) {
      $this->role = $role;
      $this->canEdit = Site::userHasPermission(
        Site::getUser(),
        User_Module::getPermissionOptions('role/item/'.$this->role->id.'/edit'));
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate('User_Main_Role_Item_View');
        $template = new $templateClass(array(
          'name' => $this->role->name,
          'canEdit' => $this->canEdit,
          'editUrl' => Site::getPageUrl(Page::forModule('user'),'role/item/'.$this->role->id.'/edit')
        ));
        return $template;
    }
}
