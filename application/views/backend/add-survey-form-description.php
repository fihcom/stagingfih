<?php


  $title = 'Add Survey form';
  $action = 'add';
  $userID = 0;
?>
<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo base_url();?>politician/surveyforms">Survey list</a>
      </li>
      <li class="breadcrumb-item active"><?php echo $settings['survey_title']?></li>
    </ol>
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
    <div class="box_general padding_bottom">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="header_box version_2">
              <h2><i class="fa fa-file"></i><?php echo $settings['survey_title']?></h2>
              <a class="btn btn-primary btn-md pull-right" href="<?php echo base_url(); ?>politician/surveyforms"><i class="fa fa-level-up"></i> Back to list</a>
            </div><!-- /.box-header -->
            <!-- form start -->
            <br clear="all">
            <?php $this->load->helper("form"); ?>
            <form role="form" id="AddSurvey" action="<?php echo base_url(); ?>politician/surveyforms/addfields" method="post" role="form" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12 add-survey-form-desc">                                
                  <?php echo $settings['survey_description']?>
                  </div>
                  <div class="col-md-12 add-survey-form-desc-price">  
                  <div class="form-group">
                    <label for="">Survey Cost</label>
                    <div class="membership-fee">                              
                      <?php echo $currency[0]['symbol'].$settings['survey_price']?>
                    </div>
                   </div>
                  
                  </div>
                  
                  
                  
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <input type="hidden" name="action" value="<?php echo $action;?>">
                
                <input type="submit" name="submit" class="btn btn-primary" value="Proceed" />
                <input type="button" onclick="location.href='<?php echo base_url();?>politician/surveyforms';" class="btn btn-default" value="Cancel" />
              </div>
            </form>
          </div>
        </div>
      </div>    
      </div>
    </div>
  </div>