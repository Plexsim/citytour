			<ul class="breadcrumb">
				<li>
					<a href="<?php echo site_url();?>">Dashboard</a> 
					<span class="divider"></span>
				</li>
				<li>Inquiry Information</li>
			</ul>
			
			<div class="row">
				<div class="col-sm-6">
					<legend>Inquiry Information</legend>
					<table class="table table-striped table-bordered">
						<tr>
							<th>Item Name</th>
							<td><?php echo $this->item->get_info($inquiry->item_id)->name;?></td>
						</tr>
						<tr>
							<th>Name</th>
							<td><?php echo $inquiry->name;?></td>
						</tr>
						<tr>
							<th>Email</th>
							<td><?php echo $inquiry->email;?></td>
						</tr>
						<tr>
							<th>Message</th>
							<td><?php echo $inquiry->message;?></td>
						</tr>
					</table>
				</div>
			</div>
				
			<a class="btn btn-primary" href="<?php echo site_url('inquiries');?>" class="btn">Back</a>
