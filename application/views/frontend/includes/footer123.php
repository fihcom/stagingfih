<footer class="mainFooter">  
		<div class="ftop">
			<div class="container">
				<div class="row">
					<div class="col-md-4 fblock" data-aos="fade-right" data-aos-duration="2200">
						<div class="fbox">
							<div class="flogo mb20"><img src="<?php echo base_url();?>uploads/logo_image/<?php echo $site_settings->home_logo?>" alt=""></div>
							<div class="fpara"><?php echo $site_settings->description;?></div>
							<div class="fcontact">
							<ul class="ul">
									<li><span><i class="fa fa-envelope" aria-hidden="true"></i></span><a href="mailto:<?php echo $site_settings->helpline_email_address?>"><?php echo $site_settings->helpline_email_address?></a></li>
									<?php
									if($site_settings->address!='')
									{
										?>
										<li><span><i class="fa fa-map-marker" aria-hidden="true"></i></span><?php echo $site_settings->address?></li>
										<?php
									}
									?>
									
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-3 fblock" data-aos="fade-left" data-aos-duration="2200">
						<div class="fbox">
							<h2 class="subheading">Site Links</h2>
							<nav class="fnav">
								<ul class="in">
									<li><a href="<?php echo base_url();?>links/aboutus"><span>About Us</span></a></li>
									<li><a href="<?php echo base_url();?>marketplace"><span>Online Business Marketplace</span></a></li>
									<li><a href="<?php echo base_url();?>getfreevaluation"><span>Instant Appraisals</span></a></li>
									<!--<li><a href="#"><span>News</span></a></li>-->
									<li><a href="<?php echo base_url();?>user/sell-your-business"><span>Sell Your Business</span></a></li>
									<li><a href="<?php echo base_url();?>login"><span>Login/Register</span></a></li>
								</ul>
							</nav>
						</div>
					</div>
					<div class="col-md-5 fblock" data-aos="fade-left" data-aos-duration="2200">
						<div class="fbox">
							<h2 class="subheading">Newsletter</h2>
							<p>Get updates right to your inbox.</p> 
							<form action="https://fih.us1.list-manage.com/subscribe/post?u=a55c3226adb337b2996a11887&amp;id=ce3ff1e535" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
								<div class="labelWrap">
									<input type="email" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Enter your email..." required>
									<button type="submit" id="mc-embedded-subscribe" class="btn emailsubscribebtn">Subscribe</button>
								</div>
								<input type="hidden" name="referrer" >
							</form>
							<!-- Begin Mailchimp Signup Form -->
							<!--<link href="//cdn-images.mailchimp.com/embedcode/horizontal-slim-10_7.css" rel="stylesheet" type="text/css">
							<style type="text/css">
								#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; width:100%;}
								/* Add your own Mailchimp form style overrides in your site stylesheet or in this style block.
								We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
							</style>
							<div id="mc_embed_signup">
							<form action="https://fih.us1.list-manage.com/subscribe/post?u=a55c3226adb337b2996a11887&amp;id=ce3ff1e535" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
								<div id="mc_embed_signup_scroll">
								
								<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
								<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_a55c3226adb337b2996a11887_ce3ff1e535" tabindex="-1" value=""></div>
								<div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
								</div>
							</form>-->
							</div>

							<!--End mc_embed_signup-->
							<div class="social mt20">
								<a href="<?php echo $site_settings->facebook_link?>" target="_blank" rel="noopener noreferrer nofollow" aria-label="Facebook" class="sk_facebook"><i class="fa fa-facebook"></i></a> 
								<a href="<?php echo $site_settings->twitter_link?>" target="_blank" rel="noopener noreferrer nofollow" aria-label="Twitter" class="sk_twitter"><i class="fa fa-twitter"></i></a>
								<a href="<?php echo $site_settings->instagram_link?>" target="_blank" rel="noopener noreferrer nofollow" aria-label="Linkedin" class="sk_linkedin"><i class="fa fa-linkedin"></i></a>
								<a href="<?php echo $site_settings->youtube_link?>" target="_blank" rel="noopener noreferrer nofollow" aria-label="Youtube" class="sk_youtube"><i class="fa fa-youtube"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<section class="copyright">
			<div class="container">
				<div class="d-flex align-items-center justify-content-between"> 
					<p>© <?php echo date('Y');?> <a href="https://www.fih.com">FIH.com</a>. All Rights Reserved.</p>   
					<nav class="">
						<ul class="">
							<li><a href="<?php echo base_url();?>links/terms-conditions"><span>Terms &amp; Conditions</span></a> </li>
							<li><a href="<?php echo base_url();?>links/privacypolicy"><span>Privacy Policy</span></a> </li>
						</ul> 
					</nav>  
					 
					
				</div>  
			</div>
		</section>
	</footer>
	<input type="hidden" id="sitepath" value="<?php echo base_url();?>">
    

	<script defer="" type="text/javascript">
		function lightbox(){
		if(window.jQuery){
			lc_lightbox('.sk_gal', {
				wrap_class: 'lcl_fade_oc',
				gallery : true,
				thumb_attr: 'data-lcl-thumb',
				skin: 'dark',
				radius: 0,
				padding	: 0,
				border_w: 0,
				shadow: true,
				autoplay: false,
				counter: true,
				ol_opacity: 0.8,
				ol_color: '#000',
				cmd_position: 'outer',
				data_position: 'under', 
				ins_close_pos: 'corner', 
				nav_btn_pos: 'middle', 
				txt_hidden: 767,
				thumbs_w: 90,
				thumbs_h: 90,
				modal: false,
				rclick_prevent: false,
			});} else {setTimeout(function(){ lightbox();}, 50);}}lightbox();</script>
    <!-- 1.plugins 5.custom js -->
    <script type="text/javascript" src="<?php echo base_url();?>assets/frontend/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/frontend/js/bootstrap.min.js"></script>
    
	<script type="text/javascript" src="<?php echo base_url();?>assets/frontend/js/plugins.js"></script>     
    <script type="text/javascript" src="<?php echo base_url();?>assets/frontend/js/custom.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url();?>assets/frontend/js/jquery.validate.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/frontend/js/front.js"></script> 

	<?php
		if($this->uri->segment(2) == 'uncover' && $this->uri->segment(1) == 'listing'){
			?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/frontend/js/dropzone.min.js"></script>

	<script src="https://cdn.withpersona.com/dist/persona-v3.4.0.js"></script>
	<script src="https://cdn.plaid.com/link/v2/stable/link-initialize.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/frontend/js/user-profile.js"></script>	
	<!-- Custom scripts for this page-->
	

	<?php
		}
		elseif($this->uri->segment(1) == 'listing'){
	?>
		<script type="text/javascript" src="<?php echo base_url();?>assets/frontend/js/dropzone.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/frontend/js/listing-details.js"></script>
	<?php
		if($_GET['processunlock'] == 1)
		{
			?>
			<script>
			$(function () {
			$('#seefulldetails').trigger('click');
			});
			</script>
			<?php
		}if($this->session->flashdata('faq') == true)
		{
			?>
			<script>
			$(function () {
			$('#faq').trigger('click');
			});
			</script>
			<?php
		}
		if($this->session->flashdata('submitoffer') == true)
		{
			?>
			<script>
			$(function () {
			$('#submitoffer').trigger('click');
			});
			</script>
			<?php
		}
		if($this->session->flashdata('submitbuy') == true)
		{
			?>
			<script>
			$(function () {
			$('#buynow').trigger('click');
			});
			</script>
			<?php
		}
	}
	elseif($this->uri->segment(1) == 'marketplace'){
	?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/frontend/js/marketplace.js"></script>
	
	<?php
	}elseif($this->uri->segment(1) == 'ticket' || ($this->uri->segment(1) == 'scheduledcalls')){
		?>
		<script type="text/javascript" src="<?php echo base_url();?>assets/backend/vendor/datatables/jquery.dataTables.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/backend/vendor/datatables/dataTables.bootstrap4.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/frontend/js/user-datatable.js"></script>
	
	<?php
	}
	if($this->session->userdata('user_id') > 0)
		{
			?>
			<script type="text/javascript" src="<?php echo base_url();?>assets/frontend/js/notification.js"></script>
			<?php
		}
		if($this->uri->segment(1) == 'marketplace' || $this->uri->segment(1) == ''){
	?>
	<script type="text/javascript" src="<?php echo base_url();?>assets/frontend/js/price-range.js"></script>
	<?php
		}
  if($this->session->flashdata('slidetab')==8)
  {
	/*echo '<script>
	notificationfunc();
	</script>';*/
  }
  ?>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html> 