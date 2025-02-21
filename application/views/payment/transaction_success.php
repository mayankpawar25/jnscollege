<style>
    body{
        background-color: #f3f2f1;
        margin: 0px;
        padding: 0px;
        font-family: Arial, Helvetica, sans-serif;
    }
    .status-box{
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0px 6px 12px rgba(0,0,0,.12);
        margin: 10% auto;
        width: 80%;
        max-width: 420px;
        padding: 32px 0 16px 0;
        text-align: center;
    }
    .iconbox{
        width: 120px;
        height: 120px;
        margin: 0px auto;
        background-color: #2cce2c;
        border-radius: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .iconbox svg{
        fill: #fff;
    }
    h2{
        color: #2cce2c;
        padding: 0px 12px;

    }
    h4{
        font-size: 16px;
        color: #333;
        line-height: 1.5;
        padding: 0px 12px;
    }
    .hr{
        border:1px dashed #ddd;
    }
</style>
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
                            <div class="status-box">
                                <div class="iconbox">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="90px" viewBox="0 -960 960 960" width="90px" fill="undefined"><path d="M378-246 154-470l43-43 181 181 384-384 43 43-427 427Z"/></svg>
                                </div>
                                <h2>Payment Successful!</h2>
                                <div class="hr"></div>
                                <h5><b>You order id : <?php echo $order_id;?></b></h5>
                                <h4>Your payment has been processed successfully.<br> Taking you back home… Hang tight!</h4>
                            </div>
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
<script>
    setTimeout(function () {
        window.location.href = '<?php echo base_url().'user/user/getfees'; ?>'
    }, 5000);
</script>