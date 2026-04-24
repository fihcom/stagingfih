<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url();?>administrator">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Promo Code</li>
      </ol>
      <div class="box_general padding_bottom site-setting-area">
      <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="header_box version_2">
            <h2><i class="fa fa-file"></i>Add Promo Code</h2>
            <a style="float:right;" class="btn btn-primary btn-sm addasset" href="<?php echo base_url(); ?>administrator/promo-code">Back to list</a>
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
            <form role="form" id="promoCodeFrm" action="<?php echo base_url(); ?>administrator/promo-code/alter" method="post" role="form">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <input type="hidden" name="promocodeId" value="<?php echo $result[0]['id']?>">
            <div class="row">
                <div class="col-md-4">                                
                  <div class="form-group">
                      <label for="cat_name">Code Title</label>
                      <input type="text" class="form-control" value="<?php echo $result[0]['promocode'] ?>" id="codeTitle" name="codeTitle">
                  </div>
                </div>
                <div class="col-md-4">                                
                  <div class="form-group">
                      <label for="cat_name">Discount Type</label>
                      <select name="discountType" id="discountType" class="form-control">
                      <option value="Percentage" <?php echo ($result[0]['discount_type']=='Percentage')?'selected':'' ?>>Promo Percentage</option>
                      <option value="Amount" <?php echo ($result[0]['discount_type']=='Amount')?'selected':'' ?>>Promo Amount</option>
                      </select>
                  </div>
                </div>
             <div class="col-md-4">                                
                  <div class="form-group">
                      <label for="cat_name">Amount</label>
                      <input type="text" class="form-control" value="<?php echo $result[0]['discount'] ?>" id="" name="amount">
                  </div>
                </div> 
                <div class="col-md-4">                                
                  <div class="form-group">
                      <label for="cat_name">Validity</label>
                      <select name="Validity" id="validity" class="form-control">
                      <option value="LifeTime" <?php echo ($result[0]['validity']=='LifeTime')?'selected':'' ?>>Life Time</option>
                      <option value="DateRange" <?php echo ($result[0]['validity']=='DateRange')?'selected':'' ?>>Date Range</option>
                      </select>
                  </div>
                </div>
                <div class="col-md-4 datefields" <?php echo ($result[0]['validity']=='LifeTime' || $result[0]['validity']=='')? 'style="display:none"':''?>>                                
                  <div class="form-group">
                      <label for="cat_name">Date From</label>
                      <input type="date" class="form-control" value="<?php echo $result[0]['date_from'] ?>" id="" name="dateFrom">
                  </div>
                </div>
                <div class="col-md-4 datefields" <?php echo ($result[0]['validity']=='LifeTime' || $result[0]['validity']=='')? 'style="display:none"':''?>>                                
                  <div class="form-group">
                      <label for="cat_name">Date To</label>
                      <input type="date" class="form-control" value="<?php echo $result[0]['date_to'] ?>" id="" name="dateTo">
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