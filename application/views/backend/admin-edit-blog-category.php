<div class="content-wrapper">
<div class="container-fluid">
<ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Edit Blog Category</li>
      </ol>
      <div class="box_general padding_bottom">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header">
              <h3 class="box-title">Edit Blog Category</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <?php 
              $error = $this->session->flashdata('error');
              if($error) {
                ?>
                <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php 
              } 

              $success = $this->session->flashdata('success');
              if($success) { 
                ?>
                <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php 
              } 
              ?>
                <br clear="all">
          <?php $this->load->helper("form"); ?>
          <form role="form" id="editBlogCat" action="<?php echo base_url(); ?>administrator/adminbloginfo/alter_blog_cat_form_details" method="post" role="form">
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <div class="box-body">
              <div class="row">
                <div class="col-md-6 blogcat-name">                                
                  <div class="form-group">
                      <label for="cat_blog_name">Blog Category Name</label>
                      <input type="text" class="form-control" id="name" name="name" value="<?php echo $blog_cat_details['name']; ?>">
                  </div>
                </div>
                <div class="col-md-6 blogcat-slug">                                
                  <div class="form-group">
                      <input type="hidden" class="form-control" value="<?php echo $blog_cat_details['slug']; ?>" id="slug" name="slug" readonly="readonly">
                  </div>
                </div>
                <div class="col-md-4 package-name">                                
                  <div class="form-group">
                      <label for="package_name">Blog Category Status</label>
                      <div class="statuses">
                        <label for="status"><input type="radio" name="status" value="1" <?php if(isset($blog_cat_details['status']) && $blog_cat_details['status']==1) { echo 'checked="checked"'; } ?>> Active</label>
                        <label for="status"><input type="radio" name="status" value="0" <?php if(isset($blog_cat_details['status']) && $blog_cat_details['status']==0) { echo 'checked="checked"'; } ?>> Inactive</label>
                      </div>
                  </div>
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <input type="hidden" name="action" value="edit">
              <input type="hidden" name="hidden_cat_id" value="<?php echo $blog_cat_details['cat_id'];?>">
              <input type="submit" name="submit" class="btn btn-primary" value="Submit" />
              <input type="button" class="btn btn-default" value="Cancel" />
            </div>
          </form>
        </div>
      </div>
    </div>   
    </div> 
    </div>
</div>