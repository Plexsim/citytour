<ul class="nav nav-sidebar">
  <li class="active">
			<a href="<?php echo site_url('dashboard');?>">
				<span class="glyphicon glyphicon-home"></span>
				Dashboard
			</a></li>
 

  
</ul>
<ul class="nav nav-sidebar">
	<?php
		
		
	
		foreach($allowed_modules->result() as $module){
		//print_r($module->module_icon);
			echo "<li><a href='".site_url($module->module_name)."'><span class='".$module->module_icon."'></span>".
					$module->module_desc."</a></li>";
		}
	?>
	
	<li><a href="<?php echo site_url('backup');?>">
			<span class="glyphicon glyphicon-export"></span>
			Exports</a></li>	
</ul>
<ul class="nav nav-sidebar">
  <li><a href="http://www.panacea-soft.com/"><span class="glyphicon glyphicon-copyright-mark"></span>CityTour 2014</a></li>
</ul>
