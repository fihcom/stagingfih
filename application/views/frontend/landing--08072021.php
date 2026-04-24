<!DOCTYPE html>
<html lang="en">
<head>
	<title>Flat Iron Holdings LLC</title> 
	<link rel="icon" href="<?php echo base_url();?>assets/frontend/images/favicon.ico" type="image/png" sizes="16x16">
	<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;1,300;1,400&family=Jost:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600;1,700&display=swap" rel="stylesheet"> 
 	  
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/frontend/css/plugins.css">   
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/frontend/css/style.css"> 
  
</head>
<body class="landing-page">
	<div class="bodyOverlay"></div>
	<div class="responsive_nav"></div>
	<a class="scrollup" href="javascript:void(0);" aria-label="Scroll to top"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>

	<header class="mainHeader landing-page-header">
		<section class="header_main">
			<div class="htop">
				<div class="container">
					<div class="htop-left d-flex align-items-center flex-wrap">
						<ul class="ul hinfo w-100 d-flex align-items-center">
							<li>
								<span><i class="fa fa-headphones" aria-hidden="true"></i></span>
								<!--<a href="tel:">Schedule Call</a>-->
								<a href="tel:+1 (646) 797-3158">+1 (646) 797-3158</a>
							</li>
							<li class="ml-auto">
								<span><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
								<a href="mailto:team@fih.com">team@fih.com</a>
							</li> 
						</ul> 
                        
					</div>
				</div>
			</div>
			<div class="hbottom">
				<div class="container">
					<div class="d-flex align-items-center flex-wrap justify-content-between">
						<div class="logo">
							<a href="https://www.fih.com/" style="background-image:url(https://www.fih.com/uploads/logo_image/a1ae3aab4960e760e88e7b1882577c33.png);"></a>
						</div>  
					</div>
				</div>
			</div>
           
		</section> 
		<section class="common_banner">
			<div class="landing-page-banner"> 
				<div class="bannerbox"> 
					<figure class="bannerimg">
						<img src="<?php echo base_url();?>assets/frontend/images/landing-banner.jpg" alt="banner">
					</figure> 
					<div class="landing-bannertext"> 
						<div class="container">
							<div class="landing-bannertext-in">  
								<!--<h2 class="subheading">our business marketplace is about to launch!</h2>-->
								<div class="days-count d-flex justify-content-center">
									<div class="count-box" id="day">
										
										<span>days</span>
									</div>
									<div class="count-box" id="hour">
										
										<span>hours</span>
									</div>
									<div class="count-box" id="minute">
										
										<span>min</span>
									</div>
									<div class="count-box" id="second">
										
										<span>sec</span>
									</div>
								</div>
								<h2 class="subheading mb-4">Are you an online business owner or a creative investor?</h2>
								<div class="banner-mail">
									<h2 class="subheading">Request Beta Access to our Business Marketplace</h2>
                                    
									<div class="">
										<!--<input type="text" placeholder="Your Email Id">
										<button class="btn">subscribe</button>-->
                                        <!-- Begin Mailchimp Signup Form -->

                                        <div id="mc_embed_signup">
                                        <form action="https://fih.us1.list-manage.com/subscribe/post?u=a55c3226adb337b2996a11887&amp;id=ce3ff1e535" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                                            <div id="mc_embed_signup_scroll">
                                            
                                        <div class="mc-field-group banner-mail-form">
                                            <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Email Address">
                                            <input type="submit" value="Submit" name="subscribe" id="mc-embedded-subscribe" class="btn">
                                        </div>
                                            <div id="mce-responses" class="thankYouMsg">
                                                <div class="response" id="mce-error-response"></div>
                                                <div class="response" id="mce-success-response"></div>
                                            </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                                            <div style="position: absolute; left: -5000px;" aria-hidden="true">
                                                <input type="text" name="b_a55c3226adb337b2996a11887_ce3ff1e535" tabindex="-1" value="">
                                            </div>
                                                
                                            </div>
                                        </form>
                                        </div>
                                        <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
                                        <!--End mc_embed_signup-->
									</div>
								</div>
							</div> 
						</div> 
					</div>    
				</div>     
			</div>   
		</section>
	</header>
	<footer class="mainFooter">   
		<section class="copyright">
			<div class="container">
				<div class="d-flex align-items-center justify-content-center"> 
					<p>Copyright © 2021 Flat Iron Holdings LLC. All Rights Reserved</p>   
				</div>  
			</div>
		</section>
	</footer>  
    <script>
        <?php
        $launchdate = strtotime('2121-07-28 00:00:00');
        $nowtime = time();
        ?>
        /*var upgradeTime = <?php echo $launchdate - $nowtime?>;
        var seconds = upgradeTime;
        function timer() {
        var days        = Math.floor(seconds/24/60/60);
        var hoursLeft   = Math.floor((seconds) - (days*86400));
        var hours       = Math.floor(hoursLeft/3600);
        var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
        var minutes     = Math.floor(minutesLeft/60);
        var remainingSeconds = seconds % 60;
        function pad(n) {
            return (n < 10 ? "0" + n : n);
        }
        //document.getElementById('countdown').innerHTML = pad(days) + ":" + pad(hours) + ":" + pad(minutes) + ":" + pad(remainingSeconds);
        document.getElementById('day').innerHTML = pad(days)+'<span>days</span>'
        document.getElementById('hour').innerHTML = pad(hours)+'<span>hours</span>'
        document.getElementById('minute').innerHTML = pad(minutes)+'<span>min</span>'
        document.getElementById('second').innerHTML = pad(remainingSeconds)+'<span>sec</span>'
        if (seconds == 0) {
            clearInterval(countdownTimer);
            document.getElementById('countdown').innerHTML = "Completed";
        } else {
            seconds--;
        }
        }
        var countdownTimer = setInterval('timer()', 1000);*/
        var countDownDate = new Date("Jul 28, 2021 00:00:00").getTime();
        function pad(n) {
            return (n < 10 ? "0" + n : n);
        }
        function sowcountdown(){
            var now = new Date().getTime();
            var timeleft = countDownDate - now;
                
            var days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
            var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);
            document.getElementById('day').innerHTML = pad(days)+'<span>days</span>'
            document.getElementById('hour').innerHTML = pad(hours)+'<span>hours</span>'
            document.getElementById('minute').innerHTML = pad(minutes)+'<span>min</span>'
            document.getElementById('second').innerHTML = pad(seconds)+'<span>sec</span>'
            if (timeleft < 0) {
                clearInterval(myfunc);
                document.getElementById('day').innerHTML = '00<span>days</span>'
                document.getElementById('hour').innerHTML = '00<span>hours</span>'
                document.getElementById('minute').innerHTML = '00<span>min</span>'
                document.getElementById('second').innerHTML = '00<span>sec</span>'
            }
        }
        var myfunc = setInterval(function() {
            // code goes here
            sowcountdown();
        }, 1000)
        </script>
</body>
</html> 