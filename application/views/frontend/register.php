<main class="mainContainer">  
		<section class="section login-sec register-sec">
			<div class="container">
				 <div class="register_form"> 
                 <?php
			$error = $this->session->flashdata('error');
			if($error) {
				?>
				<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <strong>Errors!</strong> 
				<ul>
				<?php
				if(is_array($this->session->flashdata('error')) && count($this->session->flashdata('error'))>0)
				{
					foreach($this->session->flashdata('error') as $val)
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
			?>
                     <form id="regform" class="form_wrap reg_form" method="post" action="<?php echo base_url();?>registeruser">
                     <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
					 <input type="hidden" id="captcha-response" name="captcha-response" />
						<h2 class="heading text-center">Create Your Account</h2>
						 <ul class="row ul">
							 <li class="col-sm-6">
								 <div class="labelWrap">
									 <label for="">First Name</label>
									 <input type="text" name="fname" value="<?php echo $fieldData['fname'];?>">
								 </div>
                             </li>
							 <li class="col-sm-6">
								 <div class="labelWrap">
									 <label for="">Last Name</label>
									 <input type="text" name="lname" value="<?php echo $fieldData['lname'];?>">
								 </div>
                             </li>
							 <li class="col-sm-12">
								<div class="labelWrap">
									<label for="">Email</label>
									<input type="text" name="mail" value="<?php echo $fieldData['mail'];?>">
								</div>
                            </li>
                            <li class="col-sm-12">
								<div class="labelWrap">
									<label for="">Phone</label>
									<input type="text" name="phone" value="<?php echo $fieldData['phone'];?>">
								</div>
                            </li>
							 <li class="col-sm-12">
								<div class="labelWrap">
									<label for="">Password</label>
									<input type="password" name="password" id="password" placeholder="Min 8 character">
								</div>
                            </li> 
                            <li class="col-sm-12">
								<div class="labelWrap">
									<label for="">Confirm Password</label>
									<input type="password" name="conpassword"  placeholder="Min 8 character">
								</div>
                            </li> 
							<li class="col-sm-12">
								<div class="labelWrap">
									<label for="">You are</label>
									<div>
									<input type="radio" name="userProfile" value="Business Owner" id="" style="width: 25px;vertical-align: middle;" checked> <span style="width: vertical-align: middle;">Business Owner</span>
									<input type="radio" name="userProfile" value="Investor" id="" style="width: 25px;vertical-align: middle;" > <span style="width: vertical-align: middle;">Investor</span>
									<input type="radio" name="userProfile" value="Both" id="" style="width: 25px;vertical-align: middle;" > <span style="width: vertical-align: middle;">Both</span>

									</div>
									
								</div>
                            </li> 
                            <li class="col-sm-12 term-cond">
								<div class="labelWrap">
									<input type="checkbox" name="terms">
									<div class="term-text">
										By registering for an account on FIH.com, I understand and agree to their <a href="<?php echo base_url();?>/terms-conditions" target="_blank" rel="noopener noreferrer" class="Link__StyledLink-ljrJwl hysMmG undefined link">Terms of Use</a> which contains important details about buying & selling online businesses.
									</div>
								</div>
                            </li> 
							<li class="col-sm-12">
								<div class="labelWrap text-center">
                                    <!--<a class="btn sgnUp mt-2 d-block" href="#">register Now</a> -->
                                    <input type="submit" value="Register Now" id="signupnow" class="btn sgnUp mt-2 d-block"></input>
								</div>
							</li>
							<li class="col-sm-12" style="display:none">
								<div class="labelWrap text-center"> 
									<div class="others-signup">
										<div class="login-with"><span>or Signup with</span></div>
										<div class="google-fb-signup">
											<a href="<?php echo $google_login_url;?>" class="fgBtn gl"><span><img src="<?php echo base_url();?>assets/frontend/images/google-icon.png" alt=""></span> SIGN UP WIth google</a>
											<a href="<?php echo $facebook_login_url;?>" class="fgBtn fb"><span><img src="<?php echo base_url();?>assets/frontend/images/fb-icon.png" alt=""></span> SIGN UP WIth Facebook</a>
										</div>
										<span class="creataccnt">Have an account? <a href="<?php echo base_url();?>login" class="underline">Login Now</a></span>
									</div>
								</div>
							</li>
						 </ul>
					 </form>
				 </div>
			</div>
		</section> 
	</main> 
	<script src="https://www.google.com/recaptcha/api.js?render=<?php echo CAPTCHAKEY ; ?>"></script>
	<script>
	grecaptcha.ready(function() {
		//console.log('ready')
		// do request for recaptcha token
		// response is promise with passed token
			grecaptcha.execute('<?php echo CAPTCHAKEY ; ?>', {action:'validate_captcha'})
					.then(function(token) {
				// add token value to form
				document.getElementById('captcha-response').value = token;
			});
		});
	</script>
	<style>
		.grecaptcha-badge {
  width: 70px !important;
  overflow: hidden !important;
  transition: all 0.3s ease !important;
  left: 4px !important;
}
.grecaptcha-badge:hover {
  width: 256px !important;
}
		</style>