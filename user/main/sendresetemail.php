<?php
class User_Main_SendResetEmail extends Page_Renderable {
    function __construct() {
      unset($_SESSION["user_username"]);
      $this->form = new Form();
      $this->form->id = 'user-resetpassword';
      $this->form->fields = array(
        new Form_TextField('Username', 'username', '', 'Enter username',
          array('autocomplete' => 'username')),
        new Form_TextField('Email', 'email', '', 'Enter email',
          array('autocomplete' => 'email'))
      );
      $this->form->submitText = 'Request Password Reset Email';
      $this->form->submitUrl = Site::getApiUrl('user','sendresetemail');
      $this->form->redirectOnSuccess = false;
      $this->form->redirectUrl = Site::getFullUrlForPage(Site::getDefaultPage());
      $this->form->successFeedback = 'Sent an email, assuming the account exists';
      $this->form->failureFeedback = 'Failed to generate reset request';
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("User_Main_SendResetEmail");
        $template = new $templateClass(array(
          'form' => $this->form->render($theme, $page)
        ));
        return $template;
    }

}
