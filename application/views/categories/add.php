
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url();?>">Dashboard</a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('categories');?>">Category List</a> <span class="divider"></span></li>
				<li>Add new category</li>
			</ul>
			
			<?php
				$attributes = array('id' => 'category-form');
				echo form_open(site_url('categories/add'), $attributes);
			?>
				<legend>Category Information</legend>
					
				<div class="row">
					<div class="col-sm-6">
							<div class="form-group">
								<label>Category Name</label>
								<input class="form-control" type="text" placeholder="Category Name" name='name' id='name'>
							</div>
							<div class="form-group">
								<label>Ordering</label>
								<input class="form-control" type="text" placeholder="Ordering" name='ordering' id='ordering'>
							</div>
					</div>
				</div>
				
				<hr/>
				
				<button type="submit" class="btn btn-primary">Submit</button>
				<a href="<?php echo site_url('categories');?>" class="btn">Cancel</a>
			</form>

			<script>
				$(document).ready(function(){
					$('#category-form').validate({
						rules:{
							name:{
								required: true,
								minlength: 4,
								remote: '<?php echo site_url("categories/exists");?>'
							}
						},
						messages:{
							name:{
								required: "Please fill Category Name.",
								minlength: "The length of Category Name must be greater than 4",
								remote: "Category Name is already existed in the system"
							}
						}
					});
				});
			</script>
