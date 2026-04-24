<main class="mainContainer">  
		<section class="section sell-your-site">
			<div class="container"> 
					<h2 class="heading text-center font-weight-bold">How Much Is Your Online Business Worth?</h2>  					
					<div class="d-block w-100">
						<div class="sell-site-wrap mt30">
							<div class="js-tabs sell-site-tab" data-aos="fade-left" data-aos-duration="2400">
								<nav>
									<ul class='tabs'>
									<li id="tabarea1" class='active <?php echo $selectedtab1; ?>' data-tab-id='tab1'>Select Monetization </li>
									<li id="tabarea3" class="<?php echo $selectedtab3; ?>" data-tab-id='tab3'>Average Yearly Revenue and Profit</li>
									<li id="tabarea4" class="<?php echo $selectedtab4; ?>" data-tab-id='tab4'>Business Questions</li>
									</ul>
								</nav>
								<form class="" id="valueurbusinessform" method="post" action="<?php echo base_url();?>business-valuation-action">
					 				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" class="csrftoken" value="<?php echo $this->security->get_csrf_hash(); ?>" />
									 
									<input type="hidden" name="sellbusinessdata" id="sellbusinessdata" value="<?php echo $tempdata;?>">
								
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
														/*if(in_array($val['slug'],$tempdata['monetization']))
														{
															$class='slected-monetization';
														}else{
															$class='';
														}*/
														?>
														<li class="col-md-3">
															<a href="javascript: void(0)" class="box monetization <?php echo $class?>" data-tab="<?php echo $val['slug'];?>"><span><img src="<?php echo base_url();?>assets/frontend/images/blue-tick.png" alt=""><?php echo $val['name'];?></span></a>
														</li>
														<?php
													}
												}
												?>
											</ul>
										</div>
										<div class="d-flex justify-content-between align-items-center mt30">
											<div class="btn-group ml-auto">
												<input type="hidden" name="monitizationValue" value="" id="monitizationValue">
												<button class="btn step1next" disabled="true">Next <i class="fa mr-0 fa-long-arrow-right" aria-hidden="true"></i>
												</button>
											</div>
										</div>
										
									</div>
									<div id='tab3' class='content'>
										<h2 class="blue-heading text-center">Let’s Talk Income...Fill Out Your Average Net Profits.</h2>
										<div class="income-details-list">
											<ul class="ul row">
												<li class="col-md-12">
													<div class="box">
														<h2 class="subhead">What is the average yearly revenue and profit?</h2>
														<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum aliquam velit risus, at fermentum mi ultrices vitae. Curabitur 
															pellentesque suscipit arcu ut fermentum. </p>
                                                            <?php
                                                            //print '<pre>';
                                                            //print_r($currency->symbol);
                                                            ?>
															<div class="income-input-row">
																<ul class="row ul">
																	<li class="col-sm-6">
																		<input type="text" placeholder="<?php echo $currency->symbol?> 0.00 ( average revenue )" name="monthavgrevenue" id="monthavgrevenue" value="">
																		<label class="error" id="monthavgrevenuelbl" style="display: none" for="fname">Name is required</label>
																	</li>
																	<li class="col-sm-6">
																		<input type="text" placeholder="<?php echo $currency->symbol?> 0.00 ( average profit  )" name="monthavgprofit" id="monthavgprofit" value="">
																		<label class="error" id="monthavgprofitlbl" style="display: none" for="fname">Name is required</label>
																	</li> 
																</ul>
															</div>
													</div>
												</li> 

											</ul>
										</div>
										<div class="d-flex justify-content-between align-items-center mt30">
											<a href="#" class="btn btn_t">Reset</a>
											<div class="btn-group ml-auto">
												<a href="javascript: void(0)" class="btn btn-ylw step3back" ><i class="fa fa-angle-left" aria-hidden="true"></i> Back 
												</a>
												<button type="button" class="btn ml-2 step3next">Next <i class="fa fa-angle-right" aria-hidden="true"></i>
												</button>
											</div>
										</div>
									</div>
									<div id='tab4' class='content'>
										<h2 class="blue-heading text-center">Please answer the below questions related to your business.</h2>
										<div class="income-details-list tracking-info-list">
											<ul class="ul row">
												
												<?php
                                                if(is_array($questions) && count($questions)>0)
                                                {
                                                    foreach($questions as $qk=>$qv)
                                                    {
                                                        ?>
                                                        <li class="col-md-12">
                                                            <div class="box">
                                                                <h2 class="subhead"><?php echo $qv['question']?></h2>
                                                                    <div class="income-input-row">
                                                                        <ul class="row ul">
                                                                            <li class="col-sm-12">
                                                                                <input name="q[<?php echo $qv['id']?>]" type="number" data-id="<?php echo $qv['id']?>" id="monthlyvisitor" class="questioninput" placeholder="<?php echo $qv['question']?>" value="">
																				<label class="error" id="questionerror<?php echo $qv['id']?>" style="display: none" for="fname">Please add a numeric value.</label> <?php
																				
																				if($qv['factor'] == 'AGE')
																				{
																					echo 'Months';
																				}elseif($qv['factor'] == 'TIME')
																				{
																					echo 'Hours';
																				}elseif($qv['factor'] == 'TRAFFIC')
																				{
																					echo 'Unique Visitors/Month';
																				}elseif($qv['factor'] == 'REVENUE')
																				{
																					echo 'Revenue Channels';
																				}elseif($qv['factor'] == 'PROFITRATIO')
																				{
																					echo 'Rev/Profit Ratio';
																				}elseif($qv['factor'] == 'FOLLOWERS')
																				{
																					echo 'Million';
																				}elseif($qv['factor'] == 'REPEATCUST')
																				{
																					echo '';
																				}
																				?>
                                                                            </li> 
                                                                        </ul>
                                                                    </div>
                                                            </div>
                                                        </li> 
                                                        <?php
                                                    }
                                                }
                                                ?>
												
											</ul>
										</div>
										<div class="d-flex justify-content-between align-items-center mt30">
											<a href="#" class="btn btn_t">Reset</a>
											<div class="btn-group ml-auto">
												<a href="javascript: void(0)" class="btn btn-ylw step4back"><i class="fa fa-angle-left" aria-hidden="true"></i> Back 
												</a>
												<button type="button" class="btn ml-2 step4next">Submit <i class="fa fa-angle-right" aria-hidden="true"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
								</form>
							</div>
						</div> 
					</div>  
			</div>
		</section>  
	</main> 