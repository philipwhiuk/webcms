<?php
class Block_Main_Item_Edit extends Page_Renderable {
    function __construct($block) {
      $this->block = $block;
      $modules = array();
      $moduleObjs = Module::getAllLoaded();
      foreach ($moduleObjs as $module) {
        $modules[$module->name] = $module->name;
      }
      $this->form = new Form();
      $this->form->id = 'block-edit-'.$this->block->id;
      $this->form->fields = array(
        new Form_TextField('Title', 'title', $this->block->title, 'Enter title',
          array()),
        new Form_Select('Module', 'module', $this->block->module, 'Select module',
          $modules),
        new Form_TextField('Action', 'action', $this->block->action, 'Select action',
          array()),
        new Form_TextField('Location', 'location', $this->block->location, 'Select location',
          array()),
        new Form_Select('Visibility', 'visibility', $this->block->visibility, 'Select visibility',
          Block::$VISIBILITY_OPTIONS)
      );
      $this->form->submitText = 'Save';
      $this->form->submitUrl = Site::getApiUrl('block','item/'.$this->block->id.'/update');
      $this->form->redirectOnSuccess = false;
      $this->form->successFeedback = 'Updated block';
      $this->form->failureFeedback = 'Failed to update block';
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate('Block_Main_Item_Edit');
        $template = new $templateClass(array(
          'form' => $this->form->render($theme, $page)
        ));
        return $template;
    }
}
