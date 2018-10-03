
<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <div class="row">
            <h2 class="no-margin-bottom col-sm-8"><?php echo $module_name; ?></h2>

        </div>

    </div>
</header>
<?php echo $alert; ?>

<section class="dashboard-header">
    <div class="container-fluid">

        <div class="row">
            <!-- Statistics -->
            <div class="statistics col-md-6 col-12">
                <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-red"><i class="fa fa-group"></i></div>
                    <div class="text"><strong id="q_shr"><?php echo $shareholders_registered; ?></strong><br><small>Shareholders Registered</small></div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="statistics col-md-6 col-12">

                <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-orange"><i class="fa fa-money"></i></div>
                    <div class="text"><strong id="q_tc"><?php echo cus_price_form($total_capital); ?></strong><br><small>Total Shares</small></div>
                </div>
            </div>

        </div>

        <div class="row">
            <!-- Statistics -->
            <div class="statistics col-md-6 col-12">

                <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-green"><i class="fa fa-calendar-o"></i></div>
                    <div class="text"><strong id="q_sr"><?php echo cus_price_form($shares_registered); ?></strong><br><small>Shares registered</small></div>
                </div>

            </div>

            <!-- Statistics -->
            <div class="statistics col-md-6 col-12">

                <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-green"><i class="fa fa-percent"></i></div>
                    <div class="text"><strong id="q_p"><?php echo $percent; ?>%</strong><br><small>Percentage of shares registered</small></div>
                </div>

            </div>
        </div>
        
        <!--shareholders_attendance-->
        
        <div class="row">
            <!-- Statistics -->
            <div class="statistics col-md-6 col-12">

                <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-info"><i class="fa fa-group"></i></div>
                    <div class="text"><strong id="q_sa"><?php echo cus_price_form($shareholders_attendance); ?></strong><br><small>Total Shareholders Attended</small></div>
                </div>

            </div>

            <!-- Statistics $proxy_attendance-->
            <div class="statistics col-md-6 col-12">

                <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-warning"><i class="fa fa-group"></i></div>
                    <div class="text"><strong id="q_pa"><?php echo cus_price_form($proxy_attendance); ?></strong><br><small>Total Proxies Attended</small></div>
                </div>

            </div>
        </div>
        
         <div class="row">
            <!-- Statistics -->
            <div class="statistics col-md-6 col-12">

                <div class="statistic d-flex align-items-center bg-white has-shadow">
                    <div class="icon bg-green"><i class="fa fa-group"></i></div>
                    <div class="text"><strong id="q_ta"><?php echo cus_price_form($proxy_attendance + $shareholders_attendance); ?></strong><br><small>Total Attendees</small></div>
                </div>

            </div>

            
        </div>
        
    </div>

</section>

<script type="text/javascript">
    $(document).ready(function () {

        $('#select_year').select2({palceholder: 'Select meeting year'});

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
</script>


