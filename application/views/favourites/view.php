<div class='row'>
	<div class='col-sm-12'>
		<ul class="breadcrumb">
			<li>
				<a href="<?php echo site_url();?>">Dashboard</a> 
				<span class="divider"></span>
			</li>
			<li>Favourite List</li>
		</ul>
	</div>
</div>

<table class="table table-striped table-bordered">
	<tr>
		<th>No</th>
		<th>Item Name</th>
		<th>App User Name</th>
		<th>Date</th>
	</tr>
	<?php
		if(!$count=$this->uri->segment(3))
			$count = 0;
		if(isset($favourites) && count($favourites->result())>0):
			foreach($favourites->result() as $favourite):					
	?>
	<tr>
		<td><?php echo ++$count;?></td>
		<td><?php echo $this->item->get_info($favourite->item_id)->name;?></td>
		<td><?php echo $this->appuser->get_info($favourite->appuser_id)->username;?></td>
		<td><?php echo $favourite->added;?></td>
	</tr>
	<?php
		endforeach;
		else:
	?>
	<tr>
		<td colspan='5'>There is no data.</td>
	</tr>
	<?php
	endif;
	?>
</table>
<?php 
$this->pagination->initialize($pag);
echo $this->pagination->create_links();
?>
