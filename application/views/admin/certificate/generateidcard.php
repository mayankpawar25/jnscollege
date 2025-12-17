<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>
<div class="content-wrapper">  
    <section class="content-header">
        <h1><i class="fa fa-newspaper-o"></i> <?php //echo $this->lang->line('certificate'); ?></h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <?php if ($this->session->flashdata('msg')) { ?>
            <?php 
                echo $this->session->flashdata('msg');
                $this->session->unset_userdata('msg');
            ?>
        <?php } ?>  
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <form role="form" action="<?php echo site_url('admin/generateidcard/search') ?>" method="post" class="">
                                <?php echo $this->customlib->getCSRF(); ?>
                                <div class="col-sm-4">
                                    <div class="form-group"> 
                                        <label><?php echo $this->lang->line('class'); ?></label><small class="req"> *</small>
                                        <select autofocus="" id="class_id" name="class_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($classlist as $class) {
                                                ?>
                                                <option value="<?php echo $class['id'] ?>" <?php if (set_value('class_id') == $class['id']) echo "selected=selected" ?>><?php echo $class['class'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                    </div>  
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('section'); ?></label>
                                        <select  id="section_id" name="section_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                                    </div>   
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('id_card_template'); ?></label><small class="req"> *</small>
                                        <select  id="id_card" name="id_card" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            if (isset($idcardlist)) {
                                                foreach ($idcardlist as $list) {
                                                    ?>
                                                    <option value="<?php echo $list->id ?>" <?php if (set_value('id_card') == $list->id) echo "selected=selected" ?>><?php echo $list->title ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('id_card'); ?></span>
                                    </div>   
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>  
                    </div>

                    <?php
                    if (isset($resultlist)) {
                        ?>
                        <form method="post" action="<?php echo base_url('admin/generateidcard/generatemultiple') ?>">
                            <div  class="" id="duefee">
                                <div class="box-header ptbnull"></div>   
                                <div class="box-header ptbnull">
                                    <h3 class="box-title titlefix"><i class="fa fa-users"></i> <?php echo $this->lang->line('student_list'); ?></h3>
                                    <button class="btn btn-info btn-sm printSelected pull-right" type="button" name="generate" title="<?php echo $this->lang->line('generate_certificate'); ?>"><?php echo $this->lang->line('generate'); ?></button>
                                </div>
                                <div class="box-body table-responsive overflow-visible">
                                    <div class="download_label"><?php echo $this->lang->line('student_list'); ?></div>
                                    <div class="tab-pane active table-responsive no-padding" id="tab_1">
                                        <table class="table table-striped table-bordered table-hover example" cellspacing="0" width="100%">
                                            <thead>
                                                <tr> 
                                                    <th><input type="checkbox" id="select_all" /></th>
                                                    <?php if (!$adm_auto_insert) { ?>
                                                        <th><?php echo $this->lang->line('admission_no'); ?></th>
                                                    <?php } ?>
                                                    <th><?php echo $this->lang->line('student_name'); ?></th>
                                                    <th><?php echo $this->lang->line('class'); ?></th>
                                                    <?php if ($sch_setting->father_name) { ?>
                                                        <th><?php echo $this->lang->line('father_name'); ?></th>
                                                    <?php } ?>
                                                    <th><?php echo $this->lang->line('date_of_birth'); ?></th>
                                                    <th><?php echo $this->lang->line('gender'); ?></th>
                                                    <?php if ($sch_setting->category) { ?>
                                                        <th><?php echo $this->lang->line('category'); ?></th>
                                                    <?php } if ($sch_setting->mobile_no) { ?>
                                                        <th><?php echo $this->lang->line('mobile_number'); ?></th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (empty($resultlist)) {
                                                    ?>

                                                    <?php
                                                } else {
                                                    $count = 1;
                                                    foreach ($resultlist as $student) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><input type="checkbox" class="checkbox center-block" data-student_id="<?php echo $student['id'] ?>"  name="check" id="check" value="<?php echo $student['id'] ?>">
                                                                <input type="hidden" name="class_id" id="class_id" value="<?php echo $student['class_id'] ?>">
                                                                <input type="hidden" name="id_card_id" id="id_card_id" value="<?php echo $idcardResult[0]->id ?>">
                                                            </td>
                                                            <?php if (!$adm_auto_insert) { ?>
                                                                <td><?php echo $student['admission_no']; ?></td>
                                                            <?php } ?>
                                                            <td>
                                                                <a href="<?php echo base_url(); ?>student/view/<?php echo $student['id']; ?>"><?php echo $this->customlib->getFullName($student['firstname'],$student['middlename'],$student['lastname'],$sch_setting->middlename,$sch_setting->lastname); ?>
                                                                </a>
                                                            </td>
                                                            <td><?php echo $student['class'] . "(" . $student['section'] . ")" ?></td>
                                                            <?php if ($sch_setting->father_name) { ?>
                                                                <td><?php echo $student['father_name']; ?></td>
                                                            <?php } ?>
                                                            <td>
                                                                <?php if(!empty($student['dob'])){ echo date($this->customlib->getSchoolDateFormat(), $this->customlib->dateyyyymmddTodateformat($student['dob'])); } ?>
                                                            </td>
                                                            <td><?php echo $this->lang->line(strtolower($student['gender'])); ?></td>
                                                            <?php if ($sch_setting->category) { ?>
                                                                <td><?php echo $student['category']; ?></td>
                                                            <?php } if ($sch_setting->mobile_no) { ?>
                                                                <td><?php echo $student['mobileno']; ?></td>
                                                            <?php } ?>
                                                        </tr>
                                                        <?php
                                                        $count++;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>                                                                           
                                </div>                                                         
                            </div>
                        </form>
                        <?php
                    }
                    ?>
                </div>  
            </div>  
        </div> 
    </section>
</div>
<div class="response"> 
</div>
<script type="text/javascript">
    function getSectionByClass(class_id, section_id) {
        if (class_id != "" && section_id != "") {
            $('#section_id').html("");
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "sections/getByClass",
                data: {'class_id': class_id},
                dataType: "json",
                success: function (data) {
                    $.each(data, function (i, obj)
                    {
                        var sel = "";
                        if (section_id == obj.section_id) {
                            sel = "selected";
                        }
                        div_data += "<option value=" + obj.section_id + " " + sel + ">" + obj.section + "</option>";
                    });
                    $('#section_id').append(div_data);
                }
            });
        }
    }
    
    $(document).ready(function () {
        var class_id = $('#class_id').val();
        var section_id = '<?php echo set_value('section_id') ?>';
        getSectionByClass(class_id, section_id);
        $(document).on('change', '#class_id', function (e) {
            $('#section_id').html("");
            var class_id = $(this).val();
            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "sections/getByClass",
                data: {'class_id': class_id},
                dataType: "json",
                success: function (data) {
                    $.each(data, function (i, obj)
                    {
                        div_data += "<option value=" + obj.section_id + ">" + obj.section + "</option>";
                    });
                    $('#section_id').append(div_data);
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#select_all').on('click', function () {
            if (this.checked) {
                $('.checkbox').each(function () {
                    this.checked = true;
                });
            } else {
                $('.checkbox').each(function () {
                    this.checked = false;
                });
            }
        });

        $('.checkbox').on('click', function () {
            if ($('.checkbox:checked').length == $('.checkbox').length) {
                $('#select_all').prop('checked', true);
            } else {
                $('#select_all').prop('checked', false);
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '.printSelected', function () {
            var array_to_print = [];
            var classId = $("#class_id").val();
            var idCard = $("#id_card_id").val();
            $.each($("input[name='check']:checked"), function () {
                var studentId = $(this).data('student_id');
                item = {}
                item ["student_id"] = studentId;
                array_to_print.push(item);
            });
            if (array_to_print.length == 0) {
                alert("<?php echo $this->lang->line('no_record_selected'); ?>");
            } else {
                $.ajax({
                    url: '<?php echo site_url("admin/generateidcard/generatemultiple") ?>',
                    type: 'post',
                    dataType: 'JSON',
                    data: {'data': JSON.stringify(array_to_print), 'class_id': classId, 'id_card': idCard, },
                    success: function (response) {
                        if(response.status) {
                            Popup(response.page);
                        } else {
                            alert(response.error);
                        }
                    },
                    error: function(err){
                          console.log("error data");
                    },
                });
            }
        });
    });
</script>
<script type="text/javascript">

    var base_url = '<?php echo base_url() ?>';
    function waitForPrintAssets(iframeEl, timeoutMs) {
        var deferred = $.Deferred();
        var start = Date.now();

        function check() {
            var doc = (iframeEl.contentDocument || (iframeEl.contentWindow && iframeEl.contentWindow.document));
            if (!doc) {
                if ((Date.now() - start) > timeoutMs) {
                    return deferred.resolve();
                }
                return setTimeout(check, 100);
            }

            var images = doc.images ? Array.prototype.slice.call(doc.images) : [];
            var imagesReady = images.every(function (img) { return img.complete; });

            var fontsReady = true;
            if (doc.fonts && typeof doc.fonts.ready !== 'undefined') {
                fontsReady = (doc.fonts.status === 'loaded');
            }

            if (imagesReady && fontsReady) {
                return deferred.resolve();
            }

            if ((Date.now() - start) > timeoutMs) {
                return deferred.resolve();
            }

            setTimeout(check, 100);
        }

        setTimeout(check, 50);
        return deferred.promise();
    }

    function Popup(data) {
        var frameId = 'printDiv_' + Date.now();
        var frame1 = $('<iframe>', {
            id: frameId,
            name: frameId
        }).css({
            position: 'absolute',
            left: '-9999px',
            top: '0',
            width: '0',
            height: '0',
            border: '0'
        });

        // Remove any old/leftover print frames.
        $("iframe[id^='printDiv_']").remove();

        $("body").append(frame1);

        var iframeEl = frame1[0];
        var frameDoc = (iframeEl.contentDocument || (iframeEl.contentWindow && iframeEl.contentWindow.document));
        frameDoc.open();
        frameDoc.write('<!doctype html>');
        frameDoc.write('<html>');
        frameDoc.write('<head>');
        frameDoc.write('<meta charset="utf-8">');
        frameDoc.write('<title></title>');
        frameDoc.write('</head>');
        frameDoc.write('<body>');
        frameDoc.write(data);
        frameDoc.write('</body>');
        frameDoc.write('</html>');
        frameDoc.close();

        waitForPrintAssets(iframeEl, 60000).always(function () {
            var win = iframeEl.contentWindow;
            var cleanup = function () { frame1.remove(); };

            if (win) {
                try {
                    win.onafterprint = cleanup;
                } catch (e) {
                }
                win.focus();
                win.print();
            }

            // Fallback cleanup in case onafterprint doesn't fire.
            setTimeout(cleanup, 20000);
        });

        return true;
    }
</script>
