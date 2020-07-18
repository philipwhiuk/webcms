<?php
class Form_TextArea {
  function __construct($label, $id, $value) {
    $this->label = $label;
    $this->id = $id;
    $this->value = $value;
  }

  function render($theme, $page) {
    $templateClass = $theme->getTemplate("Form_TextArea");
    $template = new $templateClass(array(
      'label' => $this->label,
      'id' => $this->id,
      'value' => $this->value
    ), $page);
    return $template;
  }
}
