<?php $currency_symbol = $this->customlib->getSchoolCurrencyFormat(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-money"></i> <?php echo $this->lang->line('fees_collection'); ?></h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php if ($this->rbac->hasPrivilege('fees_master', 'can_add') || $this->rbac->hasPrivilege('fees_master', 'can_edit')) { ?>
                <div class="col-md-4">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $this->lang->line('edit_fees_master') . " : " . $this->setting_model->getCurrentSessionName(); ?></h3>
                        </div><!-- /.box-header -->
                        <form id="form1" action="<?php echo site_url("admin/feebreakups/edit/" . $feegroup_type[0]->id) ?>"  id="feemasterform" name="feemasterform" method="post" accept-charset="utf-8">
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php 
                                        echo $this->session->flashdata('msg');
                                        $this->session->unset_userdata('msg'); 
                                    ?>
                                <?php } ?>

                                <?php echo $this->customlib->getCSRF(); ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="id" value="<?php echo $feegroup_type[0]->id; ?>">
                                        <?php
                                            // echo "<pre>";
                                            // print_r(set_value('fee_breakup_id'));
                                            // die;
                                        ?>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('fees_group'); ?></label><small class="req"> *</small>
                                            <select autofocus="" id="fee_groups_id" name="fee_groups_id" class="form-control" >
                                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                <?php
                                                foreach ($feegroupList as $feegroup) {
                                                    ?>
                                                    <option value="<?php echo $feegroup['id'] ?>"<?php
                                                    if (set_value('fee_groups_id', $feegroup_type[0]->feegroup_id) == $feegroup['id']) {
                                                        echo "selected =selected";
                                                    }
                                                    ?>><?php echo $feegroup['name'] ?></option>

                                                    <?php
                                                    $count++;
                                                }
                                                ?>
                                            </select>
                                            <span class="text-danger"><?php echo form_error('fee_groups_id'); ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="breakups"><?php echo $this->lang->line('fees_breakup'); ?></label> <small class="req">*</small>
                                            <select autofocus="" id="fee_breakup_id" name="fee_breakup_id" class="form-control" >
                                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                <?php
                                                foreach ($breakups as $breakup) {
                                                    ?>
                                                    <option value="<?php echo $breakup['id'] ?>"<?php
                                                    if (set_value('fee_breakup_id', $feegroup_type[0]->breakup['id']) == $breakup['id']) {
                                                        echo "selected =selected";
                                                    }
                                                    ?>><?php echo $breakup['name'] ?></option>

                                                    <?php
                                                    $count++;
                                                }
                                                ?>
                                            </select>
                                            <span class="text-danger"><?php echo form_error('fee_breakup_id'); ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo $this->lang->line('amount'); ?> (<?php echo $currency_symbol; ?>)</label><small class="req">*</small>
                                            <input id="amount" name="amount" placeholder="" type="text" class="form-control"  value="<?php echo set_value('amount', convertBaseAmountCurrencyFormat($feegroup_type[0]->amount)); ?>" />
                                            <span class="text-danger"><?php echo form_error('amount'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                    </div><!-- /.box-body -->
                    </form>
                </div>
                <div class="col-md-<?php
                if ($this->rbac->hasPrivilege('fees_master', 'can_add') || $this->rbac->hasPrivilege('fees_master', 'can_edit')) {
                    echo "8";
                } else {
                    echo "12";
                }
                ?>">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-header ptbnull">
                            <h3 class="box-title titlefix"><?php echo $this->lang->line('fees_master_list') . " : " . $this->setting_model->getCurrentSessionName(); ?></h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="download_label"><?php echo $this->lang->line('fees_master_list') . " : " . $this->setting_model->getCurrentSessionName(); ?></div>
                            <div class="mailbox-messages">
                                <div class="table-responsive">  
                                    <table class="table table-striped table-bordered table-hover example">
                                        <thead>
                                            <tr>
                                                <th><?php echo $this->lang->line('fees_group'); ?></th>
                                                <th>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <?php echo $this->lang->line('fees_code'); ?>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <?php echo $this->lang->line('amount'); ?>
                                                        </div>
                                                    </div>
                                                </th>
                                                <th class="text-right noExport"><?php echo $this->lang->line('action'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(!empty($feebreakups_feegroup)) {
                                                foreach ($feebreakups_feegroup as $feebreakup) {
                                                ?>
                                                <tr>
                                                    <td class="mailbox-name">
                                                        <a href="#" data-toggle="popover" class="detail_popover"><?php echo $feebreakup->group['name']; ?></a>
                                                    </td>
                                                    <td class="mailbox-name">
                                                        <ul class="liststyle1">
                                                                    <li> 
                                                                        <div class="row">
                                                                            <div class="col-md-6"> 
                                                                                <?php 
                                                                                    echo $feebreakup->breakup['name'] 
                                                                                ?>
                                                                            </div>
                                                                            <div class="col-md-3"> 
                                                                            <?php 
                                                                                echo $currency_symbol.amountFormat($feebreakup->amount); 
                                                                            ?>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                            
                                                            </ul>
                                                    </td>
                                                    <td class="mailbox-date pull-right">
                                                        <?php if ($this->rbac->hasPrivilege('fees_group_assign', 'can_view')) { ?>
                                                            <a href="<?php echo base_url(); ?>admin/feebreakups/edit/<?php echo $feebreakup->id ?>"   data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                        <?php } ?>
                                                        <?php if ($this->rbac->hasPrivilege('fees_master', 'can_delete')) { ?>
                                                            <a href="<?php echo base_url(); ?>admin/feebreakups/delete/<?php echo $feebreakup->id ?>" data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');">
                                                                <i class="fa fa-remove"></i>
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table><!-- /.table -->
                                </div>  
                            </div><!-- /.mail-box-messages -->
                        </div><!-- /.box-body -->
                        </form>
                    </div>
                </div><!--/.col (right) -->
            </div><!--/.col (right) -->
            <!-- left column -->
        <?php } ?>
        <!-- left column -->
</div>
<script type="text/javascript">
    $(document).on('change', '#fee_groups_id', function() {
        $('form#feebreakupsform').submit();
    })
</script>