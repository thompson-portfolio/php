<?php echo $this->template->load_view('head.php'); ?>

<div id="one_column">

	<div id="container-main">

		<div id="container">

			<?php echo $this->template->load_view('header.php'); ?>
			
			<!--Content-->
			<div id="content">

				<div class="content">

					<?php echo $template['body']; ?>
					
				</div><!-- #content END-->
				
			</div>
			
		</div><!-- #container-->

	</div><!-- #container main END-->


	  
	<div class="clear"></div>

</div>

<?php echo $this->template->load_view('footer.php');