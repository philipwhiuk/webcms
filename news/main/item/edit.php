<?php
class News_Main_Item_Edit extends Page_Renderable {
    function __construct($news) {
      $this->news = $news;
      $this->form = new Form();
      $this->form->id = 'news-edit-'.$this->news->id;
      $this->form->fields = array(
        new Form_TextField('Title', 'title', $this->news->title, 'Enter title',
          array()),
        new Form_TextField('Publish Date', 'publish_date',
          date("d-m-Y H:i:s", $this->news->publish_date), array()),
        new Form_TextArea('Intro', 'intro', $this->news->intro),
        new Form_TextArea('Body', 'body', $this->news->body)
      );
      $this->form->submitText = 'Save';
      $this->form->submitUrl = Site::getApiUrl('news','item/'.$this->news->id.'/update');
      $this->form->finishText = 'Back to View';
      $this->form->finishUrl = Site::getPageUrl(Page::forModule('news'),'item/'.$this->news->id.'/view');
      $this->form->redirectOnSuccess = false;
      $this->form->successFeedback = 'Updated news article';
      $this->form->failureFeedback = 'Failed to update news article';
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate('News_Main_Item_Edit');
        $template = new $templateClass(array(
          'form' => $this->form->render($theme, $page)
        ));
        return $template;
    }
}
