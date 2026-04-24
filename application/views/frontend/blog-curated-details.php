<section class="section inner-blog">
    <div class="container">  
        <h2 class="heading font36 text-center"  data-aos="zoom-in" data-aos-duration="1800"> 
            <?php echo $blogdescription['title'];?>
        </h2>   
        
        <div class="blog-page">
            <div class="row">
                <article class="col-md-9 col-sm-8 stickyContent">
                    <div class="theiaStickySidebar">
                        <div class="content_wrap">
                            <div class="dtls-content">  
                                <figure>
                                    <?php
                                    $blogImage = json_decode($blogdescription['image'],true);
                                    ?>
                                    <img src="<?php echo base_url();?>uploads/images_extra/<?php echo $blogImage[0];?>" alt="">
                                </figure>
                                <div class="dtls-text">
                                    <div class="dtls-btop">
                                        <ul class="d-flex ul align-items-center">
                                            <li class="bdate d-flex align-items-center">
                                                <img src="<?php echo base_url();?>assets/frontend/images/date.png" alt="">
                                                <div>
                                                    <span><?php echo date('jS M',strtotime($blogdescription['date_added']));?></span>
                                                    <span><?php echo date('Y',strtotime($blogdescription['date_added']));?></span>
                                                </div>
                                            </li> 
                                            <!--<li><i class="fa fa-comment" aria-hidden="true"></i>33 Comments</li>-->
                                        </ul>
                                    </div> 
                                    <div class="dtls-bottom">
                                        <div class="dtls-share">
                                            <div class="scl-txt d-block">Share :</div>
                                            <div class="social_part social text-left">
                                                <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
                                                <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
                                                <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
                                                <a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a>
                                            </div>
                                        </div> 
                                        <h2 class="heading"><?php echo $blogdescription['title'];?></h2>
                                        <div class="short-desc">
                                        <?php echo $blogdescription['description'];?>
                                        </div> 

                                        
                                        </div>
                                    </div>
                                </div> 
                            </div> 
                        </div>
                    </div>
                </article> 
                
            </div>
        </div> 
    </div> 
</section>

