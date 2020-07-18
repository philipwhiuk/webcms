<?php
class User_Main_User_Item_Delete extends Page_Renderable {
    function __construct($user) {
      $this->user = $user;
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate('User_Main_User_Item_Delete');
        $template = new $templateClass(array(
          'id' => $this->user->id,
          'username' => $this->user->username,
          'apiDeleteUrl' => Site::getApiUrl('user','user/item/'.$this->user->id.'/delete'),
          'viewUrl' => Site::getPageUrl(Page::forModule('user'),'user/item/'.$this->user->id.'/view'),
          'editUrl' => Site::getPageUrl(Page::forModule('user'),'user/item/'.$this->user->id.'/edit')
        ));
        return $template;
    }
}
