<main class="mainContainer">  
		<section class="section inner-testimonial">
			<div class="container">
				<div class="d-flex top-head-sec flex-wrap mb30">
					<div>
						<h2 class="heading">Our Testimonials...</h2>
						
						<p>Hear what real customers and clients have to say about their experience with us.</p>


					</div>
					
				</div>
				<div class="inner-testimonial-list">
					<ul class="ul testimonialul">
					<?php
					foreach($testimonial as $v)
					{ 
						//$monetizationstrrb = '';
						?>
						<li data-aos="fade-up" data-aos-duration="2200">
                        
						<div class="testimonial-box">
							<div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between">
										<div class="block">
											<div class="test-head"><?php echo $v['author'];?>&nbsp;<small>[<?php echo $v['designation'];?>]</small></div>
											<span class="test-date d-block"><?php echo $v['dateformated'];?></span>
										</div>
                                    </div>
                                </div>
								<div class="col-md-12">
									<div class="test-para">
										<?php 
										echo $v['description'];
										?>
									</div>
								</div>
								
							</div>
						</div>
					</li>
						<?php
					}
					?>
					</ul>
                    <form action="" id="loadmoretestimonialfrm">
                    <input type="hidden" name="page" id="page" value="<?php echo $page?>">
                    <input type="hidden" name="limit" id="limit" value="<?php echo $limit?>">
                    <input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    </form>
                    <div id="testimonialli" style="display:none">
                    <li data-aos="fade-up" data-aos-duration="2200">
                        
						<div class="box">
							<div class="row">
                                <div class="col-md-8">
                                            <div class="mid-block d-flex justify-content-between">
                                                <div class="block">
                                                    <div class="head">[AUTHOR]&nbsp;<small>[[DESIGNATION]]</small></div>
                                                    <span>[DATE]</span>
                                            </div>
                                    </div>
                                </div>
								<div class="col-md-12">
									[DESCRIPTION]
								</div>
								
							</div>
						</div>
					</li></div>
				</div>
                <?php
                //print '<pre>';
                //print_r($totalrecord);
                if($totalrecord['totalrecord']>(($page*$limit)+$limit))
                {
                    ?>
                    <div data-aos="fade-up" data-aos-duration="2200" class="btn_center">
					<a href="javascript: void(0);" class="btn loadmoretestimonial">Load More Testimonials </a>
				</div>
                    <?php
                }
                ?>
				
			</div>
		</section>
</main>