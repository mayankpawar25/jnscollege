<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <?php $this->load->view('setting/_settingmenu'); ?>

            <div class="col-md-10">
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><i class="fa fa-whatsapp"></i> WhatsApp Configuration</h3>
                    </div>

                    <div class="box-body">
                        <?php if (!empty($success_msg)) { ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Success!</strong> <?php echo $success_msg; ?>
                            </div>
                        <?php } ?>

                        <?php if (!empty($error)) { ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Error!</strong> <?php echo $error; ?>
                            </div>
                        <?php } ?>

                        <div class="alert alert-info">
                            <strong>Note:</strong> Configure your WhatsApp Business API credentials here.
                        </div>

                        <form id="whatsapp_form" method="post" action="<?php echo site_url('schsettings/whatsapp'); ?>"
                            role="form">
                            <div class="form-group">
                                <label>WhatsApp Phone Number ID</label>
                                <input type="text" class="form-control" id="whatsapp_phone_id" name="whatsapp_phone_id"
                                    value="<?php echo isset($result->whatsapp_phone_id) ? $result->whatsapp_phone_id : ''; ?>"
                                    placeholder="e.g., 252997184571123" required>
                                <small class="form-text text-muted">Get from Meta Business Manager → WhatsApp
                                    Manager</small>
                            </div>

                            <div class="form-group">
                                <label>WhatsApp Access Token</label>
                                <textarea class="form-control" id="whatsapp_access_token" name="whatsapp_access_token"
                                    rows="4" placeholder="Paste your access token here"
                                    required><?php echo isset($result->whatsapp_access_token) ? $result->whatsapp_access_token : ''; ?></textarea>
                                <small class="form-text text-muted">Get from Meta Business Manager → Settings → System
                                    Users</small>
                            </div>

                            <div class="form-group">
                                <div class="alert alert-warning">
                                    <strong>Security:</strong> Keep your access token secure. Do not share it.
                                </div>
                            </div>

                            <button type="submit" name="save_whatsapp_config" value="1" class="btn btn-primary">
                                <i class="fa fa-save"></i> Save Configuration
                            </button>
                            <a href="<?php echo site_url('schsettings'); ?>" class="btn btn-secondary">Cancel</a>
                        </form>

                        <hr>

                        <div class="alert alert-info">
                            <strong>Status:</strong>
                            <?php if (!empty($result->whatsapp_phone_id) && !empty($result->whatsapp_access_token)) { ?>
                                <span class="label label-success">Configured</span>
                            <?php } else { ?>
                                <span class="label label-danger">Not Configured</span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>