<?php
include("./database/db.php");

include("./layout/header.php");

?>

<section class="contact_section layout_padding">
    <div class="container">
        <div class="heading_container" id="contact">
            <h2>Contact Us</h2>
        </div>
        <div class="row">
            <div class="col-md-6 p-5  shadow rounded-lg bg-light">
                <form action="../index.php" method="post">
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Name" />
                    </div>
                    <div class="mb-3">
                        <input type="text" name="phone"class="form-control" placeholder="Phone Number"  />
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" />
                    </div>
                    <div class="mb-3">
                        <input type="text" name="message" class="form-control" placeholder="Message" />
                    </div>
                    <div class="d-flex">
                        <button type="submit"  class="btn btn-primary"  name="submit">SEND</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <div class="map_container">
                    <div class="map">
                        <div id="googleMap" style="width:100%;height:100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>