<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>
<?php echo $alert; ?>
<div id="addDepartment"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <form id="add_departiment_form" class="modal-content" action="<?php echo site_url('management/submitadddepartment/'); ?>">
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title">Add Department</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="dept_name">
                                <label>Department Name</label>
                                <input type="text" name="dept_name" placeholder="Enter the department name" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="hod_ad_name">
                                <label>HOD AD Name</label>
                                <input type="text" name="hod_ad_name" placeholder="Enter the HOD full name"  class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="hod_full_name">
                                <label>HOD Full Name</label>
                                <input type="text" name="hod_full_name" placeholder="Enter the HOD full name"  class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="hod_phone">
                                <label>HOD Phone Number</label>
                                <input type="text" name="hod_phone" placeholder="Enter the HOD phone number"  class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="hod_email">
                                <label>HOD Email Address</label>
                                <input type="text" name="hod_email" placeholder="Enter the HOD email address"  class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Add</button>
                </div>
            </form>
        </div>
    </div>
<div id="editDepartment"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <form id="edit_department_form" class="modal-content" action="">
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title">Edit Department Details</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="edit_dept_name">
                                <label>Department Name</label>
                                <input type="text" name="edit_dept_name" placeholder="Enter the department name" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="edit_hod_ad_name">
                                <label>HOD AD Name</label>
                                <input type="text" name="edit_hod_ad_name" placeholder="Enter the HOD full name"  class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="edit_hod_full_name">
                                <label>HOD Full Name</label>
                                <input type="text" name="edit_hod_full_name" placeholder="Enter the HOD full name"  class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="edit_hod_phone">
                                <label>HOD Phone Number</label>
                                <input type="text" name="edit_hod_phone" placeholder="Enter the HOD phone number"  class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="edit_hod_email">
                                <label>HOD Email Address</label>
                                <input type="text" name="edit_hod_email" placeholder="Enter the HOD email address"  class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save</button>
                </div>
            </form>
        </div>
    </div>
<section class="tables no-padding-top">   
    <div class="container-fluid">
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <!--                <div class="btn-group pull-left" role="group" aria-label="Basic example">
                                    <a href="<?php echo site_url('user/dashboard'); ?>"  class="btn btn-info btn-sm" ><i class="fa fa-dashboard"></i>&nbsp;Dashboard</a>
                                </div>-->
                <div class="btn-group pull-right" role="group" aria-label="Basic example">
                    <a href="" data-toggle="modal" data-target="#addDepartment" class="btn btn-info btn-sm"><i class="fa fa-plus-circle"></i>&nbsp;Add Department</a>
                </div>
            </div>
        </div>
        <br/>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <table id="dept_table" class="table table-striped" style="width: 100%;font-size: 13px;">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">No.</th>
                                    <th>Department Name</th>
                                    <th>HOD AD Name</th>
                                    <th>HOD Full Name</th>
                                    <th>HOD Phone</th>
                                    <th>HOD Email</th>
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
        
        $('#dept_table').DataTable({
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
                "url": "<?php echo site_url('management/ajaxdepartments'); ?>",
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
                    "targets": [0,2], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ]
        });

    });

</script>