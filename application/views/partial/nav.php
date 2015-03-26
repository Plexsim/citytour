<div class="navbar navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo base_url()?>">	
				<img src="<?php echo base_url('img/be_logo.png');?>" width="25"/>
				CityTour
			</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						Account
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li>
							<div class="navbar-content">
								<div class="row">
									<div class="col-md-5">
										<img src="<?php echo base_url('img/fokhwar.png');?>" alt="Alternate Text" class="img-responsive"/>
										<!--<p class="text-center small">
											<a href="#">Change Photo</a>
										</p>-->
									</div>
									<div class="col-md-7">
										<?php $logged_in_user = $this->user->get_logged_in_user_info();?>
										<span><?php echo $logged_in_user->user_name;?></span>
										<p class="text-muted small"><?php echo $this->role->get_name($logged_in_user->role_id);?></p>
										<div class="divider"></div>
										<a href="<?php echo site_url('profile');?>" class="btn btn-primary btn-sm active">Edit Profile</a>
									</div>
								</div>
							</div>
							<div class="navbar-footer">
								<div class="navbar-footer-content">
									<div class="row">
										<div class="col-md-6">
											<a href="#" class="btn btn-default btn-sm">Change Passowrd</a>
										</div>
										<div class="col-md-6">
											<a href="<?php echo site_url('logout');?>" class="btn btn-default btn-sm pull-right">Sign Out</a>
										</div>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</li>
			</ul>
			
			

			
		</div>
	</div>
</div>