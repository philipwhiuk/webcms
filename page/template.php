<?php
abstract class Page_Template extends Template {
  function getBlocks($blockType) {
    if (empty($this->data['blocks']) || empty($this->data['blocks'][$blockType])) {
      return array();
    } else {
      return $this->data['blocks'][$blockType];
    }
  }
}
