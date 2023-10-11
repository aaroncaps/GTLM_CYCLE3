<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SO - Task View</title>
    <!-- css -->
    <link rel="stylesheet" href="../styles/navigation.css" />
    <link rel="stylesheet" href="../styles/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- js -->
    <script src="../js/core.js"></script>
    <script src="../js/securityofficer.js" defer></script>
    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/60ed8990c9.js" crossorigin="anonymous"></script>
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
                <?php
                require_once "../inc/dbconn.inc.php";

                //Retrieve all tasks the belong to the login user

                $sql = "SELECT * FROM Task T WHERE T.statusSup ='SUP03' AND T.taskId = " . $_REQUEST['taskId'] . " LIMIT 1";
                $result = $conn->query($sql);
                $task =  $result->fetch_assoc();
                $result->free_result();
                ?>
                <!-- put your code here -->
                <div class="main_content">
                    <!-- Existing content -->
                    <h2>Task View</h2>
                    <div class="container mt-5">
                        <form action="" id="myForm" method="GET">
                            <div class="form-group readOnly">
                                <label for="id-task">Task ID:</label>
                                <input type="text" id="id-task" name="task" value="<?php echo $task['taskId'] ?? ''; ?>" readonly>
                            </div>
                            <div class="form-group readOnly">
                                <label for="task-name">Task Name:</label>
                                <input type="text" id="task-name" name="taskname" value="<?php echo isset($task['taskName']) ? htmlspecialchars($task['taskName']) : ''; ?>" readonly>
                            </div>

                            <div class="form-group readOnly">
                                <label for="date">date:</label>

                                <input type="text" id="date" name="date" value="<?php if (isset($task['dateCreated'])) {
                                                                                    $dateCreated = date('d-m-Y', strtotime($task['dateCreated']));
                                                                                    echo htmlspecialchars($dateCreated);
                                                                                } else {
                                                                                    echo '';
                                                                                } ?>" readonly>
                            </div>
                            <div class="form-group readOnly">
                                <label for="date">Task From:</label>

                                <input type="text" id="dateFrom" name="dateFrom" value="<?php if (isset($task['dateFrom'])) {
                                                                                            $dateFrom = date('d-m-Y', strtotime($task['dateFrom']));
                                                                                            echo htmlspecialchars($dateFrom);
                                                                                        } else {
                                                                                            echo '';
                                                                                        } ?>" readonly>
                            </div>
                            <div class="form-group readOnly">
                                <label for="date">Task To:</label>

                                <input type="text" id="dateTo" name="dateTo" value="<?php if (isset($task['dateTo'])) {
                                                                                        $dateTo = date('d-m-Y', strtotime($task['dateTo']));
                                                                                        echo htmlspecialchars($dateTo);
                                                                                    } else {
                                                                                        echo '';
                                                                                    } ?>" readonly>
                            </div>
                            <?php
                            // if (isset($task['taskDetailsCli'])) {
                            //     $taskDetailsCli = "Cli Comments:\n" . htmlspecialchars($task['taskDetailsCli']) . "\n";
                            // } else {
                            //     $taskDetailsCli = '';
                            // }
                            // if (isset($task['taskDetailsDis'])) {
                            //     $taskDetailsDis = "Dis Comments:\n" . htmlspecialchars($task['taskDetailsDis']) . "\n";
                            // } else {
                            //     $taskDetailsDis = '';
                            // }
                            if (isset($task['taskDetailsSup'])) {
                                $taskDetailsSup = htmlspecialchars($task['taskDetailsSup']) . "\n";
                            } else {
                                $taskDetailsSup = '';
                            }
                            ?>
                            <span class="labelAndTextarea readOnly">
                                <label for="details">Details:</label>
                                <textarea id="details" name="details" rows="8" cols="50" required><?php echo $taskDetailsSup; ?></textarea>
                            </span>
                            <div class="right-button">
                                <button type="button" onclick="history.back()">Back</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cleardiv"></div>
</body>

</html>