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
                                <h3>Step 1 / 3</h3>
                                <p class="no-padding">Tell us your subscription information:</p>
                            </div>
                            <div class="form-top-right">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>

                        <div class="form-bottom">

                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-group" id="full_name">
                                        <label class="" for="full_name">Full Name</label>
                                        <input type="text" name="full_name" autocomplete="off" placeholder="Full Name..." class="form-first-name form-control"  id="form-first-name">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-group" id="id_number">
                                        <label class="" for="id_number">ID Number</label>
                                        <input type="text" name="id_number" autocomplete="off" placeholder="ID Number..." class="form-last-name form-control" id="form-last-name">
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
                                        <option value="<?php echo $edu['edu_level_id'] ?>"><?php echo $edu['edu_level_name']; ?></option>
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
                                        <option value="<?php echo $uni['uni_id'] ?>"><?php echo $uni['uni_name'] . ' - ' . $uni['uni_acronym']; ?></option>
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
                                                <option name="<?php echo $year; ?>"><?php echo $year; ?></option>
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
                                                <option name="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <button type="button" class="btn btn-next">Next</button>
                        </div>
                    </fieldset>

                    <fieldset id="second_fieldset">

                        <div class="form-top">
                            <div class="form-top-left">
                                <h3>Step 2 / 3</h3>
                                <p class="no-padding">Your mobile numbers and offer type:</p>
                            </div>
                            <div class="form-top-right">
                                <i class="fa fa-mobile"></i>
                            </div>
                        </div>

                        <div class="form-bottom">

                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-group" id="msisdn_1">
                                        <label class="" for="msisdn_1">Phone Number 1</label>
                                        <input type="text" name="msisdn_1" autocomplete="off" placeholder="Phone Number 1..." class="form-phone-number form-control" id="form-phone-number">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-group" id="msisdn_1_offer_type">
                                        <label class="" for="msisdn_1_offer_type">Phone Number 1 Offer Type</label>
                                        <select  name="msisdn_1_offer_type" class="" style="width:100%;">
                                            <option value=""></option>
                                            <option value="1">Data Only</option>
                                            <option value="2">Intergrated</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-group" id="msisdn_2">
                                        <label class="" for="msisdn_2">Phone Number 2 <i class="text-info">(Optional)</i></label>
                                        <input type="text" name="msisdn_2" autocomplete="off" placeholder="Phone Number 2..." class="form-phone-number form-control" id="form-phone-number">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="form-group" id="msisdn_2_offer_type">
                                        <label class="" for="msisdn_2_offer_type">Phone Number 2 Offer Type</label>
                                        <select  name="msisdn_2_offer_type" class="" style="width:100%;">
                                            <option value=""></option>
                                            <option value="1">Data Only</option>
                                            <option value="2">Intergrated</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <button type="button" class="btn btn-previous">Previous</button>
                            <button type="button" class="btn btn-next-2">Next</button>
                        </div>
                    </fieldset>

                    <fieldset id="third_fieldset" >
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3>Step 2 / 2</h3>
                                <p>Attach The Scanned Copy Of Your Student ID:</p>
                            </div>
                            <div class="form-top-right">
                                <i class="fa fa-id-card"></i>
                            </div>
                        </div>
                        <div class="form-bottom">
                            <div style="padding-bottom:20px;" id="attachment">
                                <div id="filing" class="dropzone"></div>
                            </div>
                            <button type="button" class="btn btn-previous">Previous</button>
                            <button type="button" class="btn btn-join">Join</button>
                        </div>
                    </fieldset>

                    <fieldset id="final_fieldset">
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3>Thank You</h3>
                                <p>You are done!</p>
                            </div>
                            <div class="form-top-right">
                                <i class="fa fa-check-circle-o text-success"></i>
                            </div>
                        </div>
                        <div class="form-bottom">
                            <h1 class="h1 text-center">Congratulations!</h1><br/>
                            <p class="text-center" style="padding-bottom:85px;">
                                Your request has been sent successfully. 
                                We will notify you when its processed.Thank you for choosing Vodacom. 
                            </p>
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

        first_fields = ['id_number', 'edu_level', 'college', 'joining_year', 'ending_year', 'full_name'];
        second_fields = ['msisdn_1', 'msisdn_1_offer_type', 'msisdn_2', 'msisdn_2_offer_type']

        $('select[name=college]').select2({placeholder: 'Select your college'});
        $('select[name=edu_level]').select2({placeholder: 'Select your education level'});
        $('select[name=joining_year]').select2({placeholder: 'Select joining year'});
        $('select[name=ending_year]').select2({placeholder: 'Select ending year'});
        $('select[name=msisdn_1_offer_type]').select2({placeholder: 'Select your offer type for number 1'});
        $('select[name=msisdn_2_offer_type]').select2({placeholder: 'Select your offer type for number 2'});

        var myDropzone = new Dropzone('div#filing', {url: '<?php echo site_url('utility/upload'); ?>',
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

        //Remove Field Errors
        $(document).on("click", ".form-group", function () {
            $(this).children(".field_error").remove();
        });


        /*
         Form
         */

        $('.registration-form fieldset:first-child').fadeIn('slow');

        $('.registration-form input[type="text"], .registration-form input[type="password"], .registration-form textarea').on('focus', function () {
            $(this).removeClass('input-error');
        });


        $('.registration-form .btn-next').on('click', function () {
            var parent_fieldset = $(this).parents('fieldset');
            parent_fieldset.fadeOut(10, function () {
                $(this).next().fadeIn();
            });

        });

        // next step to attach image before join
        $('.registration-form .btn-next-2').on('click', function () {

            var err = "";
            var parent_fieldset = $(this).parents('fieldset');
            var postData = $('#applicant_form').serializeArray();


            console.log(postData);
            $('.field_error').remove();

            $.blockUI({message: `<div id="loader-wrapper"><div id="loader"></div></div>`});

            $.ajax({
                url: '<?php echo site_url('catalogue/validateMsisdnAndOffers'); ?>',
                type: 'post',
                data: postData,

                success: function (data, status) {
                    $.unblockUI();
                    // Check if response have server error
                    if (data.status.error == true) {
                        has_prev_page_errors = false;
                        // Check type of error, display or pop 
                        if (data.status.error_type == 'display') {
                            // Display Errors 
                            for (var key in data.status.form_errors) {

                                // Check if we have errors in previous pages
                                if (first_fields.indexOf(key) > -1) {
                                    console.log('There is an error in ' + key);
                                    has_prev_page_errors = true;
                                }

                                if (data.status.form_errors.hasOwnProperty(key)) {
                                    $('#' + key).append("<p class=\"field_error \" style=\"color:#e93f33;\"><i class=\"fa fa-exclamation-circle\"></i>&nbsp;" + data.status.form_errors[key] + "</p>");
                                    //$('#' + key).children('input').addClass("input-error");
                                }
                            }
                            if (has_prev_page_errors == true) {

                                parent_fieldset.fadeOut(100, function () {
                                    $(this).prev().fadeIn();
                                });
                            }

                            $('html, body').animate({
                                scrollTop: $(".input-error").offset().top - 20
                            }, 300);

                        } else if (data.status.error_type == 'pop') {
                            // Pop and error
                            $.alert(data.status.error_msg);
                        }



                    } else {
                        parent_fieldset.fadeOut(10, function () {
                            $(this).next().fadeIn();
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


        // btn join
        $('.registration-form .btn-join').on('click', function () {

            var err = "";
            var has_prev_page_errors = false;
            var parent_fieldset = $(this).parents('fieldset');
            var postData = $('#applicant_form').serializeArray();


            console.log(postData);
            $('.field_error').remove();

            $.blockUI({message: `<div id="loader-wrapper"><div id="loader"></div></div>`});

            $.ajax({
                url: '<?php echo site_url('catalogue/join'); ?>',
                type: 'post',
                data: postData,

                success: function (data, status) {
                    $.unblockUI();

                    // Check if response have server error
                    if (data.status.error == true) {
                        has_error_in_first_step = false;
                        has_error_in_second_step = false;
                        // Check type of error, display or pop 
                        if (data.status.error_type == 'display') {

                            // Display Errors 
                            for (var key in data.status.form_errors) {

                                // Check if we have errors in first step
                                if (first_fields.indexOf(key) > -1) {
                                    has_error_in_first_step = true;
                                }

                                // Check if we have errors in second step 
                                if (second_fields.indexOf(key) > -1) {
                                    has_error_in_second_step = true;
                                }

                                if (data.status.form_errors.hasOwnProperty(key)) {
                                    $('#' + key).append("<p class=\"field_error \" style=\"color:#e93f33;\"><i class=\"fa fa-exclamation-circle\"></i>&nbsp;" + data.status.form_errors[key] + "</p>");
                                    //$('#' + key).children('input').addClass("input-error");
                                }
                            }
                            $('html, body').animate({
                                scrollTop: $(".input-error").offset().top - 10
                            }, 300);

                        } else if (data.status.error_type == 'pop') {
                            // Pop and error
                            alert(data.status.error_msg);
                        }

                        if (has_error_in_first_step) {
                            parent_fieldset.fadeOut(400, function () {
                                $('#first_fieldset').fadeIn();
                            });
                        } else if (has_error_in_second_step) {
                            parent_fieldset.fadeOut(400, function () {
                                $('#second_fieldset').fadeIn();
                            });
                        }



                    } else {
                        parent_fieldset.fadeOut(10, function () {
                            $(this).next().fadeIn();
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

        // previous step
        $('.registration-form .btn-previous').on('click', function () {
            $(this).parents('fieldset').fadeOut(400, function () {
                $(this).prev().fadeIn();
            });
        });

        // submit
        $('.registration-form').on('submit', function (e) {

            $(this).find('input[type="text"], input[type="password"], textarea').each(function () {
                if ($(this).val() == "") {
                    e.preventDefault();
                    $(this).addClass('input-error');
                } else {
                    $(this).removeClass('input-error');
                }
            });

        });


    });


</script>
