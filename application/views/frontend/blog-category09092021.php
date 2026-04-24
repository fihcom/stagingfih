

<section class="section latest-post">
    <div class="container">
        <h2 class="heading text-center">
        Latest Posts on: <?php echo $blogs['blog'][0]['blogCatName']?>
        </h2>
        <div class="blog_list">
            <ul class="ul row" id="blogul">
            <?php
                if(is_array($blogs['blog']) && count($blogs['blog'])>0)
                {
                    foreach($blogs['blog'] as $k=>$v)
                    {

                        $blogImage = explode(',',$v['blogImage']);
                        ?>
                        <li class="col-sm-6">
                            <div class="box">
                                <a href="<?php echo base_url();?>blog/<?php echo $v['blogSlug']?>" title="<?php echo $v['blogName']?>">
                                    <figure>
                                        <img class="lazy" src="<?php echo base_url();?>uploads/images_blog/<?php echo $blogImage[0];?>" data-src="<?php echo base_url();?>uploads/images_blog/<?php echo $blogImage[0];?>" alt="<?php echo $v['blogName']?>" style="">
                                        <div class="sk_info">
                                            <span><i class="fa fa-calendar"></i> <?php echo date('jS M Y',strtotime($v['addedOn']))?></span> 
                                        </div>
                                    </figure>
                                    <div class="text">
                                        <div class="admin">Post: by admin</div>
                                        <div class="subheading"><?php echo $v['blogName']?></div>
                                        <div class="para">
                                        <?php echo substr($v['blogDescription'],0,200); ?>...
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
                <a href="javascript: void(0);" class="btn btn-lg" id="loadmoreblog">Load More posts</a>
                </div>
            <form action="<?php echo base_url();?>getblog" id="blogfrm">
                <input type="hidden" id="blogStart" name="start" value="<?php echo $blogStart+$blogLimit?>">
                <input type="hidden" id="blogLimit" name="limit" value="<?php echo $blogLimit?>">
                <input type="hidden" id="" name="slug" value="<?php echo $slug?>">
                <input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            </form>
            <div id="blogthumb" style="display:none">
                <li class="col-sm-6">
                    <div class="box">
                        <a href="<?php echo base_url();?>blog/[BLOGSLUG]" title="blogname">
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