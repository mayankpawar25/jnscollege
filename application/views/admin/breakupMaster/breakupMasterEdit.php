<style type="text/css">
    .liststyle1 {
        margin: 0;
        list-style: none;
        line-height: 28px;
    }
</style>

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
            <?php if ($this->rbac->hasPrivilege('fees_master', 'can_add')) {
                ?>
                <div class="col-md-4">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $this->lang->line('add_breakup_list') . " : " . $this->setting_model->getCurrentSessionName(); ?></h3>
                        </div><!-- /.box-header -->
                        <form id="form1" action="<?php echo site_url("admin/breakupmaster/edit/". $id) ?>"  id="breakupsform" name="breakupsform" method="post" accept-charset="utf-8">
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php 
                                        echo $this->session->flashdata('msg');
                                        $this->session->unset_userdata('msg');
                                    ?>
                                <?php } ?>
                                <?php echo $this->customlib->getCSRF(); ?>
                                <input name="id" type="hidden" class="form-control"  value="<?php echo set_value('id', $breakup_data['id']); ?>" />
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputbreakup1"><?php echo $this->lang->line('breakup_name'); ?></label> <small class="req">*</small>
                                            <input id="breakup_name" name="breakup_name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('breakup_name', $breakup_data['name']); ?>" />
                                            <span class="text-danger"><?php echo form_error('breakup_name'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>
                </div><!--/.col (right) -->
                <!-- left column -->
            <?php } ?>
            <div class="col-md-<?php
            if ($this->rbac->hasPrivilege('fees_master', 'can_add')) {
                echo "8";
            } else {
                echo "12";
            }
            ?>">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('breakup_list') . " : " . $this->setting_model->getCurrentSessionName(); ?></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="download_label"><?php echo $this->lang->line('breakup_list') . " : " . $this->setting_model->getCurrentSessionName(); ?></div>
                        <div class="mailbox-messages">
                            <div class="">  
                                <table class="table table-striped table-bordered table-hover example">
                                    <thead>
                                        <tr>
                                            <th><?php echo $this->lang->line('breakup_name'); ?></th>
                                            <th class="text-right noExport"><?php echo $this->lang->line('action'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($breakups as $breakup) {
                                            ?>
                                            <tr>
                                                <td class="mailbox-name">
                                                    <a href="#" data-toggle="popover" class="detail_popover"><?php echo $breakup['name']; ?></a>
                                                </td>
                                                <td class="mailbox-date pull-right">
                                                    <?php
                                                    if ($this->rbac->hasPrivilege('fees_group', 'can_edit')) {
                                                        ?>
                                                        <a href="<?php echo base_url(); ?>admin/breakupmaster/edit/<?php echo $breakup['id'] ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    <?php } ?>
                                                    <?php
                                                    if ($this->rbac->hasPrivilege('fees_group', 'can_delete')) {
                                                        ?>
                                                        <a href="<?php echo base_url(); ?>admin/breakupmaster/delete/<?php echo $breakup['id'] ?>"class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');">
                                                            <i class="fa fa-remove"></i>
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
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
            <!-- left column -->
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<script type="text/javascript">
    $(document).ready(function () {
        var account_type = "<?php echo set_value('account_type', 0); ?>";
        load_disable(account_type);
    });

    $(document).on('change', '.finetype', function () {
        calculatefine();
    });

    $(document).on('keyup', '#amount,#fine_percentage', function () {
        calculatefine();
    });

    function load_disable(account_type) {
        if (account_type === "percentage") {
             $('#due_date_error').html(' *');
            $('#fine_amount').prop('readonly', true);
            $('#fine_percentage').prop('readonly', false);
        } else if (account_type === "fix") {
             $('#due_date_error').html(' *');
            $('#fine_amount').prop('readonly', false);
            $('#fine_percentage').prop('readonly', true);
        } else {
            $('#due_date_error').html('');
            $('#fine_amount').prop('readonly', true);
            $('#fine_percentage').prop('readonly', true);
        }
    }

    function calculatefine() {
        var amount = $('#amount').val();
        var fine_percentage = $('#fine_percentage').val();
        var finetype = $('input[name=account_type]:checked', '#form1').val();
        if (finetype === "percentage") {
             $('#due_date_error').html(' *');
            fine_amount = ((amount * fine_percentage) / 100).toFixed(2);
            $('#fine_amount').val(fine_amount).prop('readonly', true);
            $('#fine_percentage').prop('readonly', false);
        } else if (finetype === "fix") {
             $('#due_date_error').html(' *');
            $('#fine_amount').val("").prop('readonly', false);
            $('#fine_percentage').val("").prop('readonly', true);
        } else {
             $('#due_date_error').html('');
            $('#fine_amount').val("");
            $('#fine_percentage').val("");
            $('#fine_amount').prop('readonly', true);
            $('#fine_percentage').prop('readonly', true);
        }
    }

    $(document).ready(function () {
        $('.detail_popover').popover({
            placement: 'right',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function () {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });
    });
</script>