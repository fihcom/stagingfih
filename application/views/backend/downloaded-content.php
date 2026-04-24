<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo base_url().'administrator';?>">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Free Downloaded Contents</li>
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
          <a style="float:right;" class="btn btn-primary btn-sm" href="<?php echo base_url() ?>administrator/free-downloaded-contents/add"><i class="fa fa-plus"></i> Add Free Downloaded Contents </a>
          <?php
        }
        ?>
        
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered <?php echo ($editpermission)?'dragtablecurated':'';?>" id="" width="100%" cellspacing="0" data-count="">
          <thead>
            <tr>
              <th>Sl No.</th>
              <th>Image</th>
              <th>Title</th>
              <th>Description</th>
              <th>Download Link</th>
              <th>Display in</th>
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
            $imageArr = json_decode($val['image'],true)
            ?>
            <tr id="<?php echo $val['id']?>">
            <td><?php echo $i;?></td>
            <td><img style="width:100px;" src="<?php echo base_url() ?>uploads/images_extra/<?php echo $imageArr[0];?>" alt=""></td>
            <td><?php echo $val['title']?></td>
            <td><?php echo substr(strip_tags($val['description']),0,70);?>...</td>
            <td><a href="<?php echo $val['download_link'];?>"><?php echo substr($val['download_link'],0,50)?>...</a></td>
            <td><?php echo $val['reply_to']?></td>
            <td>
            <?php
            if($editpermission)
            {
              ?>
              <a href="<?php echo base_url()?>administrator/free-downloaded-contents/edit/<?php echo $val['id'];?>" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>
              <?php
            }if($deletepermission)
            {
              ?>
              &nbsp;<a href="javascript: void(0)" onclick="deleterecord(this)" datadeletehref="<?php echo base_url()?>administrator/free-downloaded-contents/delete/<?php echo $val['id'];?>" class="btn-sm btn-danger deleterec"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
              <th>Image</th>
              <th>Title</th>
              <th>Description</th>
              <th>Download Link</th>
              <th>Display in</th>
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
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to delete this content?</h4>
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



