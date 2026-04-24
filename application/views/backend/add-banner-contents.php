<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url();?>administrator">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Banners</li>
      </ol>
      <div class="box_general padding_bottom site-setting-area">
      <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
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
                
            <!-- ========= -->
            <form role="form" id="homeContents" action="<?php echo base_url(); ?>administrator/banners/alterbannercontents" method="post" role="form" enctype="multipart/form-data">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
              <input type="hidden" name="id" value="<?php echo $result->id; ?>">
              <div class="header_box version_2">
                <h2><i class="fa fa-file"></i>Home Page Banner</h2>
              </div> 
              <br clear="all">
              <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Section photo</label>
                      <?php 
                      
                      if($result->homeimage != '') 
                      { 
                      ?>
                      <div class="coverImage">
                        <img id="pic-buyer" style="width:220px; height:220px;" src="<?php echo base_url() ?>uploads/banner_images/resized/<?php echo $result->homeimage ;?>" prev-data-src="<?php echo base_url() ?>uploads/images_extra/<?php echo $result->image;?>" alt="">
                        <?php 
                        if($editpermission)
                        { 
                        ?>
                        <div class="col-md-12 dropzone" id="buyer" style="min-height:154px; display:none"> </div>
                        <div class="col-md-12" id="">Expected image dimention [1600px/654px] </div>
                        
                        <button style="margin-top:10px;margin-left:30px;" class="btn btn-warning btn-xs btn-sm change-pic-buyer" type="button">Change Image</button> 
                        <?php
                        }
                        ?>
                      </div>  
                      <?php 
                      } 
                      elseif($editpermission)
                      {
                      ?>
                      <div class="col-md-12 dropzone" id="buyer" style="min-height:154px"> </div>
                      <?php
                      }
                      ?>
                      <input type="hidden" name="homeimage" id="imageContentsBuyer" value="<?php echo $result->homeimage; ?>">
                    </div>
                  </div>
                  <div class="col-md-9"> 
                      <div class="row"> 
                        <div class="col-sm-12">                        
                          <div class="form-group">
                              <label for="cat_name">Text 1</label>
                              <input type="text" class="form-control" value="<?php echo $result->homeheading1; ?>" id="homeheading1" name="homeheading1">
                          </div>
                        </div>   
                        <div class="col-sm-6">
                          <div class="form-group">
                              <label for="cat_name">Text 2</label>
                              <input type="text" class="form-control" value="<?php echo $result->homeheading2; ?>" id="homeheading2" name="homeheading2">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                              <label for="cat_name">Text 3</label>
                              <input type="text" class="form-control" value="<?php echo $result->homeheading3; ?>" id="homeheading3" name="homeheading3">
                          </div>
                        </div>
                      </div>   
                  </div> 
              </div>
              <div class="row">
                <div class="col-md-12">                                
                  <div class="form-group">
                      <h6 class="header_box version_2"><strong>List Contents</strong></h6>
                      <?php
                      $listcontents = json_decode($result->homelistcontents,true);
                      ?>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="row buyersteps">
                    <div class="col-md-3">  
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="form-group">
                              <label for="cat_name">List content 1</label>
                              <input type="text" class="form-control" value="<?php echo $listcontents[0]; ?>" id="" name="homelistcontents[]">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">  
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="form-group">
                              <label for="cat_name">List content 2</label>
                              <input type="text" class="form-control" value="<?php echo $listcontents[1]; ?>" id="" name="homelistcontents[]">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">  
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                                <label for="cat_name">List content 3</label>
                                <input type="text" class="form-control" value="<?php echo $listcontents[2]; ?>" id="" name="homelistcontents[]">
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-3">  
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                                <label for="cat_name">List content 4</label>
                                <input type="text" class="form-control" value="<?php echo $listcontents[3]; ?>" id="" name="homelistcontents[]">
                            </div>
                          </div>
                        </div>
                    </div> 
                </div>
              </div>  
                <?php
                if($editpermission)
                {
                  ?>   
                  <div class="col-md-12">
                    <?php
                    if($result->id >0)
                    {
                      ?>
                      <input type="hidden" name="action" value="edit">
                      <?php
                    }else{
                      ?>
                      <input type="hidden" name="action" value="add">
                      <?php
                    }
                      ?>
                      <input type="submit" name="submit" class="btn btn-primary pull-right" value="Submit" />
                  </div>
                  <?php
                }
                ?>
            </form>
            <div class="col-md-12">    
            <form role="form" id="homeContents" action="<?php echo base_url(); ?>administrator/banners/alterbannercontents" method="post" role="form" enctype="multipart/form-data">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
              <input type="hidden" name="id" value="<?php echo $result->id; ?>">
              <input type="hidden" name="area" value="inside">
              <div class="header_box version_2">
                <h2><i class="fa fa-file"></i>Inner Page Banner</h2>
              </div> 
              <br clear="all">
              <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Section photo</label>
                      <?php 
                      
                      if($result->insideimage != '') 
                      { 
                      ?>
                      <div class="coverImage">
                        <img id="pic-seller" style="width:220px; height:220px;" src="<?php echo base_url() ?>uploads/banner_images/resized/<?php echo $result->insideimage ;?>" prev-data-src="<?php echo base_url() ?>uploads/images_extra/<?php echo $result->image;?>" alt="">
                        <?php 
                        if($editpermission)
                        { 
                        ?>
                        <div class="col-md-12 dropzone" id="seller" style="min-height:154px; display:none"> </div>
                        <div class="col-md-12" id="">Expected image dimention [1600px/312px] </div>
                        
                        <button style="margin-top:10px;margin-left:30px;" class="btn btn-warning btn-xs btn-sm change-pic-seller" type="button">Change Image</button> 
                        <?php
                        }
                        ?>
                      </div>  
                      <?php 
                      } 
                      elseif($editpermission)
                      {
                      ?>
                      <div class="col-md-12 dropzone" id="seller" style="min-height:154px"> </div>
                      <?php
                      }
                      ?>
                      <input type="hidden" name="insideimage" id="imageContentsSeller" value="<?php echo $result->insideimage; ?>">
                    </div>
                  </div>
                  <div class="col-md-9"> 
                      <div class="row"> 
                        <div class="col-sm-12">                        
                          <div class="form-group">
                              <label for="cat_name">Text 1</label>
                              <input type="text" class="form-control" value="<?php echo $result->innertext1; ?>" id="innertext1" name="innertext1">
                          </div>
                        </div>   
                        <div class="col-sm-12">
                          <div class="form-group">
                              <label for="cat_name">Text 2</label>
                              <input type="text" class="form-control" value="<?php echo $result->innertext2; ?>" id="innertext2" name="innertext2">
                          </div>
                        </div>
                      </div>   
                  </div> 
              </div>
               
                
                <?php
                if($editpermission)
                {
                  ?>   
                  <div class="col-md-12">
                    <?php
                    if($result->id >0)
                    {
                      ?>
                      <input type="hidden" name="action" value="edit">
                      <?php
                    }else{
                      ?>
                      <input type="hidden" name="action" value="add">
                      <?php
                    }
                      ?>
                      <input type="submit" name="submit" class="btn btn-primary pull-right" value="Submit" />
                  </div>
                  <?php
                }
                ?>
            </form>
            </div>
           
        </div>
      </div>
    </div>    
    </div>
  </div>
</div>
<div id="buyerstepskeleton" style="display:none">
<div class="col-md-3">  
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="form-group">
                              <label for="cat_name">Title</label>
                              <input type="text" class="form-control" id="" name="titlestepbuyer[]">
                          </div>
                        </div>
                        <div class="col-md-12">                                
                          <div class="form-group">
                              <label for="cat_name">Description</label>
                              <textarea class="form-control" id="" name="descriptstepbuyer[]" rows="10"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
</div>
<div id="sellerstepskeleton" style="display:none">
<div class="col-md-3">  
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="form-group">
                              <label for="cat_name">Title</label>
                              <input type="text" class="form-control" value="" id="" name="titlestepseller[]">
                          </div>
                        </div>
                        <div class="col-md-12">                                
                          <div class="form-group">
                              <label for="cat_name">Description</label>
                              <textarea class="form-control" value="" id="" name="descriptionstepseller[]" rows="10"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
</div>

<div id="sellerstepskeleton" style="display:none">
<div class="col-md-3">  
                          <div class="row">
                            <div class="col-sm-12">
                              <div class="form-group">
                                  <label for="cat_name">Title</label>
                                  <input type="text" class="form-control" value="" id="" name="titlestepseller[]">
                              </div>
                            </div>
                            <div class="col-md-12">                                
                              <div class="form-group">
                                  <label for="cat_name">Description</label>
                                  <textarea class="form-control" value="" id="" name="descriptionstepseller[]" rows="10"></textarea>
                              </div>
                            </div>
                          </div>
                      </div>
</div>
<div id="generalstepskeleton" style="display:none">
<div class="col-md-3">  
                          <div class="row">
                            <div class="col-sm-12">
                              <div class="form-group">
                                  <label for="cat_name">Title</label>
                                  <input type="text" class="form-control" value="" id="" name="titlestepgeneral[]">
                              </div>
                            </div>
                            <div class="col-md-12">                                
                              <div class="form-group">
                                  <label for="cat_name">Description</label>
                                  <textarea class="form-control" value="" id="" name="descriptionstepgeneral[]" rows="10"></textarea>
                              </div>
                            </div>
                          </div>
                      </div>
</div>