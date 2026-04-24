<main class="mainContainer">  
		<section class="section sell-your-site">
			<div class="container"> 
					<h2 class="heading text-center font-weight-bold">Request to List Your Business</h2>  					
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
									<li id="tabarea2" class="<?php echo ($this->session->flashdata('slidetab')=='')? 'active':''?> <?php echo $selectedtab2; ?>" data-tab-id='tab2'>Business Details</li>
									<li id="tabarea1" class='<?php echo $selectedtab1; ?>' data-tab-id='tab1'>Monetization</li>
									<li id="tabarea3" class="<?php echo $selectedtab3; ?>" data-tab-id='tab3'>Financials</li>
									<li id="tabarea4" class="<?php echo $selectedtab4; ?>" data-tab-id='tab4'>Traffic</li>
									<li id="tabarea5" class="<?php echo $selectedtab5; ?>" data-tab-id='tab5'>Confirmation</li>
									<li id="tabarea6" <?php echo ($this->session->flashdata('slidetab')=='submission')? 'class="active"':''?> data-tab-id='tab6'>Submission</li>
									</ul>
								</nav>
								<form class="" id="sellurbusinessform" method="post" action="<?php echo base_url();?>user/sell-your-business-action">
					 				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" class="csrftoken" value="<?php echo $this->security->get_csrf_hash(); ?>" />
									 
									<input type="hidden" name="sellbusinessdata" id="sellbusinessdata" value="<?php echo $tempdata;?>">
								</form>
								<div class='panels'>
									<div id='tab1' class='content'>
									<div class="alert alert-danger alert-dismissable monetizationerr" style="display:none">Please select Monetization.</div>
										<h2 class="blue-heading text-center">Please select the option that most closely resembles your business model.</h2>
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
										<div class="d-flex justify-content-between align-items-center mt30">
											<div class="btn-group ml-auto">
												<button class="btn step1next">Next <i class="fa mr-0 fa-long-arrow-right" aria-hidden="true"></i>
												</button>
											</div>
										</div>
										
									</div>
									<div id='tab2' class='content <?php echo ($this->session->flashdata('slidetab')=='')? 'active':''?>'>  
										<h2 class="blue-heading text-center">Start by entering your basic business details.</h2>
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
														<form action="" id="dateform">
															<input type="text" name="startdate" id="startdate" placeholder="" value="<?php echo $startdateformat?>"> 
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
										<h2 class="blue-heading text-center">Based on your recent business activity,  please make your best financial estimates on how your business has been doing during the following time periods:</h2>
										<div class="income-details-list">
											<form action="" id="incomeDetailsForm">
											<ul class="ul row">
												<li class="col-md-4">
													<div class="box">
														<h2 class="subhead">The Last 3 Months</h2>
														<!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum aliquam velit risus, at fermentum mi ultrices vitae. Curabitur 
															pellentesque suscipit arcu ut fermentum. </p>-->
														
															<div class="income-input-row">
																<ul class="row ul">
																	<li class="col-sm-6">
																		<input type="text" placeholder="$0 (average revenue)" name="month3avgrevenue" id="month3avgrevenue" value="<?php echo $tempdata['month3avgrevenue']?>">
																	</li>
																	<li class="col-sm-6">
																		<input type="text" placeholder="$0 (average profit)" name="month3avgprofit" id="month3avgprofit" value="<?php echo $tempdata['month3avgprofit']?>">
																	</li> 
																</ul>
															</div>
													</div>
												</li>
												<li class="col-md-4">
													<div class="box">
														<h2 class="subhead">The Last 6 Months</h2>
														<!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum aliquam velit risus, at fermentum mi ultrices vitae. Curabitur 
															pellentesque suscipit arcu ut fermentum. </p>-->
															<div class="income-input-row">
																<ul class="row ul">
																	<li class="col-sm-6">
																		<input type="text" placeholder="$0 (average revenue)" name="month6avgrevenue" id="month6avgrevenue" value="<?php echo $tempdata['month6avgrevenue']?>">
																	</li>
																	<li class="col-sm-6">
																		<input type="text" placeholder="$0 (average profit)" name="month6avgprofit" id="month6avgprofit" value="<?php echo $tempdata['month6avgprofit']?>">
																	</li> 
																</ul>
															</div>
													</div>
												</li> 
												<li class="col-md-4">
													<div class="box">
														<h2 class="subhead">The Last 12 Months</h2>
														<!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum aliquam velit risus, at fermentum mi ultrices vitae. Curabitur 
															pellentesque suscipit arcu ut fermentum. </p>-->
															<div class="income-input-row">
																<ul class="row ul">
																	<li class="col-sm-6">
																		<input type="text" placeholder="$0 (average revenue)" name="month12avgrevenue" id="month12avgrevenue" value="<?php echo $tempdata['month12avgrevenue']?>">
																	</li>
																	<li class="col-sm-6">
																		<input type="text" placeholder="$0 (average profit)" name="month12avgprofit" id="month12avgprofit" value="<?php echo $tempdata['month12avgprofit']?>">
																	</li> 
																</ul>
															</div>
													</div>
												</li> 

											</ul>
											</form>
										</div>
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
									<div id='tab4' class='content'>
										<h2 class="blue-heading text-center">Does your business track its website traffic?</h2>
										<div class="income-details-list tracking-info-list">
											<ul class="ul row">
												<li class="col-md-12">
													<div class="box">
														<h2 class="subhead">Do you currently have Google Analytics installed?</h2>
														<!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum aliquam velit risus, at fermentum mi ultrices vitae. Curabitur pellentesque suscipit arcu ut fermentum.  </p>-->
														
														<div class="btn-group">
															<a href="javascript: void(0)" class="btn yes-btn track <?php echo ($tempdata['trackingInfo'] =='Y') ? 'active' : '';?>">Yes</a>
															<a href="javascript: void(0)" class="btn no-btn ml-3 mr-3 track <?php echo ($tempdata['trackingInfo'] =='N' || $tempdata['trackingInfo'] =='') ? 'active' : '';?>">No</a>
															<a href="javascript: void(0)" class="btn NA-btn track">N/A - No Website Included</a>
														</div>
														
													</div>
												</li>
												<input type="hidden" id="trackingInfo" value="<?php echo ($tempdata['trackingInfo'] !='') ? $tempdata['trackingInfo'] : 'N';?>"> 
												<input type="hidden" id="trackingtool" value="<?php echo $tempdata['trackingtool']?>"> 
												<li id="trackingdetails" class="col-md-12" style="display:<?php echo ($tempdata['trackingInfo'] =='Y') ? 'block' : 'none';?>">
													<div class="box">
														
														<h2 class="subhead">What was the first date Google Analytics was added?</h2>
														<p>Select the date your website first started using analytics.</p>
														<form action="" id="dateform11">
															<input type="date" name="trackingaddeddate" id="trackingaddeddate" placeholder="2020/10/21" value="<?php echo $tempdata['trackingaddeddate']?>"> 
														</form>
													</div>
												</li>
												<li class="col-md-12">
													<div class="box">
														<h2 class="subhead">If traffic is known, how many combined monthly visitors does your website(s) get?</h2>
														<!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum aliquam velit risus, at fermentum mi ultrices vitae. Curabitur pellentesque suscipit arcu ut fermentum. </p>-->
														<form action="">
															<div class="income-input-row">
																<ul class="row ul">
																	<li class="col-sm-12">
																		<input type="text" id="monthlyvisitor" placeholder="Average Monthly Visitors" value="<?php echo $tempdata['monthlyvisitor']?>">
																	</li> 
																</ul>
															</div>
														</form> 
													</div>
												</li> 
											</ul>
										</div>
										<div class="d-flex justify-content-between align-items-center mt30">
											<a href="#" class="btn btn_t BtnReset">Reset</a>
											<div class="btn-group ml-auto">
												<a href="javascript: void(0)" class="btn btn-ylw step4back"><i class="fa fa-angle-left" aria-hidden="true"></i> Back 
												</a>
												<button class="btn ml-2 step4next">Next <i class="fa fa-angle-right" aria-hidden="true"></i>
												</button>
											</div>
										</div>
									</div>
									<div id='tab5' class='content'>
										<h2 class="blue-heading text-center">To expedite our vetting process, please explain why your listing is a good fit for our marketplace</h2>
										<div class="income-details-list extra-info-list">
											<ul class="ul row"> 
												<li class="col-md-12">
													<div class="box">
														<h2 class="subhead">Before you submit your application, please explain to us how your offering qualifies as a passive income producing entity. Be sure to tell us anything else that we may need to know to better understand the value & health of your online business.</h2>
														<!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum aliquam velit risus, at fermentum mi ultrices vitae. Curabitur pellentesque suscipit arcu ut fermentum. </p>-->
														<form action="" id="extraInfoForm"> 
															<ul class="row ul">
																<li class="col-sm-12">
																	<textarea name="extraInfo" id="extraInfo" placeholder="3-5 sentences"><?php echo $tempdata['extraInfo']?></textarea>
																	<span id="charNum" class="pull-left"></span>
																</li> 
															</ul> 
														</form> 
													</div>
												</li> 
											</ul>
										</div>
										<div class="d-flex justify-content-between align-items-center mt30">
											<a href="#" class="btn btn_t BtnReset">Reset</a>
											<div class="btn-group ml-auto">
												<a href="javascript: void(0)" class="btn btn-ylw step5back"><i class="fa fa-angle-left" aria-hidden="true"></i> Back 
												</a>
												<button class="btn ml-2 step5next">Next <i class="fa fa-angle-right" aria-hidden="true"></i>
												</button>
											</div>
										</div>
									</div> 
									<div id='tab6' class='content <?php echo ($this->session->flashdata('slidetab')=='submission')? 'active':''?>'>
										<h2 class="blue-heading text-center">To submit your application, you just need to pay our  listing fee.</h2>
										<div class="income-details-list payment-list">
										
										<!--<form method="post" id="paymentForm" action="<?php echo base_url();?>user/sell-your-business/success"> -->
										
											<ul class="ul row"> 
												<li class="col-md-12">
													<div class="box">
														<h2 class="subhead">Pay <span class="price"><?php echo $currency->symbol.$sitesettings['sell_business_amount']?></span> to officially submit your application to list your business</h2>
														<p>(This is refundable to all businesses that are rejected)</p>
														<form method="post" id="redeemcodeForm" action="<?php echo base_url();?>user/sell-your-business/apply-promo">
														<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" class="csrftoken" value="<?php echo $this->security->get_csrf_hash(); ?>" />
														Referral Code: <input type="text" name="redeemCode" id="" value="<?php echo $tempdata['promo_details']['promocode'];?>"> <button type="submit" class="btn paynow-btn">Redeem <i class="fa fa-gift" aria-hidden="true"></i></button>
														</form>
														<?php
														$buttonName = 'Pay Now';
														if(is_array($tempdata['promo_details']) && count($tempdata['promo_details'])>0)
														{
															
															?>
															<table class="redeem-table">
																<tr>
																	<td>Amount</td>
																	<td><?php echo $currency->symbol.$sitesettings['sell_business_amount']?></td>
																</tr>
																<tr>
																	<td>(Less) Promo Discount</td>
																	<td><?php echo $currency->symbol.$tempdata['promo_details']['discount_amount']?></td>
																</tr>
																<tr>
																	<td>Amount to Pay</td>
																	<?php
																	if($tempdata['promo_details']['Sell_amount_discounted']>0)
																	{
																		$amt = $currency->symbol.$tempdata['promo_details']['Sell_amount_discounted'];
																	}else{
																		$amt = $currency->symbol.'0';
																		$buttonName = 'Proceed';
																	}
																	?>
																	<td><?php echo $amt?></td>
																</tr>
															</table>
															<?php
														}
														?>
														<form method="post" id="paymentForm" action="<?php echo base_url();?>user/sell-your-business/payment"> 
														<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" class="csrftoken" value="<?php echo $this->security->get_csrf_hash(); ?>" />
														<button type="submit" class="btn paynow-btn"><?php echo $buttonName;?> <i class="fa fa-angle-right" aria-hidden="true"></i></button>
														</form>
														
													</div>
												</li> 
											</ul>
											
											
											
										</div> 
									</div> 
								</div>
							</div>
						</div> 
					</div>  
			</div>
		</section>  
	</main> 