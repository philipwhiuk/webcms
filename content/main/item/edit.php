<?php
class Content_Main_Item_Edit extends Page_Renderable {
    function __construct($content) {
      $this->content = $content;
      $this->form = new Form();
      $this->form->id = 'content-edit-'.$this->content->id;
      $this->form->fields = array(
        new Form_TextField('Title', 'title', $this->content->title, 'Enter title',
          array()),
        new Form_Checkbox('Show title', 'showTitle', $this->content->showTitle != 0, 'Whether to show the title
          when using the content as the main item on the page.'),
        new Form_TextArea('Text', 'text', $this->content->text)
      );
      $this->form->submitText = 'Save';
      $this->form->submitUrl = Site::getApiUrl('content','item/'.$this->content->id.'/update');
      $this->form->finishText = 'Back to View';
      $this->form->finishUrl = Site::getPageUrl(Page::forModule('content'),'item/'.$this->content->id.'/view');
      $this->form->redirectOnSuccess = false;
      $this->form->successFeedback = 'Updated content';
      $this->form->failureFeedback = 'Failed to update content';
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate('Content_Main_Item_Edit');
        $template = new $templateClass(array(
          'form' => $this->form->render($theme, $page)
        ));
        return $template;
    }
}
