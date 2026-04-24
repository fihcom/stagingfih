<main class="mainContainer">  
	<!-- html start -->
	<!-- online_business-consult start -->
	<section class="section online_business-consult">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6">
					<div class="t-image text-right">
						<figure><img src="<?php echo base_url();?>uploads/otherimages/<?php echo $lendinglist['content']['image'];?>" alt="consultation"></figure>
					</div>
				</div> 
				<div class="col-md-6">
					<!-- <div class="t-content">
						<h2 class="heading">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Molestiae, modi!</h2>
						<div class="para">
							<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel veritatis dolore fugiat veniam nesciunt, ad debitis molestiae, atque labore accusantium corrupti itaque doloremque iure expedita rerum architecto ipsa aspernatur deleniti!</p>
						</div>
					</div> -->
					<?php echo $lendinglist['content']['content_one'];?>
				</div> 
			</div>
		</div>
	</section>
	<!-- online_business-consult end -->

	<!-- pre_approved_funding start -->
	<section class="section pre_approved_funding">
		<div class="container">
			<!-- <h2 class="heading text-center">Lorem ipsum dolor, sit amet consectetur <span>voluptatem consectetur</span> assumenda laborum.</h2>
			<div class="fund_list">
				<div class="row">
					<div class="col-sm-6">
						<div class="fund_wrapper">
							<figure class="icon">
								<img src="assets/frontend/images/sample/sass.png" alt="sass">
							</figure>
							<div class="fund_text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae aliquid pariatur, optio illum suscipit voluptatem dolorum</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="fund_wrapper">
							<figure class="icon">
								<img src="assets/frontend/images/sample/doller_icon.png" alt="doller_icon">
							</figure>
							<div class="fund_text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae aliquid pariatur, optio illum suscipit voluptatem dolorum</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="fund_wrapper">
							<figure class="icon">
								<img src="assets/frontend/images/sample/tree_icon.png" alt="tree_icon">
							</figure>
							<div class="fund_text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae aliquid pariatur, optio illum suscipit voluptatem dolorum</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="fund_wrapper">
							<figure class="icon">
								<img src="assets/frontend/images/sample/bank_icon.png" alt="bank_icon">
							</figure>
							<div class="fund_text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae aliquid pariatur, optio illum suscipit voluptatem dolorum</div>
						</div>
					</div>
				</div> 
					<div class="btn-c">
					<a href="javascript:void(0);" class="buy_sell">Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro expedita tenetur accusantium numquam repudiandae cum? Voluptatibus incidunt nostrum ex fuga.</a>
					</div>
			</div> -->
			<?php echo $lendinglist['content']['content_two'];?>
				<div class="btn_center">
				<a href="#request-financing" class="fancybox btn btn-lg" data-fancybox>Get Funded</a>
				<div id="request-financing" style="display:none;" class="popup-all">
							<form id="reqfinancingfrm" action="" method="post">
								<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
								<h1>Learn More About Our Funding Options</h1>
								<div class="alert alert-success alert-dismissible successmessagefinancingh" style="display:none;" role="alert">
									<strong>Success!</strong> 
									<ul>
											<li id="successmessagefinancing"></li>
									</ul>   
								</div>
								<div class="alert alert-danger alert-dismissible errormessagefinancingh" style="display:none;" role="alert">
									<strong>Error!</strong> 
									<ul id="errormessagefinancing">
									</ul>   
								</div>
								<div style="padding-bottom:25px;">Have a business acquisition that you want to get financing for? Use this form to start the process to get listed on this page and in front of our lending partners.</div>
								<ul class="ul row">
								
									<li class="col-sm-6"><label for="">Are you a buyer, seller, or broker?</label>
										<select name="business_owner" id="business_owner">
											<option value="Acquirer">Acquirer</option>
											<option value="Business Owner">Business Owner</option>
											<option value="Broker">Broker</option>
										</select>
									</li>
									<li class="col-sm-6">
										<label for="">How much funding are you looking for?</label>
										<input type="text" name="funding_amount" id="" placeholder="Amount" value="">
									</li>
									<li class="col-sm-6"><label for="">How quickly do you need funding?</label>
										<select name="timing" id="timing">
											<option value="48 Hours"> 48 Hours</option>
											<option value="14 days">14 days</option>
											<option value="3 months">3 months</option>
											<option value="No Date Set">No Date Set</option>
										</select>
									</li>
									<li class="col-sm-6">
										<label for="">What is the URL of the business in question?</label>
										<input type="text" name="BusinessUrl" id="" placeholder="Business URL. Start with http:// or https://" value="">
									</li>
									<li class="col-sm-6">
										<label for="">Phone Number</label>
										<input type="text" name="phone" id="phone" placeholder="+X (XXX) XXX-XXXX" value="">
									</li>
									<li class="col-sm-6">
										<label for="">Email</label>
										<input type="text" name="email" id="email" placeholder="name@domain.com" value="">
									</li>
									<li class="col-sm-12">
										<button type="submit" class="btn" id="reqfinancingbtn">Submit</button>
									</li>
								</ul>
								</form>
								</div>
				</div>
		</div>
	</section>
	<!-- pre_approved_funding end -->

	<!-- loan_listing start -->
	
	<section class="section loan_listing">
		<div class="container">
			<?php
			if(is_array($lendinglist['data']) && count($lendinglist['data'])>0)
			{
			?>
			<h3 class="subheading"><?php echo count($lendinglist['data']);?> listing found</h3>
			<div class="table-responsive">
				<table>
					<thead>
						<tr>
							<th class="industry">Industry</th>
							<th class="loan_type">Loan Type</th>
							<th class="loan_term">Loan Term</th>
							<th class="a_cont">Acquirer Contribution</th>
							<th class="n_pro">Net Profit</th>
							<th class="revenue">Revenue</th>
							<th class="revenue">Business Age</th>
							<th class=""></th>
						</tr>
					</thead>
					<tbody>
						<?php
						
							foreach($lendinglist['data'] as $k=>$v)
							{
								?>
								<tr>
									<td class="industryname"><?php echo $v['industryname']?></td>
									<td class="loan_type"><?php echo $v['loan_type']?></td>
									<td class="loan_term"><?php echo $v['loan_term']?></td>
									<td class="acquirer_contribution"><?php echo $v['acquirer_contribution']?></td>
									<td class="net_profit">$<?php echo $v['net_profit']?></td>
									<td class="revenue">$<?php echo $v['revenue']?></td>
									<td class="business_age"><?php echo $v['business_age']?></td>
									<td class="business_listing_url"><a href="<?php echo $v['business_listing_url']?>" target="_blank" class="btn blue-btn">View Opportunity</a></td>
								</tr>
								
						
							<tr>
							<td colspan="100%">
								<ul class="col_wrap"> 
									<li>
										<div class="btn_group d-flex align-items-center">
											<div class="btn btn-ylw"><?php echo $v['interest_yield']?> Net Interest for Lender</div>
											<div class="btn blue-btn dark-blue ml-3"><?php echo $v['ebitda']?> IRR for Acquirer</div>
											
										</div>
									</li>
									<li class="ml-auto">
										<div class="btn_group d-flex align-items-center">
										<a href="#request-acquisition" class="fancybox btn mr-3 btnB" data-fancybox>Fund Acquisition</a>
											<span class="f_amount">Funding Amount: <span class="amount red-color">$<?php echo $v['funding_amount']?></span></span>
											</div>
									</li>
								</ul>
							</td>
							</tr>
							<?php
							}
						
						?>
					</tbody>
				</table>
			</div>
			<div id="request-acquisition" style="display:none;" class="popup-all">
							<form id="reqacquisitionfrm" action="" method="post">
								<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
								<h1>Fund this Business Acquisition</h1>
								<div class="alert alert-success alert-dismissible successmessageacquisitionh" style="display:none;" role="alert">
									<strong>Success!</strong> 
									<ul>
											<li id="successmessageacquisition"></li>
									</ul>   
								</div>
								<div class="alert alert-danger alert-dismissible errormessageacquisitionh" style="display:none;" role="alert">
									<strong>Error!</strong> 
									<ul id="errormessageacquisition">
									</ul>   
								</div>
								<div style="padding-bottom:25px">Interested in lending money to this active acquisition deal? Submit this form and we will start the process ASAP to finalize your investment.</div>
								
								<ul class="ul row">
								
									<li class="col-sm-12"><label for="">Are you an accredited investor? Do you make more than 200k a year (for the past 3 years) OR have a net worth of $1M+ (not including your main residence)</label>
										<div class="d-flex">
											<label for="" class="custom-radio-box"><input type="radio" name="investor" id="investory" value="Yes" checked> Yes</label>
											<label for="" class="custom-radio-box"><input type="radio" name="investor" id="investorn" value="No"> No</label>
										</div>
									</li>
									
									<li class="col-sm-6">
										<label for="">Full Name</label>
										<input type="text" name="name" id="name" placeholder="John Doe" value="">
									</li>
									<li class="col-sm-6">
										<label for="">Street Address</label>
										<input type="text" name="street" id="street" placeholder="100 Example St., City, State 10000" value="">
									</li>
									<li class="col-sm-6">
										<label for="">Phone Number</label>
										<input type="text" name="phone" id="phone" placeholder="+X (XXX) XXX-XXXX" value="">
									</li>
									<li class="col-sm-6">
										<label for="">Email</label>
										<input type="text" name="email" id="email" placeholder="name@domain.com" value="">
									</li>
									<li class="col-sm-12">
										<button type="submit" class="btn" id="acquisitionbtn">Submit</button>
									</li>
								</ul>
								</form>
								</div>
			<?php
			}else{
				?>
				<h3 class="subheading">All offerings are fully funded. Check back later for new opportunities.</h3>
				<?php
			}
			?>
		</div>
	</section>
	
	<!-- loan_listing end -->

	<!-- deversified_found start -->
	<section class="section deversified_found">
		<div class="container">
			<div class="deversified_wrap">
				<div class="row align-items-center">
					<div class="col-sm-8">
						<!-- <div class="ctn">
							<h2 class="heading">Interested in amore diversified investing opportunity</h2>
							<h3 class="subheading">Does a 10% return sound interesting?</h3>
							<ul>
								<li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam</li>
								<li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam in officiis repellendus quos qui reiciendis.</li>
							</ul>
						</div> -->
						<?php echo $lendinglist['content']['content_three'];?>
					</div>
					<div class="col-sm-4">
						<div class="acess_btn text-center">
						<a href="#request-access" class="fancybox btn btn-lg" data-fancybox>Request Access</a>
						<div id="request-access" style="display:none;" class="popup-all">
							<form id="reqaccessfrm" action="" method="post">
								<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
								<h1>Fund Application</h1>
								<div class="alert alert-success alert-dismissible successmessagereqaccess" style="display:none;" role="alert">
									<strong>Success!</strong> 
									<ul>
											<li id="successmessagereqaccess"></li>
									</ul>   
								</div>
								<div class="alert alert-danger alert-dismissible errormessagereqaccess" style="display:none;" role="alert">
									<strong>Error!</strong> 
									<ul id="errormessagereqaccess">
									</ul>   
								</div>
								<div style="padding-bottom:25px;">Tell us a little about yourself and we can tell you more about our fund.</div>
								<ul class="ul row">
								
									<li class="col-sm-12"><label for="">Are you an accredited investor? AKA do you make more than 200k USD a year or have more than 1M in assets (not including your primary home)</label>
										<div class="d-flex">
											<label for="" class="custom-radio-box"><input type="radio" name="investor" value="Y" id="" checked> Yes</label>
											<label for="" class="custom-radio-box"><input type="radio" name="investor" value="N" id=""> No</label>
										</div>
									</li>
									<li class="col-sm-6">
										<label for="">How much money do you have available to invest in this fund?</label>
										<input type="text" name="available_money" id="available_money" placeholder="$500k, $5M, etc." value="">
									</li>
									<li class="col-sm-6">
										<label for="">How long of a hold period are you comfortable with?</label>
										<input type="text" name="hold_period" id="hold_period" placeholder="6 months, 3 years, 10 years, etc." value="">
									</li>
									<li class="col-sm-6">
										<label for="">What is your Full Name?</label>
										<input type="text" name="name" id="name" placeholder="John Doe" value="">
									</li>
									<li class="col-sm-6">
										<label for="">What is your email address?</label>
										<input type="text" name="email" id="email" placeholder="name@domain.com" value="">
									</li>
									<li class="col-sm-12">
										<label for="">What is your phone number?</label>
										<input type="text" name="phone" id="phone" placeholder="+X (XXX) XXX-XXXX" value="">
									</li>
									<li class="col-sm-12">
										<button type="submit" class="btn" id="reqaccessbtn">Submit</button>
									</li>
								</ul>
								</form>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- deversified_found end -->
	<?php
	if(is_array($partners) && count($partners)>0)
	{
		?>
		<section class="section logo_slider">
		<div class="container">
			<div class="brand_slider owl-carousel owl-theme">
				<?php
				foreach($partners as $val)
				{
					?>
					<div class="item">
						<?php
							if($val['partner_url'] !='')
							{
								?>
								<a href="<?php echo $val['partner_url']?>">
								<?php
							}
						?>

						<figure><img src="<?php echo base_url();?>uploads/partner-image/<?php echo $val['partner_image'];?>" alt=""></figure>
						<?php
							if($val['partner_url'] !='')
							{
								?>
								</a>
								<?php
							}
						?>
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


	<!-- logo_slider start -->
	<!-- <section class="section logo_slider">
		<div class="container">
			<div class="brand_slider owl-carousel owl-theme">
				<div class="item">
					<figure>
						<img src="<?php echo base_url();?>assets/frontend/images/sample/persona.png" alt="persona">
					</figure>
				</div>
				<div class="item">
					<figure>
						<img src="<?php echo base_url();?>assets/frontend/images/sample/google_analystic.png" alt="google_analystic">
					</figure>
				</div>
				<div class="item">
					<figure>
						<img src="<?php echo base_url();?>assets/frontend/images/sample/alexa.png" alt="alexa">
					</figure>
				</div>
				<div class="item">
					<figure>
						<img src="<?php echo base_url();?>assets/frontend/images/sample/fih_amazon.png" alt="fih_amazon">
					</figure>
				</div>
				<div class="item">
					<figure>
						<img src="<?php echo base_url();?>assets/frontend/images/sample/flippa.png" alt="flippa">
					</figure>
				</div>
				<div class="item">
					<figure>
						<img src="<?php echo base_url();?>assets/frontend/images/sample/plaid.png" alt="plaid">
					</figure>
				</div>
				<div class="item">
					<figure>
						<img src="<?php echo base_url();?>assets/frontend/images/sample/persona.png" alt="persona">
					</figure>
				</div>
				<div class="item">
					<figure>
						<img src="<?php echo base_url();?>assets/frontend/images/sample/google_analystic.png" alt="google_analystic">
					</figure>
				</div>
				<div class="item">
					<figure>
						<img src="<?php echo base_url();?>assets/frontend/images/sample/alexa.png" alt="alexa">
					</figure>
				</div>
				<div class="item">
					<figure>
						<img src="<?php echo base_url();?>assets/frontend/images/sample/fih_amazon.png" alt="fih_amazon">
					</figure>
				</div>
				<div class="item">
					<figure>
						<img src="<?php echo base_url();?>assets/frontend/images/sample/flippa.png" alt="flippa">
					</figure>
				</div>
				<div class="item">
					<figure>
						<img src="<?php echo base_url();?>assets/frontend/images/sample/plaid.png" alt="plaid">
					</figure>
				</div>
			</div>
		</div>
	</section> -->
	<!-- logo_slider end -->
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
	