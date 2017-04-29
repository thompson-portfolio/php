<?php 
$this->lang->load('upsell');

echo $this->template->load_view('header.php'); ?>

<div id="one_column_thin">
	<?php echo $this->template->load_view('branding.php'); ?>
		
		<div id="t-main">
			<div class="wrapper">
				<div id="page-upsell">

					<?php echo $this->template->load_view('errors'); ?>
					
					<img class="shadow" alt="<?php echo $this->lang->line('upsells_warning'); ?>" src="/resources/brainhost/img/lang/<?php echo $this->session->userdata('_language'); ?>/img-do-not-close.jpg"/>

					<?php echo $template['body']; ?>
					
				</div><!-- /page -->
			</div><!-- /wrapper -->
		</div><!-- /t-main -->
		
	<?php echo $this->template->load_view('footer.php'); ?>
</div>