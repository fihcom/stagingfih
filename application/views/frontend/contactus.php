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
			$success = $this->session->flashdata('success');
			if($success)
			{
				?>
				<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <strong>Success!</strong> 
				<?php echo $success; ?>
				</div>
				<?php 
			}
			?>
                     <form id="contact" class="form_wrap reg_form" method="post" action="<?php echo base_url();?>contactusfrm">
                     <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
						<h2 class="heading text-center">Contact Us</h2>
						 <ul class="row ul">
							 <li class="col-sm-12">
								 <div class="labelWrap">
									 <label for="">Name</label>
									 <input type="text" name="fname" value="<?php echo $fieldData['fname'];?>">
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
									<label for="">Message</label>
									<textarea class="row3" name="message" id="message" placeholder="Type here..."><?php echo $fieldData['message'];?></textarea>
								</div>
                            </li> 
							<li class="col-sm-12">
									<label class="labelWrap">
										<div class="captcha_img">
											<div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE_KEY?>"></div>
											<span id="captcha_error" class="error" style="display: none"></span>
										</div>
										<div class="btn_wr">
											<button type="submit" class="btn btn-sm" id="submitcontact">Submit Now</button>
										</div>
                        			</label>	
							</li>
							
						 </ul>
					 </form>
				 </div>
			</div>
		</section> 
	</main> 