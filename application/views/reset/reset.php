<?php $this->load->view('partial/header');?>
	<div class='fluid-container'>
		<div class='row'>
			<div class='col-sm-4 col-sm-offset-3'>
	     		<?php
	     		$attributes = array('id' => 'login-form');
	     		echo form_open(site_url('reset/'.$code), $attributes);
	     		?>
					<h2>Reset Password</h2>
					<hr/>
					
					<!-- Message -->
					<?php if($this->session->flashdata('success')): ?>
						<div class="alert alert-success fade in">
							<?php echo $this->session->flashdata('success');?>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						</div>
					<?php elseif($this->session->flashdata('error')):?>
						<div class="alert alert-danger fade in">
							<?php echo $this->session->flashdata('error');?>
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						</div>
					<?php endif;?>
					
					<div class="form-group">
						<label>Password</label>
						<input class="form-control" type="password" id="password" placeholder="Password" name='password'>
					</div>
					
					<div class="form-group">
						<label>Confirm Password</label>
						<input class="form-control" type="password" id="conf_password" placeholder="Password" name='conf_password'>
					</div>
					
					<button class="btn btn-primary" type="submit">Submit</button>
				</form>
			</div>
		</div>
	</div>
	
	<script>
		$(document).ready(function(){
			$('#login-form').validate({
				rules:{
					password:{
						required: true,
						minlength: 4
					},
					conf_password:{
						required: true,
						equalTo: '#password'
					}
				},
				messages:{
					password:{
						required: "Please fill Password.",
						minlength: "Password must be greater than 4 characters."
					},
					conf_password:{
						required: "Please fill confirm password",
						equalTo: "Confirm Password do not match"
					}
				}
			});
		});
	</script>
	
<?php $this->load->view('partial/footer');?>