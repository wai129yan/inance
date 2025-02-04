<section class="service_section layout_padding" id="service">
    <div class="container ">
        <div class="heading_container heading_center">
            <h2> Current Jobs </h2>
        </div>
        <div class="row" id="customerPosts">
            <?php
            // $sql = "SELECT * FROM posts limit 3";
            // $sql = "SELECT * FROM posts ORDER BY created_at DESC LIMIT 5";
            $sql = "SELECT * FROM posts ORDER BY RAND() LIMIT 3";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $customerPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //print_r($customerPosts);
            ?>

            <?php foreach ($customerPosts as $customerPost) : ?>
                <div class="col-sm-6 col-md-4 mx-auto " style="min-height: 250px;">
                    <div class="box ">
                        <div class="img-box">
                            <!-- <img src="./customerPhotos/<= $customerPost['photo'] ?? 'dummy.png' ?>" alt="photo" /> -->

                            <?php
                            // Assuming $customerPost['photos'] contains a JSON-encoded string of photo filenames
                            $photos = json_decode($customerPost['photo']); // Decode the JSON string into an array
                            
                            // Get the first photo or fall back to a default if no photos exist
                            $photoToShow = !empty($photos) ? $photos[0] : 'dummy.png';
                            echo '<img src="./photos/' . htmlspecialchars($photoToShow) . '" alt="photo" />'
                            ?>


                        </div>
                        <div class="detail-box">
                            <a href="./job_detail.php?id=<?= $customerPost['id']; ?>">
                                <?= strlen($customerPost['title']) > 20 ? substr($customerPost['title'], 0, 20) . '...' : $customerPost['title']; ?>
                            </a>
                            <p>
                                <?= strlen($customerPost['content']) > 20 ? substr($customerPost['content'], 0, 20) . '...' : $customerPost['content']; ?>
                            </p>
                            <p>
                                $ <?= $customerPost['price'] ?>
                            </p>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="btn-box">
            <button class="btn btn-primary" id="load" data-offset="3">
                View More
            </button>
            <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#load").click(function() {
                        let offset = $(this).data("offset");
                        $.ajax({
                            url: "/section/load_more_posts.php",
                            type: "POST",
                            data: {
                                offset: offset
                            },
                            success: function(response) {
                                console.log(response); // For debugging
                                $("#customerPosts").append(response);
                                $("#load").data("offset", offset + 3);
                            }
                        });
                    });
                });
            </script>
        </div>
    </div>
</section>