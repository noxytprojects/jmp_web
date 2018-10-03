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
                    <a href="<?php echo site_url('resolutions/captureresolution'); ?>" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i>&nbsp;Capture Resolution</a>
                </div>
            </div>
        </div>

        <br/>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <?php
                
                if(empty($resolutions)){
                    ?>
                <p style="text-align: center;padding: 100px 0;border:1px solid #d1d1d1;">Currently there is no resolution added yet.</p>
                    <?php
                }
                $arr_col_res_types = array_column($resolutions, 'res_res_type_id');

                foreach ($res_types as $res_type) {

                    if (in_array($res_type['res_type_id'], $arr_col_res_types)) {
                        ?>
                        <br/>
                        <h1 class="h4"><?php echo $res_type['res_type_description']; ?></h1><br/>
                        <div class="card">
                            <div class="card-body no-padding">
                                <table  class="table table-striped res_table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Question (English)</th>
                                            <th>Question (Swahili)</th>
                                            <th>Voting Status</th>
                                            <th style="width:10px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($resolutions as $i => $res) {



                                            if ($res['res_res_type_id'] == $res_type['res_type_id']) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $res['res_number'] ?></td>
                                                    <td><?php echo $res['res_sms_en']; ?></td>
                                                    <td><?php echo $res['res_sms_sw']; ?></td>
                                                    <td>
                                                        <?php
                                                        switch ($res['res_status']) {
                                                            case 'NEW':
                                                                ?><h4><span class="badge badge-info badge-rounded">NEW</span></h4><?php
                                                                break;

                                                            case 'PENDING':
                                                                ?><h4><span class="badge badge-danger badge-rounded">PENDING</span></h4><?php
                                                                break;

                                                            case 'RUNNING':
                                                                ?><h4><span class="badge badge-warning badge-rounded">RUNNING</span></h4><?php
                                                                break;

                                                            case 'COMPLETED':
                                                                ?><h4><span class="badge badge-success badge-rounded">COMPLETED</span></h4><?php
                                                                break;

                                                            default:
                                                                break;
                                                        }
                                                        ?>

                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                            <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                                <a href="<?php echo site_url('resolutions/previewresolution/' . $res['res_id']); ?>" class="dropdown-item text-info"> <i class="fa fa-eye"></i>&nbsp;&nbsp;Preview</a>

                                                                <?php
                                                                if ($res['res_status'] == 'PENDING') {
                                                                    ?>
                                                                    <a href="#<?php //echo site_url('usert/deluser/' . $user['usr_id']);   ?>" class="dropdown-item del_user text-danger"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete</a>
                                                                    <?php
                                                                }
                                                                ?>

                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>

                                            <?php
                                        }
                                        ?>

                                    </tbody>
                                </table>
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

        $('.res_table').DataTable({
            aaSorting: [],
            responsive: true,
            fixedHeader: {headerOffset: 70},
            searching: false,
            lengthChange: false,
            paging: false,
            info: false,
            "pageLength": 100,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 1, targets: 1},
                {responsivePriority: 2, targets: -1}
            ]
        });

    });


</script>