<!DOCTYPE html>
<html>
    <head>
            <title>Personal Blog</title>
            <!----------------- Bootstrap CSS ------------------->
            <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/third_party/bootstrap.min.css">
            <!----------------- Fontawsome CSS ------------------>
             <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
            <!----------------- Bootstrap JS ------------------>
            <script defer type="text/javascript" src="<?php echo base_url(); ?>assets/js/third_party/jquery.min.js"></script>
            <script defer type="text/javascript" src="<?php echo base_url(); ?>assets/js/third_party/popper.min.js"></script>
            <script defer type="text/javascript" src="<?php echo base_url(); ?>assets/js/third_party/bootstrap.min.js"></script>
            <!------------------ SET GLOBAL BASE URL ------------>
            <script>var base_url = '<?php echo base_url() ?>';</script>

    
            <!---------------- User defined CSS ---------------->
            <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/blog.css">
            <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/index.css">
            <!---------------- User defined JS ----------------->
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/blog.js"></script>

    </head>
    <body> 
            <div class="container-fluid">
                <?php
                    if(checkLogin() == TRUE)
                    {
                ?>
                <!-----------Navigation links --------->
                <div class="d-flex nav-contain">
                    <div class="p-2 navlinks"><a href="<?php echo base_url();?>blog/home">Home</a></div>
                        <div class="p-2 navlinks"><a href="<?php echo base_url();?>profile/user_profile">Profile</a></div>
                        <div class="p-2 navlinks"><a href="<?php echo base_url();?>file">File</a></div>
                        <div class="p-2 ml-auto navlinks"><span><?php echo $_SESSION['username']."("; echo $_SESSION['user_role'].")<br>";?></span><a href="<?php echo base_url();?>user/logout">Logout</a></div>
                </div>
                <?php
                    }
                ?>
                <div class="title-container">
                    <h1><?=$page_title?></h1>
                </div>
                  
                
            
