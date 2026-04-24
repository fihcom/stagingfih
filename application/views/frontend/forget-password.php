<main class="mainContainer"> 
		<section class="section login-sec">
			<div class="container">
				 <div class="login_form-sec">
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
                    $success = $this->session->flashdata('success');
					if($success) {
						?>
						<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<strong>Success!</strong> 
						<ul>
								<li><?php echo $success;?></li>
						</ul>   
						</div>
						<?php 
					} 
					?>
					 <form class="form_wrap login_form" id="forgetpasswordForm" method="post" action="<?php echo base_url();?>forgetpasswordaction">
					 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
						<h2 class="heading text-center">Forget Password</h2>
						 <ul class="row ul">
							 <li class="col-sm-12">
								 <div class="labelWrap">
									 <label for="">Email Address</label>
									 <input type="text" name="email" placeholder="Email address" value="<?php echo $fieldData['email'];?>">
								 </div>
							 </li>
                             <li class="col-sm-12">
                                 <div class="labelWrap text-center">
                                 You will receive an email containing a link allowing you to reset your password to a new preferred one.
                                 </div>
                             </li>
							 <li class="col-sm-12">
                                 <div class="labelWrap text-center">
                                     <input type="submit" value="Submit" id="forgetpassbtn" class="btn sgnUp mt-2 d-block"></input>
                                 </div>
                             </li>
							<li class="col-sm-12">
								<div class="labelWrap text-center"> 
									<div class="others-signup">
										<!-- <div class="login-with"><span>or Login with</span></div>
										<div class="google-fb-signup">
											<a href="<?php //echo $google_login_url;?>" class="fgBtn gl"><span><img src="<?php //echo base_url();?>assets/frontend/images/google-icon.png" alt=""></span> SIGN UP WIth google</a>
											<a href="<?php //echo $facebook_login_url;?>" class="fgBtn fb"><span><img src="<?php //echo base_url();?>assets/frontend/images/fb-icon.png" alt=""></span> SIGN UP WIth Facebook</a>
										</div> -->
										<span class="creataccnt">Are you new user? <a href="<?php echo base_url();?>register" class="underline">Register Now</a></span>
									</div>
								</div>
							</li>
						 </ul>
					 </form>
				 </div>
			</div>
		</section> 
	</main> 