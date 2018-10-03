<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>

<?php echo $alert; ?>

<section class="tables no-padding-top">   
    <div class="container-fluid" style="min-height:500px;">

        <br/>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <!--Table should go here-->
                        <table id="market_table" class="" style="width:100%;font-size: 11px;background: #fff;text-align: center;">
                            <thead>
                                <tr style="background: #dd3c45;color: #fff;">
                                    <th>SECURITY</th>
                                    <th>QTYB</th>
                                    <th>BID</th>
                                    <th>OFFER</th>
                                    <th>QTY O</th>
                                    <th>LAST</th>
                                    <th>CHANGE</th>
                                    <th>TIME</th>
                                    <th>HIGH</th>
                                    <th>LOW</th>
                                    <th>VOLUME</th>
                                    <th>MARKET CAP</th>
                                </tr>
                            </thead>
                            <tbody>


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
        $('.form-group').click(function () {
            $(this).children('.rmv_error').remove();
        });

        var table = $('#market_table').DataTable({
            "aaSorting": [],
            responsive: true,
            fixedHeader: {headerOffset: 70},
            searching: false,
            lengthChange: false,
            "info": false,
            "paging": false,
            "pageLength": 100,
            "processing": false, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('market/ajaxmarketstatus'); ?>",

                "type": "POST",
                error: function (xhr, error, thrown) {
                    alert('Something went wrong!');
                    // location.reload(false);
                }
            },

            //Set column definition initialisation properties.
            columnDefs: [
                {responsivePriority: 1, targets: 1},
                {responsivePriority: 2, targets: -1},
                {
                    "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ]
        });

        setInterval(function () {
            table.ajax.reload();
        }, 3000);

    });
</script>