<main class="mainContainer">  
		<section class="section sell-your-site">
			<div class="container"> 
					<h2 class="heading text-center font-weight-bold">How Much Is Your Online Business Worth?</h2>  					
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

									if($tempdata['monetization'])
									{
										$selectedtab3 = 'selected';
									}else{
										$selectedtab3 = '';
									}

									if($tempdata['avgrevenue']>0 || $tempdata['avgprofit']>0 || $tempdata['recurringrevenue']>0)
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
									<li id="tabarea2" class="selected active <?php echo $selectedtab2; ?>" data-tab-id='tab2'>Business Details</li>
									<li id="tabarea3" class="<?php echo $selectedtab3; ?>" data-tab-id='tab3'>Monetization</li> 
									<li id="tabarea4" class="<?php echo $selectedtab4; ?>" data-tab-id='tab4'>Financials</li>
									<li id="tabarea5" class="<?php echo $selectedtab5; ?>" data-tab-id='tab5'>Additional Questions</li>
									</ul>
								</nav>
								<form class="" id="sellurbusinessform" method="post" action="<?php echo base_url();?>user/value-your-business-action">
					 				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" class="csrftoken" value="<?php echo $this->security->get_csrf_hash(); ?>" />
									 
									<input type="hidden" name="sellbusinessdata" id="sellbusinessdata" value="<?php echo $tempdata;?>">
								</form>
								<div class='panels'>
									
									<div id='tab2' class='content active'>  
										<h2 class="blue-heading text-center">Start by entering your basic business details.</h2>
										<div class="business-details-list">
											<ul class="ul row">
												<li class="col-md-3 col-sm-4">
													<div class="box">
														<h2 class="subhead">Website/Business URL</h2>
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
															<!--<a href="javascript: void(0)" class="btn add-url-btn addwebsite"><i class="fa fa-plus" aria-hidden="true"></i></a>-->
														</form>
														<p>At least one site URL is required.</p>
													</div>
												</li>
												<li class="col-md-4 col-sm-4">
													<div class="box">
														<h2 class="subhead">When was the business first started?</h2>
														<form action="" id="dateform">
															<?php
															$businessstartdate = $tempdata['businessstartdate'];
															if($businessstartdate !='')
															{
																$businessstartdateArr = explode('-',$businessstartdate);
																$startdateformat = $businessstartdateArr[1].'/'.$businessstartdateArr[2].'/'.$businessstartdateArr[0];
															}else{
																$startdateformat = '';
															}
															?>
															<input type="text" name="startdate" id="startdate" value="<?php echo $startdateformat;?>"> 
														</form>
														<p>Business Created date cannot be in the future.</p>
													</div>
												</li>
												<li class="col-md-5 col-sm-6">
													<div class="box">
														<h2 class="subhead">How many hours a week does it take to 
															manage the business?</h2>
														<form action="" id="hoursform"> 
															<input type="text" name="workinghour" id="workinghour" placeholder="Write Here..." value="<?php echo $tempdata['workinghour']?>" />
														</form>
														<p>This is the amount of time the owner spends on essential business activities each week.</p>
													</div>
												</li>
											</ul>
										</div>
										<div class="d-flex justify-content-between align-items-center mt30">
											<a href="#" class="btn btn_t BtnReset">Reset</a>
											<div class="btn-group ml-auto">
												<a href="javascript: void(0)" class="btn btn-ylw step2back" ><i class="fa fa-angle-left" aria-hidden="true"></i> Back 
												</a>
												<button class="btn ml-2 step2next">Next <i class="fa fa-angle-right" aria-hidden="true"></i>
												</button>
											</div>
										</div>
									</div>
									<div id='tab3' class='content'>

										<h2 class="blue-heading text-center">Please select the option that most closely resembles your business model.</h2>
										<div style="margin-top: 10px; display:none" id="monitizationerror" class="alert alert-danger alert-dismissible">Please select your monitization</div> 	
										<div class="monetization-list monetization-list-with-desc">
											<ul class="ul row">
												<?php
												//$tempmonetization = explode(',',$tempdata->monetization);
												
												if(is_array($monetization) && count($monetization)>0)
												{
													foreach($monetization as $val){
														//
														if($val['slug'] == $tempdata['monetization'])
														{
															$class='slected-monetization';
														}else{
															$class='';
														}
														?>
														<li class="col-md-4">
															<a href="javascript: void(0)" class="box monetization flex-wrap <?php echo $class?>" data-tab="<?php echo $val['slug'];?>"><span><img src="<?php echo base_url();?>assets/frontend/images/blue-tick.png" alt="">
															<?php echo $val['name'];?></span>
															<div class="smaller d-block"><?php echo $val['description'];?></div></a>
														</li>
														<?php
													}
												}
												
												?>
											</ul>
										</div>
										<input type="hidden" name="monitizationValue" value="<?php echo $tempdata['monetization'];?>" id="monitizationValue">
										

										
										<div class="d-flex justify-content-between align-items-center mt30">
											<a href="#" class="btn btn_t BtnReset">Reset</a>
											<div class="btn-group ml-auto">
												<a href="javascript: void(0)" class="btn btn-ylw step3back" ><i class="fa fa-angle-left" aria-hidden="true"></i> Back 
												</a>
												<button class="btn ml-2 step3next">Next <i class="fa fa-angle-right" aria-hidden="true"></i>
												</button>
											</div>
										</div>
									</div>
									<div id="tab4" class="content">
										<h2 class="blue-heading text-center">Based on recent business activity, please input your financial data.</h2>
										<div class="business-details-list ProfitRevenue">
											<form action="" id="incomeDetailsForm">
											<ul class="ul row">
												<li class="col-md-4 col-sm-4">
													<div class="box">
														<h2 class="subhead">What is the monthly average revenue?</h2> 
														<div class="d-sign">
															<span>$</span>
																<input type="text" placeholder="0.00 ( average revenue )" name="avgrevenue" id="avgrevenue" value="<?php echo $tempdata['avgrevenue']?>"> 
															</div>
														<!--<li class="col-sm-6">
															<input type="text" placeholder="$ 0.00 ( average profit  )" name="month3avgprofit" id="month3avgprofit" value="<?php echo $tempdata['month3avgprofit']?>">
														</li> --> 
													</div>
												</li>
												<li class="col-md-4 col-sm-4">
													<div class="box">
														<h2 class="subhead">What is the monthly average net profit?</h2>
														 
															<!--<li class="col-sm-12">
																<input type="text" placeholder="$ 0.00 ( average revenue )" name="month3avgrevenue" id="month3avgrevenue" value="<?php echo $tempdata['month3avgrevenue']?>">
															</li>--> 
															<div class="d-sign">
																<span>$</span>
																<input type="text" placeholder="0.00 ( average profit  )" name="avgprofit" id="avgprofit" value="<?php echo $tempdata['avgprofit']?>"> 
															</div>
													</div>
												</li>
												<li class="col-md-4 col-sm-4">
													<div class="box">
														<h2 class="subhead">What percentage of revenue is from recurring revenue or repeat customers?</h2>
														<div class="d-sign">
															<span>%</span>
														<input type="text" placeholder="Revenue from repeat customers" name="recurringrevenue" id="recurringrevenue" value="<?php echo $tempdata['recurringrevenue']?>">
															</div>		 
													</div>
												</li> 

											</ul>
											</form>
										</div>
										<div class="d-flex justify-content-between align-items-center mt30">
											<a href="#" class="btn btn_t BtnReset">Reset</a>
											<div class="btn-group ml-auto">
												<a href="javascript: void(0)" class="btn btn-ylw step5back" ><i class="fa fa-angle-left" aria-hidden="true"></i> Back 
												</a>
												<button class="btn ml-2 step5next">Next <i class="fa fa-angle-right" aria-hidden="true"></i>
												</button>
											</div>
										</div>
									</div>
									<div id='tab5' class='content'>
										<h2 class="blue-heading text-center">To get your valuation, please enter these final details.</h2>
										<div class="business-details-list business-questions">
											<form action="" id="dateform11">

											<ul class="ul row">
												<li class="col-md-4 col-sm-4">
													<div class="box">
														<h2 class="subhead">How many unique visitors does the company website(s) get per month?</h2>
														
														 
															<input type="text" placeholder="Unique visitors" name="uniquevisiors" id="uniquevisiors" value="<?php echo $tempdata['uniquevisiors']?>"> 
														<!--<li class="col-sm-6">
															<input type="text" placeholder="$ 0.00 ( average profit  )" name="month3avgprofit" id="month3avgprofit" value="<?php echo $tempdata['month3avgprofit']?>">
														</li> -->  
													</div>
												</li>
												<li class="col-md-4 col-sm-4">
													<div class="box">
														<h2 class="subhead">How many combined online followers (social media, mailing lists, etc.) does the business have?</h2> 
															<!--<li class="col-sm-12">
																<input type="text" placeholder="$ 0.00 ( average revenue )" name="month3avgrevenue" id="month3avgrevenue" value="<?php echo $tempdata['month3avgrevenue']?>">
															</li>--> 
															<input type="text" placeholder="Online followers" name="onlinefollowers" id="onlinefollowers" value="<?php echo $tempdata['month3avgprofit']?>"> 
													</div>
												</li>
												<li class="col-md-4 col-sm-4">
													<div class="box">
														<h2 class="subhead">How many revenue channels does the business have?</h2> 
														 
															<input type="text" placeholder="No of revenue channels" name="revenuechannels" id="revenuechannels" value="">
																 
													</div>
												</li>
												

											</ul>
											</form>
											<form class="" id="valueurbusinessform" method="post" action="<?php echo base_url();?>business-valuation-action">
											<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" class="csrftoken" value="<?php echo $this->security->get_csrf_hash(); ?>" />
											</form>
										</div>
										<div class="d-flex justify-content-between align-items-center mt30">
											<a href="#" class="btn btn_t BtnReset">Reset</a>
											<div class="btn-group ml-auto">
												<a href="javascript: void(0)" class="btn btn-ylw step4back"><i class="fa fa-angle-left" aria-hidden="true"></i> Back 
												</a>
												<button class="btn ml-2 step4next">Calculate Valuation <i class="fa fa-angle-right" aria-hidden="true"></i>
												</button>
											</div>
										</div>
									</div>
									
								</div>
							</div>
						</div> 
					</div>  
			</div>
		</section>  
	</main> 