<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url();?>administrator">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Valuation Questions</li>
      </ol>
      <div class="box_general padding_bottom site-setting-area">
      <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="header_box version_2">
            <h2><i class="fa fa-file"></i>Add Valuation Questions</h2>
            <a style="float:right;" class="btn btn-primary btn-sm addasset" href="<?php echo base_url(); ?>administrator/valuation_questions">Back to list</a>
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
            <form role="form" id="valuationaddfrm" action="<?php echo base_url(); ?>administrator/valuation_questions/alter" method="post" role="form">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <input type="hidden" name="contentId" value="<?php echo $contentId?>">
            <div class="row">
            <div class="col-md-12">                                
                  <div class="form-group">
                      <label for="cat_name">Factor</label>
                      <select name="factor" id="" class="form-control">
                      <?php
                      foreach($valuationFactors as $key=>$val)
                      {
                        ?>
                        <option value="<?php echo $key;?>" <?php echo ($key == $result[0]['factor'])?'selected':'';?>><?php echo $val;?></option>
                        <?php
                      }
                      ?>
                      </select>
                  </div>
                </div>
                <div class="col-md-2">                                
                  <div class="form-group">
                      <label for="cat_name">Value</label>
                      <select name="value_type" id="factor" class="form-control">
                        <option value="higher" <?php echo ('higher' == $result[0]['value_type'])?'selected':'';?>>Higher</option>
                        <option value="lower" <?php echo ('lower' == $result[0]['value_type'])?'selected':'';?>>Lower</option>
                      </select> 
                  </div>
                  </div>
                  <div class="col-md-1">                                
                    <div class="form-group" style="padding-top:37px">
                    <label for="cat_name">&nbsp;</label>
                      value equals 
                    </div>
                  </div>
                      <div class="col-md-2">                                
                        <div class="form-group">
                        <label for="cat_name">Yield</label>
                          <select name="range_type" id="factor" class="form-control">
                          <option value="higher" <?php echo ('higher' == $result[0]['range_type'])?'selected':'';?>>Higher</option>
                            <option value="lower" <?php echo ('lower' == $result[0]['range_type'])?'selected':'';?>>Lower</option>
                          </select> 
                      
                  </div>
                </div>
                <div class="col-md-2">                                
                    <div class="form-group">
                    <label for="cat_name">&nbsp;</label>
                    
                    </div>
                  </div>
             <div class="col-md-12">                                
                  <div class="form-group">
                      <label for="cat_name">Question</label>
                      <input type="text" class="form-control" value="<?php echo ($result[0]['question']!='')?$result[0]['question']:'' ?>" id="" name="question" placeholder="Question">
                  </div>
                </div> 
                <div class="col-md-3">                                
                  <div class="form-group">
                      <label for="cat_name">Range From</label>
                      <input type="text" class="form-control" value="<?php echo ($result[0]['low_range']!='')?$result[0]['low_range']:'' ?>" id="" name="low_range" placeholder="Range From">
                  </div>
                </div>
                 <div class="col-md-3">                                
                  <div class="form-group">
                      <label for="cat_name">Range To</label>
                      <input type="text" class="form-control" value="<?php echo ($result[0]['high_range']!='')?$result[0]['high_range']:'' ?>" id="" name="high_range" placeholder="Range To">
                  </div>
                </div> 
                <div class="col-md-3">                                
                  <div class="form-group">
                      <label for="cat_name">Worth</label>
                      <input type="text" class="form-control" value="<?php echo ($result[0]['worth']!='')?$result[0]['worth']:'' ?>" id="" name="worth" placeholder="Worth">
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