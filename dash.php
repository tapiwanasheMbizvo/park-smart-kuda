<?php

/**
 * Created by PhpStorm.
 * User: tapiwanashem
 * Date: 18/4/2020
 * Time: 08:47
 */


?>


<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">attach_money</i>
                    </div>
                    <p class="card-category">My Wallet</p>
                    <h3 class="card-title">$<?=$_SESSION["balance"]?>

                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons text-danger">success</i>
                        <a href="my-wallet">Go to Wallet</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">store</i>
                    </div>
                    <p class="card-category">View Parking Bays</p>
                    <h3 class="card-title">245</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">date_range</i> Last 24 Hours
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">info_outline</i>
                    </div>
                    <p class="card-category">Pending Fines</p>
                    <h3 class="card-title">$5</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">local_offer</i> Fines Due
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                    <div class="card-icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <p class="card-category">Unread Messages</p>
                    <h3 class="card-title">5</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">update</i> Just Updated
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                    <div class="nav-tabs-navigation">
                        <div class="nav-tabs-wrapper">
                            <span class="nav-tabs-title">My Dash Board:</span>
                            <ul class="nav nav-tabs" data-tabs="tabs">
                                <li class="nav-item">
                                    <a class="nav-link" href="#messages" data-toggle="tab">
                                        <i class="material-icons">payment</i> Transaction History
                                        <div class="ripple-container"></div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#settings" data-toggle="tab">
                                        <i class="material-icons">bookmarks</i> Parking History
                                        <div class="ripple-container"></div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">

                        <div class="tab-pane" id="messages">
                            <table class="table">

                                <thead>
                                        <tr>
                                            <th>Transaction Date</th>
                                            <th>Transaction Amount</th>
                                            <th>Transaction Ref</th>

                                        </tr>
                                </thead>
                                <tbody id="table_txns">


                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="settings">
                            <table class="table">

                                <thead>
                                <tr>
                                    <th>Booking Date</th>
                                    <th>Vehicle </th>
                                    <th>Time IN</th>
                                    <th>Time Out</th>

                                </tr>
                                </thead>
                                <tbody id="table_my_bookings">


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<?php require_once "bottom.php";?>
<script>

    loadTransactions();
    loadBookins();
/*
    $(document).on('submit', "#change_password", function (e) {


        e.preventDefault();


        alert("hey Btches");

    };
*/




    function loadTransactions(){
        $("#table_txns").innerHTML=" ";
        console.log("LOADING TXNS");
        $.ajax({
            url: "assets/moab/php/get_txns.php",
            type: 'GET',
            success: function(res) {
                console.log(res);



               res.forEach(function (txn) {



                    const txn_row = "<tr>" +
                        "<td>"+txn.date_txn+"</td>" +
                        "<td>$"+txn.amount+"</td>"+
                        "<td>"+txn.pollUrl+"</td>"+

                        "</tr>";

                    $("#table_txns").append(txn_row);


                })
                console.log(res.data);

            }
        });

    }

    function loadBookins(){
        $("#table_my_bookings").innerHTML=" ";
        console.log("LOADING Bookings");
        $.ajax({
            url: "assets/moab/php/my_bookings.php",
            type: 'GET',
            success: function(res) {
                console.log(res);



               res.forEach(function (booking) {



                    const booing_row = "<tr>" +
                        "<td>"+booking.booked_on+"</td>" +
                        "<td>"+booking.model_name+" "+booking.license_number+"</td>" +
                        "<td>"+booking.start_date+"</td>"+
                        "<td>"+booking.end_date+"</td>"+

                        "</tr>";

                    $("#table_my_bookings").append(booing_row);


                })
                console.log(res.data);

            }
        });

    }
</script>