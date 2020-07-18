  <?php
class Content_Main_List_View extends Page_Renderable {
  function __construct($items) {
    $this->items = $items;
  }

  function render($theme, $page) {
      $items = array();
      foreach ($this->items as $item) {
        $items[] = array(
          'title' => $item->title,
          'viewUrl' => Site::getPageUrl(Page::forModule("content"),"item/".$item->id."/view")
        );
      }
      $templateClass = $theme->getTemplate("Content_Main_List_View");
      $template = new $templateClass(array(
        'items' => $items,
        'adminUrl' => Site::getPageUrl(Page::forModule("content"),"list/admin")
      ));
      return $template;
  }
}
