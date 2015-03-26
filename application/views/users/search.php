
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url();?>">Dashboard</a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('users');?>">Users List</a><span class="divider"></span></li>
				<li>Search Results</li>
			</ul>
			
			<div class='row'>
				<div class='col-sm-9'>
					<?php
					$attributes = array('class' => 'form-inline');
					echo form_open(site_url('users/search'), $attributes);
					?>
						<div class="form-group">
					   	<input type="text" name="searchterm" class="form-control" placeholder="Search" 
					   	value="<?php echo $searchterm;?>">
					  	</div>
					  	<button type="submit" class="btn btn-default">Search</button>
					  	<a href='<?php echo site_url('users');?>' class="btn btn-default">Reset</a>
					</form>  
				</div>	
				<div class='col-sm-3'>
					<a href='<?php echo site_url('users/add');?>' class='btn btn-primary pull-right'><span class='glyphicon glyphicon-plus'></span> Add New User</a>
				</div>
			</div>
			
			<br/>
			
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
			
			<table class="table table-striped table-bordered">
				<tr>
					<th>No</th>
					<th>Username</th>
					<th>Email</th>
					<th>User Role</th>
					<?php if(in_array('edit',$allowed_accesses)):?>
						<th>Edit</th>
					<?php endif;?>
					<!--
					<?php if(in_array('delete',$allowed_accesses)):?>
						<th>Delete</th>
					<?php endif;?>-->
				</tr>
				<?php
					if(!$count=$this->uri->segment(3))
						$count = 0;
					if(isset($users) && count($users->result())>0):
						foreach($users->result() as $user):					
				?>
						<tr>
							<td><?php echo ++$count;?></td>
							<td><?php echo $user->user_name;?></td>
							<td><?php echo $user->user_email;?></td>
							<td><?php echo $this->role->get_name($user->role_id);?></td>
							
							<?php if(in_array('edit',$allowed_accesses)):?>
								<td><a href='<?php echo site_url("users/edit/".$user->user_id);?>'><i class='glyphicon glyphicon-edit'></i></a></td>
							<?php endif;?>
							
							<!--
							<?php if(in_array('delete',$allowed_accesses)):?>
								<td><a href='<?php echo site_url("users/delete/".$user->user_id);?>'><i class='glyphicon glyphicon-trash'></i></a></td>
							<?php endif;?>
							-->
						</tr>
						<?php
						endforeach;
					else:
				?>
						<tr>
							<td colspan='7'>There is no data.</td>
						</tr>
				<?php
					endif;
				?>
			</table>
			
			<?php 
				$this->pagination->initialize($pag);
				echo $this->pagination->create_links();
			?>

