<section class="service_section layout_padding" id="service">
    <div class="container ">
        <div class="heading_container heading_center">
            <h2> Our Technicians </h2>
        </div>
        <div class="row" id="technicians">
            <?php
            $sql = "SELECT * FROM technicians limit 3";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $technicians = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php foreach ($technicians as $technician) : ?>
                <div class="col-sm-6 col-md-4 mx-auto">
                    <div class="box ">
                        <div class="img-box">
                            <img src="images/technician/<?= $technician['photo'] ?? 'client-1.jpg' ?>" alt="photo" />
                        </div>
                        <div class="detail-box">
                            <h5>
                                <a href="../profile/profile.php?id=<?= $technician['TechnicianID'];?>"><?= $technician['name'] ?></a>
                            </h5>
                            <p>
                                <?= $technician['email'] ?>
                            </p>
                            <p>
                                <?= $technician['Phone'] ?>
                            </p>
                            <p>
                                <?= $technician['Address'] ?>
                            </p>
                            <p>
                                <?php
                                $sql = "SELECT * FROM careeries WHERE career_id = ? ";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([$technician['career_id']]);
                                $career = $stmt->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <?= $career['name'] ?>
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
                            url: "/section/load_more_technicians.php",
                            type: "POST",
                            data: {
                                offset: offset
                            },
                            success: function(response) {
                                console.log(response);
                                $("#technicians").append(response);
                                $("#loadMore").data("offset", offset + 3);
                            }
                        });
                    });
                });
            </script>
        </div>
    </div>
</section>