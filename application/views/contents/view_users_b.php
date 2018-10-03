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
                        <table id="users_table" class="table table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>User Phone</th>
                                    <th>User Role</th>
                                    <th>User AD Nmae</th>
                                    <th>Status</th>
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
                                            <div class="dropdown">
                                                <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                    <a href="<?php echo site_url('user/edituser/' . $user['usr_id']); ?>" class="dropdown-item edit_user text-info request_form"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit User</a>
                                                    <?php
                                                    if ($user['usr_status'] == 'ACTIVE') {
                                                        ?>
                                                        <a href="<?php echo site_url('user/disableuser/' . $user['usr_id']); ?>" class="dropdown-item  text-secondary confirm" title="disable this user"> <i class="fa fa-lock"></i>&nbsp;&nbsp;&nbsp;Disable User</a>
                                                        <?php
                                                    } elseif ($user['usr_status'] == 'INACTIVE') {
                                                        ?>
                                                        <a href="<?php echo site_url('user/submitenableuser/' . $user['usr_id']); ?>" class="dropdown-item  text-success confirm" title="enable this user"> <i class="fa fa-lock"></i>&nbsp;&nbsp;&nbsp;Enable User</a>
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
                {responsivePriority: 2, targets: -1}
            ]
        });

    });


</script>