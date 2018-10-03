<div class="inner-bg">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2 text text-center">
                <h1>Youth Campus Campaign</h1>
                <div class="description">
                    <p>
                        <?php echo $module_name; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12  col-sm-10 offset-md-0 col-md-12 offset-sm-1  col-lg-8 offset-lg-2 form-box">

                <form role="form" id="applicant_form" action="" method="post" class="registration-form">

                    <fieldset id="first_fieldset">
                        <div class="form-top">
                            <div class="form-top-left">
                                <p class="no-padding">Update your subscription information:</p>
                            </div>
                            <div class="form-top-right">

                            </div>
                        </div>

                        <div class="form-bottom">

                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-group" id="full_name">
                                        <label class="" for="full_name">Full Name</label>
                                        <input type="text" name="full_name" autocomplete="off" placeholder="Full Name..." class="form-first-name form-control" value="<?php echo $applicant['appl_full_name']; ?>" id="form-first-name">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-group" id="id_number">
                                        <label class="" for="id_number">ID Number</label>
                                        <input type="text" name="id_number" autocomplete="off" placeholder="ID Number..." class="form-last-name form-control" value="<?php echo $applicant['appl_id_number']; ?>" id="form-last-name">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="edu_level">
                                <label class="" for="edu_level">Education Level</label>
                                <select  name="edu_level" class="" style="width:100%;">
                                    <option value=""></option>
                                    <?php
                                    foreach ($edu_levels as $edu) {
                                        ?>
                                        <option <?php echo ($applicant['appl_edu_level'] == $edu['edu_level_id']) ? 'selected' : ''; ?> value="<?php echo $edu['edu_level_id'] ?>"><?php echo $edu['edu_level_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group" id="college">
                                <label class="" for="college">College</label>
                                <select  name="college" class="" style="width:100%;">
                                    <option value=""></option>
                                    <?php
                                    foreach ($universities as $uni) {
                                        ?>
                                        <option <?php echo ($applicant['appl_uni_id'] == $uni['uni_id']) ? 'selected' : ''; ?> value="<?php echo $uni['uni_id'] ?>"><?php echo $uni['uni_name'] . ' - ' . $uni['uni_acronym']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group" id="joining_year">
                                        <label class="" for="joining_year">Year Of Joining</label>
                                        <select name="joining_year" style="width:100%">
                                            <option value=""></option>
                                            <?php
                                            for ($i = 0; $i < 10; $i++) {
                                                $year = (date('Y') - $i);
                                                ?>
                                                <option <?php echo ($year == $applicant['appl_joining_yr']) ? 'selected' : ''; ?> name="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group" id="ending_year">
                                        <label class="" for="ending_year">Year Of Ending</label>
                                        <select name="ending_year" style="width:100%">
                                            <option value=""></option>
                                            <?php
                                            for ($i = 0; $i < 10; $i++) {
                                                $year = (date('Y') + $i);
                                                ?>
                                                <option <?php echo ($year == $applicant['appl_ending_yr']) ? 'selected' : ''; ?>  name="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-12">
                                    <div class="form-group">
                                        <label>Attachment(s)</label>
                                        <div>
                                            <ul class="row" id="attachments">
                                                <?php
                                                foreach ($attachments as $a) {
                                                    ?>
                                                    <li class="col-6 col-md-3"><img class="" src="<?php echo base_url(); ?>uploads/<?php echo $applicant['folder_name'] . '/' . $a['att_name']; ?>" style="width: 100%;cursor: -webkit-zoom-in;cursor: zoom-in;cursor: -moz-zoom-in;"></li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="padding-bottom:20px;" id="attachment">
                                <div class="form-group" id="college">
                                    <label class="" for="college">Replace Attachment(s) <i style="font-size: 14px;color:#888;">(Upload new attachments to replace existing)</i></label>
                                    <div id="filing" class="dropzone">
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <a href="<?php echo site_url('status'); ?>" class="btn btn-danger btn-lg" style="font-size: 16px; padding: 12px 25px;">Cancel</a> &nbsp;
                            <button type="submit" class="btn btn-next">Update</button>
                        </div>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    Dropzone.autoDiscover = false;

    $(document).ready(function () {

        $('.registration-form fieldset:first-child').fadeIn('slow');
        $('select[name=college]').select2({placeholder: 'Select your college'});
        $('select[name=edu_level]').select2({placeholder: 'Select your education level'});
        $('select[name=joining_year]').select2({placeholder: 'Select joining year'});
        $('select[name=ending_year]').select2({placeholder: 'Select ending year'});

        viewer = new Viewer(document.getElementById('attachments'));


        var myDropzone = new Dropzone('div#filing', {url: '<?php echo site_url('utility/upload/TEMP_REPLACE'); ?>',
            parallelUploads: 100,
            maxFiles: 2,
        });

        //        Drop zone on error
        myDropzone.on("error", function (file, message, xhr) {

            var header = xhr.status + ": " + xhr.statusText;

            $(file.previewElement).find('.dz-error-message').text(message.error);

            // Create the cancel link
            var cancelLink = Dropzone.createElement('<a href="javascript:undefined;" class="text-danger" style="display:block;text-align:center;cursor:pointer;position: absolute;top: -10px;z-index: 100;right: -10px;background: #f1f1f1;padding: 2px 10px;border-radius: 100%;"><i class="fa fa-trash"></i></a>');

            // Add the cancel link to the preview element
            // If you want it to replace another element, you can do that your way of course.
            file.previewElement.appendChild(cancelLink);

            // Now the most important part: attach the event listener here:
            cancelLink.addEventListener("click", function (e) {

                e.preventDefault();
                myDropzone.removeFile(file);

            });

        });


        myDropzone.on("success", function (file, message) {

            // Create the cancel link
            var cancelLink = Dropzone.createElement('<a href="javascript:undefined;" class="text-danger" style="display:block;text-align:center;cursor:pointer;position: absolute;top: -10px;z-index: 100;right: -10px;background: #f1f1f1;padding: 2px 10px;border-radius: 100%;"><i class="fa fa-trash"></i></a>');

            // Add the cancel link to the preview element
            // If you want it to replace another element, you can do that your way of course.
            file.previewElement.appendChild(cancelLink);

            // Now the most important part: attach the event listener here:
            cancelLink.addEventListener("click", function (e) {

                e.preventDefault();
                $.ajax({

                    type: "get",
                    url: "<?php echo base_url(); ?>index.php/utility/removeupload/" + message.filename,
                    success: function (data)
                    {

                    }

                });

                // Referencing file here as closure
                myDropzone.cancelUpload(file);
                myDropzone.removeFile(file);

            });

        });


        myDropzone.on("addedfile", function (file) {

            /*
             
             // Create the cancel link
             var cancelLink = Dropzone.createElement('<a href="javascript:undefined;" style="display:block;text-align:center;">Remove File</a>');
             
             // Add the cancel link to the preview element
             // If you want it to replace another element, you can do that your way of course.
             file.previewElement.appendChild(cancelLink);
             
             // Now the most important part: attach the event listener here:
             cancelLink.addEventListener("click", function(e) {
             
             e.preventDefault();
             // Referencing file here as closure
             myDropzone.cancelUpload(file);
             myDropzone.removeFile(file);
             
             });
             
             */


        });


        $('.removetempfile').click(function (e) {

            e.preventDefault();
            mother = $(this).parents('.dz-preview');
            url = $(this).attr('href');

            $.ajax({
                type: "get",
                url: url,
                success: function (data)
                {
                    mother.remove();
                }

            });
        });


        // On submitt application details
        $(document).on('submit', '#applicant_form', function (e) {

            e.preventDefault();

            var postData = $(this).serializeArray();

            console.log(postData);
            $('.field_error').remove();

            $.blockUI({message: `<div id="loader-wrapper"><div id="loader"></div></div>`});

            $.ajax({
                url: '<?php echo site_url('status/submitUpdateApplication'); ?>',
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
                                if (data.status.form_errors.hasOwnProperty(key)) {
                                    $('#' + key).append("<p class=\"field_error \" style=\"color:#e93f33;\"><i class=\"fa fa-exclamation-circle\"></i>&nbsp;" + data.status.form_errors[key] + "</p>");
                                    //$('#' + key).children('input').addClass("input-error");
                                }
                            }

                            $('html, body').animate({
                                scrollTop: $(".field_error").offset().top - 140
                            }, 300);

                        } else if (data.status.error_type == 'pop') {
                            // Pop and error
                            $.alert(data.status.error_msg);
                        }

                    } else {
                        $.confirm({
                            title: 'Well Done!',
                            content: 'Details updated successfully!',
                            buttons: {
                                confirm: function () {
                                    window.location.href = "<?php echo site_url('status/applicationstatus'); ?>";
                                }
                            }
                        });
                        
                    }

                },
                error: function (xhr, desc, err) {

                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);


                    $.unblockUI();
                    $.alert({
                        title: 'Ooops!',
                        content: 'Something went wrong!' + '<br/><br/>' + 'Please try again.',
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

    });


</script>
