
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url();?>">Dashboard</a> <span class="divider"></span></li>
				<li>App User Detail</li>
			</ul>
		
			<div class="row">
				<div class="col-sm-6">
					<legend>User Information</legend>
					
					<table class="table table-striped table-bordered">
						<tr>
							<th>Username</th>
							<td><?php echo $appuser->username;?></td>
						</tr>
						<tr>
							<th>Email</th>
							<td><?php echo $appuser->email;?></td>
						</tr>
						<tr>
							<th>AboutMe</th>
							<td><?php echo $appuser->about_me;?></td>
						</tr>
					</table>
				</div>
				
				<div class="col-sm-6">
					
				</div>
			</div>
				
			<a class="btn btn-primary" href="<?php echo site_url('appusers');?>" class="btn">Back</a>

