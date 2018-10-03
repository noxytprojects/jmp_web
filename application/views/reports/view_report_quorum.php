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
                    <a href="<?php echo site_url('reports/pdfexportquorumreport'); ?>" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Export PDF</a>
                </div>
            </div>
        </div>

        <br/>
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body no-padding">
                        <table  class="table table- table-bordered " style="width: 100%">
                            
                            <tbody>
                                <tr>
                                    <th>MEETING YEAR</th>
                                    <td><?php echo $year['year_name']?></td>
                                </tr>
                                <tr>
                                     <th>SHAREHOLDERS REGISTERED</th>
                                     <td><?php echo cus_price_form($shareholders_registered); ?></td>
                                </tr>
                                <tr>
                                    <th>PERCENTAGE OF SHARES REGISTERED</th>
                                    <td><?php echo $percent;?>&percnt;</td>
                                </tr>
                                <tr>
                                    <th>SHARES REGISTERED</th>
                                    <td><?php echo cus_price_form($shares_registered);?></td>
                                </tr>
                                <tr>
                                    <th>TOTAL SHARES CAPITAL</th>
                                    <td><?php echo cus_price_form($total_capital); ?></td>
                                </tr>
                                
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

    });


</script>