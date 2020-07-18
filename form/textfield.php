<?php
class Form_TextField {
  function __construct($label, $id, $value, $placeholder, $extras = array()) {
    $this->label = $label;
    $this->id = $id;
    $this->value = $value;
    $this->placeholder = $placeholder;
    $this->extras = $extras;
  }

  function render($theme, $page) {
    $templateClass = $theme->getTemplate("Form_TextField");
    $template = new $templateClass(array(
      'label' => $this->label,
      'id' => $this->id,
      'value' => $this->value,
      'placeholder' => $this->placeholder,
      'extras' => $this->extras,
    ));
    return $template;
  }
}
