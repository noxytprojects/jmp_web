<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>
<!-- Breadcrumb-->

<?php echo $alert; ?>

<section class="tables no-padding-top">   
    <div class="container-fluid">
        <br/>
        <div class="row">
            <div class="col-lg-12">
                <div class="line-chart-example card has-shadow">
                     
                    <div class="card-body">
                        <form method="post" action="<?php echo site_url('catalogue/submitselectlanguage'); ?>">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <p>Please Select Your Language</p>
                                        <p>Tafadhali Chagua Lugha</p>
                                    </div>
                                </div>
                            </div>
                            <br/>

                            <div class="row">
                                <div class="col col-12">
                                    <div>
                                        <input  id="optionsRadios1"  <?php echo $lang == 'SW' ? 'checked="checked"' : ''; ?> type="radio" value="SW" name="lang">
                                        <label for="optionsRadios1" class="text-bold">&nbsp;&nbsp;Kiswahili </label>
                                    </div>
                                </div>

                                <div class="col col-12">
                                    <div>
                                        <input id="optionsRadios2" <?php echo $lang == 'EN' ? 'checked="checked"' : ''; ?> type="radio"  value="EN" name="lang">
                                        <label for="optionsRadios2" class="text-bold">&nbsp;&nbsp;English</label>
                                    </div>
                                </div>

                                <br/>
                                <br/>
                                
                            </div>

                            <?php echo form_error('lang');?>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success" name="vote"><?php echo $lang == 'SW' ? 'Endelea' : 'Continue'; ?></button>
                                </div>

                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>