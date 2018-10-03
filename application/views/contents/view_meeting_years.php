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
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addMeetingYear"><i class="fa fa-calendar-plus-o"></i>&nbsp;Add Meeting Year</button>
                </div>
            </div>
        </div>
        <br/>
        <br/>
        <div id="setMeetingYear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <form id="edit_st_form" class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Set Current Meeting Year</h4>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body" >
                        <div id="edit_st_id">
                            <input name="edit_st_id"  type="hidden"/>
                        </div>

                        <div class="row">

                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group" id="edit_stname">
                                            <label>Meeting Year</label>
                                            <input class="form-control" name="edit_stname" readonly="readonly" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Update Parameter</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <table id="sts_table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Year</th>
                                    <th>Meeting Date</th>
                                    <th>Total Share Capital</th>
                                    <th>Status</th>
                                    <th style="width:10px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($years as $i => $yr) {
                                    ?>
                                    <tr>

                                        <td><?php echo $yr['year_name']; ?></td>
                                        <td><?php echo $yr['year_meeting_date']; ?></td>
                                        <td><?php echo cus_price_form($yr['year_total_share']); ?></td>
                                        <td><?php echo $yr['year_status']; ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                    <!--<a href="<?php // echo site_url('utility/editset/' . $yr['year_id']); ?>" class="dropdown-item text-info"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit Year</a>-->
                                                    <?php
                                                    if ($year_id != $yr['year_id']) {
                                                        ?>
                                                        <a href="<?php echo site_url('utility/switchyear/' . $yr['year_id']); ?>" class="dropdown-item text-info confirm" title="switch to year <?php echo $yr['year_name']?>."> <i class="fa fa-exchange"></i>&nbsp;&nbsp;Switch Year</a>
                                                        <?php
                                                    }
                                                    if ($yr['year_status'] == 'OPENED') {
                                                        ?>
                                                        <a href="<?php echo site_url('utility/closeyear/' . $yr['year_id']); ?>" class="dropdown-item text-danger confirm" title="close meeting year."> <i class="fa fa-close"></i>&nbsp;&nbsp;Close Year</a>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </td>
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

        $('#sts_table').DataTable({
            responsive: true,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 1, targets: 1},
                {responsivePriority: 2, targets: -1}
            ]
        });

    });

    $(document).on('click', '.edit_setting', function (e) {

        e.preventDefault();

        url = $(this).attr('href');

        $('.field_error').remove();

        $.blockUI({message: '<p class="uiblock">Please wait ... </p>'});

        $.ajax({
            url: url,
            type: 'post',

            success: function (data, status) {

                $.unblockUI();

                console.log(data);

                // Check if response have server error
                if (data.status.error == true) {

                    // Check type of error, display or pop 
                    if (data.status.error_type == 'pop') {
                        alert(data.status.error_msg);
                    }

                } else {

                    $('input[name=edit_st_id]').val(data.st_data.st_id);
                    $('input[name=edit_stname]').val(data.st_data.st_label);
                    $('input[name=edit_stvalue]').val(data.st_data.st_value);

                    $('#editSetting').modal('show');
                }

            },
            error: function (xhr, desc, err) {

                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);


                $.unblockUI();

                /*
                 $.alert({
                 title: 'Ooops!',
                 content: 'Something went wrong!' + '<br/><br/>' + 'Please try again.',
                 confirm: function () {
                 // $.alert('Confirmed!'); // shorthand.
                 }
                 });
                 */

            },

            complete: function () {
                //$('.disabled_field').attr('disabled', 'disabled');
            },
            timeout: 10000
        });
    });

    $(document).on('submit', '#edit_st_form', function (e) {

        e.preventDefault();

        //$('.disabled_field').removeAttr('disabled');

        var err = "";
        var postData = $(this).serializeArray();

        $('.field_error').remove();

        $.blockUI({message: '<p class="uiblock">Please wait, we are submitting your form ... </p>'});

        $.ajax({
            url: '<?php echo site_url('utility/submiteditst'); ?>',
            type: 'post',
            data: postData,

            success: function (data, status) {

                $.unblockUI();

                // Check if response have server error
                if (data.status.error == true) {

                    // Check type of error, display or pop 
                    if (data.status.error_type == 'display') {

                        // Display Errors 
                        for (var key in data.status.form_errors) {
                            console.log(key);
                            if (data.status.form_errors.hasOwnProperty(key)) {
                                $('#' + key).append("<p class=\"field_error invalid-feedback\"><i class=\"fa fa-exclamation-circle\"></i>&nbsp;" + data.status.form_errors[key] + "</p>");
                                $('#' + key).addClass("remove_error");
                                $('#' + key).children('.form-control').addClass("is-invalid");
                            }
                        }
                        $('html, body').animate({
                            scrollTop: $(".remove_error").offset().top - 10
                        }, 300);

                    } else if (data.status.error_type == 'pop') {
                        // Pop and error
                        alert(data.status.error_msg);
                    }
                } else {
                    window.location.href = data.url;
                }

            },
            error: function (xhr, desc, err) {

                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);


                $.unblockUI();

                /*
                 $.alert({
                 title: 'Ooops!',
                 content: 'Something went wrong!' + '<br/><br/>' + 'Please try again.',
                 confirm: function () {
                 // $.alert('Confirmed!'); // shorthand.
                 }
                 });
                 */

            },

            complete: function () {
                //$('.disabled_field').attr('disabled', 'disabled');
            },
            timeout: 10000
        });
    });

</script>