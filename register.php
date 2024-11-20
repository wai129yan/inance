<?php
include("./database/db.php");
include("./layout/header.php");
?>
<section class="contact_section layout_padding" id="contact">
    <div class="container">
        <div class="heading_container">
            <h2>Register Form</h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <form action="" method="post">
                    <div>
                        <input type="text" name="name" class="form-control"  placeholder="Name" required />
                    </div>
                    <div>
                        <input type="email" name="email" class="form-control" placeholder="Email" required />
                    </div>
                    <div>
                        <input type="text" name="phone" class="form-control" placeholder="Phone Number" required />
                    </div>
                    <div>
                        <input type="text" name="special" class="form-control" placeholder="Specialization" required />
                    </div>
                    <div>
                        <input type="date" name="registerdate" class="form-control" required />
                    </div>

                    <div class="d-flex">
                        <button type="submit" name="submit">SEND</button>
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
<?php include("./layout/footer.php") ?>;