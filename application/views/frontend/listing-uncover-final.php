<?php
//$permission['isavailablefund'] = false;
//$permission['isidentityproofed'] = false;
//$permission['isfundproofed'] = false;
if($permission['totalunloadremaining']>0 && $permission['isidentityproofed'] == true && $permission['isfundproofed'] == true && $permission['isavailablefund'] == true) {
    $proceed = 'Y';
} elseif($permission['totalunloadremaining']<1 && $permission['isidentityproofed'] == true && $permission['isfundproofed'] == true && $permission['isavailablefund'] == true) {
    $BalanceFinished = 'Y';
} elseif($permission['isidentityproofed'] == true && $permission['isfundproofed'] == true && $permission['isavailablefund'] == false) {
    $NOavailablefund = 'Y';
} elseif($permission['isidentityproofed'] == false && $permission['isfundproofed'] == false) {
    $NoDocumentProof = 'Y';
} elseif($permission['isidentityproofed'] == false) {
    $NoIdentityProof = 'Y';
} elseif($permission['isfundproofed'] == false) {
    $NoFundProof = 'Y';
}

?>
<form class="form_wrap login_form" id="uncoverfrm" method="post" action="<?php echo base_url();?>listing/uncover">
	<input type="hidden" id="uncoverCSRF" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
	<input type="hidden" name="listingNo" value="<?php echo $listing_id?>" />
	<input type="hidden" name="hidden_image_sign" value="" />
	<div style="text-align: center; font-size: 50px; color: #354c77">
		<figure>
			<img src="<?php echo base_url();?>assets/frontend/images/sample/seo-data-lockIcon.png" alt="">
		</figure>
	</div>
	<div class="top-head mt10">
		<h2 class="heading mb15 text-center">Use Your Investor Pass</h2>
		<div class="text-center mb10"><strong>Are you sure you want to use your investor pass?</strong></div>
	</div>
<?php
if($proceed == 'Y' || $BalanceFinished == 'Y' || $NOavailablefund == 'Y') {
	?>
	<ul class="ul d-flex flex-wrap justify-content-center middle-row">
		<li>Code:<strong><?php echo $permission['listing']['Investor_pass']?></strong></li>
		<li>Limit:<strong><?php echo $permission['sitesettings']['no_unload_per_vip']?></strong></li>
		<li>Max Listing Price:<strong>$<?php echo number_format($permission['maxlistingprice'],0,",",",");?></strong></li>
		<li>Usage Left:<strong><?php echo $permission['totalunloadremaining']?></strong></li>
	</ul>
	<?php
}
?>
	<ul class="ul row bottom-row mt20">
<?php
if($proceed == 'Y') {
	?>
		<li class="col-md-12 col-sm-12">
			<?php /*<div class="box">
				<p><span class="user-profile-radio-box"><input type="checkbox" name="terms" id=""></span>By pressing this button & uncovering this listing, I am agreeing to a NDA regarding all listing content that is not otherwise public. In this, all data regarding this listing is confidential and should be not shared with anyone without authorization from this site or the listing owner. By uncovering this listing, I agree to keep the following details confidential:</p>
				<ul>
					<li>All listing data that may compromise interest from customers.</li>
					<li>All financial data that shows company health.</li>
					<li>All trade secrets that may give advantage to competitors.</li>
					<li>All privately revealed connections between public data.</li>
					<li>Any other relevant details mentioned in the listing that are not public.</li>
				</ul>
			</div> */ ?>
			<div class="box nda_content_area">
				<p><span><input name="terms" type="checkbox" /></span>&nbsp;I agree to FIH.com&#39;s NON-DISCLOSURE AGREEMENT (outlined below)</p>
				<?php echo stripslashes($onlyNDAContent['pageContent']); ?>
			</div>
		</li>
<?php
}
if($NoDocumentProof == 'Y') {
?>
		<li class="col-md-6 col-sm-12">
			<div class="box">
				<div class="subheading">Verify Your identity</div>
				<div class="para mCustomScrollbar">
					<p>You must verify your identity before proceeding to uncover the listing</p>
				</div>
				<div class="btn_center">
					<a href="<?php echo base_url();?>user/verificationtab" class="btn">Verify Identity<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
				</div>
			</div>
		</li>
		<li class="col-md-6 col-sm-12">
			<div class="box">
				<div class="subheading">Verify Your fund</div>
				<div class="para mCustomScrollbar">
					<p>Use your online banking login or upload proof of fund to verify your balance. Our team will verify your financial and will issue Investor Pass to easily unlock listing. </p>
				</div>
				<div class="btn_center">
					<a href="<?php echo base_url();?>user/verificationtab" class="btn">Verify Fund<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
				</div>
			</div>
		</li>
<?php
}
if($BalanceFinished == 'Y') {
	?>
		<li class="col-md-12 col-sm-12">
			<div class="box">
				<div class="subheading">Your investor pass limit is exceeded.</div>
				<div>
					<p>Use your online banking login or upload proof of fund to verify your balance. Our team will verify your financial and will issue Investor Pass to easily unlock listing. </p>
				</div>
				<div class="btn_center">
					<a href="<?php echo base_url();?>user/verificationtab" class="btn">Verify Fund<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
				</div>
			</div>
		</li>
	<?php
}
if($NOavailablefund == 'Y') {
	?>
		<li class="col-md-12 col-sm-12">
			<div class="box">
				<div class="subheading">The list price more than you permisible limit of approved fund.</div>
				<div class="">
					<p>Use your online banking login or upload proof of fund to verify your balance. Our team will verify your financial and will issue Investor Pass to easily unlock listing. </p>
				</div>
				<div class="btn_center">
					<a href="<?php echo base_url();?>user/verificationtab" class="btn">Verify Fund<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
				</div>
			</div>
		</li>
	<?php
}
if($NoIdentityProof == 'Y') {
	?>
		<li class="col-md-12 col-sm-12">
			<div class="box">
				<div class="subheading">Verify Your identity</div>
				<div class="">
					<p>You must verify your identity before proceeding to uncover the listing</p>
				</div>
				<div class="btn_center">
					<a href="<?php echo base_url();?>user/verificationtab" class="btn">Verify Identity<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
				</div>
			</div>
		</li>
	<?php
}

if($NoFundProof == 'Y') {
    ?>
		<li class="col-md-12 col-sm-12">
			<div class="box">
				<div class="subheading">Verify Your fund</div>
				<div class="">
					<p>Use your online banking login or upload proof of fund to verify your balance. Our team will verify your financial and will issue Investor Pass to easily unlock listing. </p>
				</div>
				<div class="btn_center">
					<a href="<?php echo base_url();?>user/verificationtab" class="btn">Verify Fund<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
				</div>
			</div>
		</li>
	<?php
}
	?>
	</ul>
	<?php
if($proceed == 'Y') {
	?>
	<p class="text-center"><button type="button" class="btn mt30 finaluncover">I accept the terms and conditions of this Non-Disclosure Agreement</button></p> 
	<!-- Uncover -->
	<?php
}
?>
	<!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam malesuada sollicitudin sagittis. Nulla dignissim sed diam pellentesque efficitur. Aliquam placerat sem lorem. Phasellus fringilla hendrerit orci. In hac habitasse platea dictumst. Integer luctus sem sed mollis congue. Etiam semper, ligula sit amet rhoncus luctus, nulla odio condimentum mauris, ac molestie mi mauris vitae nibh. Aenean dapibus nunc sit amet lorem feugiat, sit amet semper dui viverra. Donec blandit eleifend cursus. Fusce pretium tortor mi, id lobortis risus convallis sit amet. Aenean placerat justo venenatis lectus feugiat, vitae pharetra magna luctus.</p>--> 
</form>