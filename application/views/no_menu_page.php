<?php
	$dt['title']=(isset($title) && $title)?$title." | ".$this->config->item('applicationName'):$this->config->item('applicationName');
	$this->load->view('includes/header',$dt);
?>
<?php if(isset($main_content) && $main_content):?>
	<?php $this->load->view($main_content); ?>
<?php endif; ?>
<?php $this->load->view('includes/footer'); ?>