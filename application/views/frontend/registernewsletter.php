<main class="mainContainer"> 
		<section class="section login-sec">
			<div class="container">
				 <div class="login_form-sec">
				 <?php
					//$error = $error;
					//$errorCode = $data['errorCode'];
					//echo $errorCode;
					if($errorCode == 1) {
						?>
						<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<strong>Errors!</strong> 
						<ul>
							<li><?php echo $error;?></li>
						</ul>   
						</div>
						<?php 
                    } 
                    //$success = $this->session->flashdata('success');
					if($errorCode == 0) {
						?>
						<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<strong>Success!</strong> 
						<ul>
								<li><?php echo $error;?></li>
						</ul>   
						</div>
						<?php 
					} 
					if($errorCode != 0)
					{
					?>
					 <form class="form_wrap login_form" id="newsletterfrm" method="post" action="<?php echo base_url();?>newsletter">
					 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
						<h2 class="heading text-center">Subscribe to newsletter</h2>
						 <ul class="row ul">
							 <li class="col-sm-12">
								 <div class="labelWrap">
									 <label for="">Email</label>
									 <input type="text" name="newsletteremail" placeholder="Enter your email..." value="<?php echo $dataval['newsletteremail'];?>">
								 </div>
							 </li>
							 <li class="col-sm-12">
                                 <div class="labelWrap text-center">
                                     <input type="submit" value="Submit" id="resetpassbtn" class="btn sgnUp mt-2 d-block"></input>
                                 </div>
                             </li>
						 </ul>
					 </form>
					 <?php
					 }
					 ?>
				 </div>
			</div>
		</section> 
	</main> 