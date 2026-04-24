<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo base_url().'administrator';?>">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Testimonials</li>
    </ol>
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
  <!-- Example DataTables Card-->
    <div class="card mb-3">
      <div class="card-header">
        <i class="fa fa-list"></i> Lists
        <?php
        if($addpermission)
        {
          ?>
          <a style="float:right;" class="btn btn-primary btn-sm" href="<?php echo base_url() ?>administrator/testimonial/add"><i class="fa fa-plus"></i> Add New Testionial </a>
          <?php
        }
        ?>
        
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered <?php echo ($editpermission)?'dragtabletestimonial':'';?>" id="" width="100%" cellspacing="0" data-count="">
          <thead>
            <tr>
              <th>Sl No.</th>
              <th>Description</th>
              <th>Author</th>
              <th>Designation</th>
              <th>Date Added</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $i=1;
          if(is_array($result) && count($result)>0)
          {
            foreach($result as $val)
            {
            
            ?>
            <tr id="<?php echo $val['id']?>">
            <td><?php echo $i;?></td>
            <td><?php echo substr(strip_tags($val['description']),0,66);?>...</td>
            <td><?php echo $val['author']?></td>
            <td><?php echo $val['designation']?></td>
            <td><?php echo date('jS M Y',strtotime($val['date_added']))?></td>
            <td>
            <?php
            if($editpermission)
            {
              ?>
              <a href="<?php echo base_url()?>administrator/testimonial/edit/<?php echo $val['id'];?>" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>
              <?php
            }if($deletepermission)
            {
            ?>
              &nbsp;<a href="javascript: void(0)" onclick="deleterecord(this)" datadeletehref="<?php echo base_url()?>administrator/testimonial/delete/<?php echo $val['id'];?>" class="btn-sm btn-danger deleterec"><i class="fa fa-trash" aria-hidden="true"></i></a>
            <?php
            }
            ?>
              </td>
            </tr>
            <?php
            $i++;
            }
          }else{
            ?>
            <tr>
            <td colspan="7"style="text-align: center;">No record found.</td>
            </tr>
            
            <?php
          }
          ?>
          </tbody>
          <tfoot>
            <tr>
            <th>Sl No.</th>
              <th>Description</th>
              <th>Author</th>
              <th>Designation</th>
              <th>Date Added</th>
              <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
              
            </tbody>
          </table>
        </div>
      </div>
      <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
    </div>
  <!-- /tables-->
  </div>
  <!-- /container-fluid-->
</div>


<div class="modal fade" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to delete this testimonial?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-footer">
        <form action="" method="post" id="delform">
        <input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <button type="submit" class="btn btn-primary">Delete</button>
        </form>
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div>
  </div>
</div>



