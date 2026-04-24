<input type="hidden" id="sitepath" value="<?php echo base_url();?>">
<footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © <?php echo date('Y');?> FIH, LLC. All Rights Reserved.. </small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="<?php echo base_url() ?>administrator/logout">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript" src="<?php echo base_url();?>assets/frontend/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/backend/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url();?>assets/backend/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    
  <script type="text/javascript" src="<?php echo base_url();?>assets/backend/vendor/datatables/jquery.dataTables.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/backend/vendor/datatables/dataTables.bootstrap4.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/backend/js/jquery.validate.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/backend/js/tablednd.js"></script>
  <!-- Custom scripts for all pages-->
  <script type="text/javascript" src="<?php echo base_url();?>assets/backend/js/admin.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/backend/js/admin-lending.js"></script>
	<!-- Custom scripts for this page-->
  <script type="text/javascript" src="<?php echo base_url();?>assets/backend/js/admin-datatables.js"></script>
  <!-- Custom scripts for this page-->
  <script type="text/javascript" src="<?php echo base_url();?>assets/frontend/js/dropzone.min.js"></script>
  <?php
  if($this->uri->segment(2) == 'free-downloaded-contents')
  {
?>
  <script type="text/javascript" src="<?php echo base_url();?>assets/backend/js/dropzone.freedownloadedcontents.js"></script>
<?php
  }elseif($this->uri->segment(2) == 'curated-content')
  {
  ?>
  <script type="text/javascript" src="<?php echo base_url();?>assets/backend/js/dropzone.custom.js"></script>
  <?php
  }elseif($this->uri->segment(2) == 'homecontents')
  {
  ?>
  <script type="text/javascript" src="<?php echo base_url();?>assets/backend/js/dropzone.homecontent.js"></script>
  <?php
  }elseif($this->uri->segment(2) == 'banners')
  {
  ?>
  <script type="text/javascript" src="<?php echo base_url();?>assets/backend/js/dropzone.banner.js"></script>
  <?php
  }elseif($this->uri->segment(2) == 'blogs')
  {
    ?>
    <script type="text/javascript" src="<?php echo base_url();?>assets/backend/js/dropzone.blog.js"></script>
    <?php
  }elseif($this->uri->segment(2) == 'site-settings')
  {
    ?>
    <script type="text/javascript" src="<?php echo base_url();?>assets/backend/js/dropzone.sitesettings.js"></script>
    <?php
  }
  ?>
  <script src="https://cdn.ckeditor.com/4.8.0/full-all/ckeditor.js"></script>
  <script>
  var ck = CKEDITOR.replace( 'pageContent', {
    allowedContent : true,
    extraAllowedContent: 'input[type];span;ul;li;table;td;style;*[id];*(*);*{*}'
  });
  CKEDITOR.replace( 'pageContent1' );
  CKEDITOR.replace( 'pageContent2' );
  
</script>
  <!-- WYSIWYG Editor -->
  <script src="<?php echo base_url();?>assets/backend/js/editor/summernote-bs4.min.js"></script>
    

<script>
      $('.editor').summernote({
		    fontSizes: ['10', '14', '16', '18'],
		    toolbar: [
        // [groupName, [list of button]]
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['font', ['strikethrough']],
          ['fontsize', ['fontsize']],
          ['para', ['ul', 'ol', 'paragraph']]
        ],
        placeholder: 'Write here ....',
        tabsize: 2,
        height: 200
      });
      
  </script>
    

	
</body>
</html>
