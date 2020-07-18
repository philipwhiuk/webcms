<?php
class User_Main_Login extends Page_Renderable {
    function __construct() {
      $this->form = new Form();
      $this->form->id = 'user-login';
      $this->form->fields = array(
        new Form_TextField('Username', 'username', '', 'Enter username',
          array('autocomplete' => 'username')),
        new Form_PasswordField('Password', 'password', '', 'Enter password',
          array('autocomplete' => 'current-password'))
      );
      $this->form->submitText = 'Login';
      $this->form->submitUrl = Site::getApiUrl('user','login');
      $this->form->redirectOnSuccess = true;
      $this->form->redirectUrl = Site::getFullUrlForPage(Site::getDefaultPage());
      $this->form->successFeedback = 'Login succeeded';
      $this->form->failureFeedback = 'Login failed';
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate('User_Main_Login');
        $template = new $templateClass(array(
          'form' => $this->form->render($theme, $page),
          'resetUrl' => Site::getPageUrl(Page::forModule('user'),'sendresetemail')
        ));
        return $template;
    }
}
