<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>
<!-- Breadcrumb-->
<?php echo $alert; ?>

<section class="form"> 
    <div class="container-fluid">

        <div class="col-lg-12">
            <div class="card has-shadow">
                <div class="card-header d-flex align-items-center">
                    <h3 class="h4">
                        Resolution No. <?php echo $res['res_number']; ?>&nbsp;&nbsp;
                        <?php
                        switch ($res['res_status']) {
                            case 'NEW':
                                ?><span class="badge badge-info badge-rounded">NEW</span><?php
                                break;

                            case 'PENDING':
                                ?><span class="badge badge-danger badge-rounded">PENDING</span><?php
                                break;

                            case 'RUNNING':
                                ?><span class="badge badge-warning badge-rounded">RUNNING</span><?php
                                break;

                            case 'COMPLETED':
                                ?><span class="badge badge-success badge-rounded">COMPLETED</span><?php
                                break;

                            default:
                                break;
                        }
                        ?>
                    </h3>
                </div>
                <div class="card-body">
                    <br/>
                    <h4 class="h4"><?php echo $res['res_type_description']; ?></h4><br/><br/>
                    <div class="row">

                        <div class="col-md-6">

                            <h4 class="h5">Question (English)</h4>
                            <p>
                                <?php
                                echo $res['res_sms_en'];

                                switch ($res['res_vote_type']) {
                                    case '1':
                                        echo '<br/>A) YES <br/>B) NO <br/>C) ABSTAIN';
                                        break;

                                    case '2';

                                        foreach ($choices as $i => $ch) {

                                            echo '<br/>' . $ch['choice_letter'] . ')&nbsp;' . $ch['choice_description_en'];
                                        }
                                        //echo '<br/>ABSTAIN)&nbsp;' . $ch['choice_description_en'];
                                        echo '';

                                        break;

                                    case '3';

                                        foreach ($choices as $i => $ch) {

                                            echo '<br/>' . $ch['choice_letter'] . ')&nbsp;' . $ch['choice_description_en'];
                                        }
                                        //echo '<br/>ABSTAIN)&nbsp;' . $ch['choice_description_en'];
                                        echo '';

                                        break;
                                }
                                ?>
                            </p>
                        </div>

                        <div class="col-md-6">
                            <h4 class="h5">Question (Swahili)</h4>
                            <p>
                                <?php
                                echo $res['res_sms_sw'];

                                switch ($res['res_vote_type']) {
                                    case '1':

                                        echo '<br/>A) NDIO <br/>B) HAPANA <br/>C) SIJUI';
                                        break;

                                    case '2';
                                        foreach ($choices as $i => $ch) {

                                            echo '<br/>' . $ch['choice_letter'] . ')&nbsp;' . $ch['choice_description_sw'];
                                        }
                                        //echo '<br/>D)&nbsp;SIJUI';
                                        echo '';
                                        break;
                                    case '3';
                                        foreach ($choices as $i => $ch) {

                                            echo '<br/>' . $ch['choice_letter'] . ')&nbsp;' . $ch['choice_description_sw'];
                                        }
                                        //echo '<br/>D)&nbsp;SIJUI';
                                        echo '';
                                        break;
                                }
                                ?>
                            </p>
                        </div>
                    </div>



                    <?php
                    if (($res['res_status'] == 'COMPLETED' OR $res['res_status'] == 'RUNNING') AND $res['res_vote_type'] == '1') {
                        ?>
                        <br/>
                        <h4 class="h4">Voting Results</h4>
                        <table id="results" class="table table-bordered table-responsive-sm">
                            <tr>
                                <th colspan="2">For</th>
                                <th colspan="2">Against</th>
                                <th colspan="2">Abstain</th>
                                <th colspan="2"><?php echo $res['res_status'] == 'COMPLETED' ? 'Invalid' : 'Pending'; ?></th>
                            </tr>
                            <tr>
                                <td id="for_data">
                                    <?php
                                    $for = 0;
                                    foreach ($votes as $v) {
                                        if ($v['vote_answer'] == 'YES') {
                                            $for = $v['shares'];
                                        }
                                    }
                                    echo $for;
                                    ?>
                                </td>
                                <td id="for_percentage_data"><?php echo $shares_registered > 0 ? round((($for / $shares_registered) * 100), 2) . '%' : '0%'; ?></td>
                                <td id="agst_data">
                                    <?php
                                    $agst = 0;
                                    foreach ($votes as $v) {
                                        if ($v['vote_answer'] == 'NO') {
                                            $agst = $v['shares'];
                                        }
                                    }
                                    echo $agst;
                                    ?>
                                </td>
                                <td id="agst_percentage_data"><?php echo $shares_registered > 0 ? round((($agst / $shares_registered) * 100), 2) . '%' : '0%'; ?></td>
                                <td id="abs_yesno_data">
                                    <?php
                                    echo $abs;
                                    ?>
                                </td>
                                <td id="abs_yesno_percent_data"><?php echo $shares_registered > 0 ? round((($abs / $shares_registered) * 100), 2) . '%' : '0%'; ?></td>
                                <td id="pnd_yesno_data">
                                    <?php
                                    echo $pnd;
                                    ?>
                                </td>
                                <td id="pnd_yesno_percent_data"><?php echo $shares_registered > 0 ? round((($pnd / $shares_registered) * 100), 2) . '%' : '0%'; ?></td>
                            </tr>
                        </table>
                        <?php
                    } elseif (($res['res_status'] == 'COMPLETED' OR $res['res_status'] == 'RUNNING') AND ( $res['res_vote_type'] == '2' OR $res['res_vote_type'] == '3')) {
                        ?>
                        <br/>
                        <h4 class="h4">Voting Results</h4><br/>
                        <table id="results" class="table table-bordered table-responsive-sm">
                            <tr>
                                <th>Choice</th>
                                <th>Shares</th>
                                <th>Percentage</th>
                            </tr>

                            <?php
                            $vote_shares = 0;
                            foreach ($choices as $key => $ch) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $ch['choice_description_en']; ?>
                                    </td>
                                    <td id="choice_<?php echo $ch['choice_letter'] ?>_data">
                                        <?php
                                        $vt = 0;
                                        foreach ($votes as $v) {
                                            if ($v['vote_answer'] == $ch['choice_letter']) {
                                                $vote_shares += $v['shares'];
                                                $vt = $v['shares'];
                                            }
                                        }
                                        echo $vt;
                                        ?>
                                    </td>
                                    <td id="choice_<?php echo $ch['choice_letter'] ?>_percent_data">
                                        <?php echo $shares_registered > 0 ? round((($vt / $shares_registered) * 100), 2) . '%' : '&nbsp;&nbsp;0%'; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
    <!--                            <tr>
    <th>Abstain</th>
    <td id="abs_data"><?php echo $abs; ?></td>
    <td id="abs_percent_data"><?php echo $shares_registered > 0 ? round((($abs / $shares_registered) * 100), 2) . '%' : '&nbsp;&nbsp;0%'; ?></td>
    </tr>-->
                            <?php
                            if ($res['res_vote_type'] == '2') {
                                ?>
                                <tr>
                                    <th><?php echo $res['res_status'] == 'COMPLETED' ? 'Invalid' : 'Pending'; ?></th>
                                    <td id="pnd_data"><?php echo $pnd; ?></td>
                                    <td id="pnd_percent_data"><?php echo $shares_registered > 0 ? round((($pnd / $shares_registered) * 100), 2) . '%' : '&nbsp;&nbsp;0%'; ?></td>
                                </tr>
                                <?php
                            }
                            ?>

                        </table>
                        <?php
                    }
                    ?>

                    <br/>

                    <?php
                    if ($vote_att_count) {
                        ?>
                        <h4 class="h4">Voting Channels Attendee Counts </h4>
                        <table id="results" class="table table-bordered table-responsive-sm">
                            <tr>
                                <th>MANUAL</th>
                                <th>SMS</th>
                                <th>WEB</th>
                                <th>TOTAL</th>
                            </tr>

                            <tr>
                                <td><?php echo '<strong id="manual_attendees_votes">' . (int)$vote_att_count['manual_attendees_votes']/$dividend . '</strong>' . ' Of <strong id="manual_attendees">' . (int)$vote_att_count['manual_attendees']/$dividend . '</strong>'; ?></td>
                                <td><?php echo '<strong id="sms_attendees_votes">' . (int)$vote_att_count['sms_attendees_votes']/$dividend . '</strong>' . ' Of <strong id="sms_attendees">' . (int)$vote_att_count['sms_attendees']/$dividend . '</strong>'; ?></td>
                                <td><?php echo '<strong id="web_attendees_votes">' . (int)$vote_att_count['web_attendees_votes']/$dividend . '</strong>' . ' Of <strong id="web_attendees">' . (int)$vote_att_count['web_attendees']/$dividend . '</strong>'; ?></td>
                                <td><?php echo '<strong id="total_attendees_votes">' . ((int) $vote_att_count['manual_attendees_votes'] + (int) $vote_att_count['sms_attendees_votes'] + (int) $vote_att_count['web_attendees_votes'])/$dividend . '</strong>' . ' Of <strong id="total_attendees">' . (int)$vote_att_count['attendees']/$dividend . '</strong>'; ?></td>
                            </tr>

                        </table>
                        <?php
                    }
                    ?>

                    <br/>

                    <a href="<?php echo site_url('resolutions/resolutionlist'); ?>" class="btn btn-secondary btn-sm"><i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp;Back</a>
                    <?php
                    if ($res['res_status'] == 'PENDING') {
                        ?>
                        <a href="<?php echo site_url('resolutions/editresolution/' . $res['res_id']) ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>
                        <a href="<?php echo site_url('resolutions/confirmresolution/' . $res['res_id']); ?>" class="btn btn-success btn-sm"><i class="fa fa-save"></i>&nbsp;&nbsp;Confirm</a>
                        <?php
                    } elseif ($res['res_status'] == 'NEW') {
                        ?>
                        <a href="<?php echo site_url('resolutions/editresolution/' . $res['res_id']) ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i>&nbsp;&nbsp;Edit</a>
                        <a href="<?php echo site_url('resolutions/startvoting/' . $res['res_id']); ?>" class="btn btn-success btn-sm confirm" title="start voting process"><i class="fa fa-play-circle"></i>&nbsp;&nbsp;Start Voting</a>
                        <?php
                    } elseif ($res['res_status'] == 'RUNNING') {
                        ?>
                        <a href="<?php echo site_url('resolutions/stopvoting/' . $res['res_id']); ?>" class="btn btn-danger btn-sm confirm" title="stop voting process"><i class="fa fa-stop-circle-o"></i>&nbsp;&nbsp;Stop Voting</a>
                        <?php
                    } elseif ($res['res_status'] == 'COMPLETED') {
                        ?>
                        <a href="<?php echo site_url('resolutions/votinganswers/' . $res['res_id']); ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i>&nbsp;&nbsp;View Answers</a>
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

        window.setInterval(refreshVotingResults, 3000);

        function refreshVotingResults() {

            $.ajax({
                url: '<?php echo site_url('voting/ajaxvotingresults/' . $res['res_id']); ?>',
                type: 'post',
                success: function (data, status) {

                    if (data.res_type == 1) {
                        $('#for_data').html(data.res_result.for);
                        $('#for_percentage_data').html(data.res_result.for_percent);
                        $('#agst_data').html(data.res_result.agst);
                        $('#agst_percentage_data').html(data.res_result.agst_percent);
                        $('#abs_yesno_data').html(data.res_result.abs);
                        $('#abs_yesno_percent_data').html(data.res_result.abs_percent);
                        $('#pnd_yesno_data').html(data.res_result.pnd);
                        $('#pnd_yesno_percent_data').html(data.res_result.pnd_percent);
                    } else if (data.res_type == 2) {

                        for (var key in data.res_result) {
                            if (data.res_result.hasOwnProperty(key)) {
                                $('#' + key).html(data.res_result[key]);
                            }

                        }

                    }

                    $('#manual_attendees_votes').html(data.vote_att_counts.manual_attendees_votes/data.dividend);
                    $('#manual_attendees').html(data.vote_att_counts.manual_attendees/data.dividend);
                    $('#sms_attendees_votes').html(data.vote_att_counts.sms_attendees_votes/data.dividend);
                    $('#sms_attendees').html(data.vote_att_counts.sms_attendees/data.dividend);
                    $('#web_attendees_votes').html(data.vote_att_counts.web_attendees_votes/data.dividend);
                    $('#web_attendees').html(data.vote_att_counts.web_attendees/data.dividend);
                    $('#total_attendees_votes').html(data.total_attendees_voted/data.dividend);
                    $('#total_attendees').html(data.vote_att_counts.attendees/data.dividend);

                },

                // Holly molly, we may have some errors
                error: function (xhr, desc, err) {
                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);// just log to see whats going on
                },
                complete: function () {
                    //$('.disabled_field').attr('disabled', 'disabled');
                },
                timeout: 5000
            });
        }
    });
</script>
