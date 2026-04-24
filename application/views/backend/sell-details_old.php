
<div class="content-wrapper">
    <div class="container-fluid">
        <section class="sell-your-site">
			<div class="container"> 
					<h2 class="heading text-center font-weight-bold">Sell Your Site</h2>  					
					<div class="d-block w-100">
						<div class="sell-site-wrap mt30">
							<div class="js-tabs sell-site-tab" data-aos="fade-left" data-aos-duration="2400">
								<nav>
									<ul class='tabs'>
									<?php
									if(is_array($tempdata['monetization']) && count($tempdata['monetization'])>0)
									{
										$selectedtab1 = 'selected';
									}else{
										$selectedtab1 = '';
									}

									if(is_array($tempdata['website']) && count($tempdata['website'])>0 && $tempdata['businessstartdate'] !='' && $tempdata['workinghour'] !='')
									{
										$selectedtab2 = 'selected';
									}else{
										$selectedtab2 = '';
									}

									if($tempdata['month3avgrevenue'] !='' && $tempdata['month3avgprofit'] !='' && $tempdata['month6avgrevenue'] !='' && $tempdata['month6avgprofit'] !='' && $tempdata['month12avgrevenue'] !='' && $tempdata['month12avgprofit'] !='')
									{
										$selectedtab3 = 'selected';
									}else{
										$selectedtab3 = '';
									}

									if($tempdata['trackingInfo'] !='')
									{
										$selectedtab4 = 'selected';
									}else{
										$selectedtab4 = '';
									}

									if($tempdata['extraInfo'] !='')
									{
										$selectedtab5 = 'selected';
									}else{
										$selectedtab5 = '';
									}
									?>
									<li id="tabarea1" class='active <?php echo $selectedtab1; ?>' data-tab-id='tab1'>Select Monetization </li>
									<li id="tabarea2" class="<?php echo $selectedtab2; ?>" data-tab-id='tab2'>Business Detail</li>
									<li id="tabarea3" class="<?php echo $selectedtab3; ?>" data-tab-id='tab3'>Income Detail</li>
									<li id="tabarea4" class="<?php echo $selectedtab4; ?>" data-tab-id='tab4'>Tracking Info</li>
									<li id="tabarea5" class="<?php echo $selectedtab5; ?>" data-tab-id='tab5'>Extra Info</li>
									</ul>
								</nav>
								<form class="" id="sellurbusinessform" method="post" action="<?php echo base_url();?>user/sell-your-business-action">
					 				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" class="csrftoken" value="<?php echo $this->security->get_csrf_hash(); ?>" />
									 
									<input type="hidden" name="sellbusinessdata" id="sellbusinessdata" value="<?php echo $tempdata;?>">
								</form>
								<div class='panels'>
									<div id='tab1' class='content active'>
										<h2 class="blue-heading text-center">Please Select Any/All That Apply...</h2>
										<div class="monetization-list">
											<ul class="ul row">
												<?php
												//$tempmonetization = explode(',',$tempdata->monetization);
												if(is_array($monetization) && count($monetization)>0)
												{
													foreach($monetization as $val){
														//
														if(in_array($val['slug'],$tempdata['monetization']))
														{
															$class='slected-monetization';
														}else{
															$class='';
														}
														?>
														<li class="col-md-3">
															<a href="javascript: void(0)" class="box <?php echo $class?>" data-tab="<?php echo $val['slug'];?>"><span><img src="<?php echo base_url();?>assets/frontend/images/blue-tick.png" alt=""><?php echo $val['name'];?></span></a>
														</li>
														<?php
													}
												}
												?>
											</ul>
										</div>
										<!--<div class="d-flex justify-content-between align-items-center mt30">
											<div class="btn-group ml-auto">
												<button class="btn step1next" disabled="true">Next <i class="fa mr-0 fa-long-arrow-right" aria-hidden="true"></i>
												</button>
											</div>
										</div>-->
										
									</div>
									<div id='tab2' class='content'>  
										<h2 class="blue-heading text-center">Enter Your Business Details Here...</h2>
										<div class="business-details-list">
											<ul class="ul row">
												<li class="col-md-4 col-sm-4">
													<div class="box">
														<h2 class="subhead">Website/Business URL(s)</h2>
														<form action="" id="websiteform">
														<?php
														if(is_array($tempdata['website']) && count($tempdata['website'])>0)
														{
															$i= 0;
															foreach($tempdata['website'] as $val)
															{
																?>
																<input type="text" class="websitetext" placeholder="Enter Your Business URL" name="website<?php echo ($i>0) ? $i : ''?>" value="<?php echo $val?>">
																<?php
																$i++;
															}
														}else{
															?>
															<input type="text" class="websitetext" placeholder="Enter Your Business URL" name="website" value="">
															<?php
														}
														?>
															
															<a href="javascript: void(0)" class="btn add-url-btn addwebsite"><i class="fa fa-plus" aria-hidden="true"></i></a>
														</form>
														<p>At least one site URL is required.</p>
													</div>
												</li>
												<li class="col-md-4 col-sm-4">
													<div class="box">
														<h2 class="subhead">When was the business first started?</h2>
														<form action="" id="dateform">
															<input type="date" name="startdate" id="startdate" placeholder="2020/10/21" value="<?php echo $tempdata['businessstartdate']?>"> 
														</form>
														<p>Business Created date cannot be in the future.</p>
													</div>
												</li>
												<li class="col-md-4 col-sm-4">
													<div class="box">
														<h2 class="subhead">How many hours a week does it take to 
															manage the business?</h2>
														<form action="" id="hoursform"> 
															<input type="text" name="workinghour" id="workinghour" placeholder="Write Here..." value="<?php echo $tempdata['workinghour']?>" />
														</form>
														<p>First Made Money date cannot be in the future.</p>
													</div>
												</li>
											</ul>
										</div>
										<!--
										<div class="d-flex justify-content-between align-items-center mt30">
											<a href="#" class="btn btn_t">Reset</a>
											<div class="btn-group ml-auto">
												<a href="javascript: void(0)" class="btn btn-ylw step2back" ><i class="fa fa-angle-left" aria-hidden="true"></i> Back 
												</a>
												<button class="btn ml-2 step2next">Next <i class="fa fa-angle-right" aria-hidden="true"></i>
												</button>
											</div>
										</div>
										-->
									</div>
									<div id='tab3' class='content'>
										<h2 class="blue-heading text-center">Let’s Talk Income...Fill Out Your Average Net Profits.</h2>
										<div class="income-details-list">
											<form action="" id="incomeDetailsForm">
											<ul class="ul row">
												<li class="col-md-12">
													<div class="box">
														<h2 class="subhead">What is the average revenue and avarage net profit (per month) over the last 3 months?</h2>
														<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum aliquam velit risus, at fermentum mi ultrices vitae. Curabitur 
															pellentesque suscipit arcu ut fermentum. </p>
														
															<div class="income-input-row">
																<ul class="row ul">
																	<li class="col-sm-6">
																		<input type="text" placeholder="$ 0.00 ( average revenue )" name="month3avgrevenue" id="month3avgrevenue" value="<?php echo $tempdata['month3avgrevenue']?>">
																	</li>
																	<li class="col-sm-6">
																		<input type="text" placeholder="$ 0.00 ( average profit  )" name="month3avgprofit" id="month3avgprofit" value="<?php echo $tempdata['month3avgprofit']?>">
																	</li> 
																</ul>
															</div>
													</div>
												</li>
												<li class="col-md-12">
													<div class="box">
														<h2 class="subhead">What is the average revenue and avarage net profit (per month) over the last 6 months?</h2>
														<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum aliquam velit risus, at fermentum mi ultrices vitae. Curabitur 
															pellentesque suscipit arcu ut fermentum. </p>
															<div class="income-input-row">
																<ul class="row ul">
																	<li class="col-sm-6">
																		<input type="text" placeholder="$ 0.00 ( average revenue )" name="month6avgrevenue" id="month6avgrevenue" value="<?php echo $tempdata['month6avgrevenue']?>">
																	</li>
																	<li class="col-sm-6">
																		<input type="text" placeholder="$ 0.00 ( average profit  )" name="month6avgprofit" id="month6avgprofit" value="<?php echo $tempdata['month6avgprofit']?>">
																	</li> 
																</ul>
															</div>
													</div>
												</li> 
												<li class="col-md-12">
													<div class="box">
														<h2 class="subhead">What is the average revenue and avarage net profit (per month) over the last 12 months?</h2>
														<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum aliquam velit risus, at fermentum mi ultrices vitae. Curabitur 
															pellentesque suscipit arcu ut fermentum. </p>
															<div class="income-input-row">
																<ul class="row ul">
																	<li class="col-sm-6">
																		<input type="text" placeholder="$ 0.00 ( average revenue )" name="month12avgrevenue" id="month12avgrevenue" value="<?php echo $tempdata['month12avgrevenue']?>">
																	</li>
																	<li class="col-sm-6">
																		<input type="text" placeholder="$ 0.00 ( average profit  )" name="month12avgprofit" id="month12avgprofit" value="<?php echo $tempdata['month12avgprofit']?>">
																	</li> 
																</ul>
															</div>
													</div>
												</li> 

											</ul>
											</form>
										</div>
										<!--
										<div class="d-flex justify-content-between align-items-center mt30">
											<a href="#" class="btn btn_t">Reset</a>
											<div class="btn-group ml-auto">
												<a href="javascript: void(0)" class="btn btn-ylw step3back" ><i class="fa fa-angle-left" aria-hidden="true"></i> Back 
												</a>
												<button class="btn ml-2 step3next">Next <i class="fa fa-angle-right" aria-hidden="true"></i>
												</button>
											</div>
										</div>
										-->
									</div>
									<div id='tab4' class='content'>
										<h2 class="blue-heading text-center">Does Your Website Have Analytics</h2>
										<div class="income-details-list tracking-info-list">
											<ul class="ul row">
												<li class="col-md-12">
													<div class="box">
														<h2 class="subhead">Do you currently have either Google Analytics or clicky Installed?</h2>
														<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum aliquam velit risus, at fermentum mi ultrices vitae. Curabitur pellentesque suscipit arcu ut fermentum.  </p>
														
														<div class="btn-group">
															<a href="javascript: void(0)" class="btn yes-btn track">Yes</a>
															<a href="javascript: void(0)" class="btn no-btn ml-3 mr-3 track">No</a>
															<a href="javascript: void(0)" class="btn NA-btn track">N/A - No Website Included</a>
														</div>
														
													</div>
												</li>
												<input type="hidden" id="trackingInfo" value="<?php echo ($tempdata['trackingInfo'] !='') ? $tempdata['trackingInfo'] : 'N';?>"> 
												<input type="hidden" id="trackingtool" value="<?php echo $tempdata['trackingtool']?>"> 
												<li id="trackingdetails" class="col-md-12" style="display:<?php echo ($tempdata['trackingInfo'] =='Y') ? 'block' : 'none';?>">
													<div class="box">
														
														<h2 class="subhead">What was the first date Google Analytics or Clicky Was Added?</h2>
														<p>Select the date your website first started using analytics.</p>
														<form action="" id="dateform11">
															<input type="date" name="trackingaddeddate" id="trackingaddeddate" placeholder="2020/10/21" value="<?php echo $tempdata['trackingaddeddate']?>"> 
														</form>
													</div>
												</li>
												<li class="col-md-12">
													<div class="box">
														<h2 class="subhead">If traffic known, what is the average monthly visitor amount?</h2>
														<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum aliquam velit risus, at fermentum mi ultrices vitae. Curabitur pellentesque suscipit arcu ut fermentum. </p>
														<form action="">
															<div class="income-input-row">
																<ul class="row ul">
																	<li class="col-sm-12">
																		<input type="text" id="monthlyvisitor" placeholder="monthly  average visitor" value="<?php echo $tempdata['monthlyvisitor']?>">
																	</li> 
																</ul>
															</div>
														</form> 
													</div>
												</li> 
											</ul>
										</div>
										<!--
										<div class="d-flex justify-content-between align-items-center mt30">
											<a href="#" class="btn btn_t">Reset</a>
											<div class="btn-group ml-auto">
												<a href="javascript: void(0)" class="btn btn-ylw step4back"><i class="fa fa-angle-left" aria-hidden="true"></i> Back 
												</a>
												<button class="btn ml-2 step4next">Next <i class="fa fa-angle-right" aria-hidden="true"></i>
												</button>
											</div>
										</div>
										-->
									</div>
									<div id='tab5' class='content'>
										<h2 class="blue-heading text-center">To Expedite The Vetting Process We Need Some Extra Details</h2>
										<div class="income-details-list extra-info-list">
											<ul class="ul row"> 
												<li class="col-md-12">
													<div class="box">
														<h2 class="subhead">Briefly tell us about your business including anything special we may need to know :</h2>
														<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum aliquam velit risus, at fermentum mi ultrices vitae. Curabitur pellentesque suscipit arcu ut fermentum. </p>
														<form action="" id="extraInfoForm"> 
															<ul class="row ul">
																<li class="col-sm-12">
																	<textarea name="extraInfo" id="extraInfo" placeholder="2-3 sentence ( 0/1000 )"><?php echo $tempdata['extraInfo']?></textarea>
																	<span id="charNum" class="pull-left"></span>
																</li> 
															</ul> 
														</form> 
													</div>
												</li> 
											</ul>
										</div>
										<!--
										<div class="d-flex justify-content-between align-items-center mt30">
											<a href="#" class="btn btn_t">Reset</a>
											<div class="btn-group ml-auto">
												<a href="javascript: void(0)" class="btn btn-ylw step5back"><i class="fa fa-angle-left" aria-hidden="true"></i> Back 
												</a>
												<button class="btn ml-2 step5next">Next <i class="fa fa-angle-right" aria-hidden="true"></i>
												</button>
											</div>
										</div>
										-->
									</div> 
									
								</div>
							</div>
						</div> 
					</div>  
			</div>
		</section>  
    </div>
</div>