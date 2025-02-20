<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="content-header">
                <h1>
                    <i class="fa fa-money"></i> <small></small>
                </h1>
            </section>
        </div>
    </div>
    <!-- /.control-sidebar -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-4">
                                <h3 class="box-title">Transaction Status</h3>
                            </div>
                            <div class="col-md-8 ">
                                <!-- <div class="btn-group pull-right">
                                    <a href="<?php echo base_url() ?>user/user/dashboard" type="button" class="btn btn-primary btn-xs">
                                        <i class="fa fa-arrow-left"></i> <?php echo $this->lang->line('back'); ?></a>
                                </div> -->
                            </div>
                        </div>
                    </div><!--./box-header-->

                    <div class="box-body" style="padding-top:0;">
                        <div class="row">
                        <?php
                            if($transaction_status == 'SUCCESS') {
                        ?>
                                <h5>Transaction successfull.</h5>
                        <?php
                            } else if($transaction_status == 'FAIL') {
                                ?>
                                        <h5>Transaction failed.</h5>
                                <?php
                                    }
                        ?>
                            
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <!-- add qr code start -->
                  
                    <!-- <div class="col-md-12">
                        <div class="box box-solid">
                            <div class="box-header ptbnull">
                                <h3 class="box-title titlefix"> Notice Board</h3>
                            </div>
                            <div class="box-body pt0">
                                <div class="alert alert-info">No Record Found</div>

                            </div>
                        </div>
                        <aside class="sidebar-container" role="dialog">
                            <article class="email-collection">
                                <a href="#" class="mail-sidebar mail-close-btn"><i class="fa fa-times fs-2"></i></a>
                                <div id="notificationdata"></div>
                            </article>
                        </aside>
                    </div> -->
                    <!-- add qr code end -->
                </div>
            </div>
            <!--/.col (left) -->
        </div>
    </section>
</div>