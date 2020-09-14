<?php
/**
 * Created by PhpStorm.
 * User: tapiwanashem
 * Date: 18/4/2020
 * Time: 13:22
 */

?>


<?php require_once "header_auth.php";?>


<div class="content">

    <div class="container-fluid">
        <div class="row">

            <div class="col-md-4 offset-4">
                <div class="card card-profile">
                    <div class="card-avatar">
                        <a href="javascript:;">
                            <img class="img" src="assets/img/faces/park.png">
                        </a>
                    </div>
                    <div class="card-body">
                        <h6 class="card-category text-gray">E-Park</h6>
                        <h4 class="card-title">Parking System </h4>
                        <p class="card-description">
                            Pre-Book ,and pre pay for our City Parking
                        </p>

                    </div>
                </div>
            </div>

        </div>
        <div class="row">

            <div class="col-md-6 offset-3">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Register</h4>
                        <p class="card-category">Complete the Details and Create Account</p>
                    </div>
                    <div class="card-body">
                        <form method="post" id="user_register" name="user_register">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">First Name</label>
                                        <input type="text" id="first_name" name="first_name"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Last Name</label>
                                        <input type="text" id="last_name" name="last_name" class="form-control">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Email Address</label>
                                        <input type="email" id="email" name="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Physical Address</label>
                                        <input type="text" id="address" name="address" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Password</label>
                                        <input type="password" name="password" id="password" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Confirm Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                                    </div>
                                </div>


                            </div>
                            <button type="submit" class="btn btn-primary pull-right">Register</button>
                            <button type="submit" class="btn btn-warning pull-left">
                                <a href="login">Go to Login</a>
                            </button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<?php require_once "bottom.php"?>



<script>
    $(document).on('submit', "#user_register", function (e) {

        e.preventDefault();

        const first_name = $('#first_name').val();
        const last_name = $('#last_name').val();
        const email = $('#email').val();
        const password = $('#password').val();
        const confirm_password = $('#confirm_password').val();
        const address = $('#address').val();

        const  data= {

            first_name:first_name,
            last_name:last_name,
            email:email,
            password:password,
            address:address,
            is_admin:0,
            confirm_password:confirm_password

        };


        $.ajax({

            type:'POST',
            url:'assets/moab/php/create_user.php',
            data:data,
            dataType:'JSON',
            success:function (data) {

                if(data.success){

                    swal({
                        title: "Success",
                        text: "Account was created, redirecting to login",
                        icon: "success",
                    });

                    window.setTimeout(function () {

                        window.location.href="login";
                    }, 2500)


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
    });
</script>
