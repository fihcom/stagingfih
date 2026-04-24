<main class="mainContainer">
	<section class="section unlock-section">
		<div class="container">
			<h2 class="heading text-center font-weight-bold">Unlock Listing</h2>
			<div class="text-center"><span class="step-listing-price-btn"><span>Listing price: </span> $<?php echo number_format($listingDetails['price'], 0, '.', ',')?></span></div>
			<div class="unlock-step">
				<div class="row">
					<div class="col-md-6 step1 <?php echo ($userDetails['identity_proof_status'] == 1)?'verified-identity':'';?>">
						<div class="box">
							<div class="step-heading">
								<div class="heading">Step 01 <span>Verify Your Identity</span></div>
							</div>
						<?php
							if($userDetails['identity_proof_status'] == 2){
								?>
						<div class="clock">
							<div class="top"></div>
							<div class="right"></div>
							<div class="bottom"></div>
							<div class="left"></div>
							<div class="center"></div>
							<div class="shadow"></div>
							<div class="hour"></div>
							<div class="minute"></div>
							<div class="second"></div>
						</div> 
						<h1 class="text-center WaitingforFundApproval">Waiting for Identity Approval</h1>
						<div class="text-center WaitingforFundApproval"> Your documents are being review and should be processed shortly. You will be notified once the verification process is complete.</div>
						<?php
					}elseif($userDetails['identity_proof_status'] == 1){
						?>
						<div class="text-center WaitingforFundApproval">
						<i class="fa fa-check" aria-hidden="true" style="font-size:80px;"></i><h1>Verified</h1>
						Your Identity is verified.</div>
						<?php
					}
					else{
						?>
						<form id="verifyIdentitystep1" action="<?php echo base_url();?>user/verifyIdentityaction?redirect_to=listing/uncover/<?php echo $listingid?>" method="post">
							<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
							<input type="hidden" name="verificationType" value="online">
							<input type="hidden" name="personainquiryId" id="personainquiryId" value="">
							<div class="stepbox">
								<div class="head-top d-flex align-items-center flex-wrap">
									<div class="icon-left"><i class="fa fa-id-card-o" aria-hidden="true"></i></div>
									<h2 class="subheading unlock-subhead">Verify Identity <a href="#" class="info-icon"><i class="fa fa-info-circle" aria-hidden="true"></i>
									</a></h2>
									<div class="small-head w-100"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Instant Unlock</div>
								</div>
								
								<div class="para">You must verify your identity before you are able to provide proof of funds.</div>
								<button type="button" class="btn" id="verifyidentityunlockbtn">Verify Your Identity <i class="fa fa-angle-right" aria-hidden="true"></i></button>
							</div>
									
						</form>
						<?php
					}
					?>
								<!--<div class="subheading unlock-subhead" style="padding-top:30px;">Agree to Terms of Use before proceeding 
									to unlock this listing
								</div>-->
								<div class="alert alert-danger alert-dismissible tcagree" role="alert" style="display:none">
									<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<strong>Errors!</strong> 
									<ul>
											<li>Please agree to Terms of Use before proceeding to unlock this listing</li>
									</ul>   
									</div>
								<form class="form_wrap login_form" id="uncoverfrm" method="post" action="<?php echo base_url();?>listing/uncover">

								<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
								<input type="hidden" name="listingNo" value="<?php echo $listingid?>" /> 
								<!--<div class="check_box"> 
									<label class="check-box">
										<input name="terms" class="extraval" type="checkbox" value="" data-id="109">
										<span class="checkmark"></span>
									</label>
									<div class="editor_text">
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec 
											vel diam mollis, sagittis felis vitae, aliquet ex. , 
										</p>
										<ul>
											<li>Aliquam sed mauris dictum, imperdiet velit ut, rutrum sem.</li>
											<li>Maecenas eu nunc in justo ornare finibus nec et lacus.</li>
											<li>Orci varius natoque penatibus et magnis</li>
											<li>Maecenas eu nunc </li>
											<li>Orci varius natoque penatibus et </li>
											<li>Orci varius natoque penatibus et </li>
										</ul>
									</div>
								</div>
								<div class="subheading unlock-subhead gray-color">To Unlock This Listing Prove Your Funds</div>-->
								<div class="subheading unlock-subhead gray-color"></div>
								
								<?php
								if($permission['isavailablefund'] == true && $permission['isidentityproofed'] == true && $permission['isfundproofed'] == true && $permission['totalunloadremaining']>0)
								{
									?>
									<!--<div class="btn_left"><button type="submit" class="btn blue-btn btn-lg finaluncover">Procced to unlock listing</button></div>-->
									<?php
								}
								?>
								
							</div>
							</form>
						</div>
						<div class="col-md-6 step2"> 
							<div class="step-heading">
								<div class="heading heading2">Step 02 <span>Verify Your Fund</span></div>
							</div>  
							<?php
								if($userDetails['proof_fund_status'] == 2){
									?>
									<div class="clock">
										<div class="top"></div>
										<div class="right"></div>
										<div class="bottom"></div>
										<div class="left"></div>
										<div class="center"></div>
										<div class="shadow"></div>
										<div class="hour"></div>
										<div class="minute"></div>
										<div class="second"></div>
									</div> 
									<h1 class="text-center WaitingforFundApproval">Waiting for Fund Approval</h1>
									<div class="text-center WaitingforFundApproval"> Your documents are being review and should be processed shortly. You will be notified once the verification process is complete.</div>
									<?php
								}elseif($userDetails['proof_fund_status'] == 1){
											if($permission['isfundproofed'] == true && $permission['isavailablefund'] == false)
											{
									?>
									<div class="alert alert-danger alert-dismissable">
									The listing price is more than your proof of funds level. Please reverify your proof of funds to be able to uncover higher priced listings.
									</div>
									<?php
											}
											?>
									<div class="text-center WaitingforFundApproval">
									<i class="fa fa-check" aria-hidden="true" style="font-size:80px;"></i><h1>Verified</h1>
									Your proof of fund is verified.
									<br><a class="btn mt-3" href="<?php echo base_url();?>user/reverifyfund?redirect_to=listing/uncover/<?php echo $listingid?>">Reverify Fund</a>
									</div>
									<?php
								}else
								{ 
												?>
												<!--<form id="proofoffundform" action="<?php echo base_url();?>user/proofoffundaction?redirect_to=listing/uncover/<?php echo $listingid?>" method="post">-->
												<form id="proofoffundform" action="<?php echo base_url();?>user/proofoffundactiononline" method="post">
												<input type="hidden" name="verificationTypeFund" id="online" checked value="online">
												<input type="hidden" id="accesstokens" name="accesstokens" value="">
												<input type="hidden" id="accessrequests" name="accessrequests" value="">
												<input type="hidden" name="listingNo" value="<?php echo $listingid?>" /> 
												<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
												<div class="box">
													<div class="head-top d-flex align-items-center flex-wrap">
														<div class="icon-left"><img src="<?php echo base_url();?>assets/frontend/images/sample/bank-bal.png" alt=""></div>
														<h2 class="subheading unlock-subhead">Verify Bank Balance <a href="#" class="info-icon"><i class="fa fa-info-circle" aria-hidden="true"></i>
														</a></h2>
														<div class="small-head w-100"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Instant Unlock</div>
													</div>
													
													<div class="para">Use your online banking login so that we are able to verify your balance and we will instantly unlock this listing and issue a VIP Code. We do not store any of your credentials or information.</div>
													<h3 class="h3addedbanks" style="display:none">Your added banks:</h3>
													<ul class="addedbank">
													</ul>
													<button type="button" class="btn" id="verifybankbtn" <?php echo ($userDetails['identity_proof_status'] != 1)? 'disabled="true"':'';?>>Connect Bank</button>
													<button type="button" class="btn pull-right" id="proofoffundsubmitbtn" disabled="true">Submit</button>
													<!--<div class="btn popupBtn pull-right">Submit</div>-->
												</div>
												</form>
												<div class="varify-bank-popup">
													<div class="varify-bank-popup-wrap">
														<div class="varify-bank-popup-box">
															<div class="loader-icon"></div>
															<div class="heading">Verifying by Bank, Please wait...</div>
														</div>
													</div>
												</div>
												<div class="text-center"><div class="or">OR</div></div>
												<div class="box">
													<div class="head-top d-flex align-items-center flex-wrap">
														<div class="icon-left"><img src="<?php echo base_url();?>assets/frontend/images/sample/bank-bal.png" alt=""></div>
														<h2 class="subheading unlock-subhead">Upload Financial Documents
															<a href="#" class="info-icon"><i class="fa fa-info-circle" aria-hidden="true"></i>
														</a></h2>
														<div class="small-head w-100"><i class="fa fa-hourglass-start" aria-hidden="true"></i> 24 Hours</div>
													</div>
													<div class="para">Use your online banking login so that we are able to verify your balance and we will instantly unlock this listing and issue a VIP Code. We do not store any of your credentials or information.</div>
													<button href="#lock-content" class="fancybox btn d-block" data-fancybox <?php echo ($userDetails['identity_proof_status'] != 1)? 'disabled="true"':'';?>>Upload Documents</button> 
													
													<div id="lock-content" style="display:none;">
													<form id="proofoffundformoffline" action="<?php echo base_url();?>user/proofoffundaction?redirect_to=listing/uncover/<?php echo $listingid?>" method="post">
													<input type="hidden" name="verificationTypeFund" id="offline" checked value="offline">
													<input type="hidden" id="" name="accesstokens" value="">
													<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
													<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																	<p>Upload your proof of funds, and once our team has verified your financials, we will issue you a VIP Code to easily unlock listings.</p>
																	<h3 class="subheading">You can upload:</h3>
																	<ul class="row ul">
																		<li class="col-md-4 col-sm-6 lock-content-check"><input type="checkbox" name="proof[]" id="" value="Bank Statement" <?php echo (in_array('Bank Statement',$dataval['proof']))?'checked':'';?>> <span>Bank Statement</span></li>
																		<li class="col-md-4 col-sm-6 lock-content-check"><input type="checkbox" name="proof[]" id="" value="Stock Portfolio" <?php echo (in_array('Stock Portfolio',$dataval['proof']))?'checked':'';?>> <span>Stock Portfolio</span></li>
																		<li class="col-md-4 col-sm-6 lock-content-check"><input type="checkbox" name="proof[]" id="" value="CPA Letter" <?php echo (in_array('CPA Letter',$dataval['proof']))?'checked':'';?>> <span>CPA Letter</span></li>
																		<li class="col-md-4 col-sm-6 lock-content-check"><input type="checkbox" name="proof[]" id="" value="Home Equity Line of Credit" <?php echo (in_array('Home Equity Line of Credit',$dataval['proof']))?'checked':'';?>> <span>Home Equity Line of Credit</span></li>
																		<li class="col-md-4 col-sm-6 lock-content-check"><input type="checkbox" name="proof[]" id="" value="Corporation Documents" <?php echo (in_array('Corporation Documents',$dataval['proof']))?'checked':'';?>> <span>Corporation Documents</span></li>
																		<li class="col-md-4 col-sm-6 lock-content-check"><input type="checkbox" name="proof[]" id="" value="Other Available Credit Status" <?php echo (in_array('Other Available Credit Status',$dataval['proof']))?'checked':'';?>> <span>Other Available Credit Status</span></li>
																	</ul>
																	</form>
																	<ul class="row ul mt30">
																		<li class="col-md-12">
																			<div class="box">
																				<div class="subhead">Files</div>
																				<form id="profilefundproof" action="<?php echo base_url() ?>user/submit-user-fundproof" class="dropzone">
																					<input class="csrftoken" type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
																				</form>
																			</div>
																		</li>
																	</ul> 
																	<input type="button" id="proofoffundsubmitbtnoffline" class="btn" value="Submit">
																	
													</div>
												</div>
										<?php
									}
									?>



						</div>
					</div>
					<?php
					if($permission['isavailablefund'] == true && $permission['isidentityproofed'] == true && $permission['isfundproofed'] == true && $permission['totalunloadremaining']>0)
					{
						?>
					<div class="btn_center"><button type="button" class="btn blue-btn btn-lg finaluncover animation">Procced to unlock listing</button></div>
					<?php
					}
					?>
				</div>
				<div class="section-secure">
					<div class="row">
						<div class="col-md-4">
							<div class="box">
								<figure><img src="<?php echo base_url();?>assets/frontend/images/sample/s1.png" alt=""></figure>
								<h2 class="subheading">
									SSL Encryption
									<strong>Secure</strong>
								</h2>
							</div>
						</div>
						<div class="col-md-4">
							<div class="box">
								<figure><img src="<?php echo base_url();?>assets/frontend/images/sample/s2.png" alt=""></figure>
								<h2 class="subheading">
									AES-256 BIT
									<strong>Encryption</strong>
								</h2>
							</div>
						</div>
						<div class="col-md-4">
							<div class="box">
								<figure><img src="<?php echo base_url();?>assets/frontend/images/sample/s3.png" alt=""></figure>
								<h2 class="subheading">
									FIH
									<strong>CERTIFIED</strong>
								</h2>
							</div>
						</div>
					</div>
				</div>
				<div class="unlock-last-sec">
					<div class="row">
						<div class="col-md-6">
							<div class="box">
								<div class="subheading">
								Uncovering the listing will grant you the following: 
								</div>
								<div class="editor_text">
									<ul>
										<li>Instant access to the site URL(s)</li>
										<li>Detailed proof of earnings and traffic</li>
										<li>Access to seller for questions and follow-ups</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="box contact-box">
								<div class="subheading">
									Discuss Your Options with Our Sales Team 
								</div>
								<br><br>
								<a href="<?php echo base_url();?>scheduledcalls" class="btn">Book A Call</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section> 
	</main>