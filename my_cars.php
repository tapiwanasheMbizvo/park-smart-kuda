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
              <h4>Manage My Cars</h4>
              <div class="row">

                  <div class="col-sm-7">
                      <div class="card">
                          <div class="card-header card-header-primary">
                                <h4 class="card-title">My Cars</h4>
                              <p class="card-category">View And Manage Cars</p>

                          </div>
                          <div class="card-body">
                              <form class="form-inline" id="add_car" name="add_car">
                                  <div class="form-group">
                                      <label for="email">Car Model</label>
                                      <input type="text" class="form-control" id="model_name" name="model_name" placeholder="Toyota Allion">
                                  </div>
                                  <div class="form-group">
                                      <label for="pwd">License Number</label>
                                      <input type="text" class="form-control" id="license_number" name="license_number"placeholder="AXX-8585">
                                  </div>

                                  <button type="submit" class="btn btn-primary">Add Car To Collection</button>
                              </form>
                          </div>
                          <hr/>

                          <div class="table-responsive">

                              <table class="table">
                                  <thead>
                                  <tr>

                                        <th>Car Model</th>
                                        <th>License Number</th>
                                        <th>Actions</th>

                                  </tr>
                                  </thead>
                                  <tbody id="table_cars">



                                  </tbody>
                              </table>

                          </div>
                      </div>
                  </div>


              </div>
          </div>

      </div>





<?php require_once "bottom.php";?>


<script>


    loadCars();
    function loadCars(){
        $("#table_cars").innerHTML=" ";
        console.log("LOADING CARS");
        $.ajax({
            url: "assets/moab/php/get_cars.php",
            type: 'GET',
            success: function(res) {
                console.log(res);



                res.forEach(function (car) {



                    const car_row = "<tr>" +
                        "<td>"+car.model_name+"</td>" +
                        "<td>"+car.license_number+"</td>"+
                        "<td><button class='btn btn-danger btn-sm delbtn' data-id="+car.vehicle_id+">Delete</button></td>"+
                        "</tr>";

                    $("#table_cars").append(car_row);


                })
                //console.log(res.data);

            }
        });

    }



$(document).on('click', '.delbtn', function (e) {

    e.preventDefault();
    let $this = $(this);

    let card_id = ($this.attr("data-id"));


   // alert("GOOD MORNING" +card_id);

    deletecar(card_id);
});

    $(document).on('submit', "#add_car", function (e) {

        e.preventDefault();


        let license_number = $('#license_number').val();
        let model_name = $('#model_name').val();


        if(model_name.length < 4 || model_name.length>20 || license_number<4 || license_number>20){
            swal({
                title: "Error",
                text: "Model name or license number must be between 4-20 characters",
                icon: "warning",
            });


        }else{

            swal({
                title: "Loading",
                text: "Please wait while we do a few checks",
                icon: "warning",
            });

            const  data= {

                model_name:model_name,
                license_number:license_number
            };


            $.ajax({

                type:'POST',
                url:'assets/moab/php/add_car.php',
                data:data,
                dataType:'JSON',
                success:function (data) {

                    if(data.success){
                        console.log("YAY WE DONE IT");

                        swal({
                            title: "Success",
                            text: "Car Has Been Added",
                            icon: "success",
                        });

                        const new_car = "<tr>" +
                            "<td>"+model_name+"</td>" +
                            "<td>"+license_number+"</td>" +
                            "<td><button class='btn btn-danger btn-sm'>Delete</button></td>"+
                            "</tr>";

                        $("#table_cars").append(new_car);
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

        }






    })

    function deletecar(id) {

        const  data= {

            id:id,

        };
        $.ajax({

            type:'POST',
            url:'assets/moab/php/delete_car.php',
            data:data,
            dataType:'JSON',
            success:function (data) {

                if(data.success){

                    //$("#table_cars").innerHTML=" ";
                    $("#table_cars tr").remove();

                    loadCars();

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

    }
</script>
