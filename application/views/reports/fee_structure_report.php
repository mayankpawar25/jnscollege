<div class="content-wrapper" style="min-height: 946px;">    
    <!-- Main content -->
    <section class="content">
        <?php $this->load->view('reports/_feestructureinformation'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box removeboxmius">
                    <div class="box-header ptbnull"></div>
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                    <div class="box-body">    
                        <form role="form" action="<?php echo site_url('report/checkfeevalidation') ?>" method="post" id="reportform" >
                            <div class="row">
                                <?php echo $this->customlib->getCSRF(); ?>
                                <div class="col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('fees_group'); ?></label>
                                        <select autofocus="" id="fees_group_id" name="fees_group_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($fees_groups as $fees_group) {
                                                ?>
                                                <option value="<?php echo $fees_group['id'] ?>" <?php if (set_value('fees_group_id') == $fees_group['id']) echo "selected=selected" ?> ><?php echo $fees_group['name'] ?></option>
                                                <?php
                                                $count++;
                                            }
                                            ?>
                                        </select>
                                      <span class="text-danger" id="error_fees_group_id"></span>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button type="submit" name="search" value="search_filter" class="btn btn-primary btn-sm checkbox-toggle pull-right"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>
                                    </div>
                                </div>
                            </div><!--./row-->     
                        </form>
                    </div><!--./box-body-->  
                    <div class="box-header ptbnull"></div>
                    <div class="">
                        <div class="box-header ptbnull">
                            <h3 class="box-title titlefix"><i class="fa fa-users"></i> <?php echo $this->lang->line('online_admission_report'); ?></h3>
                        </div>
                        <div class="box-body table-responsive">                             
                           <table class="table table-striped table-bordered table-hover student-list" data-export-title="<?php echo $this->lang->line('online_admission_report'); ?>">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('fees_code'); ?></th>
                                        <th><?php echo $this->lang->line('amount'); ?></th>                                       
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!--./box box-primary-->
            </div><!--./col-md-12-->  
        </div>   
    </div>  
</section>
</div>

<script>
$(document).ready(function() {
     emptyDatatable('student-list','data');
});
</script>

<script type="text/javascript">
$(document).ready(function(){ 
$(document).on('submit','#reportform',function(e){
    e.preventDefault(); // avoid to execute the actual submit of the form.
    var $this = $(this).find("button[type=submit]:focus");  
    var form = $(this);
    var url = form.attr('action');
    var form_data = form.serializeArray();
    $.ajax({
           url: url,
           type: "POST",
           dataType:'JSON',
           data: form_data, // serializes the form's elements.
              beforeSend: function () {
                $('[id^=error]').html("");
                $this.button('loading');
               },
              success: function(response) { // your success handler
                
                if(!response.status){
                    $.each(response.error, function(key, value) {
                    $('#error_' + key).html(value);
                    });
                }else{                 
                   initDatatable('student-list','report/dtonlinefeestructurereportlist', response.params);
                }
              },
             error: function() { // your error handler
                 $this.button('reset');
             },
             complete: function() {
               $this.button('reset');
             }
         });
        });
    });    
</script>