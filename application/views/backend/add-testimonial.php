<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url();?>administrator">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Testimonial</li>
      </ol>
      <div class="box_general padding_bottom site-setting-area">
      <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="header_box version_2">
            <h2><i class="fa fa-file"></i>Add Testimonial</h2>
            <a style="float:right;" class="btn btn-primary btn-sm addasset" href="<?php echo base_url(); ?>administrator/testimonials">Back to list</a>
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
            <form role="form" id="testimonialFrm" action="<?php echo base_url(); ?>administrator/testimonial/alter" method="post" role="form" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <input type="hidden" name="testimonialId" value="<?php echo $contentId?>">
            <div class="row">
                
                <div class="col-md-12">                                
                  <div class="form-group">
                      <label for="cat_name">Description</label>
                      <textarea name="description" id="" cols="30" rows="10" class="editor"><?php echo $result[0][0]['description'] ?></textarea>
                  </div>
                </div>
              
             <div class="col-md-9">                                
                  <div class="form-group">
                      <label for="cat_name">Author</label>
                      <input type="text" class="form-control" value="<?php echo ($result[0][0]['author']!='')?$result[0][0]['author']:'' ?>" id="" name="author">
                  </div>
                </div> 
                <div class="col-md-3">                                
                <div class="form-group">
                      <label for="cat_name">Designation</label>
                      <input type="text" class="form-control" value="<?php echo $result[0][0]['designation'] ?>" id="site_title" name="desingation">
                  </div>
                </div>             
            </div>
            
            
            <div class="box-footer">
              <input type="hidden" name="action" value="add">
              
              <input type="submit" name="submit" class="btn btn-primary" value="Submit" />
            </div>
          </form>
        </div>
      </div>
    </div>    
    </div>
  </div>
</div>
<script>
var images = [];
<?php
if($result[0]['image'] !='')
{
  $imagesArr = json_decode($result[0]['image'],true);
  if(is_array($imagesArr) && count($imagesArr)>0)
  {
    foreach($imagesArr as $val)
    {
      ?>
      images.push('<?php echo $val?>');
      <?php
    }
  }
}
?>
</script>