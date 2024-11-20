

<section class="contact_section layout_padding">
    <div class="container">
        <div class="heading_container">
            <h2>Contact Us</h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <form action="../index.php" method="post">
                    <div>
                        <input type="text" name="name" placeholder="Name" />
                    </div>
                    <div>
                        <input type="text" name="phone" placeholder="Phone Number"  />
                    </div>
                    <div>
                        <input type="email" name="email" placeholder="Email" />
                    </div>
                    <div>
                        <input type="text" name="message" class="message-box" placeholder="Message" />
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