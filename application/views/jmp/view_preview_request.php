<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>

<?php echo $alert; ?>

<?php
if ($can_approve) {
    ?>

    <div id="approveDriverProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <form id="user_form" class="modal-content" action="<?php echo site_url('api/submitapprovedriverprofile'); ?>">
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title">Approve Driver Profile</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-lg-12">
                            <input type="hidden" name="driver_usr_id" value="<?php echo $trip['dp_usr_id']; ?>"/>
                            <input type="hidden" name="tr_id" value="<?php echo $trip['tr_id']; ?>"/>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="full_name">
                                        <label>Driver Full Name</label>
                                        <h1 class="h5"><?php echo $trip['dp_full_name']; ?></h1>
                                    </div>
                                </div>
                                <div class="col-md-6" >
                                    <div class="form-group" id="phone">
                                        <label>Driver Phone Number</label>
                                        <h1 class="h5"><?php echo $trip['dp_phone_number']; ?></h1>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group"  id="email">
                                        <label>Driver Email</label>
                                        <h1 class="h5"><?php echo $trip['dp_email']; ?></h1>
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="user_ad_name">
                                        <label>License Number</label>
                                        <h1 class="h5"><?php echo $trip['dp_license_number']; ?></h1>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group" id="user_ad_name">
                                        <label>License Expiry Date</label>
                                        <h1 class="h5"><?php echo $trip['dp_license_expiry']; ?></h1>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Approve</button>
                </div>
            </form>
        </div>
    </div>
    <div id="approveRequest"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <form id="approve_request_form" class="modal-content" action="<?php echo site_url('approval/submitapproval/' . $trip['tr_id']); ?>">
                <input type="hidden" name="action" value="approve"/>
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title"> Approve Trip Request</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>

                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="comment">
                                <label>Approval Comment (Optional)</label>
                                <textarea placeholder="Enter the approval commnets"  class="form-control" name="comment"></textarea>
                            </div>
                        </div>
                    </div>
<!--                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="comment">
                                <label>Name</label>
                                <input name="" readonly="" class="form-control" value="<?php //echo $contoller; ?>">
                            </div>
                        </div>
                    </div>-->
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i>&nbsp;Approve</button>
                </div>
            </form>
        </div>
    </div>
    <div id="disApproveRequest"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <form id="disapprove_request_form" class="modal-content" action="<?php echo site_url('api/submitdisapproverequest/' . $trip['tr_id']); ?>">
                <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title"> Disapprove Trip Request</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group" id="dis_comment">
                                <label>Disapproval Comment</label>
                                <textarea placeholder="Enter the disapproval commnets"  class="form-control" name="dis_comment"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary pull-left">Close</button>

                    <button type="submit" class="btn btn-danger"><i class="fa fa-check-circle-o"></i>&nbsp;Disapprove</button>
                </div>
            </form>
        </div>
    </div>
    <?php
}
?>


<section class="tables no-padding-top">   
    <div class="container-fluid">
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="pull-right" role="group" aria-label="Basic example">
                    <a href="<?php echo site_url('trip/pdfpreviewtrip/' . $trip['tr_id']) ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="fa fa-file-pdf-o"></i>&nbsp;PDF Preview</a>
                </div>
            </div>
        </div>
        <br/>
        <div class="row">

            <div class="col-lg-12">
                <p>
                    The current approval status of this trip request is  
                    <?php
                    switch ($trip['tr_status']) {
                        case 'NEW':
                            echo '<span class="badge badge-info">NEW</span>';
                            break;
                        case 'PENDING':
                            echo '<span class="badge badge-danger">PENDING</span>';
                            break;
                        
                        case 'INPROGRESS':
                            echo '<span class="badge badge-danger">INPROGRESS</span>';
                            break;
                        case 'COMPLETED':
                            echo '<span class="badge badge-success">COMPLETED</span>';
                            break;
                        case 'PAUSED':
                            echo '<span class="badge badge-secondary">PAUSED</span>';
                            break;

                        case 'DISAPPROVED':
                            echo '<span class="badge badge-danger">DISAPPROVED</span>';
                            break;

                        case 'APPROVED':
                            echo '<span class="badge badge-success">APPROVED</span>';
                            break;
                        default:
                            break;
                    }
                    ?>
                </p>
                <h5>Trip Details</h5>
                <table class="table table-bordered table-sm" style="font-size: 13px;width: 100%">
                    <thead>
                        <tr style="background:#f1f1f1;">
                            <th colspan="4">Driver Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td >Driver Name</td>
                            <td style="min-width:150px;"><strong><?php echo $trip['dp_full_name']; ?></strong></td>
                            <td>Company/Division/Department</td>
                            <td style="min-width:150px;"><strong><?php echo $trip['dept_name'] . ' - ' . $trip['sec_name']; ?></strong></td>
                        </tr>
                        <tr>
                            <td >Contacts</td>
                            <td style="min-width:150px;"><strong><?php echo $trip['dp_phone_number']; ?><br/><?php echo $trip['dp_email']; ?></strong></td>
                            <td>Line Manager Name And <br/>Contact No</td>
                            <td style="min-width:150px;"><strong><?php echo $trip['usr_fullname']; ?><br/><?php echo $trip['usr_phone']; ?><br/><?php echo $trip['usr_email']; ?></strong></td>
                        </tr>
                        <tr>
                            <td>Driving License Number</td>
                            <td style="min-width:150px;"><strong><?php echo $trip['dp_license_number']; ?></strong></td>
                            <td>License Expiry Date</td>
                            <td style="min-width:150px;"><strong><?php echo cus_nice_date($trip['dp_license_expiry']); ?></strong></td>
                        </tr>

                    </tbody>
                </table>

                <table class="table table-bordered table-sm" style="font-size: 13px;width: 100%">
                    <thead>
                        <tr style="background:#f1f1f1;">
                            <th colspan="4">Journey Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td >Purpose Of The Journey</td>
                            <td colspan="3"><strong><?php echo $trip['dept_name'] . ' - ' . $trip['sec_name']; ?></strong></td>
                        </tr>
                        <tr>
                            <td >Vehicle Reg No.</td>
                            <td style="min-width:150px;"><strong><?php echo $trip['tr_vehicle_reg_no']; ?></strong></td>
                            <td>Traveling Distance (Total distance covered-One way OR To & From)</td>
                            <td style="min-width:20px;"><strong><?php echo $trip['tr_distance']; ?>&nbsp;KM</strong></td>
                        </tr>
                        <tr>
                            <td colspan="3">Driver medical fitness assessment done by OSHA?</td>
                            <td style="min-width:20px;"><strong><?php echo $trip['tr_medical_by_osha']; ?></strong></td>
                        </tr>

                        <tr>
                            <td colspan="3">Will the work finish at or after 17h00 and the remote site is over 300km from their normal place of duty or home (Other external factors e.g. Traffic jam to be communicated to the line manager whenever required to do so)</td>
                            <td style="min-width:20px;"><strong><?php echo $trip['tr_work_finish_time']; ?></strong></td>
                        </tr>
                        <?php
                        if (strtolower($trip['tr_work_finish_time']) == 'yes') {
                            ?>
                            <tr>
                                <td >Reason</td>
                                <td colspan="3"><strong><?php echo $trip['tr_reason_finish_after_17']; ?></strong></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>

                <table class="table table-bordered table-sm" style="font-size: 13px;width: 100%">
                    <thead>
                        <tr style="background:#f1f1f1;">
                            <th colspan="4">Type Of Vehicle And Training</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td >Vehicle Type</td>
                            <td style="min-width:150px;"><strong><?php echo $trip['tr_vehicle_type']; ?></strong></td>
                            <td>Attended diffensive driver traing</td>
                            <td style="min-width:50px;"><strong><?php echo $trip['tr_difense_driver_training']; ?></strong></td>
                        </tr>
                        <tr>
                            <td colspan="3">Attended 4X4 Off Driving Training</td>
                            <td ><strong><?php echo $trip['tr_for_by_for_training']; ?></strong></td>
                        </tr>

                    </tbody>
                </table>

                <table class="table table-bordered table-sm" style="font-size: 13px;width: 100%">
                    <thead>
                        <tr style="background:#f1f1f1;">
                            <th colspan="4">Vehicle And Driver Fitness</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td >Vehicle fit for intended use? (If NO- Line manager to confirm and seek safe option from Fleet department)</td>
                            <td style="min-width:40px;"><strong><?php echo $trip['tr_fit_for_use']; ?></strong></td>
                            <td>In possession of a suitable driver’s license of vehicle being used (i.e. Professional driver permit) (YES/NO)</td>
                            <td style="min-width:40px;"><strong><?php echo $trip['tr_suitable_license']; ?></strong></td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-bordered table-sm" style="font-size: 13px;width: 100%">
                    <thead>
                        <tr style="background:#f1f1f1;">
                            <th colspan="4">Departure Journey Plan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td >Departure Time</td>
                            <td style="min-width:150px;"><strong><?php echo cus_nice_timestamp($trip['tr_dispatch_time']); ?></strong></td>
                            <td>Arrival Time</td>
                            <td style="min-width:150px;"><strong><?php echo cus_nice_timestamp($trip['tr_arraival_time']); ?></strong></td>
                        </tr>
                        <tr>
                            <td >Departure Location</td>
                            <td style="min-width:150px;"><strong><?php echo $trip['tr_departure_location']; ?></strong></td>
                            <td>Final Destination Location</td>
                            <td style="min-width:150px;"><strong><?php echo $trip['tr_destination_location']; ?></strong></td>
                        </tr>
                        <tr>
                            <td>Journey Stop Locations And <br/>Reason For Stoping</td>
                            <td colspan="3"><strong><?php echo $trip['tr_stop_locations']; ?></strong></td>
                        </tr>

                    </tbody>
                </table>

            </div>

            <div class="col-lg-12">
                <h5>Attachments</h5>
                <?php
                $i = 1;
                foreach ($attachments as $key => $f) {
                    echo '<div><a href="' . base_url() . 'uploads/request/' . $f['att_name'] . '" target="_blank" title="Click to open file.">Request attachment ' . ($i) . '</a></div>';
                    $i++;
                }
                ?>
                <?php
                if (!empty($pending_approval) AND in_array(strtolower($trip['tr_status']), ['inprogress', 'new'])) {
                    ?>
                    <br/>
                    <h4 class="h5">Pending Approval Officials</h4>
                    <table class="table table-bordered table-responsive-sm" style="font-size: 13px;width: 100%">
                        <thead>
                            <tr>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                            </tr>
                            <tr>
                                <th colspan="3">Title</th>
                                <th colspan="3">Name</th>
                                <th colspan="3">Phone</th>
                                <th colspan="3">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($pending_approval as $pa) {
                                ?>
                                <tr>
                                    <td colspan="3"><?php echo $pa['r_usr_title']; ?></td>
                                    <td colspan="3"><?php echo $pa['fullname']; ?></td>
                                    <td colspan="3"><?php echo $pa['phone']; ?></td>
                                    <td colspan="3"><?php echo $pa['email']; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>

                            </tr>
                        </tbody>
                    </table>
                    <?php
                }
                
                if (!empty($approvers_approved)) {
                    ?>
                    <br/>
                    <h4 class="h5">Trip Request Approval</h4>
                    <table class="table table-bordered permit_details table-responsive-sm" style="font-size: 13px;width: 100%">
                        <thead>
                            <tr>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                                <td style="border: none;width: 8.5%;padding: 0"></td>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($approvers_approved as $ap) {

                               
                                ?>
                                <tr>
                                    <th colspan="3"><?php echo $ap['auth_usr_title']; ?></th>
                                    <th colspan="3"><?php echo $ap['fullname']; ?></th>
                                    <th colspan="3"><?php echo $ap['phone']; ?></th>
                                    <th colspan="3"><?php echo cus_nice_timestamp($ap['auth_approved_date']); ?></th>
                                </tr>
                                <tr>
                                    <td colspan="3" style="border-right: none; vertical-align: top">
                                        Comments:
                                    </td>
                                    <td colspan="9" style="border-left: none">
                                        <?php echo nl2br($ap['auth_comment']); ?>

                                    </td>
                                </tr>
                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
                    <?php
                }
                ?>
                <br/>
            </div>



            <div class="col-lg-12">
                <table class="table table-bordered table-sm" style="font-size: 13px;width: 100%">
                    <thead>
                        <tr style="background:#f1f1f1;">
                            <th colspan="4">Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?php
                                if (empty($trip['ap_comments'])) {
                                    ?>
                                    <br/>
                                    <p class="text-center">Currently there is no comment added</p>
                                    <?php
                                } else {
                                    echo '<p style="padding:10px 0 0 10px;">' . nl2br($trip['ap_comments']) . '</p>';
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>



            <div class="col-lg-12">
                <div class="modal-footer">
                    <?php
// Check if he can edit
                    if ($is_my_application AND in_array(strtolower($trip['tr_status']), ['paused'])) {
                        ?>
                        <a  href="<?php echo site_url('trip/edittriprequest/' . $trip['tr_id']); ?>" class="btn btn-sm btn-outline-info pull-left"><i class="fa fa-edit"></i>&nbsp;Edit Request</a>
                        <?php
                    }

                    // Check if he can request approval
                    if ($is_my_application AND in_array(strtolower($trip['tr_status']), [ 'paused'])) {
                        ?>
                        <a href="<?php echo site_url('trip/requestapproval/' . $trip['tr_id']); ?>" class="btn btn-sm btn-outline-success confirm" title="Are you sure you want to request approval for this trip?."><i class="fa fa-send"></i>&nbsp;Request Approval</a>
                        <?php
                    }

                    // Check if he can edit
                    if ($can_approve AND in_array(strtolower($trip['tr_status']), ['inprogress'])) {
                        ?>
                        <a href="" data-toggle="modal" data-target="#disApproveRequest" class="btn btn-sm btn-outline-danger"><i class="fa fa-close"></i>&nbsp;Disapprove</a>
                        <?php
                        if (strtolower($trip['dp_status']) == 'pending') {
                            ?>
                            <a href="" data-toggle="modal" data-target="#approveDriverProfile" class="btn btn-sm btn-outline-info"><i class="fa fa-user-circle"></i>&nbsp;Approve Driver Profile</a>
                            <?php
                        }
                        ?>
                        <a href="" data-toggle="modal" data-target="#approveRequest" class="btn btn-sm btn-outline-success"><i class="fa fa-check-circle-o"></i>&nbsp;Approve</a>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function () {
        $('select[name=medical_by_osha]').select2({placeholder: 'Select YES or NO'});
        $('.remove_row').click(function () {
            $(this).parents('.p').remove();
        });

    });
</script>
