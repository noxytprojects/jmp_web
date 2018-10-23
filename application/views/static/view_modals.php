<?php
// Delete user bs modal
if (in_array('modal_template', $modals)) {
    ?>

    <?php
}
?>


<script type="text/javascript">

    $(document).ready(function () {

        // Submit ajax form button clicked
        $(document).on('submit', '#update_profile_form,#edit_section_form,#add_section_form,#edit_department_form,#add_department_form,#approve_request_form,#disapprove_request_form,#request_trip_form', function (e) {
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
