<?php
class Block_Main_Item_New extends Page_Renderable {
    function __construct() {
      $modules = array();
      $moduleObjs = Module::getAllLoaded();
      foreach ($moduleObjs as $module) {
        $modules[$module->name] = $module->name;
      }
      
      $this->form = new Form();
      $this->form->id = 'block-new';
      $this->form->fields = array(
        new Form_TextField('Title', 'title', '', 'Enter title',
          array()),
          new Form_Select('Module', 'module', $this->block->module, 'Select module',
            $modules),
        new Form_TextField('Action', 'action', '', 'Select action',
          array()),
        new Form_TextField('Location', 'location', '', 'Select location',
          array()),
        new Form_Select('Visibility', 'visibility', $this->block->visibility, 'Select visibility',
          Block::$VISIBILITY_OPTIONS)
      );
      $this->form->submitText = 'Add';
      $this->form->submitUrl = Site::getApiUrl("block","item/create");
      $this->form->redirectOnSuccess = true;
      $this->form->redirectUrl = Site::getPageUrl(Page::forModule("block"),"list/view");
      $this->form->successFeedback = 'Added block';
      $this->form->failureFeedback = 'Failed to add block';
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("Block_Main_Item_New");
        $template = new $templateClass(array(
          'form' => $this->form->render($theme, $page)
        ));
        return $template;
    }
}
