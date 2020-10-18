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
              <h4>Manage Users</h4>
              <div class="row">



                  <div class="col-sm-7">


                      <div class="card">
                          <div class="card-header card-header-primary">
                              <h4 class="card-title">Users</h4>
                              <p class="card-category">View and Manage Parking Users </p>
                          </div>
                          <div class="card-body">

                              <div class="table-responsive">
                                  <table class="table">
                                      <thead class=" text-primary">

                                      <tr>
                                            <th>User Name</th>
                                            <th>Email</th>
                                          <th>Options</th>
                                      </tr>

                                      </thead>

                                      <tbody id="table_users">

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



    loadUsers();
    function loadUsers(){
        $("#table_users").innerHTML=" ";
        console.log("LOADING STRRETS")
        $.ajax({
            url: "assets/moab/php/get_users.php",
            type: 'GET',
            success: function(res) {
               // console.log(res);

                const results = res;

                results.forEach(function (user) {
               // <i class='material-icons'>aspect_ratio</i>
                 //   console.log(street)

                    const user_row = "<tr>" +
                        "<td>"+user.first_name+" "+user.last_name+"</td>" +
                        "<td>"+user.email+"</td>"+
                        "<td>" +
                        "<button class='btn-sm btn-primary'><i class='material-icons'>edit</i></button>" +
                        "<button class='btn-sm btn-danger'><i class='material-icons'>preview</i></button>" +
                        "</td>"+
                        "</tr>";

                    $("#table_users").append(user_row);


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
