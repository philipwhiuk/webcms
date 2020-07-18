<?php
class Form_Checkbox {
  function __construct($label, $id, $checked, $description) {
    $this->label = $label;
    $this->id = $id;
    $this->checked = $checked;
    $this->description = $description;
  }

  function render($theme, $page) {
    $templateClass = $theme->getTemplate("Form_Checkbox");
    $template = new $templateClass(array(
      'label' => $this->label,
      'id' => $this->id,
      'checked' => $this->checked,
      'description' => $this->description
    ));
    return $template;
  }
}
