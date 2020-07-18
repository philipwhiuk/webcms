<?php
class User_Main_Role_Item_Edit extends Page_Renderable {
    function __construct($role) {
      $this->role = $role;
      $this->form = new Form();
      $this->form->id = 'role-edit-'.$this->role->id;
      $this->form->fields = array(
        new Form_TextField('Name', 'name', $this->role->name, 'Enter name',
          array()),
        new Form_TextArea('Description', 'description', $this->role->username)
      );
      $this->form->submitText = 'Save';
      $this->form->submitUrl = Site::getApiUrl('user','role/item/'.$this->role->id.'/update');
      $this->form->finishText = 'Back to View';
      $this->form->finishUrl = Site::getPageUrl(Page::forModule('user'),'role/item/'.$this->role->id.'/view');
      $this->form->redirectOnSuccess = false;
      $this->form->successFeedback = 'Updated role';
      $this->form->failureFeedback = 'Failed to update role';
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate('User_Main_Role_Item_Edit');
        $template = new $templateClass(array(
          'form' => $this->form->render($theme, $page)
        ));
        return $template;
    }
}
