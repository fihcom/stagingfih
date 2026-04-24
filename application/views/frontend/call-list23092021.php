<main class="mainContainer">  
		<section class="section login-sec register-sec create-ticket">
			<div class="container">
				 <div class="register_form"> 
				 <?php
				 $success = $this->session->flashdata('successCall');
				 if($success) {
					 ?>
					 <div class="alert alert-success alert-dismissible" role="alert">
					 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					 <strong>Success!</strong> 
					 <ul>
					 <?php
					  ?>
							 <li><?php echo $success['message'];?></li>
							 <?php
					 ?>
					 </ul>   
					 </div>
					 <?php 
				 } 
			$error = $this->session->flashdata('errorCall');
			if($error) {
				$errormsg = $error['errorcall'];
				$dataVal = $error['dataval']['ret'];
				$userProfileData['fname'] = $dataVal['callScheduleName'];
				$userProfileData['phone'] = $dataVal['callSchedulePhone'];
				?>
				<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <strong>Errors!</strong> 
				<ul>
				<?php
				if(is_array($errormsg) && count($errormsg)>0)
				{
					foreach($errormsg as $val)
					{
						?>
						<li><?php echo $val;?></li>
						<?php
					}
				}
				
				?>
				</ul>   
				</div>
				<?php 
			} 
			?>
			<div><button class="btn blue-btn schedulecallbtn pull-right">Schedule Call</button>
			<form id="calllogreqform" class="form_wrap form-full-width" style="display: none" method="post" action="<?php echo base_url();?>user/sell/scheduleCall">
                     <input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
						<h2 class="heading text-center">Schedule Call</h2>
						 <ul class="row ul">
							 <li class="col-sm-4">
								 <div class="labelWrap">
									 <label for="">Name</label>
									 <input type="text" name="callScheduleName" id="" value="<?php echo $userProfileData['fname']?>">
								 </div>
                             </li>
							 <li class="col-sm-4">
								<div class="labelWrap">
									<label for="">Phone No</label>
									<input type="text" name="callSchedulePhone" id="" value="<?php echo $userProfileData['phone']?>">
								</div>
                            </li>
							<li class="col-sm-4">
								<div class="labelWrap">
									<label for="">Preferred Time of Call [EST time]</label>
									<input type="datetime-local" name="callScheduleTime" id="" value="<?php echo $dataVal['callScheduleTime']?>">
								</div>
                            </li>
							<li class="col-sm-12">
								<div class="labelWrap">
									<label for="">Special Request (If any)</label>
									<textarea name="callScheduleNote" id="" cols="30" rows="5"><?php echo $dataVal['callScheduleNote']?></textarea>
								</div>
                            </li>

							<li class="col-sm-12">
								<div class="labelWrap text-center">
                                    <!--<a class="btn sgnUp mt-2 d-block" href="#">register Now</a> -->
                                    <input type="submit" value="Submit" style="width:auto"  id="createTicket" class="btn sgnUp mt-2"></input>
								</div>
							</li>
						 </ul>
					 </form>
			</div>
                     
				 </div>
			</div>
		</section> 
		<section class="create-ticket-wrap">
		<div class="account-sec basic-info pt15">

		<div class="row pull-right search-status">
									<div class="col-md-4">
										<label>Search</label>
										<input type="text" class="form-control" name="textSearch" value="<?php echo $result->sellername;?>" id="textSearchCall" placeholder="">
									</div>
									<div class="col-md-5">
										<label>Time</label>
										<input type="datetime-local" class="form-control" name="textSearch" value="<?php echo $result->sellername;?>" id="textSearchTime" placeholder="">
									</div>
									<div class="col-md-3">
										<label>Status</label>
										<select name="statusSearch" id="statusSearchCall" class="form-control">
										<option value="">All</option>
										<option value="1">Pending</option>
										<option value="2">Denied</option>
										<option value="3">Approved</option>
										<option value="4">Completed</option>
										</select>
									</div>
      
      								</div>
									
										<div class="table-responsive">
											<table class="table table-bordered" id="usercallschedulkleTable" width="100%" cellspacing="0">
												<thead>
													<tr>
														<th class="subhead">Phone No</th>
														<th class="subhead">Scheduled Time</th>
														<th class="subhead">Note</th>
														<th class="subhead">Status</th>
													</tr>
												</thead>
												<tbody>
												
												</tbody>
												<tfoot>
													<tr>
													<th>Phone No</th>
													<th>Scheduled Time</th>
													<th>Note</th>
													<th>Status</th>
													</tr>
													</tfoot>
													<?php
													
													?>
												<tbody>
													
											</tbody>
											</table>
										</div>
										</section>
	</main> 