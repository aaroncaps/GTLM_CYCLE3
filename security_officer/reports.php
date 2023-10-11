<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SO - Reports</title>
  <!-- css -->
  <link rel="stylesheet" href="../styles/navigation.css" />
  <link rel="stylesheet" href="../styles/style.css" />
</head>

<body>
  <!-- navbar begins -->
  <div class="wrapper">
    <div class="left_navbar">
      <div class="logo">
        <img src="../images/Logo.png" alt="" />
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
        <h2>Reports</h2>
        <?php
            if (isset($_GET['messageError'])) {
                $error_message = $_GET['messageError'];
                echo '<div class="error-message">' . htmlspecialchars($error_message) . '</div>';
            } else if (isset($_GET['message'])) {
                $message = $_GET['message'];
                echo '<div class="success-message">' . htmlspecialchars($message) . '</div>';
            } 
        ?>
        <h4>Task Lists</h4>
        <!-- put your code here -->
        <div>
          <?php
          require_once "../inc/dbconn.inc.php";

          //Fetching data from databse

          $sql = "SELECT T.taskId, T.taskName
                             FROM Task T JOIN Status S ON T.statusSup = S.statusId 
                             WHERE T.statusSup ='SUP03' AND T.securityOfficerId = $loginUserId";
          $result = $conn->query($sql);
          $tasks =  $result->fetch_all(MYSQLI_ASSOC);
          $result->free_result();
          ?>
          <script>
            const tasksData = <?php echo json_encode($tasks, true); ?>
          </script>
          <table>
            <thead>
              <tr>
                <th>Task Number</th>
                <th>Task</th>
              </tr>
            </thead>
            <tbody id="reportsTableBody">
            </tbody>

          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="cleardiv"></div>
  <!-- Include your JavaScript file -->
  <script src="../js/securityofficer.js" defer></script>
</body>

</html>