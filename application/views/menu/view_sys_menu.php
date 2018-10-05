<!-- Side Navbar -->
<nav class="side-navbar sidebar-menu">
    <!-- Side bar Header-->
    <div class="sidebar-header d-flex align-items-center">
        <div class="avatar"><img src="<?php echo base_url(); ?>assets/img/user.png" alt="..." class="img-fluid rounded-circle "></div> 
        <div class="title">
            <?php
            if (!empty($full_name)) {
                ?>
                <h1 class="h4"><?php echo $full_name; ?></h1>
                <?php
            } else {
                ?>
                <h1 class="h4"><?php echo $ad_name; ?></h1>
                <?php
            }
            ?>

            <span class="badge badge-danger badge-pill"><?php echo $role; ?></span>
        </div>
    </div>

    <!-- Side bar Navigation Menus--><span class="heading">Main</span>
    <ul class="list-unstyled">

        <?php
        if (in_array($page, ['HOME'])) {
            ?>
            <li class="<?php echo ($curr_menu == 'TRIP') ? "active" : "" ?>"><a href="#trip" aria-expanded="<?php echo ($curr_menu == 'TRIP') ? "true" : "false" ?>" data-toggle="collapse"><i class="fa fa-car"></i>Trip Request </a>
                <ul id="trip" class="<?php echo ($curr_sub_menu == 'TRIP') ? "" : "collapse" ?> list-unstyled">
                    <li><a href="<?php echo site_url('trip/requests'); ?>">Trip Requests</a></li>
                    <li><a href="<?php echo site_url('trip/inbox'); ?>">Incoming Request</a></li>
                    <li><a href="<?php echo site_url('trip/requesttrip');  ?>">Request Trip</a></li>
                    <li><a href="<?php echo site_url('trip/myrequests'); ?>">My Trip Requests</a></li>
                </ul>
            </li>
            
            <li class="<?php echo ($curr_menu == 'MANAGEMENT') ? "active" : ""; ?>"><a href="#mgt" aria-expanded="<?php echo ($curr_menu == 'MANAGEMENT') ? "true" : "false" ?>" data-toggle="collapse"><i class="fa fa-cogs"></i>Management </a>
                <ul id="mgt" class="<?php echo ($curr_sub_menu == 'MANAGEMENT') ? "" : "collapse"; ?> list-unstyled">
                    <li><a href="<?php echo site_url('management/departments'); ?>">Departments</a></li>
                    <li><a href="<?php echo site_url('management/sections'); ?>">Sections</a></li>
                    <li><a href="<?php  ?>">Administrators</a></li>
                </ul>
            </li>
            <?php
        }


        if (in_array($page, ['HOME', 'UPDATE_DRIVER_PROFILE'])) {
            ?>
            <li class="<?php echo ($curr_menu == 'DRIVER') ? "active" : "" ?>"><a href="#driver" aria-expanded="<?php echo ($curr_menu == 'DRIVER') ? "true" : "false" ?>" data-toggle="collapse"><i class="fa fa-user-circle"></i>Driver Profile </a>
                <ul id="driver" class="<?php echo ($curr_sub_menu == 'DRIVER') ? "" : "collapse" ?> list-unstyled">
                    <?php
                    if (in_array($page, ['HOME'])) {
                        ?>
                        <li><a href="<?php ?>">Driver Details</a></li>
                        <?php
                    }
                    ?>
                    <li><a href="<?php echo site_url('driver/updateprofile'); ?>">Update Driver Profile</a></li>
                </ul>
            </li>
            <?php
        }
        ?>
    </ul>

</nav>
<div class="content-inner">