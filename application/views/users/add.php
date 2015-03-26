
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url();?>">Dashboard</a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('users');?>">User List</a> <span class="divider"></span></li>
				<li>Add new user</li>
			</ul>
			
			<?php
			$attributes = array('id' => 'user-form');
			echo form_open(site_url('users/add'), $attributes);
			?>
				<legend>User Information</legend>
					
				<div class="row">
					<div class="col-sm-6">
							<div class="form-group">
								<label>Username</label>
								<input class="form-control" type="text" placeholder="username" name='user_name' id='user_name'>
							</div>
							
							<div class="form-group">
								<label>Email</label>
								<input class="form-control" type="text" placeholder="email" name='user_email' id='user_email'>
							</div>
							
							<div class="form-group">
								<label>Password</label>
								<input class="form-control" type="password" placeholder="password" name='user_password' id='user_password'>
							</div>
										
							<div class="form-group">
								<label>Confirm Password</label>
								<input class="form-control" type="password" placeholder="confirm password" name='conf_password' id='conf_password'>
							</div>
							
							<div class="form-group">
								<label>User Role</label>
								<select class="form-control" name='role_id' id='role_id'>
									<?php
										foreach($this->role->get_all()->result() as $role)
											echo "<option value='".$role->role_id."'>".$role->role_desc."</option>";
									?>
								</select>
							</div>
					</div>
					
					<div class="col-sm-6">
						<div class="form-group">
							<label>Allowed Modules</label>
							<?php
								foreach($this->module->get_all()->result() as $module)
									echo "<label class='checkbox'><input type='checkbox' name='permissions[]' value='".$module->module_id."'>".$module->module_desc."</label><br/>";
							?>
						</div>
					</div>
				</div>
				
				<hr/>
				
				<button type="submit" class="btn btn-primary">Submit</button>
				<a href="<?php echo site_url('users');?>" class="btn">Cancel</a>
			</form>

			<script>
			$(document).ready(function(){
				$('#user-form').validate({
					rules:{
						user_name:{
							required: true,
							minlength: 4,
							remote: '<?php echo site_url("users/exists");?>'
						},
						user_email:{
							required: true,
							email: true
						},
						user_password:{
							required: true,
							minlength: 4
						},
						conf_password:{
							required: true,
							equalTo: '#user_password'
						}
					},
					messages:{
						user_name:{
							required: "Please fill user name.",
							minlength: "The length of username must be greater than 4",
							remote: "Username is already existed in the system"
						},
						user_email:{
							required: "Please fill email address",
							email: "Please provide valid email address"
						},
						user_password:{
							required: "Please fill user password.",
							minlength: "The length of password must be greater than 4"
						},
						conf_password:{
							required: "Please fill confirm password",
							equalTo: "Password and confirm password do not match."
						}
					}
				});
			});
		</script>

