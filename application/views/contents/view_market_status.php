<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo SYSTEM_NAME; ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="all,follow">
        <!-- Bootstrap CSS-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css">
        <!-- Fontastic Custom icon font-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fontastic.css">
        <!-- Font Awesome CSS-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/font-awesome/css/font-awesome.min.css">
        <!-- Google fonts - Poppins -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
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
        <script src="<?php echo base_url(); ?>assets/vendor/datatables/datatables.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo base_url(); ?>assets/vendor/datatables/responsive.1/js/dataTables.responsive.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/datatables/responsive.1/css/responsive.dataTables.css" rel="stylesheet" type="text/css"/>

        <style type="text/css">
            .login-page .container {
                padding:40px 100px;
            }
            @media (min-width: 1200px){
                .container {
                    max-width: 99%;
                }
            }
			
			table.dataTable tbody th, table.dataTable tbody td {
    padding: 4px 10px;
}
			

        </style>

    </head>
    <body>
        <div class="page login-page">
            <div style="width: 100%;z-index: 9999;position: absolute;top:0;left: 0;color: #fff;">
                <h1 class="h4" style="padding-top: 10px;color: #000;text-align: center;">MARKET WATCH</h1>
				
            </div>
			
			
			
            <div class="container align-items-center">
				<p class="text-danger text-center" id="_error" style="display:none;">Error contacting server. Refreshing.....</p>
                <table id="market_table" class="table-sm table-striped" style="width:100%;font-size: 14px;background: #fff;text-align: center;">
                    <thead>
                        <tr style="background: red;color: #fff;">
                            <th>SECURITY</th>
                            <th>QTYB</th>
                            <th>BID</th>
							<th>CHNB</th>
                            <th>OFFER</th>
							
                            <th>QTY O</th>
							<th>CHNO</th>
                            <!--<th>LAST</th>-->
                            <!--<th>CHANGE</th>-->
                            <th>TIME</th>
                            <th>HIGH</th>
                            <th>LOW</th>
                            <th>VOLUME</th>
                            <th>MARKET CAP (Bln)</th>
                        </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>

            </div>
            <div class="copyrights text-center">
                <p style="font-size: 12px;"><a href="<?php echo COPYRIGHT_URL; ?>" class="external text-danger">Powered By Noxyt Software Solution</a></p>
                <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
            </div>

        </div>
        <!-- Javascript files-->
        <script src="<?php echo base_url(); ?>assets/vendor/popper.js/umd/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/vendor/jquery.cookie/jquery.cookie.js"></script>
        <script src="<?php echo base_url(); ?>assets/vendor/jquery-validation/jquery.validate.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/front.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.form-group').click(function () {
                    $(this).children('.rmv_error').remove();
                });

                var table = $('#market_table').DataTable({
                    "aaSorting": [],
                    responsive: true,
                    fixedHeader: {headerOffset: 70},
                    searching: false,
                    lengthChange: false,
                    "info": false,
                    "paging": false,
                    "pageLength": 100,
                    "processing": false, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": "<?php echo site_url('market/ajaxmarketstatus'); ?>",
                        
                        "type": "POST",
						"dataSrc": function ( json ) {
							//Make your callback here.
							$('#_error').hide();
							return json.data;
						},
                        error: function (xhr, error, thrown) {
							$('#_error').show();
                            // alert('Something went wrong!');
                            // location.reload(false);
                        }
                    },

                    //Set column definition initialisation properties.
                    columnDefs: [
                        {responsivePriority: 1, targets: 1},
                        {responsivePriority: 2, targets: -1},
                        {
                            "targets": [0,1,2, 3,4,5,6,7,8,9,10,11], //first column / numbering column
                            "orderable": false, //set not orderable
                        },
                    ]
                });

				
                setInterval(function () {
                    table.ajax.reload();
                }, 3000);

            });
        </script>
    </body>
</html>