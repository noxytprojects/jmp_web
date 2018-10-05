<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>
<?php echo $alert; ?>
<div id="addSection"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <form id="add_section_form" class="modal-content" action="<?php echo site_url('management/submitaddsection/'); ?>">
            <div class="modal-header">
                <h4 id="exampleModalLabel" class="modal-title">Add Section</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="sec_name">
                            <label>Section Name</label>
                            <input type="text" name="sec_name" placeholder="Enter the section name" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="sec_dept">
                            <label>Section Department</label>
                            <select name="sec_dept" style="width: 100%">
                                <option value=""></option>
                                <?php
                                foreach ($depts as $dept) {
                                    ?>
                                    <option value="<?php echo strtoupper($dept['dept_id']); ?>"><?php echo strtoupper($dept['dept_name']); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="tl_ad_name">
                            <label>Teamleader AD Name</label>
                            <input type="text" name="tl_ad_name" placeholder="Enter the Teamleader full name"  class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="tl_full_name">
                            <label>Teamleader Full Name</label>
                            <input type="text" name="tl_full_name" placeholder="Enter the Teamleader full name"  class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="tl_phone">
                            <label>Teamleader Phone Number</label>
                            <input type="text" name="tl_phone" placeholder="Enter the Teamleader phone number"  class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="tl_email">
                            <label>Teamleader Email Address</label>
                            <input type="text" name="tl_email" placeholder="Enter the Teamleader email address"  class="form-control" />
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
<div id="editSection"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <form id="edit_section_form" class="modal-content" action="">
            <div class="modal-header">
                <h4 id="exampleModalLabel" class="modal-title">Edit Department Details</h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="edit_sec_name">
                            <label>Section Name</label>
                            <input type="text" name="edit_sec_name" placeholder="Enter the section name" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="edit_sec_dept">
                            <label>Section Department</label>
                            <select name="edit_sec_dept" style="width: 100%">
                                <option value=""></option>
                                <?php
                                foreach ($depts as $dept) {
                                    ?>
                                    <option value="<?php echo strtoupper($dept['dept_id']); ?>"><?php echo strtoupper($dept['dept_name']); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="edit_tl_ad_name">
                            <label>Teamleader AD Name</label>
                            <input type="text" name="edit_tl_ad_name" placeholder="Enter the Teamleader full name"  class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="edit_tl_full_name">
                            <label>Teamleader Full Name</label>
                            <input type="text" name="edit_tl_full_name" placeholder="Enter the Teamleader full name"  class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="edit_tl_phone">
                            <label>Teamleader Phone Number</label>
                            <input type="text" name="edit_tl_phone" placeholder="Enter the Teamleader phone number"  class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group" id="edit_tl_email">
                            <label>Teamleader Email Address</label>
                            <input type="text" name="edit_tl_email" placeholder="Enter the Teamleader email address"  class="form-control" />
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
                    <a href="" data-toggle="modal" data-target="#addSection" class="btn btn-info btn-sm"><i class="fa fa-plus-circle"></i>&nbsp;Add Section</a>
                </div>
            </div>
        </div>
        <br/>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <table id="secs_table" class="table table-striped" style="width: 100%;font-size: 13px;">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">No.</th>
                                    <th>Section Name</th>
                                    <th>Department</th>
                                    <th>TL AD Name</th>
                                    <th>TL Full Name</th>
                                    <th>TL Phone</th>
                                    <th>TL Email</th>
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
        
        $('select[name=sec_dept],select[name=edit_sec_dept]').select2({placeholder:'Select section department'});

        $('#secs_table').DataTable({
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
                "url": "<?php echo site_url('management/ajaxsections'); ?>",
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