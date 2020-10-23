<?php
/**
 * Created by PhpStorm.
 * User: tapiwanashem
 * Date: 18/4/2020
 * Time: 09:16
 */
error_reporting(E_ERROR | E_PARSE);


if(!isset($_SESSION)){

    session_start();
}


//var_dump(  $_SESSION["user"]);

$user =   $_SESSION["user"];

if(!$_SESSION["is_logged_in"]){

//
    ?>

    <script>
        window.location.href="login";
    </script>
    <?php

}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Smart Parking
    </title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="assets/demo/demo.css" rel="stylesheet" />

    <script src="jsQR.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Ropa+Sans" rel="stylesheet">
</head>

<body class="">
<div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="assets/img/sidebar-1.jpg">
        <!--
          Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

          Tip 2: you can also add an image using data-image tag
      -->
        <div class="logo"><a href="dash" class="simple-text logo-normal">
                E -Park
            </a></div>


        <?php if ($user->is_admin==1){

            ?>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="nav-item active  ">
                        <a class="nav-link" href="dash">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link" href="bays">
                            <i class="material-icons">aspect_ratio</i>
                            <p>Parking Bays</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="view-users">
                            <i class="material-icons">commute</i>
                            <p>Users</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="view-bookings">
                            <i class="material-icons">library_books</i>
                            <p>Bookings</p>
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link" href="logout">
                            <i class="material-icons">flight_takeoff</i>
                            <p>Logout</p>
                        </a>
                    </li>


                </ul>
            </div>


            <?php

        }else{
            ?>

            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="nav-item active  ">
                        <a class="nav-link" href="dash">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link" href="bookings">
                            <i class="material-icons">commute</i>
                            <p>Book A Bay</p>
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link" href="parking">
                            <i class="material-icons">local_parking</i>
                            <p>Parking</p>
                        </a>
                    </li>


                    <li class="nav-item ">
                        <a class="nav-link" href="my-cars">
                            <i class="material-icons">commute</i>
                            <p>My Cars</p>
                        </a>
                    </li>


                    <li class="nav-item ">
                        <a class="nav-link" href="my-wallet">
                            <i class="material-icons">commute</i>
                            <p>My Wallet</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./icons.html">
                            <i class="material-icons">library_books</i>
                            <p>History</p>
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link" href="logout">
                            <i class="material-icons">flight_takeoff</i>
                            <p>Logout</p>
                        </a>
                    </li>


                </ul>
            </div>

            <?php

        }

            ?>




    </div>
    <div class="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <a class="navbar-brand" href="javascript:;">Dashboard</a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end">
                    <form class="navbar-form">
                        <div class="input-group no-border">
                            <input type="text" value="" class="form-control" placeholder="Search...">
                            <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                <i class="material-icons">search</i>
                                <div class="ripple-container"></div>
                            </button>
                        </div>
                    </form>
                    <ul class="navbar-nav">


                        <li class="nav-item dropdown">
                            <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span><?php echo $user->email ?></span>
                                <i class="material-icons">person</i>
                                <p class="d-lg-none d-md-block">
                                    Account
                                </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                <a class="dropdown-item" href="#">Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>