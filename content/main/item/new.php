<?php
class Content_Main_Item_New extends Page_Renderable {
  function __construct() {
    $this->form = new Form();
    $this->form->id = 'content-new';
    $this->form->fields = array(
      new Form_TextField('Title', 'title', '', 'Enter title',
        array()),
      new Form_Checkbox('Show title', 'showTitle', true, 'Whether to show the title
        when using the content as the main item on the page.'),
      new Form_TextArea('Text', 'text', '')
    );
    $this->form->submitText = 'Add';
    $this->form->submitUrl = Site::getApiUrl("content","item/create");
    $this->form->finishText = 'Back to View';
    $this->form->finishUrl = Site::getPageUrl(Page::forModule('content'),'item/'.$this->content->id.'/view');
    $this->form->redirectOnSuccess = true;
    $this->form->redirectUrl = Site::getPageUrl(Page::forModule('content'),"list/view");
    $this->form->successFeedback = 'Added content';
    $this->form->failureFeedback = 'Failed to add content';
  }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("Content_Main_Item_New");
        $template = new $templateClass(array(
          'form' => $this->form->render($theme, $page)
        ));
        return $template;
    }
}
