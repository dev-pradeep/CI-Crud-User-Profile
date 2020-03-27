<?php
	$dt['title']=(isset($title) && $title) ? $this->config->item('applicationName')." | ".$title : $this->config->item('applicationName');
	$this->load->view('includes/header',$dt);
?>
<?php if(isset($main_content) && $main_content):?>
	<?php $this->load->view($main_content); ?>
<?php endif; ?>