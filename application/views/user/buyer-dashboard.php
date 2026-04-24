<main class="mainContainer">  
		<section class="section dashboard">
			<div class="container">
				<div class="dashboard-top">
					<ul class="row ul">
						<li class="col-md-6">
							<div class="box">
								<div class="heading-top d-flex justify-content-between">
									<div class="left">
										<h2 class="subheading">Selling</h2>
										<div class="dPrice">1,587</div>
									</div>
									<figure><img src="images/sample/selling.png" alt=""></figure>
								</div>
								<div class="bottom-para d-flex justify-content-between">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
									<a href="#" class="btn">Find Listing</a>
								</div>
							</div>
						</li>
						<li class="col-md-6">
							<div class="box">
								<div class="heading-top d-flex justify-content-between">
									<div class="left">
										<h2 class="subheading">Buying</h2>
										<div class="dPrice">1,587</div>
									</div>
									<figure><img src="<?php echo base_url();?>assets/frontend/images/sample/buying.png" alt=""></figure>
								</div>
								<div class="bottom-para d-flex justify-content-between">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
									<a href="#" class="btn">Find Listing</a>
								</div>
							</div>
						</li>
					</ul>
				</div>
				<div class="dashboard-bottom mt30">
					<div class="row">
						<div class="col-md-5 settings-sec">
							<div class="box">
								<h2 class="subheading">Settings <i class="fa fa-cogs" aria-hidden="true"></i></h2>
								<div class="body">
									<ul class="ul">
										<li>
											<label>Name :</label>
											<span><?php echo $profiledata['fname']?></span>
										</li>
										<li>
											<label>Email :</label>
											<span><?php echo $profiledata['mail']?></span>
										</li>
										<li>
											<label>Phone :</label>
											<span>+ <?php echo $profiledata['phone']?></span>
										</li>
										<li>
											<label>Address :</label>
											<span>
											</span>
										</li>
										<li>
											<a href="<?php echo base_url();?>user/profile" class="btn d-block">Edit Profile</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-md-7 notification-sec">
							<div class="box">
								<h2 class="subheading">Notification Alter <i class="fa fa-bell" aria-hidden="true"></i></h2>
								<div class="body editor_text">
									<ul id="notificationul">
									<?php

									if(is_array($notifications['data']['notification']) && count($notifications['data']['notification'])>0)
									{
										foreach($notifications['data']['notification'] as $k=>$val)
										{
											
											?>
											<li id="notification<?php echo $val['id'];?>">
												<?php echo $val['notification_text'];?>
												<a href="javascript: void(0);" class="delete" onclick="javascript: deletenotification(this)" datadeletehref="<?php echo base_url();?>user/removenotification/<?php echo $val['id']?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
											</li> 
											<?php
										}
									}else{
										?>
										<li>No new Notifications found.</li> 
										<?php
									}
									?>
									</ul>
									<div id="notificationskeleton" style="display: none">
										<li id="notificationNOTIFICATIONID">
											[NOTIFICATIONTEXT]
											<a href="javascript: void(0);" class="delete" onclick="javascript: deletenotification(this)" datadeletehref="<?php echo base_url();?>user/removenotification/NOTIFICATIONID"><i class="fa fa-trash" aria-hidden="true"></i></a>
										</li>
									</div>
									 <?php
									 if($notifications['data']['totalrecord']['totalrecord'] > $sellerOffersLimit)
									 {
										?>
											<a href="javascript: void(0);" class="readmore showallnotifications">Show More</a>
											<input type="hidden" id="loadmorestart" value="<?php echo $sellerOffersStart+$sellerOffersLimit;?>">
											<input type="hidden" id="loadmorelimit" value="<?php echo $sellerOffersLimit;?>">
										<?php
									 }
									 ?>
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>  
	</main> 
