<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>
<?php echo $alert; ?>
<?php 
   $perm_type = "All";
   $status ="All";
   
?>
<section class="tables no-padding-top">   
    <div class="container-fluid" >
        <br/>
        <div id="filter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <form action="<?php echo site_url('reports/detailedreport'); ?>" method="post" class="modal-content">
                    <div class="modal-header">
                        <h4 id="exampleModalLabel" class="modal-title">Filter <?php echo $module_name; ?></h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="item_name">
                                    <label>Select Date Range<br/><small class="text-primary">Clear this field if you want to get report from the beginning.</small></label>
                                    <input placeholder="Select Date Range" class="form-control" name="date_range" id="_date_range" autocomplete="off" value="<?php echo set_value('date_range'); ?>">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="edu_level">
                                    <label>Permit Type</label>
                                    <select style="width: 100%" id="_perm_type" name="perm_type">
                                        <option value="ALL">All</option>
                                        <?php
                                        foreach (PERM_TYPES as $t) {
                                            ?>
                                            <option 
                                            <?php
                                            if (set_value('perm_type') == $t) {
                                                echo ' selected ';
                                                $perm_type = $t;
                                            }
                                            ?> 
                                                value="<?php echo $t; ?>"><?php echo $t; ?></option>
                                                <?php
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" id="apl_status">
                                    <label>Permit Status</label>
                                    <select style="width: 100%" id="_perm_status" name="perm_status">
                                        <option value="ALL">All</option>
                                        <?php
                                        foreach (PERM_STATUSES as $s) {
                                            ?>
                                            <option 

                                                <?php
                                                if (set_value('perm_status') == $s) {
                                                    echo ' selected ';
                                                    $status = $s;
                                                }
                                                ?> 

                                                value="<?php echo $s; ?>"><?php echo $s; ?></option>
                                                <?php
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                        <input type="submit" name="rpt_sbt" class="btn btn-success" value="Submit"/>
                    </div>
                </form>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="line-chart-example card has-shadow">
                    <div class="card-close">
                        <div class="dropdown">
                            <button type="button" data-toggle="modal" data-target="#filter" class="btn btn-info btn-sm"><i class="fa fa-filter"></i>&nbsp;Filter</button>
                            <button type="button" class="btn btn-secondary btn-sm"><i class="fa fa-file-excel-o"></i>&nbsp;Excel</button>
                            <!--<button type="button"  class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"></i>&nbsp;PDF</button>-->
                        </div>
                    </div>
                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Report Summary</h3>
                    </div>
                    <div class="card-body">
                        <form >
                            <div class="row">
                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Implementation Date</label>
                                        <p><?php echo!empty(set_value('date_range')) ? set_value('date_range') : 'From The Beginning'; ?></p>
                                    </div>
                                </div>
                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Permit Type</label>
                                        <p><?php echo $perm_type; ?></p>
                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Permit Status</label>
                                        <p><?php echo $status; ?></p>
                                    </div>
                                </div>

                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <table id="ptw_det_rep_tbl" class="table table-striped" style="width: 100%;font-size: 12px;">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Permit Ref No</th>
                                    <th>Description</th>
                                    <th>Request Date</th>
                                    <th>Requestor</th>
                                    <th>Implementation Dates</th>
                                    <th>Permit Type</th>
                                    <th>Status</th>
                                    <th>Site ID</th>
                                    <th>Site Name</th>
                                    <th>Region</th>
                                    <!--<th style="width: 10px"></th>-->
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
        
        $('select[name=perm_type],select[name=apl_status]').select2();
        $('select[name=perm_status],select[name=apl_status]').select2();
        

        $('#_date_range').daterangepicker({

            "singleDatePicker": false,
            "autoUpdateInput": false,
            "autoApply": true,
            "linkedCalendars": false,
            "startDate": "<?php echo date('m/d/Y'); ?>",
            "maxDate": "<?php echo date('m/d/Y'); ?>"

        }, function (start, end, label) {
            $('#_date_range').val(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

        $('#ptw_det_rep_tbl').DataTable({
            "aaSorting": [],
            responsive: true,
            fixedHeader: {headerOffset: 70},
            searching: true,
            lengthChange: true,
            "pageLength": 25,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('reports/ajaxdetailedreport'); ?>",
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
                {responsivePriority: 2, targets: -2},
                {
                    "targets": [0, 2], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ]
        });

    });

</script>