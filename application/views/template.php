<?php $this->load->view('partial/header');?>

<?php $this->load->view('partial/nav');?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2 sidebar teamps-sidebar">
			<?php $this->load->view('partial/sidebar');?>
		</div>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		
		<?php echo $content;?>
		
		</div>
	</div>
</div>

<?php $this->load->view('partial/footer');?>