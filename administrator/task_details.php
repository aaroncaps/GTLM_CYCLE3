<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Onboarding</title>
    <!-- css -->
    <link rel="stylesheet" href="../styles/navigation.css">
    <link rel="stylesheet" href="../styles/style.css">

    <!-- js -->
    <script src="../js/core.js"></script>
    <script src="../js/admin.js"></script>
    
    
    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/60ed8990c9.js" crossorigin="anonymous"></script>

</head>

<body>
    <!-- navbar begins -->
    <div class="wrapper">
        <div class="left_navbar">
            <div class="logo">
                <img src="../images/logo.png" alt="">
            </div>
            <ul>
                <a href="tasks.php"><li>Tasks</li></a>
                <a href="event_logs.php"><li>Event Logs</li></a>
                <a href="system_settings.html"><li>Systen Settings</li></a>
                
            </ul>
        </div>
        <div class="right_content">
            <div class="upper_navbar">
                <!-- hamurger menu starts -->
                <i class="fa-solid fa-bars" onclick="handleHamburger()"></i>
                <i class="fa-solid fa-xmark" onclick="handleXmark()"></i>
                <!-- hamburger menu ends -->
                <a href="../profile/profile.html">Profile</a>
                <a href="../help_support/help_support.html">Help & Support</a>
                <a href="../login/login.html">Logout</a>
            </div>
            <div class="upper_navbar_user">
                <?php
                session_start();
                $loginUserId = $_SESSION['loginUserId'];
                $loginName = $_SESSION['loginName'];
                echo 'Welcome, ' . $loginName;
                if($loginUserId=='') {
                  header("Location: ../login/login.php");
                  exit();
                }
                ?>
              </div>

            <div class="main_content">
                <div class="mobile_menu">
                    <ul>
                        <a href="tasks.html"><li>Tasks</li></a>
                        <a href="event_logs.html"><li>Event Logs</li></a>
                        <a href="../profile/profile.html"><li>Profile</li></a>
                        <a href="../help_support/help_support.html"><li>Help & Support</li></a>
                        <a href="../login/login.html"><li>Logout</li></a>
                    </ul>
                </div>
                <h2>Tasks > Onboarding</h2>

                <?php
            if (isset($_GET['messageError'])) {
                $error_message = $_GET['messageError'];
                echo '<div class="error-message">' . htmlspecialchars($error_message) . '</div>';
            } else if (isset($_GET['message'])) {
                $message = $_GET['message'];
                echo '<div class="success-message">' . htmlspecialchars($message) . '</div>';
            } 
        ?>
<?php
if (isset($_GET['requestId'])) {
    $requestId = $_GET['requestId'];
    require_once "../inc/dbconn.inc.php";
    $stmt = $conn->prepare("SELECT dateRequest, fName, lName, s.status
                          FROM new_hires AS n
                          INNER JOIN status AS s ON n.statusId = s.statusId
                          WHERE n.requestId = ?");

  
    $stmt->bind_param("s", $requestId);
    $stmt->execute();
    $stmt->bind_result($dateRequest, $fName, $lName, $status);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
} else {
    
    echo 'Requested Number: Request ID not provided.';
    exit(); 
}
?>



                
                <div id="taskDetails">
                  <form class="onboarding-form">
                  <p><strong>Requested Number:</strong> <?php echo $requestId; ?></p>
    <p><strong>Requested Date:</strong> <?php echo $dateRequest; ?></p>
    <p><strong>Name:</strong> <?php echo $fName . ' ' . $lName; ?></p>
    <p><strong>Status:</strong> <?php echo $status; ?></p>
                    
                    
        <div class="onboarding-element">
          <label for="role">Role:</label>
            <select id="role" name="role" class="select-box">
        
            <option value="">Select a Role</option>
              
            <option value="Administrator">Administrator</option>
            <option value="Dispatcher">Dispatcher</option>
            <option value="Supervisor">Supervisor</option>
            <option value="Security Officer">Security Officer</option>
            </select>

        </div>
        <div class="onboarding-element">
          <label for="startDate">Start Date:</label>
            <input type="date" id="startDate" name="startDate">
          

        </div>

        <div class="onboarding-element">
          <label for="additionalMessage">Additional Message:</label>
            <textarea id="additionalMessage" name="additionalMessage" rows="4"></textarea>

        </div>

         </form>
        
    </div>

  


    <div class="right-button">
        <button id="cancelButton" class="">Cancel</button>
        <button id="submitButton" class="">Submit</button>
    </div>
    
</body>
</html>
