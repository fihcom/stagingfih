<main class="mainContainer">  
		<section class="section seller-dashboard">
			<div class="container">
				<div class="d-flex tab-head-sec flex-wrap mb30">
					<div>
						<h2 class="heading">Seller Dashboard</h2> 
						
					</div>
					<div class="ml-auto">
						<a href="<?php echo base_url();?>user/sell-your-business" class="btn">Sell Your Business</a>
					</div>
					<div class="d-block w-100">
						<div class="dashboard-wrap mt30">
							<div class="js-tabs" data-aos="fade-left" data-aos-duration="2400">
								<nav>
									<ul class='tabs'>
									<li data-tab-id='tab1' <?php echo ($firstslide=='Y')? 'class="active"':''?>>My Listings</li>
									<li data-tab-id='tab2' <?php echo ($this->session->flashdata('slidetab')==2)? 'class="active"':''?>>Offers</li>
									<li data-tab-id='tab7' <?php echo ($this->session->flashdata('slidetab')==7)? 'class="active"':''?>>Sold Listings</li>
									<!--<li data-tab-id='tab3' <?php echo ($this->session->flashdata('slidetab')==3)? 'class="active"':''?>>Upcoming Calls</li>-->
									<li data-tab-id='tab8'>applications</li>
									<li data-tab-id='tab4'>Valuations</li>
									<li data-tab-id='tab5'>Resources</li>
									<li data-tab-id='tab6'>Questions</li>
									
									</ul>
								</nav>
								
								<div class='panels'>
									<div id='tab1' class='content <?php echo ($firstslide=='Y')? 'active':''?>'>
									<div class="latest-list">
											<ul class="ul">

											<?php
											if(is_array($sellerListing) && count($sellerListing)>0)
											{
											foreach($sellerListing as $rb)
											{
												//print '<pre>';
												//echo $LogginUser;
												//print_r($rb);
												$monetizationstrrb = '';
												?>
												<li data-aos="fade-up" data-aos-duration="2200">
												<div class="box">
												<?php
													if($rb['Status'] == 4 && $rb['seller'] == $LogginUser) 
													{
														?>
													<!-- =============================SOLD========================== -->
													<div class="sold2">
													Congrats<span>this listing as sold!</span>
													</div>
													<?php
													}
													?>
													<div class="row">
														<div class="col-md-2 col-sm-2 img-sec">
															<a href="<?php echo base_url();?>listing/<?php echo $rb['listing_id'];?>" <?php echo ($rb['unlocked'] == true) ? '' : 'class="lock"'; ?>><img src="<?php echo base_url();?><?php echo ($rb['unlocked'] == true) ? 'uploads/business_image/'.$rb["business_image"] : 'assets/frontend/images/sample/banner.jpg'; ?>" alt=""></a>
														</div>
														<div class="col-md-8 latest-list-middleCol">
															<a href="<?php echo base_url();?>listing/<?php echo $rb['listing_id'];?>" class="d-block">
																<div class="mid-block d-flex justify-content-between">
																	<div class="block">
																		<div class="head">Industry</div>
																		<span><?php echo $rb['industryname'];?></span>
																	</div>
																	<div class="block">
																		<div class="head">Monetization</div>
																		<span><?php //echo $rb['monetizationStr'];
																			echo mb_strimwidth($rb['monetizationStr'], 0, 70, '...');
																		?>
																		
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
																	<?php /* <div class="block">
																		<div class="head">Traffic</div>
																		<span><?php echo number_format($rb['traffic_per_month'], 0, '.', ',')?> p/mo</span>
																	</div> */ ?>  
																	<div class="block">
																
															</div> 
																</div>
																<div class="starting-price">
																	<span>Listing Price</span>:&nbsp;$<?php echo number_format($rb['price'], 0, '.', ',')?>
																	<span class="multiple"><img src="<?php echo base_url();?>assets/frontend/images/multiple.png" alt=""><span><?php echo $rb['multiple'];?>% Cash Yield</span></span>
																</div>
															</a>
														</div>
														<div class="col-md-2 latest-list-bottomCol">
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
										}else{
												echo 'No data found.';
											}
											?>
											</ul>
										</div>
									</div>
									<div id='tab7' class='content'>
										<!-- Start of Meetings Embed Script -->
										<div class="latest-list">
											<ul class="ul">

											<?php
											if(is_array($SoldList) && count($SoldList)>0)
											{
											foreach($SoldList as $rb)
											{
												$monetizationstrrb = '';
												?>
												<li data-aos="fade-up" data-aos-duration="2200">
												<div class="box">
												<?php
													if($rb['Status'] == 4 && $LogginUser == $rb['seller']) 
													{
														?>
													<!-- =============================SOLD========================== -->
													<div class="sold2">
													Congrats<span>this listing as sold!</span>
													</div>
													<?php
													}
													?>
													<div class="row">
														<div class="col-md-2 col-sm-2 img-sec">
															<a href="<?php echo base_url();?>listing/<?php echo $rb['listing_id'];?>" ><img src="<?php echo base_url();?><?php echo 'uploads/business_image/'.$rb["business_image"]; ?>" alt=""></a>
														</div>
														<div class="col-md-8 latest-list-middleCol mult-text">
															<a href="<?php echo base_url();?>listing/<?php echo $rb['listing_id'];?>" class="d-block">
																<div class="mid-block flex-wrap d-flex justify-content-between">
																	<div class="block">
																		<div class="head">Industry</div>
																		<span><?php echo $rb['industryname'];?></span>
																	</div>
																	<div class="block">
																		<div class="head">Monetization</div>
																		<span><?php
																			//echo $rb['monetizationStr'];
																			echo mb_strimwidth($rb['monetizationStr'], 0, 70, '...');
																		?></span>
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
																	<?php /* <div class="block">
																		<div class="head">Traffic</div>
																		<span><?php echo number_format($rb['traffic_per_month'], 0, '.', ',')?> p/mo</span>
																	</div> */ ?>
																	<div class="block">
																		<div class="head">Business transfer Status</div>
																		<span><?php 
																		if($rb['transfer_status'] == 1) {
																			echo 'Unpaid';
																		} elseif($rb['transfer_status'] == 2) {
																			echo 'Funds Received';
																		} elseif($rb['transfer_status'] == 3) {
																			echo 'Transfer Pending';
																		} elseif($rb['transfer_status'] == 4) {
																			echo 'Completed';
																		}
																		?></span>
																	</div> 
																	<div class="block">
																		<div class="head">Fih.com Commission</div>
																		<span>$<?php echo $rb['commissionAmount']?></span> 
																	</div>
																	<div class="block">
																		<div class="head">Net Proceeding</div>
																		<span>$<?php echo $rb['transferAmount']?></span> 
																	</div> 
																</div> 
																<div class="d-flex">
																	<div class="starting-price">
																		<span>Listing Price</span>:&nbsp;
																		<?php
																			if($rb['offer_price'] > 0)
																			{
																		?>
																		<em class="line-through">$<?php echo number_format($rb['price'], 0, '.', ',')?></em>
																		<?php
																			}else{

																				echo '$'.number_format($rb['price'], 0, '.', ',');
																			}
																		?>

																	</div>
																	<?php
																	if($rb['offer_price'] > 0)
																	{
																		?>
																		<div class="starting-price offer-price ml-3">
																			<span>Offer Price</span>:&nbsp;$<?php echo number_format($rb['offer_price'], 0, '.', ',')?>
																		</div>
																		<?php
																	}
																	?>
																	<span class="multiple"><span><?php echo $rb['multiple'];?>Profit Multiple</span></span>
																	
																</div>
															</a>
														</div>
														<div class="col-md-2 latest-list-bottomCol">
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
										}else
										{
											echo 'No data found.';
										}
											?>
											</ul>
										</div>
									</div>
									<div id='tab2' class='content  <?php echo ($this->session->flashdata('slidetab')==2)? 'active':''?>'>  
									<div id="offertab">
									<?php
										$success = $this->session->flashdata('successoffer');
										if($success) { 
											?>
										<div class="alert alert-success alert-dismissable">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
										<?php echo $this->session->flashdata('successoffer'); ?>
										</div>
											<?php 
										} 
										$error = $this->session->flashdata('failedoffer');
										if($error) { 
											?>
										<div class="alert alert-danger alert-dismissable">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
										<?php echo $this->session->flashdata('failedoffer'); ?>
										</div>
											<?php 
										} 
										?>
										<div id="offerdata">
										<?php
											if(is_array($sellerOffers['record']) && count($sellerOffers['record'])>0 && $sellerOffers['totalrecord']['totalrecord']>0)
											{
												foreach($sellerOffers['record'] as $k=>$v)
												{
													/*if($v['user_profile_pic'] !='')
													{
														$profilePic = 'uploads/profile_pictures/'.$v['user_profile_pic'];
													}else{
														$profilePic = 'assets/frontend/images/male.png';
													}*/
													$profilePic = 'assets/frontend/images/male.png';
													?>

													<div class="admin-reply">
														<div class="top">
															<span class="admin-reply-icon" style="width:100px;"><img src="<?php echo base_url().$profilePic;?>" alt="" ></span>
															<span class="seller-id"><strong>Listing #:</strong><a href="<?php echo base_url();?>listing/<?php echo $v['listing_id'];?>" target="_blank"><?php echo $v['listing_id'];?></a></span>
															
															<div class="name">Potential Buyer</div>
															<div class="date"><?php echo $v['offerDate'];?></div>
															<span class="pull-right"><?php 
															if($v['status'] == 1)
															{
																echo '<a href="javascript: void(0)" onclick="javascript: approveoffer(this)" class="btn btn-primary offerapprove'.$v['id'].'" data-href="'.base_url().'user/sell/approveoffer/'.$v['id'].'">Approve Offer</a>
																<a href="javascript: void(0)" onclick="javascript: rejectoffer(this)" class="btn btn-danger offerreject'.$v['id'].'" data-href="'.base_url().'user/sell/rejectoffer/'.$v['id'].'">Reject Offer</a>';
															}
														?></span>
														</div>
														<div class="text">Offer Price: <?php echo $sellerOffers['currency']['symbol'].$v['offer_price'];?></div>
														<div class="text">Offer Status: <?php 
															if($v['status'] == 1)
															{
																echo '<span class="red">Pending</span>';
															}elseif($v['status'] == 2)
															{
																echo '<span class="green">Approved</span>';
															}elseif($v['status'] == 3)
															{
																echo '<span class="red">Rejected</span>';
															}
														?></div>
															<!--<div class="seller-reply" id="sellerreply<?php echo $v['id'];?>" <?php echo ($v['offer_description']!='')?'': 'style="display:none";'?>>
																<label for="">Description</label>
																<div class="reply-box" id="sellerreplytext<?php echo $v['id'];?>"><?php echo $v['offer_description'];?></div>
															</div>-->
														
													</div>
													
													<?php
												}
												?>
												<div class="seller_offer_skeleton" style="display:none">
												<div class="admin-reply">
														<div class="top">
															<span class="admin-reply-icon" style="width:100px;"><img src="<?php echo base_url().'assets/frontend/images/male.png';?>" alt="" ></span>
															<span class="seller-id"><strong>Listing #:</strong><a href="<?php echo base_url();?>listing/listingnooffer" target="_blank">listingnooffer</a></span>
															<div class="name">Potential Buyer</div>
															<div class="date">[DATEOFFER]</div>
															<span class="pull-right" approveofferhide><a href="javascript: void(0)" onclick="javascript: approveoffer(this)" class="btn btn-primary offerapproveofferid" data-href="<?php echo base_url()?>user/sell/approveoffer/offerid">Approve Offer</a>
															<a href="javascript: void(0)" onclick="javascript: rejectoffer(this)" class="btn btn-primary offerrejectofferid" data-href="<?php echo base_url()?>user/sell/rejectoffer/offerid">Reject Offer</a></span>
														</div>
														<div class="text">[PRICE]</div>
														<div class="text">Offer Status: [OFFERSTATUS]</div>
															<!--<div class="seller-reply" id="sellerreplyofferid" descriptionofferhide>
																<label for="">Description</label>
																<div class="reply-box" id="sellerreplytextofferid">[SELLERREPLY]</div>
															</div>-->
													</div>
												</div>
												
												<?php
											}else{
												echo 'No data found.';
											}
											?>
											</div>
											<?php
											if($sellerOffers['totalrecord']['totalrecord'] > $sellerOffersLimit)
											{
												?>
												<button type="button" class="add-reply-button loadmoreoffer">Load More Offers</a></button>
												<input type="hidden" id="offerstart" value="<?php echo $sellerOffersStart+$sellerOffersLimit?>">
												<input type="hidden" id="offerlimit" value="<?php echo $sellerOffersLimit?>">
												<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
												<?php
											}
											?>
									</div>
									</div>
									
									<div id='tab4' class='content'>
									<div class="valuations-list">
											<ul class="ul">
												<?php
												if(is_array($valuationListData) && count($valuationListData))
												{
													//print '<pre>';
													//print_r($valuationListData);

													foreach($valuationListData as $val)
													{
														?>
														<li data-aos="fade-up" data-aos-duration="2200">
													<div class="box">
														<div class="row">
															<div class="col-md-3 col-sm-3 img-sec"> 
																<a href="<?php echo base_url();?>user/valuation/<?php echo $val['listing_id']?>" class="round-icon"><img src="<?php echo base_url();?>assets/frontend/images/sample/v1.png" alt=""></a>
																<h2 class="subheading"><?php echo $val['monetizationRec']?></h2> 
															</div>
															<div class="col-md-7 mid-block">
																<a href="<?php echo base_url();?>user/valuation/<?php echo $val['listing_id']?>" class="d-flex align-items-center justify-content-between"> 
																<div class="block">
																		<div class="head">Website</div>
																		<span> <?php echo $val['dataArr']['website'][0]?></span>
																	</div>
																	<div class="block">
																		<div class="head">Valuation Date</div>
																		<span> <?php echo date('jS M',strtotime($val['last_updated']))?></span>
																	</div>
																	<div class="block">
																		<div class="head">Valuation Time</div>
																		<span><?php echo date('g:i a',strtotime($val['last_updated']))?></span>
																	</div>
																	<div class="block">
																		<div class="head">Final Valuation</div>
																		<span>$<?php echo number_format(($val['valuationArr']['profit']*$val['valuationArr']['multiple']),2);?></span>
																	</div>
																	<div class="block">
																		<div class="head">Multiple</div>
																		<div class="multiple">
																			<span><?php echo number_format($val['valuationArr']['multiple'],2);?>x</span>
																		</div>
																	</div>    
																</a>
															</div>
															<div class="col-md-2 d-flex align-items-center">
																<div class="right-block d-flex align-items-center justify-content-end">
																	<a href="<?php echo base_url();?>user/valuation/<?php echo $val['listing_id']?>" class="round-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
																</div>
															</div>
														</div>
													</div>
												</li> 
														<?php
													}
													
												}else{
													echo 'No data found...';
												}
												?>
											</ul>
										</div>
									</div>
									<!--<div class="loading-text btn_center" data-aos="fade-up" data-aos-duration="2200">
											<span>Loading....</span>
										</div>-->
									<div id='tab5' class='content'>

									<?php
												if(is_array($freecontents) && count($freecontents)>0)
												{
													?>
									<h2 class="heading font_Sofia_Pro_Light">Free Downloads:</h2>
										<div class="download-list mb20">
											<ul class="ul row">
												<?php
													foreach($freecontents as $val)
													{
														$image = json_decode($val['image'],true);

														?>
														<li class="col-md-4">
															<div class="dbox">
																<div class="top-sec d-flex align-items-center">
																	<figure><img src="<?php echo base_url();?>uploads/images_extra/<?php echo $image[0];?>" alt=""></figure>
																	<h2 class="subheading font_Sofia_Pro_Light"><?php echo $val['title'];?></h2>																</h2>
																</div>
																<div class="para">
																<?php echo $val['description'];?>
																</div>
																<a href="<?php echo $val['download_link'];?>" class="btn"><i class="fa fa-download" aria-hidden="true"></i>
																	Download Now</a>
															</div>
														</li>
														<?php
													}
												?>
											</ul>
										</div>
										<hr>
										<?php
										}
										?>


										<!--<div class="useful-tools pt20 pb20"> 
											<h2 class="heading font_Sofia_Pro_Light">Useful Tools:</h2>
											<div class="useful-list">
												<ul class="ul row">
													<li class="col-md-6 col-sm-6">
														<div class="box">
															<div class="section-left">
																<h2 class="subheading font_Sofia_Pro_Light">Valuation Tool</h2>
																<div class="para">Answer a few quick questions to discover how much your online business is worth. All your valuations are saved to your account, so you can track your progress.</div>
															</div>
															<div class="section-right">
																<figure class="icon"><img src="<?php //echo base_url();?>assets/frontend/images/sample/useful1.png" alt=""></figure>
																<a href="#" class="btn">Begin</a>
															</div>
														</div>
													</li>
													<li class="col-md-6 col-sm-6">
														<div class="box">
															<div class="section-left">
																<h2 class="subheading font_Sofia_Pro_Light">Seller Frequently Asked Questions</h2>
																<div class="para">Here are a list of our most frequently asked questions that will hopefully help you out with the buying process.</div>
															</div>
															<div class="section-right">
																<figure class="icon"><img src="<?php //echo base_url();?>assets/frontend/images/sample/useful2.png" alt=""></figure>
																<a href="#" class="btn">Begin</a>
															</div>
														</div>
													</li>
												</ul>
											</div>
										</div><hr>-->
										<?php
										if(is_array($CuratedContents['record']) && count($CuratedContents['record'])>0)
										{
											?>
										
											<div class="pt20 resources-blog">
											<div class="heading font_Sofia_Pro_Light">Curated Content For Sellers:</div>
											<div class="blog_list">
												<ul class="ul row">
												<?php
												foreach($CuratedContents['record'] as $val){
													$imagesArr = json_decode($val['image'],true);

													?>
													<li class="col-md-4" data-aos="fade-up" data-aos-duration="2200">
														<div class="box">
															<a href="<?php echo base_url();?>user/seller-cureted-content/<?php echo $val['title_slug'];?>">
															<figure><img src="<?php echo base_url();?>uploads/images_extra/<?php echo $imagesArr[0];?>" alt=""></figure>
															<div class="text">
																<h2 class="subheading"><?php echo $val['title'];?></h2>
																<div class="para"><?php echo substr(strip_tags($val['description']),0,200);?></div>
																<div class="bottom">
																	<span class="admin">By <?php echo $val['author'];?></span>
																	<span class="date"><?php echo date('jS F Y',strtotime($val['date_added']));?></span>
																	<div class="btn"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></div>
																</div>
															</div>
															</a>
														</div>
													</li>
													<?php
												}
												?> 
												</ul>
											</div>
										</div>  
										<?php
										//if($CuratedContents['totalrecord']['totalrecord']>2)
										//{
											?>
										<!--<div data-aos="fade-up" data-aos-duration="2200" class="btn_center">
											<a href="<?php //echo base_url();?>curated_contents_seller" class="btn">View All</a>
										</div>-->
										<?php
										//}
										}
										?>
									</div> 
									<div id='tab6' class='content'>
											<div id="faqtab">
											<?php
											//print '<pre>';
											//print_r($sellerFAQ);
											if(is_array($sellerFAQ['record']) && count($sellerFAQ['record'])>0 && $sellerFAQ['totalrecord']['totalrecord']>0)
											{
												foreach($sellerFAQ['record'] as $k=>$v)
												{
													if($v['user_profile_pic'] !='')
													{
														//$profilePic = 'uploads/profile_pictures/'.$v['user_profile_pic'];
														$profilePic = 'assets/frontend/images/male.png';
													}else{
														$profilePic = 'assets/frontend/images/male.png';
													}
													$v['fname'] = 'Potential Buyer';
													?>

													<div class="admin-reply">
														<div class="top">
															<span class="admin-reply-icon" style="width:100px;"><img src="<?php echo base_url().$profilePic;?>" alt="" ></span>
															<span class="seller-id"><strong>Listing #:</strong><a href="<?php echo base_url().'listing/'.$v['listing_id'];?>"><?php echo $v['listing_id'];?></a></span>
															<div class="name"><?php echo $v['fname']?></div>
															<div class="date"><?php echo $v['faqDate'];?></div>
														</div>
														<div class="text"><?php echo $v['question'];?></div>
														
															<div class="seller-reply" id="sellerreply<?php echo $v['id'];?>" <?php echo ($v['Status']>0)?'': 'style="display:none";'?>>
																<label for="">Seller reply</label>
																<div class="reply-box" id="sellerreplytext<?php echo $v['id'];?>"><?php echo $v['seller_reply'];?></div>
															</div>
															
															
															<div class="add-reply " id="replysec<?php echo $v['id'];?>" <?php echo ($v['Status']>0)?'style="display:none;"': ''?>>
															<form action="<?php echo base_url();?>user/seller_faq_reply" method="post" class="replyform">
															<input type="hidden" name="qId" value="<?php echo $v['id'];?>">
															<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																<label for="">Add reply</label>
																<textarea name="sellerReply" id="" cols="30" rows="10" placeholder="Add reply here...."></textarea>
																<div class="text-right"><button type="button" class="add-reply-button replyfaq<?php echo $v['id'];?>" onClick="replyfaq('<?php echo $v['id'];?>')">Reply</a></button></div>
																</form>
															</div>
															
															
														
													</div>
													
													<?php
												}
												?>
												<div class="seller_reply_skeleton" style="display:none">
													<div class="admin-reply">
														<div class="top">
															<span class="admin-reply-icon" style="width:100px;"><img src="<?php echo base_url().'assets/frontend/images/male.png';?>" alt="" ></span>
															<span class="seller-id"><strong>Listing #:</strong><a href="<?php echo base_url().'listing/';?>[ALISTINGNO]">[LISTINGNO]</a></span>
															<div class="name">Potential Buyer</div>
															<div class="date">[DATEFAQ]</div>
														</div>
														<div class="text">[QUESTION]</div>
														
															<div class="seller-reply" id="sellerreplyquestionid" replyhide>
																<label for="">Seller reply</label>
																<div class="reply-box" id="sellerreplytextquestionid">[SELLERREPLY]</div>
															</div>
															
															
															<div class="add-reply " id="replysecquestionid" replypane>
															<form action="<?php echo base_url();?>user/seller_faq_reply" method="post" class="replyform" onsubmit="return false">
															<input type="hidden" name="qId" value="questionid">
															<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																<label for="">Add reply</label>
																<textarea name="sellerReply" id="" cols="30" rows="10" placeholder="Add reply here...."></textarea>
																<div class="text-right"><button type="button" class="add-reply-button replyfaqquestionid" onClick="replyfaq('questionid')">Reply</a></button></div>
																</form>
															</div>
															
															
														
													</div>
												</div>
												
												<?php
											}else{
												echo 'No data found.';
											}
											if($sellerFAQ['totalrecord']['totalrecord'] > $sellerFAQlimit)
											{
												?>
												<button type="button" class="add-reply-button loadmorereply">Load More Reply</a></button>
												<input type="hidden" id="replystart" value="<?php echo $sellerFAQstart+$sellerFAQlimit?>">
												<input type="hidden" id="replylimit" value="<?php echo $sellerFAQlimit?>">
												<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
												<?php
											}
											?>
										</div>
										

									
								</div>
								<div id='tab8' class='content'>
								<?php
										if(is_array($applications) && count($applications)>0)
										{
										?>
													<table>
														<tr>
															<td><strong>Listing#</strong></td>
															<td><strong>Website</strong></td>
															<td><strong>Average Revenue</strong></td>
															<td><strong>Average Profit</strong></td>
															<td><strong>Date Requested</strong></td>
															<td><strong>Status</strong></td>
														</tr>
														<?php
														foreach($applications as $val)
														{
															$jsonArr = json_decode($val['data_json'],true);
															//print '<pre>';
															//print_r($jsonArr);
															?>
															<tr>
																<td><?php echo $val['listing_id'];?></td>
																<td><?php echo $jsonArr['website'][0];?></td>
																<td>$<?php 
																echo $jsonArr['month12avgrevenue'];
																?></td>
																<td>$<?php 
																echo $jsonArr['month12avgprofit'];
																?></td>
																<td><?php echo date('jS F Y',strtotime($val['last_updated']));?></td>
																<td><?php 
																if($val['Status'] == 1)
																{
																	echo '<span style="color: orange">Pending</span>';
																}elseif($val['Status'] == 2)
																{
																	echo '<span style="color: red">Denied [Fee Refunded]</span>';
																}elseif($val['Status'] == 3)
																{
																	echo '<span style="color: green">Approved</span><a href="'.base_url().'user/sell/moreinfo/'.$val['listing_id'].'" Type="submit" class="btn-sm" style="float:right">Add Info</a>';
																}
																?>
																</td>
															</tr>
															<?php
														}
														?>
														
														
													</table>
													<?php
										}else{
											echo 'No Record found.';
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
	<div class="modal fade" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  		<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
							<h4 class="modal-title" id="deleteModalLabel">Are you sure want to approve this listing offer?</h4>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-footer">
								<form action="" method="post" id="delform">
									<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
									<button type="submit" class="btn btn-primary">Approve</button>
								</form>
								<button type="button" data-dismiss="modal" class="btn">Cancel</button>
					</div>
			</div>
  		</div>
</div>
<div class="modal fade" id="rejectOffer" data-backdrop="static" data-keyboard="false" tabindex="1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  		<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
							<h4 class="modal-title" id="">Are you sure want to reject this listing offer?</h4>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-footer">
								<form action="" method="post" id="rejectform">
									<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
									<button type="submit" class="btn btn-primary">Reject</button>
								</form>
								<button type="button" data-dismiss="modal" class="btn">Cancel</button>
					</div>
			</div>
  		</div>
</div>