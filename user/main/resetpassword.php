<?php
class User_Main_ResetPassword extends Page_Renderable {
    function __construct() {
      $this->form = new Form();
      $this->form->id = 'user-resetpassword';
      $this->form->fields = array(
        new Form_TextField('Username', 'username', '', 'Enter username',
          array('autocomplete' => 'username')),
        new Form_TextField('Reset Code', 'resetCode', '', 'Enter reset code',
          array('autocomplete' => 'new-password')),
        new Form_PasswordField('Password', 'password', '', 'Enter new password',
          array('autocomplete' => 'new-password')),
        new Form_PasswordField('Confirm password', 'confirm_password', '', 'Enter new password again',
          array())
      );
      $this->form->submitText = 'Reset Password';
      $this->form->submitUrl = Site::getApiUrl('user','resetpassword');
      $this->form->redirectOnSuccess = false;
      $this->form->successFeedback = 'Password reset successfully - you may now login with the new password';
      $this->form->failureFeedback = 'Failed to reset password';
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("User_Main_ResetPassword");
        $template = new $templateClass(array(
          'form' => $this->form->render($theme, $page)
        ));
        return $template;
    }

}
