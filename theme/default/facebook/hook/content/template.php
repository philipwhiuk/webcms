<?php
class Theme_Default_Facebook_Hook_Content_Template extends Template {
  function registerPageData($page) {
      $page->registerHeadElements(
        '<meta property="og:url" content="'.$this->data['url'].'" />'.
        '<meta property="og:type" content="website" />'.
        '<meta property="og:title" content="'.$this->data['title'].'" />');

      $page->registerBodyElements('
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous"
          src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&autoLogAppEvents=1&version=v7.0&appId='
          .$this->data['appId'].'" nonce="eeGApg4L"></script>');
  }

  function display() {
    ?>
    <div class="fb-share-button"
      data-href="<?php echo $this->data['url']; ?>"
      data-layout="button" data-size="small"><a target="_blank"
      href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $this->data['encodedUrl']; ?>&amp;src=sdkpreparse"
      class="fb-xfbml-parse-ignore">Share</a></div>
    <?php
  }
}
