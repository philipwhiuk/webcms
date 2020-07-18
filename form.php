<?php
class Form {
  public $id;
  public $fields;
  public $submitText;
  public $submitUrl;
  public $redirectOnSuccess = false;
  public $redirectUrl = false;
  public $successFeedback;
  public $failureFeedback;
  public $finishUrl;
  public $finishText;

  function render($theme, $page) {
      $templateClass = $theme->getTemplate("Form");
      $fields = array();
      foreach ($this->fields as $field) {
        $fields[] = $field->render($theme, $page);
      }
      $template = new $templateClass(array(
        'id' => $this->id,
        'fields' => $fields,
        'submitText' => $this->submitText,
        'submitUrl' => $this->submitUrl,
        'redirectOnSuccess' => $this->redirectOnSuccess,
        'redirectUrl' => $this->redirectUrl,
        'successFeedback' => $this->successFeedback,
        'failureFeedback' => $this->failureFeedback,
        'finishUrl' => $this->finishUrl,
        'finishText' => $this->finishText
      ));
      return $template;
  }
}
