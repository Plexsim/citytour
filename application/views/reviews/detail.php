			<ul class="breadcrumb">
				<li>
					<a href="<?php echo site_url();?>">Dashboard</a> 
					<span class="divider"></span>
				</li>
				<li>Review Information</li>
			</ul>
			
			<div class="row">
				<div class="col-sm-6">
					<legend>Review Information</legend>
					
					<table class="table table-striped table-bordered">
						<tr>
							<th>Item Name</th>
							<td><?php echo $this->item->get_info($review->item_id)->name;?></td>
						</tr>
						<tr>
							<th>App User Name</th>
							<td><?php echo $this->appuser->get_info($review->appuser_id)->username;?></td>
						</tr>
						<tr>
							<th>Review</th>
							<td><?php echo $review->review;?></td>
						</tr>
					</table>
				</div>
			</div>
				
			<a class="btn btn-primary" href="<?php echo site_url('reviews');?>" class="btn">Back</a>
			
