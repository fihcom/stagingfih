<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $site_settings->site_title;?></title>
	<!-- Standard favicon & meta tags -->
	<?php include_once('meta.php'); ?>
	<!-- End standard favicon & meta tags -->
	<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;1,300;1,400&family=Jost:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600;1,700&display=swap" rel="stylesheet">
	<style>
	.common_banner,.container,.header_main,.nav_wrapper{position:relative}body{margin:0;padding:0}*,:after,:before{box-sizing:border-box}.responsive_nav,.scrollup{display:none}.header_main{top:0;left:0;right:0;z-index:5;border-top:5px solid #262525;border-bottom:5px solid #22942a;height:162px}.homebanner{height:450px;min-height:450px;overflow:hidden;background:#ccc}.container{width:1170px;padding:0 15px;margin:0 auto}.logo{width:128px;float:left;padding:10px 0}.hright{float:right;text-align:right;height:152px}.htop{color:#fff;background:#171817;padding:0 0 5px;float:right;height:35px}.hmiddle{padding:20px 0;clear:both;height:76px}.nav_wrapper{float:left;background:#22942a;padding:5px 0 0 30px;height:41px}
	@media only screen and (max-width: 991px) {.homebanner{height: auto;min-height:inherit}}
	</style>
	<?php //echo inline_code('style', 'animate', base_url() . 'assets/frontend/css/animate.min.css'); ?>
	<?php //echo inline_code('style', 'aos', base_url() . 'assets/frontend/css/aos.css'); ?>
	<?php //echo inline_code('style', 'owl.carousel', base_url() . 'assets/frontend/css/owl.carousel.min.css'); ?>
	<?php //echo inline_code('style', 'plugins', base_url() . 'assets/frontend/css/plugins.css'); ?>
	<?php //echo inline_code('style', 'style', base_url() . 'assets/frontend/css/style.min.css'); ?>
	<?php //echo inline_code('style', 'responsive', base_url() . 'assets/frontend/css/responsive.min.css'); ?>
	<?php //echo inline_code('style', 'price-range', base_url() . 'assets/frontend/css/price-range.min.css'); ?>
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/css/animate.min.css'?>">
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/css/aos.css'?>">
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/css/owl.carousel.min.css'?>">
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/css/plugins.css'?>">
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/css/style.min.css'?>">
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/css/responsive.min.css'?>">
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/css/price-range.min.css'?>">
	<?php include_once('third-party-script.php'); ?>
</head>
<body class="">
	<div class="bodyOverlay"></div>
	<div class="responsive_nav"></div>
	<a class="scrollup" href="javascript:void(0);" aria-label="Scroll to top"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
	<header class="mainHeader">
		<section class="header_main">
			<div class="htop">
				<div class="container">
					<div class="htop-left d-flex align-items-center flex-wrap">
						<ul class="ul hinfo d-flex align-items-center">
							<li>
								<span><i class="fa fa-headphones" aria-hidden="true"></i></span>
								<!--<a href="tel:<?php //echo $site_settings->helpline_no?>">Schedule Call</a>-->
								<a href="<?php echo base_url();?>scheduledcalls">Schedule Call</a>
							</li>
							<li>
								<span><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
								<a href="<?php echo base_url();?>ticket/create">Email Support</a>
							</li>
							<!--<li>
								<span><i class="fa fa-map-marker" aria-hidden="true"></i></span>
								<?php //echo $site_settings->address?>
							</li>-->
						</ul>

						<div class="user-right ml-auto">
						<?php
						if($this->session->userdata('isLoggedIn'))
						{
							?>
							<div class="after-login">

							<div class="btn-group ml-4">
									<a href="<?php echo base_url();?>user/buyer" class="btn btn-sm">Buyer Dashboard</a>
									<a href="<?php echo base_url();?>user/sell" class="btn sellingBtn btn-sm ml-2">Seller Dashboard</a>
								</div>
								<a href="<?php echo base_url();?>user/buyer/notification" class="notifiction"><i class="fa fa-bell" aria-hidden="true"></i><span class="notificationspan"><?php echo  $notifications['totalnotifications']; ?></span></a>
								<div class="user">
									<span class="uicon"><img src="<?php echo base_url();?>assets/frontend/images/male.png" alt=""></span>
									<span class="uname"><?php echo $this->session->userdata('name')?> <i class="fa fa-caret-down" aria-hidden="true"></i>
									</span>
									<div class="user-dropdown">
										<ul>
										<li><a href="<?php echo base_url();?>user/buyer">Dashboard</a></li>
											<li><a href="<?php echo base_url();?>user/profile">Profile</a></li>
											<li><a href="<?php echo base_url();?>logout">Logout</a></li>
										</ul>
									</div>
								</div>

							</div>
							<?php
						}else{
							?>
							<div class="user-login">
								<span class="user-icon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>
								<a href="<?php echo base_url();?>login">Login</a>
								<span class="separator">/</span>
								<a href="<?php echo base_url();?>register">Register</a>
							</div>
							<?php
						}
						?>

						</div>


						<!-- <div class="social ml-auto">
							<a href="https://www.facebook.com" target="_blank" rel="noopener noreferrer nofollow" aria-label="Facebook" class="sk_facebook"><i class="fa fa-facebook"></i></a>
							<a href="https://www.instagram.com" target="_blank" rel="noopener noreferrer nofollow" aria-label="Instagram" class="sk_instagram"><i class="fa fa-instagram"></i></a>
						</div> -->
					</div>
				</div>
			</div>
			<div class="hbottom">
				<div class="container">
					<div class="d-flex align-items-center flex-wrap justify-content-between">
						<div class="logo">
							<a href="<?php echo base_url();?>" style="background-image:url(<?php echo base_url();?>uploads/logo_image/<?php echo $site_settings->home_logo?>);"></a>
						</div>
						<div class="nav_wrapper">
							<nav class="nav_menu">
								<ul class="">
									<li><a href="<?php echo base_url();?>aboutus"><span>About</span></a> </li>
									<li><a href="<?php echo base_url();?>marketplace"><span>Marketplace</span></a> </li>
									<li><a href="<?php echo base_url();?>testimonials"><span>Track Record </span></a> </li>
									<!--<li><a href="<?php echo base_url();?>blog"><span>News</span></a> </li>-->
								</ul>
							</nav>
							<span class="responsive_btn"><span></span></span>
							<div class="clear"></div>
						</div>
						<div class="btn-group">
							<a href="<?php echo base_url();?>getfreevaluation" class="btn blue-btn">Get Appraised</a>
							<a href="<?php echo base_url();?>user/sell-your-business" class="btn ml-2">Sell Your Business</a>
						</div>
					</div>
				</div>
			</div>

        </section>
		<section class="common_banner homebanner">
			<div class="homeslider">
				<div class="itemheader">
					<div class="bannerbox">
						<figure class="bannerimg">
							<img src="<?php echo base_url();?>assets/frontend/images/sample/banner.jpg" alt="banner">
						</figure>
						<div class="bannertext">
							<div class="container">
								<div class="banner_right_text">
								<strong>Neil P. Bostick</strong>
									<hr style="margin: 4px 0; !important">
									<span>CEO & 1st Adopter | FIH.com</span>
								</div>
								<div class="bannertext-in">
									<h1 class="heading">
										<!--The Verified  NYC'S CURATED --> THE FIRST PASSIVE
									</h1>
									<h2 class="subheading"><!--Business BrokerBUSINESS MARKETPLACE-->INCOME MARKETPLACE</h2>
									<p>We offer profit opportunities for accredited investors, cash liquidity for verified business owners, & the platform to enable you to become a digital entrepreneur.</p>
								</div>
								<div class="search_section mt20">
									<form method="get" action="<?php echo base_url();?>marketplace">
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
										<div class="row">
											<div class="col-sm-3">
												<input type="text" id="politicianName" name="searchText" value="<?php echo $this->security->xss_clean(trim($_GET['searchText']));?>" placeholder="Search listing">
											</div>
											<div class="col-sm-3">
												<select name="Monitization">
													<option value="">Select Monitization</option>
													<?php
													if(is_array($monetization) && count($monetization)>0)
													{
														foreach($monetization as $Mone)
														{
															?>
															<option value="<?php echo $Mone['slug'];?>"  <?php echo ($Mone['slug'] == $this->security->xss_clean(trim($_GET['Monitization'])))?'selected':''?>><?php echo $Mone['name'];?></option>
															<?php
														}
													}
													?>
												</select>
											</div>
											<div class="col-sm-4">
												<div class="range-sec">
													<div class="caption-sec">
														<div class="caption left-caption">
															<strong>Min:</strong> <span id="slider-range-value1"></span>
														</div>
														<div class="caption right-caption">
															<strong>Max:</strong> <span id="slider-range-value2"></span>
														</div>
													</div>
													<div id="slider-range"></div>
												</div>
												<input type="hidden" id="pricerangemin" value="<?php echo $maxmin['minPrice'];?>">
												<input type="hidden" id="pricerangemax" value="<?php echo $maxmin['maxPrice'];?>">
												<input type="hidden" name="min" id="min-value" value="<?php echo ($this->security->xss_clean(trim($_GET['min']))>0) ? $this->security->xss_clean(trim($_GET['min'])):'100'; ?>">
              									<input type="hidden" name="max" id="max-value" value="<?php echo ($this->security->xss_clean(trim($_GET['min']))>0) ? $this->security->xss_clean(trim($_GET['max'])):'3800000'; ?>">
											</div>
											<div class="col-sm-2">
												<input type="submit" value="Find Listing">
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</header>
