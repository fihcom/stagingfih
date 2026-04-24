<?php
/**
 * Blog Edit page
 */
/*echo '<pre>';
print_r($blog_details);
echo '</pre>';*/

$blogimage =  base_url() . '/uploads/blog_images/' . $blog_details['blog_image'];

?>

<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header">
              <h3 class="box-title">Edit Blog</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <?php $this->load->helper("form"); ?>
          <form role="form" id="editBlog" action="<?php echo base_url(); ?>administrator/admininfo/alter_blog_form_details" method="post" role="form" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <div class="box-body">
              <div class="row">
                <div class="col-md-4 blog-name">                                
                  <div class="form-group">
                      <label for="package_name">Blog Name</label>
                      <input type="text" class="form-control" value="<?php echo ($blog_details['blog_name'] != '') ? $blog_details['blog_name'] : '';?>" id="blog_name" name="blog_name">
                  </div>
                </div>
                <div class="col-md-4 blog-publishable-date">                                
                  <div class="form-group">
                      <label for="package_name">Blog Publishable Date</label>
                      <input type="text" class="form-control" value="<?php echo ($blog_details['blog_publishable_date'] != '') ? $blog_details['blog_publishable_date'] : '';?>" id="blog_publishable_date" name="blog_publishable_date">
                  </div>
                </div>
                <div class="col-md-4 blog-author">                                
                  <div class="form-group">
                      <label for="package_name">Blog Author</label>
                      <input type="text" class="form-control" value="<?php echo ($blog_details['name'] != '') ? $blog_details['name'] : '';?>" id="blog_author" name="blog_author" disabled="disabled">
                  </div>
                </div>
                <div class="col-md-6 package-name">                                
                  <div class="form-group">
                      <label for="blog_image">Blog Image</label>
                      <img src="<?php echo $blogimage; ?>" alt="" class="preview-sml"/>
                      <input type="file" class="" value="" id="blog_image" name="blog_image">
                      <input type="hidden" name="hidden_blog_image" value="<?php echo $blog_details['blog_image'];?>">
                  </div>
                </div>
                <div class="col-md-6 package-name">                                
                  <div class="form-group">
                      <label for="blog_approval_status">Blog Approval Status</label>
                      <select class="form-control" id="blog_approval_status" name="blog_approval_status">
                        <option value="">Select Status</option>
                        <option value="0"<?php echo ($blog_details['blog_approval_status'] == 0) ? ' selected="selected"' : '';?>>Inapproved</option>
                        <option value="1"<?php echo ($blog_details['blog_approval_status'] == 1) ? ' selected="selected"' : '';?>>Approved</option>
                      </select>
                  </div>
                </div>
                <div class="col-md-12 package-name">                                
                  <div class="form-group">
                      <label for="blog_description">Blog Description</label>
                      <textarea class="form-control" name="blog_description" id="blog_description" rows="6"><?php echo ($blog_details['blog_description'] != '') ? stripcslashes($blog_details['blog_description']) : '';?></textarea>
                  </div>
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <input type="hidden" name="action" value="edit">
              <input type="hidden" name="blog_id" value="<?php echo $blog_details['blog_id'];?>">
              <input type="submit" name="submit" class="btn btn-primary" value="Submit" />
              <input type="button" class="btn btn-default" value="Cancel" />
            </div>
          </form>
        </div>
      </div>
    </div>    
  </section>
</div>