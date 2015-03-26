
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url();?>">Dashboard</a> <span class="divider"></span></li>
				<li>App User List</li>
			</ul>
			
			<?php
			$attributes = array('class' => 'form-inline');
			echo form_open(site_url('appusers/search'),$attributes);
			?>
				<div class="form-group">
			   	<input type="text" name="searchterm" class="form-control" placeholder="Search">
			  	</div>
			  	<button type="submit" class="btn btn-default">Search</button>
			</form>
			
			<br/>
			
			<table class="table table-striped table-bordered">
				<tr>
					<th>No</th>
					<th>Username</th>
					<th>Email</th>
					<th>Detail</th>
					<?php if(in_array('ban',$allowed_accesses)):?>
						<th>Ban</th>
					<?php endif;?>
				</tr>
				<?php
					if(!$count=$this->uri->segment(3))
						$count = 0;
					if(isset($appusers) && count($appusers->result())>0):
						foreach($appusers->result() as $appuser):					
				?>
						<tr>
							<td><?php echo ++$count;?></td>
							<td><?php echo $appuser->username;?></td>
							<td><?php echo $appuser->email;?></td>
							<td><a href='<?php echo site_url('appusers/detail/'.$appuser->id);?>'>Detail</a></td>
							<?php if(in_array('ban',$allowed_accesses)):?>
							<td>
								<?php if($appuser->is_banned == 1):?><button class="btn btn-sm btn-danger unban" 
									appuserid='<?php echo $appuser->id;?>'>Unban</button>
								<?php else:?><button class="btn btn-sm btn-primary ban" 
								   appuserid='<?php echo $appuser->id;?>'>Ban</button><?php endif;?>
							</td>
							<?php endif;?>
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

<script>
$(document).ready(function(){
	$(document).delegate('.ban','click',function(){
		var btn = $(this);
		var id = $(this).attr('appuserid');
		$.ajax({
			url: '<?php echo site_url('appusers/ban');?>/'+id,
			method:'GET',
			success:function(msg){
				if(msg == 'true')
					btn.addClass('unban').addClass('btn-danger').removeClass('btn-primary').removeClass('ban').html('Unban');
				else
					alert('System error occured. Please contact your system administrator.');
			}
		});
	});
	
	$(document).delegate('.unban','click',function(){
		var btn = $(this);
		var id = $(this).attr('appuserid');
		$.ajax({
			url: '<?php echo site_url('appusers/unban');?>/'+id,
			method:'GET',
			success:function(msg){
				if(msg == 'true')
					btn.addClass('ban').addClass('btn-primary').removeClass('btn-danger').removeClass('unban').html('Ban');
				else
					alert('System error occured. Please contact your system administrator.');
			}
		})
	});
});
</script>

