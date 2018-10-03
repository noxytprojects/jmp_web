<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>
<!-- Breadcrumb-->

<?php echo $alert; ?>

<section class="tables no-padding-top">   
    <div class="container-fluid">
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="line-chart-example card has-shadow">

                    <?php
                    if ($res) {
                        ?>
                        <div class="card-header d-flex align-items-center">
                            <h3 class="h4"><?php echo $lang == 'SW' ? "Azimio Namba " . $res['res_number'] : "Resolution No. " . $res['res_number']; ?></h3>
                        </div>
                        <div class="card-body">
                            <form method="post" action="<?php echo site_url('catalogue/submitvote/' . $res['res_id']); ?>">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group" id="vote_form">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">

                                            <p><?php echo $lang == 'SW' ? $res['res_sms_sw'] : $res['res_sms_en']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <br/>

                                <?php
                                if ($res['res_vote_type'] == '1') {
                                    ?>
                                    <div class="row">
                                        <div class="col col-12">
                                            <div>
                                                <input  id="optionsRadios1" type="radio" value="YES" name="answer">
                                                <label for="optionsRadios1" class="text-bold">&nbsp;&nbsp;<?php echo $lang == 'SW' ? 'NDIO' : 'FOR'; ?></label>
                                            </div>
                                        </div>

                                        <div class="col col-12">
                                            <div>
                                                <input id="optionsRadios2" type="radio"  value="NO" name="answer">
                                                <label for="optionsRadios2" class="text-bold">&nbsp;&nbsp;<?php echo $lang == 'SW' ? 'HAPANA' : 'AGAINST'; ?></label>
                                            </div>
                                        </div>

                                        <div class="col col-12">
                                            <div>
                                                <input id="optionsRadios3" type="radio"  value="ABS" name="answer">
                                                <label for="optionsRadios3" class="text-bold">&nbsp;&nbsp;<?php echo $lang == 'SW' ? 'SIJUI' : 'ABSTAIN'; ?></label>
                                            </div>
                                        </div>

                                        <br/>

                                    </div>

                                    <?php echo form_error('answer'); ?>
                                    <br/>
                                    <?php
                                } elseif ($res['res_vote_type'] == '2') {
                                    ?>
                                    <div class="row">

                                        <?php
                                        foreach ($choices as $key => $ch) {
                                            ?>
                                            <div class="col col-12">
                                                <div>
                                                    <input id="optionsRadios<?php echo $key; ?>" <?php echo set_value('answer') == $ch['choice_letter'] ? 'checked' : ''; ?> type="radio" value="<?php echo $ch['choice_letter']; ?>" name="answer">
                                                    <label for="optionsRadios<?php echo $key; ?>" class="text-bold">&nbsp;&nbsp;<?php echo $lang == 'SW' ? $ch['choice_description_sw'] : $ch['choice_description_en']; ?></label>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <br/>

                                    </div>
                                    <?php echo form_error('answer'); ?>
                                    <br/>
                                    <?php
                                } elseif ($res['res_vote_type'] == '3') {
                                    ?>
                                    <div class="row">

                                        <?php
                                        $selection = !empty(set_value('answer')) ? set_value('answer') : [];

                                        foreach ($choices as $key => $ch) {
                                            ?>
                                            <div class="col col-12">
                                                <div>
                                                    <input id="optionsRadios<?php echo $key; ?>" <?php echo in_array($ch['choice_letter'], $selection) ? 'checked' : ''; ?> type="checkbox" value="<?php echo $ch['choice_letter']; ?>" name="answer[]">
                                                    <label for="optionsRadios<?php echo $key; ?>" class="text-bold">&nbsp;&nbsp;<?php echo $lang == 'SW' ? $ch['choice_description_sw'] : $ch['choice_description_en']; ?></label>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <br/>

                                    </div>
                                    <?php echo form_error('answer[]'); ?>
                                    <br/>
                                    <?php
                                }
                                ?>

                                <p>
                                    <?php
                                    if ($lang == 'SW') {
                                        ?>
                                        <b>Kumbuka:</b>&nbsp;Endapo hautapiga kura, itahesabika kua imeharibika. 
                                        <?php
                                    } else {
                                        ?>
                                        <b>NB:</b>&nbsp;If you dont vote for this resolution your vote will be counted as spoiled 
                                        <?php
                                    }
                                    ?>
                                </p>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success" name="vote"><?php echo $lang == 'SW' ? 'KUSANYA KURA' : 'SUBMIT VOTE'; ?></button>
                                    </div>

                                </div>

                            </form>
                        </div>
                        <?php
                    } else {
                        ?>
                        <p style="padding: 80px 50px; text-align: center;">

                            <?php
                            if ($lang == 'SW') {
                                ?>
                                Kwa sasa hakuna azimio la kupiga kura.<br/><br/><a class="btn btn-sm btn-info" href="<?php echo site_url('catalogue/vote'); ?>"><i class="fa fa-refresh"></i>&nbsp;Angalia Tena</a>
                                <?php
                            } else {
                                ?>
                                Currently there is no resolution to vote for.<br/><br/><a class="btn btn-sm btn-info" href="<?php echo site_url('catalogue/vote'); ?>"><i class="fa fa-refresh"></i>&nbsp;Refresh</a>
                                <?php
                            }
                            ?>

                        </p>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>

    </div>
</section>