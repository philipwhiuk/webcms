<?php
class Theme_Default_Error_Main_View_Template extends Template {
    function display() {
?>
<div class="error-view">
	<div class="error-title">An Error Has Occurred</div>
	<div class="error">
    <?php if ($this->data['error_code'] != null && $this->data['trace'] == null) { ?>
      Sorry. An error has occurred. You may want to contact the site owner.
    <?php } ?>
    <?php if ($this->data['error_code'] != null) { ?>
      <div><span class="error-code-title">Error Code:</span> <?php echo $this->data['error_code']; ?>
    <?php } ?>
    <?php if ($this->data['trace'] != null) { ?>
      <div><span class="error-trace-title">Stack Trace:</span> <pre>
<?php echo $this->data['trace']; ?>
</pre></div>
    <?php } ?>
  </div>
</div>
<?php
    }
}
