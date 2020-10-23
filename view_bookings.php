<!--
=========================================================
Material Dashboard - v2.1.2
=========================================================

Product Page: https://www.creative-tim.com/product/material-dashboard
Copyright 2020 Creative Tim (https://www.creative-tim.com)
Coded by Creative Tim

=========================================================
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<?php

$streets=0;

?>
<?php  require_once  "header.php";?>

      <!-- End Navbar -->
      <div class="content">

          <div class="container-fluid">
              <h4>View Bookings Users</h4>
              <div class="row">



                  <div class="col-sm-7">


                      <div class="card">
                          <div class="card-header card-header-primary">
                              <h4 class="card-title">Bookings</h4>
                              <p class="card-category">View Parking Bookings </p>
                          </div>
                          <div class="card-body">

                              <div class="table-responsive">
                                  <table class="table">
                                      <thead class=" text-primary">

                                      <tr>
                                            <th>Vehicle Identification</th>
                                            <th>Booked On</th>
                                            <th>Bay Code</th>
                                          <th>Time In</th>
                                          <th>Time Out</th>
                                      </tr>

                                      </thead>

                                      <tbody id="table_bookings">

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



    loadBookings();
    function loadBookings(){
        $("#table_bookings").innerHTML=" ";
        console.log("LOADING Bookings");
        $.ajax({
            url: "assets/moab/php/get_bookings.php",
            type: 'GET',
            success: function(res) {
               // console.log(res);

                const results = res;

                results.forEach(function (booking) {
               // <i class='material-icons'>aspect_ratio</i>
                 //   console.log(street)

                    const booking_row = "<tr>" +
                        "<td>"+booking.license_number+"</td>" +
                        "<td>"+booking.booked_on+"</td>"+
                        "<td>"+booking.bay_code+"</td>"+
                        "<td>"+booking.start_date+"</td>"+
                        "<td>"+booking.end_date+"</td>"+
                        "</tr>";

                    $("#table_bookings").append(booking_row);


                })
                //console.log(res.data);

            }
        });

    }


    function listBays(){

        $.ajax({

            url:"assets/moab/php/get_bays.php",
            type:'GET',
            success:function (response) {

                const  results = response;

                results.forEach(function (bay) {


                    //const bay_row = "<option value='"+bay.bay_id+"'>"+bay.bay_code+"</option>"
                })
            }
        })

    }



    function streetBays(){



        $("#table_bays").empty();
        let street_id = $('#list_bays').val();

        const  data= {


            street_id:street_id
        };

        $.ajax({

            type:'POST',
            url:'assets/moab/php/get_bays.php',
            data:data,
            dataType:'JSON',
            success:function (data) {

                data.forEach(function (bay) {

                    const bay_row = "<tr>" +
                        "<td>"+bay.bay_code+"</td>" +
                        "<td>"+bay.status+"</td>"+
                        "</tr>";

                    $("#table_bays").append(bay_row);


                });



            },
            error:function (txt) {

                swal({
                    title: "Failed!! ",
                    text: txt,
                    icon: "error",
                });
            }



        });

    }

    $(document).on('submit', "#add_street", function (e) {

        e.preventDefault();


        let street = $('#street').val();
        let slots = $('#slots').val();


        const  data= {

            slots:slots,
            street_name:street
        };

        $.ajax({

            type:'POST',
            url:'assets/moab/php/add_street.php',
            data:data,
            dataType:'JSON',
            success:function (data) {

                if(data.success){
                    console.log("YAY WE DONE IT");

                    const new_street = "<tr>" +
                        "<td>"+street+"</td>" +
                        "<td>"+slots+"</td>" +
                        "</tr>";

                    $("#table_streets").append(new_street);
                    //loadStreets();

                }else{

                    // alert(data.error);

                    swal({
                        title: "Failed!! ",
                        text: data.error,
                        icon: "error",
                    });
                }
            },
            error:function (txt) {

                swal({
                    title: "Failed!! ",
                    text: txt,
                    icon: "error",
                });
            }



        });



    })
</script>
