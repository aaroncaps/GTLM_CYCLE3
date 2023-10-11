<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SO - Reports</title>
  <!-- css -->
  <link rel="stylesheet" href="../styles/navigation.css" />
  <link rel="stylesheet" href="../styles/style.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <!-- js -->
  <script src="../js/core.js"></script>
  <!-- font awesome -->
  <script src="https://kit.fontawesome.com/60ed8990c9.js" crossorigin="anonymous"></script>

  <style>
    .profile-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }

    .column {
      flex-basis: 48%;
    }

    .profile-picture img {
      max-width: 100%;
      height: auto;
    }

    .info p {
      margin: 5px 0;
    }
  </style>
</head>

<body>
  <!-- navbar begins -->
  <div class="wrapper">
    <div class="left_navbar">
      <div class="logo">
        <img src="../images/Logo.png" alt="" onclick="redirecttotask()" />
      </div>
      <ul>
        <a href="tasks.php">
          <li>Tasks</li>
        </a>
        <a href="reports.php">
          <li>Reports</li>
        </a>
      </ul>
    </div>
    <div class="right_content">
      <div class="upper_navbar">
        <!-- hamurger menu starts -->
        <i class="fa-solid fa-bars" onclick="handleHamburger()"></i>
        <i class="fa-solid fa-xmark" onclick="handleXmark()"></i>
        <!-- hamburger menu ends -->
        <a href="../profile/profile.php">Profile</a>
        <a href="../help_support/help_support.php">Help & Support</a>
        <a href="../login/logout.php">Logout</a>
      </div>
      <div class="upper_navbar_user">
        <?php
        session_start();
        $loginUserId = $_SESSION['loginUserId'];
        $loginName = $_SESSION['loginName'];
        echo 'Welcome, ' . $loginName;
        if ($loginUserId == '') {
          header("Location: ../login/login.php");
          exit();
        }

        ?>
      </div>
      <div class="main_content">
        <div class="mobile_menu">
          <ul>
            <a href="tasks.php">
              <li>Tasks</li>
            </a>
            <a href="reports.php">
              <li>Reports</li>
            </a>
            <a href="../profile/profile.php">
              <li>Profile</li>
            </a>
            <a href="../help_support/help_support.php">
              <li>Help & Support</li>
            </a>
            <a href="../login/logout.php">
              <li>Logout</li>
            </a>
          </ul>
        </div>
        <h1>Profile</h1>
        <!-- put your code here -->

        <!-- ... (previous code) ... -->
        <?php
        require_once "../inc/dbconn.inc.php";


        $sql = "SELECT * FROM user WHERE userId  = $loginUserId";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
          $user = $result->fetch_assoc();
          $result->free_result();
        } else {
          echo "No user found with ID: $loginUserId";
        } ?>
        <!-- put your code here -->
        <div class="profile-container" style="
padding-left: 200px;
">
          <!-- Personal Information -->
          <div class="column personal-info">
            <div class="profile-picture">
              <img src="../images/profilepic.jpg" alt="Supervisor Picture">
            </div>

            <div class="column certificates">
              <h2>Name: <?php echo $user['fName'] . ' ' . $user['lName']; ?></h2>
              <p>Role: <?php echo $user['role']; ?></p>
              <p>Date of Birth: <?php echo $user['DOB']; ?></p>
              <p>Sex: <?php echo $user['sex']; ?></p>
              <p>Address: <?php echo $user['address']; ?></p>
              <p>Contact: <?php echo $user['contact']; ?></p>
              <p>Email Address: <?php echo $user['email']; ?></p>
            </div>

            <div class="column certificates">
              <h2>Certificate & License</h2>
              <p>USI: <?php echo $user['usi']; ?></p>
              <p>License No.: <?php echo $user['licence']; ?></p>
              <p>Driving License No.: <?php echo $user['Driving_licence']; ?></p>
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>
  <div class="cleardiv"></div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

<!-- -->
</body>

</html>