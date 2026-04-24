<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url();?>administrator">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Sub Admin</li>
      </ol>
      <div class="box_general padding_bottom site-setting-area">
      <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="header_box version_2">
            <h2><i class="fa fa-file"></i>Edit Sub Admin</h2>
            <a style="float:right;" class="btn btn-primary btn-sm addasset" href="<?php echo base_url(); ?>administrator/sub-admin">Back to list</a>
          </div><!-- /.box-header -->
          <!-- form start -->
          <?php 
              $error = $this->session->flashdata('error');
              
              if($error) {
                $dataval = $this->session->flashdata('dataval');

                ?>
                <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <ul>
                  <?php
                  foreach($error as $val)
                  {
                    ?>
                    <li><?php echo $val?></li>
                    <?php
                  }
                  ?>        
                  </ul>        
                </div>
                <?php 
              } 
              if($dataval['authorize'] !='')
              {

                $authArr = explode('|',$dataval['authorize']);
                if(is_array($authArr) && count($authArr)>0)
                {
                  foreach($authArr as $k=>$v)
                  {
                    //USER:EDIT,DELETE
                    $authIndiArr = explode(':',$v);
                    $authIndiValArr = explode(',',$authIndiArr[1]);
                    $newAuthArr[$authIndiArr[0]] = $authIndiValArr;
                  }
                }
                
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
            <form role="form" id="subadmineditfrm" action="<?php echo base_url(); ?>administrator/sub-admin/alter" method="post" role="form">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <input type="hidden" name="userId" id="userId" value="<?php echo $dataval['userId']?>">
            <div class="row">
                <div class="col-md-4">                                
                  <div class="form-group">
                      <label for="cat_name">First Name</label>
                      <input type="text" class="form-control" value="<?php echo $dataval['fname'] ?>" id="firstName" name="fname">
                  </div>
                </div>
                <div class="col-md-4">                                
                  <div class="form-group">
                      <label for="cat_name">Last Name</label>
                      <input type="text" class="form-control" value="<?php echo $dataval['lname'] ?>" id="lastName" name="lname">
                  </div>
                </div>
                <div class="col-md-4">                                
                  <div class="form-group">
                      <label for="cat_name">Email</label>
                      <input type="text" class="form-control" value="<?php echo $dataval['email'] ?>" id="email" name="email">
                  </div>
                </div>
                <div class="col-md-4">                                
                  <div class="form-group">
                      <label for="cat_name">Password</label>
                      <input type="password" class="form-control" value="" id="password" name="password">
                  </div>
                </div>
                <div class="col-md-4">                                
                  <div class="form-group">
                      <label for="cat_name">Confirm Password</label>
                      <input type="password" class="form-control" value="" id="conpassword" name="conpassword">
                  </div>
                </div>
                <div class="col-md-12">                                
                  <div class="form-group">
                      <label for="cat_name">User Management</label>
                      <div class="row">

                          <div class="col-sm-12 mb-2">
                            <div class="row">
                              <div class="col-md-4"><span><input type="checkbox" name="authorize[user]" value="USER" id="user" section="user" <?php echo array_key_exists("USER",$newAuthArr) ? 'checked':''?> class="permissionsettings">User </span></div>
                              <div class="col-md-8"><span class="mr-2"><input type="checkbox" name="subauthorize[user][edit]" id="user_edit" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['USER']) ? 'checked':''?>>Edit </span><span><input type="checkbox" name="subauthorize[user][delete]" value="DELETE" <?php echo in_array("DELETE",$newAuthArr['USER']) ? 'checked':''?> id="user_delete">Delete </span></div>
                            </div>
                          </div>
                          <div class="col-sm-12 mb-2">
                            <div class="row">
                                <div class="col-md-4"><span><input type="checkbox" name="authorize[identityproof]" value="IDENTITYPROOF" id="identityproof" class="permissionsettings" section="identityproof" <?php echo array_key_exists("IDENTITYPROOF",$newAuthArr) ? 'checked':''?>>Identity Proof </span></div>
                                <div class="col-md-8"><span class="mr-2"><input type="checkbox" name="subauthorize[identityproof][edit]" id="identityproof_edit" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['IDENTITYPROOF']) ? 'checked':''?>>Approve/Reject Identity </span></div>
                            </div>
                          </div>
                          <div class="col-sm-12 mb-2">
                            <div class="row">
                                <div class="col-md-4"><span><input type="checkbox" name="authorize[fundproof]" value="FUNDPROOF" id="fundproof" class="permissionsettings" section="fundproof" <?php echo array_key_exists("FUNDPROOF",$newAuthArr) ? 'checked':''?>>Fund Proof </span></div>
                              <div class="col-md-8"><span class="mr-2"><input type="checkbox" name="subauthorize[fundproof][edit]" id="fundproof_edit" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['FUNDPROOF']) ? 'checked':''?>>Approve/Reject Fund </span>
                            </div>
                          </div>
                      </div>


                      
                  </div>
                </div>
              </div>
                <div class="col-md-12">                                
                  <div class="form-group">
                      <label for="cat_name">Listing Management</label>
                      <div class="row">
                          <div class="col-sm-12 mb-2">
                            <div class="row">
                                <div class="col-md-4"><span><input type="checkbox" name="authorize[businessapplication]" value="BUSINESSAPPLICATION" id="user" class="permissionsettings" section="businessapplication" <?php echo array_key_exists("BUSINESSAPPLICATION",$newAuthArr) ? 'checked':''?>>Business Application </span></div>
                                <div class="col-md-8"><span class="mr-2"><input type="checkbox" name="subauthorize[businessapplication][approve]" id="businessapplication_approve" value="APPROVE" <?php echo in_array("APPROVE",$newAuthArr['BUSINESSAPPLICATION']) ? 'checked':''?>>Approve </span><span><input type="checkbox" name="subauthorize[businessapplication][delete]" value="DELETE" <?php echo in_array("DELETE",$newAuthArr['BUSINESSAPPLICATION']) ? 'checked':''?> id="businessapplication_delete">Delete </span></div>
                            </div>
                          </div>
                          <div class="col-sm-12 mb-2">
                            <div class="row">
                                <div class="col-md-4"><span><input type="checkbox" name="authorize[listing]" value="LISTING" id="listing" class="permissionsettings" section="listing" <?php echo array_key_exists("LISTING",$newAuthArr) ? 'checked':''?>>Listing </span></div>
                                <div class="col-md-8"><span class="mr-2"><input type="checkbox" name="subauthorize[listing][edit]" id="listing_edit" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['LISTING']) ? 'checked':''?>>Edit </span><span><input type="checkbox" name="subauthorize[listing][delete]" value="DELETE" <?php echo in_array("DELETE",$newAuthArr['LISTING']) ? 'checked':''?> id="listing_delete">Delete </span></div>
                            </div>
                          </div>

                          <div class="col-sm-12 mb-2">
                            <div class="row">
                                <div class="col-md-4"><span><input type="checkbox" name="authorize[promocode]" value="PROMOCODE" id="promocode" class="permissionsettings" section="promocode" <?php echo array_key_exists("PROMOCODE",$newAuthArr) ? 'checked':''?>>Promo Code </span></div>
                                <div class="col-md-8"><span class="mr-2"><input type="checkbox" name="subauthorize[promocode][add]" id="promocode_add" value="ADD" <?php echo in_array("ADD",$newAuthArr['PROMOCODE']) ? 'checked':''?>>Add </span><span class="mr-2"><input type="checkbox" name="subauthorize[promocode][edit]" id="promocode_edit" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['PROMOCODE']) ? 'checked':''?>>Edit </span><span><input type="checkbox" name="subauthorize[promocode][delete]" value="DELETE" <?php echo in_array("DELETE",$newAuthArr['PROMOCODE']) ? 'checked':''?> id="promocode_delete">Delete </span></div>
                            </div>
                          </div>
                          <div class="col-sm-12 mb-2">
                            <div class="row">
                                <div class="col-md-4"><span><input type="checkbox" name="authorize[faq]" value="FAQ" id="faq" class="permissionsettings" section="faq" <?php echo array_key_exists("FAQ",$newAuthArr) ? 'checked':''?>>FAQ </span></div>
                                <div class="col-md-8"><span class="mr-2"><input type="checkbox" name="subauthorize[faq][delete]" value="DELETE" <?php echo in_array("DELETE",$newAuthArr['FAQ']) ? 'checked':''?> id="faq_delete">Delete </span></div>
                            </div>
                          </div>
                          <div class="col-sm-12 mb-2">
                            <div class="row">
                                <div class="col-md-4"><span><input type="checkbox" name="authorize[listingoffers]" value="LISTINGOFFERS" id="listingoffers" class="permissionsettings" section="listingoffers" <?php echo array_key_exists("LISTINGOFFERS",$newAuthArr) ? 'checked':''?>>Promo Code </span></div>
                                <div class="col-md-8"><span class="mr-2"><input type="checkbox" name="subauthorize[listingoffers][edit]" id="listingoffers_edit" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['LISTINGOFFERS']) ? 'checked':''?>>Edit </span><span><input type="checkbox" name="subauthorize[listingoffers][delete]" value="DELETE" <?php echo in_array("DELETE",$newAuthArr['LISTINGOFFERS']) ? 'checked':''?> id="listingoffers_delete">Delete </span></div>
                            </div>
                          </div>
                          
                          
                      </div>
                      
                  </div>
                </div>

                <div class="col-md-12">                                
                  <div class="form-group">
                      <label for="cat_name">Banking</label>
                      <div class="row">
                      <div class="col-sm-12 mb-2">
                        <div class="row">
                            <div class="col-md-4"><span><input type="checkbox" name="authorize[buyrequest]" value="BUYREQUEST" id="user" class="permissionsettings" section="buyrequest" <?php echo array_key_exists("BUYREQUEST",$newAuthArr) ? 'checked':''?>>Listing Buy Request</span></div>
                            <div class="col-md-8"><span class="mr-2"><input type="checkbox" name="subauthorize[buyrequest][delete]" value="DELETE" <?php echo in_array("DELETE",$newAuthArr['BUYREQUEST']) ? 'checked':''?> id="buyrequest_delete">Approve/Reject </span></div>
                        </div>
                      </div>
                      <div class="col-sm-12 mb-2">
                          <div class="row">
                              <div class="col-md-4"><span><input type="checkbox" name="authorize[wallet]" value="WALLET" id="wallet" class="permissionsettings" section="wallet" <?php echo array_key_exists("WALLET",$newAuthArr) ? 'checked':''?>>Wallet Request </span></div>
                              <div class="col-md-8"><span class="mr-2"><input type="checkbox" name="subauthorize[wallet][delete]" value="DELETE" <?php echo in_array("DELETE",$newAuthArr['WALLET']) ? 'checked':''?> id="wallet_delete">Approve/Reject </span></div>
                          </div>
                      </div>
                      <div class="col-sm-12 mb-2">
                            <div class="row">
                                <div class="col-md-4"><span><input type="checkbox" name="authorize[report]" value="REPORT" id="report" class="permissionsettings" section="report" <?php echo array_key_exists("REPORT",$newAuthArr) ? 'checked':''?>>Report</span></div>
                                <div class="col-md-8"><span class="mr-2"><input type="checkbox" name="subauthorize[report][edit]" id="report_edit" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['REPORT']) ? 'checked':''?>>Edit </span></div>
                      </div>
                          </div>
                          

                          

                          

                          </div>
                      
                  </div>
                </div>
                <div class="col-md-12">                                
                  <div class="form-group">
                      <label for="cat_name">Content Management</label>
                      <div class="row">
                          <div class="col-sm-12 mb-2">
                            <div class="row">
                                <div class="col-md-4">
                                  <span><input type="checkbox" name="authorize[sitecontent]" value="SITECONTENT" id="user" class="permissionsettings" section="sitecontent" <?php echo array_key_exists("SITECONTENT",$newAuthArr) ? 'checked':''?>>Site Contents</span>
                                </div>
                              <div class="col-md-8">
                                <span class="mr-2"><input type="checkbox" name="subauthorize[sitecontent][add]" value="ADD" <?php echo in_array("ADD",$newAuthArr['SITECONTENT']) ? 'checked':''?> id="sitecontent_add">Add </span>
                                <span class="mr-2"><input type="checkbox" name="subauthorize[sitecontent][edit]" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['SITECONTENT']) ? 'checked':''?> id="sitecontent_edit">Edit </span>
                                <span><input type="checkbox" name="subauthorize[sitecontent][delete]" value="DELETE" <?php echo in_array("DELETE",$newAuthArr['SITECONTENT']) ? 'checked':''?> id="sitecontent_delete">Delete </span>
                              </div> 
                            </div>
                          </div>
                          <div class="col-sm-12 mb-2">
                            <div class="row">
                                <div class="col-md-4">
                                <span><input type="checkbox" name="authorize[partners]" value="PARTNERS" id="user" class="permissionsettings" section="partners" <?php echo array_key_exists("PARTNERS",$newAuthArr) ? 'checked':''?>>Partners</span>
                              </div>
                              <div class="col-md-8">
                                <span class="mr-2"><input type="checkbox" name="subauthorize[partners][add]" value="ADD" <?php echo in_array("ADD",$newAuthArr['PARTNERS']) ? 'checked':''?> id="partners_add">Add </span>
                                <span><input type="checkbox" name="subauthorize[partners][delete]" value="DELETE" <?php echo in_array("DELETE",$newAuthArr['PARTNERS']) ? 'checked':''?> id="partners_delete">Delete </span>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-12 mb-2">
                            <div class="row">
                              <div class="col-md-4">
                                <span><input type="checkbox" name="authorize[testimonials]" value="TESTIMONIALS" id="user" class="permissionsettings" section="testimonials" <?php echo array_key_exists("TESTIMONIALS",$newAuthArr) ? 'checked':''?>>Testimonials</span>
                              </div>
                              <div class="col-md-8">
                                <span class="mr-2"><input type="checkbox" name="subauthorize[testimonials][add]" value="ADD" <?php echo in_array("ADD",$newAuthArr['TESTIMONIALS']) ? 'checked':''?> id="testimonials_add">Add </span>
                                <span class="mr-2"><input type="checkbox" name="subauthorize[testimonials][edit]" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['TESTIMONIALS']) ? 'checked':''?> id="testimonials_edit">Edit </span>
                                <span><input type="checkbox" name="subauthorize[testimonials][delete]" value="DELETE" <?php echo in_array("DELETE",$newAuthArr['TESTIMONIALS']) ? 'checked':''?> id="testimonials_delete">Delete </span>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-12 mb-2">
                            <div class="row">
                              <div class="col-md-4">
                                <span><input type="checkbox" name="authorize[homecontents]" value="HOMECONTENTS" id="user" class="permissionsettings" section="homecontents" <?php echo array_key_exists("HOMECONTENTS",$newAuthArr) ? 'checked':''?>>Home Contents</span>
                              </div>
                              <div class="col-md-8">
                                <span class="mr-2"><input type="checkbox" name="subauthorize[homecontents][edit]" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['HOMECONTENTS']) ? 'checked':''?> id="homecontents_edit">Edit </span>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-12 mb-2">
                            <div class="row">
                              <div class="col-md-4">
                                <span><input type="checkbox" name="authorize[curetedcontents]" value="CURETEDCONTENTS" id="user" class="permissionsettings" section="curetedcontents" <?php echo array_key_exists("CURETEDCONTENTS",$newAuthArr) ? 'checked':''?>>Cureted Contents</span>
                              </div>
                              <div class="col-md-8">
                                <span class="mr-2"><input type="checkbox" name="subauthorize[curetedcontents][add]" value="ADD" <?php echo in_array("ADD",$newAuthArr['CURETEDCONTENTS']) ? 'checked':''?> id="curetedcontents_add">Add </span>
                                <span class="mr-2"><input type="checkbox" name="subauthorize[curetedcontents][edit]" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['CURETEDCONTENTS']) ? 'checked':''?> id="curetedcontents_edit">Edit </span>
                                <span><input type="checkbox" name="subauthorize[curetedcontents][delete]" value="DELETE" <?php echo in_array("DELETE",$newAuthArr['CURETEDCONTENTS']) ? 'checked':''?> id="curetedcontents_delete">Delete </span>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-12 mb-2">
                            <div class="row">
                              <div class="col-md-4">
                                <span><input type="checkbox" name="authorize[downloadedcontents]" value="DOWNLOADEDCONTENTS" id="user" class="permissionsettings" section="downloadedcontents" <?php echo array_key_exists("DOWNLOADEDCONTENTS",$newAuthArr) ? 'checked':''?>>Free Downloaded Contents</span>
                              </div>
                              <div class="col-md-8">
                                <span class="mr-2"><input type="checkbox" name="subauthorize[downloadedcontents][add]" value="ADD" <?php echo in_array("ADD",$newAuthArr['DOWNLOADEDCONTENTS']) ? 'checked':''?> id="downloadedcontents_add">Add </span>
                                <span class="mr-2"><input type="checkbox" name="subauthorize[downloadedcontents][edit]" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['DOWNLOADEDCONTENTS']) ? 'checked':''?> id="downloadedcontents_edit">Edit </span>
                                <span><input type="checkbox" name="subauthorize[downloadedcontents][delete]" value="DELETE" <?php echo in_array("DELETE",$newAuthArr['DOWNLOADEDCONTENTS']) ? 'checked':''?> id="downloadedcontents_delete">Delete </span>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-12 mb-2">
                            <div class="row">
                              <div class="col-md-4">
                                <span><input type="checkbox" name="authorize[blogcat]" value="BLOGCAT" id="user" class="permissionsettings" section="blogcat" <?php echo array_key_exists("BLOGCAT",$newAuthArr) ? 'checked':''?>>Blog Category</span>
                              </div>
                              <div class="col-md-8">
                                <span class="mr-2"><input type="checkbox" name="subauthorize[blogcat][add]" value="ADD" <?php echo in_array("ADD",$newAuthArr['BLOGCAT']) ? 'checked':''?> id="blogcat_add">Add </span>
                                <span class="mr-2"><input type="checkbox" name="subauthorize[blogcat][edit]" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['BLOGCAT']) ? 'checked':''?> id="blogcat_edit">Edit </span>
                                <span><input type="checkbox" name="subauthorize[blogcat][delete]" value="DELETE" <?php echo in_array("DELETE",$newAuthArr['BLOGCAT']) ? 'checked':''?> id="blogcat_delete">Delete </span>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-12 mb-2">
                            <div class="row">
                              <div class="col-md-4">
                                <span><input type="checkbox" name="authorize[blog]" value="BLOG" id="user" class="permissionsettings" section="blog" <?php echo array_key_exists("BLOG",$newAuthArr) ? 'checked':''?>>Blog</span>
                              </div>
                              <div class="col-md-8">
                                <span class="mr-2"><input type="checkbox" name="subauthorize[blog][add]" value="ADD" <?php echo in_array("ADD",$newAuthArr['BLOG']) ? 'checked':''?> id="blog_add">Add </span>
                                <span class="mr-2"><input type="checkbox" name="subauthorize[blog][edit]" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['BLOG']) ? 'checked':''?> id="blog_edit">Edit </span>
                                <span><input type="checkbox" name="subauthorize[blog][delete]" value="DELETE" <?php echo in_array("DELETE",$newAuthArr['BLOG']) ? 'checked':''?> id="blog_delete">Delete </span>
                              </div>
                            </div>
                          </div>
                          </div>
                  </div>
                </div>
                
                <div class="col-md-12">                                
                  <div class="form-group">
                      <label for="cat_name">Site Settings</label>
                      <div class="row">

                          <div class="col-sm-12 mb-2">
                            <div class="row">
                              <div class="col-md-4"><span><input type="checkbox" name="authorize[basicsettings]" value="BASICSETTINGS" id="basicsettings" section="basicsettings" <?php echo array_key_exists("BASICSETTINGS",$newAuthArr) ? 'checked':''?> class="permissionsettings">Basic Settings </span></div>
                              <div class="col-md-8">
                              <span class="mr-2"><input type="checkbox" name="subauthorize[basicsettings][edit]" id="basicsettings_edit" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['BASICSETTINGS']) ? 'checked':''?>>Edit </span>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-12 mb-2">
                            <div class="row">
                                <div class="col-md-4"><span><input type="checkbox" name="authorize[commonassets]" value="COMMONASSETS" id="commonassets" class="permissionsettings" section="commonassets" <?php echo array_key_exists("COMMONASSETS",$newAuthArr) ? 'checked':''?>>Common Assets </span></div>
                                <div class="col-md-8"><span class="mr-2"><input type="checkbox" name="subauthorize[commonassets][add]" id="commonassets_add" value="ADD" <?php echo in_array("ADD",$newAuthArr['COMMONASSETS']) ? 'checked':''?>>Add </span><span class="mr-2"><input type="checkbox" name="subauthorize[commonassets][edit]" id="commonassets_edit" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['COMMONASSETS']) ? 'checked':''?>>Edit </span><span><input type="checkbox" name="subauthorize[commonassets][delete]" value="DELETE" <?php echo in_array("DELETE",$newAuthArr['COMMONASSETS']) ? 'checked':''?> id="commonassets_delete">Delete </span></div>
                            </div>
                          </div>
                          <div class="col-sm-12 mb-2">
                            <div class="row">
                                <div class="col-md-4"><span><input type="checkbox" name="authorize[industries]" value="INDUSTRIES" id="industries" class="permissionsettings" section="industries" <?php echo array_key_exists("INDUSTRIES",$newAuthArr) ? 'checked':''?>>Industries </span></div>
                                <div class="col-md-8"><span class="mr-2"><input type="checkbox" name="subauthorize[industries][add]" id="industries_add" value="ADD" <?php echo in_array("ADD",$newAuthArr['INDUSTRIES']) ? 'checked':''?>>Add </span><span class="mr-2"><input type="checkbox" name="subauthorize[industries][edit]" id="industries_edit" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['INDUSTRIES']) ? 'checked':''?>>Edit </span><span><input type="checkbox" name="subauthorize[industries][delete]" id="industries_delete" value="DELETE" <?php echo in_array("DELETE",$newAuthArr['INDUSTRIES']) ? 'checked':''?>>Delete </span></div>
                            </div>
                          </div>
                          <div class="col-sm-12 mb-2">
                            <div class="row">
                                <div class="col-md-4"><span><input type="checkbox" name="authorize[monetization]" value="MONETIZATION" id="monetization" class="permissionsettings" section="monetization" <?php echo array_key_exists("MONETIZATION",$newAuthArr) ? 'checked':''?>>Monetization </span></div>
                                <div class="col-md-8"><span class="mr-2"><input type="checkbox" name="subauthorize[monetization][add]" id="monetization_add" value="ADD" <?php echo in_array("ADD",$newAuthArr['MONETIZATION']) ? 'checked':''?>>Add </span><span class="mr-2"><input type="checkbox" name="subauthorize[monetization][edit]" id="monetization_edit" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['MONETIZATION']) ? 'checked':''?>>Edit </span><span><input type="checkbox" name="subauthorize[monetization][delete]" id="monetization_delete" value="DELETE" <?php echo in_array("DELETE",$newAuthArr['MONETIZATION']) ? 'checked':''?>>Delete </span></div>
                            </div>
                          </div>
                          <div class="col-sm-12 mb-2">
                            <div class="row">
                                <div class="col-md-4"><span><input type="checkbox" name="authorize[commsettings]" value="COMMSETTINGS" id="commsettings" class="permissionsettings" section="commsettings" <?php echo array_key_exists("COMMSETTINGS",$newAuthArr) ? 'checked':''?>>Commission Settings </span></div>
                                <div class="col-md-8"><span class="mr-2"><input type="checkbox" name="subauthorize[commsettings][add]" id="commsettings_add" value="ADD" <?php echo in_array("ADD",$newAuthArr['COMMSETTINGS']) ? 'checked':''?>>Add </span><span class="mr-2"><input type="checkbox" name="subauthorize[commsettings][edit]" id="commsettings_edit" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['COMMSETTINGS']) ? 'checked':''?>>Edit </span><span><input type="checkbox" name="subauthorize[commsettings][delete]" id="commsettings_delete" value="DELETE" <?php echo in_array("DELETE",$newAuthArr['COMMSETTINGS']) ? 'checked':''?>>Delete </span></div>
                            </div>
                          </div>
                          <div class="col-sm-12 mb-2">
                            <div class="row">
                                <div class="col-md-4"><span><input type="checkbox" name="authorize[sellquestion]" value="SELLQUESTION" id="sellquestion" class="permissionsettings" section="sellquestion" <?php echo array_key_exists("SELLQUESTION",$newAuthArr) ? 'checked':''?>>Sell Question </span></div>
                                <div class="col-md-8"><span class="mr-2"><input type="checkbox" name="subauthorize[sellquestion][edit]" id="sellquestion_edit" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['SELLQUESTION']) ? 'checked':''?>>Edit </span></div>
                            </div>
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-md-12">                                
                  <div class="form-group">
                      <label for="cat_name">Support</label>
                      <div class="row">

                          <div class="col-sm-12 mb-2">
                            <div class="row">
                              <div class="col-md-4"><span><input type="checkbox" name="authorize[supportticket]" value="SUPPORTTICKET" id="supportticket" section="supportticket" <?php echo array_key_exists("SUPPORTTICKET",$newAuthArr) ? 'checked':''?> class="permissionsettings">Support Ticket </span></div>
                              <div class="col-md-8">
                              <span class="mr-2"><input type="checkbox" name="subauthorize[supportticket][edit]" id="supportticket_edit" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['SUPPORTTICKET']) ? 'checked':''?>>Reply/Close ticket </span>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-12 mb-2">
                            <div class="row">
                                <div class="col-md-4"><span><input type="checkbox" name="authorize[callschedule]" value="CALLSCHEDULE" id="callschedule" class="permissionsettings" section="callschedule" <?php echo array_key_exists("CALLSCHEDULE",$newAuthArr) ? 'checked':''?>>Call Schedule </span></div>
                                <div class="col-md-8"><span class="mr-2"><input type="checkbox" name="subauthorize[callschedule][edit]" id="callschedule_edit" value="EDIT" <?php echo in_array("EDIT",$newAuthArr['CALLSCHEDULE']) ? 'checked':''?>>Edit </span></div>
                            </div>
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