  <?php
class News_Main_List_View extends Page_Renderable {
  function __construct($items) {
    $this->items = $items;
  }

  function render($theme, $page) {
      $items = array();
      foreach ($this->items as $item) {
        $items[] = array(
          'title' => $item->title,
          'intro' => $item->intro,
          'viewUrl' => Site::getPageUrl(Page::forModule("news"),"item/".$item->id."/view")
        );
      }
      $templateClass = $theme->getTemplate("News_Main_List_View");
      $template = new $templateClass(array(
        'items' => $items,
        'adminUrl' => Site::getPageUrl(Page::forModule("news"),"list/admin")
      ));
      return $template;
  }
}
