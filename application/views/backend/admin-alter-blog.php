<?php 
  $blogName = '';
  $blogCategory = '';
  $blogPublishableDate = '';
  $blogStatus = '';
  $blogImage = '';
  $blogDescription = '';
  $headingText = 'Add Blog';
  $formID = 'AddBlog';
  $action = 'add';
  $blogID = '';

  if(isset($blog_details)){
    $blogName = $blog_details['blogName'];
    $blogCategory = $blog_details['blogCategory'];
    $blogPublishableDate = $blog_details['blogPublishableDate'];
    $blogStatus = $blog_details['blogStatus'];
    $blogImage = $blog_details['blogImage'];
    $blogDescription = $blog_details['blogDescription'];
    $blog_author = $blog_details['blog_author'];
    $headingText = 'Edit Blog';
    $formID = 'EditBlog';
    $action = 'edit';
    $blogID = $blog_details['blogID'];
  }


?>

<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url();?>administrator/blogs">Blog Listing</a>
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
            <a class="btn btn-primary btn-sm pull-right" href="<?php echo base_url(); ?>administrator/blogs"><i class="fa fa-level-up"></i> Back to list</a>
          </div><!-- /.box-header -->
          <!-- form start -->
          <br clear="all">
          <?php $this->load->helper("form"); ?>
          <form role="form" id="AddEditBlog" action="<?php echo base_url(); ?>administrator/Adminbloginfo/alterBlogDetails" method="post" role="form" enctype="multipart/form-data">
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <div class="box-body">
              <div class="row">
                <div class="col-md-6 blog-name">                                
                  <div class="form-group">
                      <label for="blogName">Title <span style="color:red">*</span></label>
                      <input type="text" class="form-control" value="<?php echo $blogName;?>" id="blogName" name="blogName">
                  </div>
                </div>
                <div class="col-md-6 blog-slug">                                
                  <div class="form-group">
                    <label for="blogCategory">Category <span style="color:red">*</span></label>
                    <?php 
                      // pre($blogCatDetails);
                    ?>
                    <select class="form-control" id="blogCategory" name="blogCategory">
                      <option value="">Select Category</option>
                      <?php
                        foreach($blogCatDetails as $bcDetails){
                          ?>
                      <option<?php echo ($blogCategory != '' && $blogCategory == $bcDetails['blogCatID']) ? ' selected="selected"' : '';?> value="<?php echo $bcDetails['blogCatID'];?>"><?php echo $bcDetails['blogCatName'];?></option>
                          <?php
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-12 package-name">                                
                  <div class="form-group">
                      <label for="blogDescription">Description <span style="color:red">*</span></label>
                      <textarea class="editor form-control" name="blogDescription" id="blogDescription"><?php echo $blogDescription;?></textarea>
                  </div>
                </div>
                <div class="col-md-4 package-name">                                
                  <div class="form-group">
                      <label for="package_name">Blog Author</label>
                      <input type="text" class="form-control" value="<?php echo $blog_author; ?>" id="blog_author" name="blog_author" placeholder="Blog Author">
                  </div>
                </div>
                <div class="col-md-8 blog-name">                                
                  <div class="form-group">
                      <label for="blogName">Image</label>
                      <div class="col-md-12 dropzone" id="blogimg" style="height:100px"> </div>
                      <input type="hidden" name="imageContents" id="imageContents" value="<?php echo $blogImage?>">

                  </div>
                </div>
                <div class="col-md-4 blog-slug">                                
                  <div class="form-group">
                      <label for="blogCategory">Status <span style="color:red">*</span></label>
                      <label for="blogStatus"><input type="radio" name="blogStatus" value="1"<?php echo ($blogStatus == '' || $blogStatus == '1') ? ' checked="checked"' : '';?>>Active</label>
                        <label for="blogStatus"><input type="radio" name="blogStatus" value="0"<?php echo ($blogStatus == '0') ? ' checked="checked"' : '';?>> Inactive</label>
                  </div>
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <input type="hidden" name="action" value="<?php echo $action;?>">
              <?php if($blogID != '') { ?>
              <input type="hidden" name="blogID" value="<?php echo $blogID;?>">
              <?php } ?>
              <input type="submit" name="submit" class="btn btn-primary" value="Submit" />
              <input type="button" onclick="location.href='<?php echo base_url();?>administrator/blogs';" class="btn btn-default" value="Cancel" />
              <p><span style="color:red">*</span> fields are mandatory.</p>
            </div>
          </form>
        </div>
      </div>
    </div>    
    </div>
  </div>
</div>


<!-- The Modal -->
<div class="modal fade" id="myModalShowImage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Image preview</h4>
      </div>
      <div class="modal-body">
        <img src="" id="imagepreview" style="max-width: 100%; height: 264px;" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
var images = [];
<?php
if($blogImage !='')
{
  $blogImgArr = explode(',',$blogImage);
  if(is_array($blogImgArr) && count($blogImgArr)>0)
  {
    foreach($blogImgArr as $val)
    {
      ?>
        images.push('<?php echo $val;?>');
      <?php
    }
  }
  
}
?>
</script>
