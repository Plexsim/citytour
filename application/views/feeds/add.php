
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url();?>">Dashboard</a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('feeds');?>">News Feeds List</a> <span class="divider"></span></li>
				<li>Add New feed</li>
			</ul>
			
			<?php
			$attributes = array('id' => 'feed-form','enctype' => 'multipart/form-data');
			echo form_open(site_url('feeds/add'), $attributes);
			?>
				<legend>News Feed Information</legend>
				
				<div class="row">
					<div class="col-sm-8">
							<div class="form-group">
								<label>Title</label>
								<input class="form-control" type="text" placeholder="Title" name='title' id='title'>
							</div>
							
							<div class="form-group">
								<label>Description</label>
								<textarea class="form-control" name="description" placeholder="Description" rows="9"></textarea>
							</div>
					</div>
				</div>
				
				<hr/>
				
				<input type="submit" name="save" value="Save" class="btn btn-primary"/>
				<input type="submit" name="gallery" value="Save and Go to Gallery" class="btn btn-success"/>
				<a href="<?php echo site_url('feeds');?>" class="btn">Cancel</a>
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
						title:{
							required: "Please fill title.",
							minlength: "The length of title must be greater than 4"
						}
					}
				});
			});
			</script>

