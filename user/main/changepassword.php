<?php
class User_Main_ChangePassword extends Page_Renderable {
    function __construct() {
      $this->form = new Form();
      $this->form->id = 'user-changepassword';
      $this->form->fields = array(
        new Form_PasswordField('Password', 'password', '', 'Enter new password',
          array('autocomplete' => 'new-password')),
        new Form_PasswordField('Confirm password', 'confirm_password', '', 'Enter new password again',
          array())
      );
      $this->form->submitText = 'Change Password';
      $this->form->submitUrl = Site::getApiUrl('user','changepassword');
      $this->form->redirectOnSuccess = true;
      $this->form->redirectUrl = Site::getFullUrlForPage(Site::getDefaultPage());
      $this->form->successFeedback = 'Password changed successfully';
      $this->form->failureFeedback = 'Failed to change password';
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("User_Main_ChangePassword");
        $template = new $templateClass(array(
          'form' => $this->form->render($theme, $page)
        ));
        return $template;
    }

}
