<?php $this->load->view('partial/header');?>

<?php $this->load->view('partial/nav');?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2 sidebar teamps-sidebar">
			<?php $this->load->view('partial/sidebar');?>
		</div>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h2 class="page-header">Welcome, <?php echo $this->user->get_logged_in_user_info()->user_name;?>!</h2>
		 	
		 	<div class="row">
		  		<div class="col-sm-3">
		  			<a href="<?php  echo site_url('appusers') ?>">
			  			<span class="badge badge-important">
			  				<?php echo $this->appuser->count_all();?>
			  			</span>
			  			
			  			<div class="hero-widget">
			  				<div class="icon">
			  					<i class="glyphicon glyphicon-user"></i>
			  				</div>
			  				<div class="text">
			  					
			  					<label class="text-muted">Registered User Counts</label>
			  				</div>
			  			</div>
		  			</a>
		  		</div>
			  	<div class="col-sm-3">
			  		<a href="<?php  echo site_url('reviews') ?>">
			  		
				  		<span class="badge badge-important">
				  			<?php echo $this->review->count_all();?>
				  		</span>
				  		
				  		<div class="hero-widget">
				  			<div class="icon">
				  				<i class="glyphicon glyphicon-pencil"></i>
				  			</div>
				  			<div class="text">
				  				<label class="text-muted">Item Review Counts</label>
				  			</div>
				  		</div>
			  		
			  		</a>
			  	</div>
			  	<div class="col-sm-3">
			  		<a href="<?php  echo site_url('likes') ?>">
			  		
				  		<span class="badge badge-important">
				  			<?php echo $this->like->count_all();?>
				  		</span>
				  		
				  		<div class="hero-widget">
				  			
				  			<div class="icon">
				  				<i class="glyphicon glyphicon-thumbs-up"></i>
				  			</div>
				  			<div class="text">
				  				
				  				<label class="text-muted">Item Like Counts</label>
				  			</div>
				  		</div>
			  		
			  		</a>
			  	</div>
			  	<div class="col-sm-3">			  		
			  		<a href="<?php  echo site_url('inquiries') ?>">
				  		
				  		<span class="badge badge-important">
				  			<?php echo $this->inquiry->count_all();?>
				  		</span>
				  		
				  		<div class="hero-widget">
				  			<div class="icon">
				  				<i class="glyphicon glyphicon-envelope"></i>
				  			</div>
				  			<div class="text">
				  				
				  				<label class="text-muted">Inquiry Counts</label>
				  			</div>
				  		</div>
			  		</a>
			  	</div>
			  	
			  	
			  	
		  	</div>
			<hr/>
					  	
		  	<div class="row">
		  		<div class="col-md-6">
		  			<div class="panel panel-success">
		  				<div class="panel-heading clickable">
		  				
		  					<h3 class="panel-title">Latest Published Items</h3>
		  					<span class="pull-right "><i class="glyphicon glyphicon-minus"></i></span>
		  				</div>
		  				<table class='table table-condensed table-hover table-striped'>
		  					<?php 
		  						foreach($this->item->get_all(3)->result() as $item)
		  							echo "<tr><td>".$item->name.' - '.
		  								$this->category->get_info($item->cat_id)->name."</td></tr>";
		  					?>
		  					<tr>
		  						<td class="text-right"><a href='<?php echo site_url('items');?>'>View All</a></td>
		  					</tr>
		  				</table>
		  			</div>
		  		</div>
	       	
	          
	          <div class="col-md-6">
	          	<div class="panel panel-danger">
	          		<div class="panel-heading clickable">
	          			<h3 class="panel-title">Recent Inquiries</h3>
	          			<span class="pull-right "><i class="glyphicon glyphicon-minus"></i></span>
	          		</div>
	          		<table class='table table-condensed table-hover table-striped'>
	          		<?php 
	          			foreach($this->inquiry->get_all(3)->result() as $inquiry)
	          				echo '<tr><td>'.$inquiry->name.' inquires about '.
	          					$this->item->get_info($inquiry->item_id)->name.'</td></tr>';
	          		?>
	          			<tr>
	          				<td class="text-right"><a href='<?php echo site_url('inquiries');?>'>View All</a></td>
	          			</tr>
	          		</table>
	          	</div>
	          </div>
	          
	   	</div>
		   	
		   	<div class="row">
		   			<div class="col-md-6">
		   				<div class="panel panel-warning">
		   					<div class="panel-heading clickable">
		   						<h3 class="panel-title">Recent Likes</h3>
		   						<span class="pull-right "><i class="glyphicon glyphicon-minus"></i></span>
		   		     </div>
		   		     <table class='table table-condensed table-hover table-striped'>
		   		     <?php 
		   		     	foreach($this->like->get_all(3)->result() as $like)
		   		     		echo '<tr><td>'.$this->appuser->get_info($like->appuser_id)->username.' likes '.
		   		     			$this->item->get_info($like->item_id)->name.'</td></tr>';
		   		     ?>
			   		     <tr>
			   		     	<td class="text-right"><a href='<?php echo site_url('likes');?>'>View All</a></td>
			   		     </tr>
		   		     </table>
		   			</div>
		   		</div>
		   		
		   		<div class="col-md-6">
		   			<div class="panel panel-info">
		   				<div class="panel-heading clickable">
		   					<h3 class="panel-title">Recent Reviews</h3>
		   					<span class="pull-right "><i class="glyphicon glyphicon-minus"></i></span>
		   				</div>
		   				<table class='table table-condensed table-hover table-striped'>
		   				<?php 
		   					foreach($this->review->get_all(3)->result() as $review)
		   						echo '<tr><td>'.$this->appuser->get_info($review->appuser_id)->username.' reviews '.
		   							$this->item->get_info($review->item_id)->name.'</td></tr>';
		   				?>
		   		    		<tr>
		   		    			<td class="text-right"><a href='<?php echo site_url('reviews');?>'>View All</a></td>
		   		    		</tr>
		   				</table>
		   			</div>
		   		</div>
			     	
			 	</div>
			</div>
		</div>
	</div>

<?php $this->load->view('partial/footer');?>