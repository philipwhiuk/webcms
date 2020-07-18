<?php
class User_Main_User_Item_Edit extends Page_Renderable {
    function __construct($user) {
      $this->user = $user;
      $this->form = new Form();
      $this->form->id = 'user-edit-'.$this->user->id;
      $this->form->fields = array(
        new Form_TextField('Username', 'username', $this->user->username, 'Enter username',
          array())
      );
      $this->form->submitText = 'Save';
      $this->form->submitUrl = Site::getApiUrl('user','user/item/'.$this->user->id.'/update');
      $this->form->finishText = 'Back to View';
      $this->form->finishUrl = Site::getPageUrl(Page::forModule('user'),'user/item/'.$this->user->id.'/view');
      $this->form->redirectOnSuccess = false;
      $this->form->successFeedback = 'Updated user';
      $this->form->failureFeedback = 'Failed to update user';
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate('User_Main_User_Item_Edit');
        $template = new $templateClass(array(
          'form' => $this->form->render($theme, $page)
        ));
        return $template;
    }
}
