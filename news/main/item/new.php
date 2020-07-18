<?php
class News_Main_Item_New extends Page_Renderable {
    function __construct() {
      $this->form = new Form();
      $this->form->id = 'news-new';
      $this->form->fields = array(
        new Form_TextField('Title', 'title', '', 'Enter title',
          array()),
        new Form_TextField('Publish Date', 'publish_date',
          date("d-m-Y H:i:s"), array()),
        new Form_TextArea('Intro', 'intro', ''),
        new Form_TextArea('Body', 'body', '')
      );
      $this->form->submitText = 'Add';
      $this->form->submitUrl = Site::getApiUrl("news","item/create");
      $this->form->finishText = 'Back to View';
      $this->form->finishUrl = Site::getPageUrl(Page::forModule('news'),'item/'.$this->news->id.'/view');
      $this->form->redirectOnSuccess = true;
      $this->form->redirectUrl = Site::getPageUrl(Page::forModule('news'),"list/view");
      $this->form->successFeedback = 'Added news article';
      $this->form->failureFeedback = 'Failed to add news article';
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate("News_Main_Item_New");
        $template = new $templateClass(array(
          'form' => $this->form->render($theme, $page)
        ));
        return $template;
    }
}
