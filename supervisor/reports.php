<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Supervisor - Reports</title>
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
                <img src="../images/Logo.png" alt="" onclick="redirecttotask()"/>
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
                <div>
                    <label>
                        <input type="radio" name="reportType" value="MyReports" onchange="radioReports()" checked> My Reports
                    </label>
                    <label class="so-label">
                        <input type="radio" name="reportType" value="SOReports" onchange="radioReports()"> Security Officers's Reports
                    </label>
                </div>
                <form>
                    <div>
                        <table id="tasktable">
                            <thead>
                                <tr>
                                    <th>Supervisor's ID</th>
                                    <th>Name</th>
                                    <th>Task</th>
                                    <th>Status</th>
                                    <th>Date Submitted</th>
                                </tr>
                            </thead>
                            <tbody id="reportsTableBody">
                                <?php
                                    require_once "../inc/dbconn.inc.php";
                                    $sql = "SELECT R.taskId, R.userId, R.timestamp, T.taskName, U.fName, U.lName, R.status
                                    FROM Report R JOIN Task T ON R.taskId = T.taskId JOIN User U ON R.userId = U.userId
                                    WHERE T.statusDis IN ('DIS04','DIS05') AND T.supervisorId = $loginUserId AND R.userId = $loginUserId;
                                    ";
                                    $reports = [];

                                    if ($result = mysqli_query($conn, $sql)) {
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $reports[] = $row;
                                            }
                                            mysqli_free_result($result);
                                        }
                                    }
                                    foreach ($reports as $report) :
                                        //Check if every task report of a particular taskId has been completed
                                        $allCompleted = 0;
                                        $sql = "SELECT taskId, 
                                        CASE WHEN COUNT(*) = SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) 
                                            THEN 1 
                                            ELSE 0 
                                        END AS all_completed
                                        FROM Report
                                        WHERE taskId = ? AND userId != $loginUserId
                                        GROUP BY taskId";
                                        $statement = mysqli_prepare($conn, $sql);
                                        if ($statement) {
                                            mysqli_stmt_bind_param($statement, 's', $report['taskId']);
                                            mysqli_stmt_execute($statement);
                                            $result = mysqli_stmt_get_result($statement);
                                            $row = mysqli_fetch_assoc($result);

                                        if ($row) {
                                            $allCompleted = $row['all_completed'];
                                        }
                                        mysqli_stmt_close($statement);
                                        } else {
                                        echo "Error in SQL statement: " . mysqli_error($conn);
                                        }
                                        if($allCompleted) {
                                ?>
                                    <tr>
                                        <td>
                                            <a href="javascript:void(0);" onclick="redirectToReportsSoSupPage('<?php echo $report['taskId']; ?>',
                                                '<?php echo $report['taskName']; ?>', '<?php echo $report['status']; ?>')">
                                                <?php echo $report['userId']; ?>
                                            </a>
                                        </td>
                                        <td><?php echo $report['fName'] . ' ' . $report['lName']; ?></td>
                                        <td><?php echo $report['taskName']; ?></td>
                                        <td><?php echo $report['status']; ?></td>
                                        <td>
                                        <?php
                                        if (!empty($report['timestamp'])) {
                                            $formattedTimestampSO = date('d-m-Y H:i:s', strtotime($report['timestamp']));
                                            echo htmlspecialchars($formattedTimestampSO);
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                        </td>
                                    </tr>
                                <?php }
                                endforeach;
                                ?>
                                
                            </tbody>
                        </table>
                        <table id="tasktable2">
                            <thead>
                                <tr>
                                    <th>Security Officer's ID</th>
                                    <th>Name</th>
                                    <th>Task</th>
                                    <th>Status</th>
                                    <th>Date Submitted</th>
                                </tr>
                            </thead>
                            <tbody id="reportsTableBody2">
                                <?php
                                    require_once "../inc/dbconn.inc.php";
                                    $sql = "SELECT R.taskId, R.userId, R.timestamp, T.taskName, U.fName, U.lName, R.status
                                    FROM Report R JOIN Task T ON R.taskId = T.taskId JOIN User U ON R.userId = U.userId
                                    WHERE T.statusSup IN ('SUP03','SUP04') AND T.supervisorId = $loginUserId AND R.userId != $loginUserId;
                                    ";
                                    $reports = [];

                                    if ($result = mysqli_query($conn, $sql)) {
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $reports[] = $row;
                                            }
                                            mysqli_free_result($result);
                                        }
                                    }
                                    foreach ($reports as $report) :
                                ?>
                                    <tr>
                                        <td>
                                            <a href="javascript:void(0);" onclick="redirectToReportsSoPage('<?php echo $report['taskId']; ?>',
                                                '<?php echo $report['taskName']; ?>', '<?php echo $report['userId']; ?>', '<?php echo $report['fName']; ?>', '<?php echo $report['lName']; ?>', '<?php echo $report['timestamp']; ?>')">
                                                <?php echo $report['userId']; ?>
                                            </a>
                                        </td>
                                        <td><?php echo $report['fName'] . ' ' . $report['lName']; ?></td>
                                        <td><?php echo $report['taskName']; ?></td>
                                        <td><?php echo $report['status']; ?></td>
                                        <td>
                                        <?php
                                        if (!empty($report['timestamp'])) {
                                            $formattedTimestampSO = date('d-m-Y H:i:s', strtotime($report['timestamp']));
                                            echo htmlspecialchars($formattedTimestampSO);
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                        </td>
                                    </tr>
                                <?php endforeach;
                                    mysqli_close($conn);
                                ?>
                                
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="cleardiv"></div>
    <!-- -->
</body>

</html>