<main class="mainContainer">  
		<section class="section my-account">
			<div class="container"> 
				<h2 class="heading text-center font-weight-bold">My Account</h2>  
											<!-- loader for online bank verification -->	
												<div class="varify-bank-popup">
													<div class="varify-bank-popup-wrap">
														<div class="varify-bank-popup-box">
															<div class="loader-icon"></div>
															<div class="heading">Verifying by Bank, Please wait...</div>
														</div>
													</div>
												</div>				
												<!-- loader for online bank verification -->	
				<div class="d-block w-100">
					<div class="my-account-wrap mt30">
						<div class="js-tabs my-account-tab" data-aos="fade-left" data-aos-duration="2400">
							<nav>
								<ul class='tabs text-center'>
									<li data-tab-id='tab1' <?php echo ($this->session->flashdata('successprofileupdate') || $firstslide=='Y')? 'class="active"':''?>>Account Settings</li>
									<li data-tab-id='tab2' <?php echo ($this->session->flashdata('slidetab')==2)? 'class="active"':''?>>Verification</li> 
									<li data-tab-id='tab3' <?php echo ($this->session->flashdata('slidetab')==3)? 'class="active"':''?>>Security</li>
									

									
									<li data-tab-id='tab5'>Referral Code</li> 
									<li data-tab-id='tab4'>Investor Passes</li>
									<li data-tab-id='tab8' id="notificationtab" <?php echo ($this->session->flashdata('slidetab')==8)? 'class="active"':''?>>Notifications</li>
									<!--<li data-tab-id='tab5' <?php echo ($this->session->flashdata('slidetab')==5)? 'class="active"':''?>>Support Tickets</li> -->
								</ul>
							</nav>
							<div class='panels'>
								<div id='tab1' class='content  <?php echo ($this->session->flashdata('successprofileupdate') || $firstslide=='Y')? 'active':''?>'> 
									<div class="account-sec">
									<?php
									$success = $this->session->flashdata('successprofilepicture');
									if($success) { 
										?>
									<div class="alert alert-success alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<?php echo $this->session->flashdata('successprofilepicture'); ?>
									</div>
										<?php 
									} 
									$error = $this->session->flashdata('errorprofilepicture');
									if($error) { 
										?>
									<div class="alert alert-danger alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<?php echo $this->session->flashdata('errorprofilepicture'); ?>
									</div>
										<?php 
									} 

									?>
									<form id="userProfileuploadphoto" action="<?php echo base_url();?>user/profilephotoupdate" method="post" enctype="multipart/form-data">
										<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrftoken" />
										<div class="row">
											<div class="col-lg-3 col-md-4 upload-profile-pic-left">
												<label for="drag-photo" class="upload-profile-pic">
													<span class="drag-head">You can click here to select image you want to upload.</span>
													
													<img id="profileimg" src="<?php echo base_url();?>uploads/profile_pictures/<?php echo $userDetails['user_profile_pic'];?>?r=<?php echo rand(200,5622)?>" <?php echo ($userDetails['user_profile_pic'] !='')?'':' style="display:none"'?> >
													<input type="file" id="drag-photo" name="profilePic" class="drag-photo" onchange="readURL(this);">
												</label>
											</div>
											<div class="col-lg-9 col-md-8 upload-profile-pic-right">
												<h2 class="heading">Your Profile Picture</h2>
												<p>Uploading a profile picture has potential sales benefits.</p>
												
												<div class="subheading">Upload a Photo</div>
												<p>You can upload a JPG, GIF or PNG file (File size limit is 2 MB).</p>
												<button type="submit" class="btn">Upload Photo +</button>
												
											</div>
										</div> 
										</form>
										<form id="userProfile" action="<?php echo base_url();?>user/profileupdate" method="post">
										<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
										<div class="basic-info mt50">
											<h2 class="heading">Basic Info</h2>
											<?php
												$success = $this->session->flashdata('successprofileupdate');
												if($success) 
												{ 
													?>
												<div class="alert alert-success alert-dismissable">
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
												<?php echo $this->session->flashdata('successprofileupdate'); ?>
												</div>
													<?php 
												} 
												$error = $this->session->flashdata('failedprofileupdate');
																if($error) {
																	?>
																	<div class="alert alert-danger alert-dismissible" role="alert">
																	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
																	<strong>Errors!</strong> 
																	<ul>
																	<?php
																	if(is_array($this->session->flashdata('failedprofileupdate')) && count($this->session->flashdata('failedprofileupdate'))>0)
																	{
																		foreach($this->session->flashdata('failedprofileupdate') as $val)
																		{
																			?>
																			<li><?php echo $val;?></li>
																			<?php
																		}
																	}
																	?>
																	</ul>
																	</div>
																	<?php
																	$fieldData = $this->session->flashdata('dataval');
																	
																}

									?>
												<ul class="row ul">
													<li class="col-md-4">
														<div class="box">
															<div class="subhead">First Name</div>
															<input type="text" name="fname" placeholder="First Name" value="<?php echo $fieldData['fname']?>">
														</div>
													</li>
													<li class="col-md-4">
														<div class="box">
															<div class="subhead">Last Name</div>
															<input type="text" name="lname" placeholder="Last Name" value="<?php echo $fieldData['lname']?>">
														</div>
													</li>
													
													<li class="col-md-4">
														<div class="box">
															<div class="subhead">Primary Phone Number</div>
															<input type="text" name="phone" placeholder="Primary Phone Number" value="<?php echo $fieldData['phone']?>">
														</div>
													</li>
													<!--<li class="col-md-4">
														<div class="box">
															<div class="subhead">Secondary Phone Number</div>
															<input type="text" name="secondary_phone" placeholder="Secondary Phone Number" value="<?php echo $fieldData['secondary_phone']?>">
														</div>
													</li>
													<li class="col-md-4">
														<div class="box">
															<div class="subhead">Google Analytics Email</div>
															<input type="text" name="google_analitics_email" placeholder="Google Analytics Email" value="<?php echo $fieldData['google_analitics_email']?>">
														</div>
													</li>-->
													<li class="col-md-4">
														<div class="box add-mail">
															<div class="subhead">Email Addresses</div>
															<input type="text" name="mail" placeholder="Email Address" value="<?php echo $fieldData['mail']?>" disabled>
															<!--<a href="#" class="btn add-url-btn"><i class="fa fa-plus" aria-hidden="true"></i>
															</a>-->
														</div>
													</li>
													<li class="col-md-4">
														<div class="box add-mail">
															<div class="subhead">User Type</div>
															<select name="profile_type" id="" class="form-control">
															<option value="Business Owner" <?php echo ($fieldData['profile_type'] == 'Business Owner')? 'selected':'';?>>Business Owner</option>
															<option value="Investor" <?php echo ($fieldData['profile_type'] == 'Investor')? 'selected':'';?>>Investor</option>
															<option value="Both" <?php echo ($fieldData['profile_type'] == 'Both')? 'selected':'';?>>Both</option>
															</select>
															
														</div>
													</li>
												</ul> 
											
										</div>
										<div class="btn_center">
											<button type="submit" class="btn" id="basicinfobtn">Save Changes</button>
										</div> 
										</form>
										
									</div>
								</div>
								<div id='tab2' class='content <?php echo ($this->session->flashdata('slidetab')==2)? 'active':''?>'>  
								<?php
										$success = $this->session->flashdata('successuserverify');
									if($success) { 
										?>
									<div class="alert alert-success alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<?php echo $this->session->flashdata('successuserverify'); ?>
									</div>
										<?php 
									} 
									 
									$error = $this->session->flashdata('faileduserverify');
											if($error) {
												?>
												<div class="alert alert-danger alert-dismissible" role="alert">
												<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
												<strong>Errors!</strong> 
												<ul>
												<?php
												if(is_array($this->session->flashdata('faileduserverify')) && count($this->session->flashdata('faileduserverify'))>0)
												{
													foreach($this->session->flashdata('faileduserverify') as $val)
													{
														?>
														<li><?php echo $val;?></li>
														<?php
													}
												}
												?>
												</ul>
												</div>
												<?php
												$fieldData = $this->session->flashdata('dataval');
												
											}

											?>
										
											<div class="basic-info mt50">
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
													
											<form id="verifyIdentitystep1" action="<?php echo base_url();?>user/verifyIdentityaction" method="post">
											<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
												<h2 class="heading"><span class="user-profile-radio-box"><input type="radio" <?php echo ($fieldData['verificationType'] == 'online' || $fieldData['verificationType'] == '')?'checked':'';?> name="verificationType" id="online" value="online"></span>Instant Identity Verification</h2>
												
													
													<ul class="">
														<li>Good lighting is required to ensure your verification is approved.</li>
														<li>Make sure any images you upload are crisp and not blurry.</li>
														<li>Do not cover up any part of the identification with your fingers.</li>
													</ul>
													To enhance trust and protect all parties involved in a deal, we need to verifiy your identity. Please take a moment to upload your identification so that we can verify you are who you say you are.
													<div class="subheading mt30">You can upload</div>
													<ul class="mb20"> 
														<li>Passport</li>
														<li>Drivers License</li>
														<li>Government Issued ID Card</li>
													</ul>
													<?php
											if(!$userDetails['identity_proof_status']>0)
											{
											?>
											<div class="btn_center">
												<button type="button" class="btn" id="verifyidentitybtn1">Verify Identity Instantly</button>
												
											</div> 
											<?php
											}
											?>




													<!--<ul class="row ul">
														<li class="col-md-4">
															<div class="box">
																<div class="subhead">Name</div>
																<input class="form-control" name="username" placeholder="Name" value="<?php echo $fieldData['fname']?>">
															</div>
														</li>
														<li class="col-md-4">
															<div class="box">
																<div class="subhead">Date of Birth</div>
																<input class="form-control" name="dob" id="dob" type="date" value="<?php echo $fieldData['dob']?>">
															</div>
														</li>
														
													</ul> 
													-->
												<input type="hidden" name="personainquiryId" id="personainquiryId" value="">
												
												<hr>
												<h2 class="heading"><span class="user-profile-radio-box"><input type="radio" name="verificationType" id="offline" <?php echo ($fieldData['verificationType'] == 'offline')?'checked':'';?> value="offline"></span>24 Hour Identity Verification</h2>
												<ul class="row ul">
														<li class="col-md-4">
															<div class="box">
																<div class="subhead">Name</div>
																<input class="form-control" name="usernameoffline" placeholder="Name" value="<?php echo $fieldData['usernameoffline']?>">
															</div>
														</li>
														<li class="col-md-4">
															<div class="box">
																<div class="subhead">Date of Birth</div>
																<?php
																	$businessstartdate = $fieldData['doboffline'];
																	if($businessstartdate !='')
																	{
																		$businessstartdateArr = explode('-',$businessstartdate);
																		$startdateformat = $businessstartdateArr[1].'/'.$businessstartdateArr[2].'/'.$businessstartdateArr[0];
																	}else{
																		$startdateformat = '';
																	}
																	?>
																<input class="form-control" name="doboffline" id="startdate" type="text" value="<?php echo $startdateformat?>">
															</div>
														</li>
														<li class="col-md-4">
															<div class="box">
																<div class="subhead">Identity Proof</div>
																<select name="IdentrityProof" class="form-control" id="">
																<option value="Passport" <?php echo ($fieldData['IdentrityProof'] == 'Passport')?'selected':'';?>>Passport</option>
																<option value="Drivers License" <?php echo ($fieldData['IdentrityProof'] == 'Drivers License')?'selected':'';?>>Drivers License</option>
																<option value="Government Issued ID Card" <?php echo ($fieldData['IdentrityProof'] == 'Government Issued ID Card')?'selected':'';?>>Government Issued ID Card</option>
																</select>
															</div>
														</li>
														
														<li class="col-md-4">
															<div class="box">
																<div class="subhead">Identity Proof Number</div>
																<input class="form-control" name="IdentrityProofNumber" placeholder="Identity Proof Number" value="<?php echo $fieldData['IdentrityProofNumber']?>">
															</div>
														</li>
														<li class="col-md-4">
															<div class="box">
																<div class="subhead">Identity Proof Exp Date</div>
																<input class="form-control" name="IdentrityProofexpdate" placeholder="Identity Proof Expiry Date" value="<?php echo $fieldData['IdentrityProofexpdate']?>">
															</div>
														</li>
													</ul> 
												</form>
												<ul class="row ul mt30">
													<li class="col-md-12">
														<div class="box">
															<div class="subhead">Files</div>
															<form id="profilefundproof" action="<?php echo base_url() ?>user/submit-user-identityproof" class="dropzone">
																<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
															</form>
														</div>
													</li>
												</ul> 
												<?php
												}
												?>
											</div>
											<?php
											if(!$userDetails['identity_proof_status']>0)
											{
											?>
											<div class="btn_center">
												<button type="button" class="btn" id="verifyidentitybtn">Verify Identity</button>
												
											</div> 
											<?php
											}
											?>
										
										
										<div class="basic-info mt50">
										<?php
										$success = $this->session->flashdata('successproofupload');
												if($success) { 
													?>
												<div class="alert alert-success alert-dismissable">
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
												<?php echo $this->session->flashdata('successproofupload'); ?>
												</div>
													<?php 
												} 
												$error = $this->session->flashdata('failedproofupload');
												if($error) { 
													?>
												<div class="alert alert-danger alert-dismissable">
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
												<?php echo $this->session->flashdata('failedproofupload'); ?>
												<?php
												$dataval = $this->session->flashdata('dataval')
												?>
												</div>
													<?php 
												}
												?>
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
													?>
													<div class="text-center WaitingforFundApproval">
													<i class="fa fa-check" aria-hidden="true" style="font-size:80px;"></i><h1>Verified</h1>
													Your proof of fund is verified.
													<a class="btn" href="<?php echo base_url();?>user/reverifyfund">Reverify Fund</a>
													</div>
													<?php
												}else{ 
												?>
												<form action="<?php echo base_url();?>user/verifyfundprofile" id="uncoverfrm" method="post">
												<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
												</form>
										<form id="proofoffundform" action="<?php echo base_url();?>user/proofoffundaction" method="post">				
												<h2 class="heading"><span class="user-profile-radio-box"><input type="radio" name="verificationTypeFund" id="online" checked value="online"></span>Instant Proof of Funds</h2>
												<ul class="">
														<li>Please provide proof of funds by logging into your bank via the Plaid.com API.</li>
														<li>After you provide proof of funds, you can sign into a different bank account to increase your proof of funds threshold.</li>
													</ul>
													<h3 class="h3addedbanks" style="display:none">Your added banks:</h3>
												<ul class="addedbank">
												</ul>
													<button type="button" class="btn mb20 mt10" id="verifybankbtn">Verify Bank Online</button>
													<input type="hidden" id="accesstokens" name="accesstokens" value="">
												<hr>
											<h2 class="heading"><span class="user-profile-radio-box"><input type="radio" name="verificationTypeFund" id="offline" <?php echo ($fieldData['verificationTypeFund'] == 'offline')?'checked':'';?> value="offline"></span>24 Hour Proof of Funds</h2>
											<?php
												 
												

												
												?>
												
										<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
												<p>Upload 1 or more files which verifies your cash funds available and once our team has verified your financials, we will issue you Investor Passes for you to uncover up to 10 listings.</p>
												<h3 class="subheading">You can upload:</h3>
												<ul class="row ul">
													<li class="col-md-3 col-sm-6"><input type="checkbox" name="proof[]" id="" value="Bank Statement" <?php echo (in_array('Bank Statement',$dataval['proof']))?'checked':'';?>> Bank Statement</li>
													<li class="col-md-3 col-sm-6"><input type="checkbox" name="proof[]" id="" value="Stock Portfolio" <?php echo (in_array('Stock Portfolio',$dataval['proof']))?'checked':'';?>> Stock Portfolio</li>
													<li class="col-md-3 col-sm-6"><input type="checkbox" name="proof[]" id="" value="CPA Letter" <?php echo (in_array('CPA Letter',$dataval['proof']))?'checked':'';?>> CPA Letter</li>
													<li class="col-md-3 col-sm-6"><input type="checkbox" name="proof[]" id="" value="Home Equity Line of Credit" <?php echo (in_array('Home Equity Line of Credit',$dataval['proof']))?'checked':'';?>> Home Equity Line of Credit</li>
													<li class="col-md-3 col-sm-6"><input type="checkbox" name="proof[]" id="" value="Corporation Documents" <?php echo (in_array('Corporation Documents',$dataval['proof']))?'checked':'';?>> Corporation Documents</li>
													<li class="col-md-3 col-sm-6"><input type="checkbox" name="proof[]" id="" value="Other Available Credit Status" <?php echo (in_array('Other Available Credit Status',$dataval['proof']))?'checked':'';?>> Other Available Credit Status</li>
												</ul>
										</form>

												<ul class="row ul mt30">
													<li class="col-md-12">
														<div class="box">
															<div class="subhead">Files</div>
															<form id="profilefundproof" action="<?php echo base_url() ?>user/submit-user-fundproof" class="dropzone">
																<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
															</form>
														</div>
													</li>
												</ul> 
												<?php
												}
												?>
											
										</div>
										<?php
										if($userDetails['proof_fund_status'] != 2 && $userDetails['proof_fund_status'] != 1) {
											?>
										<!--<input type="hidden" name="personainquiryId" id="personainquiryId" value="">-->
										<div class="btn_center">
											<button type="button" id="proofoffundsubmitbtnprofile" class="btn">Submit</button>
											
										</div> 
										<?php
										}
										?>
								</div> 
								<div id='tab3'class="content  <?php echo ($this->session->flashdata('slidetab')==3)? 'active':''?>">  
									<div class="account-sec">
										<form id="userProfileupdatePassword" action="<?php echo base_url();?>user/profileupdatepassword" method="post">
										<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
										<div class="basic-info mt50">
											<h2 class="heading">Update Password</h2>
											<?php
												 $success = $this->session->flashdata('successchangepassword');
												if($success) { 
													?>
												<div class="alert alert-success alert-dismissable">
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
												<?php echo $this->session->flashdata('successchangepassword'); ?>
												</div>
													<?php 
												} 
												$error = $this->session->flashdata('failedchangepassword');
												if($error) { 
													?>
												<div class="alert alert-danger alert-dismissable">
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
												<?php echo $this->session->flashdata('failedchangepassword'); ?>
												</div>
													<?php 
												} 
												?>
												<ul class="row ul">
													<li class="col-md-4">
														<div class="box">
															<div class="subhead">Enter Current Password</div>
															<input class="form-control" name="old_pass" type="password">
														</div>
													</li>
													<li class="col-md-4">
														<div class="box">
															<div class="subhead">Change Password</div>
															<input class="form-control" name="new_pass" id="new_pass" type="password">
														</div>
													</li>
													<li class="col-md-4">
														<div class="box">
															<div class="subhead">Confirm Password</div>
															<input class="form-control" name="confirm_pass" type="password">
														</div>
													</li>
												</ul> 
											
										</div>
										<div class="btn_center">
											<button type="submit" class="btn">Save Changes</button>
										</div> 
										</form>
										
									</div>
								</div> 
								<div id='tab4' class='content' style="min-height:500px">  
									<?php
									//print '<pre>';
									//print_r($permission);
									if($permission['isfundproofed'] == true && $permission['isavailablefund'] == true  && $permission['totalunloadremaining']>0)
									{
									?>

									<ul class="ul d-flex flex-wrap justify-content-center top-row-investor-passes">
										<li>Code:<strong><?php echo $permission['listing']['Investor_pass']?></strong></li>
										<li>Limit:<strong><?php echo $permission['sitesettings']['no_unload_per_vip']?></strong></li>
										<li>Max Listing Price:<strong>$<?php echo number_format($permission['maxlistingprice'],0,",",",");?></strong></li>
										<li>Usage Left:<strong><?php echo $permission['totalunloadremaining']?></strong></li>
									</ul>
									<?php
									}else{
									?>

									<div class="investor-pass-para">You currently don't have a Investor Pass. Please contact <a href="mailto: <?php echo $permission['sitesettings']['helpline_email_address']?>"><?php echo $permission['sitesettings']['helpline_email_address']?></a> for more information.</div>
									<?php
									}
									?>
								</div> 
								<div id='tab8' class='content <?php echo ($this->session->flashdata('slidetab')==8)? 'active':''?>'>
											<ul id="notificationul">
											<?php

											if(is_array($notifications['data']['notification']) && count($notifications['data']['notification'])>0)
											{
												foreach($notifications['data']['notification'] as $k=>$val)
												{
													
													?>
													<li id="notification<?php echo $val['id'];?>"><i class="fa fa-bell" aria-hidden="true"></i>
													<div class="notification-box">
														<?php echo $val['notification_text'];?> <br> <div class="date"> As on <?php echo $val['monthFormated']?>
														<a href="javascript: void(0);" class="delete" onclick="javascript: deletenotification(this)" datadeletehref="<?php echo base_url();?>user/removenotification/<?php echo $val['id']?>"><i class="fa fa-trash" aria-hidden="true"></i></a></div>
													</div>
													</li> 
													<?php
												}
											}else{
												?>
												<li>No new Notifications found.</li> 
												<?php
											}
											?>
											</ul>
												<div id="notificationskeleton" style="display: none">
												<li id="notificationNOTIFICATIONID"><i class="fa fa-bell" aria-hidden="true"></i>
													<div class="notification-box">
														[NOTIFICATIONTEXT] <br> As on [NOTIFICATIONDATE]
														<a href="javascript: void(0);" class="delete" onclick="javascript: deletenotification(this)" datadeletehref="<?php echo base_url();?>user/removenotification/NOTIFICATIONID"><i class="fa fa-trash" aria-hidden="true"></i></a>
													</div>
													</li>
												</div>
												<?php
												if($notifications['data']['totalrecord']['totalrecord'] > $sellerOffersLimit)
												{
													?>
														<a href="javascript: void(0);" class="readmore showallnotifications">Show More</a>
														<input type="hidden" id="loadmorestart" value="<?php echo $sellerOffersStart+$sellerOffersLimit;?>">
														<input type="hidden" id="loadmorelimit" value="<?php echo $sellerOffersLimit;?>">
													<?php
												}
												?>
									</div>
								<div id='tab5' class='content' style="min-height:400px;">  
								<div class="account-sec">
										<div class="basic-info mt50">
											<h2 class="heading">Refer a business owner & earn up to $50,000</h2>
												<div class="subheading">Referral Code: <span style="color: #ff8464;"><?php echo $userDetails['promo_code']; ?></span></div>
												
												<p>Refer a owner to list their business for sale on our site with this code and you both will win! When they input this code at the end of the application process, they will save hundreds of dollars (by getting to list their business for free!) and you will get to benefit from taking 10% of our fees when their business sells (up to $50,000). When they input this code, their business is automatically attributed to your account and we will add your referral commission to your wallet balance within 48 hours after their business sale closes successfully.</p>
											
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
	<div class="modal fade" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to approve this identity?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-footer">
        <form action="" method="post" id="delform">
        <input type="hidden" class="votecsrf csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
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