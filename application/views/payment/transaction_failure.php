<style>
    .status-box {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0px 6px 12px rgba(0, 0, 0, .12);
        margin: 10% auto;
        width: 80%;
        max-width: 420px;
        padding: 32px 0 16px 0;
        text-align: center;
    }

    .iconbox {
        width: 120px;
        height: 120px;
        margin: 0px auto;
        background-color: red;
        border-radius: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .iconbox svg {
        fill: #fff;
    }

    h2 {
        color: red;
        padding: 0px 12px;


    }

    h4 {
        font-size: 16px;
        color: #333;
        line-height: 1.5;
        padding: 0px 12px;

    }

    .hr {
        border: 1px dashed #ddd;
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
                        <div class="status-box">
                            <div class="iconbox">
                                <svg xmlns="http://www.w3.org/2000/svg" height="90px" viewBox="0 -960 960 960" width="90px"
                                    fill="undefined">
                                    <path
                                        d="m251.33-204.67-46.66-46.66L433.33-480 204.67-708.67l46.66-46.66L480-526.67l228.67-228.66 46.66 46.66L526.67-480l228.66 228.67-46.66 46.66L480-433.33 251.33-204.67Z" />
                                </svg>
                            </div>
                            <h2>Payment Failed!</h2>
                            <div class="hr"></div>
                            <h4>Something went wrong. <br>Taking you back home… Please try again!</h4>
                        </div>
                    </div>
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