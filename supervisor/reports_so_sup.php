<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Supervisor - Create Reports</title>
    <!-- css -->
    <link rel="stylesheet" href="../styles/navigation.css" />
    <link rel="stylesheet" href="../styles/style.css" />

    <!-- js -->
    <script src="../js/core.js"></script>
    <script src="../js/supervisor.js" defer></script>
    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/60ed8990c9.js" crossorigin="anonymous"></script>
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
                <a href="../login/login.php">Logout</a>
            </div>
            <div class="upper_navbar_user">
                <?php
                session_start();
                $loginUserId = $_SESSION['loginUserId'];
                $loginName = $_SESSION['loginName'];
                echo 'Welcome, ' . $loginName;
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
                        <a href="../login/login.php">
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
                <form id="myForm" action="reports_so_process.php" method="POST">
                <input type="hidden" id="task-id" name="task-id" value="<?php echo (isset($_GET['taskId']) ? htmlspecialchars($_GET['taskId']) : ''); ?>" />
                <input type="hidden" id="option" name="option" value="sup"/>
                    <?php
                    // echo 'taskId: ' . $_GET['taskId'];
                    // echo '<br>';
                    // echo 'taskName: ' . $_GET['taskName'];
                    // echo '<br>';
                    require_once "../inc/dbconn.inc.php";
                    $taskId = $_GET['taskId'];
                    $reportSup = null;
                    $allCompleted = 0;

                    //retrieve info from Supervisor
                    $sql = "SELECT report FROM Report WHERE taskId = ? AND userId = ?";
                    $statement = mysqli_stmt_init($conn);
                    if (mysqli_stmt_prepare($statement, $sql)) {
                        mysqli_stmt_bind_param($statement, 'ii', $taskId, $loginUserId);
                        if (mysqli_stmt_execute($statement)) {
                            mysqli_stmt_bind_result($statement, $reportSup);
                            if (mysqli_stmt_fetch($statement)) {

                            } 
                        }
                        mysqli_stmt_close($statement);
                    }
                    mysqli_close($conn);

                    ?>
                    <h3>Supervisor's Report</h3>
                    <div>
                        <label for="task-id-output">Task ID:</label>
                        <output id="task-id-output" name="task-id-output"><?php echo (isset($_GET['taskId']) ? htmlspecialchars($_GET['taskId']) : ''); ?></output>
                    </div>
                    <div>
                        <label for="task-name">Task Name:</label>
                        <output id="task-name" name="task-name"><?php echo (isset($_GET['taskName']) ? htmlspecialchars($_GET['taskName']) : ''); ?></output>
                    </div>
                    <div class="labelAndTextarea">
                        <label for="id-report-sup">Report:</label>
                        <textarea id="id-report-sup" name="id-report-sup" rows="8" cols="50" required><?php echo htmlspecialchars($reportSup) ?></textarea>
                    </div>
                    <div class="right-button">
                    <button type="button" onclick="cancelButton()">Back</button>
                    <?php
                    if($_GET['status'] == 'Pending') {
                    ?>
                    <button type="button" id="submit-report" onclick="submitReport()">
                        Submit
                    </button>
                    <?php
                    }
                    ?>
                    </div>
                   
                    <div id="popup">
                        <div id="confirm-popup" class="popupMessage">
                            <output id="confirm-popup-output"></output>
                        </div>
                        <div class="right-button">
                            <button type="button" id="cancel-button" onclick="cancelPopup()">Cancel</button>
                            <button type="submit" id="process-button">Confirm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="cleardiv"></div>
    <!-- -->
</body>

</html>