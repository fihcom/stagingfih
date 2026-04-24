<main class="mainContainer">  
                <?php
					if($this->uri->segment(1) == 'maconsulting')
					{
                        $maconsulting = 'maconsulting';
                    }else{
                        $maconsulting = '';
                    }
				?>
		<section class="section inner-pages <?php echo $maconsulting;?>">
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