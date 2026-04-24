<section class="section inner-blog">
    <div class="container">  
        <h2 class="heading font36 text-center"  data-aos="zoom-in" data-aos-duration="1800"> 
            <?php echo $blogdescription['blogName'];?>
        </h2>   
        
        <div class="blog-page">
            <div class="row">
                <article class="col-md-12 col-sm-12 stickyContent">
                    <div class="theiaStickySidebar">
                        <div class="content_wrap">
                            <div class="dtls-content">  
                                <figure>
                                    <?php
                                    $blogImage = explode(',',$blogdescription['blogImage']);
                                    ?>
                                    <img src="<?php echo base_url();?>uploads/images_blog/<?php echo $blogImage[0];?>" alt="">
                                </figure>
                                <div class="dtls-text">
                                    <div class="dtls-btop">
                                        <ul class="d-flex ul align-items-center">
                                            <li class="bdate d-flex align-items-center">
                                                <img src="<?php echo base_url();?>assets/frontend/images/date.png" alt="">
                                                <div>
                                                    <span><?php echo date('jS M',strtotime($blogdescription['addedOn']));?></span>
                                                    <span><?php echo date('Y',strtotime($blogdescription['addedOn']));?></span>
                                                </div>
                                            </li> 
                                            <?php
                                            if($blogdescription['blog_author'] !='')
                                            {
                                                ?><li class="right">By <?php echo $blogdescription['blog_author'];?></li>
                                                <?php
                                            }
                                            ?>
                                            
                                        </ul>
                                    </div> 
                                    <div class="dtls-bottom">
                                        <div class="dtls-share">
                                            <!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox_djuq"></div>
                                        </div> 
                                        <h2 class="heading"><?php echo $blogdescription['blogName'];?></h2>
                                        <div class="short-desc">
                                        <?php echo $blogdescription['blogDescription'];?>
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
<!-- Go to www.addthis.com/dashboard to customize your tools --> 
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ee3383b9c1ae0f3"></script>

