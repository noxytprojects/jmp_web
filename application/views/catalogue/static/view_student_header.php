<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Vodacom | Youth Campus Campaign</title>

        <!-- CSS -->
        <!--<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">-->
        <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>students/assets/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>students/assets/css/form-elements.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>students/assets/css/style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>students/assets/dropzone/dropzone.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>students/assets/ico/favicon.png">
        
        <!--        
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
        -->

        <!--Responsive top bar-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/catalog/css/styles.css">
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
          <link rel="stylesheet" href="css/ie.css">
        <![endif]-->

        <!-- Javascript -->
        <script src="<?php echo base_url(); ?>students/assets/js/jquery-1.11.1.min.js"></script>
        <script src="<?php echo base_url(); ?>students/assets/js/jquery.backstretch.min.js"></script>
        <script src="<?php echo base_url(); ?>students/assets/js/retina-1.1.0.min.js"></script>
        <script src="<?php echo base_url(); ?>students/assets/js/scripts.js"></script>
        <script src="<?php echo base_url(); ?>students/assets/dropzone/dropzone.js" type="text/javascript"></script>

        <!--Select 2-->
        <link href="<?php echo base_url(); ?>students/select2/css/select2.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo base_url(); ?>students/select2/js/select2.full.min.js" type="text/javascript"></script>
        <!--End of select 2-->

        <!-- Confirm -->
        <script src="<?php echo base_url(); ?>assets/vendor/jquery-confirm-master/dist/jquery-confirm.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/jquery-confirm-master/dist/jquery-confirm.min.css" rel="stylesheet" type="text/css"/>

        <!--Jquery block UI-->
        <script src="<?php echo base_url(); ?>assets/js/jquery.blockUI.js"></script>


        <!-- Viewer -->
        <script src="<?php echo base_url(); ?>assets/vendor/viewerjs-master/dist/viewer.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/viewerjs-master/dist/viewer.css" rel="stylesheet" type="text/css"/>

        <script src="<?php echo base_url(); ?>assets/vendor/popper.js/umd/popper.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
        
        <!-- Jquery DataTable Plugin Js -->
        <script src="<?php echo base_url(); ?>assets/vendor/datatables/datatables.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo base_url(); ?>assets/vendor/datatables/responsive.1/js/dataTables.responsive.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/datatables/responsive.1/css/responsive.dataTables.css" rel="stylesheet" type="text/css"/>


        <style type="text/css">
            
            *{
                font-family: 'Nanum Gothic', sans-serif;
            }
            
            
            #attachments{
                list-style: none;
                padding:15px 0;
            }
            .dt{
                margin-bottom:30px;
            }

            .custom_jumbo{
                height:440px;
                background: url('<?php echo base_url(); ?>students/assets/img/backgrounds/bg.jpg') no-repeat center center;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }

            .fa-facebook{
                color: #ea4146;
            }

            .fa-twitter{
                color: #ea4146;
            }

            .navbar-inverse .navbar-toggle {
                border-color: #333;
                background: #e95260;
            }

            img{
                width:100%;
            }
            /*Please wait loading*/

            #loader-wrapper {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 1000;
            }
            #loader {
                display: block;
                position: relative;
                left: 50%;
                top: 50%;
                width: 150px;
                height: 150px;
                margin: -75px 0 0 -75px;
                border-radius: 50%;
                border: 3px solid transparent;
                border-top-color: #3498db;
                -webkit-animation: spin 2s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
                animation: spin 2s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
            }

            #loader:before {
                content: "";
                position: absolute;
                top: 5px;
                left: 5px;
                right: 5px;
                bottom: 5px;
                border-radius: 50%;
                border: 3px solid transparent;
                border-top-color: #e74c3c;
                -webkit-animation: spin 3s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
                animation: spin 3s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
            }

            #loader:after {
                content: "";
                position: absolute;
                top: 15px;
                left: 15px;
                right: 15px;
                bottom: 15px;
                border-radius: 50%;
                border: 3px solid transparent;
                border-top-color: #f9c922;
                -webkit-animation: spin 1.5s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
                animation: spin 1.5s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
            }

            @-webkit-keyframes spin {
                0%   {
                    -webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
                    -ms-transform: rotate(0deg);  /* IE 9 */
                    transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
                }
                100% {
                    -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
                    -ms-transform: rotate(360deg);  /* IE 9 */
                    transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
                }
            }
            @keyframes spin {
                0%   {
                    -webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
                    -ms-transform: rotate(0deg);  /* IE 9 */
                    transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
                }
                100% {
                    -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
                    -ms-transform: rotate(360deg);  /* IE 9 */
                    transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
                }
            }

        </style>

    </head>

    <body>

        <!-- Top menu -->
        <header>
            <a href="#" class="logo text-danger" data-scroll>
                <img src="<?php echo base_url() ?>assets/img/vodal.png" style="width:230px;"/>
            </a>
            <nav class="nav-collapse">
                <ul>
                    <li class="menu-item <?php echo $menu == 'register' ? 'active' : ''; ?>"><a href="<?php echo site_url('catalogue') ?>" data-scroll>Register Now</a></li>
                    <li class="menu-item <?php echo $menu == 'status' ? 'active' : ''; ?>"><a href="<?php echo site_url('status') ?>" data-scroll>Registration Status</a></li>
                </ul>
            </nav>
        </header>

        <div class="custom_jumbo" style="margin-top: 58px; ">

        </div>

        <!-- Top content -->
        <div class="top-content" style="margin-top:-350px;">