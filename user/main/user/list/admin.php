<?php
class User_Main_User_List_Admin extends Page_Renderable {
  function __construct($users) {
    $this->users = $users;
  }

  function render($theme, $page) {
      $users = array();
      foreach ($this->users as $user) {
        $users[] = array(
          'username' => $user->username,
          'viewUrl' => Site::getPageUrl(Page::forModule('user'),'user/item/'.$user->id.'/view'),
          'editUrl' => Site::getPageUrl(Page::forModule('user'),'user/item/'.$user->id.'/edit'),
          'deleteUrl' => Site::getPageUrl(Page::forModule('user'),'user/item/'.$user->id.'/delete')
        );
      }
      $templateClass = $theme->getTemplate('User_Main_User_List_Admin');
      $template = new $templateClass(array(
        'users' => $users,
        'viewUrl' =>  Site::getPageUrl(Page::forModule('user'),'user/list/view'),
        'newUrl' =>  Site::getPageUrl(Page::forModule('user'),'user/item/new')
      ));
      return $template;
  }
}
