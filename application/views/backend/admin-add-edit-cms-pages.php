<?php
$pageID      = "";
$pageName    = "";
$pageTitle   = "";
$pageSlug    = "";
$pageContent = "";
$pageStatus  = "";
$showInMenu  = "";
$metaTitle   = "";
$metaKeyword = "";
$metaDescription = "";
$action      = "add";
$headingText = 'Add CMS Page';
$formID = 'addCMS';
$sponsored_title = '';
$sponsored_subtitle = '';
$most_viewed_title = '';
$most_viewed_subtitle = '';
if(isset($getPageDetails) && !empty($getPageDetails)){
  //echo "<pre>"; print_r($project_details); echo "</pre>";die;
  $pageID      = $getPageDetails['pageID'];
  $pageName    = $getPageDetails['pageName'];
  $pageTitle   = $getPageDetails['pageTitle'];
  $pageSlug    = $getPageDetails['pageSlug'];
  $bannerTitle    = $getPageDetails['banner_title'];
  $bannerSubTitle    = $getPageDetails['banner_sub_title'];
  $bannerImage    = $getPageDetails['banner_image'];
  $bannerImage    = $getPageDetails['banner_image'];
  $pageContent = stripslashes($getPageDetails['pageContent']);
  $pageImage   = $getPageDetails['pageFeatureImage'];
  $pageStatus  = $getPageDetails['pageStatus'];
  $showInMenu  = $getPageDetails['showInMenu'];
  $metaTitle   = $getPageDetails['metaTitle'];
  $metaKeyword = $getPageDetails['metaKeyword'];
  $metaDescription = $getPageDetails['metaDescription'];
  $action      = "edit";
  $headingText = 'Edit CMS Page';
  $formID = 'editCMS';
  
  $sponsored_title = $getPageDetails['sponsored_title'];
  $sponsored_subtitle = $getPageDetails['sponsored_subtitle'];
  $most_viewed_title = $getPageDetails['most_viewed_title'];
  $most_viewed_subtitle = $getPageDetails['most_viewed_subtitle'];
}
?>
<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo base_url();?>administrator/cms-pages">CMS Pages</a>
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
              <a class="btn btn-primary btn-sm pull-right" href="<?php echo base_url(); ?>administrator/cms-pages"><i class="fa fa-level-up"></i> Back to list</a>
            </div><!-- /.box-header -->
            <!-- form start -->
            <br clear="all">
            <?php $this->load->helper("form"); ?>
            <form role="form" id="AddEditCMSPage" action="<?php echo base_url(); ?>administrator/cms-pages/edit" method="post" role="form" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">                                
                    <div class="form-group">
                      <label for="pageName">Page Name <span style="color:red;">*</span></label>
                      <input type="text" class="form-control" id="pageName" name="pageName" <?php if($pageSlug=='home-page' || $pageSlug=='add-restaurant-owner') { echo 'readonly'; } ?> value="<?php echo $pageName;?>">
                    </div>
                  </div>
                  <div class="col-md-6">                                
                    <div class="form-group">
                      <label for="pageTitle">Page Title <span style="color:red;">*</span></label>
                      <input type="text" class="form-control" id="pageTitle" name="pageTitle"  value="<?php echo $pageTitle;?>">
                      
                    </div>
                  </div>
                  <div class="col-md-6">                                
                    <div class="form-group">
                      <label for="pageStatus">Status <span style="color:red;">*</span></label>
                      <select class="form-control" name="pageStatus" id="pageStatus">
                        <option value="">Select Option</option>
                        <option <?php echo ($pageStatus != '' && $pageStatus == '1') ? ' selected="selected"' : '';?> value="1">Yes</option>
                        <option <?php echo ($pageStatus != '' && $pageStatus == '0') ? ' selected="selected"' : '';?> value="0">No</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">                                
                    <div class="form-group">
                      <label for="showInMenu">Show In Menu <span style="color:red;">*</span></label>
                      <select class="form-control" name="showInMenu" id="showInMenu">
                        <option value="">Select Option</option>
                        <option <?php echo ($showInMenu != '' && $showInMenu == 'Y') ? ' selected="selected"' : '';?> value="Y">Yes</option>
                        <option <?php echo ($showInMenu != '' && $showInMenu == 'N') ? ' selected="selected"' : '';?> value="N">No</option>
                      </select>
                    </div>
                  </div>
                  <!--
                  <div class="col-md-2">                                
                    <div class="form-group">
                      <label for="showInMenu">Banner Title</label>
                      <input type="text" name="banner_title" id="banner_title" class="form-control" value="<?php echo $bannerTitle; ?>">
                    </div>
                  </div>
                  <div class="col-md-4">                                
                    <div class="form-group">
                      <label for="showInMenu">Banner Sub Title</label>
                      <input type="text" name="banner_sub_title" id="banner_sub_title" class="form-control" value="<?php echo $bannerSubTitle; ?>">
                    </div>
                  </div>
                  <div class="col-md-2">                                
                    <div class="form-group">
                      <label for="showInMenu">Banner Image</label>
                      <input type="file" name="banner_image" id="banner_image">
                      <span class="fileUpload"></span>
                    </div>
                  </div>

                  <div class="col-md-2">
                  <?php 
                  //if($bannerImage!='')
                  //{
                  ?>
                  <img id="blah" src="<?php //echo base_url() ?>uploads/cms_page_images/banner_images/<?php //echo $bannerImage; ?>" style="height:100px;width:100px;" />
                  <?php
                  //}
                  //else 
                  //{
                  ?>
                  <img id="blah" src="#" style="margin-left:100px;display:none;height:100px;width:100px;" />
                  <?php 
                  //}
                  ?>
                  </div>
                  -->
                  
                 
                  <div class="col-md-8">                                
                    <div class="form-group">
                      <label for="page_content">Page Content <span style="color:red;">*</span></label>
                      <textarea class="form-control" name="pageContent" id="pageContent" rows="6"><?php echo $pageContent;?></textarea>
                    </div>
                  </div>
                  <div class="col-md-4">   
                  <div class="row">
                    <div class="col-md-12">
                          <div class="form-group">
                              <label for="pageImage">Page Feature Image</label>
                              <input type="file" name="pageImage" id="pageImage" class="form-control">
                              <span class="testimonialUpload"></span>
                            </div>
                    </div>
                    <div class="col-md-12">
                          <div class="form-group">
                              <?php
                              if($pageImage != ''){
                                ?>
                                <img src="<?php echo base_url() . '/uploads/cms_page_images/' . $pageImage; ?>" alt="" class="preview-sml"/>
                                <?php
                              }
                              ?>
                            </div>
                    </div>

                  
                  </div>                             
                    
                  </div>



                  <?php 
                  if($pageSlug=='home-page')
                  {
                  ?>
                            
                  <div class="col-sm-6">                                
                    <div class="form-group">
                        <label for="cat_name">Sponsored Title</label>
                        <input type="text" class="form-control" id="sponsored_title" name="sponsored_title" value="<?php echo $sponsored_title; ?>">
                    </div>
                  </div>

                  <div class="col-sm-6">                                
                    <div class="form-group">
                        <label for="cat_name">Sponsored Sub Title</label>
                        <input class="form-control" id="sponsored_subtitle" name="sponsored_subtitle" value="<?php echo $sponsored_subtitle; ?>">
                    </div>
                  </div>
                                  
                  <div class="col-sm-6">                                
                    <div class="form-group">
                        <label for="cat_name">Most Viewed Title</label>
                        <input type="text" class="form-control" id="most_viewed_title" name="most_viewed_title" value="<?php echo $most_viewed_title; ?>">
                    </div>
                  </div>

                  <div class="col-sm-6">                                
                    <div class="form-group">
                        <label for="cat_name">Most Viewed Sub Title</label>
                        <input class="form-control" id="most_viewed_subtitle" name="most_viewed_subtitle" value="<?php echo $most_viewed_subtitle; ?>">
                    </div>
                  </div>
                  

                  <br clear="all">
                  <div class="row">
                      <div class="col-sm-12">
                        <h4>First Content Section</h4>
                      </div>
                    
                      <div class="col-md-3">                                
                        <div class="form-group">
                            <label for="cat_name"> Title</label>
                            <input type="text" class="form-control" id="first_content_title" name="first_content_title" value="<?php echo $getPageDetails['first_content_title']; ?>">
                        </div>
                      </div>

                      <div class="col-md-5">                                
                        <div class="form-group">
                            <label for="cat_name"> Description</label>
                            <textarea class="form-control" id="first_content_description" name="first_content_description"><?php echo $getPageDetails['first_content_description']; ?></textarea>
                        </div>
                      </div>

                      <div class="col-md-3">                                
                        <div class="form-group">
                            <label for="cat_name"> Image</label>
                            <input type="file" id="first_content_image" name="first_content_image">
                            <?php 
                            if($getPageDetails['first_content_image']!='')
                            {
                            ?>
                            <img src="<?php echo base_url() ?>uploads/home_page/<?php echo $getPageDetails['first_content_image'] ?>" style="height:75px;width:75px;">
                            <?php 
                            }
                            ?>
                        </div>
                      </div>
                  
                      <div class="col-sm-12">
                        <h4>Second Content Section</h4>
                      </div>
                      <div class="col-md-3">                                
                        <div class="form-group">
                            <label for="cat_name"> Title</label>
                            <input type="text" class="form-control" id="second_content_title" name="second_content_title" value="<?php echo $getPageDetails['second_content_title']; ?>">
                        </div>
                      </div>

                      <div class="col-md-5">                                
                        <div class="form-group">
                            <label for="cat_name"> Description</label>
                            <textarea class="form-control" id="second_content_description" name="second_content_description"><?php echo $getPageDetails['second_content_description']; ?></textarea>
                        </div>
                      </div>

                      <div class="col-md-3">                                
                        <div class="form-group">
                            <label for="cat_name"> Image</label>
                            <input type="file" id="second_content_image" name="second_content_image">
                            <?php 
                            if($getPageDetails['second_content_image']!='')
                            {
                            ?>
                            <img src="<?php echo base_url() ?>uploads/home_page/<?php echo $getPageDetails['second_content_image'] ?>" style="height:75px;width:75px;">
                            <?php 
                            }
                            ?>
                        </div>
                      </div>
                  </div>
                  <?php 
                  }
                  ?>


                  <?php 
                  if($pageSlug=='add-restaurant-owner')
                  {
                  ?>
                  <br clear="all">
                  


                      <div class="col-sm-12">
                        <h4>Restaurant Owner Content</h4>
                      </div>
                      <?php 
                      $id_array = array();
                      $count=1;
                      if(count($get_restaurant_owner_content_details)>0)
                      {
                        foreach($get_restaurant_owner_content_details as $content_details)
                        {
                          $id_array[] = $content_details['id'];
                      ?>
                      <div class="row">
                      <div class="col-md-2">                                
                        <div class="form-group">
                            <label for="cat_name"> Title</label>
                            <input type="text" class="form-control" id="owner_title" name="owner_title[]" value="<?php echo $content_details['owner_title']; ?>">
                        </div>
                      </div>

                      <div class="col-md-2">                                
                        <div class="form-group">
                            <label for="cat_name">Sub Title</label>
                            <input type="text" class="form-control" id="owner_sub_title" name="owner_sub_title[]" value="<?php echo $content_details['owner_sub_title']; ?>">
                        </div>
                      </div>

                      <div class="col-md-3">                                
                        <div class="form-group">
                            <label for="cat_name"> Description</label>
                            <textarea class="form-control" id="first_content_description" name="owner_description[]"><?php echo $content_details['owner_description']; ?></textarea>
                        </div>
                      </div>

                      <div class="col-md-3">                                
                        <div class="form-group">
                            <label for="cat_name"> Image</label>
                            <input type="file" id="first_content_image" name="owner_image[]">
                            <span class="fileUpload"></span>
                            <br clear="all">
                            <?php 
                            if(isset($content_details['owner_image']) && $content_details['owner_image']!='')
                            {
                            ?>
                            <img src="<?php echo base_url() ?>uploads/restaurant_owner/<?php echo $content_details['owner_image'] ?>" style="width:50px; height:50px;">
                            <?php
                            }
                            ?>
                        </div>
                      </div>

                      <div class="col-md-2">                                
                        <div class="form-group">
                            <?php 
                            if($count>1)
                            {
                            ?>
                            <Button class="btn btn-xs btn-danger" type="button" onclick="remove_owner_content('<?php echo $content_details['id'] ?>')"><i class="fa fa-close"></i></Button>
                            <?php 
                            }
                            else 
                            {
                            ?>
                            <Button class="btn btn-xs btn-info" type="button" id="add_more"><i class="fa fa-plus"></i></Button>
                            <?php
                            }
                            ?>
                        </div>
                      </div>
                      <input type="hidden" name="content_id[]" id="content_id" value="<?php echo $content_details['id']; ?>">
                      </div>
                      <?php 
                        $count++;
                        }
                      }
                      else
                      {
                      ?>
                      <div class="row">
                      <div class="col-md-2">                                
                        <div class="form-group">
                            <label for="cat_name"> Title</label>
                            <input type="text" class="form-control" id="owner_title" name="owner_title[]" value="<?php echo $content_details['owner_title']; ?>">
                        </div>
                      </div>

                      <div class="col-md-2">                                
                        <div class="form-group">
                            <label for="cat_name">Sub Title</label>
                            <input type="text" class="form-control" id="owner_sub_title" name="owner_sub_title[]" value="<?php echo $content_details['owner_sub_title']; ?>">
                        </div>
                      </div>

                      <div class="col-md-4">                                
                        <div class="form-group">
                            <label for="cat_name"> Description</label>
                            <textarea class="form-control" id="first_content_description" name="owner_description[]"><?php echo $content_details['owner_description']; ?></textarea>
                        </div>
                      </div>

                      <div class="col-md-2">                                
                        <div class="form-group">
                            <label for="cat_name"> Image</label>
                            <input type="file" id="first_content_image" name="owner_image[]">
                            <span class="fileUpload"></span>
                        </div>
                        
                      </div>

                      <div class="col-md-2">                                
                        <div class="form-group">
                            <Button class="btn btn-xs btn-info" type="button" id="add_more"><i class="fa fa-plus"></i></Button>
                        </div>
                      </div>
                      <input type="hidden" name="content_id[]" id="content_id" value="">
                      </div>
                      <?php 
                      }
                      ?>
                      
                  </div>
                  
                      
                  
                  <?php 
                  }
                  ?>

                </div>
                <span id="more_content"></span>
                

                  
                </div>
                <?php 
                  /* if(isset($getPageExtraFields)){
                    ?>
                    <div class="extra_fields_area">
                        <?php
                        //echo "<pre>"; print_r($getPageExtraFields); die;
                        foreach($getPageExtraFields as $gFields){
                          ?>
                          <div class="row">
                            <div class="col-sm-8">
                              <div class="form-group">
                                <label><?php echo $gFields['extra_field_title'];?></label>
                                <?php 
                                  if($gFields['display_type'] == 'image'){
                                    if($gFields['meta_value'] != ''){
                                      $thumbfileName = str_ireplace('.', '_resized.', $gFields['meta_value']);
                                      $pageimage =  base_url() . 'uploads/cms_page_images/' . $thumbfileName;
                                      ?>
                                      <img src="<?php echo $pageimage; ?>" alt="" class="preview-sml"/>
                                      <?php
                                    }
                                    ?>
                                    <input type="file" class="form-control" name="<?php echo $gFields['extra_field_name'];?>" />
                                    <?php
                                  } else if($gFields['display_type'] == 'textarea') {
                                    
                                    ?>
                                    <textarea class="form-control ckeditor" name="<?php echo $gFields['extra_field_name'];?>"><?php echo $gFields['meta_value'];?></textarea>
                                    <?php 
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                          <?php
                        }
                        ?>
                    </div>
                    <?php
                  } */
                ?>
                <div class="row">
                  <div class="col-sm-12">
                    <h4>SEO Fields</h4>
                  </div>
                  <div class="col-md-12">                                
                    <div class="form-group">
                      <label for="page_name">Meta Title</label>
                      <input type="text" class="form-control" id="metaTitle" name="metaTitle" value="<?php echo $metaTitle;?>">
                    </div>
                  </div>
                  <div class="col-md-12">                                
                    <div class="form-group">
                      <label for="page_name">Meta Keyword</label>
                      <input type="text" class="form-control" id="metaKeyword" name="metaKeyword" value="<?php echo $metaKeyword;?>">
                    </div>
                  </div>
                  <div class="col-md-12">                                
                    <div class="form-group">
                      <label for="page_name">Meta Description</label>
                      <textarea class="form-control" id="metaDescription" name="metaDescription" rows="6"><?php echo $metaDescription;?></textarea>
                    </div>
                  </div>
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <input type="hidden" name="action" value="<?php echo $action;?>">
                <?php if($pageID != '') { ?>
                <input type="hidden" name="pageID" value="<?php echo $pageID;?>">
                <?php } ?>
                <input type="submit" name="submit" class="btn btn-primary" value="Submit" />
                <input type="button" onclick="location.href='<?php echo base_url();?>administrator/cms-pages';" class="btn btn-default" value="Cancel" />
                <p><span style="color:red;">*</span> fields are mandatory.</p>
              </div>
            </form>
          </div>
        </div>
      </div>    
      </div>
    </div>
  </div>
  <script>
  function remove_owner_content(id)
  {
   if(confirm("Are You Sure Want To Delete?"))
   {
      $.ajax({
          url: '<?php echo base_url();?>administrator/delete-owner-content',
          data: ({ id: id }),
          dataType: 'json', 
          type: 'post',
          success: function(data) {
            alert(data.message);
            location.reload();
          }             
      });
   }
  }

  </script>