<main class="mainContainer">  
		<section class="section seller-dashboard">
			<div class="container">
				<div class="d-flex tab-head-sec flex-wrap mb30">
					<div>
						<h2 class="heading">Buyer Dashboard</h2> 
						
					</div>
					
					<div class="d-block w-100">
						<div class="dashboard-wrap mt30">
							<div class="js-tabs" data-aos="fade-left" data-aos-duration="2400">
								<nav>
									<ul class='tabs'>
									<li data-tab-id='tab7' <?php echo ($this->session->flashdata('slidetab')==7 || $firstslide=='Y')? 'class="active"':''?>>My Wallet</li>
									<li data-tab-id='tab1'>Uncovered Listings</li>
									<li data-tab-id='tab4'>Won Listings</li>
									<li data-tab-id='tab2' <?php echo ($this->session->flashdata('slidetab')==2)? 'class="active"':''?>>Offers Submitted</li>
									<!--<li data-tab-id='tab3'>Upcoming Calls</li>-->
									<!--<li data-tab-id='tab4'>Valuations</li>-->
									<li data-tab-id='tab5'>Resources</li>
									<li data-tab-id='tab6'>FAQ</li>
									
									
									</ul>
								</nav>
								
								<div class='panels'>
									<div id='tab1' class='content'>
										<div class="latest-list">
											<ul class="ul">

											<?php
											if(is_array($sellerListing) && count($sellerListing)>0)
											{
											foreach($sellerListing as $rb)
											{
												$monetizationstrrb = '';
												?>
												<li data-aos="fade-up" data-aos-duration="2200">
												<div class="box">
												<?php
													if($rb['Status'] == 4) 
													{
														if($rb['seller'] == $LogginUser)
														{
															?>
															<!-- =============================SOLD========================== -->
															<div class="sold2">
															Congrats<span>this listing as sold!</span>
															</div>
															<?php
														}elseif($rb['buyer'] == $LogginUser)
														{
															?>
															<!-- =============================SOLD========================== -->
															<div class="sold2">
															Congrats<span>you won this listing!</span>
															</div>
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
														<div class="col-md-8 latest-list-middleCol">
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
															
															<div class="name">Business Owner</div>
															<div class="date"><?php echo $v['offerDate'];?></div>
															
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
														
													</div>
													
													<?php
												}
												?>
												<div class="seller_offer_skeleton" style="display:none">
												<div class="admin-reply">
														<div class="top">
															<span class="admin-reply-icon" style="width:100px;"><img src="<?php echo base_url().'assets/frontend/images/male.png';?>" userimage alt="" ></span>
															<span class="seller-id"><strong>Listing #:</strong><a href="<?php echo base_url().'listing/listingnooffer'?>" target="_blank">listingnooffer</a></span>
															<div class="name">Business Owner</div>
															<div class="date">[DATEOFFER]</div>
														</div>
														<div class="text">[PRICE]</div>
														<div class="text">Offer Status: [OFFERSTATUS]</div>
													</div>
												</div>
												
												<?php
											}else{
												echo 'No data found.';
											}
											?>
											</div>
											<?php
											
											if($sellerOffers['totalrecord']['totalrecord'] >= $sellerOffersLimit)
											{
												?>
												<button type="button" class="add-reply-button loadmoreofferreqest">Load More Offers</a></button>
												<input type="hidden" id="offerstart" value="<?php echo $sellerOffersStart+$sellerOffersLimit?>">
												<input type="hidden" id="offerlimit" value="<?php echo $sellerOffersLimit?>">
												<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
												<?php
											}
											?>
										</div>
									</div>
									<!--<div id='tab3' class='content'>
											<div class="meetings-iframe-container" data-src="https://meetings.hubspot.com/pantnair87?embed=true"></div>
											<script type="text/javascript" src="https://static.hsappstatic.net/MeetingsEmbed/ex/MeetingsEmbedCode.js"></script>
									</div>-->
									<div id='tab4' class='content'>
										<!-- Start of Meetings Embed Script -->
										<div class="latest-list">
											<ul class="ul">

											<?php
											if(is_array($buyerWonList) && count($buyerWonList)>0)
											{
											foreach($buyerWonList as $rb)
											{
												$monetizationstrrb = '';
												?>
												<li data-aos="fade-up" data-aos-duration="2200">
												<div class="box">
												<?php
													if($rb['Status'] == 4) 
													{
														if($rb['seller'] == $LogginUser)
														{
															?>
															<!-- =============================SOLD========================== -->
															<div class="sold2">
															Congrats<span>this listing as sold!</span>
															</div>
															<?php
														}elseif($rb['buyer'] == $LogginUser)
														{
															?>
															<!-- =============================SOLD========================== -->
															<div class="sold2">
															Congrats<span>you won this listing!</span>
															</div>
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
															<a href="<?php echo base_url();?>listing/<?php echo $rb['listing_id'];?>" ><img src="<?php echo base_url();?><?php echo 'uploads/business_image/'.$rb["business_image"]; ?>" alt=""></a>
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
																	<div class="block">
																		<div class="head">Traffic</div>
																		<span><?php echo number_format($rb['traffic_per_month'], 0, '.', ',')?> p/mo</span>
																	</div>  
																	<div class="block">
																<div class="head">Business transfer Status</div>
																<span><?php 
																if($rb['transfer_status'] == 1)
																{
																	echo 'Unpaid';
																}elseif($rb['transfer_status'] == 2)
																{
																	echo 'Funds Received';
																}elseif($rb['transfer_status'] == 3)
																{
																	echo 'Transfer Pending';
																}elseif($rb['transfer_status'] == 4)
																{
																	echo 'Completed';
																}
																?></span>
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
																<figure class="icon"><img src="<?php echo base_url();?>assets/frontend/images/sample/useful1.png" alt=""></figure>
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
																<figure class="icon"><img src="<?php echo base_url();?>assets/frontend/images/sample/useful2.png" alt=""></figure>
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
											<div class="heading font_Sofia_Pro_Light">Curated Content For Buyers:</div>
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
										if($CuratedContents['totalrecord']['totalrecord']>2)
										{
											?>
										<div data-aos="fade-up" data-aos-duration="2200" class="btn_center">
											<a href="<?php echo base_url();?>user/seller-cureted-content" class="btn">View All</a>
										</div>
										<?php
										}
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
													$v['fname'] = 'Business Owner';
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
															
															
															
														
													</div>
													
													<?php
												}
												?>
												<div class="seller_reply_skeleton" style="display:none">
												<div class="admin-reply">
														<div class="top">
															<span class="admin-reply-icon" style="width:100px;"><img  src="<?php echo base_url().'assets/frontend/images/male.png';?>" alt="" ></span>
															<span class="seller-id"><strong>Listing #:</strong><a href="<?php echo base_url().'listing/';?>[ALISTINGNO]">[LISTINGNO]</a></span>
															<div class="name">Business Owner</div>
															<div class="date">[DATEFAQ]</div>
														</div>
														<div class="text">[QUESTION]</div>
														
															<div class="seller-reply" id="sellerreplyquestionid" replyhide>
																<label for="">Seller reply</label>
																<div class="reply-box" id="sellerreplytextquestionid">[SELLERREPLY]</div>
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
												<button type="button" class="add-reply-button loadmorebuyerfaq">Load More Reply</a></button>
												<input type="hidden" id="replystart" value="<?php echo $sellerFAQstart+$sellerFAQlimit?>">
												<input type="hidden" id="replylimit" value="<?php echo $sellerFAQlimit?>">
												<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
												<?php
											}
											?>
										</div>
									</div>
									<div id='tab7' class='content <?php echo ($this->session->flashdata('slidetab')==7 || $firstslide=='Y')? 'active':''?>'>
											
										<div id="eallettab">
										<?php
										$error = $this->session->flashdata('failedwithdraw');
										if($error) {
											?>
											<div class="alert alert-danger alert-dismissible" role="alert">
											
											<strong>Errors!</strong> 
											<ul>
											<?php
											$error = $this->session->flashdata('failedwithdraw');
											if($error)
											{
												if(is_array($error) and count($error)>0)
												{
													foreach($error as $v)
													{
														?>
														<li><?php echo $v;?></li>
														<?php
													}
												}else{
													?>
													<li><?php echo $error;?></li>
													<?php
												}
													
											}
											$fieldData = $this->session->flashdata('dataval');
											?>
											</ul>   
											</div>
											<?php 
										} 
										$success = $this->session->flashdata('successwithdraw');
										if($success) {
											?>
											<div class="alert alert-success alert-dismissible" role="alert">
											
											<strong>Success!</strong> 
											<ul>
													<li><?php echo $success;?></li>
											</ul>   
											</div>
											<?php 
										} 
										?>
										<div class="wallet-wrap d-flex flex-wrap align-items-center">
										
										
											<div class="wallet mr-2">Total Wallet balance: <strong><?php echo $walletdetails['sitesettings']['symbol'].$walletdetails['walletamt']?></strong></div>
											<?php
											if(is_array($walletdetails['investorPass']) && $walletdetails['investorPass']['identity_proof_status'] == true){
												?>
												<a href="#buy-now-pane" class="fancybox btn" id="buynow" data-fancybox>Add Money</a>
												<?php
											}else{
												?>
												<form id="verifyIdentitystep1" action="<?php echo base_url();?>user/verifyIdentityaction?redirect_to=user/buyer" method="post">
																<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																<input type="hidden" name="verificationType" value="online">
																	<input type="hidden" name="personainquiryId" id="personainquiryId" value="">

																	<!--<button type="submit" class="btn big-arrow-btn" id="verifyidentityunlockbtn">Verify Your Identity <i class="fa fa-angle-right" aria-hidden="true"></i></button>-->
																	<a href="javascript: void(0);" class="btn" id="verifyidentityunlockbtn">Verify Identity to add money</a>
																
												</form>
												
												<?php
											}
											?>
											<?php
												if($walletdetails['walletamt'] >0 && is_array($walletdetails['investorPass']) && $walletdetails['investorPass']['identity_proof_status'] == true)
												{
													?>
													<a href="#withdraw-pane" class="fancybox btn" id="withdraw" data-fancybox>Withdraw Money</a>
													<?php
												}
											?> 
										</div>
										<div id="withdraw-pane" class="withdraw-pane" style="display:none;">
										
											<form class="w-100 withdraw-pane-form" id="submitwithdrawFrm" action="<?php echo base_url(); ?>user/submitwalletwithdrawrequest" method="post">
											<input type="hidden" name="payThrough" value="WIRETRANSFER">
											<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
											<h1 class="heading">Withdraw From Wallet</h1>
											<ul class="ul row">
												
												<li class="col-sm-5">
													<div class="d-flex flex-wrap align-items-center cpn-wrap">
														<span>Wallet Balance</span> <h3 class="listing-price mb-0"><?php echo $walletdetails['sitesettings']['symbol'].$walletdetails['walletamt']?></h3>
														
													</div>
												</li>
												<li class="col-sm-7">
													<div class="d-flex flex-wrap align-items-center cpn-wrap">
														<span>Minimum Withdrawal Amount</span> <h3 class="listing-price mb-0"><?php echo $walletdetails['sitesettings']['symbol']?>1000</h3>
														
													</div>
												</li>
												<li class="col-sm-12 withdrawbreakup" style="display:none">
												<div class="" >
													<table>
													<tr>
														<td><strong>Withdrawal Amount</strong></td>
														<td><strong class="Wallet-balance"><?php echo $walletdetails['sitesettings']['symbol'];?><span id="grosswithdrawalamt"></span></strong></td>
													</tr>
													<tr>
														<td><strong>Wire Transfer Fee (Less)</strong></td>
														<td><strong class="Wallet-balance"><?php echo $walletdetails['sitesettings']['symbol'];?>35</strong></td>
													</tr>
													<tr>
														<td><strong>Net Amount</strong></td>
														<td><strong class="Wallet-balance"><?php echo $walletdetails['sitesettings']['symbol'];?><span id="netwithdrawalamt"></span></strong></td>
													</tr>
													</table>
												</div>
												</li>
												<li class="col-sm-12">
													<label>Amount</label>
													<h3 class="listing-price">
													<div class="price-sign">
														<span class="psign"><?php echo $walletdetails['sitesettings']['symbol'];?></span>
														<input type="text" class="form-group" name="walletMoney" id="withdrawalAmount">
														<input type="hidden" name="wire_transfer_ref" value="<?php echo $walletdetails['refnumbrer'];?>">
													</div>
												</li>
												<li class="col-sm-12">
													<label>Wire transfer instructions</label>
													<h3 class="listing-price">
														<textarea name="witeTransferInstruction" id="" cols="30" rows="2"></textarea>
												</li>
													<li class="col-sm-12">
													<!--<button type="submit" class="btn" id="submitwithdrawbtn">Request to Withdraw</button>-->
													<a href="#MarkWithdraw" class="btn fancybox" data-fancybox id="submitwithdrawbtn">Request to Withdraw</a>
													<div id="MarkWithdraw" style="display:none;">
													<div class="MarkPaymentWrap text-center">
														<h2 class="subheading text-center">Are you sure, you want to withdraw funds from your wallet?</h2>
														<div class="btn_center"> 
															<button type="button" class="btn submitwalletwithdraw">Submit</button>
															<a href="javascript:void(0)" data-fancybox-close="" class="btn cancelwalletwithdraw">cancel</a>  
														</div>
													</div>
												</div>
												</li>
												
											</ul>
											</form>
										</div>
										<div id="buy-now-pane" class="buy-now-pane" style="display:none;">
										
											<form class="w-100 buy-now-pane-form" id="submitbuyFrm" action="<?php echo base_url(); ?>user/submitbuywalletamountrequest" method="post">
											<input type="hidden" name="payThrough" value="WIRETRANSFER">
											<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
											<h1 class="heading">Add Money To Wallet</h1>
											<ul class="ul row">
												<li class="col-sm-12">
													<h4>Wire Transfer Details</h4>
													<hr>
													<?php //echo $walletdetails['sitesettings']['wire_transfer_details'];?>
												</li>
												<li class="col-sm-6">
												<div class="wiretransfer">
													<strong>Bank Name</strong>
													<br clear="all">
													<?php echo trim($walletdetails['sitesettings']['wire_bank_name']);?>
												</div>
											</li>
											<li class="col-sm-6">
												<div class="wiretransfer">
													<h5><strong>Bank Address</strong></h5>
													<?php echo $walletdetails['sitesettings']['wire_bank_address'];?>
												</div>
											</li>
											<li class="col-sm-6">
												<div class="wiretransfer">
													<strong>Swift Code</strong>
													<br clear="all">
													<?php echo trim($walletdetails['sitesettings']['wire_swift_code']);?>
												</div>
											</li>
											<li class="col-sm-6">
												<div class="wiretransfer">
													<h5><strong>Credit Account Name</strong></h5>
													<?php echo $walletdetails['sitesettings']['wire_credit_account_name'];?>
												</div>
											</li>
											<li class="col-sm-6">
												<div class="wiretransfer">
													<strong>ABA Routing #</strong>
													<br clear="all">
													<?php echo trim($walletdetails['sitesettings']['wire_aba_routing']);?>
												</div>
											</li>
											<li class="col-sm-6">
												<div class="wiretransfer">
													<h5><strong>Credit Account #</strong></h5>
													<?php echo $walletdetails['sitesettings']['wire_credit_account_no'];?>
												</div>
											</li>
											<li class="col-sm-6">
												<div class="wiretransfer">
													<strong>Wire Beneficiary Address</strong>
													<br clear="all">
													<?php echo trim($walletdetails['sitesettings']['wire_beneficiary_address']);?>
												</div>
											</li>
											<li class="col-sm-6">
												<div class="wiretransfer">
													<h5><strong>Additional Instructions</strong></h5>
													<?php echo $walletdetails['sitesettings']['wire_additional_info'];?>
												</div>
											</li>
												<li class="col-sm-12">
													<div class="d-flex flex-wrap align-items-center cpn-wrap">
														<span>Please put your reference number in your 'note/message to wire recipient' to identify your payment.</span> <h1 class="cpn-code" id="refnumberh1"><?php echo $walletdetails['refnumbrer'];?></h1><a class="copy-text" href="javascript: void(0)" onclick="javascript: clicktocopy('#refnumberh1')">Copy Text</a> 
														<strong class="mt-2 w-100">To finalize purchase or adding of funds, you need to click "Mark Payment As Sent" immediately after initiating wire transfer.</strong>
													</div>
												</li>

												<li class="col-sm-12">
													<label for="" class="subheading d-block price-head mb-1">Amount</label>
													<h3 class="listing-price">
													<div class="price-sign">
														<span class="psign"><?php echo $walletdetails['sitesettings']['symbol'];?></span>
														<input type="text" class="form-group" name="walletMoney" id="">
														<input type="hidden" name="wire_transfer_ref" value="<?php echo $walletdetails['refnumbrer'];?>">
													</div>
												</li>
													<li class="col-sm-12">
													<a href="#MarkPayment" class="btn fancybox" data-fancybox id="submitbuybtn">Mark Payment As Sent</a>
												</li>
												
											</ul>
											<div id="MarkPayment" style="display:none;">
												<div class="MarkPaymentWrap text-center">
													<h2 class="subheading text-center">Please confirm once more that the wire transfer has been sent.</h2>
													<div class="btn_center"> 
														<button type="button" class="btn submitwallet">Confirm</button>
														<a href="javascript:void(0)" data-fancybox-close="" class="btn cancelwallet">cancel</a>  
													</div>
												</div>
											</div>
											</form> 
										</div>
										
								
										<div class="table-responsive">
											<table class="table table-bordered" id="walletTable" width="100%" cellspacing="0">
												<thead>
													<tr>
														<th class="subhead">Payment Ref #</th>
														<th class="subhead">Amount</th>
														<th class="subhead">Type</th>
														<th class="subhead">Date</th>
														<th class="subhead">Status</th>
													</tr>
												</thead>
												<tbody>
												
												</tbody>
												<tfoot>
													<tr>
													<th>Payment Ref #</th>
													<th>Amount</th>
													<th>Type</th>
													<th>Date</th>
													<th>Status</th>
													</tr>
													</tfoot>
													<?php
													
													?>
												<tbody>
													
											</tbody>
											</table>
										</div>
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
	<div class="modal fade" id="deletenotificationModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title" id="deleteModalLabel">Are you sure want to delete this notification?</h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-footer">
			<form action="" method="post" id="delformnotification">
			<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
			<button type="button" class="btn btn-primary delnotification">Delete</button>
			</form>
			<button type="button" data-dismiss="modal" class="btn">Cancel</button>
		</div>
		</div>
	</div>
	</div>