<?php
/**
 * Created by PhpStorm.
 * User: tapiwanashem
 * Date: 18/4/2020
 * Time: 13:09
 */


?>

<?php require_once "header.php";?>
<style type="text/css">
    #results { padding:20px; border:1px solid; background:#ccc; }
</style>
<div class="content">

    <div class="container-fluid">
        <h4>Parking</h4>
        <div class="row">

            <div class="col-sm-7">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Car Detection</h4>
                        <p class="card-category">Book A Bay</p>

                    </div>
                    <div class="card-body">

                        <form method="POST" action="storeImage.php">
                            <div class="row">
                                <div class="col-md-6">
                                    <div id="my_camera"></div>
                                    <br/>
                                    <input type=button value="Take Snapshot" onClick="take_snapshot()">
                                    <input type="hidden" name="image" id="the_image" class="image-tag">
                                </div>
                                <div class="col-md-6">
                                    <div id="results">Your captured image will appear here...</div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <br/>
                                    <button class="btn btn-success">Submit</button>
                                </div>
                            </div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script src='https://unpkg.com/tesseract.js@v2.1.0/dist/tesseract.min.js'></script>

<script language="JavaScript">
    Webcam.set({
        width: 490,
        height: 390,
        image_format: 'jpeg',
        jpeg_quality: 90
    });

    Webcam.attach( '#my_camera' );

    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);

            const the_image = $("#the_image").val();

            Tesseract.recognize(
               // 'https://tesseract.projectnaptha.com/img/eng_bw.png',
                the_image,
                'eng',
                { logger: m => console.log(m) }
            ).then(({ data: { text } }) => {
                console.log(text);
            });
            //console.log("THE IMAGE"+the_image);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    }
</script>