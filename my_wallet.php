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

                  <div class="col-sm-7">
                      <div class="card">
                          <div class="card-header card-header-primary">
                                <h4 class="card-title">My Wallet</h4>
                              <p class="card-category">View And Manage Wallet Trasactions</p>

                          </div>
                          <div class="card-body">
                              <form class="form" id="top_up" name="top_up">

                                  <div class="form-group">
                                      <label for="pwd">Top Up Amount</label>
                                      <input type="number" class="form-control" id="amount" min="100" max="1000" step="10" name="amount"placeholder="AXX-8585">
                                  </div>

                                  <button type="submit" class="btn btn-primary">Top Up Wallet</button>
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