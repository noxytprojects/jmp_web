<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>
<section class="tables no-padding-top">   
    <div class="container-fluid" style="min-height:500px;">
        <br/><br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="btn-group pull-left" role="group" aria-label="Basic example">
                    <a href="<?php echo site_url('user/dashboard'); ?>"  class="btn btn-info btn-sm" ><i class="fa fa-dashboard"></i>&nbsp;Dashboard</a>
                </div>
                <div class="btn-group pull-right" role="group" aria-label="Basic example">
                    <!--<a href="<?php echo site_url('shareholder/cdsuploads') ?>" class="btn btn-info btn-sm"><i class="fa fa-list-ul"></i>&nbsp;Uploaded Files</a>-->
                </div>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-2">
                <b>Res No <?php echo $res['res_number']; ?>.&nbsp;&nbsp;</b>
            </div>
            <div class="col-md-10 ">
                <?php echo $res['res_sms_en']; ?>
            </div>

        </div>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <table id="cds_acc_table" class="table table-striped" style="width: 100%;font-size: 12px;">
                            <thead>
                                <tr>
                                    <th>Attendee Name</th>
                                    <th>CDS Number(s)</th>
                                    <th>Shares</th>
                                    <th>Channel</th>
                                    <th>Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($answers as $i => $ans) {
                                    ?>
                                    <tr>

                                        <td><?php echo $ans['att_fullname']; ?></td>
                                        <td><?php echo $ans['cds_accounts']; ?></td>
                                        <td><?php echo $ans['shares'] ?></td>
                                        <td><?php echo $ans['vote_channel'] ?></td>
                                        <td>
                                            <?php
                                            if ($ans['res_vote_type'] == '2' OR $ans['res_vote_type'] == '3') {
                                                if (!empty($ans['choice_description_en'])) {
                                                    echo $ans['choice_description_en'];
                                                }
                                            } else {

                                                switch ($ans['vote_answer']) {
                                                    case 'YES':
                                                        echo '<h4><span class="badge badge-success">FOR</span></h4>';
                                                        break;
                                                    case 'NO':
                                                        echo '<h4><span class="badge badge-danger">AGAINST</span></h4>';
                                                        break;
                                                    case 'ABS':
                                                        echo '<h4><span class="badge badge-secondary">ABSTAIN</span></h4>';
                                                        break;
                                                    case 'N/A':
                                                        echo '<h4><span class="badge badge-warning">INVALID</span></h4>';
                                                        break;
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


</section>

<script type="text/javascript">

    $(document).ready(function () {

        $('#cds_acc_table').DataTable({
            aaSorting: [],
            responsive: true,
            fixedHeader: {headerOffset: 70},
            searching: true,
            lengthChange: true,
            "pageLength": 25,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 1, targets: 1},
                {responsivePriority: 2, targets: -1}
            ]
        });

    });

</script>