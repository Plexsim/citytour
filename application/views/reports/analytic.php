			<?php
			$attributes = array('class' => 'form-inline','method' => 'POST');
			echo form_open(site_url('reports/analytic'), $attributes);
			?>
			  	<div class="form-group">
			  		<label> Choose Category </label>
			  		<select class="form-control" name="cat_id">
			  		<?php 
			  		foreach($this->category->get_all()->result() as $category){
			  			echo "<option value='".$category->id."'";
			  			if($cat_id == $category->id) echo " selected ";
			  			echo ">".$category->name."</option>";	
			  		}
			  		?>
			  		</select>
			  	</div>
			  	<button type="submit" class="btn btn-primary">Generate Report</button>
			<?php echo form_close(); ?>
			<?php if($count > 0):?>
				<div id="chart_div" style="height: 500px;width: 800px;"></div>
				<div id="piechart" style="height: 400px;width: 700px;"></div>
			<?php endif;?>
			
			<script type="text/javascript" src="https://www.google.com/jsapi"></script>
			<script type="text/javascript">
				google.load("visualization", "1", {packages:["corechart"]});
				google.setOnLoadCallback(drawGraphChart);
				google.setOnLoadCallback(drawPieChart);
				
				function drawGraphChart() {
					
					var data = google.visualization.arrayToDataTable(<?php echo $graph_items;?>);
					var options = {
						title: 'Total Touch Counts (All Items From ' + '<?php echo $cat_name;?>)',
						vAxis: {title: 'Items',  titleTextStyle: {color: 'red'}},
						colors:['#11ab9f']
					};
					var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
					chart.draw(data, options);
				}
				
				function drawPieChart() {
			     	
			     	var data = google.visualization.arrayToDataTable(<?php echo $pie_items;?>);
			     	var options = {
			       		title: 'Top 5 Popular Items From ' + '<?php echo $cat_name;?>'
			     	};
			
			     	var chart = new google.visualization.PieChart(document.getElementById('piechart'));
			     	chart.draw(data, options);
			   }
			</script>