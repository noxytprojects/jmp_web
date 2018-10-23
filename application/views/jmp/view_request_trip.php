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
                <form id="request_trip_form" style="font-size: 14px;"  action="<?php echo site_url('api/submitrequesttrip'); ?>">
                    <h1 class="h5">Journey Details</h1>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" id="journey_purpose">
                                <label>Journey Purpose</label>
                                <textarea placeholder="Enter the purpose of the journey" class="form-control" name="journey_purpose"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6 col-sm-6">
                            <div class="form-group" id="vehicle_reg_number">
                                <label>Vehicle Reg No</label>
                                <input autocomplete="off" placeholder="Enter the vehicle registration number"  class="form-control" name="vehicle_reg_number"  value="">
                            </div>
                        </div>



                        <div class="col-md-6 col-sm-6">
                            <div class="form-group" id="distance">
                                <label>Estimated Travelling Distance</label>
                                <input autocomplete="off"  placeholder="Enter the estimated travelling distance"  class="form-control amount" name="distance"  value="">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group" id="work_finish_time">
                                <label>Will the work finish at or after 17h00 and the remote site is over 300km from their normal place of duty
                                    or home (Other external
                                    factors e.g. Traffic jam to be communicated to the line manager whenever required to do so)</label>
                                <div class="i-checks">
                                    <input id="finishyes" type="radio" value="YES" name="work_finish_time" class="radio-template">
                                    <label for="finishyes">YES</label>
                                </div>
                                <div class="i-checks">
                                    <input id="finishno" type="radio" value="NO" name="work_finish_time" class="radio-template">
                                    <label for="finishno">NO</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 hide" id="reason">
                            <div class="form-group" id="reason_finish_after_17">
                                <label>Reasons if work will finish at or After 17hr00</label>
                                <textarea placeholder="Enter the reason if work will finish at or After 17hr00" class="form-control" name="reason_finish_after_17"></textarea>
                            </div>
                        </div>

                        <!--
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group" id="medical_by_osha">
                                <label>Driver Medical Fitness Done By OSHA</label>
                                <div class="i-checks">
                                    <input id="oshayes" type="radio" value="YES" name="medical_by_osha" class="radio-template">
                                    <label for="oshayes">YES</label>
                                </div>
                                <div class="i-checks">
                                    <input id="oshano" type="radio" value="NO" name="medical_by_osha" class="radio-template">
                                    <label for="oshano">NO</label>
                                </div>
                            </div>
                        </div>
                        -->

                    </div>
                    <br/>
                    <h1 class="h5">Vehicle Type And Training</h1>
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group" id="vehicle_type">
                                <label>Vehicle Type</label>
                                <div class="i-checks">
                                    <input id="rav4" type="radio" value="RAV 4" name="vehicle_type" class="radio-template">
                                    <label for="rav4">RAV 4</label>
                                </div>
                                <div class="i-checks">
                                    <input id="fortuner" type="radio" value="FORTUNER" name="vehicle_type" class="radio-template">
                                    <label for="fortuner">FORTUNER</label>
                                </div>
                                <div class="i-checks">
                                    <input id="hilux" type="radio" value="HILUX PICKUP" name="vehicle_type" class="radio-template">
                                    <label for="hilux">HILUX PICKUP</label>
                                </div>
                                <div class="i-checks">
                                    <input id="prado" type="radio" value="PRADO" name="vehicle_type" class="radio-template">
                                    <label for="prado">PRADO</label>
                                </div>
                                <div class="i-checks">
                                    <input id="ford" type="radio" value="FORD" name="vehicle_type" class="radio-template">
                                    <label for="ford">FORD</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group" id="difense_driver_training">
                                <label>Attended Defense Driver Training</label>
                                <div class="i-checks">
                                    <input id="difenseyes" type="radio" value="YES" name="difense_driver_training" class="radio-template">
                                    <label for="difenseyes">YES</label>
                                </div>
                                <div class="i-checks">
                                    <input id="difenseno" type="radio" value="NO" name="difense_driver_training" class="radio-template">
                                    <label for="difenseno">NO</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group" id="for_by_for_training">
                                <label>Attende 4X4 Off Road Driving Training</label>
                                <div class="i-checks">
                                    <input id="fouryes" type="radio" value="YES" name="for_by_for_training" class="radio-template">
                                    <label for="fouryes">YES</label>
                                </div>
                                <div class="i-checks">
                                    <input id="fourno" type="radio" value="NO" name="for_by_for_training" class="radio-template">
                                    <label for="fourno">NO</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <br/>

                    <h1 class="h5">Vehicle  And Driver Fitness</h1>
                    <div class="row">

                        <div class="col-md-6 col-sm-12">
                            <div class="form-group" id="fit_for_use">
                                <label>Vehicle fit for intended use? (If NO- Line manager to confirm and seek safe option from Fleet department)</label>
                                <div class="i-checks">
                                    <input id="fityes" type="radio" value="YES" name="fit_for_use" class="radio-template">
                                    <label for="fityes">YES</label>
                                </div>
                                <div class="i-checks">
                                    <input id="fitno" type="radio" value="NO" name="fit_for_use" class="radio-template">
                                    <label for="fitno">NO</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group" id="suitable_license">
                                <label>In possession of a suitable driver’s license of vehicle being
                                    used (i.e. Professional driver permit)</label>
                                <div class="i-checks">
                                    <input id="licenseyes" type="radio" value="YES" name="suitable_license" class="radio-template">
                                    <label for="licenseyes">YES</label>
                                </div>
                                <div class="i-checks">
                                    <input id="licenseno" type="radio" value="NO" name="suitable_license" class="radio-template">
                                    <label for="licenseno">NO</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <br/>
                    <h1 class="h5">Departure Journey Plan</h1>

                    <div class="row">

                        <div class="col-md-4 col-sm-6">
                            <div class="form-group" id="dispatch_time">
                                <label>Departure Time</label>
                                <input autocomplete="off" placeholder="Enter the departure time"  class="form-control min_time" name="dispatch_time"  value="">
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="form-group" id="arraival_time">
                                <label>Arrival Time</label>
                                <input autocomplete="off" placeholder="Enter the arrival time"  class="form-control min_time" name="arraival_time"  value="">
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="form-group" id="departure_location">
                                <label>Departure Location</label>
                                <input autocomplete="off" placeholder="Enter the departure location"  class="form-control" name="departure_location"  value="">
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="form-group" id="destination_location">
                                <label>Final Destination Location</label>
                                <input autocomplete="off" placeholder="Enter the destination location"  class="form-control" name="destination_location"  value="">
                            </div>
                        </div>

                    </div>

                    <br/>
                    <h1 class="h5">Journey stop location & reason for stopping (For long trips only)</h1>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" id="stop_locations">
                                <textarea placeholder="Enter the journey stop locations and reasons" class="form-control" name="stop_locations"></textarea>
                            </div>
                        </div>
                    </div>

                    <br/>
                    <h1 class="h5">Attachments</h1>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group" id="file">
                                <label>Attach Vehicle Prestart Check List Form </label>
                                <div>
                                    <div class="dropzone"  id="uploadfile">
                                        <?php
                                        if ($attachments) {


                                            foreach ($attachments as $f) {

                                                if ($f['att_status'] == '0') {
                                                    ?>
                                                    <div class="dz-preview dz-file-preview dz-processing dz-success dz-complete"> 
                                                        <div class="dz-image"><img data-dz-thumbnail="" alt="<?php echo $f['att_name']; ?>" src="<?php echo base_url(); //echo base_url() . 'uploads/' . $hall['hall_admin_id'] . '/thumb_square_' . $f['temp_att_name']                         ?>assets/images/placeholderfilejpeg.png"></div>

                                                        <div class="dz-details">    
                                                            <div class="dz-size"><span data-dz-size=""><strong><i class="icon-file"></i></strong></span></div>  
                                                            <div class="dz-filename"><span data-dz-name=""><?php echo $f['att_name']; ?></span></div>
                                                        </div>  

                                                        <div class="dz-progress">
                                                            <span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span>
                                                        </div>

                                                        <div class="dz-error-message">
                                                            <span data-dz-errormessage=""></span>
                                                        </div>  
                                                        <div class="dz-success-mark">    

                                                        </div>

                                                        <a class="removetempfile" href="<?php echo site_url('utility/removeupload/' . $f['att_id']) ?>/TRIP_REQUEST" style="display:block;text-align:center;cursor:pointer;position: absolute;top: -10px;z-index: 100;right: -10px;background: #f1f1f1;padding: 5px 10px;border-radius: 100%;"><i class="fa fa-trash text-danger"></i></a>

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
        $('.remove_row').click(function () {
            $(this).parents('.p').remove();
        });


        var myDropzone = new Dropzone('div#uploadfile', {url: '<?php echo site_url('api/upload/TRIP_REQUEST'); ?>',
            parallelUploads: 100,
            maxFiles: 3,
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
                    url: "<?php echo base_url(); ?>index.php/utility/removeupload/" + message.att_id + '/' + message.att_type,
                    success: function (data)
                    {

                    }

                });

                // Referencing file here as closure
                myDropzone.cancelUpload(file);
                myDropzone.removeFile(file);

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
                    mother.remove();
                }

            });
        });


        $(document).on('change', 'input[type=radio][name=work_finish_time]', function () {

            if (this.value == 'YES') {
                $('#reason').removeClass('hide');
            } else if (this.value == 'NO') {
                $('#reason').addClass('hide');
            }

        });


    });



</script>
