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
                <div class="pull-right">
                    <a href="<?php echo site_url('reports/excelusers');?>" class="btn btn-secondary btn-sm" target="_blank"><i class="fa fa-file-excel-o"></i>&nbsp;User Review Excel</a>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addUser"><i class="fa fa-plus-square"></i>&nbsp;Add User</button>
                </div>
            </div>
        </div>

        <br/>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <table id="users_table" class="table table-striped" style="width: 100%; font-size: 13px;">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>User Phone</th>
                                    <th>User Role</th>
                                    <th>User AD Name</th>
                                    <th>Status</th>
                                    <th>2FA</th>
                                    <th style="width:10px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($users as $i => $user) {
                                    ?>
                                    <tr>
                                        <td><?php echo $user['usr_fullname']; ?></td>
                                        <td><?php echo $user['usr_email']; ?></td>
                                        <td><?php echo $user['usr_phone']; ?></td>
                                        <td><?php echo $user['usr_role']; ?></td>
                                        <td><?php echo $user['usr_ad_name']; ?></td>
                                        
                                        <td>
                                            <?php
                                            switch ($user['usr_status']) {
                                                case 'ACTIVE':
                                                    ?>
                                                    <h5><span class="badge badge-success badge-rounded">ACTIVE</span></h5>
                                                    <?php
                                                    break;
                                                case 'INACTIVE':
                                                    ?>
                                                    <h5><span class="badge badge-danger badge-rounded">INACTIVE</span></h5>
                                                    <?php
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            switch ($user['usr_2fa_enabled']) {
                                                case '1':
                                                    ?>
                                                    <h5><span class="badge badge-success badge-rounded">ENABLED</span></h5>
                                                    <?php
                                                    break;
                                                case '0':
                                                    ?>
                                                    <h5><span class="badge badge-danger badge-rounded">DISABLED</span></h5>
                                                    <?php
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                    <a href="<?php echo site_url('user/edituser/' . $user['usr_id']); ?>" class="dropdown-item edit_user text-info request_form"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit User</a>
                                                    <?php
                                                    if ($user['usr_2fa_enabled'] == '1') {
                                                        ?>
                                                        <a href="<?php echo site_url('user/disable2fa/' . $user['usr_id']); ?>" class="dropdown-item  text-warning confirm" title="disable 2FA for this user"> <i class="fa fa-unlock"></i>&nbsp;&nbsp;Disable 2FA</a>
                                                        <?php
                                                    } elseif ($user['usr_2fa_enabled'] == '0') {
                                                        ?>
                                                        <a href="<?php echo site_url('user/enable2fa/' . $user['usr_id']); ?>" class="dropdown-item  text-success confirm" title="enable 2FA for this user"> <i class="fa fa-lock"></i>&nbsp;&nbsp;&nbsp;Enable 2FA</a>
                                                        <?php
                                                    }
                                                    if ($user['usr_status'] == 'ACTIVE') {
                                                        ?>
                                                        <a href="<?php echo site_url('user/disableuser/' . $user['usr_id']); ?>" class="dropdown-item  text-secondary confirm" title="disable this user"> <i class="fa fa-lock"></i>&nbsp;&nbsp;&nbsp;Disable User</a>
                                                        <?php
                                                    } elseif ($user['usr_status'] == 'INACTIVE') {
                                                        ?>
                                                        <a href="<?php echo site_url('user/submitenableuser/' . $user['usr_id']); ?>" class="dropdown-item  text-success confirm" title="enable this user"> <i class="fa fa-unlock"></i>&nbsp;&nbsp;&nbsp;Enable User</a>
                                                        <?php
                                                    }
                                                    ?>

                                                    <a href="<?php echo site_url('user/submitdeluser/' . $user['usr_id']); ?>" class="dropdown-item text-danger confirm" title="delete this user"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete User</a>
                                                </div>
                                            </div>
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

        $('#users_table').DataTable({
            aaSorting: [],
            responsive: true,
            fixedHeader: {headerOffset: 70},
            searching: true,
            lengthChange: true,
            "pageLength": 25,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 1, targets: 1},
                {responsivePriority: 2, targets: -1},{
                    "targets": [2,3,5,6,7], //first column / numbering column
                    "orderable": false, //set not orderable
                }
            ]
        });

    });


</script>