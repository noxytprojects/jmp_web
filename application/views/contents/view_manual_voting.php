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
        <div class="row">
            <div class="col-lg-12">
                <div class="btn-group pull-left" role="group" aria-label="Basic example">
                    <a href="<?php echo site_url('voting'); ?>" class="btn btn-info btn-sm"><i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp;Manual Attendees List</a>
                </div>
            </div>
        </div>
        <br/>

        <div class="row">
            <div class="col-lg-12">
                <div class="line-chart-example card has-shadow">

                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4">Attendee Details</h3>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class=" col-sm-6 col-md-6  col-lg-4 col-xs-6">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <p><?php echo $att['att_fullname']; ?></p>
                                    </div>
                                </div>
                                <div class=" col-sm-6 col-md-6  col-lg-4 col-xs-6">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <p><?php echo $att['att_phone_number']; ?></p>
                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <p><?php echo $att['att_address']; ?></p>
                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>CDS Number(s)</label>
                                        <p><?php echo $att['cds_accounts']; ?></p>
                                    </div>
                                </div>

                                <div class="col col-sm-6 col-md-6 col-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Attendee Type</label>
                                        <?php
                                        if ($att['att_attends_as'] == 'SHAREHOLDER') {
                                            ?>
                                            <h4><span class="badge badge-success">SHAREHOLDER</span></h4>
                                            <?php
                                        } elseif ($att['att_attends_as'] == 'REPRESENTATIVE') {
                                            ?>
                                            <h4><span class="badge badge-warning">REPRESENTATIVE</span></h4>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
        <br/>
        <h5 class="h4">Resolution Voting</h5>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <form id="manual_voting_form"  action="<?php echo site_url('voting/submitmanualvoting/' . $att_id); ?>">

                    <?php
                    foreach ($ress as $key => $res) {
                        ?>

                        <div class="row">
                            <div class="col-md-2">
                                <b>Res No <?php echo $res['res_number']; ?>.&nbsp;&nbsp;</b>
                            </div>
                            <div class="col-md-10 ">
                                <?php echo $res['res_sms_en']; ?>
                            </div>
                            <div class="offset-md-2 col-md-10" id="answer_<?php echo $res['res_id']; ?>">
                                <?php
                                if ($res['res_vote_type'] == '1') {
                                    ?>
                                    <div class="row" id="">
                                        <div class="col-12">
                                            <div>
                                                <input  id="optionsRadios<?php echo $res['res_id']; ?>" type="radio" value="YES" name="answer_<?php echo $res['res_id']; ?>">
                                                <label for="optionsRadios<?php echo $res['res_id']; ?>" class="text-bold">&nbsp;&nbsp;FOR</label>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div>
                                                <input id="optionsRadios<?php echo $res['res_id']; ?>_1" type="radio"  value="NO" name="answer_<?php echo $res['res_id']; ?>">
                                                <label for="optionsRadios<?php echo $res['res_id']; ?>_1" class="text-bold">&nbsp;&nbsp;AGAINST</label>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div>
                                                <input id="optionsRadios<?php echo $res['res_id']; ?>_2" type="radio"  value="ABS" name="answer_<?php echo $res['res_id']; ?>">
                                                <label for="optionsRadios<?php echo $res['res_id']; ?>_2" class="text-bold">&nbsp;&nbsp;ABSTAIN</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div>
                                                <input id="optionsRadios<?php echo $res['res_id']; ?>_3" type="radio"  value="N/A" name="answer_<?php echo $res['res_id']; ?>">
                                                <label for="optionsRadios<?php echo $res['res_id']; ?>_3" class="text-bold">&nbsp;&nbsp;SPOILED</label>
                                            </div>
                                        </div>
                                    </div>

                                    <?php echo form_error('answer'); ?>
                                    <?php
                                } elseif ($res['res_vote_type'] == '2') {
                                    ?>
                                    <div class="row" id="">

                                        <?php
                                        foreach ($res_choices as $key => $ch) {
                                            if ($ch['choice_res_id'] == $res['res_id']) {
                                                ?>
                                                <div class="col-12">
                                                    <div>
                                                        <input id="optionsRadios<?php echo $res['res_id'] . '_' . $key; ?>" type="radio" value="<?php echo $ch['choice_letter']; ?>" name="answer_<?php echo $res['res_id']; ?>">
                                                        <label for="optionsRadios<?php
                                                        echo $res['res_id'] . '_' . $key;
                                                        ;
                                                        ?>" class="text-bold">&nbsp;&nbsp;<?php echo $ch['choice_description_en']; ?></label>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <div class="col-12">
                                            <div>
                                                <input id="optionsRadios<?php echo $res['res_id']; ?>_na" type="radio"  value="N/A" name="answer_<?php echo $res['res_id']; ?>">
                                                <label for="optionsRadios<?php echo $res['res_id']; ?>_na" class="text-bold">&nbsp;&nbsp;SPOILED</label>
                                            </div>
                                        </div>

                                        <!--                                        <div class="col-12">
                                                                                    <div>
                                                                                        <input id="optionsRadios_abs" type="radio" value="ABS" name="answer_<?php echo $res['res_id']; ?>">
                                                                                        <label for="optionsRadios_abs" class="text-bold">&nbsp;&nbsp;ABSTAIN</label>
                                                                                    </div>
                                                                                </div>-->

                                    </div>
                                    <?php
                                } elseif ($res['res_vote_type'] == '3') {
                                    ?>
                                    <div class="row" id="">

                                        <?php
                                        foreach ($res_choices as $key => $ch) {
                                            if ($ch['choice_res_id'] == $res['res_id']) {
                                                ?>
                                                <div class="col-12">
                                                    <div>
                                                        <input id="optionsRadios<?php echo $res['res_id'] . '_' . $key; ?>" type="checkbox" value="<?php echo $ch['choice_letter']; ?>" name="answer_<?php echo $res['res_id']; ?>[]">
                                                        <label for="optionsRadios<?php
                                                        echo $res['res_id'] . '_' . $key;
                                                        ?>" class="text-bold">&nbsp;&nbsp;<?php echo $ch['choice_description_en']; ?></label>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
<!--                                        <div class="col-12">
                                            <div>
                                                <input id="optionsRadios<?php echo $res['res_id']; ?>_na" type="radio"  value="N/A" name="answer_<?php echo $res['res_id']; ?>">
                                                <label for="optionsRadios<?php echo $res['res_id']; ?>_na" class="text-bold">&nbsp;&nbsp;SPOILED</label>
                                            </div>
                                        </div>-->

                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <br/>
                        <?php
                    }
                    ?>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Submit</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</section>

<script type="text/javascript">

    $(document).ready(function () {
        $('.po_product').select2({placeholder: 'Select product type'});
        $('.remove_row').click(function () {
            $(this).parents('.p').remove();
        });
    });
</script>
