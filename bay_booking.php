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

                        <form class="form" id="book_bay" name="book_bay">

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

                            <div class="form-group">
                                <label for="pwd">Time In</label>

                                <input type="datetime-local" class="form-control" id="time_in" name="time_in"/>

                            </div>

                            <div class="form-group">
                                <label for="pwd">Time Out</label>

                                <input type="datetime-local" class="form-control" id="time_out" name="time_out"/>

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

    $(document).on('submit', "#book_bay", function (e) {

        e.preventDefault();
        let car_id = $('#car_list').val();
        let bay_id = $('#list_bays').val();

        let time_in = $('#time_in').val();
        let time_out = $('#time_out').val();
        //alert("hey BITCHES");

        var new_in = new Date(time_in);
        var new_out = new Date(time_out);


        var diffrence = new_out-new_in;

         var msec = diffrence;

        var hh = Math.floor(msec / 1000 / 60 / 60);
        msec -= hh * 1000 * 60 * 60;
        var mm = Math.floor(msec / 1000 / 60);
        msec -= mm * 1000 * 60;
        var ss = Math.floor(msec / 1000);
        msec -= ss * 1000;


        //console.log("Difference is "+diffrence);
        console.log("Difference in real time its  "+hh+" hours ,"+mm+" minutes and "+ss+" seconds" );

       // console.log(new_out.getTime()>new_in.getTime());

   if(Date.parse(time_out)>Date.parse(time_in)){

        //yay we are good

       if(hh<8){

           //lets make a booking now

           bookBay(bay_id, car_id, time_in, time_out);

       }else{

           swal({
               title: "Failed!! ",
               text: "You can only book for a max of 8 hours",
               icon: "error",
           });
       }

    }else{

       swal({
           title: "Failed!! ",
           text: "Time in is later than time out, Please edit and try again",
           icon: "error",
       });

    }




        //bookBay(bay_id, car_id, time_in, time_out);
    });



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



                    const car_option = "<option value=' "+car.vehicle_id+" '>"+car.model_name +"  "+car.license_number +" </option>";

                    $("#car_list").append(car_option);


                })
                //console.log(res.data);

            }
        });

    }


    function bookBay(bay_id, car_id, time_in, time_out) {

        //alert(bay_id+car_id+time_in+time_out);

        const  data= {

            bay_id:bay_id,
            car_id:car_id,
            time_in:time_in,
            time_out:time_out,
        };

        $.ajax({

            type:'POST',
            url:'assets/moab/php/book_bay.php',
            data:data,
            dataType:'JSON',
            success:function (data) {

                if(data.success){

                  //  window.location.href="dash";
                    swal({
                        title: "Success",
                        text: "Bay has Been Booked!",
                        icon: "success",
                    });

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

   // alert("hey BITCHES  2");

</script>


