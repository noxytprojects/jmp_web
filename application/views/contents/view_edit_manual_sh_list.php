<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>

<?php echo $alert; ?>

<section class="tables no-padding-top">   
    <div class="container-fluid" style="min-height:500px;">
        <br/><br/>
        <div class="row">
            <div class="col-lg-12">

                <?php
                if ($type != 'manual') {
                    ?> 
                    <div class="btn-group pull-left" role="group" aria-label="Basic example">
                        <a href="<?php echo site_url('voting/edit'); ?>"  class="btn btn-info btn-sm" ><i class="fa fa-chevron-circle-left"></i>&nbsp;Manual Attendees Voting List</a>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="btn-group pull-left" role="group" aria-label="Basic example">
                        <a href="<?php echo site_url('user/dashboard'); ?>"  class="btn btn-info btn-sm" ><i class="fa fa-dashboard"></i>&nbsp;Dashboard</a>
                    </div>
                    <?php
                }
                ?>


                <?php
                if ($type == 'manual') {
                    ?> 
<!--                    <div class="btn-group pull-right" role="group" aria-label="Basic example">
                        <a href="<?php echo site_url('voting/editwebsms'); ?>" class="btn btn-danger btn-sm"><i class="fa fa-check-circle-o"></i>&nbsp;Edit Manual Voting For SMS & WEB Attendees</a>
                    </div>-->
                    <?php
                }
                ?>

            </div>
        </div>

        <br/>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <table  class="table table-striped res_table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">No</th>
                                    <th>Fullname</th>
                                    <th>Phone Number</th>
                                    <th>Address</th>
                                    <th>CDS Numbers</th>
                                    <th style="width:10px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($atts as $i => $att) {
                                    ?>
                                    <tr>
                                        <td><?php echo ($i + 1); ?></td>
                                        <td><?php echo $att['att_fullname']; ?></td>
                                        <td><?php echo $att['att_phone_number']; ?></td>
                                        <td><?php echo $att['att_address']; ?></td>
                                        <td><?php echo $att['cds_accounts']; ?></td>
                                        <td><a href="<?php echo site_url('voting/editmanualvoting/' . $att['att_id']); ?>" class="btn btn-sm btn-outline-success"><i class="fa fa-check-circle-o"></i>&nbsp;Edit</a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


</section>

<script type="text/javascript">

    $(document).ready(function () {

        $('.res_table').DataTable({
            aaSorting: [],
            responsive: true,
            fixedHeader: {headerOffset: 70},
            searching: true,
            lengthChange: true,
            paging: true,
            info: true,
            "pageLength": 100,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 1, targets: 1},
                {responsivePriority: 2, targets: -1}
            ]
        });

    });


</script>