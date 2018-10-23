<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>

<?php echo $alert; ?>
<section class="tables no-padding-top">   
    <div class="container-fluid">

        <br/>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <form id="update_profile_form" style="font-size: 14px;"  action="<?php echo site_url('api/submitdriverdetails'); ?>">
                    <h1 class="h5">Driver Details</h1>

                    <div class="row">

                        <div class="col-md-6 col-sm-6">
                            <div class="form-group" id="ad_name">
                                <label>AD Name</label>
                                <input readonly="" autocomplete="off" placeholder="Loading driver ad name"  class="form-control" name="driver_ad_name"  value="<?php echo $ad_name; ?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="form-group" id="name">
                                <label>Full Name</label>
                                <input autocomplete="off" placeholder="Enter the driver full name"  class="form-control" name="name"  value="<?php echo $driver['dp_full_name']; ?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="form-group" id="phone">
                                <label>Phone Number</label>
                                <input autocomplete="off" placeholder="Enter the driver phone number"  class="form-control" name="phone"  value="<?php echo $driver['dp_phone_number']; ?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="form-group" id="email">
                                <label>Email Address</label>
                                <input autocomplete="off" placeholder="Enter the driver email addresssr"  class="form-control" name="email"  value="<?php echo $driver['dp_email']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group" id="dept">
                                <label>Department</label>
                                <select name="dept" class="form-control" style="width:100%;">
                                    <option value=""></option>
                                    <?php
                                    foreach ($depts as $dept) {
                                        ?>
                                        <option 
                                        <?php
                                        if ($dept['dept_id'] == $driver['dp_dept_id']) {
                                            echo ' selected ';
                                        }
                                        ?> 
                                            value="<?php echo $dept['dept_id']; ?>"><?php echo $dept['dept_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="form-group" id="section">
                                <label>Section</label>
                                <select name="section" class="form-control" style="width:100%;">
                                    <option value=""></option>
                                    <?php
                                    foreach ($sections as $sec) {
                                        ?>
                                        <option 
                                        <?php
                                        if ($sec['sec_id'] == $driver['dp_section_id']) {
                                            echo ' selected ';
                                        }
                                        ?>
                                            value="<?php echo $sec['sec_id']; ?>"><?php echo $sec['sec_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                </select>
                            </div>
                        </div>

                    </div>


                    <div class="row">

                        <div class="col-md-6 col-sm-6">
                            <div class="form-group" id="manager">
                                <label>Line Manager</label>
                                <select name="manager" class="form-control" style="width:100%;">
                                    <option value=""></option>
                                    <?php
                                    foreach ($managers as $manager) {
                                        ?>
                                        <option 
                                        <?php
                                        if ($manager['ao_ad_name'] == $driver['dp_ao_ad_name']) {
                                            echo ' selected ';
                                        }
                                        ?>
                                            value="<?php echo $manager['ao_ad_name']; ?>"><?php echo $manager['ao_full_name'] . ' - ' . $manager['ao_email']; ?></option>
                                            <?php
                                        }
                                        ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="form-group" id="medical_by_osha">
                                <label>Driver Medical Fitness Assessment Done By OSHA</label>
                                <div class="i-checks">
                                    <input id="oshayes" type="radio" <?php echo $driver['dp_medical_by_osha'] == 'YES' ? 'checked' : ''; ?> value="YES" name="medical_by_osha" class="radio-template">
                                    <label for="oshayes">YES</label>
                                </div>
                                <div class="i-checks">
                                    <input id="oshano" type="radio" <?php echo $driver['dp_medical_by_osha'] == 'NO' ? 'checked' : ''; ?> value="NO" name="medical_by_osha" class="radio-template">
                                    <label for="oshano">NO</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">


                        <div class="col-md-6 col-sm-6 <?php echo $driver['dp_medical_by_osha'] == 'YES' ? '' : ' hide '; ?>" id="mf_date">
                            <div class="form-group" id="medical_fitness_date">
                                <label>Medical Fitness Assessment Date</label>
                                <input autocomplete="off" placeholder="Enter the medical fitness date"  class="form-control max_date" name="medical_fitness_date"  value="<?php //echo $driver['dp_email'];                 ?>">
                            </div>
                        </div>

                        <?php
                        $medical_templates = "";
                        $i = 1;
                        foreach ($medical_attachments as $f) {
                            if ($f['att_status'] == '1') {
                                $medical_templates .= '<div><a href="' . base_url() . 'uploads/medical/' . $f['att_name'] . '" target="_blank">Medical attachment ' . ($i) . '</a></div>';
                                $i++;
                            }
                        }

                        if (!empty($medical_templates)) {
                            ?>
                            <div class="col-12">
                                <div class="form-group" id="license_attachment">
                                    <label>Existing Medical Report Attachments (Click to open)</label>
                                    <div>
                                        <?php echo $medical_templates; ?>
                                    </div>

                                </div>
                            </div>
                            <?php
                        }
                        ?>

                        <div class="col-12 <?php echo $driver['dp_medical_by_osha'] == 'YES' ? '' : ' hide '; ?>" id="mf_attachment">
                            <div class="form-group" id="medical_file_attachment">
                                <label>Attach a copy of medical report by osha (New Images Will Replace Existing)</label>
                                <div>
                                    <div class="dropzone"  id="uploadmedical">

                                        <?php
                                        if ($medical_attachments) {


                                            foreach ($medical_attachments as $f) {

                                                if ($f['att_status'] == '0') {
                                                    ?>
                                                    <div class="dz-preview dz-file-preview dz-processing dz-success dz-complete"> 
                                                        <div class="dz-image"><img data-dz-thumbnail="" alt="<?php echo $f['att_og_name']; ?>" src="<?php echo base_url(); //echo base_url() . 'uploads/' . $hall['hall_admin_id'] . '/thumb_square_' . $f['temp_att_name']                        ?>assets/images/placeholderfilejpeg.png"></div>

                                                        <div class="dz-details">    
                                                            <div class="dz-size"><span data-dz-size=""><strong><i class="icon-file"></i></strong></span></div>  
                                                            <div class="dz-filename"><span data-dz-name=""><?php echo $f['att_og_name']; ?></span></div>
                                                        </div>  

                                                        <div class="dz-progress">
                                                            <span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span>
                                                        </div>

                                                        <div class="dz-error-message">
                                                            <span data-dz-errormessage=""></span>
                                                        </div>  
                                                        <div class="dz-success-mark">    

                                                        </div>

                                                        <a class="removetempfile" href="<?php echo site_url('utility/removeupload/' . $f['att_id']) ?>/MEDICAL_FITNESS" style="display:block;text-align:center;cursor:pointer;position: absolute;top: -10px;z-index: 100;right: -10px;background: #f1f1f1;padding: 5px 10px;border-radius: 100%;"><i class="fa fa-trash text-danger"></i></a>

                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <br/>
                    <h1 class="h5">Licence Details</h1>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group" id="license">
                                <label>License Number</label>
                                <input autocomplete="off" placeholder="Enter the driver license number"  class="form-control" name="license"  value="<?php echo $driver['dp_license_number']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group" id="license_expiry">
                                <label>License Expiry Date</label>
                                <input autocomplete="off" placeholder="Enter the license expiry date "  class="form-control min_date" name="license_expiry"  value="">
                            </div>
                        </div>

                        <?php
                        $license_templates = "";
                        $i = 1;
                        foreach ($license_attachments as $key => $f) {
                            if ($f['att_status'] == '1') {
                                $license_templates .= '<div><a href="'. base_url().'uploads/license/'.$f['att_name'].'" target="_blank">License attachment ' . ($i) . '</a></div>';
                                $i++;
                            }
                        }

                        if (!empty($license_attachments)) {
                            ?>
                            <div class="col-12">
                                <div class="form-group" id="license_attachment">
                                    <label>Existing Divers License Attachments (Click to open)</label>
                                    <div>
                                        <?php echo $license_templates; ?>
                                    </div>

                                </div>
                            </div>
                            <?php
                        }
                        ?>

                        <div class="col-12">
                            <div class="form-group" id="license_attachment">
                                <label>Attach driver copy of license (New Images Will Replace Existing) </label>
                                <div>
                                    <div class="dropzone"  id="uploadlicense">

                                        <?php
                                        if ($license_attachments) {


                                            foreach ($license_attachments as $f) {

                                                if ($f['att_status'] == '0') {
                                                    ?>
                                                    <div class="dz-preview dz-file-preview dz-processing dz-success dz-complete"> 
                                                        <div class="dz-image"><img data-dz-thumbnail="" alt="<?php echo $f['att_og_name']; ?>" src="<?php echo base_url(); //echo base_url() . 'uploads/' . $hall['hall_admin_id'] . '/thumb_square_' . $f['temp_att_name']                        ?>assets/images/placeholderfilejpeg.png"></div>

                                                        <div class="dz-details">    
                                                            <div class="dz-size"><span data-dz-size=""><strong><i class="icon-file"></i></strong></span></div>  
                                                            <div class="dz-filename"><span data-dz-name=""><?php echo $f['att_og_name']; ?></span></div>
                                                        </div>  

                                                        <div class="dz-progress">
                                                            <span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span>
                                                        </div>

                                                        <div class="dz-error-message">
                                                            <span data-dz-errormessage=""></span>
                                                        </div>  
                                                        <div class="dz-success-mark">    

                                                        </div>

                                                        <a class="removetempfile" href="<?php echo site_url('utility/removeupload/' . $f['att_id']) ?>/DRIVER_LICENSE" style="display:block;text-align:center;cursor:pointer;position: absolute;top: -10px;z-index: 100;right: -10px;background: #f1f1f1;padding: 5px 10px;border-radius: 100%;"><i class="fa fa-trash text-danger"></i></a>

                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save Request</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</section>

<script type="text/javascript">

    Dropzone.autoDiscover = false;

    $(document).ready(function () {

        $('select[name=medical_by_osha]').select2({placeholder: 'Select YES or NO'});
        $('select[name=manager]').select2({placeholder: 'Select your line manager'});

        $('select[name=dept]').select2({placeholder: 'Select driver department'});
        $('select[name=section]').select2({placeholder: 'Select driver section'});

        $('.remove_row').click(function () {
            $(this).parents('.p').remove();
        });

        $('input[name=license_expiry]').data('daterangepicker').setStartDate('<?php echo date('d/m/Y', strtotime($driver['dp_license_expiry'])); ?>');


<?php
if (strtolower($driver['dp_medical_by_osha']) == 'yes') {
    ?>
            $('input[name=medical_fitness_date]').data('daterangepicker').setStartDate('<?php echo date('d/m/Y', strtotime($driver['dp_medical_date'])); ?>');
    <?php
}
?>


        var myDropzone1 = new Dropzone('div#uploadlicense', {url: '<?php echo site_url('api/upload/DRIVER_LICENSE'); ?>',
            parallelUploads: 100,
            maxFiles: 3,
        });

        var myDropzone2 = new Dropzone('div#uploadmedical', {url: '<?php echo site_url('api/upload/MEDICAL_FITNESS'); ?>',
            parallelUploads: 100,
            maxFiles: 3,
        });

        //        Drop zone on error
        myDropzone1.on("error", function (file, message, xhr) {

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
                myDropzone1.removeFile(file);

            });

        });


        myDropzone1.on("success", function (file, message) {

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
                    url: "<?php echo base_url(); ?>index.php/utility/removeupload/" + message.att_id + '/' + message.att_type,
                    success: function (data)
                    {

                    }

                });

                // Referencing file here as closure
                myDropzone1.cancelUpload(file);
                myDropzone1.removeFile(file);

            });

        });


        //        Drop zone on error
        myDropzone2.on("error", function (file, message, xhr) {

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
                myDropzone2.removeFile(file);

            });

        });


        myDropzone2.on("success", function (file, message) {

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
                    url: "<?php echo base_url(); ?>index.php/utility/removeupload/" + message.att_id + '/' + message.att_type,
                    success: function (data)
                    {

                    }

                });

                // Referencing file here as closure
                myDropzon2.cancelUpload(file);
                myDropzon2.removeFile(file);

            });

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
                    if (data.status.error === false) {
                        mother.remove();
                    } else if (data.status.error === true) {

                        if (data.status.error_type == 'pop') {
                            $.alert({
                                title: 'Something went wrong!',
                                content: data.status.error_msg,
                                confirm: function () {
                                    // $.alert('Confirmed!'); // shorthand.
                                }
                            });
                        }
                    }

                }

            });
        });


        $(document).on('change', 'input[type=radio][name=medical_by_osha]', function () {

            if (this.value == 'YES') {
                $('#mf_date').removeClass('hide');
                $('#mf_attachment').removeClass('hide');
            } else if (this.value == 'NO') {
                $('#mf_date').addClass('hide');
                $('#mf_attachment').addClass('hide');
            }

        });


    });



</script>
