<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url();?>administrator">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Site Settings</li>
      </ol>
      <div class="box_general padding_bottom site-setting-area">
      <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="header_box version_2">
            <h2><i class="fa fa-file"></i>Site Settings info</h2>
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
            <form role="form" id="siteSettings" action="<?php echo base_url(); ?>administrator/adminsitesettings/submit_sitesetting_form" method="post" role="form" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <div class="row">
                <div class="col-md-12">                                
                  <div class="form-group">
                      <label for="cat_name">Site Title</label>
                      <input type="text" class="form-control" value="<?php echo $siteSettings['site_title'] ?>" id="site_title" name="site_title">
                  </div>
                </div>
                

                
                <!--<div class="col-md-6">                                
                  <div class="form-group">
                      <label for="cat_name">Wire Transfer Details</label>
                      <input type="text" class="form-control" value="<?php echo $siteSettings['wire_transfer_details'] ?>" id="wire_transfer_details" name="wire_transfer_details">
                  </div>
                </div>-->
                <div class="col-md-12">                                
                  <div class="form-group">
                      <label for="cat_name">Description</label>
                      <textarea class="form-control" value="" id="description" name="description"><?php echo $siteSettings['description'] ?></textarea>
                  </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                <label for="cat_name">Home Page Logo</label>
                <?php
                if($siteSettings['home_logo'] !='')
                {
                  ?>
                  <div id="home_logo" style="background-color:grey; width:142px; height:56px;">
                  <img style="width:142px; height:56px;" src="<?php echo base_url() ?>uploads/logo_image/<?php echo $siteSettings['home_logo'] ;?>" alt="">
                  </DIV>
                  <?php
                  if($editpermission)
                  {
                    ?>
                  <button type="button" style="margin-top:10px;" class="btn btn-warning btn-xs change-home-logo">Change Image</button> 
                  <div class="dropzone" id="homepagelogo" style="min-height:154px; display:none"></div>
                  <?php
                  }
                }elseif($editpermission){
                  ?>
                  <div class="dropzone" id="homepagelogo" style="min-height:154px"></div>
                  <?php
                }
                ?>
                  <input type="hidden" name="homelogoimagefile" id="homelogoimagefile">
                </div>
                </div>                              
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="cat_name">Inside Page Logo</label>
                  <?php
                if($siteSettings['inside_logo'] !='')
                {
                  ?>
                  <div id="inside_logo" style="background-color:grey; width:142px; height:56px;">
                  <img style="width:142px; height:56px;" src="<?php echo base_url() ?>uploads/logo_image/<?php echo $siteSettings['inside_logo'] ;?>" alt="">
                  </DIV>
                  <?php
                  if($editpermission)
                  {
                    ?>
                  <button type="button" style="margin-top:10px;" class="btn btn-warning btn-xs change-inside-pic">Change Image</button> 
                  <div class="dropzone" id="insidepagelogo" style="min-height:154px; display:none"></div>
                  <?php
                  }
                }elseif($editpermission){
                  ?>
                    <div class="dropzone" id="insidepagelogo" style="min-height:154px"></div>
                    <?php
                }
                ?>
                    <input type="hidden" name="insidelogoimagefile" id="insidelogoimagefile">
                  </div>
                </div>
            </div>
              
            <br clear="all">
            <br clear="all">     
            <h4>Contact info</h4>
            <br clear="all">
            <div class="row">
                <div class="col-md-3">                                
                  <div class="form-group">
                      <label for="cat_name">Helpline No</label>
                      <input type="text" class="form-control" value="<?php echo $siteSettings['helpline_no'] ?>" id="helpline_no" name="helpline_no">
                  </div>
                </div>

                <div class="col-md-3">                                
                  <div class="form-group">
                      <label for="cat_name">Helpline Email Address</label>
                      <input type="text" class="form-control" value="<?php echo $siteSettings['helpline_email_address'] ?>" id="helpline_email_address" name="helpline_email_address">
                  </div>
                </div>
                <div class="col-md-3">                                
                  <div class="form-group">
                      <label for="cat_name">Support Email Address</label>
                      <input type="text" class="form-control" value="<?php echo $siteSettings['support_email_address'] ?>" id="support_email_address" name="support_email_address">
                  </div>
                </div>

                <div class="col-md-12">                                
                  <div class="form-group">
                      <label for="cat_name">Address</label>
                      <textarea class="form-control" value="" id="address" name="address"><?php echo $siteSettings['address'] ?></textarea>
                  </div>
                </div>
            </div>
            <br clear="all">
            <br clear="all">     
            <h4>FIH Transaction and Payment Details</h4>
            <br clear="all">
            <div class="row">
            <div class="col-md-3">                                
                  <div class="form-group">
                      <label for="cat_name">Currency</label>
                      <!--<input type="text" class="form-control" value="<?php echo $siteSettings['currency'] ?>" id="currency" name="currency">-->
                      <select class="form-control" name="currency" id="currency">
                        <option value="">Select Currency</option>
                        <?php 
                          foreach($getCurrency as $currency){
                            ?>
                            <option value="<?php echo $currency['id'];?>"<?php echo ($currency['id'] == $siteSettings['currency']) ? ' selected="selected"' : '';?>><?php echo $currency['currency'].'('.$currency['code'].')('.$currency['symbol'].')';?></option>
                            <?php
                          }
                        ?>
                      </select>
                  </div>
                </div>
                <div class="col-md-3">                                
                  <div class="form-group">
                      <label for="cat_name">PayPal Email</label>
                      <input type="text" class="form-control" value="<?php echo $siteSettings['paypal_email'] ?>" id="paypalemail" name="paypalemail">
                     
                  </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-3">                                
                  <div class="form-group">
                      <label for="cat_name">Bank Name</label>
                      <input type="text" class="form-control" value="<?php echo $siteSettings['wire_bank_name'] ?>" id="wire_bank_name" name="wire_bank_name">
                  </div>
                </div>
                <div class="col-md-9">                                
                  <div class="form-group">
                      <label for="cat_name">Bank Address</label>
                      <input type="text" class="form-control" value="<?php echo $siteSettings['wire_bank_address'] ?>" id="wire_bank_address" name="wire_bank_address">
                  </div>
                </div>
                <div class="col-md-3">                                
                  <div class="form-group">
                      <label for="cat_name">Swift Code</label>
                      <input type="text" class="form-control" value="<?php echo $siteSettings['wire_swift_code'] ?>" id="wire_swift_code" name="wire_swift_code">
                  </div>
                </div>
                <div class="col-md-3">                                
                  <div class="form-group">
                      <label for="cat_name">Credit Account Name</label>
                      <input type="text" class="form-control" value="<?php echo $siteSettings['wire_credit_account_name'] ?>" id="wire_credit_account_name" name="wire_credit_account_name">
                  </div>
                </div>
                <div class="col-md-3">                                
                  <div class="form-group">
                      <label for="cat_name">ABA Routing #</label>
                      <input type="text" class="form-control" value="<?php echo $siteSettings['wire_aba_routing'] ?>" id="wire_aba_routing" name="wire_aba_routing">
                  </div>
                </div>
                <div class="col-md-3">                                
                  <div class="form-group">
                      <label for="cat_name">Credit Account #</label>
                      <input type="text" class="form-control" value="<?php echo $siteSettings['wire_credit_account_no'] ?>" id="wire_credit_account_no" name="wire_credit_account_no">
                  </div>
                </div>
                <div class="col-md-6">                                
                  <div class="form-group">
                      <label for="cat_name">Wire Beneficiary Address</label>
                      <input type="text" class="form-control" value="<?php echo $siteSettings['wire_beneficiary_address'] ?>" id="wire_beneficiary_address" name="wire_beneficiary_address">
                  </div>
                </div>
                <div class="col-md-6">                                
                  <div class="form-group">
                      <label for="cat_name">Additional Instruction</label>
                      <input type="text" class="form-control" value="<?php echo $siteSettings['wire_additional_info'] ?>" id="wire_additional_info" name="wire_additional_info">
                  </div>
                </div>
            </div>
            <br clear="all">
            <br clear="all">     
            <h4>FIH Pricing</h4>
            <br clear="all">
            <div class="row">
                <div class="col-md-3">                                
                  <div class="form-group">
                      <label for="cat_name">Sell Business Listing Price</label>
                      <input type="text" class="form-control" value="<?php echo $siteSettings['sell_business_amount'] ?>" id="sell_business_amount" name="sell_business_amount">
                  </div>
                </div>
                <!--<div class="col-md-3">                                
                  <div class="form-group">
                      <label for="cat_name">Buy Business Commission</label>
                      <input type="text" class="form-control" value="<?php echo $siteSettings['buy_business_commission'] ?>" id="buy_business_commission" name="buy_business_commission">
                  </div>
                </div>-->
            </div>              
            <br clear="all">
            <br clear="all">

            <h4>Social Media info</h4>
            <br clear="all">
            <div class="row">
                <div class="col-md-3">                                
                  <div class="form-group">
                      <label for="cat_name">Facebook Link</label>
                      <input type="text" class="form-control" value="<?php echo $siteSettings['facebook_link'] ?>" id="facebook_link" name="facebook_link">
                  </div>
                </div>

                <div class="col-md-3">                                
                  <div class="form-group">
                      <label for="cat_name">Twitter Link</label>
                      <input type="text" class="form-control" value="<?php echo $siteSettings['twitter_link'] ?>" id="twitter_link" name="twitter_link">
                  </div>
                </div>

                <div class="col-md-3">                                
                  <div class="form-group">
                      <label for="cat_name">Linkedin Link</label>
                      <input type="text" class="form-control" value="<?php echo $siteSettings['instagram_link'] ?>" id="instagram_link" name="instagram_link">
                  </div>
                </div>

                <div class="col-md-3">                                
                  <div class="form-group">
                      <label for="cat_name">Youtube Link</label>
                      <input type="text" class="form-control" value="<?php echo $siteSettings['youtube_link'] ?>" id="youtube_link" name="youtube_link">
                  </div>
                </div>
            </div>

            <div class="box-footer">
            <?php
            if($editpermission)
            {
            ?>
              <input type="hidden" name="action" value="add">
              <input type="submit" name="submit" class="btn btn-primary" value="Submit" />
              <?php
            }
            ?>
            </div>
          </form>
        </div>
      </div>
    </div>    
    </div>
  </div>
</div>