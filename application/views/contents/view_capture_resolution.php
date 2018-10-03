<!-- Page Header-->
<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom"><?php echo $module_name; ?></h2>
    </div>
</header>

<?php echo $alert; ?>
<section class="form">   

    <div class="container-fluid">

        <div class="col-lg-12">
            <div class="card has-shadow">
                <div class="card-header d-flex align-items-center">
                    <h3 class="h4">Enter Resolution Details</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo site_url('resolutions/submitresolutution'); ?>" method="post" class="form-horizontal">
                        <input type="hidden" name="details_type" value="adding"/>

                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Resolution Number </label>
                            <div class="col-sm-9 input-field">
                                <input name="res_number" placeholder="Enter the resolution number" value="<?php echo set_value('res_number'); //$res_number; ?>" class="form-control"/>
                                <?php echo form_error('res_number'); ?>
                            </div>
                        </div>
                        <br/>

                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Resolution Category </label>
                            <div class="col-sm-9 input-field">
                                <select name="res_type_id" style="width:100%" class="form-control">
                                    <option value=""></option>
                                    <?php
                                    $res_type_id = set_value('res_type_id');

                                    foreach ($res_types as $res_type) {
                                        ?>
                                        <option <?php echo $res_type_id == $res_type['res_type_id'] ? 'selected' : ''; ?> value="<?php echo $res_type['res_type_id']; ?>"><?php echo $res_type['res_type_description']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('res_type_id'); ?>
                            </div>
                        </div>
                        <br/>

                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Resolution SMS (English) </label>
                            <div class="col-sm-9 input-field">
                                <textarea rows="3" name="res_desc_en"   placeholder="Enter Resolution SMS in English" class="form-control <?php echo!empty(form_error('res_desc_en')) ? 'is-invalid' : ''; ?>"><?php echo set_value('res_desc_en'); ?></textarea>
                                <?php echo form_error('res_desc_en'); ?>
                            </div>
                        </div>
                        <br/>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Resolution SMS (Swahili)</label>
                            <div class="col-sm-9 input-field">
                                <textarea rows="3" name="res_desc_sw"  placeholder="Enter Resolution SMS in Swahili" class="form-control <?php echo!empty(form_error('res_desc_sw')) ? 'is-invalid' : ''; ?>"><?php echo set_value('res_desc_sw'); ?></textarea>
                                <?php echo form_error('res_desc_sw'); ?>
                            </div>
                        </div>
                        <br/>
                        <div class="form-group row">
                            <label class="col-sm-3 form-control-label">Resolution Question Type</label>
                            <div class="col-sm-9 input-field">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div>
                                            <input id="yesorno" <?php echo set_value('qn_type') == 'YESNO' ? 'checked="checked"' : ''; ?> type="radio" value="YESNO" name="qn_type">
                                            <label for="yesorno">FOR/AGAINST</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div>
                                            <input id="multiple" <?php echo set_value('qn_type') == 'MULTI' ? 'checked="checked"' : ''; ?> type="radio" value="MULTI" name="qn_type">
                                            <label for="multiple">MULTIPLE CHOICES</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div>
                                            <input id="ms" <?php echo set_value('qn_type') == 'MS' ? 'checked="checked"' : ''; ?> type="radio" value="MS" name="qn_type">
                                            <label for="ms">MULTIPLE SELECTION</label>
                                        </div>
                                    </div>

                                </div>
                                <?php echo form_error('qn_type'); ?>
                            </div>
                        </div>
                        <br/>
                        <div id="choices" class="form-group row <?php echo (set_value('qn_type') == 'MULTI' OR  set_value('qn_type') == 'MS')? '' : 'hide'; ?>">
                            <label class="col-sm-3 form-control-label">Resolution Answer Choices</label>
                            <div class="col-sm-9 input-field">
                                <?php
                                if (!empty(set_value('letter[]'))) {

                                    $letters = set_value('letter[]');
                                    $qn_desc_en = set_value('qn_desc_en[]');
                                    $qn_desc_sw = set_value('qn_desc_sw[]');

                                    foreach ($letters as $i => $l) {

                                        if (!empty($letters[$i]) AND ! empty($qn_desc_en[$i]) AND ! empty($qn_desc_sw[$i])) {
                                            ?>
                                            <div class="row" style="margin-bottom:10px;">
                                                <div class="col-3">
                                                    <select name="letter[]" class="form-control letter">
                                                        <option <?php echo $letters[$i] == 'A' ? 'selected' : ''; ?> value="A">A</option>
                                                        <option <?php echo $letters[$i] == 'B' ? 'selected' : ''; ?> value="B">B</option>
                                                        <option <?php echo $letters[$i] == 'C' ? 'selected' : ''; ?> value="C">C</option>
                                                        <option <?php echo $letters[$i] == 'D' ? 'selected' : ''; ?> value="D">D</option>
                                                        <option <?php echo $letters[$i] == 'E' ? 'selected' : ''; ?> value="E">E</option>
                                                        <option <?php echo $letters[$i] == 'F' ? 'selected' : ''; ?> value="F">F</option>
                                                        <option <?php echo $letters[$i] == 'G' ? 'selected' : ''; ?> value="G">G</option>
                                                        <option <?php echo $letters[$i] == 'H' ? 'selected' : ''; ?> value="H">H</option>
                                                        <option <?php echo $letters[$i] == 'I' ? 'selected' : ''; ?> value="I">I</option>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <input name="qn_desc_en[]" type="text" placeholder="English description" value="<?php echo $qn_desc_en[$i]; ?>" class="form-control desc_en">
                                                </div>
                                                <div class="col-4">
                                                    <input name="qn_desc_sw[]" type="text" placeholder="Swahili description" value="<?php echo $qn_desc_sw[$i]; ?>" class="form-control desc_sw">
                                                </div>
                                                <a class="deleteRow"><img src="http://i.imgur.com/ZSoHl.png"></a>
                                            </div>                                    
                                            <?php
                                        }
                                    }
                                }
                                ?>
                                <div class="row" id="initRow" style="margin-bottom:10px;">
                                    <div class="col-md-3">
                                        <select name="letter[]" class="form-control letter">
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>
                                            <option value="F">F</option>
                                            <option value="G">G</option>
                                            <option value="H">H</option>
                                            <option value="I">I</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input name="qn_desc_en[]" type="text" placeholder="English description" class="form-control desc_en">
                                    </div>
                                    <div class="col-md-4">
                                        <input name="qn_desc_sw[]" type="text" placeholder="Swahili description" class="form-control desc_sw">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="ms_max" class="form-group row <?php echo (set_value('qn_type') == 'MS')? '' : 'hide'; ?>">
                            <label class="col-sm-3 form-control-label">Maxmum Choice Selection <br/><small class="text-primary">Maxmum number of choices attendee can select</small></label>
                            <div class="col-sm-9 input-field">
                                <input name="max_selection" value="<?php echo set_value('max_selection');?>" class="form-control"/>
                                <?php echo form_error('max_selection'); ?>
                            </div>
                        </div>

                        <div class="line"></div>
                        <div class="clearfix"></div>
                        <div class="form-group row">
                            <div class="col-sm-4 offset-sm-3">
                                <button type="submit" class="btn btn-primary">Save Resolution</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>

<script type="text/javascript">

    $(document).ready(function () {

        $('select[name=res_type_id]').select2({placeholder: 'Select resolution type'});
        $('#hall_booking_price').numeric({negative: false, decimalPlaces: 2});
        $('#hall_advance').numeric({negative: false, decimalPlaces: 2});
        $('#hall_size').numeric({negative: false, decimal: false});

        $('#select_manager').select2({placeholder: 'Select manager for this hall'});

        format = {h1: false, h2: false, h3: false, h4: false, h5: false, h6: false, indent: false, outdent: false, fsize: false, sub: false, sup: false, unlink: false, hr: false, source: false, strike: false, left: false, right: false, center: false, color: false, remove: false, format: false, rule: false}

        $('#hall_description').jqte(format);

        $('input[name=qn_type]').on('change', function () {

            if (this.value == 'MULTI' || this.value == 'MS') {
                $('#choices').removeClass('hide');
            } else if (this.value == 'YESNO') {
                $('#choices').addClass('hide');
            }
            
            if (this.value == 'MS') {
                $('#ms_max').removeClass('hide');
            } else if (this.value == 'YESNO' || this.value == 'MULTI') {
                $('#ms_max').addClass('hide');
            }
            
        });


        $(document).on('click','.deleteRow',function(){
            $(this).parent('.row').remove();
        });
        
        var initRow = $('#initRow');
        section = initRow.parent('section');

        initRow.on('focus', 'input', function () {
            addRow(section, initRow);
        });

        initRow.on('change', 'select', function () {
            addRow(section, initRow);
        });

        function addRow(section, initRow) {

            var newRow = initRow.clone().removeAttr('id').addClass('new').insertBefore(initRow);
            deleteRow = $('<a class="rowDelete"><img src="http://i.imgur.com/ZSoHl.png"></a>');

            newRow.append(deleteRow).on('click', 'a.rowDelete', function () {
                removeRow(newRow);
            }).slideDown(300, function () {
                $(this).find('.desc_en').focus();
            })
        }

        function removeRow(newRow) {
            newRow.slideUp(200, function () {
                $(this).next('div:not(#initRow)').find('input').focus().end().end().remove();
            });
        }

    });

</script>
