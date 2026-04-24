<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo base_url();?>administrator">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Process Sell Request</li>
    </ol>
    <?php
      if($storedData->Status == 2) {
        ?>
    <div class="modal fade" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="deleteModalLabel">Are you sure want to publish this sell?</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-footer">
            <form action="<?php echo base_url(); ?>administrator/sell/publishsell" method="post" id="delform">
              <input type="hidden" name="requestId" value="<?php echo $req_id; ?>" />
              <input type="hidden" name="approveId" value="<?php echo $storedData->id; ?>" />
              <input type="hidden" name="userId" value="<?php echo $storedData->userId; ?>" />
              <input type="hidden" name="action" value="publish" />
              <input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
              <button type="submit" class="btn btn-danger">Publish</button>
            </form>
            <button type="button" data-dismiss="modal" class="btn">Cancel</button>
          </div>
        </div>
      </div>
    </div>
        <?php
      } 
      if($storedData->Status == 1) {
        ?>
    <div class="modal fade" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="deleteModalLabel">Are you sure want to unpublish this sell?</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-footer">
            <form action="<?php echo base_url(); ?>administrator/sell/publishsell" method="post" id="delform">
              <input type="hidden" name="requestId" value="<?php echo $req_id; ?>" />
              <input type="hidden" name="approveId" value="<?php echo $storedData->id; ?>" />
              <input type="hidden" name="action" value="unpublish" />
              <input type="hidden" name="userId" value="<?php echo $storedData->userId; ?>" />
              <input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
              <button type="submit" class="btn btn-danger">Unpublish</button>
              
            </form>
            <button type="button" data-dismiss="modal" class="btn">Cancel</button>
          </div>
        </div>
      </div>
    </div>
        <?php
      }
      $this->load->helper("form");
      ?>
    <form role="form" id="siteSettings" action="<?php echo base_url(); ?>administrator/sell/add_sale" method="post" role="form" enctype="multipart/form-data">
      <input type="hidden" name="requestId" value="<?php echo $req_id; ?>"> 
      <div id="accordion">
        <!-- box1 -->
        <div class="box_general padding_bottom site-setting-area card"> 
          <div class="header_box version_2 collapsHeading" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            <h2><i class="fa fa-file"></i>Basic settings</h2>
            <?php
              if($storedData->Status == 2) {
                ?>
            <button type="button" class="btn-sm btn btn-warning pull-right" onclick="deleterecord(this)">Publish Sell</button>
                <?php
              } if($storedData->Status == 1) {
                ?>
            <a href="<?php echo base_url(); ?>listing/<?php echo $storedData->listing_id; ?>" class="btn btn-primary btn-sm pull-right" style="margin-left:10px;" target="_blank">Go to Listing</a>
            <button type="button" class="btn-sm btn btn-warning pull-right" onclick="deleterecord(this)">Unpublish Sell</button>
                <?php
              }
            ?>
          </div><!-- /.box-header -->
          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
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
                <?php 
                  if($storedData->id) {
                    ?>
                    <input type="hidden" name="approveId" value="<?php echo $storedData->id; ?>" />
                    <input type="hidden" name="action" value="edit" />
                    <?php
                  } else {
                    ?>
                    <input type="hidden" name="action" value="add" />
                    <?php
                  }
                ?>
                      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                      <div class="row">
                        <div class="col-md-12">
                            <div class="header_box version_2 mb-3">
                              <h2>Monetization</h2>
                            </div>
                          </div> 
                          <div class="row">
                            <?php
                            if(is_array($monetization) && count($monetization)>0)
                            {
                              foreach($monetization as $val){
                                
                                ?>
                                <div class="col-md-3 monetization">                                
                                  <div class="form-group labelWrap">
                                      <input type="checkbox" name="monetization[]" value="<?php echo $val['slug'];?>" <?php echo (in_array($val['slug'],$tempdata['monetization'])) ? 'checked' : '' ?> /><label style="margin: 7px 0 0 8px;"><?php echo $val['name'];?></label>
                                      
                                  </div>
                                </div>
                                <?php
                              }
                            }
                            ?>  
                          </div>
                        </div> 
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <input type="submit" value="Save Changes" class="btn-sm btn btn-primary pull-right">
                        </div>
                      </div>
                  </div>
                    
        </div>
        
        <!-- box2 -->
        <div class="box_general padding_bottom site-setting-area card"> 
            <div class="header_box version_2 collapsHeading collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              <h2><i class="fa fa-file"></i>Business Detail</h2>
            </div><!-- /.box-header -->

            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
              <div class="card-body">
                <!-- form start -->
                <br clear="all">
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
                          <input type="text" class="form-control" value="<?php echo $val?>" id="website_url" name="website_url[]">
                          </div>
                          <?php
                          $i++;
                        }
                      }
                    ?>                
                    </div>
                    
                    <div class="col-md-4">   
                          <div class="form-group">
                            <label for="cat_name">How many hours a week does it take to manage the business?</label>
                            <input type="text" class="form-control" name="workinghour" id="workinghour" placeholder="Total hours work" value="<?php echo $tempdata['workinghour']?>" />
                          </div>              
                    </div>
                      <div class="col-md-4">   
                          <div class="form-group">
                            <label for="cat_name">Industry</label>
                            <select class="form-control" name="industry">
                            
                            <?php
                            if(is_array($industries) && count($industries)>0)
                            {
                              foreach($industries as $k=>$val)
                              {
                                ?>
                                <option value="<?php echo $val['id']?>" <?php echo ($val['id'] == $storedData->industry) ? 'selected': '';?>><?php echo $val['industry']?></option>
                                <?php
                              }
                            }
                            ?>
                            </select>
                          </div>              
                    </div>
                    
                  </div>
                  <div class="row">
                    <div class="col-md-12">   
                          <div class="form-group">
                            <label for="cat_name">Google drive folder link</label>
                            <input type="text" class="form-control" name="googleDrive" id="googleDrive" placeholder="Google drive folder link" value="<?php echo $storedData->google_drive_link?>" />
                          </div>              
                    </div>
                    <div class="col-md-12">   
                          <div class="form-group">
                            <label for="cat_name">Profit & Loss link</label>
                            <input type="text" class="form-control" name="pl_link" id="pl_link" placeholder="Profit & Loss Link" value="<?php echo $storedData->pl_link?>" />
                          </div>              
                    </div>
                    <div class="col-md-8">   
                          <div class="form-group">
                            <label for="cat_name">Business location</label>
                            
                            <textarea class="form-control" name="businessLocation" id="" cols="30" rows="1"><?php echo $storedData->businesslocation?></textarea>
                          </div>              
                    </div>
                    <div class="col-md-4">   
                          <div class="form-group">
                            <label for="cat_name">Country</label>
                            
                            <select class="form-control" name="country">
                            <?php
                          if(is_array($countries) && count($countries)>0)
                          {
                            foreach($countries as $k=>$val)
                            {
                              ?>
                              <option value="<?php echo $val['id']?>" <?php echo ($val['id'] == $storedData->country) ? 'selected': '';?>><?php echo $val['name']?></option>
                              <?php
                            }
                          }
                          ?>
                            </select>
                          </div>              
                    </div>
                    <div class="col-md-4">   
                      <div class="form-group">
                          <label for="cat_name">Business Image</label><br clear="all">
                          <input type="file" name="businessImage" id="browseImage" style="display:none" onchange="readURL(this);">
                          <?php
                          if($storedData->business_image !='')
                          {
                            $imagePath = 'uploads/business_image/'.$storedData->business_image;
                          }else{
                            $imagePath = 'assets/backend/img/image-placeholder-icon.png';
                          }
                          ?>
                          <img id="blah" style="width: 150px;height: 119px;" src="<?php echo base_url().$imagePath;?>" alt="your image" />
                          
                      </div>
                    </div>
                    <div class="col-md-8"></div>
                    <div class="col-md-4">                                
                      <div class="form-group">
                        <input type="button" name="submit" class="btn btn-primary" id="browsebtn" value="Browse" />
                      </div>
                    </div>
                  </div> 
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <input type="submit" value="Save Changes" class="btn-sm btn btn-primary pull-right">
                  </div>
                </div> 
            </div>

        </div>
            
        <!-- box3 -->
        <div class="box_general padding_bottom site-setting-area card"> 
            <div class="header_box version_2 collapsHeading collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              <h2><i class="fa fa-file"></i>Pricing</h2>
            </div><!-- /.box-header -->
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
              <div class="card-body">
                <!-- form start --> 
                <br clear="all">
                <div class="row">
                    <div class="col-md-6">   
                        <div class="form-group">
                          <label for="cat_name">Revenue Multiple <!-- Cashflow Volatility --> </label>
                            <input type="text" class="form-control" name="pricingperiod" id="pricingperiod" placeholder="Cashflow Volatility" value="<?php echo $storedData->pricing_period?>"><!-- % -->
                        </div>
                    </div>
                    <div class="col-md-6">   
                      <div class="form-group">
                        <label for="cat_name">Price</label>
                          <input type="text" class="form-control" name="price" id="price" placeholder="Price" value="<?php echo $storedData->price?>">
                      </div>
                    </div>
                    <div class="col-md-6">   
                            <div class="form-group">
                              <label for="cat_name">Monthly Revenue</label>
                                <input type="text" class="form-control" name="monthly_revenue" id="monthly_revenue" placeholder="Monthly Revenue" value="<?php echo $storedData->monthly_revenue?>">
                            </div>
                    </div>
                    <div class="col-md-6">   
                            <div class="form-group">
                              <label for="cat_name">Monthly Profit</label>
                                <input type="text" class="form-control" name="monthly_profit" id="monthly_profit" placeholder="Monthly Profit" value="<?php echo $storedData->monthly_profit?>">
                            </div>
                    </div>
                    <div class="col-md-6">   
                            <div class="form-group">
                              <label for="cat_name">Profit Multiple <!-- Yield --></label>
                                <input type="text" class="form-control" name="multiple" id="multiple" placeholder="Profit Multiple" value="<?php echo $storedData->multiple?>">
                            </div>
                    </div>
                    <div class="col-md-6">   
                            <div class="form-group">
                              <label for="cat_name">Listing #</label>
                                <input type="text" class="form-control" name=""  placeholder="Listing #" disabled value="#<?php echo $storedData->listing_id?>">
                            </div>
                    </div>
                </div> 
                <div class="row">
                  <div class="col-md-12">
                    <input type="submit" value="Save Changes" class="btn-sm btn btn-primary pull-right">
                  </div>
                </div> 
              </div>
            </div>
        </div> 
        <!-- box4 -->
        <div class="box_general padding_bottom site-setting-area card"> 
            <div class="header_box version_2 collapsHeading collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
              <h2><i class="fa fa-file"></i>Listing Summary</h2>
            </div><!-- /.box-header -->
            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                <div class="card-body">
                      <!-- form start --> 
                    <br clear="all">
                    <div class="row">
                      <div class="col-md-12">   
                        <div class="form-group">
                          <label for="cat_name">Summary</label>
                          <textarea class="form-control ckeditor" name="listingSummery" id="listingSummery"><?php echo $storedData->summery?></textarea>
                        </div>
                      </div> 
                    </div>   
                    <div class="row">
                      <div class="col-md-12">
                        <input type="submit" value="Save Changes" class="btn-sm btn btn-primary pull-right">
                      </div> 
                    </div>
                </div>
            </div>
        </div>

        <!-- box5 -->
        <div class="box_general padding_bottom site-setting-area card"> 
              <div class="header_box version_2 collapsHeading collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                <h2><i class="fa fa-file"></i>Description</h2>
              </div><!-- /.box-header -->

              <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                <div class="card-body">
                      <div class="header_box version_2">
                        <h2>Business create date</h2>
                      </div><!-- /.box-header -->

                      <br clear="all">
                      <div class="row">
                        <div class="col-md-12">   
                          <div class="form-group">
                            <label for="cat_name">Date</label>
                            <input type="date" class="form-control" name="startdate" id="startdate" placeholder="2020/10/21" value="<?php echo $tempdata['businessstartdate']?>"> 
                          </div>              
                        </div>
                      </div>

                      <div class="header_box version_2">
                        <h2>List of assets</h2>
                      </div><!-- /.box-header -->
                      <!-- form start -->
                    
                      <br clear="all">
                      <div class="row listassets">
                          <?php

                            if(is_array($assets) && count($assets)>0)
                            {
                              foreach($assets as $k=>$val){
                                
                                ?>
                                <div class="col-md-12 monetization">                                
                                  <div class="form-group labelWrap">
                                      <input type="checkbox" name="asset_description[]" value="<?php echo $val['id'];?>" <?php echo (array_key_exists($val['id'],$addedassets)) ? 'checked' : '';?> /><label style="margin: 7px 0 0 8px;"><input type="text" class="form-control" name="AssetDescriptiontxt[<?php echo $val['id']?>]" value="<?php echo (array_key_exists($val['id'],$addedassets)) ? $addedassets[$val['id']] : $val['asset_description'];?>"></label>
                                      
                                  </div>
                                </div>
                                <?php
                              }
                            }
                          ?>
                          <div class="col-md-12 monetization">                                
                                <div class="form-group labelWrap">
                                    <input type="checkbox" value="<?php echo $val['asset_description'];?>" /><label style="margin: 7px 0 0 8px;">Extra Assets</label>
                                    <textarea name="otherAssets" style="margin: 7px 0 0 8px;" class="form-control extra-assets-textarea" name="" id="" cols="30" rows="10"><?php echo $extraassets?></textarea>
                                    
                                </div>
                          </div>
                          <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                              <div class="header_box version_2">
                                <h2>BRAG Rating</h2>
                              </div><!-- /.box-header -->
                              <!-- form start -->
                              
                                <br clear="all">
                                  <div class="row">
                                      <div class="col-md-3">                                
                                            <div class="form-group labelWrap">
                                                <label style="margin: 7px 0 0 8px;">Brand Reputation</label>
                                                <input type="text" class="form-control" name="brand_reputation" id="brand_reputation" placeholder="Brand Reputation" value="<?php echo $storedData->brand_reputation?>"><span class="right-number">/2.5</span>
                                            </div>
                                      </div>
                                      <div class="col-md-3">                                
                                            <div class="form-group labelWrap">
                                                <label style="margin: 7px 0 0 8px;">Risk Profile</label>
                                                <input type="text" class="form-control" name="risk_profile" id="risk_profile" placeholder="Risk Profile" value="<?php echo $storedData->risk_profile?>"><span class="right-number">/2.5</span>
                                            </div>
                                      </div>
                                      <div class="col-md-3">                                
                                            <div class="form-group labelWrap">
                                                <label style="margin: 7px 0 0 8px;">Asset Value</label>
                                                <input type="text" class="form-control" name="asset_value" id="asset_value" placeholder="Asset Value" value="<?php echo $storedData->asset_value?>"><span class="right-number">/2.5</span>
                                            </div>
                                      </div>
                                      <div class="col-md-3">                                
                                            <div class="form-group labelWrap">
                                                <label style="margin: 7px 0 0 8px;">Growth Potential</label>
                                                <input type="text" class="form-control" name="growth_potential" id="growth_potential" placeholder="Growth Potential" value="<?php echo $storedData->growth_potential?>"><span class="right-number">/2.5</span>
                                            </div>
                                      </div>
                                  </div>

                                  
                            </div>
                          </div>
                          <div class="col-md-12">  
                            <div class="header_box version_2">
                              <h2>Youtube Videos</h2>
                          </div><!-- /.box-header -->
                          <br clear="all">
                          <div class="row">
                                <div class="col-md-12" id="youtubepane">    
                                              <div class="form-group">
                                              <?php
                                              if($storedData->youtube_url !='')
                                              {
                                                $youtube_url = json_decode($storedData->youtube_url);
                                              }
                                              ?>
                                                <label for="cat_name">URL</label>
                                                <input type="text" class="form-control" name="youtube_url[]" placeholder="Youtube Video URL" value="<?php echo $youtube_url[0]?>">
                                              </div>
                                              <?php
                                              if(count($youtube_url) >1)
                                              {
                                                $k=1;
                                                while($youtube_url[$k])
                                                {
                                                  ?>
                                                  <div class="form-group">
                                                    <input type="text" class="form-control" name="youtube_url[]" placeholder="Youtube Video URL" value="<?php echo $youtube_url[$k]?>">
                                                  </div>
                                                  <?php
                                                  $k++;
                                                }
                                              }
                                              ?>
                                              
                                </div>
                          
                          </div>
                          <div class="row">
                                            <div class="col-md-6">                                
                                                      <div class="form-group labelWrap">
                                                      <a href="javascript: void(0)" id="addmoreytvideo" class="btn-sm btn btn-primary" style="margin-top:5px"><i class="fa fa-plus" aria-hidden="true"></i>Add More video</a>
                                                      </div>
                                                </div>
                                                </div>

                                          </div>
                                            <div class="col-md-12">
                              <input type="submit" value="Save Changes" class="btn-sm btn btn-primary pull-right">
                              </div>
                          </div> 
                      </div> 
              </div>
        </div>
      
        <!-- box6 -->
        <div class="box_general padding_bottom site-setting-area card"> 
          <div class="header_box version_2 collapsHeading collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
            <h2><i class="fa fa-file"></i>Extra Section</h2>
          </div><!-- /.box-header -->
          <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
            <div class="card-body">
                <!-- form start --> 
                <div class="row">
                  <div class="col-md-12"> 
                      <div class="header_box version_2">
                        <h2>Reasons for sale</h2>
                      </div>
                  </div>
                  <br clear="all">
                  <div class="col-md-12">                                
                      <div class="form-group labelWrap">
                          <textarea name="reason_for_sale"  class="ckeditor" style="width:100%" rows="5"><?php echo $storedData->reason_for_sale?></textarea>
                      </div>
                  </div>
                  <div class="col-md-12"> 
                    <div class="header_box version_2">
                      <h2>Seller Support Includes</h2>
                    </div>
                  </div>
                  <br clear="all">
                  <div class="col-md-12">                                
                      <div class="form-group labelWrap">
                          <textarea name="support_seller_included"  class="ckeditor" style="width:100%" rows="5"><?php echo $storedData->support_seller_included?></textarea>
                      </div>
                  </div>
                  <div class="col-md-12"> 
                    <div class="header_box version_2">
                      <h2>Other information</h2>
                    </div>
                  </div>
                  <br clear="all">
                  <div class="col-md-12">
                      <div class="form-group labelWrap">
                        <label style="margin: 7px 0 0 8px;">Description</label>
                        <textarea name="other_info_description" class="ckeditor"  style="width:100%" rows="5"><?php echo $storedData->other_info_description?></textarea>
                      </div> 
                  </div>
                  <div class="col-md-12">                                
                      <div class="form-group labelWrap">
                          <label style="margin: 7px 0 0 8px;"></label>
                          <?php
                          if($storedData->other_info !='')
                          {
                            $otherInfo = json_decode($storedData->other_info);
                          }
                          //print '<pre>';
                          //print_r($otherInfo);
                          ?>
                          <div class="row" style="background-color:#f8f8f8" id="lastotheroption">
                              <div class="col-md-6">                                
                                    <div class="form-group labelWrap">
                                        <label style="margin: 7px 0 0 8px;">Title</label>
                                        <input type="text" class="form-control" name="Title[]"  placeholder="Title" value="<?php echo $otherInfo[0]->title;?>">
                                    </div>
                              </div>
                              <div class="col-md-6">                                
                                    <div class="form-group labelWrap">
                                        <label style="margin: 7px 0 0 8px;">Value</label>
                                        <input type="text" class="form-control" name="value[]"  placeholder="Value" value="<?php echo $otherInfo[0]->value;?>">
                                    </div>
                              </div>
                              <div class="col-md-6">                                
                                    <div class="form-group labelWrap">
                                        <label style="margin: 7px 0 0 8px;">Title</label>
                                        <input type="text" class="form-control" name="Title[]"  placeholder="Title" value="<?php echo $otherInfo[1]->title;?>">
                                    </div>
                              </div>
                              <div class="col-md-6">                                
                                    <div class="form-group labelWrap">
                                        <label style="margin: 7px 0 0 8px;">Value</label>
                                        <input type="text" class="form-control" name="value[]"  placeholder="Value" value="<?php echo $otherInfo[1]->value;?>">
                                    </div>
                              </div>
                              <div class="col-md-6">                                
                                    <div class="form-group labelWrap">
                                        <label style="margin: 7px 0 0 8px;">Title</label>
                                        <input type="text" class="form-control" name="Title[]"  placeholder="Title" value="<?php echo $otherInfo[2]->title;?>">
                                    </div>
                              </div>
                              <div class="col-md-6">                                
                                    <div class="form-group labelWrap">
                                        <label style="margin: 7px 0 0 8px;">Value</label>
                                        <input type="text" class="form-control" name="value[]"  placeholder="Value" value="<?php echo $otherInfo[2]->value;?>">
                                    </div>
                              </div>
                              <div class="col-md-6">                                
                                    <div class="form-group labelWrap">
                                        <label style="margin: 7px 0 0 8px;">Title</label>
                                        <input type="text" class="form-control" name="Title[]"  placeholder="Title" value="<?php echo $otherInfo[3]->title;?>">
                                    </div>
                              </div>
                              <div class="col-md-6">                                
                                    <div class="form-group labelWrap">
                                        <label style="margin: 7px 0 0 8px;">Value</label>
                                        <input type="text" class="form-control" name="value[]"  placeholder="Value" value="<?php echo $otherInfo[3]->value;?>">
                                    </div>
                              </div>
                              <?php
                              if(count($otherInfo)>4)
                              {
                                $i=4;
                                while($otherInfo[$i])
                                {
                                  ?>
                                  <div class="col-md-6">                                
                                    <div class="form-group labelWrap">
                                        <label style="margin: 7px 0 0 8px;">Title</label>
                                        <input type="text" class="form-control" name="Title[]"  placeholder="Title" value="<?php echo $otherInfo[$i]->title;?>">
                                    </div>
                                  </div>
                                  <div class="col-md-6">                                
                                        <div class="form-group labelWrap">
                                            <label style="margin: 7px 0 0 8px;">Value</label>
                                            <input type="text" class="form-control" name="value[]"  placeholder="Value" value="<?php echo $otherInfo[$i]->value;?>">
                                        </div>
                                  </div>
                                  <?php
                                  $i++;
                                }
                                
                              }
                              ?>

                          </div>
                          <div class="row">
                              <div class="col-md-6">                                
                                    <div class="form-group labelWrap">
                                      <a href="javascript: void(0)" id="addmoreotherinfo" class="btn-sm btn btn-primary" style="margin-top:5px"><i class="fa fa-plus" aria-hidden="true"></i>Add More</a>
                                    </div>
                              </div>
                          </div>
                      </div>
                  </div>              
                  <div class="col-md-12"> 
                      <div class="header_box version_2">
                        <h2>Buyer Profile</h2>
                      </div>
                  </div>
                  <br clear="all">
                  <div class="col-md-12">
                    <div class="form-group labelWrap">
                      <label style="margin: 7px 0 0 8px;">Description</label>
                        <textarea name="buyer_profile_description" class="ckeditor"  style="width:100%" rows="5"><?php echo $storedData->buyer_profile_description?></textarea>
                    </div> 
                  </div>
                  <div class="col-md-12">                                
                      <div class="form-group labelWrap">
                          <label style="margin: 7px 0 0 8px;"></label>
                          <?php
                          if($storedData->buyer_profile !='')
                          {
                            $buyerprofile = json_decode($storedData->buyer_profile);
                          }
                          //print '<pre>';
                          //print_r($otherInfo);
                          ?>
                          <div class="row" style="background-color:#f8f8f8" id="lastbuyerprofile">
                              <div class="col-md-6">                                
                                    <div class="form-group labelWrap">
                                        <label style="margin: 7px 0 0 8px;">Title</label>
                                        <input type="text" class="form-control" name="buyerTitle[]"  placeholder="Title" value="<?php echo $buyerprofile[0]->title;?>">
                                    </div>
                              </div>
                              <div class="col-md-6">                                
                                    <div class="form-group labelWrap">
                                        <label style="margin: 7px 0 0 8px;">Value</label>
                                        <input type="text" class="form-control" name="buyervalue[]"  placeholder="Value" value="<?php echo $buyerprofile[0]->value;?>">
                                    </div>
                              </div>
                              <div class="col-md-6">                                
                                    <div class="form-group labelWrap">
                                        <label style="margin: 7px 0 0 8px;">Title</label>
                                        <input type="text" class="form-control" name="buyerTitle[]"  placeholder="Title" value="<?php echo $buyerprofile[1]->title;?>">
                                    </div>
                              </div>
                              <div class="col-md-6">                                
                                    <div class="form-group labelWrap">
                                        <label style="margin: 7px 0 0 8px;">Value</label>
                                        <input type="text" class="form-control" name="buyervalue[]"  placeholder="Value" value="<?php echo $buyerprofile[1]->value;?>">
                                    </div>
                              </div>
                              <div class="col-md-6">                                
                                    <div class="form-group labelWrap">
                                        <label style="margin: 7px 0 0 8px;">Title</label>
                                        <input type="text" class="form-control" name="buyerTitle[]"  placeholder="Title" value="<?php echo $buyerprofile[2]->title;?>">
                                    </div>
                              </div>
                              <div class="col-md-6">                                
                                    <div class="form-group labelWrap">
                                        <label style="margin: 7px 0 0 8px;">Value</label>
                                        <input type="text" class="form-control" name="buyervalue[]"  placeholder="Value" value="<?php echo $buyerprofile[2]->value;?>">
                                    </div>
                              </div>
                              <div class="col-md-6">                                
                                    <div class="form-group labelWrap">
                                        <label style="margin: 7px 0 0 8px;">Title</label>
                                        <input type="text" class="form-control" name="buyerTitle[]"  placeholder="Title" value="<?php echo $buyerprofile[3]->title;?>">
                                    </div>
                              </div>
                              <div class="col-md-6">                                
                                    <div class="form-group labelWrap">
                                        <label style="margin: 7px 0 0 8px;">Value</label>
                                        <input type="text" class="form-control" name="buyervalue[]"  placeholder="Value" value="<?php echo $buyerprofile[3]->value;?>">
                                    </div>
                              </div>
                              <?php
                              if(count($buyerprofile)>4)
                              {
                                $g=4;
                                while($buyerprofile[$g])
                                {
                                  ?>
                                  <div class="col-md-6">                                
                                    <div class="form-group labelWrap">
                                        <label style="margin: 7px 0 0 8px;">Title</label>
                                        <input type="text" class="form-control" name="buyerTitle[]"  placeholder="Title" value="<?php echo $buyerprofile[$g]->title;?>">
                                    </div>
                                  </div>
                                  <div class="col-md-6">                                
                                        <div class="form-group labelWrap">
                                            <label style="margin: 7px 0 0 8px;">Value</label>
                                            <input type="text" class="form-control" name="buyervalue[]"  placeholder="Value" value="<?php echo $buyerprofile[$g]->value;?>">
                                        </div>
                                  </div>
                                  <?php
                                  $g++;
                                }
                                
                              }
                              ?>

                              

                          </div>
                          <div class="row">
                              <div class="col-md-6">                                
                                  <div class="form-group labelWrap">
                                    <a href="javascript: void(0)" id="addmorebuyerprofile" class="btn-sm btn btn-primary" style="margin-top:5px"><i class="fa fa-plus" aria-hidden="true"></i>Add More</a>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="col-md-12"> 
                      <div class="header_box version_2">
                        <h2>Social Media Channels</h2>
                      </div>
                  </div>
                  <br clear="all">
                  <div class="col-md-12">                                
                      <div class="form-group labelWrap"> 
                        <div class="row" id="socialmedialinks">
                            <div class="col-md-4">                                
                                      <div class="form-group labelWrap">
                                      <label style="margin: 7px 0 0 8px;">Facebook</label>
                                          <input type="text" class="form-control" name="fb_link"  placeholder="Facebook" value="<?php echo $storedData->fb_link?>">
                                      </div>
                            </div>
                            <div class="col-md-4">                                
                                      <div class="form-group labelWrap">
                                      <label style="margin: 7px 0 0 8px;">Twitter</label>
                                          <input type="text" class="form-control" name="twitter_link"  placeholder="Twitter" value="<?php echo $storedData->twitter_link?>">
                                      </div>
                            </div>
                            <div class="col-md-4">                                
                                      <div class="form-group labelWrap">
                                      <label style="margin: 7px 0 0 8px;">Instagram</label>
                                          <input type="text" class="form-control" name="insta_link"  placeholder="Instagram" value="<?php echo $storedData->insta_link?>">
                                      </div>
                            </div>
                            <div class="col-md-4">                                
                                      <div class="form-group labelWrap">
                                      <label style="margin: 7px 0 0 8px;">Youtube</label>
                                          <input type="text" class="form-control" name="youtube_link"  placeholder="Youtube" value="<?php echo $storedData->youtube_link?>">
                                      </div>
                            </div>
                            <div class="col-md-4">                                
                                      <div class="form-group labelWrap">
                                      <label style="margin: 7px 0 0 8px;">Pinterest</label>
                                          <input type="text" class="form-control" name="pinterest_link"  placeholder="Pinterest" value="<?php echo $storedData->pinterest_link?>">
                                      </div>
                            </div>
                            <div class="col-md-4">                                
                                      <div class="form-group labelWrap">
                                      <label style="margin: 7px 0 0 8px;">Linkedin</label>
                                          <input type="text" class="form-control" name="linkedin_link"  placeholder="LinkedIn" value="<?php echo $storedData->linkedin_link?>">
                                      </div>
                            </div>
                            <?php
                          if($storedData->extrasocialmedia !='')
                          {
                            $extrasocialmedia = json_decode($storedData->extrasocialmedia);
                          }
                              if(count($extrasocialmedia)>0)
                              {
                                $ss=0;
                                while($extrasocialmedia[$ss])
                                {
                                  ?>
                                  <div class="col-md-4">                                
                                      <div class="form-group labelWrap">
                                      <label style="margin: 7px 0 0 8px;">Extra Social Media</label>
                                          <input type="text" class="form-control" name="extrasocialmedia[]"  placeholder="Social Media" value="<?php echo $extrasocialmedia[$ss]?>">
                                      </div>
                                  </div>
                                  <?php
                                  $ss++;
                                }
                                
                              }
                              ?>
                        </div>
                        <div class="row">
                          <div class="col-md-6">                                
                                  <div class="form-group labelWrap">
                                  <a href="javascript: void(0)" id="addmoresocialmedia" class="btn-sm btn btn-primary" style="margin-top:5px"><i class="fa fa-plus" aria-hidden="true"></i>Add More</a>
                                  </div>
                          </div>
                        </div>
                      </div>
                  </div> 
                  <div class="col-md-12"> 
                    <div class="header_box version_2">
                      <h2>Work & Skills Required</h2>
                    </div>
                  </div>
                  <div class="col-md-12">
                      <div class="form-group labelWrap">
                        <label style="margin: 7px 0 0 8px;">Description</label>
                                  <textarea name="skill_description" class="ckeditor"  style="width:100%" rows="3"><?php echo $storedData->skill_description?></textarea>
                      </div>
                  </div>
                  <div class="col-md-12">                                
                    <div class="form-group labelWrap">
                      <?php
                        if($storedData->skills !='') {
                          $skills = json_decode($storedData->skills);
                        }
                      ?>
                      <div class="row" id="worlskillpane">
                        <div class="col-md-4">                                
                          <div class="form-group labelWrap">
                            <input type="text" class="form-control" name="skill[]" placeholder="Work & Skills" value="<?php echo $skills[0]; ?>" />
                          </div>
                        </div>
                        <div class="col-md-4">                                
                          <div class="form-group labelWrap">
                            <input type="text" class="form-control" name="skill[]" placeholder="Work & Skills" value="<?php echo $skills[1]; ?>" />
                          </div>
                        </div>
                        <div class="col-md-4">                                
                          <div class="form-group labelWrap">
                            <input type="text" class="form-control" name="skill[]" placeholder="Work & Skills" value="<?php echo $skills[2]; ?>" />
                          </div>
                        </div>
                        <?php
                        if(count($skills)>3) {
                          $sk=3;
                          while($skills[$sk]) {
                            ?>
                            <div class="col-md-4">                                
                              <div class="form-group labelWrap">
                                <input type="text" class="form-control" name="skill[]"  placeholder="Work & Skills" value="<?php echo $skills[$sk]?>">
                              </div>
                            </div>
                            <?php
                            $sk++;
                          }

                        }
                        ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12"> 
                    <div class="row">
                      <div class="col-md-6">                                
                        <div class="form-group labelWrap">
                          <a href="javascript:void(0);" id="addmoreskill" class="btn-sm btn btn-primary" style="margin-top:5px"><i class="fa fa-plus" aria-hidden="true"></i>Add More</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br clear="all">
                  <div class="col-md-12">
                    <input type="submit" value="Save Changes" class="btn-sm btn btn-primary pull-right">
                  </div>   
                </div>
            </div>
          </div> 
        </div>

        <!-- box7 -->
        <div class="box_general padding_bottom site-setting-area card"> 
            <div class="header_box version_2 collapsHeading collapsed" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
              <h2><i class="fa fa-file"></i>Analytics</h2>
            </div><!-- /.box-header -->
            <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordion">
              <div class="card-body">
                <!-- form start -->
                <div class="row">
                  <div class="col-md-12"> 
                      <div class="header_box version_2">
                        <h2>SEO Data</h2>
                      </div>
                  </div>
                  <br clear="all">
                  <div class="col-md-12">                                
                        <div class="form-group labelWrap">
                            <label style="margin: 7px 0 0 8px;"></label>
                            <?php
                            if($storedData->seo_data !='') {
                              $seodata = json_decode($storedData->seo_data);
                            }
                            //print '<pre>';
                            //print_r($seodata);
                            ?>
                            <div class="row" style="background-color:#f8f8f8" id="lastseodata">
                              <div class="col-md-6">                                
                                <div class="form-group labelWrap">
                                  <label style="margin: 7px 0 0 8px;">Title</label>
                                  <input type="text" class="form-control" name="seoTitle[]"  placeholder="Title" value="<?php echo $seodata[0]->title;?>">
                                </div>
                              </div>
                                <div class="col-md-6">                                
                                  <div class="form-group labelWrap">
                                    <label style="margin: 7px 0 0 8px;">Value</label>
                                    <input type="text" class="form-control" name="seoValue[]"  placeholder="Value" value="<?php echo $seodata[0]->value;?>">
                                  </div>
                                </div>
                                <div class="col-md-6">                                
                                  <div class="form-group labelWrap">
                                    <label style="margin: 7px 0 0 8px;">Title</label>
                                    <input type="text" class="form-control" name="seoTitle[]"  placeholder="Title" value="<?php echo $seodata[1]->title;?>">
                                  </div>
                                </div>
                                <div class="col-md-6">                                
                                  <div class="form-group labelWrap">
                                    <label style="margin: 7px 0 0 8px;">Value</label>
                                    <input type="text" class="form-control" name="seoValue[]"  placeholder="Value" value="<?php echo $seodata[1]->value;?>">
                                  </div>
                                </div>
                                <div class="col-md-6">                                
                                  <div class="form-group labelWrap">
                                    <label style="margin: 7px 0 0 8px;">Title</label>
                                    <input type="text" class="form-control" name="seoTitle[]"  placeholder="Title" value="<?php echo $seodata[2]->title;?>">
                                  </div>
                                </div>
                                <div class="col-md-6">                                
                                  <div class="form-group labelWrap">
                                    <label style="margin: 7px 0 0 8px;">Value</label>
                                    <input type="text" class="form-control" name="seoValue[]"  placeholder="Value" value="<?php echo $seodata[2]->value;?>">
                                  </div>
                                </div>
                                <div class="col-md-6">                                
                                  <div class="form-group labelWrap">
                                    <label style="margin: 7px 0 0 8px;">Title</label>
                                    <input type="text" class="form-control" name="seoTitle[]"  placeholder="Title" value="<?php echo $seodata[3]->title;?>">
                                  </div>
                                </div>
                                <div class="col-md-6">                                
                                  <div class="form-group labelWrap">
                                    <label style="margin: 7px 0 0 8px;">Value</label>
                                    <input type="text" class="form-control" name="seoValue[]"  placeholder="Value" value="<?php echo $seodata[3]->value;?>">
                                  </div>
                                </div>
                                  <?php
                                  if(count($seodata)>4) {
                                    $s=4;
                                    while($seodata[$s]) {
                                      ?>
                                      <div class="col-md-6">                                
                                        <div class="form-group labelWrap">
                                            <label style="margin: 7px 0 0 8px;">Title</label>
                                            <input type="text" class="form-control" name="seoTitle[]"  placeholder="Title" value="<?php echo $seodata[$s]->title;?>">
                                        </div>
                                      </div>
                                      <div class="col-md-6">                                
                                            <div class="form-group labelWrap">
                                                <label style="margin: 7px 0 0 8px;">Value</label>
                                                <input type="text" class="form-control" name="seoValue[]"  placeholder="Value" value="<?php echo $seodata[$s]->value;?>">
                                            </div>
                                      </div>
                                      <?php
                                      $s++;
                                    }
                                    
                                  }
                                  ?>

                                

                            </div>
                            <div class="row">
                              <div class="col-md-6">                                
                                  <div class="form-group labelWrap">
                                    <a href="javascript: void(0)" id="addmoreseodata" class="btn-sm btn btn-primary" style="margin-top:5px"><i class="fa fa-plus" aria-hidden="true"></i>Add More</a>
                                  </div>
                            </div> 
                        </div>
                  </div>
                        
                    
                  </div>

                          
                   
                  <div class="col-md-12"> 
                      <div class="header_box version_2">
                        <h2>CSV Upload</h2> 
                        
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">                                
                      <div class="form-group labelWrap">
                        <input type="file" name="uploadcsv" id="uploadcsv"  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                        <br><input type="button" name="submit" class="btn btn-sm btn-primary" id="browsebtn" value="Upload" onclick="javascript: document.getElementById('uploadcsv').click()" />
                        <a class="btn btn-warning btn-sm" style="float:right; margin-left:10px;" href="<?php echo base_url();?>assets/frontend/analytics_format.csv">Download CSV format</a>
                        <?php
                        if($storedData->id>0)
                        {
                          ?>
                          <a class="btn btn-secondary btn-sm" style="float:right; margin-left:10px;" href="javascript: void(0)" data-listid="<?php echo $this->uri->segment(4);?>" id="cleananalytics">Clean Analytics Data</a>
                          <?php
                        }
                        ?>
                          
                        <a class="btn btn-info btn-sm" style="float:right; margin-left:10px;" href="javascript: void(0)" data-listid="<?php echo $this->uri->segment(4);?>" id="exportcsvbtn">Export Analytics</a>
                        
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <input type="submit" value="Save Changes" class="btn-sm btn btn-primary pull-right">
                  </div> 
                </div>  
              </div>
            </div> 
        </div> 

        <!-- box8 -->
        <div class="box_general padding_bottom site-setting-area card">
          <div class="header_box version_2 collapsHeading collapsed" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
            <h2><i class="fa fa-file"></i>SWOT Analysis</h2>
          </div><!-- /.box-header -->
          <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordion">
            <div class="card-body">
              <div class="row">
                <!-- form start -->
                <div class="col-md-12"> 
                  <div class="header_box version_2">
                    <h2>STRENGTHS</h2>
                  </div>
                </div>
                <br clear="all">
                <?php
                  if($storedData->Strength !='') {
                    $Strength = json_decode($storedData->Strength);
                  }
                ?>
                <div class="col-md-12"> 
                  <div class="row" id="strengthoptions">
                    <div class="col-md-4">                                
                      <div class="form-group labelWrap">
                        <input type="text" class="form-control" name="strength[]" placeholder="Strengths" value="<?php echo $Strength[0]?>">
                      </div>
                    </div>
                    <div class="col-md-4">                                
                      <div class="form-group labelWrap">
                        <input type="text" class="form-control" name="strength[]" placeholder="Strengths" value="<?php echo $Strength[1]?>">
                      </div>
                    </div>
                    <div class="col-md-4">                                
                      <div class="form-group labelWrap">
                        <input type="text" class="form-control" name="strength[]" placeholder="Strengths" value="<?php echo $Strength[2]?>">
                      </div>
                    </div>
                    <?php
                      if(count($Strength)>3) {
                        $s=3;
                        while($Strength[$s]) {
                          ?>
                    <div class="col-md-4">                                
                      <div class="form-group labelWrap">
                        <input type="text" class="form-control" name="strength[]" placeholder="Strengths" value="<?php echo $Strength[$s]?>">
                      </div>
                    </div>
                        <?php
                        $s++;
                      }
                    }
                    ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-6">                                
                        <div class="form-group labelWrap">
                          <a href="javascript: void(0)" id="addmorestrength" class="btn-sm btn btn-primary" style="margin-top:5px"><i class="fa fa-plus" aria-hidden="true"></i>Add More</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12"> 
                    <div class="header_box version_2">
                      <h2>OPPORTUNITIES</h2>
                    </div>
                  </div>
                  <br clear="all">
                  <?php
                    if($storedData->Opertunities !='') {
                      $Opertunities = json_decode($storedData->Opertunities);
                    }
                  ?>
                  <div class="col-md-12"> 
                    <div class="row" id="opertunitiesoptions">
                      <div class="col-md-4">                                
                        <div class="form-group labelWrap">
                          <input type="text" class="form-control" name="Opertunities[]" placeholder="Opertunities" value="<?php echo $Opertunities[0]?>">
                        </div>
                      </div>
                      <div class="col-md-4">                                
                        <div class="form-group labelWrap">
                          <input type="text" class="form-control" name="Opertunities[]" placeholder="Opertunities" value="<?php echo $Opertunities[1]?>">
                        </div>
                      </div>
                      <div class="col-md-4">                                
                        <div class="form-group labelWrap">
                          <input type="text" class="form-control" name="Opertunities[]" placeholder="Opertunities" value="<?php echo $Opertunities[2]?>">
                        </div>
                      </div>
                      <?php
                      if(count($Opertunities)>3) {
                        $op=3;
                        while($Opertunities[$op]) {
                          ?>
                      <div class="col-md-4">                                
                        <div class="form-group labelWrap">
                          <input type="text" class="form-control" name="Opertunities[]" placeholder="Opertunities" value="<?php echo $Opertunities[$op]?>">
                        </div>
                      </div>
                          <?php
                          $op++;
                        }
                      }
                      ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group labelWrap">
                          <a href="javascript: void(0)" id="addmoreopertunities" class="btn-sm btn btn-primary" style="margin-top:5px"><i class="fa fa-plus" aria-hidden="true"></i>Add More</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12"> 
                    <div class="header_box version_2">
                      <h2>WEAKNESSES</h2>
                    </div>
                  </div>
                  <br clear="all">
                  <?php
                    if($storedData->Weakness !='') {
                      $Weakness = json_decode($storedData->Weakness);
                    }
                  ?>
                  <div class="col-md-12">
                    <div class="row" id="weaknessoptions">
                      <div class="col-md-4">                                
                        <div class="form-group labelWrap">
                          <input type="text" class="form-control" name="Weakness[]" placeholder="Weakness" value="<?php echo $Weakness[0]?>">
                        </div>
                      </div>
                      <div class="col-md-4">                                
                        <div class="form-group labelWrap">
                          <input type="text" class="form-control" name="Weakness[]" placeholder="Weakness" value="<?php echo $Weakness[1]?>">
                        </div>
                      </div>
                      <div class="col-md-4">                                
                        <div class="form-group labelWrap">
                          <input type="text" class="form-control" name="Weakness[]" placeholder="Weakness" value="<?php echo $Weakness[2]?>">
                        </div>
                      </div>
                      <?php
                      if(count($Weakness) > 3) {
                        $w=3;
                        while($Weakness[$w]) {
                          ?>
                      <div class="col-md-4">                                
                        <div class="form-group labelWrap">
                          <input type="text" class="form-control" name="Weakness[]" placeholder="Weakness" value="<?php echo $Weakness[$w]?>">
                        </div>
                      </div>
                          <?php
                          $w++;
                        }
                      }
                      ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group labelWrap">
                          <a href="javascript: void(0)" id="addmoreweakness" class="btn-sm btn btn-primary" style="margin-top:5px"><i class="fa fa-plus" aria-hidden="true"></i>Add More</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="header_box version_2">
                      <h2>THREATS</h2>
                    </div>
                  </div>
                  <br clear="all">
                  <?php
                    if($storedData->Threats !='') {
                      $Threats = json_decode($storedData->Threats);
                    }
                    ?>
                  <div class="col-md-12">
                    <div class="row" id="threatsoptions">
                      <div class="col-md-4">                                
                        <div class="form-group labelWrap">
                          <input type="text" class="form-control" name="Threats[]" placeholder="Threats" value="<?php echo $Threats[0]?>">
                        </div>
                      </div>
                      <div class="col-md-4">                                
                        <div class="form-group labelWrap">
                          <input type="text" class="form-control" name="Threats[]" placeholder="Threats" value="<?php echo $Threats[1]?>">
                        </div>
                      </div>
                      <div class="col-md-4">                                
                        <div class="form-group labelWrap">
                          <input type="text" class="form-control" name="Threats[]" placeholder="Threats" value="<?php echo $Threats[2]?>">
                        </div>
                      </div>
                      <?php
                      if(count($Threats)>3) {
                        $t=3;
                        while($Threats[$t]) {
                          ?>
                      <div class="col-md-4">                                
                          <div class="form-group labelWrap">
                            <input type="text" class="form-control" name="Threats[]" placeholder="Threats" value="<?php echo $Threats[$t]?>">
                          </div>
                      </div>
                          <?php
                          $t++;
                        }
                      }
                      ?>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-6">                                
                        <div class="form-group labelWrap">
                          <a href="javascript: void(0)" id="addmorethreat" class="btn-sm btn btn-primary" style="margin-top:5px"><i class="fa fa-plus" aria-hidden="true"></i>Add More</a>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <input type="submit" value="Save Changes" class="btn-sm btn btn-primary pull-right">
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php 
          if(!empty($uncoverData)){
            ?>

        <!-- box9 -->
        <div class="box_general padding_bottom site-setting-area card">
          <div class="header_box version_2 collapsHeading collapsed" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
            <h2><i class="fa fa-file"></i>Uncovered By Users</h2>
          </div><!-- /.box-header -->
          <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordion">
            <div class="card-body">
              <div class="row">
                <!-- form start -->
                <div class="col-md-12"> 
                  <div class="header_box version_2">
                    <h2>Signed NDAs</h2>
                  </div>
                </div>
                <br clear="all">
                <!-- This is the area we need to work -->
                <div class="col-sm-12">
                  <div class="nda-table">
                    <div class="table-responsive">
                      <table class="table table-bordered" id="uncoverListingDTB" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>SL No</th>
                            <th>Contact</th>
                            <th>Uncovered On</th>
                            <th class="no-sort">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            foreach ($uncoverData as $ucKey => $ucVal) {
                              # code...
                              $aUrl = base_url().'administrator/download-nda/'.$ucVal['userId'].'/'.$ucVal['unlocked_business'];
                              if($ucVal['signed_nda_if_any'] != ''){
                                $aUrl = base_url().'uploads/user_signed_nda_s/signed_nda_by_'.$ucVal['userId'].'_for_listing_'.$ucVal['unlocked_business'].'.pdf';
                              }
                              ?>
                          <tr>
                            <td><?php echo ($ucKey+1); ?></td>
                            <td><?php echo $ucVal['contact_name'].'('.$ucVal['mail'].')'; ?></td>
                            <td><?php echo date('jS F, Y', strtotime($ucVal['date_unlocked'])); ?></td>
                            <td><a target="_blank" href="<?php echo $aUrl; ?>" class="btn-sm btn-primary downloadPDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a></td>
                          </tr>
                              <?php
                            }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
            <?php 
          }
        ?>
      </form>

    <div class="modal fade" id="clearanalyticsModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to clear analytics data?</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <div class="modal-footer">
                        <form action="<?php echo base_url(); ?>administrator/sell-request/clear-analytics-data" method="post" id="delform">
                        <input type="hidden" name="requestId" value="<?php echo $req_id; ?>" />
                        <input type="hidden" name="approveId" value="<?php echo $storedData->id; ?>" />
                        <input type="hidden" name="userId" value="<?php echo $storedData->userId; ?>" />
                        <input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                        <button type="submit" class="btn btn-danger">Clear</button>
                        </form>
                        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                      </div>
                    </div>
                  </div>
                </div>
  
  </div>
</div>
<input type="hidden" id="siteurl" value="<?php echo base_url();?>">