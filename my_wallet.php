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
              <h4>Manage Wallet</h4>
              <div class="row">

                  <div class="col-sm-7">
                      <div class="card">
                          <div class="card-header card-header-primary">
                                <h4 class="card-title">My Wallet</h4>
                              <p class="card-category">View And Manage Wallet Trasactions</p>

                          </div>
                          <div class="card-body">
                              <div class="alert alert-success alert-dismissible fade show" role="alert">
                                  <strong>Good Day</strong> Your Wallet Balance is $<?=$_SESSION["balance"]?>.
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <form class="form" id="top_up" name="top_up">

                                  <div class="form-group">
                                      <label for="pwd">Top Up Amount</label>
                                      <input type="number" class="form-control" id="amount" min="10" max="1000" step="any" name="amount"placeholder="250">
                                  </div>

                                  <button type="submit" class="btn btn-primary">Top Up Wallet</button>
                              </form>
                          </div>
                          <hr/>

                          <div id="paynow_init_response">

                              <div id="paynow_init_spinner" style="display: none" class="alert alert-warning alert-dismissible fade show" role="alert">
                                  <strong>Initiating...</strong> Please Wait While we initiate your transaction...
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>

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


        if(amount<100 || amount>999){

            swal({
                title: "Failed!! ",
                text: "Amount should be between 100 - 999",
                icon: "error",
            });

        }else{


            $("#paynow_init_spinner").css("display", "block");
            $("#top_up").css("display", "none");


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
                            "<button class='btn btn-sm btn-success'>Got to Paynow and Pay $ "+data.amount+" </button>" +
                            "</a>";

                        $("#paynow_init_spinner").css("display", "none");

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

        }





    })
</script>