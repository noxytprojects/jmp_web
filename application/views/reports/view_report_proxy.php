<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>
<section class="tables no-padding-top">   
    <div class="container-fluid" style="min-height:500px;">
        <br/><br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="btn-group pull-left" role="group" aria-label="Basic example">
                    <a href="<?php echo site_url('user/dashboard'); ?>"  class="btn btn-info btn-sm" ><i class="fa fa-dashboard"></i>&nbsp;Dashboard</a>
                </div>
                <div class="btn-group pull-right" role="group" aria-label="Basic example">

                    <?php
                    if ($year['year_status'] == 'CLOSED') {
                        ?>

                        <?php
                    }
                    ?>

                    <!--<a href="<?php //echo site_url('reports/excelproxy'); ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Export To Excel</a>-->
                    <a href="<?php echo site_url('reports/pdfproxiesreport'); ?>" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Export To PDF</a>

                </div>
            </div>
        </div>
        <br/>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <table id="proxies_table" class="table table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Attendee Name</th>
                                    <th>Phone Number</th>
                                    <th>Address</th>
                                    <th>Type</th>
                                    <th>CDS Number(s)</th>
                                    <th>Total<br/>Shares</th>
                                    <th>Shares<br/>Parcentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($proxies as $i => $proxy) {
                                    ?>
                                    <tr>

                                        <td><?php echo ucwords($proxy['att_fullname']); ?></td>
                                        <td><?php echo $proxy['att_phone_number']; ?></td>
                                        <td><?php echo ucwords($proxy['att_address']); ?></td>
                                        <td><?php echo $proxy['att_attends_as']; ?></td>
                                        <td><?php echo ucwords($proxy['cds_accounts']); ?></td>
                                        <td><?php echo $proxy['total_shares']; ?></td>
                                        <td><?php 
                                                echo $year['year_total_share'] >  0? round((($proxy['total_shares']/ (int)$year['year_total_share']) * 100),2) . "%" : 0 .'%';
                                        ?></td>
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

        $('#proxies_table').DataTable({
            aaSorting: [],
            responsive: true,
            fixedHeader: {headerOffset: 70},
            searching: true,
            lengthChange: true,
            "pageLength": 25,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 1, targets: 1},
                {responsivePriority: 2, targets: -1}
            ]
        });

    });

</script>