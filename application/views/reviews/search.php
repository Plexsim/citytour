			<ul class="breadcrumb">
				<li>
					<a href="<?php echo site_url();?>">Dashboard</a> 
					<span class="divider"></span>
				</li>
				<li>
					<a href="<?php echo site_url('reviews');?>">Review List</a>
					<span class="divider"></span>
				</li>
				<li>Search Results</li>
			</ul>
			
			<?php
			$attributes = array('class' => 'form-inline','method' => 'POST');
			echo form_open(site_url('reviews/search'), $attributes);
			?>
			
				<div class="form-group">
			   		<input type="text" name="searchterm" class="form-control" placeholder="Search">
			  	</div>
			  	
			  	<button type="submit" class="btn btn-default">Search</button>
			  	<a href='<?php echo site_url('reviews');?>' class="btn btn-default">Reset</a>
			<?php echo form_close(); ?>
			
			<br/>
			
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
					<th>Item Name</th>
					<th>App User Name</th>
					<th>Date</th>
					<th>Detail</th>
					
					<?php if(in_array('delete',$allowed_accesses)):?>
					<th>Delete</th>
					<?php endif;?>
				</tr>
				<?php
					if(!$count=$this->uri->segment(3))
						$count = 0;
					if(isset($reviews) && count($reviews->result())>0):
						foreach($reviews->result() as $review):					
				?>
				<tr>
					<td><?php echo ++$count;?></td>
					<td><?php echo $this->item->get_info($review->item_id)->name;?></td>
					<td><?php echo $this->appuser->get_info($review->appuser_id)->username;?></td>
					<td><?php echo $review->added;?></td>
					<td><a href='<?php echo site_url('reviews/detail/'.$review->id);?>'>Detail</a></td>
					
					<?php if(in_array('delete',$allowed_accesses)):?>
					<td><a href='<?php echo site_url("reviews/delete/".$review->id);?>'><i class='glyphicon glyphicon-trash'></i></a></td>
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
			
