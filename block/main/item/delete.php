<?php
class Block_Main_Item_Delete extends Page_Renderable {
    function __construct($block) {
      $this->block = $block;
    }
    function render($theme, $page) {
        $templateClass = $theme->getTemplate('News_Main_Item_Delete');
        $template = new $templateClass(array(
          'id' => $this->block->id,
          'title' => $this->block->title,
          'apiDeleteUrl' => Site::getApiUrl('block','item/'.$this->block->id.'/delete'),
          'viewUrl' => Site::getPageUrl(Page::forModule('block'),'item/'.$this->block->id.'/view'),
          'editUrl' => Site::getPageUrl(Page::forModule('block'),'item/'.$this->block->id.'/edit')
        ));
        return $template;
    }
}
