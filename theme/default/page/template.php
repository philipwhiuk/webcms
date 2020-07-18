<?php
class Theme_Default_Page_Template extends Page_Template {
  function display() {
    ?>
<html>
  <head>
    <title><?php echo $this->data['title']; ?></title>
  </head>
  <body>
    <?php
    foreach ($this->getBlocks('page_header') as $block) {
      $block->display();
    }
    $this->data['main']->display();
    foreach ($this->getBlocks('page_footer') as $block) {
      $block->display();
    }
    ?>
  </body>
</html>
    <?php
  }
}
