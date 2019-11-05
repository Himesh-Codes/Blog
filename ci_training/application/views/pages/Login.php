 <!DOCTYPE html>
<html>
    <head>
            <title>Personal Blog</title>
            <!----------------- Bootstrap CSS ------------------->
            <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/third_party/bootstrap.min.css">
            <!----------------- Fontawsome CSS ------------------>
             <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/third_party/font-awesome.min.css">
            <!----------------- Bootstrap JS ------------------>
            <script defer type="text/javascript" src="<?php echo base_url(); ?>assets/js/third_party/jquery.min.js"></script>
            <script defer type="text/javascript" src="<?php echo base_url(); ?>assets/js/third_party/popper.min.js"></script>
            <script defer type="text/javascript" src="<?php echo base_url(); ?>assets/js/third_party/bootstrap.min.js"></script>
    
            <!---------------- User defined CSS ---------------->
            <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/blog.css">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/index.css">
            <!---------------- User defined JS ----------------->
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/blog.js"></script>

    </head>
    <body> 
         <div class="container-fluid">
            <div class="title-container">
                <h1><?php echo $page_title?></h1>
            </div>
            <!--********** Form Section  **********-->
            <div class="inner-container">
                <div class="login-container">
                    <div class="errors">
                        <?php
                            //message for uauthorised entry 
                            if ($this->session->has_userdata('unauthorised') == TRUE) 
                            {
                                echo  $this->session->unauthorised;
                            }

                                //message for account creation
                                if ($this->session->flashdata('success_account') == TRUE) 
                                {
                                    echo "<p class='success'>";
                                    echo $this->session->flashdata('success_account');
                                    echo "</p>";
                                }
                            ?>
                    </div>
                  <div class="input-area">
                    <!-- ***** Form Begins ****** -->
                    <?php echo form_open('user/index'); ?>
                       <!-- ******** Username Section ********* --> 
                       <div class="input-section">
                            <h5 class="input-text"><label for="username">Username</label>
                            <span class="errors">
                                <?php 
                                        echo "*";
                                ?>
                            </span></h5>
                            <div class="row">
                                <div class="col-sm-12 col-lg-2">
                                    <p class="icon-align"><i class="fa fa-user" aria-hidden="true"></i></p>
                                </div>
                                <div class="col-sm-12 col-lg-10">
                                    <input type="text" name="username"  class="form-control float-right">
                                    <div class="errors">
                                        <?php echo form_error('username'); ?> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ******Passsword section****** -->
                        <div class="input-section">
                            <h5 class="input-text"><label for="password">Password</label>
                            <span class="errors">
                                <?php 
                                        echo "*";
                                ?>
                            </span></h5>
                            <div class="row">
                                <div class="col-sm-12 col-lg-2">
                                    <p class="icon-align"><i class="fa fa-unlock-alt" aria-hidden="true"></i></p>
                                </div>
                                <div class="col-sm-12 col-lg-10">
                                    <input type="password" name="password" class="form-control float-right">
                                    <div class="errors">
                                        <?php echo form_error('password'); ?> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="<?php echo base_url(); ?>profile/registration/1">Not Yet Registered?</a>
                            <input type="submit" name="submit" class="login-button float-right" value="Submit" />
                        </div>
                    </form>
                  </div>
                </div>
            </div>