<?php
class Theme_Default_Content_Main_List_View_Template extends Template {
    function display() {
?>
<div class="content-list-view">
  <ul>
    <?php foreach ($this->data['items'] as $item) { ?>
       <li class="content-list-item"><?php echo $item->title; ?></li>
    <?php } ?>
  </ul>
</div>
<?php
    }
}
