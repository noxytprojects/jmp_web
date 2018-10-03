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
            <div class="col-12  col-sm-10 offset-md-0 col-md-12 offset-sm-1  col-lg-10 offset-lg-1 form-box">

                <div>
                    <fieldset id="first_fieldset">
                        <div class="form-top text-right" style="overflow:visible;">
                            <!--                            <div class="pull-left ">
                                                            <p style="margin-top: 10px; padding: 20px 0 0;" class="no-padding">Below Are Your Registration Status.</p>
                                                        </div>-->
                            <div class="" style="padding-top: 20px;">
                                <div class="dropdown">
                                    <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-gear"></i> Options</button>
                                    <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                        <?php
                                        if ($can_update) {
                                            ?>
                                            <a href="<?php echo site_url('status/updateapplicantion'); ?>" class="dropdown-item text-info"> <i class="fa fa-user-o"></i>&nbsp;&nbsp;Update Details</a>
                                            <?php
                                        }
                                        ?>

                                        <?php
                                        if (count($msisdns) < 2) {
                                            ?>
                                            <a href="#" class="add_number dropdown-item edit text-success"> <i class=" fa fa-plus-circle"></i>&nbsp;&nbsp;Add Phone Number</a>
                                            <?php
                                        }
                                        ?>


                                        <a href="<?php echo site_url('status/checkotherapplicationstatus'); ?>" class="dropdown-item text-danger"> <i class="fa fa-power-off"></i>&nbsp;&nbsp;Sign Out</a>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-bottom" style="font-size: 14px;">
                            <div class="row">

                                <div class="col col-md-4 col-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <p id="r_fullname" class="dt"><strong><?php echo $applicant['appl_full_name']; ?></strong></p>
                                    </div>
                                </div>

                                <div class="col col-md-4 col-6 col-sm-6">
                                    <div class="form-group">
                                        <label>ID No </label>
                                        <p id="r_id_number" class="dt"><strong><?php echo $applicant['appl_id_number']; ?></strong></p>
                                    </div>
                                </div>

                                <div class="col col-md-4 col-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Education Level</label>
                                        <p id="r_college_name" class="dt"><strong><?php echo $applicant['edu_level_name']; ?></strong></p>
                                    </div>
                                </div>

                                <div class="col col-md-4 col-6 col-sm-6">
                                    <div class="form-group">
                                        <label>College Name</label>
                                        <p id="r_college_name" class="dt"><strong><?php echo $applicant['uni_name']; ?></strong></p>
                                    </div>
                                </div>

                                <div class="col col-md-4 col-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Joining Year</label>
                                        <p id="r_joining_year" class="dt"><strong><?php echo $applicant['appl_joining_yr']; ?></strong></p>
                                    </div>
                                </div>
                                <div class="col col-md-4 col-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Ending Year </label>
                                        <p id="r_ending_year" class="dt"><strong><?php echo $applicant['appl_ending_yr']; ?></strong></p>
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

                            <div id="applicant_msisdn" class="">
                                <?php
                                foreach ($msisdns as $i => $m) {
                                    ?>

                                    <table  class="msisdn table table-striped" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>MSISDN - <?php echo ($i + 1) ?></th>
                                                <th>Offer Type</th>
                                                <th>Status</th>
                                                <th style="width:10px"></th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            <tr>
                                                <td><?php echo $m['msisdn_number']; ?></td>
                                                <td><?php echo $m['offer_type']; ?></td>
                                                <td><h6><span class="badge badge-rounded badge-<?php echo $m['badge_color']; ?> "><?php echo $m['msisdn_status']; ?></span></h6></td>
                                                <td>
                                                    <a class="change btn btn-info btn-sm" href="<?php echo site_url('status/getcurrentmsisdnDetails/' . $m['msisdn_number']); ?>"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <?php
                                    if (count($m['statuses'] > 0)) {
                                        ?>
                                        <strong><br/>Status History</strong><br/>
                                        <?php
                                        foreach ($m['statuses'] as $status) {
                                            ?>
                                            <span class="<?php echo $status['status_text_color']; ?>"><br/><strong><?php echo $status['status_name']; ?></strong> - <i>(<?php echo $status['status_time_statmp']; ?>)</i><br/><?php echo $status['status_notes']; ?><br/></span>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    }
                                    ?>
                                    <br/><br/>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </fieldset>                    
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function () {
        $('.registration-form fieldset:first-child').fadeIn('slow');
        viewer = new Viewer(document.getElementById('attachments'));


        $('.msisdn').DataTable({
            "aaSorting": [],
            responsive: true,
            searching: false,
            lengthChange: false,
            info: false,
            paging: false,
            "pageLength": 20,
            //Set column definition initialisation properties.
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1},
                {responsivePriority: 3, targets: 2},
                {
                    "targets": [0, 1, 2, 3], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ]
        });


        function changeMsisdn(url, post_data) {

            $.blockUI({message: `<div id="loader-wrapper"><div id="loader"></div></div>`});

            $.ajax({
                url: url,
                data: post_data,
                type: 'post',

                success: function (data, status) {

                    $.unblockUI();

                    // Check if response have server error
                    if (data.status.error == true) {
                        // Check type of error, display or pop 
                        if (data.status.error_type == 'pop') {
                            // Pop and error
                            $.alert(data.status.error_msg);
                            
                        }
                    } else {
                        
                        $.confirm({
                            title: 'Accept!',
                            content: 'Phone number submitted successfully. You will be notified when your request is processed!',
                            buttons: {
                                somethingElse: {
                                    text: 'OKAY',
                                    btnClass: 'btn-success',
                                    keys: ['enter', 'shift'],
                                    action: function () {
                                        if (data.status.redirect == true) {
                                            window.location.href = data.status.redirect_url;
                                        }

                                    }
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


                    return false;


                },

                complete: function () {
                    //$('.disabled_field').attr('disabled', 'disabled');
                },
                timeout: 10000
            });

        }


        function addMsisdn(url, post_data) {

            $.blockUI({message: `<div id="loader-wrapper"><div id="loader"></div></div>`});

            $.ajax({
                url: url,
                data: post_data,
                type: 'post',

                success: function (data, status) {

                    $.unblockUI();

                    // Check if response have server error
                    if (data.status.error == true) {
                        // Check type of error, display or pop 
                        if (data.status.error_type == 'pop') {
                            // Pop and error
                            $.alert(data.status.error_msg);

                        }

                        return false;

                    } else {
                        
                        $.confirm({
                            title: 'Accept!',
                            content: 'Phone number added successfully!',
                            buttons: {
                                somethingElse: {
                                    text: 'OKAY',
                                    btnClass: 'btn-success',
                                    keys: ['enter', 'shift'],
                                    action: function () {
                                        if (data.status.redirect == true) {
                                            window.location.href = data.status.redirect_url;
                                        }

                                    }
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


                    return false;


                },

                complete: function () {
                    //$('.disabled_field').attr('disabled', 'disabled');
                },
                timeout: 10000
            });

        }


        $(document).on('click', '.add_number', function (e) {

            e.preventDefault();

            url = "<?php echo site_url('status/addphonenumber'); ?>";

            var content = '' +
                    '<br/><form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label>Phone Number</label>' +
                    '<input  type="text" placeholder="Phoner Number"  class="phone_number form-control" name="phone_number" value="" required/>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Offer Type</label>' +
                    `<select class="" name="offer_type">
                        <option  value="0">-- Select Offer Type --</option>
                                    <option value="1">Data Only</option><option `;
            content += ` value="2">Intergrated</option>
                                    </select>` +
                    '</div>' +
                    '</form>';

            $.confirm({
                title: 'Add Phone Number',
                content: content,
                columnClass: 'col-lg-6 col-sm-8',
                buttons: {
                    cancel: function () {
                        //close
                    },
                    formSubmit: {
                        text: 'Add',
                        btnClass: 'btn-blue',
                        action: function () {
                            var data = this.$content.find('form').serializeArray();
                            addMsisdn(url, data);

                            return false;
                        }
                    },
                },
                onContentReady: function () {
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });

        });


        $(document).on('click', '.change', function (e) {

            e.preventDefault();

            url = $(this).attr('href');

            $.blockUI({message: `<div id="loader-wrapper"><div id="loader"></div></div>`});

            $.ajax({
                url: url,
                data: {},
                type: 'post',

                success: function (data, status) {

                    $.unblockUI();

                    // Check if response have server error
                    if (data.status.error == true) {
                        // Check type of error, display or pop 
                        if (data.status.error_type == 'pop') {
                            // Pop and error
                            $.alert(data.status.error_msg);
                            return false;
                        }
                    } else {
                        var url = '<?php echo site_url('status/changemsisdndetails') ?>/' + data.msisdn.msisdn_number;
                        var content = '' +
                                '<br/><form action="<?php echo site_url('status/changemsisdndetails') ?>/' + data.msisdn.msisdn_number + '" class="formName">' +
                                '<div class="form-group">' +
                                '<label>Phone Number</label>' +
                                '<input  type="text" placeholder="Phoner Number" name="phone_number" class="form-control" value="' + data.msisdn.msisdn_number + '" required/>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label>Offer Type</label>' +
                                `<select name="offer_type">
                                    <option `;
                        content += (data.msisdn.msisdn_offer_type == '1') ? ' selected ' : '';
                        content += ` value="1">Data Only</value>
                                    <option `;
                        content += (data.msisdn.msisdn_offer_type == '2') ? ' selected ' : '';
                        content += ` value="2">Intergrated</value>
                                    </select>` +
                                '</div>' +
                                '</form>';

                        $.confirm({
                            title: 'Change Phone Number',
                            content: content,
                            columnClass: 'col-lg-6 col-sm-8',
                            buttons: {
                                cancel: function () {
                                    //close
                                },
                                formSubmit: {
                                    text: 'Change',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        var data = this.$content.find('form').serializeArray();
                                        changeMsisdn(url, data);
                                        return false;
                                    }
                                },
                            },
                            onContentReady: function () {
                                // bind to events
                                var jc = this;
                                this.$content.find('form').on('submit', function (e) {
                                    // if the user submits the form by pressing enter in the field.
                                    e.preventDefault();
                                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                                });
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


                    return false;


                },

                complete: function () {
                    //$('.disabled_field').attr('disabled', 'disabled');
                },
                timeout: 10000
            });


        });

    });

</script>
