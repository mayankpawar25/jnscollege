<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#424242" />
    <title><?php echo $this->setting_model->get_appname(); ?></title>
    <!--favican-->
    <link href="<?php echo base_url(); ?>uploads/school_content/admin_small_logo/<?php $this->setting_model->getAdminsmalllogo(); ?>" rel="shortcut icon" type="image/x-icon">
    <!-- CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/css/form-elements.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/css/style.css">
    <!-- <style type="text/css">

            body{background:linear-gradient(to right,#676767 0,#dadada 100%);}
        </style> -->
</head>

<body>
    <!-- Top content -->
    <div class="top-content">
        <div class="inner-bg">
            <div class="container-fluid">
                <div class="row">
                    <div class="bgoffsetbg">
                        <div class="col-lg-4 col-md-4 col-sm-12 nopadding">
                            <div class="loginbg">
                                <div class="form-top">
                                    <div class="form-top-left logowidth">
                                        <img  src="<?php echo base_url(); ?>uploads/school_content/admin_logo/<?php echo $this->setting_model->getAdminlogo(); ?>" />
                                    </div>
                                </div>


                                <div class="form-bottom">
                                    <h1>Contact Us</h1>

                                    <!-- Contact us page here -->
                                    <div>
                                        <h3><b>Address:</b> JNS Shaskiya Snatkottar Mahavidhyalay, Shujalpur, Madhya Pradesh</h3>
                                        <h3><b>Registration No:</b> 1382</h3>
                                        <h3><b>Phone No:</b> 07360-244358</h3>
                                        <h3><b>Email:</b> hegjnscshushg@mp.gov.in</h3>
                                    </div>







                                    <h3 class="font-white bolds"><?php echo $this->lang->line('reset_password'); ?></h3>

                                    <?php
                                    if (isset($error_message)) {
                                        echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                                    }
                                    ?>
                                    <!-- <form action="<?php echo site_url('user/resetpassword/' . $role . '/' . $verification_code) ?>" method="post">
                                        <?php echo $this->customlib->getCSRF(); ?>
                                        <div class="form-group has-feedback">
                                            <label class="sr-only"><?php echo $this->lang->line('password'); ?></label>
                                            <input type="password" name="password" placeholder="<?php echo $this->lang->line('password'); ?>" class="form-password form-control" id="form-password">
                                            <span class="fa fa-lock form-control-feedback"></span>
                                            <span class="text-danger"><?php echo form_error('password'); ?></span>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label class="sr-only"><?php echo $this->lang->line('confirm_password'); ?></label>
                                            <input type="password" name="confirm_password" placeholder="<?php echo $this->lang->line('confirm_password'); ?>" class="form-control" id="form-confirm_password">
                                            <span class="fa fa-lock form-control-feedback"></span>
                                            <span class="text-danger"><?php echo form_error('confirm_password'); ?></span>
                                        </div>
                                        <button type="submit" class="btn"><?php echo $this->lang->line('submit'); ?></button>
                                    </form> -->
                                    <!-- <a href="<?php echo site_url('site/userlogin') ?>" class="forgot"><i class="fa fa-key"></i> <?php echo $this->lang->line('user_login'); ?></a> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 nopadding-2">
                        <div class="d-flex align-items-center text-wrap flex-column justify-content-center bg-position-sm-left bg-position-lg-center" style="background: url('<?php echo base_url(); ?>uploads/school_content/login_image/<?php echo $school['user_login_page_background']; ?>') no-repeat; background-size:cover"> 
                                <div class="<?php if ($notice) { ?> bg-shadow-remove <?php } ?>">
                                    <?php
                                    if ($notice) {
                                    ?>

                                        <h3 class="h3"><?php echo $this->lang->line('whats_new_in'); ?> <?php echo $app_name[0]['name']; ?> </h3>
                                        <div class="loginright mCustomScrollbar">
                                            <div class="messages">

                                                <?php
                                                foreach ($notice as $notice_key => $notice_value) {
                                                ?>
                                                    <h4><?php echo $notice_value['title']; ?></h4>

                                                    <?php
                                                    $string = ($notice_value['description']);
                                                    $string = strip_tags($string);
                                                    if (strlen($string) > 100) {

                                                        // truncate string
                                                        $stringCut = substr($string, 0, 100);
                                                        $endPoint  = strrpos($stringCut, ' ');

                                                        //if the string doesn't contain any space then it will cut without word basis.
                                                        $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                        $string .= '... <a class=more href="' . site_url('read/' . $notice_value['slug']) . '" target="_blank">' . $this->lang->line('read_more') . '  </a>';
                                                    }
                                                    echo '<p>' . $string . '</p>';
                                                    ?>

                                                    <div class="logdivider"></div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div><!--./col-lg-6-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Javascript -->
</body>

</html>