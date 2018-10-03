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
                    <a href="<?php echo site_url('shareholder/cdsaccounts'); ?>"  class="btn btn-info btn-sm" ><i class="fa fa-chevron-circle-left"></i>&nbsp;CDS Accounts List</a>
                </div>
                <div class="btn-group pull-right" role="group" aria-label="Basic example">
                    <?php
                    if (in_array(strtolower($user_role), ['admin'])) {
                        ?>
                        <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#uploadCDSExcel"><i class="fa fa-upload"></i>&nbsp;Upload CDS</button>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
        <br/>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <table id="cds_acc_table" class="table table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Upload Time</th>
                                    <th>AGM Year</th>
                                    <th>Uploaded File</th>
                                    <th>Notes</th>
                                    <th>Ignored Rows</th>
                                    <th>Uploaded By</th>
                                    <th style="width: 10px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($uploads as $i => $u) {
                                    ?>
                                    <tr>

                                        <td><?php echo cus_nice_timestamp($u['cds_upload_timestamp']); ?></td>
                                        <td><?php echo $u['year_name']; ?></td>
                                        <td><a href="<?php echo base_url(); ?>/uploads/imports/<?php echo $u['cds_upload_file_path']; ?>">Download File</a></td>
                                        <td><?php echo $u['cds_upload_notes']; ?></td>
                                        <td><?php echo $u['cds_upload_ignored_rows']; ?></td>
                                        <td><?php echo $u['usr_fullname']; ?></td>
                                        <td><a href="<?php echo site_url('shareholder/removecdsupload/' . $u['cds_upload_id']); ?>" class="btn btn-outline-danger btn-sm confirm" title="delete imported file. It will also delete corresponding cds accounts"><i class="fa fa-trash"></i></a></td>
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

    Dropzone.autoDiscover = false;
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


        var myDropzone = new Dropzone('div#uploadcds', {url: '<?php echo site_url('utility/upload/IMPORT'); ?>',
            parallelUploads: 100,
            maxFiles: 1,
        });

        //        Drop zone on error
        myDropzone.on("error", function (file, message, xhr) {

            var header = xhr.status + ": " + xhr.statusText;

            $(file.previewElement).find('.dz-error-message').text(message.error);

            // Create the cancel link
            var cancelLink = Dropzone.createElement('<a href="javascript:undefined;" class="text-danger" style="display:block;text-align:center;cursor:pointer;position: absolute;top: -10px;z-index: 100;right: -10px;background: #f1f1f1;padding: 2px 10px;border-radius: 100%;"><i class="fa fa-trash"></i></a>');

            // Add the cancel link to the preview element
            // If you want it to replace another element, you can do that your way of course.
            file.previewElement.appendChild(cancelLink);

            // Now the most important part: attach the event listener here:
            cancelLink.addEventListener("click", function (e) {

                e.preventDefault();
                myDropzone.removeFile(file);

            });

        });


        myDropzone.on("success", function (file, message) {

            // Create the cancel link
            var cancelLink = Dropzone.createElement('<a href="javascript:undefined;" class="text-danger" style="display:block;text-align:center;cursor:pointer;position: absolute;top: -10px;z-index: 100;right: -10px;background: #f1f1f1;padding: 2px 10px;border-radius: 100%;"><i class="fa fa-trash"></i></a>');

            // Add the cancel link to the preview element
            // If you want it to replace another element, you can do that your way of course.
            file.previewElement.appendChild(cancelLink);

            // Now the most important part: attach the event listener here:
            cancelLink.addEventListener("click", function (e) {


                e.preventDefault();
                $.ajax({

                    type: "get",
                    url: "<?php echo base_url(); ?>index.php/utility/removeimport/" + message.filename + '/IMPORT',
                    success: function (data)
                    {

                    }

                });

                // Referencing file here as closure
                myDropzone.cancelUpload(file);
                myDropzone.removeFile(file);

            });

        });


        $('.removetempfile').click(function (e) {

            e.preventDefault();
            mother = $(this).parents('.dz-preview');
            url = $(this).attr('href');

            $.ajax({
                type: "get",
                url: url,
                success: function (data)
                {
                    mother.remove();
                }

            });
        });

    });

</script>