<?php
class User_Main_Role_Item_Delete extends Page_Renderable {
    function __construct($role) {
      $this->role = $role;
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate('User_Main_Role_Item_Delete');
        $template = new $templateClass(array(
          'id' => $this->role->id,
          'name' => $this->role->name,
          'apiDeleteUrl' => Site::getApiUrl('user','role/item/'.$this->role->id.'/delete'),
          'viewUrl' => Site::getPageUrl(Page::forModule('user'),'role/item/'.$this->role->id.'/view'),
          'editUrl' => Site::getPageUrl(Page::forModule('user'),'role/item/'.$this->role->id.'/edit')
        ));
        return $template;
    }
}
