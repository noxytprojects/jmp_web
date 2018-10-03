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


        <!--Chart Js-->
        <script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.bundle.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/front.js"></script>


        <!--Marque-->
        <link href="<?php echo base_url(); ?>assets/vendor/marque/css/marquee.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo base_url(); ?>assets/vendor/marque/js/marquee.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/vendor/marque/css/marquee.css" rel="stylesheet" type="text/css"/>



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

            .page {
                background: #fff;
            }

        </style>

    </head>
    <body>
        <div class="">
            <div class="simple-marquee-container">
                <!--    <div class="marquee-sibling">
                        Market Ticker
                    </div>-->
                <div class="marquee">
                    <ul class="marquee-content-items">
                        <li><b>VODA</b> 850.00 <span class="fa fa-chevron-down text-danger"></span> <span class="badge badge-danger">- 120</span>&nbsp;<span class="badge badge-danger">- 80</span></li>
                        <li><b>SWALA</b> 1,500.00 <span class="fa fa-chevron-up text-success"></span> <span class="badge badge-success">+ 180</span>&nbsp;<span class="badge badge-success">+ 72</span></li>
                        <li><b>NMB</b> 910.00 <span class="fa fa-chevron-down text-danger"></span> <span class="badge badge-danger">- 320</span>&nbsp;<span class="badge badge-danger">- 160</span></li>
                        <li><b>TBL</b> 1,200.00 <span class="fa fa-chevron-down text-danger"></span> <span class="badge badge-danger">- 120</span>&nbsp;<span class="badge badge-danger">- 80</span></li>
                        <li><b>NMB</b> 550.00 <span class="fa fa-chevron-up text-success"></span> <span class="badge badge-success">+ 120</span>&nbsp;<span class="badge badge-success">+ 80</span></li>
                        <li><b>DSE</b> 615.00 <span class="fa fa-chevron-down text-danger"></span> <span class="badge badge-danger">- 100</span>&nbsp;<span class="badge badge-danger">- 40</span></li>
                        <li><b>MUCO</b> 812.00 <span class="fa fa-chevron-up text-success"></span> <span class="badge badge-success">+ 120</span>&nbsp;<span class="badge badge-success">+ 80</span></li>
                        <li><b>MBP</b> 400.00 <span class="fa fa-chevron-down text-danger"></span> <span class="badge badge-danger">- 125</span>&nbsp;<span class="badge badge-danger">- 76</span></li>
                        <li><b>MCB</b> 13,200.00 <span class="fa fa-chevron-down text-danger"></span> <span class="badge badge-danger">- 180</span>&nbsp;<span class="badge badge-danger">- 340</span></li>
                    </ul>
                </div>
            </div>
            <br/>

            <section class="dashboard-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5>MAIN MARKET SEGMENT</h5>
                                    <div class="card">
                                        <div class="card-body no-padding">
                                            <table id="market_table" class="table table-sm table-bordered table-success" style="font-size: 10px;width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2">SN</th>
                                                        <th rowspan="2">ISSUER</th>
                                                        <th colspan="4">PRICE (TZS)</th>
                                                        <th rowspan="2">TURNOVER (TZS)</th>
                                                        <th rowspan="2">VOLUME (TZS)</th>
                                                        <th rowspan="2">Market Cap (TZS) in Biln</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Previous Price</th>
                                                        <th>High Price</th>
                                                        <th>Low Price</th>
                                                        <th>Closing Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>VODA</td>
                                                        <td>780</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>780</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>1,792.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>TBL</td>
                                                        <td>16,600</td>
                                                        <td>15,900</td>
                                                        <td>16,600</td>
                                                        <td>16,600</td>
                                                        <td>35,790,000.00</td>
                                                        <td>2,240</td>
                                                        <td>4,897.93</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>TPP</td>
                                                        <td>120</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>120</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>2.24</td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>TCCL</td>
                                                        <td>1,000</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>1,000</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>63.67</td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>SWISS</td>
                                                        <td>3,500</td>
                                                        <td>3,400</td>
                                                        <td>3,400</td>
                                                        <td>3,500</td>
                                                        <td>68,000.00</td>
                                                        <td>20</td>
                                                        <td>126.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>6</td>
                                                        <td>NMB</td>
                                                        <td>2,750</td>
                                                        <td>2,340</td>
                                                        <td>2,340</td>
                                                        <td>2,750</td>
                                                        <td>42,120.00</td>
                                                        <td>18</td>
                                                        <td>1,375.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>7</td>
                                                        <td>CRDB</td>
                                                        <td>160</td>
                                                        <td>160</td>
                                                        <td>160</td>
                                                        <td>160</td>
                                                        <td>52,150,080.00</td>
                                                        <td>325,938</td>
                                                        <td>417.89</td>
                                                    </tr>
                                                </tbody>

                                                <tfoot>
                                                    <tr>
                                                        <th colspan="6" >TOTAL</th>
                                                        <th>95,125,000.00</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <h5>ENTERPRISES GROWTH MARKET (EGM)</h5>
                                    <div class="card">
                                        <div class="card-body no-padding">
                                            <table id="enterprice_table" class="table table-sm table-bordered table-info" style="font-size: 10px;width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2">SN</th>
                                                        <th rowspan="2">ISSUER</th>
                                                        <th colspan="4">PRICE (TZS)</th>
                                                        <th rowspan="2">TURNOVER (TZS)</th>
                                                        <th rowspan="2">VOLUME (TZS)</th>
                                                        <th rowspan="2">Market Cap (TZS) in Biln</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Previous Price</th>
                                                        <th>High Price</th>
                                                        <th>Low Price</th>
                                                        <th>Closing Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>MBP</td>
                                                        <td>590</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>590</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>8.63</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>SWALA</td>
                                                        <td>490</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>490</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>52.04</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>MKCB</td>
                                                        <td>800</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>800</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>16.49</td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>MCB</td>
                                                        <td>500</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>500</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>30.91</td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>YETU</td>
                                                        <td>600</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>600</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>7.27</td>
                                                    </tr>
                                                </tbody>

                                                <tfoot>
                                                    <tr>
                                                        <th colspan="6" >GRAND TOTAL</th>
                                                        <th>95,125,000.00</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <h5>CROSS LISTED COMPANIES MARKET</h5>
                                    <div class="card">
                                        <div class="card-body no-padding">
                                            <table id="crosslisted_table" class="table table-sm table-bordered table-warning" style="font-size: 10px;width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2">SN</th>
                                                        <th rowspan="2">ISSUER</th>
                                                        <th colspan="4">PRICE (TZS)</th>
                                                        <th rowspan="2">TURNOVER (TZS)</th>
                                                        <th rowspan="2">VOLUME (TZS)</th>
                                                        <th rowspan="2">Market Cap (TZS) in Biln</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Previous Price</th>
                                                        <th>High Price</th>
                                                        <th>Low Price</th>
                                                        <th>Closing Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>ACA</td>
                                                        <td>3,640</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>3,580</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>1,468.11</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>EABL</td>
                                                        <td>4,980</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>4,860</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>3,843.16</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>JHL</td>
                                                        <td>11,390</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>11,400</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>826.19</td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>KA</td>
                                                        <td>225</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>225</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>1,278.32</td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>KCB</td>
                                                        <td>1,170</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>1,160</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>3,445.59</td>
                                                    </tr>
                                                    <tr>
                                                        <td>6</td>
                                                        <td>NMG</td>
                                                        <td>2040</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td></td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>3,445.59</td>
                                                    </tr>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <h5>VOLUME</h5>
                                    <div class="card">
                                        <div class="card-body no-padding">
                                            <canvas id="salesGraph" width="400" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <h5>MARKET CAP</h5>
                                    <div class="card">
                                        <div class="card-body no-padding">
                                            <canvas id="marketCapGraph" width="400" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <h5>TURNOVER</h5>
                                    <div class="card">
                                        <div class="card-body no-padding">
                                            <canvas id="turnoverGraph" width="400" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <h5>PRICE VS TIME</h5>
                                    <div class="card">
                                        <div class="card-body no-padding">
                                            <canvas id="pricetimeGraph" width="400" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="work-amount card bg-success">

                                        <div class="card-body">
                                            <h3 class="text-center text-light">Vodacom PLC Summary</h3>
                                            <div class="text-center"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                                                <div>
                                                    <p class="text-light text-small">VOLUME = 100% of Total</p>
                                                    <p class="text-light text-small" >TURNOVER = 21222200 of Total</p>
                                                    <p class="text-light text-small" >MARKET CAP = 1212123411080</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="work-amount card bg-info">

                                        <div class="card-body">
                                            <h3 class="text-center text-light">Total Market Summary</h3>
                                            <div class="text-center"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                                                <div>
                                                    <p class="text-light text-small">VOLUME = 10000</p>
                                                    <p class="text-light text-small" >TURNOVER = 21222200</p>
                                                    <p class="text-light text-small" >MARKET CAP = 1212123411080</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
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

                $('.simple-marquee-container').SimpleMarquee({duration: 60000, documentHasFocus:true});
                $('#market_table').DataTable({
                    lengthChange: false,
                    "info": false,
                    "paging": false,
                    "pageLength": 100,
                    "processing": false,
                    searching: false,
                    responsive: true
                });

                $('#enterprice_table').DataTable({
                    lengthChange: false,
                    "info": false,
                    "paging": false,
                    "pageLength": 100,
                    "processing": false,
                    searching: false,
                    responsive: true
                });

                $('#crosslisted_table').DataTable({
                    lengthChange: false,
                    "info": false,
                    "paging": false,
                    "pageLength": 100,
                    "processing": false,
                    searching: false,
                    responsive: true
                });

                window.setInterval(refreshQurum, 3500);

                function refreshQurum() {

                    $.ajax({
                        url: '<?php echo site_url('user/refreshquorum'); ?>',
                        type: 'post',
                        success: function (data, status) {
                            $('#q_shr').html(data.quorum.shareholders_registered);
                            $('#q_sr').html(data.quorum.shares_registered);
                            $('#q_tc').html(data.quorum.total_capital);
                            $('#q_p').html(data.quorum.percent + '%');
                            $('#q_sa').html(data.quorum.shareholders_attendance);
                            $('#q_pa').html(data.quorum.proxy_attendance);
                            $('#q_ta').html(data.quorum.total_attendees);
                        },

                        // Holly molly, we may have some errors
                        error: function (xhr, desc, err) {
                            console.log(xhr);
                            console.log("Details: " + desc + "\nError:" + err);// just log to see whats going on
                        },
                        complete: function () {
                            //$('.disabled_field').attr('disabled', 'disabled');
                        },
                        timeout: 3000
                    });
                }


            });


            var sales = document.getElementById("salesGraph").getContext('2d');
            var marketCap = document.getElementById("marketCapGraph").getContext('2d');
            var turnover = document.getElementById("turnoverGraph").getContext('2d');
            var pricetime = document.getElementById("pricetimeGraph").getContext('2d');

            var salesGraph = new Chart(sales, {
                type: 'bar',
                //type: 'horizontalBar',
                data: {

                    labels: ["VODA", "SWALA", "CRDB", "TBL", "TICL", "NICOL"],
                    datasets: [{
                            label: 'Volume',
                            data: [0, 0, 325938, 2240, 0, 13200],
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255,99,132,1)',
                            borderWidth: 1
                        }]
                },
                options: {
                    scales: {
                        yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                    }
                }
            });

            var marketCapGraph = new Chart(marketCap, {
                //type: 'bar',
                type: 'horizontalBar',
                data: {

                    labels: ["VODA", "SWALA", "CRDB", "TBL", "TICL", "NICOL"],
                    datasets: [{
                            label: 'Market Cap Perfomance (Bln)',
                            data: [1792, 52.04, 417.89, 4897.93, 32.88, 20.06],
                            backgroundColor: 'rgba( 99,255, 132, 0.2)',
                            borderColor: 'rgba(99,255,132,1)',
                            borderWidth: 1
                        }]
                },
                options: {
                    scales: {
                        yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                    }
                }
            });

            var turnoverGraph = new Chart(turnover, {
                type: 'bar',
                //type: 'horizontalBar',
                data: {

                    labels: ["VODA", "SWALA", "CRDB", "TBL", "TICL", "NICOL"],
                    datasets: [{
                            label: 'Turnover',
                            data: [0, 0, 52150080, 35790000, 0, 3828000],
                            backgroundColor: 'rgba( 99, 132,255, 0.2)',
                            borderColor: 'rgba(99,132,255,1)',
                            borderWidth: 1
                        }]
                },
                options: {
                    scales: {
                        yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                    }
                }
            });

            var pricetimeGraph = new Chart(pricetime, {
                type: 'line',
                //type: 'horizontalBar',
                data: {

                    labels: ["1 Aug", "2 Aug", "3 Aug", "4 Aug", "5 Aug", "6 Aug", "7 Aug", "8 Aug"],
                    datasets: [{
                            label: 'Price',
                            data: [800, 850, 720, 790, 810, 830, 800, 820],
                            backgroundColor: 'rgba( 99, 132,255, 0)',
                            borderColor: 'rgba(243,112,0,1)',
                            borderWidth: 1
                        }]
                },
                options: {
                    scales: {
                        yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                    }
                }
            });
        </script>
    </body>
</html>