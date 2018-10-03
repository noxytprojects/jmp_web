<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>
<?php echo $error_msg . $success_msg; ?>

<section class="tables no-padding-top">  

    <div class="container-fluid" style="min-height: 500px;">
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="btn-group pull-right" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-square"></i>&nbsp;Add Customer</button>
                </div>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <table class="table" id="log_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <!--<th>ID</th>-->
                                    <th>LEVEL</th>
                                    <th>TIME</th>
                                    <th>MESSAGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $classes = array(
                                    'ERROR' => 'danger',
                                    'DEBUG' => 'warning',
                                    'INFO' => 'info',
                                    'PETRONITE' => 'info'
                                );
                                for ($i = 0; $i < count($cols['level']); $i++) {
                                    ?>
                                    <tr>
                                        <!--<td class="<?php echo $classes[$cols['level'][$i]]; ?>"><?php echo $i + 1; ?></td>-->
                                        <td class="<?php echo $classes[$cols['level'][$i]]; ?>"><?php echo $cols['level'][$i]; ?></td>
                                        <td class="<?php echo $classes[$cols['level'][$i]]; ?>"><?php echo date('YmdHis', strtotime($cols['time'][$i])); ?></td>
                                        <td class="<?php echo $classes[$cols['level'][$i]]; ?>"><?php echo $cols['message'][$i]; ?></td>
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

<!--  <script src="<?php echo base_url(); ?>assets/js/charts-home.js" type="text/javascript"></script>-->

<script type="text/javascript">

    $(document).ready(function () {
        $('#log_table').DataTable({
            "order": [[ 1, "desc" ]],
            responsive: true,
            fixedHeader: { headerOffset: 70 },
            columnDefs: [
                //{responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -1}
            ]
        });
    });

</script>


