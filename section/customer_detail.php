<section class="service_section layout_padding" id="service">
    <div class="container">
        <div class="heading_container heading_center">
            <h2> Big Customer</h2>
        </div>
        <div class="row" id="customerPosts">
            <?php
            $sql = "SELECT * FROM customers ORDER BY RAND() LIMIT 3";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <?php foreach ($customers as $customer) : ?>
                <div class="col-sm-6 col-md-4 mx-auto" style="min-height: 250px;">
                    <div class="box">
                        <div class="img-box owl-carousel owl-theme">
                            <?php
                            $photos = json_decode($customer['photo']); // Decode the JSON string into an array
                            if (!empty($photos)) {
                                foreach ($photos as $photo) {
                                    echo '<img class="owl-lazy" data-src="./photos/' . htmlspecialchars($photo) . '" alt="photo" />';
                                }
                            } else {
                                echo '<img class="owl-lazy" data-src="./photos/dummy.png" alt="photo" />';
                            }
                            ?>
                        </div>
                        <div class="detail-box">
                            <a href="./job_detail.php?id=<?= $customer['id']; ?>">
                                <?= strlen($customer['name']) > 20 ? substr($customer['name'], 0, 20) . '...' : $customer['name']; ?>
                            </a>
                            <p>
                                <?= strlen($customer['email']) > 20 ? substr($customer['email'], 0, 20) . '...' : $customer['email']; ?>
                            </p>
                            <p>
                                <?= $customer['address'] ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="owl-carousel owl-theme">
                    <img class="owl-lazy" data-src="https://placehold.it/350x450&text=1" data-src-retina="https://placehold.it/350x250&text=1-retina" alt="">
                    <img class="owl-lazy" data-src="https://placehold.it/350x650&text=2" data-src-retina="https://placehold.it/350x250&text=2-retina" alt="">
                    <picture>
                        <source class="owl-lazy" media="(min-width: 650px)" data-srcset="https://placehold.it/350x250&text=3-large">
                        <source class="owl-lazy" media="(min-width: 350px)" data-srcset="https://placehold.it/350x250&text=3-medium">
                        <img class="owl-lazy" data-src="https://placehold.it/350x250&text=3-fallback" alt="">
                    </picture>
                    <img class="owl-lazy" data-src="https://placehold.it/350x250&text=4" alt="">
                    <img class="owl-lazy" data-src="https://placehold.it/350x250&text=5" alt="">
                    <img class="owl-lazy" data-src="https://placehold.it/350x250&text=6" alt="">
                </div>
            <?php endforeach; ?>
        </div>

        <div class="btn-box">
            <button class="btn btn-primary" id="load" data-offset="3">
                View More
            </button>
            <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
            <script>
                $('.owl-carousel').owlCarousel({
                    items: 4,
                    lazyLoad: true,
                    loop: true,
                    margin: 10
                });
            </script>
        </div>
    </div>
</section>