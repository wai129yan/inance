<style>
    html,
    body {
        position: relative;
        height: 100%;
    }

    body {
        background: #eee;
        font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
        font-size: 14px;
        color: #000;
        margin: 0;
        padding: 0;
    }

    swiper-container {
        width: 100%;
        height: 100%;
        background: #000;
    }

    swiper-slide {
        font-size: 18px;
        color: #fff;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        padding: 40px 60px;
        text-align: center;
    }

    .parallax-bg {
        position: absolute;
        left: 0;
        top: 0;
        width: 130%;
        height: 100%;
        -webkit-background-size: cover;
        background-size: cover;
        background-position: center;
    }

    swiper-slide .title {
        font-size: 41px;
        font-weight: 300;
    }

    swiper-slide .subtitle {
        font-size: 21px;
    }

    swiper-slide .text {
        font-size: 14px;
        max-width: 400px;
        line-height: 1.3;
        margin: 10px auto;
    }

    swiper-slide img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
    }
</style>

<section class="service_section layout_padding" id="service">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>Big Customer</h2>
        </div>

        <div class="row" id="customerPosts">
            <?php
            // Database query
            $sql = "SELECT * FROM customers";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
        </div>

        <!-- Swiper Container -->
        <swiper-container style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
            class="mySwiper" speed="600" parallax="true" pagination="true" pagination-clickable="true" navigation="true">

            <!-- Parallax Background -->
            <div slot="container-start" class="parallax-bg"
                style="background-image: url('https://swiperjs.com/demos/images/nature-1.jpg');"
                data-swiper-parallax="-23%">
            </div>

            <!-- Customer Slides -->
            <?php foreach ($customers as $customer): ?>
                <swiper-slide>
                    <img src="./customerPhotos/<?= $customer['photo'] ?>" alt="">
                    <div class="title" data-swiper-parallax="-300"><?= $customer['name'] ?></div>
                    <div class="subtitle" data-swiper-parallax="-200"><?= $customer['email'] ?></div>
                    <div class="text" data-swiper-parallax="-100"><?= $customer['address'] ?></div>
                </swiper-slide>
            <?php endforeach; ?>

        </swiper-container>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>