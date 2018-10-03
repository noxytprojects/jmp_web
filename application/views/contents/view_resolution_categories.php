<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>
<?php echo $alert;?>

<section class="tables no-padding-top">   
    <div class="container-fluid" style="min-height:500px;">
        <br/><br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="btn-group pull-left" role="group" aria-label="Basic example">
                    <a href="<?php echo site_url('user/dashboard'); ?>"  class="btn btn-info btn-sm" ><i class="fa fa-dashboard"></i>&nbsp;Dashboard</a>
                </div>
                <div class="btn-group pull-right" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addCat"><i class="fa fa-plus-square"></i>&nbsp;Add Category</button>
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
                                    <th>Category </th>
                                    <th style="max-width:200px;">Sequence No. </th>
                                    <th style="width:10px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($cats as $key => $cat) {
                                    ?>
                                    <tr>
                                        <td><?php echo $cat['res_type_description'] ?></td>
                                        <td><?php echo $cat['res_type_sequence'] ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                                                <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                    <!--<a href="<?php // echo site_url('resolutions/edituser/' . $cat['res_type_id']); ?>" class="dropdown-item edit_cat text-info"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit Category</a>-->
                                                    <a href="<?php echo site_url('resolutions/deleteresolutioncategory/' . $cat['res_type_id']); ?>" class="dropdown-item del_user text-danger confirm"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete Category</a>
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