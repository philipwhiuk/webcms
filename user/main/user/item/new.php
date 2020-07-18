<?php
class User_Main_User_Item_New extends Page_Renderable {
  function __construct() {
    $this->form = new Form();
    $this->form->id = 'user-new';
    $this->form->fields = array(
      new Form_TextField('Username', 'username', '', 'Enter username',
        array())
    );
    $this->form->submitText = 'Add';
    $this->form->submitUrl = Site::getApiUrl('user','user/item/create');
    $this->form->finishText = 'Back to List';
    $this->form->finishUrl = Site::getPageUrl(Page::forModule('user'),'user/list/view');
    $this->form->redirectOnSuccess = true;
    $this->form->redirectUrl = Site::getPageUrl(Page::forModule('user'),'user/list/view');
    $this->form->successFeedback = 'Added user';
    $this->form->failureFeedback = 'Failed to add user';
  }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate('User_Main_User_Item_New');
        $template = new $templateClass(array(
          'form' => $this->form->render($theme, $page)
        ));
        return $template;
    }
}
