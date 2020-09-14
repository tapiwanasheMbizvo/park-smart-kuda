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
              <h4>Manage Bays</h4>
              <div class="row">

                  <div class="col-sm-5">
                      <div class="card">
                          <div class="card-header card-header-primary">
                                <h4 class="card-title">Streets</h4>
                              <p class="card-category">View And Manage Streets</p>

                          </div>
                          <div class="card-body">
                              <form class="form-inline" id="add_street" name="add_street">
                                  <div class="form-group">
                                      <label for="email">Street Name</label>
                                      <input type="text" class="form-control" id="street" name="street">
                                  </div>
                                  <div class="form-group">
                                      <label for="pwd">No.of Bays</label>
                                      <input type="number" class="form-control" min="5" max="10" id="slots" name="slots">
                                  </div>

                                  <button type="submit" class="btn btn-primary">Add Street</button>
                              </form>
                          </div>
                          <hr/>

                          <div class="table-responsive">

                              <table class="table">
                                  <thead>
                                  <tr>

                                        <th>Name</th>
                                        <th>Total Bays</th>

                                  </tr>
                                  </thead>
                                  <tbody id="table_streets">


                                  </tbody>
                              </table>
                          </div>
                      </div>
                  </div>

                  <div class="col-sm-7">


                      <div class="card">
                          <div class="card-header card-header-primary">
                              <h4 class="card-title">Parking Bays</h4>
                              <p class="card-category">View and Manage Parking Bays </p>
                          </div>
                          <div class="card-body">

                              <span>Select Street To View Bays </span>
                              <select class="form-control" id="list_bays">

                              </select>
                              <div class="table-responsive">
                                  <table class="table">
                                      <thead class=" text-primary">

                                      <tr>
                                            <th>Parking Bay Code</th>
                                            <th>Status</th>
                                      </tr>

                                      </thead>

                                      <tbody id="table_bays">

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


    loadStreets();
    function loadStreets(){
        $("#table_streets").innerHTML=" ";
        console.log("LOADING STRRETS")
        $.ajax({
            url: "assets/moab/php/get_streets.php",
            type: 'GET',
            success: function(res) {
               // console.log(res);

                const results = res;

                results.forEach(function (street) {

                 //   console.log(street)

                    const street_row = "<tr>" +
                        "<td>"+street.street_name+"</td>" +
                        "<td>"+street.slots+"</td>"+
                        "</tr>";

                    $("#table_streets").append(street_row);

                    const list_item = "<option value='"+street.street_id+"'>"+street.street_name+"</option>";

                    $("#list_bays").append(list_item);
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
