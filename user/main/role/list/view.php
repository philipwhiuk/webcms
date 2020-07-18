  <?php
class User_Main_Role_List_View extends Page_Renderable {
  function __construct($roles) {
    $this->roles = $roles;
  }

  function render($theme, $page) {
      $roles = array();
      foreach ($this->roles as $role) {
        $roles[] = array(
          'name' => $role->name,
          'viewUrl' => Site::getPageUrl(Page::forModule('user'),'role/item/'.$role->id.'/view')
        );
      }
      $templateClass = $theme->getTemplate('User_Main_Role_List_View');
      $template = new $templateClass(array(
        'roles' => $roles,
        'adminUrl' => Site::getPageUrl(Page::forModule('user'),'role/list/admin')
      ));
      return $template;
  }
}
