<?php
class Gallery_Block_Gallery_View {
  function __construct($gallery) {
    $this->gallery = $gallery;
    $this->items = Gallery_Item::getByGallery($gallery->id);
  }
  function render($theme, $page) {
      $templateClass = $theme->getTemplate("Gallery_Block_Gallery_View");
      $items = array();
      foreach ($this->items as $item) {
        $items[] = array('src' => $item->src);
      }
      $template = new $templateClass(array(
        'id' => $this->gallery->id,
        'items' => $items
      ));
      return $template;
  }
}
