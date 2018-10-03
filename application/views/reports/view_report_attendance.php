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
                <div class="btn-group pull-left" role="group" aria-label="Basic example">
                    <a href="<?php echo site_url('user/dashboard'); ?>"  class="btn btn-info btn-sm" ><i class="fa fa-dashboard"></i>&nbsp;Dashboard</a>
                </div>
                <div class="btn-group pull-right" role="group" aria-label="Basic example">
                    <!--<a href="<?php // echo site_url('reports/excelattendance'); ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Export To Excel</a>-->
                    <a href="<?php echo site_url('reports/pdfattendancereport'); ?>" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Export To PDF</a>
                </div>
            </div>
        </div>
        <br/>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <table id="cds_acc_table" class="table table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">No.</th>
                                    <th>CDS Acc No</th>
                                    <th>Shareholder Name</th>
                                    <th>Type</th>
                                    <th>Represented By</th>
                                    <th>Phone Number</th>
                                    <th>Total Shares</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($attendance as $i => $att) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i + 1; ?></td>
                                        <td><?php echo $att['cds_acc_number']; ?></td>
                                        <td><?php echo $att['cds_acc_fullname']; ?></td>
                                        <td>
                                            <?php
                                            if ($att['cds_att_type'] == 'SELF') {
                                                ?>
                                                <h4><span class="badge badge-success">SELF</span></h4>
                                                <?php
                                            } elseif ($att['cds_att_type'] == 'REPRESENTED') {
                                                ?>
                                                <h4><span class="badge badge-warning">REPRESENTED</span></h4>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($att['cds_att_type'] == 'REPRESENTED') {
                                                echo $att['att_fullname'];
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $att['att_phone_number']; ?></td>
                                        <td><?php echo $att['cds_acc_shares']; ?></td>
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

        $('#cds_acc_table').DataTable({
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