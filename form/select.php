<?php
class Form_Select {
  function __construct($label, $id, $value, $placeholder, $options = array()) {
    $this->label = $label;
    $this->id = $id;
    $this->value = $value;
    $this->placeholder = $placeholder;
    $this->options = $options;
  }

  function render($theme, $page) {
    $templateClass = $theme->getTemplate("Form_Select");
    $template = new $templateClass(array(
      'label' => $this->label,
      'id' => $this->id,
      'value' => $this->value,
      'placeholder' => $this->placeholder,
      'options' => $this->options,
    ));
    return $template;
  }
}
