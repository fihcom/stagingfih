<?php

if($this->session->userdata('isLoggedIn'))
{
	if($permission['totalunloadremaining']>0 && $permission['isidentityproofed'] == true && $permission['isfundproofed'] == true && $permission['isavailablefund'] == true)
	{
		$unlockLink = '#lock-content';
		$class= 'fancybox';
		$datafancybox = 'data-fancybox';
		$buyPermission = 'Y';
	}else{
		$unlockLink = base_url().'listing/uncover/'.$listing_id;
		$class= '';
		$datafancybox = '';
		$buyPermission = 'N';
	}
	
}else{
	$unlockLink = base_url().'login?redirect_to=listing/uncover/'.$listing_id;
	$class= '';
	$datafancybox = '';
	$buyPermission = 'N';
}
?>
<div class="container">
		<div class="breadcrumb">
			<ul> 
				<li><a href="<?php echo base_url();?>">Home</a></li>
				<li><a href="<?php echo base_url();?>/marketplace">Online Business Marketplace</a></li>
				<li><?php echo $listing_id?></li>
			</ul>
		</div>
	</div>
	<main class="mainContainer"> 
		<section class="section marketplace-details pb30">  
			<div class="container">
				<div class="<?php //echo ($permission['isunlocked'] == TRUE && $business_image!='')?'marketplace-details-wrap-sec':'';?>">
				<?php
							//if($permission['isunlocked'] == TRUE && $business_image!='')
							//{
								?>
							<!--<img src="<?php //echo base_url();?><?php //echo 'uploads/business_image/'.$business_image; ?>" alt="" style="border:1px solid #ccc; left:14px !important">-->
							<?php
							//}
							?>
					<h2 class="heading font-weight-black font35 mb-0">Niche: <?php echo $industryname?></h2> 
					<div class="marketplace-btn-wrap"> 
								<?php
								if($Status == 4)
								{
									?>
									<div class="btn_group marketplace-btn marketplace-sold-btn">
									<?php
									if($seller == $this->session->userdata('user_id'))
									{
										?>
										<!-- =============================SOLD========================== -->
										<div class="sold sold2">
										Congrats<span>this listing as sold!</span>
										</div>
										<?php
									}elseif($buyer == $this->session->userdata('user_id'))
									{
										?>
										<!-- =============================SOLD========================== -->
										<div class="sold sold2">
										Congrats<span>you won this listing!</span>
										</div>
										<?php
									}else{
										?>
										<div class="sold">sold </div>
										<?php
									}
									?>
									</div>
									<?php
								}else{
									?>
									<div class="btn_group marketplace-btn text-left mt-3">
									<?php
								if($userId != $this->session->userdata('user_id'))
								{
								if($permission['isunlocked'] == false || $permission['isidentityproofed'] == false || $permission['isfundproofed'] == false || $permission['isavailablefund'] == false)
								{
								?>
								<a href="<?php echo $unlockLink;?>" class="<?php echo $class?> btn" <?php echo $datafancybox;?>>Buy Now</a>
								<a href="<?php echo $unlockLink;?>" class="<?php echo $class?> btn btn_t ml-2" <?php echo $datafancybox;?>><i class="fa fa-lock" aria-hidden="true"></i> Submit Offer</a>
								<a href="<?php echo $unlockLink;?>" class="<?php echo $class?> btn  btn_t ml-2" <?php echo $datafancybox;?>><i class="fa fa-lock" aria-hidden="true"></i>Ask Question </a>
								<?php
								}else{
									?>
									<a href="#buy-now-pane" class="fancybox btn" id="buynow" data-fancybox>Buy Now</a>
									<div id="buy-now-pane" class="buy-now-pane" style="display:none;">
									<?php
									$error = $this->session->flashdata('errorbuyoffer');
									if($error) {
										?>
										<div class="alert alert-danger alert-dismissible" role="alert">
										
										<strong>Errors!</strong> 
										<ul>
										<?php
										if(is_array($this->session->flashdata('errorbuyoffer')) && count($this->session->flashdata('errorbuyoffer'))>0)
										{
											foreach($this->session->flashdata('errorbuyoffer') as $val)
											{
												?>
												<li><?php echo $val;?></li>
												<?php
											}
										}
										$fieldData = $this->session->flashdata('dataval');
										?>
										</ul>   
										</div>
										<?php 
									} 
									$success = $this->session->flashdata('successbuyoffer');
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
										<form id="submitbuyrequestfrm" action="<?php echo base_url(); ?>listing/submitbuyrequest" method="post">
											<input type="hidden" name="payThrough" value="WIRETRANSFER">
											<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
											<input type="hidden" name="listingNo" value="<?php echo $listing_id?>" /> 
											<h1 class="heading">Send Wire to Buy Business</h1>
											<ul class="ul row">
												<li class="col-sm-12">
													<h4>Wire Transfer Details</h4>
													<hr>
													<?php //echo $sitesettings['wire_transfer_details'];?>
												</li>
												<li class="col-sm-6">
													<div class="wiretransfer">
														<strong>Bank Name</strong>
														<br clear="all">
														<?php echo trim($sitesettings['wire_bank_name']);?>
													</div>
												</li>
												<li class="col-sm-6">
													<div class="wiretransfer">
														<h5><strong>Bank Address</strong></h5>
														<?php echo $sitesettings['wire_bank_address'];?>
													</div>
												</li>
												<li class="col-sm-6">
													<div class="wiretransfer">
														<strong>Swift Code</strong>
														<br clear="all">
														<?php echo trim($sitesettings['wire_swift_code']);?>
													</div>
												</li>
												<li class="col-sm-6">
													<div class="wiretransfer">
														<h5><strong>Credit Account Name</strong></h5>
														<?php echo $sitesettings['wire_credit_account_name'];?>
													</div>
												</li>
												<li class="col-sm-6">
													<div class="wiretransfer">
														<strong>ABA Routing #</strong>
														<br clear="all">
														<?php echo trim($sitesettings['wire_aba_routing']);?>
													</div>
												</li>
												<li class="col-sm-6">
													<div class="wiretransfer">
														<h5><strong>Credit Account #</strong></h5>
														<?php echo $sitesettings['wire_credit_account_no'];?>
													</div>
												</li>
												<li class="col-sm-6">
													<div class="wiretransfer">
														<strong>Wire Beneficiary Address</strong>
														<br clear="all">
														<?php echo trim($sitesettings['wire_beneficiary_address']);?>
													</div>
												</li>
												<li class="col-sm-6">
													<div class="wiretransfer">
														<h5><strong>Additional Instructions</strong></h5>
														<?php echo $sitesettings['wire_additional_info'];?>
													</div>
												</li>
												<li class="col-sm-12">
													<div class="d-flex flex-wrap align-items-center cpn-wrap">
														<span>Please put your reference number in your 'note/message' to wire recipient to identify your payment.</span> <h1 class="cpn-code" id="refnumberh1"><?php echo $permission['refNumber'];?></h1><a href="javascript: void(0)" onclick="javascript: clicktocopy('#refnumberh1')" class="copy-text">Copy Text</a>
														<strong class="mt-2 w-100">To finalize purchase or adding of funds, you need to click "Mark Payment As Sent" immediately after initiating wire transfer.</strong>
													</div>
												</li>
												<li class="col-sm-12">
													<label class="subheading d-block price-head mb-1" for="">Listing Price</label>
													<h3 class="listing-price mb-0"><?php echo $sitesettings['symbol'];?><?php echo number_format($price, 0, '.', ',')?></h3>
												</li>
												<?php
												if($wallet['walletamt'] > 0)
												{
													?>
													<li class="col-sm-12 mb-0">
													<label><input type="checkbox" name="useWallet" value="Y" id="walletMoney" style="width: 25px;vertical-align: middle;" checked> <strong style="width: vertical-align: middle;">Use Wallet Money</strong> [Wallet balance: <strong class="Wallet-balance"><?php echo $sitesettings['symbol'].number_format($wallet['walletamt'], 0, '.', ',')?></strong>]</label>
												</li>
												<li class="col-sm-12">
													<div class="pricebreakup" >
														<table>
														<tr>
															<td><strong>Listing Price</strong></td>
															<td><strong class="Wallet-balance"><?php echo $sitesettings['symbol'];?><?php echo number_format($price, 0, '.', ',')?></strong></td>
														</tr>
														<tr>
															<td><strong>Wallet (Less)</strong></td>
															<td><strong class="Wallet-balance"><?php echo $sitesettings['symbol'];?><?php echo ($price >= $wallet['walletamt']) ? number_format($wallet['walletamt'], 0, '.', ',') : number_format($price, 0, '.', ',');?></strong></td>
														</tr>
														<tr>
															<td><strong>Wire Transfer</strong> </td>
															<?php
															if($price > $wallet['walletamt'])
															{
																$wireAmtRaw = $price-$wallet['walletamt'];
																$wireAmt = $sitesettings['symbol'].number_format($wireAmtRaw, 0, '.', ',');
															}else{
																$wireAmt = $sitesettings['symbol'].'0';
															}
															?>
															<td><strong class="Wallet-balance"><?php echo $wireAmt;?></strong></td>
														</tr>
														</table>
													</div>
												</li>
													<?php
												}
												?>
												
												<?php
												if($permission['buyRequestSent'] == 'Y')
												{
													
												}else{
													?>
													<li class="col-sm-6">
													
													<a href="#MarkPayment" class="btn fancybox" data-fancybox id="submitbuybtn">Mark Payment As Sent</a>
												</li>
												<div id="MarkPayment"  style="display:none;">
												<div class="MarkPaymentWrap text-center">
													<h2 class="subheading text-center">Please confirm once more that you want to buy this business and the wire transfer has been sent.</h2>
													<div class="btn_center"> 
														<button type="button" class="btn" id="confirmbuyrequest">Confirm</button>
														<a href="javascript:void(0)" data-fancybox-close="" class="btn cancelwallet">cancel</a>  
													</div>
												</div>
											</div>
												
													<?php
												}
												?>
												
											</ul>
										</form>
											<?php
										if($permission['buyRequestSent'] == 'Y')
										{
											if($this->session->flashdata('successbuyoffer') == '')
											{
											?>
											<ul class="ul row">
											<li class="col-sm-12">
											<div class="alert alert-success alert-dismissible" role="alert">
									
											<strong>Success!</strong> 
											Your buy request successfully submitted and pending for admin approval. You will be notified once your buy request is approved.
											</div>
											</li>
											</ul>
											<?php
											}
										}
										?>
										
									</div>
									<a href="#submit-offer" class="fancybox unlock btn btn_t ml-2" id="submitoffer" data-fancybox> Submit Offer</a>
									<div id="submit-offer" style="display:none; width:50%">
									<?php
									$error = $this->session->flashdata('errorsubmitoffer');
									if($error) {
										?>
										<div class="alert alert-danger alert-dismissible" role="alert">
										
										<strong>Errors!</strong> 
										<ul>
										<?php
										if(is_array($this->session->flashdata('errorsubmitoffer')) && count($this->session->flashdata('errorsubmitoffer'))>0)
										{
											foreach($this->session->flashdata('errorsubmitoffer') as $val)
											{
												?>
												<li><?php echo $val;?></li>
												<?php
											}
										}
										$fieldData = $this->session->flashdata('dataval');
										?>
										</ul>   
										</div>
										<?php 
									} 
									$success = $this->session->flashdata('successsubmitoffer');
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
										<form id="submitOfferFrm" action="<?php echo base_url(); ?>listing/submitoffers" method="post">
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
										<input type="hidden" name="listingNo" value="<?php echo $listing_id?>" /> 
										<h1>Submit your offer</h1>
										<ul class="ul row">
										<li class="col-sm-12">
												<label for="">Listing Price</label><br clear="all">
												<h3><?php echo $sitesettings['symbol'];?><?php echo ($listing_price>0)? number_format($listing_price, 0, '.', ',') : number_format($price, 0, '.', ',')?></h3>
											</li>
										<li class="col-sm-12">
												<input type="text" name="offerPrice" id="" placeholder="Offer Price" value="<?php echo $fieldData['offerPrice'];?>">
											</li>
											<li class="col-sm-12 lock-content-check">
												<!--<textarea name="offerDescription" id="" cols="100" rows="10" placeholder="Offer Description"><?php echo $fieldData['offerDescription'];?></textarea>-->
												<input type="checkbox" name="agreement" id="" value="Y" <?php echo (in_array('Bank Statement',$dataval['proof']))?'checked':'';?>> <span>By making this offer, you are legally agreeing to buy this business at the the offer price stated. If accepted, you have 72 hours to make the wire payment.</span>
											</li>
											<li class="col-sm-12">
												<button type="submit" class="btn" id="submitofferbtn">Submit Your Offer</button>
											</li>
										</ul>
										</form>
									</div>
									<a href="#ask-question" class="fancybox unlock btn  btn_t ml-2" id="faq" data-fancybox>Ask Question </a>
									<div id="ask-question" style="display:none;">
									<?php
									$error = $this->session->flashdata('errorfaq');
									if($error) {
										?>
										<div class="alert alert-danger alert-dismissible" role="alert">
										
										<strong>Errors!</strong> 
										<ul>
										<?php
										if(is_array($this->session->flashdata('errorfaq')) && count($this->session->flashdata('errorfaq'))>0)
										{
											foreach($this->session->flashdata('errorfaq') as $val)
											{
												?>
												<li><?php echo $val;?></li>
												<?php
											}
										}
										$fieldData = $this->session->flashdata('dataval');
										?>
										</ul>   
										</div>
										<?php 
									} 
									$success = $this->session->flashdata('successfaq');
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
									<form action="<?php echo base_url(); ?>listing/askquestion" method="post">
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
									<input type="hidden" name="listingNo" value="<?php echo $listing_id?>" /> 
									<h1>Ask Question</h1>
									<ul class="ul row">
										<li class="col-sm-12">
											<textarea name="question" id="" cols="100" rows="10"><?php echo $fieldData['question'];?></textarea>
										</li>
										<li class="col-sm-12">
											<button type="submit" class="btn">Submit</button>
										</li>
									</ul>
									</form>
									</div>
									<?php
								}
								if($permission['isunlocked'] == false)
								{
								?>
								<a id="seefulldetails" href="<?php echo $unlockLink;?>" class="<?php echo $class?> btn blue-btn btn_t ml-2" <?php echo $datafancybox;?>>See Full Details</a>
								<?php
								}
								}
								?>
									</div>
									<?php
							}
								?>
							
						<div class="marketplace-content">
							<div class="marketplace-details-category">
								<span>Monetization:</span>
								<span><?php
								if(is_array($monetization) && count($monetization)>0)
								{
									foreach($monetization as $val)
									{
										$monetizationstr .=  $val['name'].', ';
									}
									echo rtrim($monetizationstr,', ');
								}
								?></span>
							</div>
							<?php
							if($businesslocation!='')
							{
								?>
								<div class="marketplace-details-category location">
									<span><i class="fa fa-map-marker" aria-hidden="true"></i> Location:</span>
									<span><?php echo $businesslocation;?></span>
								</div>
								<?php
							}
							?> 
						</div>
					</div>
					<?php
					if($permission['isunlocked'] == false)
					{
					?>
					<div class="marketplace-details-para">Uncover a listing for full access to the URL, Google Analytics, Profit & Loss Statement, etc.</div>
					<?php
					}else{
						$website = $website[0];
						if (strpos($website,'http') !== false) {
							//$website
						}elseif (strpos($website,'www') !== false) {
							$website = 'http://'.$website;
						}else{
							$website = 'http://www.'.$website;
						}
						?>
						<div class="marketplace-details-para">
							<a href="<?php echo $website?>" class="btn btn_t ml-2" target="_blank">View Website</a>
							<a href="<?php echo $pl_link?>" class="btn btn_t ml-2" target="_blank">Profit & Loss Statement</a>
							<a href="<?php echo $google_drive_link?>" class="btn btn_t ml-2" target="_blank">Other Details</a>
						</div>
						<?php
					}
					?>
					<?php
					if($offer_accepted == 'YES' && $Status != 4)
					{
						?>
					<div class="alert alert-success alert-dismissable">Your Offer is Accepted, Make Payment Now.</div>
					<?php
					}
					?>
				</div>
				<hr class="mt-5">
				<div class="multiple-price">
					<ul class="ul row">
						<li class="col-sm-2">
							<div class="box">
								<span>#<?php echo $listing_id?></span>
								<p>Listing Number</p>
							</div>
						</li>
						<li class="col-sm-2">
							<div class="box">
								<span style="color:#f6695e !important"><?php echo $sitesettings['symbol'];?><?php echo number_format($price, 0, '.', ',')?></span>
								<p>Listing Price</p>
							</div>
						</li>
						<li class="col-sm-2">
							<div class="box">
								<span><?php echo $sitesettings['symbol'];?><?php echo number_format($monthly_revenue, 0, '.', ',')?></span>
								<p>Monthly Revenue</p>
							</div>
						</li>
						<li class="col-sm-2">
							<div class="box">
								<span><?php echo $sitesettings['symbol'];?><?php echo number_format($monthly_profit, 0, '.', ',')?></span>
								<p>Monthly Net Profit</p>
							</div>
						</li>
						<li class="col-sm-2">
							<div class="box">
								<span><?php echo $pricing_period;?>%</span>
								<p>Cashflow Volatility</p>
							</div>
						</li>
						
						<li class="col-sm-2">
							<div class="box">
								<span><?php echo $multiple?>%</span>
								<p>Cash Yield</p>
							</div>
						</li>
					</ul>
				</div>
			</div> 
		</section> 
	<section class="section listing-summary">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 left-part" data-aos="fade-down-right" data-aos-duration="2200">
					<?php
					if($summery !=''){
						?>
					<div class="box">
						<h2 class="heading font35 font-weight-black">Listing Summary</h2>
						
						<div class="editor_text">
							<?php echo $summery;?>
						</div>
					</div>
					<?php
					}
					?>
				</div>
				<div class="col-sm-6 right-part" data-aos="fade-down-left" data-aos-duration="2200">
					<div class="box">
						<div class="top-list">
							<ul class="ul">
								<li>
									<figure><img src="<?php echo base_url();?>assets/frontend/images/sample/top-icon1.png" alt=""></figure>
									<div class="text">
										<h2 class="subheading">
											Business Created
										</h2>
										<p><?php echo date("F, Y",strtotime($business_create_date)); ?> - (<?php echo $business_age;?>)</p>
									</div>
								</li>
								<?php 
                                if(is_array($asset_list) && count($asset_list)>0)
                                {
									?>
								<li>
									<figure><img src="<?php echo base_url();?>assets/frontend/images/sample/top-icon2.png" alt=""></figure>
									<div class="text">
										<h2 class="subheading">
											Assets Included in the Sale
										</h2>
										<p>The following are included in the sale of this business:</p>
									</div>
								</li>
								<?php
								}
								?>
							</ul>
						</div>
						<div class="editor_text mt30 mb30 pl20">
							<ul class="ul">
                                <?php 
                                if(is_array($asset_list) && count($asset_list)>0)
                                {
                                    foreach($asset_list as $val)
                                    {
                                        ?>
                                        <li><?php echo $val?></li>
                                        <?php
                                    }
                                }
                                ?>
							</ul>
						</div>
						<div class="breakdown-rating">
							<div class="row">
								<div class="col-sm-5">
									<div class="box left-box">
										<h2 class="subheading">Fih.com's BRAG Rating</h2>
										<div class="left-rating">
                                            <?php
                                            $avgrating = ($brand_reputation+$risk_profile+$asset_value+$growth_potential);
                                            ?>
											<span><?php echo number_format($avgrating, 2, '.', ',')?></span>/<span>10</span>
										</div>
									</div>
								</div>
								<div class="col-sm-7">
									<div class="box right-box">
                                        <div class="subhead">Breakdown of Ratings</div>
                                        <ul>
                                            <li>Brand Reputation</li>
                                            <li><progress id="file" value="<?php echo ($brand_reputation/2.5)*100?>" max="100"></progress> <?php echo $brand_reputation?>/2.5</li>
                                            <li>Risk Profile</li>
                                            <li><progress id="file" value="<?php echo ($risk_profile/2.5)*100?>" max="100"></progress> <?php echo $risk_profile?>/2.5</li>
                                            <li>Asset Value</li>
                                            <li><progress id="file" value="<?php echo ($asset_value/2.5)*100?>" max="100"></progress> <?php echo $asset_value?>/2.5</li>
                                            <li>Growth Potential</li>
                                            <li><progress id="file" value="<?php echo ($growth_potential/2.5)*100?>" max="100"></progress> <?php echo $growth_potential?>/2.5</li>
                                        </ul>
                                        
									</div>
								</div>
							</div>
                        </div>
                        <?php
                        if(is_array($youtube_url) && count($youtube_url)>0)
                        {
                            ?>
                            <div class="Interview-Video mt40">
							<h2 class="subheading">Seller Interview:</h2>
                            <p>Get to know the owner of the business:</p>
							<!-- html start -->
							<!-- <div class="video-frame"> 
								<div class="owl-carousel video-slider">
									<div class="item">
										<div class="videoBox">
											<iframe width="560" height="315" src="https://www.youtube.com/embed/9xwazD5SyVg" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
										</div>
									</div>
									<div class="item">
										<div class="videoBox">
											<iframe width="560" height="315" src="https://www.youtube.com/embed/9xwazD5SyVg" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
										</div>
									</div>
								</div>
							</div> -->
							<!-- html end -->
                            
                                <div class="video-frame">
									<div class="owl-carousel video-slider">
									<?php
										foreach($youtube_url as $val)
										{
										preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $val, $match);
										$youtube_id = $match[1];
										?>
										<div class="item">
											<div class="videoBox">
                                    			<iframe width="510" height="315" src="https://www.youtube.com/embed/<?php echo $youtube_id?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
											</div>
										</div>
										<?php
										}
										?>
									</div>
                                </div>
                                
						</div>
                            <?php

                        }
                        ?>
						
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
	$currentYear = date('Y');
	$currentMonth = date('n');
	$Months= ['0'=>'JAN','1'=>'FEB','2'=>'MAR','3'=>'APR','4'=>'MAY','5'=>'JUN','6'=>'JUL','7'=>'AUG','8'=>'SEP','9'=>'OCT','10'=>'NOV','11'=>'DEC'];
	
	if(is_array($earnings) && count($earnings)>0)
	{
		foreach($earnings as $val)
		{
			if($currentYear>=$val['year'])
			{
				$earningYear = $val['year'];
				$newEarningArr[$earningYear] = $val;
				///

			}
		}
		ksort($newEarningArr,1);
		//print '<pre>';
		//print_r($newEarningArr);
		//die;
		foreach($newEarningArr as $nval)
		{
			$i = 0;
			$yearlyprofit = 0;
			$yearlyrevenue = 0;
			while($Months[$i]){
				if($nval['year']<$currentYear || ($nval['year'] == $currentYear && $currentMonth > ($i+1)))
				{
					if($nval['avgProfit'][$i]!='' && $nval['avgRevenue'][$i]!='')
					{
						$labelsArr[] = $Months[$i].' '.$nval['year'];
						$permonthavgProfit = ($nval['avgProfit'][$i]!='')?$nval['avgProfit'][$i]:0;
						$permonthavgRevenue = ($nval['avgRevenue'][$i]!='')?$nval['avgRevenue'][$i]:0;
						$avgProfitArr[] = $permonthavgProfit;
						$avgRevenueArr[] = $permonthavgRevenue;
						$yearlyprofit = $yearlyprofit + $permonthavgProfit;
						$yearlyrevenue = $yearlyrevenue + $permonthavgRevenue;
						$a++;
					}
					

				}
				
				$i++;
			}
			$yearlylabelsArr[] = $nval['year'];
			$yearlyavgProfitArr[] = $yearlyprofit;
			$yearlyavgRevenueArr[] = $yearlyrevenue;

		}

	}
	
	$labelstr =  join("','",$labelsArr);
	$avgProfitStr = join(",",$avgProfitArr);
	$avgRevenueStr = join(",",$avgRevenueArr);

	// yearly
	$yearlylabelstr =  join("','",$yearlylabelsArr);
	$yearlyavgProfitStr =  join(",",$yearlyavgProfitArr);
	$yearlyavgRevenueStr =  join(",",$yearlyavgRevenueArr);

	// print '<pre>';
	// print_r($yearlylabelstr);
	// echo '<br>';
	// print_r($yearlyavgProfitStr);
	// echo '<br>';
	// print_r($yearlyavgRevenueStr);
	// die;

	if(is_array($traffic) && count($traffic)>0)
	{
		foreach($traffic as $val)
		{
			if($currentYear>=$val['year'])
			{
				$trafficYear = $val['year'];
				$newTrafficArr[$trafficYear] = $val;
			}
		}
		ksort($newTrafficArr,1);
		foreach($newTrafficArr as $nval)
		{
			$i = 0;
			$yearlypageview = 0;
			$yearlyvisitor = 0;
			while($Months[$i]){
				if($nval['year']<$currentYear || ($nval['year'] == $currentYear && $currentMonth > ($i+1)))
				{
					if($nval['avgPageview'][$i]!='' && $nval['avgVisitor'][$i]!='')
					{
						$trafficlabelsArr[] = $Months[$i].' '.$nval['year'];
						$permonthavgpageview = ($nval['avgPageview'][$i]!='')?$nval['avgPageview'][$i]:0;
						$permonthavgvisitor = ($nval['avgVisitor'][$i]!='')?$nval['avgVisitor'][$i]:0;

						$avgPageviewArr[] = $permonthavgpageview;
						$avgVisitorArr[] = $permonthavgvisitor;

						$yearlypageview = $yearlypageview + $permonthavgpageview;
						$yearlyvisitor = $yearlyvisitor + $permonthavgvisitor;
					}
					
				}
				
				$i++;
			}
			$yearlytrafficlabelsArr[] = $nval['year'];
			$yearlypageviewArr[] = $yearlypageview;
			$yearlyavgvisitorArr[] = $yearlyvisitor;
		}

	}
	$trafficlabelstr =  join("','",$trafficlabelsArr);
	$avgPageviewStr = join(",",$avgPageviewArr);
	$avgVisitorStr = join(",",$avgVisitorArr);
	// yearly
	$yearlytrafficlabelstr =  join("','",$yearlytrafficlabelsArr);
	$yearlyavgvisitorStr =  join(",",$yearlyavgvisitorArr);
	$yearlyavgpageviewsStr =  join(",",$yearlypageviewArr);
	?>
	<div class="grap-img" data-aos="fade-up" data-aos-duration="2200">
		<input type="hidden" id="activebaseLabels" value="">
		<input type="hidden" id="activerevdata" value="">
		<input type="hidden" id="activeprofitdata" value="">

		<input type="hidden" id="trafficactivebaseLabels" value="">
		<input type="hidden" id="activepageviewdata" value="">
		<input type="hidden" id="activevisitoredata" value="">

		<!--<img src="<?php echo base_url();?>assets/frontend/images/sample/grap-img.jpg" alt="">-->
		<script src="<?php echo base_url();?>assets/frontend/js/chart/Chart.min.js"></script>
		<script src="<?php echo base_url();?>assets/frontend/js/chart/utils.js"></script>
		<script>
		//var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];
		var color = Chart.helpers.color;
		var baseLabels = ['<?php echo $labelstr?>']
		var baseLabelsYearly = ['<?php echo $yearlylabelstr; ?>']
		//var baseLabels = ['NOV 2017','DEC 2017','JAN 2018','FEB 2018','MAR 2018','APR 2018','MAY 2018','JUN 2018','JUL 2018','AUG 2018','SEP 2018','OCT 2018','NOV 2018','DEC 2018','JAN 2019','FEB 2019','MAR 2019','APR 2019','MAY 2019','JUN 2019','JUL 2019','AUG 2019','SEP 2019','OCT 2019','NOV 2019','DEC 2019','JAN 2020','FEB 2020','MAR 2020','APR 2020','MAY 2020','JUN 2020','JUL 2020','AUG 2020','SEP 2020','OCT 2020']
		//console.log(baseLabels);
		var baserevenueData = [<?php echo $avgRevenueStr; ?>]
		var baseProfitData = [<?php echo $avgProfitStr; ?>]
		//yearly
		var yearlybaserevenueData = [<?php echo $yearlyavgRevenueStr; ?>]
		var yearlybaseProfitData = [<?php echo $yearlyavgProfitStr; ?>]

		//var baserevenueData = [101,103,105,107,109,111,113,115,117,119,121,123,125,127,129,131,133,135,137,139,141,143,145,147,149,151,153,155,157,159,161,163,165,167,169,171]
		//var baseProfitData = [102,104,106,108,110,112,114,116,118,120,122,124,126,128,130,132,134,136,138,140,142,144,146,148,150,152,154,156,158,160,162,164,166,168,170,172]
		//console.log(baserevenueData);
		//console.log(baseProfitData);

		var activebaseLabels = baseLabels.slice(1).slice(-12);
		var activerevdata = baserevenueData.slice(1).slice(-12);
		var activeprofitdata = baseProfitData.slice(1).slice(-12);
		//$('#testhidden').val(activebaseLabels);
		document.getElementById("activebaseLabels").value = activebaseLabels;
		document.getElementById("activerevdata").value = activerevdata;
		document.getElementById("activeprofitdata").value = activeprofitdata;
		//console.log("first",activebaseLabels);
		//var activebaseLabels = ["JAN 2020","FEB 2020","MAR 2020","APR 2020","MAY 2020","JUN 2020","JUL 2020","AUG 2020","SEP 2020","OCT 2020","NOV 2020","DEC 2020"];
		//var activerevdata = [2000,2100,2110,3600,3662,3690,4500,2160,2690,4508,6211,4598];
		//var activeprofitdata = [3520,3550,3700,3810,3950,4012,3580,3641,5200,4980,6571,7521];
		
		//console.log(activebaseLabels);
		//console.log(activerevdata);
		//console.log(activeprofitdata);


		var trafficbaseLabels = ['<?php echo $trafficlabelstr?>']
		var trafficbasepageviewData = [<?php echo $avgPageviewStr; ?>]
		var trafficbaseVisitorData = [<?php echo $avgVisitorStr; ?>]

		var trafficbaseLabelsYearly = ['<?php echo $yearlytrafficlabelstr; ?>']
		var yearlytrafficbasepageviewData = [<?php echo $yearlyavgpageviewsStr; ?>]
		var yearlytrafficbaseVisitorData = [<?php echo $yearlyavgvisitorStr; ?>]


		var trafficactivebaseLabels = trafficbaseLabels.slice(1).slice(-12);
		var activepageviewdata = trafficbasepageviewData.slice(1).slice(-12);
		var activevisitoredata = trafficbaseVisitorData.slice(1).slice(-12);

		document.getElementById("trafficactivebaseLabels").value = activebaseLabels;
		document.getElementById("activepageviewdata").value = activerevdata;
		document.getElementById("activevisitoredata").value = activeprofitdata;

		//var trafficactivebaseLabels = ["JAN 2020","FEB 2020","MAR 2020","APR 2020","MAY 2020","JUN 2020","JUL 2020","AUG 2020","SEP 2020","OCT 2020","NOV 2020","DEC 2020"];
		//var activepageviewdata = [2000,2100,2110,3600,3662,3690,4500,2160,2690,4508,6211,4598];
		//var activevisitoredata = [3520,3550,3700,3810,3950,4012,3580,3641,5200,4980,6571,7521];
		

		/*var totalset = activebaseLabels.length;
		var totalRevenue = 0;
		var totalProfit = 0;
		activerevdata.map(d=>{
			totalRevenue = totalRevenue + parseInt(d)
		});

		activeprofitdata.map(p=>{
			totalProfit = totalProfit + parseInt(p)
		});
		$('#totalRevenue').html(numberWithCommas(totalRevenue));
		$('#avgRevenue').html(numberWithCommas(totalRevenue/totalset));

		$('#totalProfit').html(numberWithCommas(totalProfit));
		$('#avgprofit').html(numberWithCommas(parseInt(totalProfit/totalset)));*/


		var barChartData = {
			labels: activebaseLabels,
			datasets: [{
				label: 'Revenue',
				backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
				borderColor: window.chartColors.red,
				borderWidth: 1,
				data: activerevdata
			}, {
				label: 'Profit',
				backgroundColor: color(window.chartColors.yellow).alpha(0.5).rgbString(),
				borderColor: window.chartColors.yellow,
				borderWidth: 1,
				data: activeprofitdata
			}]

		};
		var trafficbarChartData = {
			labels: trafficactivebaseLabels,
			datasets: [{
				label: 'Visitors',
				backgroundColor: color(window.chartColors.yellow).alpha(0.5).rgbString(),
				borderColor: window.chartColors.yellow,
				borderWidth: 1,
				data: activevisitoredata
			}, {
				label: 'Pageviews',
				backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
				borderColor: window.chartColors.red,
				borderWidth: 1,
				data: activepageviewdata
			}]

		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myBar = new Chart(ctx, {
				type: 'bar',
				data: barChartData,
				options: {
					responsive: true,
					legend: {
						display: false,
                        position: 'top',
                        labels: {
                            fontColor: 'black'
                        }
					},
					title: {
						display: false,
						text: 'Chart.js Bar Chart'
					}
				}
			});





			var ctx1 = document.getElementById('canvas1').getContext('2d');
			window.myBar1 = new Chart(ctx1, {
				type: 'bar',
				data: trafficbarChartData,
				options: {
					responsive: true,
					legend: {
						display: false,
                        position: 'top',
                        labels: {
                            fontColor: 'black'
                        }
					},
					title: {
						display: false,
						text: 'Chart.js Bar Chart'
					}
				}
			});

		};

		/*document.getElementById('randomizeData').addEventListener('click', function() {
			var zero = Math.random() < 0.2 ? true : false;
			barChartData.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return zero ? 0.0 : randomScalingFactor();
				});

			});
			window.myBar.update();
		});*/

		var colorNames = Object.keys(window.chartColors);
		
		
		function alltinmeearning(obj){
			if(baseLabelsYearly.length > 3 )
			{
				barChartData.labels=baseLabelsYearly ; // remove the label first
				barChartData.datasets[0].data = yearlybaserevenueData;
				barChartData.datasets[1].data = yearlybaseProfitData;
			}else{
				barChartData.labels=baseLabels ; // remove the label first
				barChartData.datasets[0].data = baserevenueData;
				barChartData.datasets[1].data = baseProfitData;
			}
			

			
			
			window.myBar.update();
			$('.earningbtn').removeClass('active');
			$(obj).addClass('active');
			if(baseLabelsYearly.length > 3 )
			{
				var totalset = baseLabelsYearly.length;
				var totalRevenue = 0;
				var totalProfit = 0;
				yearlybaserevenueData.map(d=>{
					totalRevenue = totalRevenue + parseInt(d)
				});
				yearlybaseProfitData.map(p=>{
					totalProfit = totalProfit + parseInt(p)
				});
			}else{
				var totalset = baseLabels.length;
				var totalRevenue = 0;
				var totalProfit = 0;
				baserevenueData.map(d=>{
					totalRevenue = totalRevenue + parseInt(d)
				});
				baseProfitData.map(p=>{
					totalProfit = totalProfit + parseInt(p)
				});
			}
			
			$('#totalRevenue').html(numberWithCommas(totalRevenue));
			$('#avgRevenue').html(numberWithCommas(parseInt(totalRevenue/totalset)));

			$('#totalProfit').html(numberWithCommas(totalProfit));
			$('#avgprofit').html(numberWithCommas(parseInt(totalProfit/totalset)));
			
		}
		function twelvemonthearning(obj){
			var last12monthlabels = baseLabels.slice(1).slice(-12);
			var last12monthrevdata = baserevenueData.slice(1).slice(-12);
			var last12monthprofitdata = baseProfitData.slice(1).slice(-12);

			barChartData.labels=last12monthlabels ; // remove the label first
			barChartData.datasets[0].data = last12monthrevdata;
			barChartData.datasets[1].data = last12monthprofitdata;
			window.myBar.update();
			$('.earningbtn').removeClass('active');
			$(obj).addClass('active');

			var totalset = last12monthlabels.length;
			var totalRevenue = 0;
			var totalProfit = 0;
			last12monthrevdata.map(d=>{
				totalRevenue = totalRevenue + parseInt(d)
			});

			last12monthprofitdata.map(p=>{
				totalProfit = totalProfit + parseInt(p)
			});
			$('#totalRevenue').html(numberWithCommas(totalRevenue));
			$('#avgRevenue').html(numberWithCommas(parseInt(totalRevenue/totalset)));

			$('#totalProfit').html(numberWithCommas(totalProfit));
			$('#avgprofit').html(numberWithCommas(parseInt(totalProfit/totalset)));
			
		}
		function threemonthearning(obj){
			var last10monthlabels = baseLabels.slice(1).slice(-3);
			var last10monthrevdata = baserevenueData.slice(1).slice(-3);
			var last10monthprofitdata = baseProfitData.slice(1).slice(-3);

			barChartData.labels=last10monthlabels ; // remove the label first
			barChartData.datasets[0].data = last10monthrevdata;
			barChartData.datasets[1].data = last10monthprofitdata;
			window.myBar.update();
			$('.earningbtn').removeClass('active');
			$(obj).addClass('active');

			var totalset = last10monthrevdata.length;
			var totalRevenue = 0;
			var totalProfit = 0;
			last10monthrevdata.map(d=>{
				totalRevenue = totalRevenue + parseInt(d)
			});

			last10monthprofitdata.map(p=>{
				totalProfit = totalProfit + parseInt(p)
			});
			$('#totalRevenue').html(numberWithCommas(totalRevenue));
			$('#avgRevenue').html(numberWithCommas(parseInt(totalRevenue/totalset)));

			$('#totalProfit').html(numberWithCommas(totalProfit));
			$('#avgprofit').html(numberWithCommas(parseInt(totalProfit/totalset)));
			
		}
		////////////////
		
		function alltinmetraffic(obj){

			if(trafficbaseLabelsYearly.length> 3)
			{
				trafficbarChartData.labels=trafficbaseLabelsYearly ; // remove the label first
				trafficbarChartData.datasets[0].data = yearlytrafficbaseVisitorData;
				trafficbarChartData.datasets[1].data = yearlytrafficbasepageviewData;
			}else{
				trafficbarChartData.labels=trafficbaseLabels ; // remove the label first
				trafficbarChartData.datasets[0].data = trafficbaseVisitorData;
				trafficbarChartData.datasets[1].data = trafficbasepageviewData;
			}



            
			window.myBar1.update();
			$('.trafficbtn').removeClass('active');
			$(obj).addClass('active');
			if(trafficbaseLabelsYearly.length> 3)
			{
				var totalset = trafficbaseLabelsYearly.length;
				var totalVisitor = 0;
				var totalPageview = 0;
				yearlytrafficbaseVisitorData.map(d=>{
					totalVisitor = totalVisitor + parseInt(d)
				});

				yearlytrafficbasepageviewData.map(p=>{
					totalPageview = totalPageview + parseInt(p)
				});
			}else{
				var totalset = trafficbaseLabels.length;
				var totalVisitor = 0;
				var totalPageview = 0;
				trafficbaseVisitorData.map(d=>{
					totalVisitor = totalVisitor + parseInt(d)
				});

				trafficbasepageviewData.map(p=>{
					totalPageview = totalPageview + parseInt(p)
				});
			}
			$('#totalVisitor').html(numberWithCommas(totalVisitor));
			$('#avgVisitor').html(numberWithCommas(parseInt(totalVisitor/totalset)));

			$('#totalPageview').html(numberWithCommas(totalPageview));
			$('#avgPageview').html(numberWithCommas(parseInt(totalPageview/totalset)));
			
		}
		function twelvemonthtraffic(obj){
			var last12monthlabels = trafficbaseLabels.slice(1).slice(-12);
			var last12monthvisitordata = trafficbaseVisitorData.slice(1).slice(-12);
			var last12monthpageviewdata = trafficbasepageviewData.slice(1).slice(-12);

			trafficbarChartData.labels=last12monthlabels ; // remove the label first
			trafficbarChartData.datasets[0].data = last12monthvisitordata;
			trafficbarChartData.datasets[1].data = last12monthpageviewdata;
			window.myBar1.update();
			$('.trafficbtn').removeClass('active');
			$(obj).addClass('active');

			var totalset = last12monthlabels.length;
			var totalVisitor = 0;
			var totalPageview = 0;
			last12monthvisitordata.map(d=>{
				totalVisitor = totalVisitor + parseInt(d)
			});

			last12monthpageviewdata.map(p=>{
				totalPageview = totalPageview + parseInt(p)
			});
			$('#totalVisitor').html(numberWithCommas(totalVisitor));
			$('#avgVisitor').html(numberWithCommas(parseInt(totalVisitor/totalset)));

			$('#totalPageview').html(numberWithCommas(totalPageview));
			$('#avgPageview').html(numberWithCommas(parseInt(totalPageview/totalset)));
			
		}
		function threemonthtraffic(obj){
			var last10monthlabels = trafficbaseLabels.slice(1).slice(-3);
			var last10monthvisitordata = trafficbaseVisitorData.slice(1).slice(-3);
			var last10monthpageviewdata = trafficbasepageviewData.slice(1).slice(-3);

			trafficbarChartData.labels=last10monthlabels ; // remove the label first
			trafficbarChartData.datasets[0].data = last10monthvisitordata;
			trafficbarChartData.datasets[1].data = last10monthpageviewdata;
			window.myBar1.update();
			$('.trafficbtn').removeClass('active');
			$(obj).addClass('active');

			var totalset = last10monthvisitordata.length;
			var totalVisitor = 0;
			var totalPageview = 0;
			last10monthvisitordata.map(d=>{
				totalVisitor = totalVisitor + parseInt(d)
			});

			last10monthpageviewdata.map(p=>{
				totalPageview = totalPageview + parseInt(p)
			});
			$('#totalVisitor').html(numberWithCommas(totalVisitor));
			$('#avgVisitor').html(numberWithCommas(parseInt(totalVisitor/totalset)));

			$('#totalPageview').html(numberWithCommas(totalPageview));
			$('#avgPageview').html(numberWithCommas(parseInt(totalPageview/totalset)));
			
		}
		function numberWithCommas(x) {
			//return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
			return x.toLocaleString();
		}
		
	</script>
	<?php
	if(is_array($earnings) && count($earnings)>0)
	{
		?>
	<section class="section earnings">
		<div class="container">
			<h2 class="heading font35">Earnings</h2>
			<div class="grap-top">
				<div class="row">
					<div class="col-sm-6">
						<div class="box">
							<div class="row">
								<div class="col-sm-12">
									<div class="d-flex">
										<div class="name">Revenue: </div>
										<ul class="ul">
											<li><span>Average Revenue:</span>&nbsp;<?php echo $sitesettings['symbol'];?><span id="avgRevenue"></span></li>
											<li><span>Total Revenue: </span>&nbsp;<?php echo $sitesettings['symbol'];?><span id="totalRevenue"></span></li>
										</ul>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="d-flex">
										<div class="name">Profit:</div>
										<ul class="ul">
											<li><span>Average Profit:</span>&nbsp;<?php echo $sitesettings['symbol'];?><span id="avgprofit"></span></li>
											<li><span>Total Profit:</span>&nbsp;<?php echo $sitesettings['symbol'];?><span id="totalProfit"></span></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="box text-right">
							<div class="btn-group">
								<!--<button type="button" class="btn btn_t active" onClick="alltinmeearning()">All Time</button>
								<button type="button" class="btn btn_t active" onClick="twelvemonthearning()">12 Months</button>-->
								<a href="javascript: void(0)" class="btn ml-2 btn_t earningbtn " onClick="alltinmeearning(this)">All Time</a>
								<a href="javascript: void(0)" class="btn ml-2 earningbtn btn_t active" id="activeearninggraph" onClick="twelvemonthearning(this)">12 Months</a>
								<a href="javascript: void(0)" class="btn ml-2 earningbtn btn_t" onClick="threemonthearning(this)" id="">3 Months</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<canvas id="canvas" style="width: 75%;"></canvas>
		</div>
	</section>
	<?php
	}
	//print '<pre>';
	//print_r($traffic);
	if(is_array($traffic) && count($traffic)>0)
	{
		?>
	<section class="section traffic">
		<div class="container">
			<h2 class="heading font35">Traffic</h2>
			<div class="grap-top">
				<div class="row">
					<div class="col-sm-6">
						<div class="box">
							<div class="row">
								<div class="col-sm-12">
									<div class="d-flex">
										<div class="name">Page View: </div>
										<ul class="ul">
											<li><span>Average Pageviews:</span>&nbsp;<span id="avgPageview"></span></li>
											<li><span>Total Pageviews:</span>&nbsp;<span id="totalPageview"></span></li>
										</ul>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="d-flex">
										<div class="name">Visitors:</div>
										<ul class="ul">
											<li><span>Average Visitors:</span>&nbsp;<span id="avgVisitor"></span></li>
											<li><span>Total Visitors:</span>&nbsp;<span id="totalVisitor"></span></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="box text-right">
							<div class="btn-group">
								<a href="javascript: void(0)" class="btn btn_t trafficbtn" onClick="alltinmetraffic(this)">All Time</a>
								<a href="javascript: void(0)" class="btn ml-2 trafficbtn btn_t active" onClick="twelvemonthtraffic(this)">12 Months</a>
								<a href="javascript: void(0)" class="btn ml-2 trafficbtn btn_t" onClick="threemonthtraffic(this)">3 Months</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<canvas id="canvas1" style="width: 75%;"></canvas>
		</div>
	</section>
	<?php
	}
	?>	 

	</div>
	<?php
		if(is_array($seo_data) && count($seo_data)>0)
		{
	?>
	<section class="section seo-data" data-aos="fade-up" data-aos-duration="2200">
		<div class="container">
			<h2 class="heading text-center">SEO Data</h2>
			<div class="short-para text-center">Provided by Alexa</div>
			<?php
				if($permission['isunlocked'] == false)
				{
				?>
			<div class="content LockContentBox d-flex align-items-center justify-content-between">

				<figure><img src="<?php echo base_url();?>assets/frontend/images/sample/seo-data-lockIcon.png" alt=""></figure>
				<h2 class="subheading">This Content Is Only Accessible By Uncovering This Listing</h2>
				
				<a href="<?php echo $unlockLink;?>" class="<?php echo $class?> btn" <?php echo $datafancybox;?>>Uncover Listing</a>
				
			</div>
			<?php
				}else{
					if(is_array($seo_data) && count($seo_data)>0)
					{
						?>
						<div class="content LockContentBox d-flex align-items-center justify-content-between">
						<table >
							<?php
							foreach($seo_data as $k=>$v)
							{
								?>
								<tr>
								<th><?php echo $v['title'];?></th>
								<td><?php echo $v['value'];?></td>
								</tr>
								<?php
							}
							?>
						</table>
					</div>
						<?php
					}
				}
			?>
		</div> 
	</section>
	<?php
		}
		?>
	<section class="section work-skill">
		<div class="container">
			<!-- <div class="row">
				<div class="col-sm-6"> 
					<div class="work-skill-list">
						<ul class="ul row">
							<li class="col-sm-4" data-aos="fade-down-left" data-aos-duration="2200">
								<div class="box">
									<figure><img src="images/sample/skill1.png" alt=""></figure>
									<h2 class="subheading">Social Media Channels
									</h2>
								</div>
							</li>
							<li class="col-sm-4" data-aos="fade-down-left" data-aos-duration="2200">
								<div class="box">
									<figure><img src="images/sample/skill1.png" alt=""></figure>
									<h2 class="subheading">Work & Skills Required</h2>
								</div>
							</li>
							<li class="col-sm-4" data-aos="fade-down-left" data-aos-duration="2200">
								<div class="box">
									<figure><img src="images/sample/skill3.png" alt=""></figure>
									<h2 class="subheading">Other Information</h2>
								</div>
							</li>
							<li class="col-sm-4" data-aos="fade-up-right" data-aos-duration="2200">
								<div class="box">
									<figure><img src="images/sample/skill4.png" alt=""></figure>
									<h2 class="subheading">Seller Support Includes</h2>
								</div>
							</li>
							<li class="col-sm-4" data-aos="fade-up-right" data-aos-duration="2200">
								<div class="box">
									<figure><img src="images/sample/skill5.png" alt=""></figure>
									<h2 class="subheading">Reason for Sale</h2>
								</div>
							</li>
							<li class="col-sm-4" data-aos="fade-up-right" data-aos-duration="2200">
								<div class="box">
									<figure><img src="images/sample/skill6.png" alt=""></figure>
									<h2 class="subheading">Buyer Profiles</h2>
								</div>
							</li>
						</ul>
					</div> 
				</div>
				<div class="col-sm-6">
					<h2 class="heading font35 font-weight-black">Work & Skills Required</h2>
					<p>The Seller currently spends around 15 hours per week:</p>
					<div class="editor_text">
						<ul>
							<li>Writing Content</li>
							<li>Managing affiliate relationships</li>
							<li>Posting on social media</li>
							<li>Updating website content</li>
						</ul>
					</div>
				</div>
			</div> -->

			<div class="work-skill-list" data-aos="fade-left" data-aos-duration="2400">
				<div class="tab-menu">
					<ul class='ul'> 
					<?php
						$socialAcviveTab = 'N';
						$skillAcviveTab = 'N';
						$otherinfoAcviveTab = 'N';
						$supportinfoAcviveTab = 'N';
						$salereasonAcviveTab = 'N';
						$buyerprofileAcviveTab = 'N';
					   if($fb_link !='' || $twitter_link!='' || $insta_link!='' || $youtube_link!='' || $pinterest_link!='' || $linkedin_link !='' || $extrasocialmedia !='')
					   {
						   $socialAcviveTab = 'Y';
						   ?>
						<li><a href="javascript:void(0)" class="tab-a <?php echo ($socialAcviveTab == 'Y')? 'active-a':''; ?>" data-id="tab1"><figure><img src="<?php echo base_url();?>assets/frontend/images/sample/skill1.png" alt=""></figure>Social Media Channels</a></li>
						<?php
					   }
					   if((is_array($skills) && count($skills)>0) || $skill_description != '')
					   {	
							if($socialAcviveTab == 'N')
							{
								$skillAcviveTab = 'Y';
							}
						   ?>
					   <li><a href="javascript:void(0)" class="tab-a <?php echo ($skillAcviveTab == 'Y')? 'active-a':''; ?>" data-id="tab2"><figure><img src="<?php echo base_url();?>assets/frontend/images/sample/skill3.png" alt=""></figure>Work & Skills Required</a></li>
					   <?php
					   }
					   if((is_array($other_info) && count($other_info)>0) || $other_info_description != '')
					   {
							if($socialAcviveTab == 'N' && $skillAcviveTab == 'N')
							{
								$otherinfoAcviveTab = 'Y';
							}
						   ?>
					   <li><a href="javascript:void(0)" class="tab-a <?php echo ($otherinfoAcviveTab == 'Y')? 'active-a':''; ?>" data-id="tab3"><figure><img src="<?php echo base_url();?>assets/frontend/images/sample/skill3.png" alt=""></figure>Other Information</a></li>
					   <?php
					   }
					   if($support_seller_included !='')
					   {
							if($socialAcviveTab == 'N' && $skillAcviveTab == 'N' && $otherinfoAcviveTab == 'N')
							{
								$supportinfoAcviveTab = 'Y';
							}
						   ?>
					   <li><a href="javascript:void(0)" class="tab-a <?php echo ($supportinfoAcviveTab == 'Y')? 'active-a':''; ?>" data-id="tab4"><figure><img src="<?php echo base_url();?>assets/frontend/images/sample/skill4.png" alt=""></figure>Seller Support Includes</a></li>
					   <?php
					   }
					   if($reason_for_sale !='')
					   {
							if($socialAcviveTab == 'N' && $skillAcviveTab == 'N' && $otherinfoAcviveTab == 'N' && $supportinfoAcviveTab == 'N')
							{
								$salereasonAcviveTab = 'Y';
							}
						   ?>
						   <li><a href="javascript:void(0)" class="tab-a <?php echo ($salereasonAcviveTab == 'Y')? 'active-a':''; ?>" data-id="tab5"><figure><img src="<?php echo base_url();?>assets/frontend/images/sample/skill5.png" alt=""></figure>Reason for Sale</a></li>
						   <?php
					   }
						if((is_array($buyer_profile) && count($buyer_profile)>0) || $buyer_profile_description != '')
						{
							if($socialAcviveTab == 'N' && $skillAcviveTab == 'N' && $otherinfoAcviveTab == 'N' && $supportinfoAcviveTab == 'N' && $salereasonAcviveTab == 'N')
							{
								$buyerprofileAcviveTab = 'Y';
							}
							?>
					   <li><a href="javascript:void(0)" class="tab-a <?php echo ($buyerprofileAcviveTab == 'Y')? 'active-a':''; ?>" data-id="tab6"><figure><img src="<?php echo base_url();?>assets/frontend/images/sample/skill6.png" alt=""></figure>Buyer Profiles</a></li>
					   <?php
						}
						?>
					</ul>
					</div>
				
				<div class='tabDetails'>
					<div class="tab <?php echo ($socialAcviveTab == 'Y')? 'tab-active':''; ?> " data-id="tab1">
						<div class="right-work">
							<h2 class="heading font35 font-weight-black">Social Media Channels</h2>
							<?php
				if($permission['isunlocked'] == false)
				{
					?>

					<div class="LockContentBox2"> 
						<figure><img src="<?php echo base_url();?>assets/frontend/images/sample/seo-data-lockIcon.png" alt=""></figure>
						<h2 class="subheading">This Content Is Only Accessible By Uncovering This Listing</h2> 
						<a href="<?php echo $unlockLink;?>" class="<?php echo $class?> btn" <?php echo $datafancybox;?>>Uncover Listing</a> 
					</div>  

					<?php

				}else{
				?>
							<div class="social_text">
								<ul>
                                    <?php
                                    if($fb_link !='')
                                    {
                                        ?>
                                        <li><i class="fa fa-facebook-official" aria-hidden="true"></i> <a href="<?php echo $fb_link;?>" target="_blank"><?php echo $fb_link;?></a></li>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if($twitter_link !='')
                                    {
                                        ?>
                                        <li><i class="fa fa-twitter" aria-hidden="true"></i> <a href="<?php echo $twitter_link;?>" target="_blank"><?php echo $twitter_link;?></a></li>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                    if($insta_link !='')
                                    {
                                        ?>
                                        <li><i class="fa fa-instagram" aria-hidden="true"></i> <a href="<?php echo $insta_link;?>" target="_blank"><?php echo $insta_link;?></a></li>
                                        <?php
                                    }
                                    ?>
									<?php
                                    if($youtube_link !='')
                                    {
                                        ?>
                                        <li><i class="fa fa-youtube-play" aria-hidden="true"></i> <a href="<?php echo $youtube_link;?>" target="_blank"><?php echo $youtube_link;?></a></li>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if($pinterest_link !='')
                                    {
                                        ?>
                                        <li><i class="fa fa-pinterest" aria-hidden="true"></i> <a href="<?php echo $pinterest_link;?>" target="_blank"><?php echo $pinterest_link;?></a></li>
                                        <?php
                                    }
                                    ?><?php
                                    if($linkedin_link !='')
                                    {
                                        ?>
                                        <li><i class="fa fa-linkedin-square" aria-hidden="true"></i> <a href="<?php echo $linkedin_link;?>" target="_blank"><?php echo $linkedin_link;?></a></li>
                                        <?php
									}
									if($extrasocialmedia !='')
                                    {
										foreach($extrasocialmedia as $sm)
										{
											?>
											<li><i class="fa fa-external-link" aria-hidden="true"></i> <a href="<?php echo $sm;?>" target="_blank"><?php echo $sm;?></a></li>
											<?php
										}
									}
                                    ?>
								</ul>
							</div>
							<?php
				}
				?>
						</div>
					</div>
					<div class="tab <?php echo ($skillAcviveTab == 'Y')? 'tab-active':''; ?>" data-id="tab2">  
                    <div class="right-work">
							<h2 class="heading font35 font-weight-black">Work & Skills Required</h2>
							<?php echo $skill_description?>
							<div class="editor_text">
								<ul>
                                <?php 
                                    if(is_array($skills) && count($skills)>0)
                                    {
                                        foreach($skills as $val)
                                        {
                                            ?>
                                            <li><?php echo $val;?></li>
                                            <?php
                                        }
                                    }
                                    
                                    
                                    ?>
								</ul>
							</div>
						</div>
					</div>
					<div class="tab <?php echo ($otherinfoAcviveTab == 'Y')? 'tab-active':''; ?>" data-id="tab3">
                    <div class="right-work">
							<h2 class="heading font35 font-weight-black">Other Information</h2>
							<?php echo $other_info_description?>
							<div class="editor_text">
								<ul>
                                <?php 
                                    if(is_array($other_info) && count($other_info)>0)
                                    {
                                        foreach($other_info as $val)
                                        {
                                            ?>
                                            <li><strong><?php echo $val['title'];?></strong>: <?php echo $val['value'];?></li>
                                            <?php
                                        }
                                    }
                                    
                                    
                                    ?>
								</ul>
							</div>
						</div>
					</div>
					<div class="tab <?php echo ($supportinfoAcviveTab == 'Y')? 'tab-active':''; ?>" data-id="tab4">
                    <div class="right-work">
							<h2 class="heading font35 font-weight-black">Seller Support Includes</h2>
                                <?php echo $support_seller_included;?>
                                </div>
					</div>
					<div class="tab <?php echo ($salereasonAcviveTab == 'Y')? 'tab-active':''; ?>" data-id="tab5">
                    <div class="right-work">
							<h2 class="heading font35 font-weight-black">Reason for Sale</h2>
                                <?php echo $reason_for_sale;?>   
					</div>
					</div> 
					<div class="tab <?php echo ($buyerprofileAcviveTab == 'Y')? 'tab-active':''; ?>" data-id="tab6">
                    <div class="right-work">
							<h2 class="heading font35 font-weight-black">Buyers Profiles</h2>
							<?php echo $buyer_profile_description?>
							<div class="editor_text">
								<ul>
                                <?php 
                                    if(is_array($buyer_profile) && count($buyer_profile)>0)
                                    {
                                        foreach($buyer_profile as $val)
                                        {
                                            ?>
                                            <li><strong><?php echo $val['title'];?></strong>: <?php echo $val['value'];?></li>
                                            <?php
                                        }
                                    }
                                    
                                    
                                    ?>
								</ul>
							</div>
					</div>
					</div> 
				</div>
			</div>

		</div>
	</section>
	<?php
	if((is_array($Strength) && count($Strength)>0) || (is_array($Opertunities) && count($Opertunities)>0) || (is_array($Weakness) && count($Weakness)>0) || (is_array($Threats) && count($Threats)>0))
	{
		?>
	<section class="section analysis" data-aos="fade-up" data-aos-duration="2200">
		<div class="container">
			<h2 class="heading font35 font-weight-black text-center">SWOT Analysis</h2>
			<div class="short-desc text-center"></div>
			<div class="analysis-list mt30">
				<ul class="ul row">
					<li class="col-md-6 col-sm-6" data-aos="fade-down-right" data-aos-duration="2200">
						<div class="box">
							<h2 class="subheading font-weight-black">Strengths</h2>
							<div class="editor_text">
								<ul>
                                <?php 
                                    if(is_array($Strength) && count($Strength)>0)
                                    {
                                        foreach($Strength as $val)
                                        {
                                            ?>
                                            <li><?php echo $val;?></li>
                                            <?php
                                        }
                                    }
                                    
                                    
                                    ?>
								</ul>
							</div>
						</div>
					</li>
					<li class="col-md-6 col-sm-6" data-aos="fade-down-left" data-aos-duration="2200">
						<div class="box">
							<h2 class="subheading font-weight-black">Opportunities</h2>
							<div class="editor_text">
								<ul>
                                <?php 
                                    if(is_array($Opertunities) && count($Opertunities)>0)
                                    {
                                        foreach($Opertunities as $val)
                                        {
                                            ?>
                                            <li><?php echo $val;?></li>
                                            <?php
                                        }
                                    }
                                    
                                    
                                    ?>
								</ul>
							</div>
						</div>
					</li>
					<li class="col-md-6 col-sm-6" data-aos="fade-up-right" data-aos-duration="2200">
						<div class="box">
							<h2 class="subheading font-weight-black">Weaknesses</h2>
							<div class="editor_text">
								<ul>
                                <?php 
                                    if(is_array($Weakness) && count($Weakness)>0)
                                    {
                                        foreach($Weakness as $val)
                                        {
                                            ?>
                                            <li><?php echo $val;?></li>
                                            <?php
                                        }
                                    }
                                    
                                    
                                    ?>
								</ul>
							</div>
						</div>
					</li>
					<li class="col-md-6 col-sm-6" data-aos="fade-up-left" data-aos-duration="2200">
						<div class="box">
							<h2 class="subheading font-weight-black">Threats</h2>
							<div class="editor_text">
								<ul>
                                    <?php 
                                    if(is_array($Threats) && count($Threats)>0)
                                    {
                                        foreach($Threats as $val)
                                        {
                                            ?>
                                            <li><?php echo $val;?></li>
                                            <?php
                                        }
                                    }
                                    
                                    
                                    ?>
								</ul>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</section>
	<?php
	}
	?>
	<section class="section frequently-asked-questions">
		<div class="container">
			<h2 class="heading font-weight-black font35 text-center" data-aos="fade-down" data-aos-duration="2200">
				Frequently Asked Questions
			</h2>
			<div class="short-desc text-center">Answered by the Seller</div>
				<?php
				if($permission['isunlocked'] == false)
				{
				?>
			<div class="content-box lockBox" data-aos="zoom-in" data-aos-duration="2200">
				<figure><img src="<?php echo base_url();?>assets/frontend/images/sample/lock-faq.png" alt=""></figure>
				<h2 class="subheading">This content is only accessible by Uncovering this listing</h2>
				<a href="<?php echo $unlockLink;?>" class="<?php echo $class?> btn" <?php echo $datafancybox;?>>Uncover Listing</a>
			</div>
			<?php
				}elseif($permission['isunlocked'] == true)
				{
					//faq listing
					?>
					<div class="faq-list">
					<div class="sk_toggle">
					<?php
					if(is_array($faq['record']) && count($faq['record'])>0)
					{
						$i=0;
						foreach($faq['record'] as $faqVal)
						{
							$opened = ($i == 0) ? 'opened' : '';
							$block = ($i == 0) ? 'display: block;' : 'display: none;';
							?>
							<div class="sk_box <?php echo $opened?>">
							<div class="sk_ques">
								<h2 class="subheading"><?php echo $faqVal['question'];?></h2>
							</div>
							<div class="sk_ans" style="<?php echo $block;?>">
								<div class="editor_text"><?php echo $faqVal['seller_reply'];?></div>
							</div>
							</div> 
							<?php
							$i++;
						}
					}else{
						echo 'No Frequently Asked Questions found.';
					}
					?>

					</div>
					</div>
					<?php
					//echo $faq['totalrecord']['totalrecord'];
					if($faq['totalrecord']['totalrecord']>10)
					{
						?>
						<a href="#faqlist" class="btn fancybox" data-fancybox>Load More</a>
						<div id="faqlist" style="display:none;">
						<div class="faq-list">
							<div class="sk_toggle" id="loadfaq">
									<?php
									if(is_array($faq['record']) && count($faq['record'])>0)
									{
										$i=0;
										foreach($faq['record'] as $faqVal)
										{
											$opened = ($i == 0) ? 'opened' : '';
											$block = ($i == 0) ? 'display: block;' : 'display: none;';
											?>
											<div class="sk_box <?php echo $opened?>">
											<div class="sk_ques">
												<h2 class="subheading"><?php echo $faqVal['question'];?></h2>
											</div>
											<div class="sk_ans" style="<?php echo $block;?>">
												<div class="editor_text"><?php echo $faqVal['seller_reply'];?></div>
											</div>
											</div> 
											<?php
											$i++;
										}
									}else{
										echo 'No FAQ found.';
									}
									?>

							</div>
							</div>
							<a href="javascript: void(0)" class="btn loadmorefaq">Load More</a>
							<input type="hidden" id="faqStart" value="10">
							<input type="hidden" id="faqLimit" value="10">
							<div class="loadfaqskeleton" style="display:none">
							<div class="sk_box ">
											<div class="sk_ques">
												<h2 class="subheading">[QUESTION]</h2>
											</div>
											<div class="sk_ans" style="display: none;">
												<div class="editor_text">[SELLERREPLY]</div>
											</div>
											</div> 
							</div>
						</div>
						
						<?php
					}
				}
				?>
		</div>
		<div id="lock-content" style="display:none;">
		<?php $this->load->view('frontend/listing-uncover-final');?>
		</div>
	</section>
	<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
	<input type="hidden" class="" id="listingNo" value="<?php echo $listingNo; ?>" />
	<?php
	if(is_array($recomendedBusiness['recomended']) && count($recomendedBusiness['recomended'])>0)
	{
	?> 
	<section class="section Recommended-Businesses">
		<div class="container">
			<h2 class="heading font35 font-weight-black text-center mb-1" data-aos="fade-down" data-aos-duration="2200">Recommended Businesses</h2>
			<div class="short-desc text-center mb25">Based on similar listing criteria</div>
			<div class="latest-list">
				<ul class="ul">
					<?php
					foreach($recomendedBusiness['recomended'] as $rb)
					{
						$monetizationstrrb = '';
						?>
						<li data-aos="fade-up" data-aos-duration="2200">
						<div class="box">
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
												/*if(is_array($rb['monetization']) && count($rb['monetization'])>0)
												{
													foreach($rb['monetization'] as $val)
													{
														$monetizationstrrb .=  $val['name'].', ';
													}
													echo rtrim($monetizationstrrb,', ');
												}*/
												echo mb_strimwidth($rb['monetizationStr'], 0, 70, '...');
												?></span>
											</div>
											<div class="block">
												<div class="head">Site Age</div>
												<span><?php echo $rb['business_age'];?></span>
											</div>
											<div class="block">
												<div class="head">Net Profit</div>
												<span><?php echo $sitesettings['symbol'];?><?php echo number_format($rb['monthly_profit'], 0, '.', ',')?> p/mo</span>
											</div>
											<div class="block">
												<div class="head">Traffic</div>
												<span><?php echo number_format($rb['traffic_per_month'], 0, '.', ',')?> p/mo</span>
											</div>   
										</div>
										<div class="starting-price">
											<span>Listing Price</span>:&nbsp;<?php echo $sitesettings['symbol'];?><?php echo number_format($rb['price'], 0, '.', ',')?>
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
					?>
					
					
				</ul>
			</div>
			<div data-aos="fade-up" data-aos-duration="2200" class="btn_center">
				<a href="<?php echo base_url();?>marketplace" class="btn">View All <?php echo $recomendedBusiness['totallist']['totalList']?> Listings </a>
			</div>
		</div>
	</section>
	<?php
	}else{
		?>
		<br>
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
							<figure><img src="<?php echo base_url();?>uploads/partner-image/<?php echo $val['partner_image'];?>" alt=""></figure>
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

<div id="myId" style="display:none"></div>

	