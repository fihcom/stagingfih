<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url();?>administrator">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Process Sell Request</li>
      </ol>
      <?php $this->load->helper("form"); ?>
      <form role="form" id="siteSettings" action="<?php echo base_url(); ?>administrator/adminsitesettings/submit_sitesetting_form" method="post" role="form" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
      <div class="box_general padding_bottom site-setting-area">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="header_box version_2">
              <h2><i class="fa fa-file"></i>Monetization</h2>
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
              
                <div class="row">
                  <?php
                  if(is_array($monetization) && count($monetization)>0)
                  {
                    foreach($monetization as $val){
                      
                      ?>
                      <div class="col-md-3 monetization">                                
                        <div class="form-group labelWrap">
                            <input type="checkbox" value="<?php echo $val['slug'];?>" <?php echo (in_array($val['slug'],$tempdata['monetization'])) ? 'checked' : '' ?> /><label style="margin: 7px 0 0 8px;"><?php echo $val['name'];?></label>
                            
                        </div>
                      </div>
                      <?php
                    }
                  }
                  ?>

                    
                </div>
          </div>
        </div>
      </div>    
      </div>

    <div class="box_general padding_bottom site-setting-area">
      <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="header_box version_2">
            <h2><i class="fa fa-file"></i>Business Detail</h2>
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
            
              <div class="row">
              <div class="col-md-3">   
              <?php
                  if(is_array($tempdata['website']) && count($tempdata['website'])>0)
                  {
                    $i= 0;
                    foreach($tempdata['website'] as $val)
                    {
                      ?>
                      <div class="form-group">
                        <?php
                        if($i == 0)
                        {
                          ?><label for="cat_name">Website/Business URL(s)</label>
                          <?php
                        }
                      ?>
                      <input type="text" class="form-control" value="<?php echo $val?>" id="paypal_email" name="paypal_email">
                      </div>
                      <?php
                      $i++;
                    }
                  }
								?>                
                </div>
                <div class="col-md-3">   
                      <div class="form-group">
                        <label for="cat_name">Website/Business URL(s)</label>
                      <input type="date" class="form-control" name="startdate" id="startdate" placeholder="2020/10/21" value="<?php echo $tempdata['businessstartdate']?>"> 
                      </div>              
                </div>
                <div class="col-md-4">   
                      <div class="form-group">
                        <label for="cat_name">How many hours a week does it take to manage the business?</label>
                        <input type="text" class="form-control" name="workinghour" id="workinghour" placeholder="Write Here..." value="<?php echo $tempdata['workinghour']?>" />
                      </div>              
                </div>
                  
              </div>

              
        </div>
      </div>
      

      
    </div>
    </div>
    <div class="box_general padding_bottom site-setting-area">
      <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="header_box version_2">
            <h2><i class="fa fa-file"></i>Income Detail</h2>
          </div><!-- /.box-header -->
          <!-- form start -->
          
            <br clear="all">
              <div class="row">
              <div class="col-md-4">   
                      <div class="form-group">
                              <h6 class="subhead">What is the average revenue and avarage net profit for last month?</h6>
                              
                                <div class="row">
                                    <div class="col-sm-6">
                                      <input type="text" class="form-control" placeholder="Monthly Revenue" name="month3avgrevenue" id="month3avgrevenue" value="<?php echo $tempdata['month3avgrevenue']?>">
                                    </div>
                                    <div class="col-sm-6">
                                      <input type="text" class="form-control" placeholder="Monthly Profit" name="month3avgprofit" id="month3avgprofit" value="<?php echo $tempdata['month3avgprofit']?>">
                                    </div> 
                                  </div>
                            </div>
                </div>
                  <!-- <div class="col-md-4">
                            <div class="form-group">
                              <h6 class="subhead">What is the average revenue and avarage net profit (per month) over the last 6 months?</h6>
                              <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum aliquam velit risus, at fermentum mi ultrices vitae. Curabitur 
                                pellentesque suscipit arcu ut fermentum. </span>
                                  <div class="row">
                                    <div class="col-sm-6">
                                      <input type="text" class="form-control" placeholder="$ 0.00 ( average revenue )" name="month6avgrevenue" id="month6avgrevenue" value="<?php echo $tempdata['month6avgrevenue']?>">
                                    </div>
                                    <div class="col-sm-6">
                                      <input type="text" class="form-control" placeholder="$ 0.00 ( average profit  )" name="month6avgprofit" id="month6avgprofit" value="<?php echo $tempdata['month6avgprofit']?>">
                                    </div> 
                                </div>
                            </div>
                  </div> -->
                  <div class="col-md-4">
                            <div class="form-group">
                              <h6 class="subhead">What is the average revenue and avarage net profit (per month) over the trailing 12 months?</h6>
                              <!-- <span>Lorem ipsum dolor sit amet, consectetur adipiscing edivt. Vestibulum aliquam velit risus, at fermentum mi ultrices vitae. Curabitur 
                                pellentesque suscipit arcu ut fermentum. </span> -->
                                  <div class="row">
                                    <div class="col-sm-6">
                                      <input type="text" class="form-control" placeholder="Monthly Revenue" name="month12avgrevenue" id="month12avgrevenue" value="<?php echo $tempdata['month12avgrevenue']?>">
                                    </div>
                                    <div class="col-sm-6">
                                      <input type="text" class="form-control" placeholder="Monthly Profit" name="month12avgprofit" id="month12avgprofit" value="<?php echo $tempdata['month12avgprofit']?>">
                                    </div> 
                                  </div>
                            </div>
                    </div> 
                    <div class="col-md-4">
                            <div class="form-group">
                              <h6 class="subhead">What is the Average Monthly Customers?</h6>
                              
                                  <div class="row">
                                    <div class="col-sm-12">
                                      <input type="text" class="form-control" placeholder="Average Monthly Customers" name="month6avgrevenue" id="month6avgrevenue" value="<?php echo $tempdata['month6avgrevenue']?>">
                                    </div>
                                </div>
                            </div>
                  </div>

                    
                </div>
              </div>

        </div>
      </div>
    </div>
    <div class="box_general padding_bottom site-setting-area">
      <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="header_box version_2">
            <h2><i class="fa fa-file"></i>Tracking Info</h2>
          </div><!-- /.box-header -->
          <!-- form start -->
          
            <br clear="all">
              <div class="row">
              <div class="col-md-4">   
                      <div class="form-group">
                              <h6 class="subhead">Do you currently have either Google Analytics or clicky Installed?</h6>
                              <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum aliquam velit risus, at fermentum mi ultrices vitae. Curabitur pellentesque suscipit arcu ut fermentum. </span>
                                <div class="row">
                                    <div class="col-sm-6">
                                      <select class="form-control">
                                        <option <?php echo ($tempdata['trackingInfo'] =='Y') ? 'selected' : '';?>>Yes</option>
                                        <option <?php echo ($tempdata['trackingInfo'] =='N') ? 'selected' : '';?>>No</option>
                                        <option <?php echo ($tempdata['trackingInfo'] =='') ? 'selected' : '';?>>N/A</option>
                                      </select>
                                    </div> 
                                  </div>
                            </div>
                </div>
                  <div class="col-md-4">
                            <div class="form-group">
                              <h6 class="subhead">What was the first date Google Analytics or Clicky Was Added?</h6>
                              <span>Select the date your website first started using analytics.</span>
                                  <div class="row">
                                    <div class="col-sm-6">
                                    <input type="date" class="form-control" name="trackingaddeddate" id="trackingaddeddate" placeholder="2020/10/21" value="<?php echo $tempdata['trackingaddeddate']?>"> 
                                    </div>
                                </div>
                            </div>
                  </div>
                  <div class="col-md-4">
                            <div class="form-group">
                              <h6 class="subhead">If traffic known, what is the average monthly visitor amount?</h6>
                              <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum aliquam velit risus, at fermentum mi ultrices vitae. Curabitur pellentesque suscipit arcu ut fermentum. </span>
                                  <div class="row">
                                    <div class="col-sm-6">
                                    <input type="text" class="form-control" id="monthlyvisitor" placeholder="monthly  average visitor" value="<?php echo $tempdata['monthlyvisitor']?>">
                                    </div>
                                    
                                  </div>
                            </div>
                    </div> 

                    
                </div>
              </div>
        </div>
      </div>
    </div>
    <div class="box_general padding_bottom site-setting-area">
      <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="header_box version_2">
            <h2><i class="fa fa-file"></i>Extra Info</h2>
          </div><!-- /.box-header -->
          <!-- form start -->
          
            <br clear="all">
              <div class="row">
              <div class="col-md-12">   
                      <div class="form-group">
                              <h6 class="subhead">Briefly tell us about your business including anything special we may need to know</h6>
                              <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum aliquam velit risus, at fermentum mi ultrices vitae. Curabitur pellentesque suscipit arcu ut fermentum.</span>
                                <div class="row">
                                    <div class="col-sm-6">
                                    <textarea class="form-control" name="extraInfo" id="extraInfo" placeholder="2-3 sentence ( 0/1000 )"><?php echo $tempdata['extraInfo']?></textarea>
                                    </div> 
                                  </div>
                            </div>
                </div>
              </div>

              
        </div>
      </div>
    </div>
    </div>
    
    

    </form>

    </div>


    

  </div>
</div>