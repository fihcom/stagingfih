<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo base_url(); ?>administrator">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Home Contents</li>
    </ol>
    <div class="box_general padding_bottom site-setting-area">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="header_box version_2">
              <h2><i class="fa fa-file"></i>What Is NBP</h2>
            </div><!-- /.box-header -->
            <!-- form start -->
            <?php
            $error = $this->session->flashdata('error');
            if ($error) {
            ?>
              <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('error'); ?>
              </div>
            <?php
            }

            $success = $this->session->flashdata('success');
            if ($success) {
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
            <form role="form" id="homeContents" action="<?php echo base_url(); ?>administrator/homecontents/alterhomecontents" method="post" role="form" enctype="multipart/form-data">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
              <input type="hidden" name="homecontentid" value="<?php echo $result[0]->id; ?>">
              <div class="row">

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="cat_name">Content</label>
                    <textarea class="form-control" value="" id="content" name="content" rows="10"><?php echo $result[0]->content; ?></textarea>
                  </div>
                </div>


                <div class="col-md-3">
                  <div class="form-group">
                    <label for="cat_name">Title</label>
                    <input type="text" class="form-control" value="<?php echo $result[0]->npb_title1; ?>" id="site_title1" name="site_title1">
                  </div>
                  <div class="form-group">
                    <label for="cat_name">Description</label>
                    <textarea class="form-control" value="" id="description1" name="description1" rows="10"><?php echo $result[0]->npb_description1; ?></textarea>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="cat_name">Title</label>
                        <input type="text" class="form-control" value="<?php echo $result[0]->npb_title2; ?>" id="site_title2" name="site_title2">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="cat_name">Description</label>
                        <textarea class="form-control" value="" id="description2" name="description2" rows="10"><?php echo $result[0]->npb_description2; ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="cat_name">Title</label>
                      <input type="text" class="form-control" value="<?php echo $result[0]->npb_title3 ?>" id="site_title3" name="site_title3">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="cat_name">Description</label>
                      <textarea class="form-control" value="" id="description3" name="description3" rows="10"><?php echo $result[0]->npb_description3; ?></textarea>
                    </div>
                  </div>

                </div>
              </div>
              <?php
              if ($editpermission) {
              ?>
                <div class="col-md-12">
                  <div class="form-group">
                    <input type="hidden" name="action" value="add">
                    <input type="submit" name="submit" class="btn btn-primary pull-right" value="Submit" />
                  </div>
                </div>
              <?php
              }
              ?>
            </form>
          </div>
          <!-- ========= -->
          <form role="form" id="homeContents" action="<?php echo base_url(); ?>administrator/homecontents/alterhomecontents" method="post" role="form" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <input type="hidden" name="homecontentid" value="<?php echo $result->id; ?>">
            <input type="hidden" name="section" value="buyer">
            <div class="header_box version_2">
              <h2><i class="fa fa-file"></i>How it works for Buyers</h2>
            </div>
            <br clear="all">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Section photo</label>
                  <?php

                  if ($buyerData['image'] != '') {
                  ?>
                    <div class="coverImage">
                      <img id="pic-buyer" style="width:220px; height:220px;" src="<?php echo base_url() ?>uploads/images_extra/<?php echo $buyerData['image']; ?>" prev-data-src="<?php echo base_url() ?>uploads/images_extra/<?php echo $buyerData['image']; ?>" alt="">
                      <?php
                      if ($editpermission) {
                      ?>
                        <div class="col-md-12 dropzone" id="buyer" style="min-height:154px; display:none"> </div>
                        <button style="margin-top:10px;margin-left:30px;" class="btn btn-warning btn-xs btn-sm change-pic-buyer" type="button">Change Image</button>
                      <?php
                      }
                      ?>
                    </div>
                  <?php
                  } elseif ($editpermission) {
                  ?>
                    <div class="col-md-12 dropzone" id="buyer" style="min-height:154px"> </div>
                  <?php
                  }
                  ?>
                  <input type="hidden" name="imageContentsBuyer" id="imageContentsBuyer" value="<?php echo $buyerData['image']; ?>">
                </div>
              </div>
              <div class="col-md-9">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="cat_name">Title</label>
                      <input type="text" class="form-control" value="<?php echo $buyerData['title']; ?>" id="howitworks_title_buyer" name="howitworks_title_buyer">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="cat_name">Short Description</label>
                      <textarea class="form-control" value="" id="howitworks_description_short_buyer" name="howitworks_description_short_buyer"><?php echo $buyerData['short_description']; ?></textarea>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="cat_name">Long Description</label>
                      <textarea class="form-control" value="" id="howitworks_description_long_buyer" name="howitworks_description_long_buyer"><?php echo $buyerData['long_description']; ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <h6 class="header_box version_2"><strong>Buy a Business Steps</strong></h6>

                </div>
              </div>
              <div class="col-sm-12">
                <div class="row buyersteps">
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for="cat_name">Title</label>
                          <input type="text" class="form-control" value="<?php echo $buyerData['steps'][0]['title']; ?>" id="" name="titlestepbuyer[]">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="cat_name">Description</label>
                          <textarea class="form-control" value="" id="" name="descriptstepbuyer[]" rows="10"><?php echo $buyerData['steps'][0]['description']; ?></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for="cat_name">Title</label>
                          <input type="text" class="form-control" value="<?php echo $buyerData['steps'][1]['title']; ?>" id="" name="titlestepbuyer[]">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="cat_name">Description</label>
                          <textarea class="form-control" value="" id="" name="descriptstepbuyer[]" rows="10"><?php echo $buyerData['steps'][1]['description']; ?></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for="cat_name">Title</label>
                          <input type="text" class="form-control" value="<?php echo $buyerData['steps'][2]['title']; ?>" id="" name="titlestepbuyer[]">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="cat_name">Description</label>
                          <textarea class="form-control" value="" id="" name="descriptstepbuyer[]" rows="10"><?php echo $buyerData['steps'][2]['description']; ?></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for="cat_name">Title</label>
                          <input type="text" class="form-control" value="<?php echo $buyerData['steps'][3]['title']; ?>" id="" name="titlestepbuyer[]">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="cat_name">Description</label>
                          <textarea class="form-control" value="" id="" name="descriptstepbuyer[]" rows="10"><?php echo $buyerData['steps'][3]['description']; ?></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                  if (count($buyerData['steps']) > 4) {
                    $b = 4;
                    while ($buyerData['steps'][$b]) {
                  ?>
                      <div class="col-md-3">
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label for="cat_name">Title</label>
                              <input type="text" class="form-control" value="<?php echo $buyerData['steps'][$b]['title']; ?>" id="" name="titlestepbuyer[]">
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="cat_name">Description</label>
                              <textarea class="form-control" value="" id="" name="descriptstepbuyer[]" rows="10"><?php echo $buyerData['steps'][$b]['description']; ?></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                  <?php
                      $b++;
                    }
                  }
                  ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <?php
                if ($editpermission) {
                ?>
                  <input type="button" value="Add More Steps" class="btn btn-primary btn-sm addbuyerstepbtn">
                <?php
                }
                ?>
              </div>
              <?php
              if ($editpermission) {
              ?>
                <div class="col-md-12">
                  <input type="hidden" name="action" value="add">
                  <input type="submit" name="submit" class="btn btn-primary pull-right" value="Submit" />
                </div>
              <?php
              }
              ?>
            </div>
          </form>
          <!-- ====== -->
          <form role="form" id="homeContents" action="<?php echo base_url(); ?>administrator/homecontents/alterhomecontents" method="post" role="form" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <input type="hidden" name="homecontentid" value="<?php echo $result->id; ?>">
            <input type="hidden" name="section" value="seller">
            <div class="header_box version_2">
              <h2><i class="fa fa-file"></i>How it works for Sellers</h2>
            </div>
            <br clear="all">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Section photo</label>
                  <?php
                  if ($sellerData['image'] != '') {
                  ?>
                    <div class="coverImage">
                      <img id="pic-seller" style="width:220px; height:220px;" src="<?php echo base_url() ?>uploads/images_extra/<?php echo $sellerData['image']; ?>" prev-data-src="<?php echo base_url() ?>uploads/images_extra/<?php echo $buyerData['image']; ?>" alt="">

                      <?php
                      if ($editpermission) {
                      ?>
                        <div class="col-md-12 dropzone" id="seller" style="min-height:154px; display:none"> </div>
                        <button style="margin-top:10px;margin-left:30px;" class="btn btn-warning btn-xs btn-sm change-pic-seller" type="button">Change Image</button>
                      <?php
                      }
                      ?>
                    </div>
                  <?php
                  } elseif ($editpermission) {
                  ?>
                    <div class="col-md-12 dropzone" id="seller" style="min-height:154px"> </div>
                  <?php
                  }
                  ?>
                  <input type="hidden" name="imageContentsSeller" id="imageContentsSeller" value="<?php echo $sellerData['image']; ?>">
                </div>
              </div>
              <div class="col-md-9">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="cat_name">Title</label>
                      <input type="text" class="form-control" value="<?php echo $sellerData['title']; ?>" id="seller_title" name="seller_title">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="cat_name">Short Description</label>
                      <textarea class="form-control" value="" id="seller_short_description" name="seller_short_description"><?php echo $sellerData['short_description']; ?></textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="cat_name">Long Description</label>
                      <textarea class="form-control" value="" id="seller_long_description" name="seller_long_description"><?php echo $sellerData['long_description']; ?></textarea>
                    </div>
                  </div>
                </div>
              </div>


              <div class="col-md-12">
                <div class="form-group">
                  <h6 class="header_box version_2">Seller a Business Steps</h6>

                </div>
              </div>
              <div class="col-md-12">
                <div class="row sellersteps">
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for="cat_name">Title</label>
                          <input type="text" class="form-control" value="<?php echo $sellerData['steps'][0]['title']; ?>" id="site_title" name="titlestepseller[]">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="cat_name">Description</label>
                          <textarea class="form-control" value="" id="description3" name="descriptionstepseller[]" rows="10"><?php echo $sellerData['steps'][0]['description']; ?></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for="cat_name">Title</label>
                          <input type="text" class="form-control" value="<?php echo $sellerData['steps'][1]['title']; ?>" id="site_title" name="titlestepseller[]">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="cat_name">Description</label>
                          <textarea class="form-control" value="" id="" name="descriptionstepseller[]" rows="10"><?php echo $sellerData['steps'][1]['description']; ?></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for="cat_name">Title</label>
                          <input type="text" class="form-control" value="<?php echo $sellerData['steps'][2]['title']; ?>" id="site_title" name="titlestepseller[]">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="cat_name">Description</label>
                          <textarea class="form-control" value="" id="" name="descriptionstepseller[]" rows="10"><?php echo $sellerData['steps'][2]['description']; ?></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for="cat_name">Title</label>
                          <input type="text" class="form-control" value="<?php echo $sellerData['steps'][3]['title']; ?>" id="" name="titlestepseller[]">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="cat_name">Description</label>
                          <textarea class="form-control" value="" id="" name="descriptionstepseller[]" rows="10"><?php echo $sellerData['steps'][3]['description']; ?></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                  if (count($sellerData['steps']) > 4) {
                    $b = 4;
                    while ($sellerData['steps'][$b]) {
                  ?>
                      <div class="col-md-3">
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label for="cat_name">Title</label>
                              <input type="text" class="form-control" value="<?php echo $sellerData['steps'][$b]['title']; ?>" id="" name="titlestepseller[]">
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="cat_name">Description</label>
                              <textarea class="form-control" value="" id="" name="descriptionstepseller[]" rows="10"><?php echo $sellerData['steps'][$b]['description']; ?></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                  <?php
                      $b++;
                    }
                  }
                  ?>
                </div>

              </div>
            </div>
            <?php
            if ($editpermission) {
            ?>
              <div class="row">
                <div class="col-md-12">
                  <input type="button" value="Add More Steps" class="btn btn-primary btn-sm addsellerstepbtn">
                </div>
                <div class="col-md-12">
                  <input type="hidden" name="action" value="add">
                  <input type="submit" name="submit" class="btn btn-primary pull-right" value="Submit" />
                </div>
              </div>

            <?php
            }
            ?>
        </div>
      </div>
      </form>
      <form role="form" id="homeContents" action="<?php echo base_url(); ?>administrator/homecontents/alterhomecontents" method="post" role="form" enctype="multipart/form-data">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <input type="hidden" name="homecontentid" value="<?php echo $result->id; ?>">
        <input type="hidden" name="section" value="general">
        <div class="header_box version_2">
          <h2><i class="fa fa-file"></i>How it works for General</h2>
        </div>
        <br clear="all">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label>Section photo</label>
              <?php
              if ($generalData['image'] != '') {
              ?>
                <div class="coverImage">
                  <img id="pic-general" style="width:220px; height:220px;" src="<?php echo base_url() ?>uploads/images_extra/<?php echo $generalData['image']; ?>" prev-data-src="<?php echo base_url() ?>uploads/images_extra/<?php echo $generalData['image']; ?>" alt="">
                  <?php
                  if ($editpermission) {
                  ?>
                    <div class="col-md-12 dropzone" id="general" style="min-height:154px; display:none"> </div>
                    <button style="margin-top:10px;margin-left:30px;" class="btn btn-warning btn-xs btn-sm change-pic-general" type="button">Change Image</button>
                  <?php
                  }
                  ?>
                </div>
              <?php
              } elseif ($editpermission) {
              ?>
                <div class="col-md-12 dropzone" id="general" style="min-height:154px"> </div>
              <?php
              }
              ?>

              <input type="hidden" name="imageContentsGeneral" id="imageContentsGeneral" value="<?php echo $generalData['image']; ?>">
            </div>
          </div>
          <div class="col-md-9">
            <div class="form-group">
              <label for="cat_name">Title</label>
              <input type="text" class="form-control" value="<?php echo $generalData['title']; ?>" id="general_title" name="general_title">
            </div>
            <div class="form-group">
              <label for="cat_name">Short Description</label>
              <textarea class="form-control" value="" id="general_description" name="general_description"><?php echo $generalData['short_description']; ?></textarea>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <h6 class="header_box version_2">General Business Steps</h6>

            </div>
          </div>
          <div class="col-md-12">
            <div class="row generalsteps">
              <div class="col-md-3">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="cat_name">Title</label>
                      <input type="text" class="form-control" value="<?php echo $generalData['steps'][0]['title']; ?>" id="site_title" name="titlestepgeneral[]">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="cat_name">Description</label>
                      <textarea class="form-control" value="" id="description3" name="descriptionstepgeneral[]" rows="10"><?php echo $generalData['steps'][0]['description']; ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="cat_name">Title</label>
                      <input type="text" class="form-control" value="<?php echo $generalData['steps'][1]['title']; ?>" id="site_title" name="titlestepgeneral[]">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="cat_name">Description</label>
                      <textarea class="form-control" value="" id="" name="descriptionstepgeneral[]" rows="10"><?php echo $generalData['steps'][1]['description']; ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="cat_name">Title</label>
                      <input type="text" class="form-control" value="<?php echo $generalData['steps'][2]['title']; ?>" id="site_title" name="titlestepgeneral[]">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="cat_name">Description</label>
                      <textarea class="form-control" value="" id="" name="descriptionstepgeneral[]" rows="10"><?php echo $generalData['steps'][2]['description']; ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="cat_name">Title</label>
                      <input type="text" class="form-control" value="<?php echo $generalData['steps'][3]['title']; ?>" id="" name="titlestepgeneral[]">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="cat_name">Description</label>
                      <textarea class="form-control" value="" id="" name="descriptionstepgeneral[]" rows="10"><?php echo $generalData['steps'][3]['description']; ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <?php
              if (count($generalData['steps']) > 4) {
                $b = 4;
                while ($generalData['steps'][$b]) {
              ?>
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label for="cat_name">Title</label>
                          <input type="text" class="form-control" value="<?php echo $generalData['steps'][$b]['title']; ?>" id="" name="titlestepgeneral[]">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="cat_name">Description</label>
                          <textarea class="form-control" value="" id="" name="descriptionstepgeneral[]" rows="10"><?php echo $generalData['steps'][$b]['description']; ?></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
              <?php
                  $b++;
                }
              }
              ?>
            </div>
          </div>
          <?php
          if ($editpermission) {
          ?>
            <div class="row">
              <div class="col-md-12">
                <input type="button" value="Add More Steps" class="btn btn-primary btn-sm addgeneralstepbtn">
              </div>
            </div>
          <?php
          }
          ?>

          <div class="box-footer">
            <?php
            if ($editpermission) {
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