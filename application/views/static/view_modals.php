<?php
// Add new user bs modal
if (in_array('modal_add_user', $modals)) {
    ?>
    <div id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <form id="user_form" class="modal-content" action="<?php echo site_url('user/submituser'); ?>">
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title">Add New User</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-lg-12">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="full_name">
                                        <label>User Full Name</label>
                                        <input autocomplete="off" placeholder="Enter user full name" class="form-control" name="full_name"  value="">
                                    </div>
                                </div>
                                <div class="col-md-6" >
                                    <div class="form-group" id="phone">
                                        <label>User Phone Number</label>
                                        <input autocomplete="off" placeholder="Enter user phone" class="form-control" name="phone"  value="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group"  id="email">
                                        <label>User Email</label>
                                        <input autocomplete="off" placeholder="Enter user email" class="form-control" name="email" value="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group" id="user_ad_name">
                                        <label>User AD Name (Optional)</label>
                                        <input autocomplete="off" placeholder="Enter the domain username" class="form-control" name="user_ad_name"  value="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="role">
                                        <label>User Role</label>
                                        <select class="form-control" name="role" name="role" id="user_role" style="width:100%">
                                            <option value="" ></option>

                                            <?php
                                            foreach ($user_roles as $role) {
                                                ?>
                                                <option value="<?php echo $role['option_name']; ?>"><?php echo $role['option_name']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6" >
                                    <div class="form-group" id="title">
                                        <label>User Title</label>
                                        <input autocomplete="off" placeholder="Enter the user title" class="form-control" name="title"  value="">
                                    </div>
                                </div>
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
    <?php
}

// Edit user bs modal
if (in_array('modal_edit_user', $modals)) {
    ?>
    <div id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-lg">
            <form id="edit_user_form" class="modal-content" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" >
                    <div id="edit_user_id">
                        <input name="edit_user_id"  type="hidden"/>
                    </div>

                    <div class="row">

                        <div class="col-lg-12">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="edit_full_name">
                                        <label>User Fullname</label>
                                        <input autocomplete="off" placeholder="Enter user full name" class="form-control" name="edit_full_name"  value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"  id="edit_email">
                                        <label>User Email</label>
                                        <input autocomplete="off" placeholder="Enter user email" class="form-control" name="edit_email" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6" >
                                    <div class="form-group" id="edit_phone">
                                        <label>User Phone Number</label>
                                        <input autocomplete="off" placeholder="Enter user phone" class="form-control" name="edit_phone"  value="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group" id="edit_user_ad_name">
                                        <label>User Ad Name (Optional)</label>
                                        <input autocomplete="off" placeholder="Enter the domain username" class="form-control" name="edit_user_ad_name"  value="">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="edit_role">
                                        <label>User Role</label>
                                        <select class="form-control" name="edit_role" name="role" id="edit_user_role" style="width:100%">
                                            <option value="" ></option>
                                            <?php
                                            foreach ($user_roles as $role) {
                                                ?>
                                                <option value="<?php echo $role['option_name']; ?>"><?php echo $role['option_name']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6" >
                                    <div class="form-group" id="edit_title">
                                        <label>User Title</label>
                                        <input autocomplete="off" placeholder="Enter the user title" class="form-control" name="edit_title"  value="">
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Update User</button>
                </div>
            </form>
        </div>
    </div>
    <?php
}

// Delete user bs modal
if (in_array('modal_delete_user', $modals)) {
    ?>
    <div id="delUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <form id="del_user_form" class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete User</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" >
                    <div id="del_user_id">
                        <input name="del_user_id"  type="hidden"/>
                    </div>

                    <div class="row">

                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Are you sure you want to delete this user?</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input class="form-control" name="del_username" readonly="readonly" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" id="edit_full_name">
                                        <label>User Fullname</label>
                                        <input placeholder="Enter user full name" class="form-control" name="del_full_name" readonly="readonly"  value="">
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;Delete User</button>
                </div>
            </form>
        </div>
    </div>
    <?php
}
?>


<script type="text/javascript">

    $(document).ready(function () {

        $('#user_title').select2({placeholder: 'Select user title'});
        $('#edit_user_title').select2({placeholder: 'Select user title'});
        $('#user_role,select[name=edit_role]').select2({placeholder: 'Select user role'});

        // Submit ajax form button clicked
        $(document).on('submit', '#del_user_form,#edit_user_form,#user_form,#update_profile_form,#edit_section_form,#add_section_form,#edit_department_form,#add_department_form,#approve_request_form,#disapprove_request_form,#request_trip_form', function (e) {
            e.preventDefault();
            var post_data = $(this).serializeArray();
            submitAjaxForm(post_data, $(this).attr('action'));
        });

        //Cache data ajaxly
        $(document).on('change', 'select[name=dept],select[name=cds_number]', function (e) {
            e.preventDefault();
            field = $(this).attr('name');
            value = $(this).val()
            cacheAjaxFields({field: field, value: value}, $(this).prop("tagName"));

        });

        // Request Form
        $(document).on('click', '.request_form', function (e) {

            e.preventDefault();

            url = $(this).attr('href');

            $.blockUI({message: `<div id="loader-wrapper"><div id="loader"></div></div>`}); // Block user interdace during submitting

            // Ajax request itself
            $.ajax({
                url: url,
                type: 'post',
                data: {}, // post data that are passed
                success: function (data, status) {

                    // Check if response have server error
                    if (data.status.error == true) {
                        // Check type of error if its pop 
                        if (data.status.error_type == 'pop') {
                            // Pop an error
                            $.alert(data.status.error_msg);
                        }

                    } else {

                        if (data.status.redirect == true) {

                            window.location.href = data.status.redirect_url;

                        } else if (data.status.pop_form == true) {

                            switch (data.status.form_type) {

                                case 'editDepartment':

                                    $('input[name=edit_dept_name]').val(data.dept.dept_name);
                                    $('input[name=edit_hod_full_name]').val(data.dept.dept_hod_full_name);
                                    $('input[name=edit_hod_email]').val(data.dept.dept_hod_email);
                                    $('input[name=edit_hod_phone]').val(data.dept.dept_hod_phone);
                                    $('input[name=edit_hod_ad_name]').val(data.dept.dept_hod_ad_name);

                                    $('#edit_department_form').attr('action', data.status.form_url);
                                    break;



                                case 'editSection':

                                    $('input[name=edit_sec_name]').val(data.section.sec_name);
                                    $('select[name=edit_sec_dept]').val(data.section.sec_dept_id).trigger('change');
                                    $('input[name=edit_tl_full_name]').val(data.section.sec_tl_full_name);
                                    $('input[name=edit_tl_email]').val(data.section.sec_tl_email);
                                    $('input[name=edit_tl_phone]').val(data.section.sec_tl_phone_number);
                                    $('input[name=edit_tl_ad_name]').val(data.section.sec_tl_ad_name);

                                    $('#edit_section_form').attr('action', data.status.form_url);
                                    break;

                                case 'editUser':

                                    $('input[name=edit_user_ad_name]').val(data.user_data.usr_ad_name);
                                    $('input[name=edit_user_contractor]').val(data.user_data.usr_contractor);
                                    $('input[name=edit_full_name]').val(data.user_data.usr_fullname);
                                    $('input[name=edit_email]').val(data.user_data.usr_email);
                                    $('input[name=edit_title]').val(data.user_data.usr_title);
                                    $('input[name=edit_phone]').val(data.user_data.usr_phone);
                                    $("select[name=edit_role]").val(data.user_data.usr_role).trigger('change');
                                    $('#edit_user_form').attr('action', data.status.form_url);
                                    break;

                            }

                            $('#' + data.status.form_type).modal('show');

                        }
                    }
                    $.unblockUI(); // Ublock UI coz we got the response

                },

                // Holly molly, we may have some errors
                error: function (xhr, desc, err) {

                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);// just log to see whats going on

                    $.unblockUI(); // ublock UI so they can be able to try again
                    $.alert({
                        title: 'Something went wrong!',
                        content: '<br/>' + err + '<br/>' + 'Please try again.',
                        confirm: function () {
                            // $.alert('Confirmed!'); // shorthand.
                        }
                    });
                },

                complete: function () {
                    //$('.disabled_field').attr('disabled', 'disabled');
                },
                timeout: 10000
            });

        });


        // This function submit all the modal ajax forms 
        function submitAjaxForm(post_data, url) {

            $('.field_error').remove(); // Remove red errors from all fields
            $.blockUI({message: `<div id="loader-wrapper"><div id="loader"></div></div>`}); // Block user interdace during submitting

            // Ajax request itself
            $.ajax({
                url: url,
                type: 'post',
                data: post_data, // post data that are passed
                success: function (data, status) {

                    $.unblockUI(); // Ublock UI coz we got the response

                    // Check if response have server error
                    if (data.status.error == true) {


                        // Check type of error, display or pop 
                        if (data.status.error_type == 'fields_error') {

                            // Display Errors 
                            for (var key in data.status.form_errors) {
                                console.log(key);
                                if (data.status.form_errors.hasOwnProperty(key)) {
                                    $('#' + key.replace("[]", "")).append("<p class=\"field_error invalid-feedback\"><i class=\"fa fa-exclamation-circle\"></i>&nbsp;" + data.status.form_errors[key] + "</p>");
                                    $('#' + key.replace("[]", "")).addClass("remove_error");
                                    $('#' + key.replace("[]", "")).children('.form-control').addClass("is-invalid");
                                }
                            }
                            // Animate by scrolling to a error field
                            $('html, body').animate({
                                scrollTop: $(".remove_error").offset().top - 10
                            }, 300);

                        } else if (data.status.error_type == 'pop') {
                            // Pop an error
                            $.alert(data.status.error_msg);
                        }
                    } else {

                        if (data.status.redirect == true) {
                            // Redirect to a respose url
                            window.location.href = data.status.redirect_url;
                        }

                    }

                },

                // Holly molly, we may have some errors
                error: function (xhr, desc, err) {

                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);// just log to see whats going on

                    $.unblockUI(); // ublock UI so they can be able to try again
                    $.alert({
                        title: 'Something went wrong!',
                        content: '<br/>' + err + '<br/>' + 'Please try again.',
                        confirm: function () {
                            // $.alert('Confirmed!'); // shorthand.
                        }
                    });
                },

                complete: function () {
                    //$('.disabled_field').attr('disabled', 'disabled');
                },
                timeout: 10000
            });
        }

        // This function will autofill some fields
        function cacheAjaxFields(data, field_type) {

            var selected_value = data.value;

            $.blockUI({message: `<div id="loader-wrapper"><div id="loader"></div></div>`}); // Block user interdace during submitting

            // Ajax request itself
            $.ajax({
                url: '<?php echo site_url('maintenance/cachefields'); ?>',
                type: 'post',
                data: data, // post data that are passed
                success: function (data, status) {

                    $.unblockUI(); // Ublock UI coz we got the response

                    // Check if response have server error
                    if (data.status.error == true) {

                        if (field_type == 'SELECT' && (selected_value != '' && selected_value != undefined)) {
                            $('select[name=' + field + ']').val('').trigger('change');
                        }

                        // Check type of error if its pop 
                        if (data.status.error_type == 'pop') {
                            // Pop an error
                            $.alert(data.status.error_msg);
                        }

                    } else {

                        switch (field) {
                            // Populate add attendance form
                            case 'dept':

                                $('select[name=section]').empty().select2({
                                    placeholder: 'Select driver section',
                                    data: data.selections
                                });

                                break;
                        }
                    }

                },

                // Holly molly, we may have some errors
                error: function (xhr, desc, err) {

                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);// just log to see whats going on

                    if (field_type == 'SELECT' && (selected_value != '' && selected_value != undefined)) {
                        $('select[name=' + field + ']').val('').trigger('change');
                    }

                    $.unblockUI(); // ublock UI so they can be able to try again
                    $.alert({
                        title: 'Something went wrong!',
                        content: '<br/>' + err + '<br/>' + 'Please try again.',
                        confirm: function () {
                            // $.alert('Confirmed!'); // shorthand.
                        }
                    });
                },

                complete: function () {
                    //$('.disabled_field').attr('disabled', 'disabled');
                },
                timeout: 10000
            });
        }
    });
</script>
