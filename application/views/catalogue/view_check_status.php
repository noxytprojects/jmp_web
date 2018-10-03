<div class="inner-bg">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2 text text-center">
                <h1>Youth Campus Campaign</h1>
                <div class="description">
                    <p>
                        <?php echo $module_name; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12  col-sm-10 offset-md-2 col-md-8 offset-sm-1  col-lg-6 offset-lg-3 form-box">

                <form role="form"  action="<?php echo site_url('status/submitcheckstatus'); ?>" method="post" class="registration-form">
                    <fieldset id="first_fieldset">
                        <div class="form-top">
                            <div class="form-top-left">
                                
                                <p style="margin-top: 10px;" class="no-padding">Submit the below details to check your application status.</p>
                            </div>
                            <div class="form-top-right">
                                <i class="fa fa-exclamation-circle"></i>
                            </div>
                        </div>

                        <div class="form-bottom">

                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12">
                                    <div class="form-group" id="full_name">
                                        <label class="" for="phone_number">Phone Number</label>
                                        <input type="text" name="phone_number" autocomplete="off" placeholder="Phone number..." class="form-first-name form-control" value="<?php echo set_value('phone_number');  ?>" id="form-first-name">
                                        <?php echo form_error('phone_number'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12">
                                    <div class="form-group" id="id_number">
                                        <label class="" for="id_number">ID Number</label>
                                        <input type="text" name="id_number" autocomplete="off" placeholder="ID Number..." class="form-last-name form-control" value="<?php echo set_value('id_number');  ?>" id="form-last-name">
                                        <?php echo form_error('id_number'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <br/>
                            <button type="submit" class="btn">Submit</button>
                        </div>
                    </fieldset>                    
                </form>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    $(document).ready(function () {
        $('.registration-form fieldset:first-child').fadeIn('slow');
    });

</script>
