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
                        <h4 class="card-title">Login</h4>
                        <p class="card-category">Complete the Details and Login</p>
                    </div>
                    <div class="card-body">
                        <form method="post" id="user_login" name="user_login">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Email Address</label>
                                        <input type="email" id="email" name="email" class="form-control">
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Password</label>
                                        <input type="password" name="password" id="password" class="form-control">
                                    </div>
                                </div>


                            </div>
                            <button type="submit" class="btn btn-primary pull-right">Login</button>
                            <button type="submit" class="btn btn-warning pull-left">
                                <a href="register">    Create Account</a>
                            </button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
+


        </div>
    </div>
</div>

<?php require_once "bottom.php"?>

<script>
    $(document).on('submit', "#user_login", function (e) {

        e.preventDefault();


        let email = $('#email').val();
        let password = $('#password').val();


        const  data= {

            email:email,
            password:password
        };

        $.ajax({

            type:'POST',
            url:'assets/moab/php/login_user.php',
            data:data,
            dataType:'JSON',
            success:function (data) {

                if(data.success){

                        window.location.href="dash";
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
