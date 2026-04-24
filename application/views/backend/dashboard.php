<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url();?>administrator">Dashboard</a>
        </li>
      </ol>
      <div class="box_general padding_bottom site-setting-area">
      <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="header_box version_2">
          </div>
<ul id="notificationul">

											<?php

											if(is_array($notification) && count($notification)>0)
											{
												foreach($notification as $k=>$val)
												{
													?>
													<li id="notification<?php echo $val['id'];?>"><i class="fa fa-bell" aria-hidden="true"></i>
                                                    <a href="<?php echo base_url();?><?php echo $val['admin_link'];?>">

													<div class="<?php echo ($val['unread'] == 'Y')?'notification-box-unread':'notification-box'?>">
														<?php echo $val['notification_text'];?> <br> <div class="date"> As on <?php echo $val['monthFormated']?>
														<a href="javascript: void(0);" class="delete" onclick="javascript: deletenotification(this)" datadeletehref="<?php echo base_url();?>administrator/removenotification/<?php echo $val['id']?>"><i class="fa fa-trash" aria-hidden="true"></i></a></div>
													</div>
                                                    </a>
													</li> 
													<?php
												}
											}else{
												?>
												<li>No new Notifications found.</li> 
												<?php
											}
											?>
											</ul>
                                            <div id="notificationskeleton" style="display: none">
												<li id="notificationNOTIFICATIONID"><i class="fa fa-bell" aria-hidden="true"></i>
													<a href="<?php echo base_url();?>adminlinknotification">
													<div class="NOTIFICATIONBOX">
														[NOTIFICATIONTEXT] <br> As on [NOTIFICATIONDATE]
														<a href="javascript: void(0);" class="delete" onclick="javascript: deletenotification(this)" datadeletehref="<?php echo base_url();?>administrator/removenotification/NOTIFICATIONID"><i class="fa fa-trash" aria-hidden="true"></i></a>
													</div>
													</a>
													</li>
												</div>
                                                <?php
												if($totalrecord->totalrecord > $notificationlimit)
												{
													?>
														<a href="javascript: void(0);" class="readmore showallnotifications">Show More</a>
														<input type="hidden" id="loadmorestart" value="<?php echo $notificationstart+$notificationlimit;?>">
														<input type="hidden" id="loadmorelimit" value="<?php echo $notificationlimit;?>">
														<input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
														
													<?php
												}
												?>
                                            </div>
      </div>
    </div>    
    </div>
  </div>
</div>
<div class="modal fade" id="deletenotificationModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to delete this notification?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-footer">
        <form action="" method="post" id="delformnotification">
        <input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <button type="button" class="btn btn-primary delnotification">Delete</button>
        </form>
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div>
  </div>
</div>