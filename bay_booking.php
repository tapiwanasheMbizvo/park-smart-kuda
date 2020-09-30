<?php
/**
 * Created by PhpStorm.
 * User: tapiwanashem
 * Date: 18/4/2020
 * Time: 13:09
 */


?>

<?php require_once "header.php";?>

<div class="content">

    <div class="container-fluid">
        <h4>Bookings</h4>
        <div class="row">

            <div class="col-sm-7">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Book A Parking Bay</h4>
                        <p class="card-category">Book A Bay</p>

                    </div>
                    <div class="card-body">

                        <form class="form" id="top_up" name="top_up">

                            <div class="form-group">
                                <label for="pwd">Select Car</label>

                                <select class="form-control" id="car_list">

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="pwd">Select Street Name</label>

                                <select class="form-control" id="list_bays">

                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Book Bay</button>
                        </form>
                    </div>
                    <hr/>

                    <div id="paynow_init_response">



                    </div>


                </div>
            </div>




        </div>
    </div>

</div>


<?php require_once "bottom.php"; ?>
<script>

    loadCars();

    loadStreets();
    function loadCars(){
        $("#table_cars").innerHTML=" ";
        console.log("LOADING CARS");
        $.ajax({
            url: "assets/moab/php/get_cars.php",
            type: 'GET',
            success: function(res) {
                console.log(res);



                res.forEach(function (car) {



                    const car_option = "<option value=' "+car.vehicle_id+" '>"+car.model_name+"</option>";

                    $("#car_list").append(car_option);


                })
                //console.log(res.data);

            }
        });

    }

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



                    const list_item = "<option value='"+street.street_id+"'>"+street.street_name+"</option>";

                    $("#list_bays").append(list_item);
                })
                //console.log(res.data);

            }
        });

    }


</script>