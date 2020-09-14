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

if(!isset($_SESSION)){

    session_start();
}
require_once  "assets/moab/Paynow/autoloader.php";


$paynow = new Paynow\Payments\Paynow(
    4593,
    'fd4f95c7-ee88-4814-97b0-1d82961b915e',
    'http://localhost/park/return-paynow',

    // The return url can be set at later stages. You might want to do this if you want to pass data to the return url (like the reference of the transaction)
    'http://localhost/park/result-paynow'
);

//$_SESSION["pollUrl"]= $pollUrl;

$pollUrl = $_SESSION["pollUrl"];


var_dump($pollUrl);

$status = $paynow->pollTransaction($pollUrl);

var_dump($status);

die;

?>
<?php  require_once  "header.php";?>

      <!-- End Navbar -->
      <div class="content">

          <div class="container-fluid">
              <h4>Manage Bays</h4>
              <div class="row">

                  <div class="col-sm-7">
                      <div class="card">
                          <div class="card-header card-header-primary">
                                <h4 class="card-title">Transaction Status Report</h4>
                              <p class="card-category">Review Transaction Status</p>

                          </div>
                          <div class="card-body">

                          </div>
                          <hr/>

                          <div id="paynow_return_response">

                          </div>


                      </div>
                  </div>


              </div>
          </div>

      </div>





<?php require_once "bottom.php";?>


<script>
    $(document).on('submit', "#top_up", function (e) {

        e.preventDefault();


        let amount = $('#amount').val();



        const  data= {

            amount:amount
        };

        $.ajax({

            type:'POST',
            url:'assets/moab/php/paynow_init.php',
            data:data,
            dataType:'JSON',
            success:function (data) {

            console.log(data);

            if(data.response.success){

               /* swal({
                    title: "Good!! ",
                    text: "Well zvaita oo link"+data.link,
                    icon: "success",
                });*/


               const new_html = "<a href='"+data.link+"'>" +
                   "<button class='btn btn-sm btn-success'>Got to Paynow </button>" +
                   "</a>"

                $("#paynow_init_response").append(new_html);
               
            }else{

                swal({
                    title: "Failed!! ",
                    text: data.response.status,
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