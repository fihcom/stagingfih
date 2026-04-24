<?php 
  $blogCatName = '';
  $blogCatParent = '';
  $blogCatStatus = '';

  $headingText = 'Add Blog Category';
  $formID = 'AddCat';
  $blogCatID = '';

  $action = 'add';

  if(isset($blogCatDetails)) {
    $action = 'edit';
    $blogCatName = $blogCatDetails['blogCatName'];
    $blogCatParent = $blogCatDetails['blogCatParent'];
    $blogCatStatus = $blogCatDetails['blogCatStatus'];

    $headingText = 'Edit Blog Category';
    $formID = 'EditCat';

    $blogCatID = $blogCatDetails['blogCatID'];
  }
?>

<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="blog-categories">Blog Categories</a>
      </li>
      <li class="breadcrumb-item active"><?php echo $headingText;?></li>
    </ol>
    <div class="box_general padding_bottom">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
        <!-- general form elements -->
          <div class="box box-primary">
            <div class="header_box version_2">
              <h2><i class="fa fa-file"></i><?php echo $headingText;?></h2>
              <a class="btn btn-primary btn-sm btn-md pull-right" href="<?php echo base_url(); ?>administrator/blog-categories"><i class="fa fa-level-up"></i> Back to list</a>
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
            <form role="form" id="AddEditBlogCategory" action="<?php echo base_url(); ?>administrator/Adminbloginfo/alterBlogCatDetails" method="post" role="form">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6 cat-name">                                
                    <div class="form-group">
                      <label for="blogCatName">Blog Category Name <span style="color:red;">*</span></label>
                      <input type="text" class="form-control" placeholder="Blog Category Name" value="<?php echo $blogCatName;?>" id="blogCatName" name="blogCatName">
                    </div>
                  </div>
                  <!-- <div class="col-md-6 cat-name">                                
                    <div class="form-group">
                      <label for="blogCatParent">Blog Parent</label>
                      <select name="blogCatParent" id="blogCatParent" class="form-control">
                        <option value="">Select Option</option>
                        <?php 
                          foreach($parent_cats as $pCats){
                            ?>
                        <option<?php echo ($blogCatParent != '' && $blogCatParent == $pCats['blogCatID']) ? ' selected="selected"' : '';?> value="<?php echo $pCats['blogCatID'];?>"><?php echo $pCats['blogCatName'];?></option>
                            <?php
                          }
                        ?>
                      </select>
                    </div>
                  </div> -->
                  <div class="col-md-6 package-name">                                
                    <div class="form-group">
                      <label for="package_name">Blog Category Status <span style="color:red;">*</span></label>
                      <div class="blogcat-statuses">
                        <label for="blogcat_status"><input type="radio" name="blogCatStatus" value="1"<?php echo ($blogCatStatus == '' || $blogCatStatus == '1') ? ' checked="checked"' : '';?>>Active</label>
                        <label for="blogcat_status"><input type="radio" name="blogCatStatus" value="0"<?php echo ($blogCatStatus == '0') ? ' checked="checked"' : '';?>> Inactive</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <input type="hidden" name="action" value="<?php echo $action;?>">
                <?php if($blogCatID != '') { ?>
                <input type="hidden" name="blogCatID" value="<?php echo $blogCatID;?>">
                <?php } ?>
                <input type="submit" name="submit" class="btn btn-primary" value="Submit" />
                <input type="button" onclick="location.href='<?php echo base_url(); ?>administrator/blog-categories'" class="btn btn-default" value="Cancel" />
                <p><span style="color:red;">*</span> fields are mandatory.</p>
              </div>
            </form>
          </div>
        </div>
      </div>    
    </div>
  </div>
</div>