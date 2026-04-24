<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="FIND, INVEST & HOLD - Your Online Business Marketplace For The Best PASSIVE INCOME Deals - Buy & Sell Your Cashflow. Join Now.">
  <meta name="author" content="Ansonika">
  <meta name="robots" content="noindex, nofollow">
  <title><?php echo (isset($sitetitle)) ? $sitetitle : 'FIH - Admin dashboard';?></title>
  <!-- Standard favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url();?>assets/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url();?>assets/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url();?>assets/favicon/favicon-16x16.png">
  <link rel="manifest" href="<?php echo base_url();?>assets/favicon/site.webmanifest">
  <link rel="mask-icon" href="<?php echo base_url();?>assets/favicon/safari-pinned-tab.svg" color="#232f3e">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
  <!-- Bootstrap core CSS-->
  <link href="<?php echo base_url();?>assets/backend/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/jquery.timepicker.min.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/jquery.datetimepicker.min.css" />
  <!-- Main styles -->
  <link href="<?php echo base_url();?>assets/backend/css/admin.min.css" rel="stylesheet">
  <!-- Icon fonts-->
  <link href="<?php echo base_url();?>assets/backend/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Plugin styles -->
  <link href="<?php echo base_url();?>assets/backend/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/backend/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/backend/css/magnific-popup.min.css">
  <!-- Your custom styles -->
  <link href="<?php echo base_url();?>assets/backend/css/custom.min.css" rel="stylesheet">

  <link href="<?php echo base_url();?>assets/frontend/css/dropzone.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/backend/css/date_picker.min.css" rel="stylesheet">
  <!-- Your custom styles -->
  <!-- WYSIWYG Editor -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/backend/js/editor/summernote-bs4.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/backend/css/chosen.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/backend/css/jquery.mCustomScrollbar.min.css">
  <script type="text/javascript">
    var baseURL = '<?php echo base_url();?>';
  </script>


</head>

<body class="fixed-nav sticky-footer" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-default fixed-top" id="mainNav">
    <a class="navbar-brand" href=""><img src="<?php echo base_url();?>assets/backend/img/logo.png" data-retina="true" alt="" height="36"></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <div class="mCust">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">


      <?php
      $role = $this->session->userdata('role');
      ?>


        <li class="nav-item<?php if(isset($class) && $class=='dashboard') { echo ' active'; }?>" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="<?php echo base_url() ?>administrator/dashboard">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
        <?php
        if(checkAuthorization('USER','LIST') || checkAuthorization('IDENTITYPROOF','LIST') || checkAuthorization('FUNDPROOF','LIST'))
        {
          ?>
        <li class="nav-item<?php if(isset($class) && $class=='proof-verification') { echo ' active'; }?>" data-toggle="tooltip" data-placement="right" title="Proof Verification">
        <a class="nav-link nav-link-collapse <?php if(isset($class) && $class=='proof-verification') { echo ''; } else { echo 'collapsed'; }?>" data-toggle="collapse" href="#collapseProof" data-parent="#ProofVerification" <?php if(isset($class) && $class=='proof-verification') { echo 'aria-expanded="true"'; } ?>>
          <i class="fa fa-user"></i>
          <span class="nav-link-text">User Management</span>
        </a>
        <ul class="sidenav-second-level collapse <?php if(isset($class) && $class=='proof-verification') { echo 'show'; }?>" id="collapseProof">
        <?php
          if(checkAuthorization('USER','LIST'))
          {
            ?>
        <li>
          <a href="<?php echo base_url() ?>administrator/users">
            <span class="nav-link-text"> Users</span>
          </a>
        </li>
        <?php
          }
          if(checkAuthorization('IDENTITYPROOF','LIST'))
          {
            ?>

          <li>
            <a href="<?php echo base_url() ?>administrator/verifications/identity-proof">Identity Proof<span class="badge badge-pill badge-primary"></span></a>
          </li>
          <?php
          }
          if(checkAuthorization('FUNDPROOF','LIST'))
          {
            ?>
          <li>
            <a href="<?php echo base_url(); ?>administrator/verifications/fund-proof">Fund Proof<span class="badge badge-pill badge-success"></span></a>
          </li>
          <?php
          }
          ?>

        </ul>
      </li>
      <?php
        }
        if(checkAuthorization('BUSINESSAPPLICATION','LIST') || checkAuthorization('LISTING','LIST') || checkAuthorization('PROMOCODE','LIST') || checkAuthorization('FAQ','LIST') || checkAuthorization('LISTINGOFFERS','LIST'))
        {
        ?>



        <li class="nav-item<?php if(isset($class) && $class=='sellrequest') { echo ' active'; }?>" data-toggle="tooltip" data-placement="right" title="Listing Mnaagement">
        <a class="nav-link nav-link-collapse <?php if(isset($class) && $class=='sellrequest') { echo ''; } else { echo 'collapsed'; }?>" data-toggle="collapse" href="#collapseListing" data-parent="#listingManagement" <?php if(isset($class) && $class=='sellrequest') { echo 'aria-expanded="true"'; } ?>>
          <i class="fa fa-list"></i>
          <span class="nav-link-text">Listing Management</span>
        </a>
        <ul class="sidenav-second-level collapse <?php if(isset($class) && $class=='sellrequest') { echo 'show'; }?>" id="collapseListing">
        <?php
          if(checkAuthorization('BUSINESSAPPLICATION','LIST'))
          {
            ?>
        <li>
          <a href="<?php echo base_url() ?>administrator/sell-request">
            <span class="nav-link-text">Business Applications</span>
          </a>
        </li>
        <li>
          <a href="<?php echo base_url() ?>administrator/valuation-request">
            <span class="nav-link-text">Valuation Applications</span>
          </a>
        </li>
        <?php
          }
          if(checkAuthorization('LISTING','LIST'))
          {
            ?>
        <li>
          <a href="<?php echo base_url() ?>administrator/approved-sell">
            <span class="nav-link-text">Listings</span>
          </a>
        </li>
        <?php
          }
          if(checkAuthorization('PROMOCODE','LIST'))
          {
            ?>
        <li>
          <a href="<?php echo base_url() ?>administrator/promo-code">
            <span class="nav-link-text">Promo Code</span>
          </a>
        </li>
        <?php
          }
          if(checkAuthorization('FAQ','LIST'))
          {
            ?>
        <li>
          <a href="<?php echo base_url() ?>administrator/faqs">
            <span class="nav-link-text">FAQs</span>
          </a>
        </li>
        <?php
          }
          if(checkAuthorization('LISTINGOFFERS','LIST'))
          {
            ?>
        <li>
          <a href="<?php echo base_url() ?>administrator/listing-offers">
            <span class="nav-link-text">Listing Offers</span>
          </a>
        </li>
        <?php
        }
        ?>

        </ul>
      </li>
      <?php
        }
        if(checkAuthorization('BUYREQUEST','LIST') || checkAuthorization('WALLET','LIST') || checkAuthorization('REPORT','LIST'))
        {
        ?>

      <li class="nav-item<?php if(isset($class) && $class=='buyreq') { echo ' active'; }?>" data-toggle="tooltip" data-placement="right" title="Banking">
        <a class="nav-link nav-link-collapse <?php if(isset($class) && $class=='buyreq') { echo ''; } else { echo 'collapsed'; }?>" data-toggle="collapse" href="#collapseBanking" data-parent="#collapseBanking" <?php if(isset($class) && $class=='buyreq') { echo 'aria-expanded="true"'; } ?>>
          <i class="fa fa-bank"></i>
          <span class="nav-link-text">Banking</span>
        </a>
        <ul class="sidenav-second-level collapse <?php if(isset($class) && $class=='buyreq') { echo 'show'; }?>" id="collapseBanking">
        <?php
          if(checkAuthorization('BUYREQUEST','LIST'))
          {
            ?>
          <li>
            <a href="<?php echo base_url() ?>administrator/listing-buy-request">
              <span class="nav-link-text">Listing Buy Request</span>
            </a>
          </li>
          <?php
          }
          if(checkAuthorization('WALLET','LIST'))
          {
            ?>
          <li>
          <a href="<?php echo base_url() ?>administrator/wallet-addmoney-request">
            <span class="nav-link-text">Wallet Request</span>
          </a>
        </li>
        <?php
          }
          if(checkAuthorization('REPORT','LIST'))
          {
            ?>
          <li>
          <a class="nav-link" href="<?php echo base_url() ?>administrator/listing-commissions">
            <span class="nav-link-text">Reports</span>
          </a>
        </li>
        <?php
          }
          ?>


        </ul>
      </li>
      <?php
        }
        if(checkAuthorization('SITECONTENT','LIST') || checkAuthorization('PARTNERS','LIST') || checkAuthorization('TESTIMONIALS','LIST') || checkAuthorization('HOMECONTENTS','LIST') || checkAuthorization('CURETEDCONTENTS','LIST') || checkAuthorization('DOWNLOADEDCONTENTS','LIST') || checkAuthorization('BLOGCAT','LIST') || checkAuthorization('BLOG','LIST'))
        {
        ?>



        <li class="nav-item<?php if(isset($class) && $class=='cms-management') { echo ' active'; }?>" data-toggle="tooltip" data-placement="right" title="Free downloaded contents">
          <a class="nav-link nav-link-collapse <?php if(isset($class) && $class=='cms-management') { echo ''; } else { echo 'collapsed'; }?>" data-toggle="collapse" href="#collapseContentmanagement" data-parent="#cms-management" <?php if(isset($class) && $class=='cms-management') { echo 'aria-expanded="true"'; } ?>>
            <i class="fa fa-file"></i>
            <span class="nav-link-text">Content Management</span>
          </a>
          <ul class="sidenav-second-level collapse <?php if(isset($class) && $class=='cms-management') { echo 'show'; }?>" id="collapseContentmanagement">
          <?php
          if(checkAuthorization('SITECONTENT','LIST'))
          {
            ?>
          <li>
            <a href="<?php echo base_url() ?>administrator/cms-pages">Site Contents<span class="badge badge-pill badge-primary"></span></a>
          </li>
          <?php
          }
          if(checkAuthorization('PARTNERS','LIST'))
          {
            ?>
          <li>
            <a href="<?php echo base_url(); ?>administrator/partners">Partners<span class="badge badge-pill badge-success"></span></a>
          </li>
          <?php
          }
          if(checkAuthorization('TESTIMONIALS','LIST'))
          {
            ?>
          <li>
            <a href="<?php echo base_url(); ?>administrator/testimonials">Testimonials<span class="badge badge-pill badge-success"></span></a>
          </li>
          <?php
          }
          if(checkAuthorization('HOMECONTENTS','LIST'))
          {
            ?>
          <li>
            <a href="<?php echo base_url(); ?>administrator/homecontents">Home Contents<span class="badge badge-pill badge-success"></span></a>
          </li>
          <?php
          }
          if(checkAuthorization('CURETEDCONTENTS','LIST'))
          {
            ?>
          <li>
            <a href="<?php echo base_url(); ?>administrator/curated-content">Curated Content<span class="badge badge-pill badge-success"></span></a>
          </li>
          <?php
          }
          if(checkAuthorization('DOWNLOADEDCONTENTS','LIST'))
          {
            ?>
          <li>
            <a href="<?php echo base_url(); ?>administrator/free-downloaded-contents">Free downloaded contents<span class="badge badge-pill badge-success"></span></a>
          </li>
          <?php
          }
          if(checkAuthorization('BLOGCAT','LIST'))
          {
            ?>
          <li>
            <a href="<?php echo base_url() ?>administrator/blog-categories">Blog Category<span class="badge badge-pill badge-primary"></span></a>
          </li>
          <?php
          }
          if(checkAuthorization('BLOG','LIST'))
          {
            ?>
          <li>
            <a href="<?php echo base_url(); ?>administrator/blogs">Blog<span class="badge badge-pill badge-success"></span></a>
          </li>
          <?php
          }
          ?>
        </ul>
        </li>
        <?php
        }
        if(checkAuthorization('BASICSETTINGS','LIST') || checkAuthorization('COMMONASSETS','LIST') || checkAuthorization('INDUSTRIES','LIST') || checkAuthorization('MONETIZATION','LIST') || checkAuthorization('COMMSETTINGS','LIST') || checkAuthorization('SELLQUESTION','LIST') || checkAuthorization('SUBADMIN','LIST'))
        {
        ?>
      <!-- ==== Booking Management  href="<?php //echo base_url() ?>administrator/cms-pages"==== -->

      <li class="nav-item<?php if(isset($class) && $class=='site-settings') { echo ' active'; }?>" data-toggle="tooltip" data-placement="right" title="Site Settings">
      <a class="nav-link nav-link-collapse <?php if(isset($class) && $class=='site-settings') { echo ''; } else { echo 'collapsed'; }?>" data-toggle="collapse" href="#collapseSiteSettings" data-parent="#siteSettings" <?php if(isset($class) && $class=='site-settings') { echo 'aria-expanded="true"'; } ?>>
          <i class="fa fa-fw fa-cogs"></i>
          <span class="nav-link-text">Site Settings</span>
        </a>
        <ul class="sidenav-second-level collapse <?php if(isset($class) && $class=='site-settings') { echo 'show'; }?>" id="collapseSiteSettings">
        <?php
          if(checkAuthorization('BASICSETTINGS','LIST'))
          {
            ?>
          <li>
            <a href="<?php echo base_url() ?>administrator/site-settings">Basic Settings<span class="badge badge-pill badge-primary"></span></a>
          </li>
          <?php
          }
          if(checkAuthorization('COMMONASSETS','LIST'))
          {
            ?>
          <li>
            <a href="<?php echo base_url(); ?>administrator/site-settings/common-list-assets">Common assets<span class="badge badge-pill badge-success"></span></a>
          </li>
          <?php
          }
          if(checkAuthorization('INDUSTRIES','LIST'))
          {
            ?>
          <li>
            <a href="<?php echo base_url(); ?>administrator/site-settings/industries">Industries<span class="badge badge-pill badge-success"></span></a>
          </li>
          <?php
          }
          if(checkAuthorization('MONETIZATION','LIST'))
          {
            ?>
          <li>
            <a href="<?php echo base_url(); ?>administrator/site-settings/monetization">Monetization<span class="badge badge-pill badge-success"></span></a>
          </li>
          <?php
          }
          if(checkAuthorization('COMMSETTINGS','LIST'))
          {
            ?>
          <li>
            <a href="<?php echo base_url(); ?>administrator/site-settings/commission-settings">Commission Settings<span class="badge badge-pill badge-success"></span></a>
          </li>
          <?php
          }
          if(checkAuthorization('SELLQUESTION','LIST'))
          {
            ?>
          <li>
            <a href="<?php echo base_url(); ?>administrator/site-settings/questionadd">Sell Questions<span class="badge badge-pill badge-success"></span></a>
          </li>
          <?php
          }
          if(checkAuthorization('SUBADMIN','LIST'))
          {
            ?>
            <li>
              <a href="<?php echo base_url(); ?>administrator/sub-admin">Sub Admin<span class="badge badge-pill badge-success"></span></a>
            </li>
            <?php
          }
         ?>
        </ul>
      </li>
      <?php
        }
        if(checkAuthorization('SUPPORTTICKET','LIST') || checkAuthorization('CALLSCHEDULE','LIST'))
        {
        ?>
      <li class="nav-item<?php if(isset($class) && $class=='supportticket') { echo ' active'; }?>" data-toggle="tooltip" data-placement="right" title="Support">
          <a class="nav-link nav-link-collapse <?php if(isset($class) && $class=='supportticket') { echo ''; } else { echo 'collapsed'; }?>" data-toggle="collapse" href="#collapsesupport" data-parent="#support" <?php if(isset($class) && $class=='supportticket') { echo 'aria-expanded="true"'; } ?>>
            <i class="fa fa-life-ring"></i>
            <span class="nav-link-text">Support</span>
          </a>
          <ul class="sidenav-second-level collapse <?php if(isset($class) && $class=='supportticket') { echo 'show'; }?>" id="collapsesupport">
          <?php
          if(checkAuthorization('SUPPORTTICKET','LIST'))
          {
            ?>
          <li>
            <a href="<?php echo base_url() ?>administrator/support-ticket">Support Ticket<span class="badge badge-pill badge-primary"></span></a>
          </li>
          <?php
          }
          if(checkAuthorization('CALLSCHEDULE','LIST'))
          {
            ?>
          <li>
            <a href="<?php echo base_url(); ?>administrator/callschedule">Call schedules<span class="badge badge-pill badge-success"></span></a>
          </li>
          <?php
          }
          ?>

        </ul>
        </li>
        <?php
        }
        ?>




      <!-- ==== -->


      <!-- ==== -->


      </ul>
    </div>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item mypro" data-toggle="tooltip" data-placement="right" title="">
          <a class="nav-link" href="<?php echo base_url() ?>" target="_blank">
            <i class="fa fa-fw fa-globe"></i>
            <span class="nav-link-text">Visit Site</span>
          </a>
        </li>
        <li class="nav-item mypro" data-toggle="tooltip" data-placement="right" title="">
          <a class="nav-link" href="<?php echo base_url() ?>administrator/edit-profile">
            <i class="fa fa-fw fa-user"></i>
            <span class="nav-link-text">My Profile</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /Navigation-->
