<main class="mainContainer">  
		<section class="section latest-listing">
			<div class="container">
				<div class="d-flex top-head-sec flex-wrap mb30">
					<div>
						<h2 class="heading">Our Newest Offerings</h2>
						
						<p>Updated weekly, here is the most recent list of businesses that we have for sale.</p>


					</div>
					<div class="ml-auto">
						<div class="wrap ul d-flex justify-content-between flex-wrap">
							<div class="list"><a href="javascript: void(0)"><span><?php echo $totalnumberofnewlisting;?> New Listings Published</span></a></div>
							<div class="list"><a href="<?php echo base_url();?>marketplace"><span><?php echo $totalnumberoflisting;?> Listings Total</span></a></div>
						</div>
					</div>
				</div>
				<div class="latest-list">
					<ul class="ul">
					<?php
					//print '<pre>';
					//print_r($recentBusiness);
					foreach($recentBusiness as $rb)
					{ 
						$monetizationstrrb = '';
						//print '';
						?>
						<li data-aos="fade-up" data-aos-duration="2200">
						<div class="box">
						<?php
										if($rb['Status'] == 4) 
										{
											if($rb['buyer'] == $loggedIn)
											{
												?>
												<div class="sold2">Congrats<span>you won this listing!</span></div>
												<?php
											}elseif($rb['seller'] == $loggedIn)
											{
												?>
												<div class="sold2">Congrats<span>this listing as sold!</span></div>
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
									<a href="<?php echo base_url();?>listing/<?php echo $rb['listing_id'];?>" <?php echo ($rb['unlocked'] == true) ? '' : 'class="lock"'; ?>><img src="<?php echo base_url();?><?php echo ($rb['unlocked'] == true) ? 'uploads/business_image/'.$rb["business_image"] : 'assets/frontend/images/sample/banner.jpg'; ?>" alt=""></a>
								</div>
								<div class="col-md-8">
									<a href="<?php echo base_url();?>listing/<?php echo $rb['listing_id'];?>" class="d-block">
										<div class="mid-block d-flex justify-content-between">
											<div class="block">
												<div class="head">Industry</div>
												<span><?php echo $rb['industryname'];?></span>
											</div>
											<div class="block">
												<div class="head">Monetization</div>
												<span><?php
												//echo $rb['monetizationStr'];
												echo mb_strimwidth($rb['monetizationStr'], 0, 70, '...');?>
												</span>
											</div>
											<div class="block">
												<div class="head">Business Age</div>
												<span><?php echo $rb['business_age'];?></span>
											</div>
											<div class="block">
												<div class="head">Net Profit</div>
												<span>$<?php echo number_format($rb['monthly_profit'], 0, '.', ',')?> p/mo</span>
											</div>
											<div class="block">
												<div class="head">Revenue</div>
												<span>$<?php echo number_format($rb['monthly_revenue'], 0, '.', ',')?> p/mo</span>
											</div>
											<div class="block">
												<div class="head">Traffic</div>
												<span><?php echo number_format($rb['traffic_per_month'], 0, '.', ',')?> p/mo</span>
											</div>   
										</div>
										<div class="starting-price">
											<span>Listing Price</span>:&nbsp;$<?php echo number_format($rb['price'], 0, '.', ',')?>

											<span class="multiple"><img src="<?php echo base_url();?>assets/frontend/images/multiple.png" alt=""><span><?php echo $rb['multiple'];?>% Cash Yield</span></span>
										</div>
									</a>
								</div>
								<div class="col-md-2">
									<div class="right-block">
										<div class="location"><i class="fa fa-map-marker" aria-hidden="true"></i>
										<a href="<?php echo base_url();?>listing/<?php echo $rb['listing_id'];?>"><?php echo $rb['countryname'];?></a></div>
										
										<div class="d-block">
											<a href="<?php echo base_url();?>listing/<?php echo $rb['listing_id'];?>" class="btn" style="margin-top:10px">View Listing</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						</li>
						<?php
					}
					?>
					</ul>
				</div>
				<div data-aos="fade-up" data-aos-duration="2200" class="btn_center">
					<a href="<?php echo base_url();?>marketplace" class="btn">View All <?php echo $totalnumberoflisting;?> Listings </a>
				</div>
			</div>
		</section>
		<section class="section whats-nbp">
			<div class="container">
				<div class="heading text-center w">What Is FIH.com?</div>
				<p class="small-desc text-center">We are an application-based online business marketplace for top level investors & owners.</p>
				<div class="nbp-list">
					<ul class="ul row">
						<li class="col-md-4" data-aos="zoom-in" data-aos-duration="2200">
							<div class="box">
								<figure class="icon"><img src="<?php echo base_url();?>assets/frontend/images/n1.png" alt=""></figure>
								<h2 class="subheading"><?php echo $homecontents[0]['npb_title1']?></h2>
								<div class="para"><?php echo $homecontents[0]['npb_description1']?></div>
							</div>
						</li>
						<li class="col-md-4" data-aos="zoom-in" data-aos-duration="2200">
							<div class="box">
								<figure class="icon"><img src="<?php echo base_url();?>assets/frontend/images/n2.png" alt=""></figure>
								<h2 class="subheading"><?php echo $homecontents[0]['npb_title2']?></h2>
								<div class="para"><?php echo $homecontents[0]['npb_description2']?></div>
							</div>
						</li>
						<li class="col-md-4" data-aos="zoom-in" data-aos-duration="2200">
							<div class="box">
								<figure class="icon"><img src="<?php echo base_url();?>assets/frontend/images/n3.png" alt=""></figure>
								<h2 class="subheading"><?php echo $homecontents[0]['npb_title3']?></h2>
								<div class="para"><?php echo $homecontents[0]['npb_description3']?></div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</section>
		<section class="section how-it-work">
			<div class="container">
				<div class="heading text-center">How We Operate</div>
				<div class="short-desc text-center">Depending on if you are a buyer or seller, we have an individualized process for you.</div>
				<div class="work-list">
					<ul class="row ul">
						<li class="col-md-12" data-aos="zoom-in" data-aos-duration="2200">
							<div class="box">
								<figure class="img">
									<img src="<?php echo base_url();?>uploads/images_extra/<?php echo $homecontents[1]['content']['image']?>" alt="">
								</figure>
								<div class="text">
									<div class="left-text">Buyers</div>
									<div class="subheading"><?php echo $homecontents[1]['content']['title']?></div>
									<p><?php echo $homecontents[1]['content']['short_description']?></p>
									<div class="btn-left">
										<a href="<?php echo base_url();?>how-it-works/buyer#buyer" class="btn">How To Buy A Business</a>
									</div>
								</div>
							</div>
						</li>
						<li class="col-md-12" data-aos="zoom-in" data-aos-duration="2200">
							<div class="box">
								<figure class="img">
									<img src="<?php echo base_url();?>uploads/images_extra/<?php echo $homecontents[2]['content']['image']?>" alt="">
								</figure>
								<div class="text">
									<div class="left-text">Sellers</div>
									<div class="subheading"><?php echo $homecontents[2]['content']['title']?> </div>
									<p><?php echo $homecontents[2]['content']['short_description']?></p>
									<div class="btn-left">
										<a href="<?php echo base_url();?>how-it-works/seller#seller" class="btn">How To Sell A Business</a>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</section>
		<!--
		<section class="section domain-section">
			<div class="container">
				<div class="heading w">Find The Perfect Domain For Your Idea</div>
				<div class="short-desc">Search premium, undeveloped and parked domains</div>
				<a href="#" class="btn right-btn">View more</a>
				<div class="domain-wrap" data-aos="fade-up" data-aos-duration="2200">
					<ul class="ul row">
						<li class="col-md-4">
							<div class="box">
								<a href="#"><div class="subheading">Sponsored<i class="fa fa-long-arrow-right" aria-hidden="true"></i></div></a>
								<div class="wrap-div">
									<div class="list d-flex align-items-center justify-content-between">
										<span>intelligentdna.com</span>
										<span>$1,000</span>
									</div>
									<div class="list d-flex align-items-center justify-content-between">
										<span>EnergyWhey.com</span>
										<span>$199</span>
									</div>
									<div class="list d-flex align-items-center justify-content-between">
										<span>s2n.com</span>
										<span>$100,000</span>
									</div>
									<div class="list d-flex align-items-center justify-content-between">
										<span>self-isolating.com</span>
										<span>$2,050</span>
									</div>
									<div class="list d-flex align-items-center justify-content-between">
										<span>sheerarmor.com</span>
										<span>$2,500</span>
									</div>
									<div class="list d-flex align-items-center justify-content-between">
										<span>intelligentdna.com</span>
										<span>$1,000</span>
									</div> 
								</div>
							</div>
						</li>
						<li class="col-md-4">
							<div class="box">
								<a href="#"><div class="subheading">Sponsored<i class="fa fa-long-arrow-right" aria-hidden="true"></i></div></a>
								<div class="wrap-div">
									<div class="list d-flex align-items-center justify-content-between">
										<span>intelligentdna.com</span>
										<span>$1,000</span>
									</div>
									<div class="list d-flex align-items-center justify-content-between">
										<span>EnergyWhey.com</span>
										<span>$199</span>
									</div>
									<div class="list d-flex align-items-center justify-content-between">
										<span>s2n.com</span>
										<span>$100,000</span>
									</div>
									<div class="list d-flex align-items-center justify-content-between">
										<span>self-isolating.com</span>
										<span>$2,050</span>
									</div>
									<div class="list d-flex align-items-center justify-content-between">
										<span>sheerarmor.com</span>
										<span>$2,500</span>
									</div>
									<div class="list d-flex align-items-center justify-content-between">
										<span>intelligentdna.com</span>
										<span>$1,000</span>
									</div> 
								</div>
							</div>
						</li>
						<li class="col-md-4">
							<div class="box">
								<a href="#"><div class="subheading">Sponsored<i class="fa fa-long-arrow-right" aria-hidden="true"></i></div></a>
								<div class="wrap-div">
									<div class="list d-flex align-items-center justify-content-between">
										<span>intelligentdna.com</span>
										<span>$1,000</span>
									</div>
									<div class="list d-flex align-items-center justify-content-between">
										<span>EnergyWhey.com</span>
										<span>$199</span>
									</div>
									<div class="list d-flex align-items-center justify-content-between">
										<span>s2n.com</span>
										<span>$100,000</span>
									</div>
									<div class="list d-flex align-items-center justify-content-between">
										<span>self-isolating.com</span>
										<span>$2,050</span>
									</div>
									<div class="list d-flex align-items-center justify-content-between">
										<span>sheerarmor.com</span>
										<span>$2,500</span>
									</div>
									<div class="list d-flex align-items-center justify-content-between">
										<span>intelligentdna.com</span>
										<span>$1,000</span>
									</div> 
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</section>
		-->
		<section class="section home-work">
			<div class="container">
				<figure class="img-left mr50" data-aos="fade-right" data-aos-duration="2200"><img src="<?php echo base_url();?>uploads/images_extra/<?php echo $homecontents[3]['content']['image']?>" alt=""></figure>
				<div class="text" data-aos="fade-up" data-aos-duration="2200">
					<h2 class="heading"><?php echo $homecontents[3]['content']['title']?></h2>
					<!--<div class="subhead"><span>$100+</span> Million of Online Businesses Sold</div>-->
					<p><?php echo $homecontents[3]['content']['short_description']?></p>
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
								<div class="para"><?php echo $homecontents[3]['steps'][1]['description']?> </div>
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
		
		<section class="section online-business" data-aos="fade-up" data-aos-duration="2200">
			<div class="container">
				<div class="d-flex justify-content-between align-items-center">
					<div class="left">
						<h2 class="heading   mb-0">Have an Online Business to Sell?</h2>
						<div class="short-desc">Check out the online tools below to sell or value your business</div>
					</div>
					<div class="right">
						<div class="btn-group">
							<a href="<?php echo base_url();?>user/sell-your-business" class="btn btn-ylw">Sell My Online Business </a>
							<a href="<?php echo base_url();?>getfreevaluation" class="btn ml-2">Try Valuation Tool </a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
						if(is_array($blogs) && count($blogs)>0)
						{
							?>
		<section class="section home-blog">
			<div class="container">
				 <h2 class="heading text-center mb15">Latest Blog Posts</h2>
				 <div class="short-desc text-center mb30">Lorem ipsum dolor sit amet, consectetur adipiscing elit.Vestibulum malesuada porttitor mauris.</div>
				<div class="blog_list">
					<ul class="ul row">
					<?php
						if(is_array($blogs) && count($blogs)>0)
						{
							foreach($blogs as $k=>$v)
							{

								$blogImage = explode(',',$v['blogImage']);
								?>
								<li class="col-md-4" data-aos="fade-up" data-aos-duration="2200">
								<div class="box">
									<a href="<?php echo base_url();?>blog/<?php echo $v['blogSlug']?>">
									<figure><img src="<?php echo base_url();?>uploads/images_blog/<?php echo $blogImage[0];?>" alt=""></figure>
									<div class="text">
										<h2 class="subheading"><?php echo $v['blogName']?></h2>
										<div class="para"><?php echo substr($v['blogDescription'],0,200); ?>...</div>
										<div class="bottom">
											<span class="admin">By Admin</span>
											<span class="date"><?php echo date('jS M Y',strtotime($v['addedOn']))?></span>
											<div class="btn"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></div>
										</div>
									</div>
									</a>
								</div>
							</li> 
								
								
								<?php
							}
						}
                ?>
					</ul>
				</div>
				<div class="btn_center" data-aos="fade-up" data-aos-duration="2200">
					<a href="<?php echo base_url();?>blog" class="btn">View All</a>
				</div>
			</div>
		</section>
		<?php
						}
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
		
 
	</main> 