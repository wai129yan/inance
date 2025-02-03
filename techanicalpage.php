<!-- Fatal error: Uncaught PDOException: SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row:
  a foreign key constraint fails (`inance`.`reviews`, CONSTRAINT `Reviews_ibfk_2` FOREIGN KEY (`AppointmentID`) REFERENCES `appointments` (`AppointmentID`)) in C:\xampp\htdocs\inance\sb-admin\create_review.php:53 Stack trace: #0 C:\xampp\htdocs\inance\sb-admin\create_review.php(53):
     PDOStatement->execute() #1 {main} thrown in C:\xampp\htdocs\inance\sb-admin\create_review.php on line 53 -->




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Card</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <style>
    body {
      background-color: #f5f5f5;
      font-family: Arial, sans-serif;
    }

    .profile-card {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      margin: 30px auto;
      max-width: 800px;
      padding: 30px;
    }

    .profile-card h2 {
      color: #333;
      font-size: 24px;
      margin-bottom: 20px;
    }

    .profile-card p {
      color: #666;
      line-height: 1.6;
      margin-bottom: 15px;
    }

    .skills-container {
      display: flex;
      justify-content: space-between;
      margin-bottom: 30px;
    }

    .skills-item {
      background-color: #f0f0f0;
      border-radius: 5px;
      padding: 10px;
      text-align: center;
    }

    .skills-item h4 {
      color: #333;
      font-size: 16px;
      margin-bottom: 5px;
    }

    .skills-item .star-rating {
      display: flex;
      justify-content: center;
    }

    .star {
      color: #ffcc00;
      margin: 0 2px;
    }

    .button {
      background-color: #007bff;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .button:hover {
      background-color: #0056b3;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="profile-card">
      <h2>Jane Smith</h2>
      <p>Full Stack Developer with a passion for creating beautiful and functional web applications.</p>
      <div class="skills-container">
        <div class="skills-item">
          <h4>HTML</h4>
          <div class="star-rating">
            <span class="star">★</span>
            <span class="star">★</span>
            <span class="star">★</span>
            <span class="star">★</span>
            <span class="star">★</span>
          </div>
        </div>
        <div class="skills-item">
          <h4>CSS</h4>
          <div class="star-rating">
            <span class="star">★</span>
            <span class="star">★</span>
            <span class="star">★</span>
            <span class="star">★</span>
            <span class="star">☆</span>
          </div>
        </div>
        <div class="skills-item">
          <h4>JavaScript</h4>
          <div class="star-rating">
            <span class="star">★</span>
            <span class="star">★</span>
            <span class="star">★</span>
            <span class="star">★</span>
            <span class="star">★</span>
          </div>
        </div>
      </div>
      <button class="button">View Portfolio</button>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html> 
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Team Showcase</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .team-section {
      padding: 50px 0;
    }

    .team-card {
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      margin: 20px;
      text-align: center;
      transition: transform 0.3s;
    }

    .team-card:hover {
      transform: translateY(-5px);
    }

    .team-img {
      width: 100%;
      border-radius: 10px 10px 0 0;
    }

    .team-name {
      font-size: 20px;
      font-weight: bold;
      margin: 15px 0 5px;
    }

    .team-role {
      color: #6c757d;
      margin-bottom: 15px;
    }

    .button {
      background-color: #28a745;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .button:hover {
      background-color: #218838;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1 class="text-center mb-5">Meet Our Team</h1>
    <div class="row team-section">
      <div class="col-md-4">
        <div class="team-card">
          <img src="https://via.placeholder.com/300" alt="Team Member" class="team-img">
          <h2 class="team-name">Alice Johnson</h2>
          <p class="team-role">Project Manager</p>
          <button class="button">Contact</button>
        </div>
      </div>
      <div class="col-md-4">
        <div class="team-card">
          <img src="https://via.placeholder.com/300" alt="Team Member" class="team-img">
          <h2 class="team-name">Bob Smith</h2>
          <p class="team-role">Lead Developer</p>
          <button class="button">Contact</button>
        </div>
      </div>
      <div class="col-md-4">
        <div class="team-card">
          <img src="https://via.placeholder.com/300" alt="Team Member" class="team-img">
          <h2 class="team-name">Charlie Brown</h2>
          <p class="team-role">UI/UX Designer</p>
          <button class="button">Contact</button>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>




