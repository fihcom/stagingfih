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
					 <form class="form_wrap login_form" id="resetpasswordForm" method="post" action="<?php echo base_url();?>resetpasswordaction">
					 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
					 <input type="hidden" name="email" value="<?php echo $email;?>">
					 <input type="hidden" name="random" value="<?php echo $random;?>">
						<h2 class="heading text-center">Reset Password</h2>
						 <ul class="row ul">
							 <li class="col-sm-12">
								 <div class="labelWrap">
									 <label for="">New Password</label>
									 <input type="password" name="password" id="mainpass" placeholder="Password">
								 </div>
							 </li>
							 <li class="col-sm-12">
								 <div class="labelWrap">
									 <label for="">Confirm Password</label>
									 <input type="password" name="conpassword" placeholder="Confirm Password">
								 </div>
							 </li>
                             
							 <li class="col-sm-12">
                                 <div class="labelWrap text-center">
                                     <input type="submit" value="Submit" id="resetpassbtn" class="btn sgnUp mt-2 d-block"></input>
                                 </div>
                             </li>
						 </ul>
					 </form>
				 </div>
			</div>
		</section> 
	</main> 