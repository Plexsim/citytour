
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url();?>">Dashboard</a> <span class="divider"></span></li>
				<li><a href="<?php echo site_url('items');?>">Item List</a> <span class="divider"></span></li>
				<li>Update Item</li>
			</ul>
		
			<?php
			$attributes = array('id' => 'item-form','enctype' => 'multipart/form-data');
			echo form_open(site_url("items/edit/".$item->id), $attributes);
			?>
			
				<legend>Item Information</legend>
					
				<div class="row">
					<div class="col-sm-6">
							<div class="form-group">
								<label>Item Name</label>
								<input class="form-control" type="text" placeholder="Item Name" name='name' id='name'
								 value="<?php echo $item->name;?>">
							</div>
							
							<div class="form-group">
								<label>Category</label>
								<select class="form-control" name="cat_id">
								<?php
									foreach($this->category->get_all()->result() as $cat){
										echo "<option value='".$cat->id."'";
										if($item->cat_id == $cat->id) 
											echo " selected ";
										echo ">".$cat->name."</option>";
									}
								?>
								</select>
							</div>
							
							<div class="form-group">
								<label>Description</label>
								<textarea class="form-control" name="description" placeholder="Description" rows="8"><?php echo $item->description;?></textarea>
							</div>
						</div>
						<div class="col-sm-6">
							
							<div class="form-group">
								<label><input type="checkbox" name="isOnHomePage" value="1" <?php if($item->isOnHomePage == 1) echo "checked";?> >&nbsp;&nbsp;Show on Home Page</label>
							</div>
							
							<div class="form-group">
								<label>Phone</label>
								<input class="form-control" type="text" name="phone" placeholder="Phone" 
								value="<?php echo $item->phone;?>"/>
							</div>
							
							<div class="form-group">
								<label>Address</label>
								<textarea class="form-control" name="address" placeholder="Address" rows="6"><?php echo $item->address;?></textarea>
							</div>
							
							<div class="form-group">
								<label>Location</label>
								<input class="form-control" type="text" name="coordinate" placeholder="Location" value="<?php echo $item->coordinate; ?>"/>
							</div>
					</div>
				</div>
				
				<input type="submit" value="Update" class="btn btn-primary"/>
				<a class="btn btn-success" href="<?php echo site_url('items/gallery/'.$item->id);?>">Go to Gallery</a>
				<a href="<?php echo site_url('items');?>">Cancel</a>
			</form>

			<script>
				$(document).ready(function(){
					$('#item-form').validate({
						rules:{
							name:{
								required: true,
								minlength: 4,
								remote: '<?php echo site_url('items/exists/'.$item->id);?>'
							}
						},
						messages:{
							name:{
								required: "Please fill item name.",
								minlength: "The length of item name must be greater than 4",
								remote: "item name is already existed in the system"
							}
						}
					});
				});
			</script>

