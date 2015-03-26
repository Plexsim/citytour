
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url();?>">Dashboard</a> <span class="divider"></span></li>
				<li>Update Profile</li>
			</ul>
			
			<?php
			$attributes = array('id' => 'user-form');
			echo form_open(site_url('profile'), $attributes);
			?>
				<div class="row">
					<div class="col-sm-6">
						<legend>User Information</legend>
						
						<!-- Message -->
						<?php if($status == 'success'): ?>
							<div class="alert alert-success fade in">
								<?php echo $message;?>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							</div>
						<?php elseif($status == 'error'):?>
							<div class="alert alert-danger fade in">
								<?php echo $message;?>
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							</div>
						<?php endif;?>
						
						<div class="form-group">
							<label>Username</label>
							<input class="form-control" type="text" placeholder="username" name='user_name' id='user_name' value='<?php echo $user->user_name;?>'>
						</div>
						
						<div class="form-group">
							<label>Email</label>
							<input class="form-control" type="text" placeholder="email" name='user_email' id='user_email' value='<?php echo $user->user_email;?>'>
						</div>
						
						<div class="form-group">
							<label>Password</label>
							<input class="form-control" type="password" placeholder="password" name='user_password' id='user_password'>
						</div>
									
						<div class="form-group">
							<label>Confirm Password</label>
							<input class="form-control" type="password" placeholder="confirm password" name='conf_password' id='conf_password'>
						</div>
					</div>
					
					<div class="col-sm-6">
						
					</div>
				</div>
							
				
				<hr/>
				
				<button type="submit" class="btn btn-primary">Submit</button>
				<a href="<?php echo site_url('dashboard');?>" class="btn">Cancel</a>
			</form>
		
			<script>
				$(document).ready(function(){
					$('#user-form').validate({
						rules:{
							user_name:{
								required: true,
								minlength: 4,
								remote: '<?php echo site_url('dashboard/exists/'.$user->user_id);?>'
							},
							user_password:{
								minlength: 4
							},
							conf_password:{
								equalTo: '#user_password'
							}
						},
						messages:{
							user_name:{
								required: "Please fill user name.",
								minlength: "The length of username must be greater than 4",
								remote: "Username is already existed in the system"
							},
							user_password:{
								minlength: "The length of password must be greater than 4"
							},
							conf_password:{
								equalTo: "Password and confirm password do not match."
							}
						}
					});
				});
			</script>

