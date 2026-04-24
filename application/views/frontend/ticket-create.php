<main class="mainContainer">  
		<section class="section login-sec register-sec create-ticket">
			<div class="container">
				 <div class="register_form"> 
				 <?php
				 $success = $this->session->flashdata('success');
				 if($success) {
					 ?>
					 <div class="alert alert-success alert-dismissible" role="alert">
					 <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					 <strong>Success!</strong> 
					 <ul>
					 <?php
					  ?>
							 <li><?php echo $success;?></li>
							 <?php
					 ?>
					 </ul>   
					 </div>
					 <?php 
				 } 
			$error = $this->session->flashdata('error');
			if($error) {
				?>
				<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <strong>Errors!</strong> 
				<ul>
				<?php
				if(is_array($this->session->flashdata('error')) && count($this->session->flashdata('error'))>0)
				{
					foreach($this->session->flashdata('error') as $val)
					{
						?>
						<li><?php echo $val;?></li>
						<?php
					}
				}
				$fieldData = $this->session->flashdata('dataval');
				?>
				</ul>   
				</div>
				<?php 
			} 
			?>
			<div><button class="btn blue-btn createticket pull-right">Create Ticket</button>
			<form id="ticketCreateFrm" class="form_wrap reg_form" style="display: none" method="post" action="<?php echo base_url();?>ticket/createAction">
                     <input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
						<h2 class="heading text-center">Create Ticket</h2>
						 <ul class="row ul">
							 <li class="col-sm-12">
								 <div class="labelWrap">
									 <label for="">Subject</label>
									 <input type="text" name="subject" value="<?php echo $fieldData['subject']?>">
								 </div>
                             </li>
							 <li class="col-sm-12">
								<div class="labelWrap">
									<label for="">Ticket Details</label>
									<textarea name="message" id="" cols="30" rows="20"><?php echo $fieldData['message']?></textarea>
									
								</div>
                            </li>
							<li class="col-sm-12">
								<div class="labelWrap text-center">
                                    <!--<a class="btn sgnUp mt-2 d-block" href="#">register Now</a> -->
                                    <input type="submit" value="Create" id="createTicket" class="btn sgnUp mt-2 d-block"></input>
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
									<div class="col-md-7">
										<label>Search</label>
										<input type="text" class="form-control" name="textSearch" value="<?php echo $result->sellername;?>" id="textSearch" placeholder="">
									</div>
									<div class="col-md-5">
										<label>Status</label>
										<select name="statusSearch" id="statusSearch" class="form-control">
										<option value="">All</option>
										<option value="1">Open</option>
										<option value="2">Closed</option></select>
									</div>
      
      								</div>
										<div class="table-responsive">
											<table class="table table-bordered" id="usersupportticketTable" width="100%" cellspacing="0">
												<thead>
													<tr>
														<th class="subhead">Ticket ID</th>
														<th class="subhead">User Name</th>
														<th class="subhead">Subject</th>
														<th class="subhead">Date</th>
														<th class="subhead">Status</th>
														<th class="subhead">Action</th>
													</tr>
												</thead>
												<tbody>
												
												</tbody>
												<tfoot>
													<tr>
													<th>Ticket ID</th>
													<th>User Name</th>
													<th>Subject</th>
													<th>Date</th>
													<th>Status</th>
													<th>Action</th>
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