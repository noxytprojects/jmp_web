<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>

<?php echo $alert; ?>

<section class="tables no-padding-top">   
    <div class="container-fluid" style="min-height:500px;">
        <br/><br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="btn-group pull-left" role="group" aria-label="Basic example">
                    <a href="<?php echo site_url('user/dashboard'); ?>"  class="btn btn-info btn-sm" ><i class="fa fa-dashboard"></i>&nbsp;Dashboard</a>
                </div>
                <div class="btn-group pull-right" role="group" aria-label="Basic example">

                    <?php
                    if (!empty($resolutions) AND $year['year_status'] == 'CLOSED') {
                        ?>
                        
                        <?php
                    }
                    ?>
                    
                    <a href="<?php echo site_url('reports/pdfexportresolutionreport'); ?>" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Export PDF</a>

                </div>
            </div>
        </div>

        <br/>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <?php
                $arr_col_res_types = array_column($resolutions, 'res_res_type_id');

                if (empty($resolutions)) {
                    ?>
                    <p style="text-align: center;padding: 100px 0;border:1px solid #d1d1d1;">No resolution report to show.</p>
                    <?php
                }

                foreach ($res_types as $res_type) {

                    if (in_array($res_type['res_type_id'], $arr_col_res_types)) {
                        ?>
                        <br/>
                        <h1 class="h4"><?php echo $res_type['res_type_description']; ?></h1><br/>
                        <div class="card">
                            <div class="card-body no-padding">
                                <?php
                                foreach ($resolutions as $i => $res) {

                                    if ($res['res_res_type_id'] == $res_type['res_type_id']) {
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
                                                    <table id="results" class="table table-bordered table-sm" style="margin-top: 10px;">
                                                        <tr>
                                                            <th colspan="2">For</th>
                                                            <th colspan="2">Against</th>
                                                            <th colspan="2">Abstain</th>
                                                            <th colspan="2">Invalid</th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                $for = 0;
                                                                foreach ($votes as $v) {
                                                                    if ($v['vote_answer'] == 'YES' AND $v['res_id'] == $res['res_id']) {
                                                                        $for = $v['shares'];
                                                                    }
                                                                }
                                                                echo $for;
                                                                ?>
                                                            </td>
                                                            <td><?php echo $shares_registered > 0 ? round((($for / $shares_registered) * 100), 2) . '%' : '0%'; ?></td>
                                                            <td>
                                                                <?php
                                                                $agst = 0;
                                                                foreach ($votes as $v) {
                                                                    if ($v['vote_answer'] == 'NO' AND $v['res_id'] == $res['res_id']) {
                                                                        $agst = $v['shares'];
                                                                    }
                                                                }
                                                                echo $agst;
                                                                ?>
                                                            </td>
                                                            <td><?php echo $shares_registered > 0 ? round((($agst / $shares_registered) * 100), 2) . '%' : '0%'; ?></td>
                                                            <td>
                                                                <?php
                                                                $abs = 0;
                                                                foreach ($votes as $v) {
                                                                    if ($v['vote_answer'] == 'ABS' AND $v['res_id'] == $res['res_id']) {
                                                                        $abs += $v['shares'];
                                                                    }
                                                                };
                                                                echo $abs;
                                                                ?>
                                                            </td>
                                                            <td><?php echo $shares_registered > 0 ? round((($abs / $shares_registered) * 100), 2) . '%' : '0%'; ?></td>
                                                            <td>
                                                                <?php
                                                                $spl = 0;
                                                                foreach ($votes as $v) {
                                                                    if ($v['vote_answer'] == 'N/A' AND $v['res_id'] == $res['res_id']) {
                                                                        $spl += $v['shares'];
                                                                    }
                                                                };
                                                                echo $spl;
                                                                ?>
                                                            </td>
                                                            <td><?php echo $shares_registered > 0 ? round((($spl / $shares_registered) * 100), 2) . '%' : '0%'; ?></td>
                                                        </tr>
                                                    </table>

                                                    <?php
                                                } elseif ($res['res_vote_type'] == '2' OR $res['res_vote_type'] == '3') {
                                                    ?>
                                                    <table id="results" class="table table-bordered table-sm" style="margin-top: 10px;">
                                                        <tr>
                                                            <th>Choice</th>
                                                            <th>Shares</th>
                                                            <th>Percentage</th>
                                                        </tr>

                                                        <?php
                                                        $vote_shares = 0;
                                                        foreach ($choices as $key => $ch) {
                                                            if ($ch['choice_res_id'] == $res['res_id']) {
                                                                ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php echo $ch['choice_description_en']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                        $vt = 0;
                                                                        foreach ($votes as $v) {
                                                                            if ($v['vote_answer'] == $ch['choice_letter'] AND $v['res_id'] == $res['res_id']) {
                                                                                $vote_shares += $v['shares'];
                                                                                $vt = $v['shares'];
                                                                            }
                                                                        }
                                                                        echo $vt;
                                                                        ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $shares_registered > 0 ? round((($vt / $shares_registered) * 100), 2) . '%' : '&nbsp;&nbsp;0%'; ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }

                                                        if ($res['res_vote_type'] == '2') {
                                                            ?>
                                                            <tr>
                                                                <th>Spolied</th>
                                                                <td>
                                                                    <?php
                                                                    $spl = 0;
                                                                    foreach ($votes as $v) {
                                                                        if ($v['vote_answer'] == 'N/A' AND $v['res_id'] == $res['res_id']) {
                                                                            $spl += $v['shares'];
                                                                        }
                                                                    };
                                                                    echo $spl;
                                                                    ?>
                                                                </td>
                                                                <td><?php echo $shares_registered > 0 ? round((($spl / $shares_registered) * 100), 2) . '%' : '&nbsp;&nbsp;0%'; ?></td>
                                                            </tr> 
                                                            <?php
                                                        }
                                                        ?>

                                                    </table>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <br/>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>

            </div>

        </div>
    </div>


</section>

<script type="text/javascript">

    $(document).ready(function () {

    });


</script>