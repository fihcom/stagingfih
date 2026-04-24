<section class="section steps-wrapper steps-blue"> 
	<div class="container">
		<div class="steps-inner" id="buyer">
            <div class="steps-left">
                <h3 class="heading">For Buyers</h3> 
                <h4 class="subheading"><?php echo $homecontents[1]['content']['title'];?></h4> 
                <p><?php echo $homecontents[1]['content']['long_description'];?></p>
                <div class="steps-button mt-3">
                    <a href="<?php echo base_url();?>register" target="_blank" rel="noopener referrer" class="btn btn-lg btn-yellow">Register Now <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                    
                </div>
            </div>
            <div class="steps-right">
                <div class="step-row">
                    <?php
                    if(is_array($homecontents[1]['steps']) && count($homecontents[1]['steps'])>0)
                    {
                        $step = 1;
                        foreach($homecontents[1]['steps'] as $val)
                        {
                            ?>
                            <div class="step-item">
                                <h5 class="subheading"><span><?php echo $step;?></span><?php echo $val['title'];?></h5>
                                <p><?php echo $val['description'];?></p>
                            </div>
                            <?php
                            $step++;
                        }
                    }
                    ?>
                </div>				
            </div>
        </div>
        <div class="steps-inner" id="seller">
            <div class="steps-left">
                <h3 class="heading">For Sellers</h3> 
                <h4 class="subheading"><?php echo $homecontents[2]['content']['title'];?></h4> 
                <p><?php echo $homecontents[2]['content']['long_description'];?></p>
                <div class="steps-button mt-3">
                    <a href="<?php echo base_url();?>register" target="_blank" rel="noopener referrer" class="btn btn-lg btn-yellow">Register Now <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                    
                </div>
            </div>
            <div class="steps-right">
                <div class="step-row">
                <?php
                    if(is_array($homecontents[2]['steps']) && count($homecontents[2]['steps'])>0)
                    {
                        $step = 1;
                        foreach($homecontents[2]['steps'] as $val)
                        {
                            ?>
                            <div class="step-item">
                                <h5 class="subheading"><span><?php echo $step?></span><?php echo $val['title'];?></h5>
                                <p><?php echo $val['description'];?></p>
                            </div>
                            <?php
                            $step++;
                        }
                    }
                    ?>		
                </div> 			
            </div>
		</div>
	</div>
</section>