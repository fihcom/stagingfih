<main class="mainContainer">  
		
		<section class="section inner-pages">
			<div class="container">
			<?php
			if($page_details['pageFeatureImage'] !='')
			{
				?>
				<div class="img_right">
					<img src="<?php echo base_url();?>uploads/cms_page_images/<?php echo $page_details['pageFeatureImage']?>" alt="">
				</div>
				<?php
			}
			?>
				
				<div class="editor_text">
					<h2 class="heading"><?php echo $page_details['pageTitle'];?></h2> 
					<!--<ul>
						<li>Experienced team based in the deal capital of the world, Manhattan, New York City. </li>
						<li>We’ve generated $32M+  in business & website sales.</li>
						<li>50 years combined experience.</li>
						<li>CPA reviewed financial statements.</li>
						<li>10,000+ investors in our active buyer pool.</li>
						<li>Excellent Closure Rates</li>
						<li>6-9% tiered commission</li>
					</ul>
					<div class="fees-sec">
						<div class="fees-wrap d-flex flex-wrap">
							<div class="fees-left">
								<div class="heading2">Listing Fees</div>
								<div class="para">$495 per business</div>
							</div>
							<div class="fees-right">
								<div class="heading2">Success Fees</div>
								<div class="editor_text">
									<ul>
										<li>9% up to $1M</li>
										<li>7% up to $2.5M</li>
										<li>5% from $2.5-5M</li>
										<li>3% on $5M+</li>
									</ul>
								</div>
							</div>
						</div>
					</div>-->
					<?php echo stripslashes($page_details['pageContent']);?>
				</div>
			</div>
		</section>
		<?php
		if(is_array($partners) && count($partners)>0)
		{
			?>
			<section class="section client">
			<div class="container">
				<div class="owl-carousel client-slider">
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
	</main> 