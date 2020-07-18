<?php
class User_Main_Configure2FA {
  function __construct() {
    $this->form = new Form();
    $this->form->id = 'user-configure2fa';
    $this->form->fields = array(
      new Form_TextField('Two Factor Auth Code', '2fa_code', '', 'Enter code',
        array())
    );
    $this->form->submitText = 'Setup Two Factor Authentication';
    $this->form->submitUrl = Site::getApiUrl('user','configure2fa');
    $this->form->redirectOnSuccess = false;
    $this->form->successFeedback = 'Two-factor authentication setup successfully';
    $this->form->failureFeedback = 'Failed to configure two-factor authentication';
  }
  function render($theme, $page) {
      $templateClass = $theme->getTemplate("User_Main_Configure2FA");
      $template = new $templateClass(array(
        'form' => $this->form->render($theme, $page)
      ));
      return $template;
  }
}
