<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo SYSTEM_NAME; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="HandheldFriendly" content="true" />
        <meta name="robots" content="all,follow">
        <!-- Bootstrap CSS-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css">
        <!-- Fontastic Custom icon font-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fontastic.css">
        <!-- Font Awesome CSS-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/font-awesome/css/font-awesome.min.css">
        <!-- Google fonts - Poppins -->
        <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">-->
        <!-- theme stylesheet-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.sea.css" id="theme-stylesheet">
        <!-- Custom stylesheet - for your changes-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
        <!-- Favicon-->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/favicon.png">
        <!-- Tweaks for older IEs--><!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->



        <!-- Javascript files-->
        <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js" type="text/javascript"></script>


        <script src="<?php echo base_url(); ?>assets/vendor/popper.js/umd/popper.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/vendor/jquery.cookie/jquery.cookie.js"></script>
        <script src="<?php echo base_url(); ?>assets/vendor/jquery-validation/jquery.validate.min.js"></script>
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>-->

        <!--Chart Js-->
        <script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.bundle.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/front.js"></script>


        <!-- Datatables -->
        <!--    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
                <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
        -->

        <script src="<?php echo base_url(); ?>assets/vendor/datatables/datatables.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo base_url(); ?>assets/vendor/datatables/responsive.1/js/dataTables.responsive.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/datatables/responsive.1/css/responsive.dataTables.css" rel="stylesheet" type="text/css"/>

        <!-- Viewer -->
        <script src="<?php echo base_url(); ?>assets/vendor/viewer-master/dist/viewer.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/viewer-master/dist/viewer.css" rel="stylesheet" type="text/css"/>


        <!-- Confirm -->
        <script src="<?php echo base_url(); ?>assets/vendor/jquery-confirm-master/dist/jquery-confirm.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/jquery-confirm-master/dist/jquery-confirm.min.css" rel="stylesheet" type="text/css"/>


        <!-- Date Range Picker -->
        <!--<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>-->
        <script src="<?php echo base_url(); ?>assets/js/moment.js" type="text/javascript"></script>

        <script src="<?php echo base_url(); ?>assets/vendor/daterange/daterangepicker.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/daterange/daterangepicker.css" rel="stylesheet" type="text/css"/>

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/dropzone/dropzone.css">
        <script src="<?php echo base_url(); ?>assets/vendor/dropzone/dropzone.js" type="text/javascript"></script>


        <!-- Location picker -->

        <!--<script type="text/javascript" src='https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyAUVnVdhs1B7jKC2FqtRi8iqLhPd9s4-uQ'></script>-->

        <!--<script src="<?php echo base_url(); ?>assets/vendor/map/dist/locationpicker.jquery.js" type="text/javascript"></script>-->

        <link href="<?php echo base_url(); ?>assets/vendor/select2/css/select2.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo base_url(); ?>assets/vendor/select2/js/select2.full.js" type="text/javascript"></script>


        <!--- Select 2 -->


        <!-- Numeric JS -->
        <script src="<?php echo base_url(); ?>assets/js/jquery.numeric.js" type="text/javascript"></script>

        <!-- Ratings -->
        <script src="<?php echo base_url(); ?>assets/vendor/rate/jquery.rateyo.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/rate/jquery.rateyo.css" rel="stylesheet" type="text/css"/>


        <!-- Tooltipstar -->
        <script src="<?php echo base_url(); ?>assets/vendor/tooltipster-master/dist/js/tooltipster.bundle.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/tooltipster-master/dist/css/tooltipster.bundle.min.css" rel="stylesheet" type="text/css"/>



        <!-- Block UI -->
        <script src="<?php echo base_url(); ?>assets/js/jquery.blockUI.js" type="text/javascript"></script>

        <!-- Simple Calendar -->
        <link href="<?php echo base_url(); ?>assets/vendor/simplecal/css/dncalendar-skin.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo base_url(); ?>assets/vendor/simplecal/js/dncalendar.js" type="text/javascript"></script>


        <!-- Text Editor -->
        <script src="<?php echo base_url(); ?>assets/vendor/jte/jquery-te-1.4.0.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/jte/jquery-te-1.4.0.css" rel="stylesheet" type="text/css"/>


        <!-- Jquery Knobs -->
        <script src="<?php echo base_url(); ?>assets/js/jquery.knob.min.js" type="text/javascript"></script>

        <!--Side bar-->
        <link href="<?php echo base_url(); ?>assets/vendor/sidebar/sidebar-menu.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo base_url(); ?>assets/vendor/sidebar/sidebar-menu.js" type="text/javascript"></script>


        <!--Scroll bar-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/scrollbar/jquery.mCustomScrollbar.min.css" />
        <script src="<?php echo base_url(); ?>assets/vendor/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>


        <!--Marque-->
        <link href="<?php echo base_url(); ?>assets/vendor/marque/css/marquee.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo base_url(); ?>assets/vendor/marque/js/marquee.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/marque/css/marquee.css" rel="stylesheet" type="text/css"/>


        <script type="text/javascript">

            $(document).ready(function () {

                $.sidebarMenu($('.sidebar-menu'));
                $(".sidebar-menu").mCustomScrollbar({autoHideScrollbar: true, theme: "dark"});

                $('#attachment').viewer();

                $('#daterange').daterangepicker();

                $(document).on('click', '.confirm', function (e) {
                    e.preventDefault();
                    var content = $(this).attr('title');
                    var url = $(this).attr('href');
                    $.confirm({
                        title: 'Confirm!',
                        content: 'Are you sure you want to ' + content,
                        buttons: {
                            cancel: function () {
                                console.log('Confirmation cancelled');
                            }, somethingElse: {
                                text: 'Confirm',
                                btnClass: 'btn-success',
                                keys: ['enter', 'shift'],
                                action: function () {
                                    window.location.href = url;
                                }
                            }
                        }
                    });

                });


                $('.input-field').click(function () {

                    $(this).children('.form-control').removeClass('is-invalid');
                    $(this).children('.rmv_error').remove();

                });


                $('.rate').tooltipster({side: 'right'});


                //Remove Field Errors
                $(document).on("click", ".remove_error", function () {
                    $(this).children(".field_error").remove();
                    $(this).children('.form-control').removeClass("is-invalid");
                });

                setHeight();

                // when resizing windows

                $(window).resize(function () {
                    setHeight();
                });

                // sidebar height
                function setHeight() {

                    winHeight = $(window).innerHeight() - 70;
                    containerMinHeight = $(window).innerHeight() - 70;
                    $('nav.side-navbar').css('height', winHeight)
                    $('.content-inner').css('min-height', containerMinHeight)
                    //s$('.overlay').css('min-height',winHeight)
                }

                $('.amount').numeric({decimalPlaces: 2, negative: false});
                $('.distance').numeric({decimalPlaces: 2, negative: false});
                $('.volume').numeric({decimalPlaces: 3, negative: false});
                $('.just_number').numeric({decimal: false, negative: false});

                $(".max_date").daterangepicker({
                    "format": 'YYYY-MM-DD',
                    "autoUpdateInput": true,
                    "singleDatePicker": true,
                    "autoApply": false,
                    "linkedCalendars": false,
                    "startDate": "<?php echo date('m/d/Y'); ?>",
                    "maxDate": "<?php echo date('m/d/Y'); ?>"

                }, function (start, end, label) {
                    //$('.max_date').val(start.format('YYYY-MM-DD'));
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });

                $(".min_date").daterangepicker({
                    "format": 'YYYY-MM-DD',
                    "autoUpdateInput": true,
                    "singleDatePicker": true,
                    "autoApply": false,
                    "linkedCalendars": false,
                    "startDate": "<?php echo date('m/d/Y'); ?>",
                    "minDate": "<?php echo date('m/d/Y'); ?>"

                }, function (start, end, label) {
                    //$('.max_date').val(start.format('YYYY-MM-DD'));
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });

                $(".min_time").daterangepicker({
                    locale: {
                        format: 'DD/MM/YY hh:mm A'
                    },
                    "autoUpdateInput": true,
                    "singleDatePicker": true,
                    "autoApply": false,
                    timePicker: true,
                    "linkedCalendars": false,
                    "startDate": "<?php echo date('d/m/Y hh:ii'); ?>",
                    "minDate": "<?php echo date('d/m/Y hh:ii'); ?>"

                }, function (start, end, label) {
                    //$('.max_date').val(start.format('YYYY-MM-DD'));
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });



                // When ajax stsrts block UI
                /*
                 $(document).ajaxStart(function () {
                 $.blockUI({message: '<h1><img src="busy.gif" /> Just a moment...</h1>'});
                 });
                 
                 //When ajax stops, ublock UI
                 $(document).ajaxStop($.unblockUI); 
                 
                 */

            });
        </script>

        <style type="text/css">

            .hide{ display: none;}
            .mCS-my-theme.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ background-color: red; }
            .mCS-my-theme.mCSB_scrollTools .mCSB_draggerRail{ background-color: white; } 

            img{
                width:100%;
            }
            table.dataTable thead th, table.dataTable thead td{
                padding: 10px 20px 10px 10px;
            }
            .fill{
                min-height: 100%;
                height: 100%;
            }

            td.danger{
                background: #ffefef;
            }

            td.info{
                background: #effbff;;
            }
            .module-date{
                font-size:12px;font-weight:normal;
            }
            td{
                vertical-align: middle;
            }

            table.dataTable{
                font-size: 0.8em;
            }
            #header_logo{
                width:150px;
            }

            @media screen and (max-width: 640px){
                .dataTables_wrapper .dataTables_length{
                    display: none;
                }
                #header_logo{
                    width:110px;
                }

                .cus-hide-sm{
                    display: none;
                }
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

            .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {
                color: #333;
                padding: 15px 0px 20px;
            }

        </style>


    </head>
    <body>
        <div class=" <?php echo isset($page_class) ? $page_class : ""; ?>">