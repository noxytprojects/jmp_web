<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Vodacom | Youth Campus Campaign</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="<?php echo base_url(); ?>students/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>students/assets/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>students/assets/css/form-elements.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>students/assets/css/style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>students/assets/dropzone/dropzone.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>students/assets/ico/favicon.png">
        <!--        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
                <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
                <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
                <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">-->


        <style type="text/css">

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

        </style>

    </head>

    <body>

        <!-- Top menu -->
        <nav class="navbar navbar-inverse" role="navigation" style="margin-bottom:0px;">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-navbar-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo site_url('user/dashboard'); ?>">
                        <img src="<?php echo base_url(); ?>students/assets/img/logo2.png">
                    </a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="top-navbar-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <span class="li-social">
                                <a href="#" class="icon-fb"><i class="fa fa-facebook"></i></a> 
                                <a href="#" class="icon-tw"><i class="fa fa-twitter"></i></a>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="custom_jumbo">

        </div>

        <!-- Top content -->
        <div class="top-content" style="margin-top:-350px;">

            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1>Youth Campus Campaign</h1>
                            <div class="description">
                                <p>
                                    Register For Universit Offer Online
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">

                            <form role="form" action="" method="post" class="registration-form">

                                <fieldset>
                                    <div class="form-top">
                                        <div class="form-top-left">
                                            <h3>Step 1 / 2</h3>
                                            <p>Tell us your subscription information:</p>
                                        </div>
                                        <div class="form-top-right">
                                            <i class="fa fa-user"></i>
                                        </div>
                                    </div>
                                    <div class="form-bottom">
                                        <div class="form-group">
                                            <label class="" for="form-first-name">Full Name</label>
                                            <input type="text" name="form-first-name" placeholder="Full Name..." class="form-first-name form-control" id="form-first-name">
                                        </div>

                                        <div class="form-group">
                                            <label class="" for="form-first-name">Phone Number</label>
                                            <input type="text" name="form-first-name" placeholder="Phone Number..." class="form-phone-number form-control" id="form-phone-number">
                                        </div>

                                        <div class="form-group">
                                            <label class="" for="form-last-name">ID Number</label>
                                            <input type="text" name="form-last-name" placeholder="ID Number..." class="form-last-name form-control" id="form-last-name">
                                        </div>

                                        <div class="form-group">
                                            <label class="" for="form-first-name">College</label>
                                            <select  name="form-first-name" class="">

                                                <option value="">St Joseph University College Of Engeneering</option>
                                                <option value="">Dar Es Salaam College</option>

                                            </select>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-6">
                                                <div class="form-group">
                                                    <label class="" for="form-last-name">Year Of Joining</label>
                                                    <input type="text" name="form-last-name" placeholder="Joining Year..." class="form-last-name form-control" id="form-last-name">
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-group">
                                                    <label class="" for="form-last-name">Year Of Ending</label>
                                                    <input type="text" name="form-last-name" placeholder="Ending Year..." class="form-last-name form-control" id="form-last-name">
                                                </div>
                                            </div>
                                        </div>

                                        <!--
                <div class="form-group">
                        <label class="sr-only" for="form-about-yourself">About yourself</label>
                        <textarea name="form-about-yourself" placeholder="About yourself..." 
                                                class="form-about-yourself form-control" id="form-about-yourself"></textarea>
                </div>
                                        -->
                                        <button type="button" class="btn btn-next">Next</button>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <div class="form-top">
                                        <div class="form-top-left">
                                            <h3>Step 2 / 2</h3>
                                            <p>Attach The Scanned Copy Of Your Student ID:</p>
                                        </div>
                                        <div class="form-top-right">
                                            <i class="fa fa-id-card"></i>
                                        </div>
                                    </div>
                                    <div class="form-bottom">
                                        <div style="padding-bottom:20px;">
                                            <div id="filing" class=""></div>
                                        </div>
                                        <button type="button" class="btn btn-previous">Previous</button>
                                        <button type="button" class="btn btn-next">Join</button>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <div class="form-top">
                                        <div class="form-top-left">
                                            <h3>Thank You</h3>
                                            <p>You are done!</p>
                                        </div>
                                        <div class="form-top-right">
                                            <i class="fa fa-check-circle-o"></i>
                                        </div>
                                    </div>
                                    <div class="form-bottom">
                                        <h1 class="h1 text-center">Congratulations!</h1><br/>
                                        <p class="text-center" style="padding-bottom:85px;">
                                            Your request has been sent successfully. 
                                            We will notify you when its processed.Thank you for choosing Vodacom. 
                                        </p>
                                    </div>
                                </fieldset>

                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <p style="color:#fff;text-align:center;">Vodacom &copy; <?php echo date('Y'); ?> | Powered By <a href="http://www.noxyt.com"><strong>Noxyt</strong></a></p>
        </div>
        
        


        <!-- Javascript -->
        <script src="<?php echo base_url(); ?>students/assets/js/jquery-1.11.1.min.js"></script>
        <script src="<?php echo base_url(); ?>students/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>students/assets/js/jquery.backstretch.min.js"></script>
        <script src="<?php echo base_url(); ?>students/assets/js/retina-1.1.0.min.js"></script>
        <script src="<?php echo base_url(); ?>students/assets/js/scripts.js"></script>
        <script src="<?php echo base_url(); ?>students/assets/dropzone/dropzone.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("div#filing").dropzone({ url: "<?php echo site_url('user/upload');?>" });
            });
        </script>
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>