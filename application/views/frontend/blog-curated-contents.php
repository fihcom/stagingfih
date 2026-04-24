<section class="section latest-post">
    <div class="container">
        <h2 class="heading text-center">
        Curated Content for <?php echo ($area=='SELLER')?'Seller':'Buyer';?>
        </h2>
        <div class="blog_list">
            <ul class="ul row" id="blogul">
            <?php
                if(is_array($blogs['record']) && count($blogs['record'])>0)
                {
                    foreach($blogs['record'] as $k=>$v)
                    {

                        $blogImage = json_decode($v['image'],true);
                        ?>
                        <li class="col-sm-6">
                            <div class="box">
                                <a class="d-block" href="<?php echo base_url();?>curated-content/<?php echo $v['title_slug']?>" title="<?php echo $v['title']?>">
                                    <figure>
                                        <img class="lazy" src="<?php echo base_url();?>uploads/images_extra/<?php echo $blogImage[0];?>" data-src="<?php echo base_url();?>uploads/images_extra/<?php echo $blogImage[0];?>" alt="<?php echo $v['title']?>">
                                        <div class="sk_info">
                                            <span><i class="fa fa-calendar"></i> <?php echo date('jS M Y',strtotime($v['date_added']))?></span> 
                                        </div>
                                    </figure>
                                    <div class="text">
                                        <div class="admin">Post: by admin</div>
                                        <div class="subheading"><?php echo $v['title']?></div>
                                        <div class="para">
                                        <?php echo substr($v['description'],0,2000); ?>...
                                        </div>
                                        <span class="readmore">Read More</span>
                                    </div>
                                </a>
                            </div>
                        </li>
                        
                        <?php
                    }
                }
                ?>
            </ul>
            <?php
            if($blogs['totalrecord']['totalrecord']>$blogLimit)
            {
                ?>
                <div class="btn_center">
                <a href="javascript: void(0);" class="btn btn-lg" id="loadmorecuratedcontentseller">Load More posts</a>
                </div>
            <form action="<?php echo base_url();?>getsellercuratedcontents" id="blogfrm">
                <input type="hidden" id="blogStart" name="page" value="<?php echo $blogStart+$blogLimit?>">
                <input type="hidden" id="blogLimit" name="limit" value="<?php echo $blogLimit?>">
                <input type="hidden" id="" name="area" value="<?php echo $area;?>">
                <input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            </form>
            <div id="blogthumb" style="display:none">
                <li class="col-sm-6">
                    <div class="box">
                        <a href="<?php echo base_url();?>curated-content/[BLOGSLUG]" title="blogname">
                            <figure>
                                <img class="lazy" blogimage data-blogimage alt="blogname" style="">
                                <div class="sk_info">
                                    <span><i class="fa fa-calendar"></i> [BLOGDATE]</span> 
                                </div>
                            </figure>
                            <div class="text">
                                <div class="admin">Post: by admin</div>
                                <div class="subheading">blogname</div>
                                <div class="para">
                                [BLOGDESCRIPTION]
                                </div>
                                <span class="readmore">Read More</span>
                            </div>
                        </a>
                    </div>
                </li>
            </div>   
                <?php
            }
            ?>
            
        </div>
    </div>
</section>