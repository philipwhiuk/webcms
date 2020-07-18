  <?php
class User_Main_User_List_View extends Page_Renderable {
  function __construct($users) {
    $this->users = $users;
  }

  function render($theme, $page) {
      $users = array();
      foreach ($this->users as $user) {
        $users[] = array(
          'username' => $user->username,
          'viewUrl' => Site::getPageUrl(Page::forModule('user'),'user/item/'.$user->id.'/view')
        );
      }
      $templateClass = $theme->getTemplate('User_Main_User_List_View');
      $template = new $templateClass(array(
        'users' => $users,
        'adminUrl' => Site::getPageUrl(Page::forModule('user'),'user/list/admin')
      ));
      return $template;
  }
}
