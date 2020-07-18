<?php
class User_Main_User_Item_View extends Page_Renderable {
    function __construct($user) {
      $this->user = $user;
      $this->canEdit = Site::userHasPermission(
        Site::getUser(),
        User_Module::getPermissionOptions('user/item/'.$this->user->id.'/edit'));
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate('User_Main_User_Item_View');
        $template = new $templateClass(array(
          'username' => $this->user->username,
          'canEdit' => $this->canEdit,
          'editUrl' => Site::getPageUrl(Page::forModule('user'),'user/item/'.$this->user->id.'/edit')
        ));
        return $template;
    }
}
