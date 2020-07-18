  <?php
class Gallery_Main_List_View extends Page_Renderable {
  function __construct($gallerys) {
    $this->gallerys = $gallerys;
  }

  function render($theme, $page) {
      $gallerys = array();
      foreach ($this->gallerys as $gallery) {
        $gallerys[] = array(
          'title' => $gallery->title,
          'viewUrl' => Site::getPageUrl(Page::forModule("gallery"),"gallery/".$gallery->id."/view")
        );
      }
      $templateClass = $theme->getTemplate("Gallery_Main_List_View");
      $template = new $templateClass(array(
        'gallerys' => $gallerys,
        'adminUrl' => Site::getPageUrl(Page::forModule("gallery"),"list/admin")
      ));
      return $template;
  }
}
