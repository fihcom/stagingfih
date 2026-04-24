<?php 
	// pre($maxmin);
?>
<main class="mainContainer"> 
		<section class="section marketplace-lock pb30">
			<div class="container">
				<div class="search-section">
					<div class="row">
						<!--<div class="search-left col-sm-3">
							<div class="search-in">
								<ul class="ul d-flex align-items-center">
									<li><a href="#"><span class="small-lock"><img src="<?php //echo base_url();?>assets/frontend/images/sample/small-lock.png" alt=""></span><img src="<?php //echo base_url();?>assets/frontend/images/sample/filter1.png" alt=""> <span class="filter-txt">Filter</span></a></li>
									<li>
										<img src="<?php //echo base_url();?>assets/frontend/images/sample/filter2.png" alt="">
										<div class="on-off-box">
											<input type="checkbox" id="toggle_1" class="chkbx-toggle" value="1" checked>
											<label for="toggle_1"></label>
										</div>
										<img src="<?php //echo base_url();?>assets/frontend/images/sample/filter3.png" alt="">
									</li>
								</ul>
							</div>
						</div>-->
						
						<div class="search-right col-sm-12 pr-0" >
						<?php $this->load->helper("form"); ?>
						  <form role="form" id="siteSettings" action="<?php echo base_url(); ?>marketplace" method="get" role="form" enctype="multipart/form-data">
						  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
							<div class="row">
								<div class="col-md-3 col-sm-3">
									<div class="labelWrap">
										<input type="text" placeholder="Search listings" name="searchText" id="searchText" value="<?php echo $this->security->xss_clean(trim($_GET['searchText']));?>">
									</div>
								</div>
								
								<div class="col-md-2 col-sm-2">
									<div class="labelWrap">
										<select name="Monitization" id="mpMonitization">
											<option value="">Select Monetization</option>
											<?php
											if(is_array($monetization) && count($monetization)>0)
											{
												foreach($monetization as $Mone)
												{
													?>
													<option value="<?php echo $Mone['slug'];?>" <?php echo ($Mone['slug'] == $this->security->xss_clean(trim($_GET['Monitization'])))?'selected':''?>><?php echo $Mone['name'];?></option>
													<?php
												}
											}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-2 col-sm-2">
									<div class="labelWrap">
										<select name="businessAge" id="businessAge">
											<option value="">Select Business Age</option>
											<!--<option value="5less">Less Than 5 Years</option>
											<option value="10less">Less Than 10 Years</option>
											<option value="20less">Less Than 20 Years</option>	
											<option value="40less">Less Than 40 Years</option>
											<option value="40more">More Than 40 Years</option>-->
											
											<!-- Sourav Das Edit - 08-04-2025 -->
											<option value="2lessyears">Less than 2 Years</option>
											<option value="2-5yrs">2-5 Years</option>
											<option value="5-10yrs">5-10 Years</option>
											<option value="10-20yrs">10-20 Years</option>
											<option value="20moreyears">20+ Years</option>
											<!-- <option value="6monthless">Less Than 6 Months</option>
											<option value="6-12months">6-12 Months</option>
											<option value="1-2yrs">1-2 Years</option>
											<option value="2-5yrs">2-5 Years</option>
											<option value="5-10yrs">5-10 Years</option>
											<option value="10more">More Than 10 Years</option> -->
										</select>
									</div>
								</div>
								<div class="col-md-2 col-sm-2">
									<div class="labelWrap">
										<select name="listingCountry" id="listingCountry">
											<option value="">Select Country</option>
											<?php
											if(is_array($countriesData) && count($countriesData)>0) {
												foreach($countriesData as $cKey => $cVal) {
													?>
													<option value="<?php echo $cVal['sortname'];?>" <?php echo ($cVal['sortname'] == $this->security->xss_clean(trim($_GET['listingCountry']))) ? 'selected':''?>><?php echo $cVal['name'].' ('.$cVal['sortname'].')';?></option>
													<?php
												}
											}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-3 col-sm-3">
									<div class="range-sec">
										<div class="caption-sec">
											<div class="caption left-caption">
												<strong>Min:</strong> <span id="slider-range-value1"></span>
											</div>
											<div class="caption right-caption">
												<strong>Max:</strong> <span id="slider-range-value2"></span>
											</div> 
										</div>
										<div id="slider-range"></div> 
									</div>
								</div>
								<input type="hidden" id="pricerangemin" value="<?php echo $maxmin['minPrice'];?>">
								<input type="hidden" id="pricerangemax" value="<?php echo $maxmin['maxPrice'];?>">
							</div>
							<div class="row advsearch" style="display:none">
								<div class="col-md-3 col-sm-3">
									<div class="labelWrap"><label for="">Monthly Profit</label>
									<div class="range-sec">
										<div class="caption-sec">
											<div class="caption left-caption">
												<strong>Min:</strong> <span id="slider-range-value1-profit"></span>
											</div>
											<div class="caption right-caption">
												<strong>Max:</strong> <span id="slider-range-value2-profit"></span>
											</div> 
										</div>
										<div id="slider-range-profit"></div> 
									</div>
									<input type="hidden" name="ProfitFrom" id="profitFrom" value="<?php echo $maxmin['minProfit'];?>">
									<input type="hidden" name="ProfitTo" id="ProfitTo" value="<?php echo $maxmin['maxProfit'];?>">

									<input type="hidden" id="profitrangemin" value="<?php echo $maxmin['minProfit'];?>">
									<input type="hidden" id="profitrangemax" value="<?php echo $maxmin['maxProfit'];?>">
										<!--<select name="ProfitFrom" id="profitFrom">
											<option value="">From</option>
											<option value="less10">Less thank 10M</option>
											<option value="10">10M</option>
											<option value="20">20M</option>
											<option value="30">30M</option>
											<option value="40">40M</option>
											<option value="50">50M</option>
											<option value="60">60M</option>
											<option value="70">70M</option>
											<option value="80">80M</option>
											<option value="90">90M</option>
										</select>
										<div class="error" id="errprofitFrom" style="display:none"></div>-->
									</div>
								</div>
								
								<!--<div class="col-md-2 col-sm-2">
									<div class="labelWrap"><label for="">&nbsp;</label>
										<select name="ProfitTo" id="ProfitTo">
											<option value="">To</option>
											<option value="20">20M</option>
											<option value="30">30M</option>
											<option value="40">40M</option>
											<option value="50">50M</option>
											<option value="60">60M</option>
											<option value="70">70M</option>
											<option value="80">80M</option>
											<option value="90">90M</option>
											<option value="100">100M</option>
											<option value="100more">More than 100M</option>
										</select>
										<div class="error" id="errprofitTo" style="display:none"></div>
									</div>
								</div>-->
								<div class="col-md-3 col-sm-3">
									<div class="labelWrap"><label for="">Monthly Revenue</label>
									<div class="range-sec">
										<div class="caption-sec">
											<div class="caption left-caption">
												<strong>Min:</strong> <span id="slider-range-value1-revenue"></span>
											</div>
											<div class="caption right-caption">
												<strong>Max:</strong> <span id="slider-range-value2-revenue"></span>
											</div> 
										</div>
										<div id="slider-range-revenue"></div> 
									</div>
									<input type="hidden" name="RevenueFrom" id="RevenueFrom" value="<?php echo $maxmin['minRevenue'];?>">
									<input type="hidden" name="RevenueTo" id="RevenueTo" value="<?php echo $maxmin['maxRevenue'];?>">
									<input type="hidden" id="revenuerangemin" value="<?php echo $maxmin['minRevenue'];?>">
									<input type="hidden" id="revenuerangemax" value="<?php echo $maxmin['maxRevenue'];?>">
										<!--<select name="RevenueFrom" id="RevenueFrom">
											<option value="">From</option>
											<option value="less10">Less thank 10M</option>
											<option value="10">10M</option>
											<option value="20">20M</option>
											<option value="30">30M</option>
											<option value="40">40M</option>
											<option value="50">50M</option>
											<option value="60">60M</option>
											<option value="70">70M</option>
											<option value="80">80M</option>
											<option value="90">90M</option>
										</select>
										<div class="error" id="errrevenueFrom" style="display:none"></div>-->
									</div>
								</div>
								
								<!--<div class="col-md-2 col-sm-2">
									<div class="labelWrap"><label for="">&nbsp;</label>
										<select name="RevenueTo" id="RevenueTo">
											<option value="">To</option>
											<option value="20">20M</option>
											<option value="30">30M</option>
											<option value="40">40M</option>
											<option value="50">50M</option>
											<option value="60">60M</option>
											<option value="70">70M</option>
											<option value="80">80M</option>
											<option value="90">90M</option>
											<option value="100">100M</option>
											<option value="100more">More than 100M</option>
										</select>
										<div class="error" id="errrevenueTo" style="display:none"></div>
									</div>
								</div>-->
								<div class="col-md-3 col-sm-3">
									<div class="labelWrap"><label for="">Profit Multiple</label>
									<div class="range-sec">
										<div class="caption-sec">
											<div class="caption left-caption">
												<strong>Min:</strong> <span id="slider-range-value1-multiple"></span>
											</div>
											<div class="caption right-caption">
												<strong>Max:</strong> <span id="slider-range-value2-multiple"></span>
											</div> 
										</div>
										<div id="slider-range-multiple"></div> 
									</div>
									<input type="hidden" name="MultipleFrom" id="MultipleFrom" value="<?php echo $maxmin['minMultiple'];?>">
									<input type="hidden" name="MultipleTo" id="MultipleTo" value="<?php echo $maxmin['maxMultiple'];?>">
									<input type="hidden" id="multiplerangemin" value="<?php echo $maxmin['minMultiple'];?>">
									<input type="hidden" id="multiplerangemax" value="<?php echo $maxmin['maxMultiple'];?>">			


										<!--<select name="MultipleFrom" id="MultipleFrom">
											<option value="">From</option>
											<option value="less10">Less thank 10x</option>
											<option value="10">10x</option>
											<option value="20">20x</option>
											<option value="30">30x</option>
											<option value="40">40x</option>
											<option value="50">50x</option>
											<option value="60">60x</option>
											<option value="70">70x</option>
											<option value="80">80x</option>
											<option value="90">90x</option>
										</select>
										<div class="error" id="errmultipleFrom" style="display:none"></div>-->
									</div>
								</div>
								
								<div class="col-md-3 col-sm-3">
									<?php /* <div class="labelWrap">
										<label for="">Traffic</label>
										<!--<select name="MultipleTo" id="MultipleTo">
											<option value="">To</option>
											<option value="20">20x</option>
											<option value="30">30x</option>
											<option value="40">40x</option>
											<option value="50">50x</option>
											<option value="60">60x</option>
											<option value="70">70x</option>
											<option value="80">80x</option>
											<option value="90">90x</option>
											<option value="100">100x</option>
											<option value="100more">More than 100x</option>
										</select>
										<div class="error" id="errmultipleTo" style="display:none"></div>-->
										<div class="range-sec">
											<div class="caption-sec">
												<div class="caption left-caption">
													<strong>Min:</strong> <span id="slider-range-value1-traffic"></span>
												</div>
												<div class="caption right-caption">
													<strong>Max:</strong> <span id="slider-range-value2-traffic"></span>
												</div> 
											</div>
											<div id="slider-range-traffic"></div> 
										</div>
										<input type="hidden" name="TrafficFrom" id="TrafficFrom" value="<?php echo $maxmin['minTraffic'];?>">
										<input type="hidden" name="TrafficTo" id="TrafficTo" value="<?php echo $maxmin['maxTraffic'];?>">
										<input type="hidden" id="trafficrangemin" value="<?php echo $maxmin['minTraffic'];?>">
										<input type="hidden" id="trafficrangemax" value="<?php echo $maxmin['maxTraffic'];?>">	
									</div> */ ?>
									<div class="labelWrap">
										<label for="">Revenue Multiple</label>
										<div class="range-sec">
											<div class="caption-sec">
												<div class="caption left-caption">
													<strong>Min:</strong> <span id="slider-range-value1-traffic"></span>
												</div>
												<div class="caption right-caption">
													<strong>Max:</strong> <span id="slider-range-value2-traffic"></span>
												</div> 
											</div>
											<div id="slider-range-traffic"></div> 
										</div>
										<input type="hidden" name="TrafficFrom" id="TrafficFrom" value="<?php echo round($maxmin['minRevenueMultiple']); // $maxmin['minTraffic'];?>">
										<input type="hidden" name="TrafficTo" id="TrafficTo" value="<?php echo round($maxmin['maxRevenueMultiple']); // $maxmin['maxTraffic'];?>">
										<input type="hidden" id="trafficrangemin" value="<?php echo round($maxmin['minRevenueMultiple']); // $maxmin['minTraffic'];?>">
										<input type="hidden" id="trafficrangemax" value="<?php echo round($maxmin['maxRevenueMultiple']); // $maxmin['maxTraffic'];?>">	
									</div>
								</div>
							</div>
							<div class="row">
							<div class="col-md-12 col-sm-12" style="text-align: right;"><a href="javascript: void(0)" id="advsrchlink">Advanced search</a></div>
							</div>
							<input type="hidden" name="min" id="min-value" value="<?php echo ($this->security->xss_clean(trim($_GET['min']))>0) ? $this->security->xss_clean(trim($_GET['min'])):$maxmin['minPrice']; ?>">
              				<input type="hidden" name="max" id="max-value" value="<?php echo ($this->security->xss_clean(trim($_GET['min']))>0) ? $this->security->xss_clean(trim($_GET['max'])):$maxmin['maxPrice']; ?>">
							<input type="hidden" name="page" id="pagelisting" value="<?php echo ($listingPage+$listingLimit)?>">
							<input type="hidden" name="limit" id="limitlisting" value="<?php echo $listingLimit?>">
							<input type="hidden" name="userId" id="loggedUser" value="<?php echo $loggedUser?>">
							<!--<button type="submit" class="btn search-button">Find Listing</button>-->
							</form>
						</div>
					
					</div>
					<div class="d-block search-result-txt dynamic-page">
					<?php
					$totalrec = $allMarketPaceDetailsPagePosition[0]+count($allMarketPaceDetails);
					?>
						<!-- <?php //echo $allMarketPaceDetailsPagePosition[0]+1?>-<?php //echo $totalrec?> records out of <?php //echo $allMarketPaceDetailsPagePosition[2]?> records found.... -->
						<?php echo $allMarketPaceDetailsPagePosition[2]?> listings found

					</div>
					<div class="latest-list mt30">
						<ul class="ul mpul">
						
							<?php
							if(is_array($allMarketPaceDetails) && count($allMarketPaceDetails)>0)
							{
								foreach($allMarketPaceDetails as $val)
								{
									?>
									<li data-aos="fade-up" data-aos-duration="2200">
										<div class="box">
										<?php
										if($val['Status'] == 4 && $val['buyer']>0) 
										{
											if($val['buyer'] == $loggedUser)
											{
												?>
												<div class="sold2">Congrats <span>You won this listing!</span></div>
												<?php
											}elseif($val['seller'] == $loggedUser)
											{
												?>
												<div class="sold2">Congrats <span>This listing as sold!</span></div>
												<?php
											}else{
												?>
												<div class="sold">sold</div>
												<?php
											

											}
											?>
										<!-- =============================SOLD========================== -->
										
										<?php
										}
										?>
											<div class="row">
												<div class="col-md-2 col-sm-2 img-sec">
													<a href="<?php echo base_url();?>listing/<?php echo $val['listing_id'];?>" <?php echo ($val['unlocked'] == true) ? '' : 'class="lock"'; ?> >
													<img src="<?php echo base_url();?><?php echo ($val['unlocked'] == true) ? 'uploads/business_image/'.$val["business_image"] : 'assets/frontend/images/sample/banner.jpg'; ?> " alt="">
														
													</a>
												</div>
												<div class="col-md-8">
													<a href="<?php echo base_url();?>listing/<?php echo $val['listing_id'];?>" class="d-block">
														<div class="mid-block d-flex justify-content-between">
															<div class="block">
																<div class="head">Industry</div>
																<span><?php echo $val['industryname'];?></span>
															</div>
															<div class="block">
																<div class="head">Monetization</div>
																<span><?php //echo $val['monetizationStr'];
																echo mb_strimwidth($val['monetizationStr'], 0, 70, '...');
																?></span>
															</div>
															<div class="block">
																<div class="head">Business Age</div>
																<span><?php echo $val['business_age'];?></span>
															</div>
															<div class="block">
																<div class="head">Net Profit</div>
																<span>$<?php echo number_format($val['monthly_profit'],0,'.',',');?> p/mo</span>
															</div>
															<div class="block">
																<div class="head">Revenue</div>
																<span>$<?php echo number_format($val['monthly_revenue'],0,'.',',');?> p/mo</span>
															</div>
															<?php /* <div class="block">
																<div class="head">Traffic</div>
																<span><?php echo number_format($val['traffic_per_month'],0,'.',',');?> p/mo</span>
															</div> */ ?>
															<!--<div class="block">
																<div class="head">Status</div>
																<span><?php 
																/*if($val['Status'] == 1)
																{
																	//echo 'Active';
																}elseif($val['Status'] == 3)
																{
																	//echo 'Pending';
																}elseif($val['Status'] == 4)
																{
																	//echo 'Sold';
																}*/
																?></span>
															</div>-->
														</div>
														<div class="starting-price">
															<span>Listing Price</span>:&nbsp;$<?php echo number_format($val['price'],0,'.',',');;?>
															<span class="multiple"><span><?php echo $val['multiple'];?>x Profit Multiple</span></span>
															<span class="multiple yellowbaba"><span><?php echo $val['revenue_multiple'];?>x Revenue Multiple</span></span>
														</div>
													</a>
												</div>
												<div class="col-md-2">
													<div class="right-block">
														<div class="location"><?php
														if($val['countryname']!=''){
															?>
														<i class="fa fa-map-marker" aria-hidden="true"></i>
														<?php echo $val['countryname'];
														}?></div>
														
														<div class="d-block">
															<a href="<?php echo base_url();?>listing/<?php echo $val['listing_id'];?>" class="btn" style="margin-top:10px;">View Listing</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</li>
									<?php
								}
							}
							?>
						</ul>
					</div>
					<?php
					if($allMarketPaceDetailsPagePosition[2] > $allMarketPaceDetailsPagePosition[1])
					{
						?>
							<hr class="mt40 pagHr">
							<!--<div class="pagination mt20 mb20"> 
								<?php //echo $links?> 
							</div>
							<div style='margin-top: 10px;' id='pagination'></div>
							<hr class="pagHr">-->
							<button class="btn loadmoremp">Load More</button>
						<?php
					}
					?>
				</div>
			</div>
		</section> 
		<?php
		if(is_array($testimonial) && count($testimonial)>0)
		{
			?>
		<section class="section home-testimonial">
			<div class="container">
				<div class="testimonial_list">
					<div class="owl-carousel test-slider">
					<?php
						foreach($testimonial as $val)
						{
							?>
							<div class="item" data-aos="fade-down" data-aos-duration="2200">
							<div class="sk_box withIcon"> 
								<div class="sk_text">
									<div class="para mCustomScrollbar">
										<p><?php echo $val['description'];?></p>
									</div>
									<div class="tbottom">
										<div class="subheading"><?php echo $val['author'];?> <span><?php echo $val['designation'];?></span></div> 
									</div> 
								</div>
							</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</section>
		<?php
		}
		?>
		<section class="section home-work">
			<div class="container">
				<figure class="img-left mr50" data-aos="fade-right" data-aos-duration="2200"><img src="<?php echo base_url();?>uploads/images_extra/<?php echo $homecontents[3]['content']['image']?>" alt=""></figure>
				<div class="text" data-aos="fade-up" data-aos-duration="2200">
					<h2 class="heading"><?php echo $homecontents[3]['content']['title']?></h2>
					<!--<div class="subhead"><span>$100+</span> Million of Online Businesses Sold</div>-->
					<p><?php echo $homecontents[3]['content']['short_description']?></p>
					<!--<p>Nunc facilisis eros sit amet est vestibulum tempor. In sed sollicitudin augue. Cras sit amet purus sapien. Aenean vulputate dignissim diam non ornare.</p>-->
				</div>
				<div class="work-bottom-list">
					<ul class="ul row">
						<li class="col-md-4" data-aos="fade-up" data-aos-duration="2200">
							<div class="box">
								<div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
								<span>01.</span>
								<h2 class="subheading"><?php echo $homecontents[3]['steps'][0]['title']?></h2>
								<div class="para"><?php echo $homecontents[3]['steps'][0]['description']?></div>
							</div>
						</li>
						<li class="col-md-4" data-aos="fade-up" data-aos-duration="2200">
							<div class="box">
								<div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
								<span>02.</span>
								<h2 class="subheading"><?php echo $homecontents[3]['steps'][1]['title']?></h2>
								<div class="para"><?php echo $homecontents[3]['steps'][1]['description']?></div>
							</div>
						</li>
						<li class="col-md-4" data-aos="fade-up" data-aos-duration="2200">
							<div class="box">
								<div class="tick"><i class="fa fa-check" aria-hidden="true"></i></div>
								<span>03.</span>
								<h2 class="subheading"><?php echo $homecontents[3]['steps'][2]['title']?></h2>
								<div class="para"><?php echo $homecontents[3]['steps'][2]['description']?>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</section>
		<section class="section online-business" data-aos="fade-up" data-aos-duration="2200">
			<div class="container">
				<div class="d-flex justify-content-between align-items-center">
					<div class="left">
						<h2 class="heading   mb-0">Have an Online Business to Sell?</h2>
						<div class="short-desc">Check out the online tools below to sell or value your business</div>
					</div>
					<div class="right">
						<div class="btn-group">
							<a href="#" class="btn btn-ylw">Sell My Online Business </a>
							<a href="#" class="btn ml-2">Try Valuation Tool </a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
		if(is_array($partners) && count($partners)>0)
		{
			?>
			<section class="section client">
			<div class="container">
				<div class="owl-carousel client-slider">
					<?php
					foreach($partners as $val)
					{
						?>
						<div class="item">
						<?php
								if($val['partner_url'] !='')
								{
									?>
									<a href="<?php echo $val['partner_url']?>">
									<?php
								}
							?>
							<figure><img src="<?php echo base_url();?>uploads/partner-image/<?php echo $val['partner_image'];?>" alt=""></figure>
							<?php
								if($val['partner_url'] !='')
								{
									?>
									</a>
									<?php
								}
							?>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</section>
			<?php
		}
		?>
		<!--<div class="container">
			<div class="latest-list grid-view mt30">
				<ul class="ul row">
					<li data-aos="fade-up" data-aos-duration="2200" class="col-md-4 col-sm-6">
						<div class="box">
							<div class="row">
								<div class="col-md-12 col-sm-12 img-sec">
									<a href="https://eclickprojects.com/qeip-llc/listing/9186035" class="lock"><img src="https://eclickprojects.com/qeip-llc/assets/frontend/images/sample/banner.jpg" alt=""></a>
								</div>
								<div class="col-md-12">
									<a href="https://eclickprojects.com/qeip-llc/listing/9186035" class="d-block">
										<div class="mid-block d-flex justify-content-between" style="flex-wrap: wrap;">
											<div class="block">
												<div class="head">Industry</div>
												<span>Ecommerce</span>
											</div>
											<div class="block">
												<div class="head">Monetization</div>
												<span>Amazon Associates, Application, Ecommerce, SaaS</span>
											</div>
											<div class="block">
												<div class="head">Business Age</div>
												<span>1 year 7 months old</span>
											</div>
											<div class="block">
												<div class="head">Net Profit</div>
												<span>$95,000 p/mo</span>
											</div>
											<div class="block">
												<div class="head">Traffic</div>
												<span>2,835 p/mo</span>
											</div>   
										</div>
										<div class="starting-price"><span>Starting Price - </span>$12,000</div>
									</a>
								</div>
								<div class="col-md-12">
									<div class="right-block">
										<div class="location"><i class="fa fa-map-marker" aria-hidden="true"></i>United Kingdom</div>
										<span class="multiple"><img src="https://eclickprojects.com/qeip-llc/assets/frontend/images/multiple.png" alt=""><span>Multiple 12x</span></span>
										<div class="d-block">
											<a href="https://eclickprojects.com/qeip-llc/listing/9186035" class="btn">View Listing</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>-->
	</main>
	<div id="mpelement" style="display:none">
		<li data-aos="fade-up" data-aos-duration="2200">
		<div class="box">
			[SOLD]
			<div class="row">
				<div class="col-md-2 col-sm-2 img-sec">
					<a href="<?php echo base_url();?>listing/LISTINGID" [LOCK] ><img src="<?php echo base_url();?>[IMAGEURL]" alt=""></a>
				</div>
				<div class="col-md-8">
					<a href="<?php echo base_url();?>listing/LISTINGID" class="d-block">
						<div class="mid-block d-flex justify-content-between">
							<div class="block">
								<div class="head">Industry</div>
								<span>[INDUSTRY]</span>
							</div>
							<div class="block">
								<div class="head">Monetization</div>
								<span>[MONETIZATION]</span>
							</div>
							<div class="block">
								<div class="head">Business Age</div>
								<span>[SITEAGE]</span>
							</div>
							<div class="block">
								<div class="head">Net Profit</div>
								<span>$[NETPROFIT] p/mo</span>
							</div>
							<div class="block">
								<div class="head">Revenue</div>
								<span>$[REVENUE] p/mo</span>
							</div>
							<?php /* <div class="block">
								<div class="head">Traffic</div>
								<span>[TRAFFIC] p/mo</span>
							</div> */ ?>  
						</div>
						<div class="starting-price">
							<span>Listing Price</span>:&nbsp;$[PRICE]
							<span class="multiple"><span>[MULTIPLE]x Profit Multiple</span></span>
							<span class="multiple yellowbaba"><span>[REVENUE_MULTIPLE]x Revenue Multiple</span></span>
						</div>
					</a>
				</div>
				<div class="col-md-2">
					<div class="right-block">
						<div class="location">[COUNTRYNAME]</div>
						<div class="d-block">
							<a href="<?php echo base_url();?>listing/LISTINGID" class="btn" style="margin-top:10px;">View Listing</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		</li>
	</div>