<section class="service_section layout_padding" id="service">
    <div class="container ">
        <div class="heading_container heading_center">
            <h2> Current Jobs </h2>
        </div>
        <div class="row" id="customerPosts">
            <?php
            // $sql = "SELECT * FROM posts limit 3";
            // $sql = "SELECT * FROM posts ORDER BY created_at DESC LIMIT 5";
            $sql = "SELECT * FROM posts ORDER BY RAND() LIMIT 5";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $customerPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //print_r($customerPosts);
            ?>

            <?php foreach ($customerPosts as $customerPost) : ?>
                <div class="col-sm-6 col-md-4 mx-auto">
                    <div class="box ">
                        <div class="img-box">
                            <img src="./customerPhotos/<?= $customerPost['photo'] ?? 'client-1.jpg' ?>" alt="photo" />
                        </div>
                        <div class="detail-box">
                            <h5>
                                <a href="./job_detail.php?id=<?= $customerPost['id']; ?>"><?= $customerPost['title'] ?></a>
                            </h5>
                            <p>
                                <?= $customerPost['content'] ?>
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
            <button class="btn btn-primary" id="loadMore" data-offset="3">
                View More
            </button>
            <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
            <script>
                $(document).ready(function() {
                    $("#loadMore").click(function() {
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
                                $("#loadMore").data("offset", offset + 3);
                            }
                        });
                    });
                });
            </script>
        </div>
    </div>
</section>