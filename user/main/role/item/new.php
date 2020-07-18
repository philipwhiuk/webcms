<?php
class User_Main_Role_Item_New extends Page_Renderable {
  function __construct() {
    $this->form = new Form();
    $this->form->id = 'role-new';
    $this->form->fields = array(
      new Form_TextField('Name', 'name', '', 'Enter name',
        array()),
      new Form_TextArea('Description', 'description', '')
    );
    $this->form->submitText = 'Add';
    $this->form->submitUrl = Site::getApiUrl('user','role/item/create');
    $this->form->finishText = 'Back to List';
    $this->form->finishUrl = Site::getPageUrl(Page::forModule('user'),'role/list/view');
    $this->form->redirectOnSuccess = true;
    $this->form->redirectUrl = Site::getPageUrl(Page::forModule('user'),'role/list/view');
    $this->form->successFeedback = 'Added role';
    $this->form->failureFeedback = 'Failed to add role';
  }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate('User_Main_Role_Item_New');
        $template = new $templateClass(array(
          'form' => $this->form->render($theme, $page)
        ));
        return $template;
    }
}
