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
                    <?php
                    if (in_array(strtolower($user_role), ['admin', 'support'])) {
                        ?>
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addAttendance"><i class="fa fa-plus-circle"></i>&nbsp;Register Attendance</button>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
        <br/>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <table id="cds_att_table" class="table table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">No.</th>
                                    <th>CDS&nbsp;Acc&nbsp;No</th>
                                    <th>Shareholder&nbsp;Name</th>
                                    <th>Type</th>
                                    <th>Represented&nbsp;By</th>
                                    <th>Phone&nbsp;Number</th>

                                    <th>Voting&nbsp;Channel</th>
                                    <th>Total<br/>Shares</th>
                                    <th>Share<br/>Parecentage</th>
                                    <th style="width: 10px"></th>
                                </tr>
                            </thead>
                            <tbody>
                               
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
        
        $('#cds_att_table').DataTable({
            "aaSorting": [],
            responsive: true,
            fixedHeader: {headerOffset: 70},
            searching: true,
            lengthChange: false,
            "pageLength": 25,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('shareholder/ajaxattendance'); ?>",
                data: {type: ""},
                "type": "POST",
                error: function (xhr, error, thrown) {
                    //alert('Something went wrong!');
                    // location.reload(false);
                }
            },

            //Set column definition initialisation properties.
            columnDefs: [
                {responsivePriority: 1, targets: 1},
                {responsivePriority: 2, targets: -1},
                {responsivePriority: 3, targets: -3},
                {
                    "targets": [0,3,4,5,6,7,8], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ]
        });

    });

</script>