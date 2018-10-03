 <!-- Main Navbar-->
<header class="header">
  <nav class="navbar">
    <!-- Search Box-->
    <div class="search-box">
      <button class="dismiss"><i class="icon-close"></i></button>
      <form id="searchForm" action="#" role="search">
        <input type="search" placeholder="What are you looking for..." class="form-control">
      </form>
    </div>
    <div class="container-fluid">
      <div class="navbar-holder d-flex align-items-center justify-content-between">
          
        <!-- Navbar Header-->
        <div class="navbar-header">
            <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
          <!-- Navbar Brand -->
          
          <a href="<?php echo site_url('user'); ?>" id="header_logo" class="">
              
              <img style="margin-top: -5px;" src="<?php echo base_url().'assets/img/jmp_logo_2.png';?>" />
<!--            <div class="brand-text brand-big"><span>HALLS </span><strong>4ALL</strong></div>
              <div class="brand-text brand-big"><span style="display: inline-block;width: 100px;"><?php //echo SYSTEM_NAME; ?> </span></div>
            <div class="brand-text brand-small"><strong><?php echo SYSTEM_NAME_SHORT; ?></strong></div>
          -->
          </a>
          
        </div>
        <!-- Navbar Menu -->
        <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
          
          <!-- Logout    -->
          <li class="nav-item"><a href="<?php echo isset($logout)? site_url($logout): site_url('user/logout');?>" class="nav-link logout">Logout<i class="fa fa-sign-out"></i></a></li>
        </ul>
      </div>
    </div>
  </nav>
</header>
<div class="page-content d-flex align-items-stretch">
    