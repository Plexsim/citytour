
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url();?>">Dashboard</a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('feeds');?>">Feeds List</a> <span class="divider"></span></li>
				<li>Update Feed</li>
			</ul>
			
			<?php
			$attributes = array('id' => 'feed-form','enctype' => 'multipart/form-data');
			echo form_open(site_url("feeds/edit/".$feed->id), $attributes);
			?>
				<legend>News Feed Information</legend>
				
				<div class="row">
					<div class="col-sm-8">
						<div class="form-group">
							<label>Title</label>
							<input class="form-control" type="text" placeholder="title" name='title' id='title'
							 value="<?php echo $feed->title;?>">
						</div>
						
						<div class="form-group">
							<label>Description</label>
							<textarea class="form-control" name="description" placeholder="Description" rows="9"><?php echo $feed->description;?></textarea>
						</div>
						
						<input type="submit" value="Update" class="btn btn-primary"/>
						<a class="btn btn-success" href="<?php echo site_url('feeds/gallery/'.$feed->id);?>">Go to Gallery</a>
						<a href="<?php echo site_url('feeds');?>" class="btn">Cancel</a>
					</div>
				</div>
			</form>
						
			<script>
				$(document).ready(function(){
					$('#feed-form').validate({
						rules:{
							title:{
								required: true,
								minlength: 4
							}
						},
						messages:{
							name:{
								required: "Please fill feed name.",
								minlength: "The length of feed name must be greater than 4"
							}
						}
					});				
				});
			</script>

