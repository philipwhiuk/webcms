<?php
class Theme_Default_Content_Main_Item_View_Template extends Template {
    function display() {
?>
<div class="content-view">
	<div class="content-title"><?php echo $this->data['title']; ?></div>
	<div class="content"><?php echo $this->data['text']; ?></div>
  <?php
    foreach ($this->data['shareHooks'] as $hook) {
      $hook->display();
    }
  ?>
</div>
<?php
    }
}
