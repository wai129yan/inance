<div class="row d-flex justify-content-center custom p-5">
    <div class=" d-flex text-center">
        <div class="rounded-circle overflow-hidden profile-image">
            <img src="https://i.pravatar.cc/150" alt="Profile Image" class="w-100 h-100 object-fit-cover">
        </div>
        <div class="d-flex flex-column align-items-center ms-3">
            <h3 class="m-3"><?= $techician['name'] ?></h3>
            <p class="text-muted"><?= $career['name'] ?></p>

            <a href="tel:+<?= $techician['Phone']; ?>" class="btn btn-info text-white">+ Contact Me</a>
        </div>
        <div class="d-flex text-center align-items-center ms-5">
            <i class="fab fa-twitter  icon-hover me-2"></i>
            <i class="fab fa-linkedin  icon-hover me-2"></i>
            <i class="fab fa-github  icon-hover me-2"></i>
            <i class="fas fa-globe icon-hover me-2 "></i>
        </div>
        <div class="d-flex text-center align-items-center ms-5">

            <a href="mailto:<?= $techician['email']; ?>" class="btn btn-light">+ Send Message</a>
        </div>
    </div>
</div>
<div class="row mt-5">
    <div class="d-flex justify-content-between align-items-center w-100 ">
        <h5 class="fw-bold">My Score Skills : </h5>
        <p class="custom-shadow p-2 mb-2 fs-5">
            <i class="fas fa-star me-2 icon-hover"></i>
            <i class="fas fa-star me-2 icon-hover"></i>
            <i class="fas fa-star me-2 icon-hover"></i>
            <i class="fas fa-star me-2 icon-hover"></i>
            Great Skills
        </p>
        <p class="custom-shadow p-2 mb-2 fs-5">
            <i class="fas fa-star me-2 icon-hover"></i>
            <i class="fas fa-star me-2 icon-hover"></i>
            <i class="fas fa-star me-2 icon-hover "></i>
            <i class="fas fa-star me-2 icon-hover"></i>
            Good In Services
        </p>
        <p class="custom-shadow p-2 mb-2 fs-5">
            <i class="fas fa-star me-2 icon-hover"></i>
            <i class="fas fa-star me-2 icon-hover"></i>
            <i class="fas fa-star me-2 icon-hover "></i>
            <i class="fas fa-star me-2 icon-hover"></i>
            Good In languages
        </p>
    </div>
</div>
<div class="row mt-5">
    <div class="col-md-7 d-flex">
        <div class="card w-100 d-flex flex-column c-shadow">
            <div class="card-body">
                <h5 class="card-title">Professional Bio</h5>
                <p class="text-danger"><?= $career['description'] ?></p>
                <p class="card-text">

                    An enthusiastic and detail-oriented Web Developer with over 5 years of experience in
                    building responsive, user-friendly websites and web applications.
                    <br><br>
                    Skilled in both front-end and back-end development, with a strong foundation in HTML, CSS,
                    JavaScript, and PHP.<br><br>
                    Experienced in working with modern frameworks like React, Vue.js, and Laravel.
                    Passionate about creating seamless user experiences and writing clean, maintainable code.
                    Dedicated to continuous learning and improving web development skills.
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-5 d-flex">
        <div class="card w-100 d-flex flex-column c-shadow">
            <div class="card-body">
                <h5 class="card-title fs-4">Where I Live</h5>
                <p class="card-text d-flex justify-content-between">
                    <span class="title">Address</span>
                    <span class="title"><?= $techician['Address'] ?></span>
                </p>
                <p class="card-text d-flex justify-content-between">
                    <span class="fs-5">Phone</span>
                    <span class="fs-5"><a class="text-decoration-none" href="tel:+<?= $techician['Phone']; ?>"><?= $techician['Phone'] ?></a></span>
                </p>
                <p class="card-text d-flex justify-content-between">
                    <span class="fs-5">Specialization</span>
                    <span class="fs-5"><?= $techician['Specialization'] ?></span>
                </p>
                <p class="card-text d-flex justify-content-between">
                    <span class="fs-5">E-mail</span>
                    <span class="fs-5"><a class="text-decoration-none" href="mailto:<?= $techician['email']; ?>"><?= $techician['email'] ?></a></span>

                </p>
            </div>
        </div>
    </div>
</div>