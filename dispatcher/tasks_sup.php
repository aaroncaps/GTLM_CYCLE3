<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administrator - Assign Task to SOs</title>
    <!-- css -->
    <link rel="stylesheet" href="../styles/navigation.css" />
    <link rel="stylesheet" href="../styles/style.css" />

    <!-- js -->
    <script src="../js/core.js"></script>
    <script src="../js/dispatcher.js" defer></script>
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
                <a href="../login/logout.php">Logout</a>
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
                <h2>Tasks</h2>
                <!-- put your code here -->
                <form id="myForm" action="tasks_sup_process.php" method="POST">
                    <?php
                    // echo 'taskId: ' . $_GET['taskId'];
                    // echo '<br>';
                    // echo 'dateCreated: ' . $_GET['dateCreated'];
                    // echo '<br>';
                    // echo 'taskName: ' . $_GET['taskName'];
                    // echo '<br>';
                    // echo 'status: ' . $_GET['status'];
                    // echo '<br>';
                    // echo 'fName: ' . $_GET['fName'];
                    // echo '<br>';
                    // echo 'lName: ' . $_GET['lName'];
                    // echo '<br>';
                    require_once "../inc/dbconn.inc.php";
                    $dateFrom = null;
                    $dateTo = null;
                    $taskDetailsCli = null;
                    $taskDetailsDis = null;
                    $taskDetailsSup = null;
                    $supervisorId = null;
                    $declineReason = null;
                    $sql = "SELECT dateFrom, dateTo, taskDetailsDis, taskDetailsSup, taskDetailsCli, supervisorId, declineReason FROM Task WHERE taskId = ?";
                    $statement = mysqli_stmt_init($conn);
                    if (mysqli_stmt_prepare($statement, $sql)) {
                        mysqli_stmt_bind_param($statement, 'i', $_GET['taskId']);
                        if (mysqli_stmt_execute($statement)) {
                            mysqli_stmt_bind_result($statement, $dateFrom, $dateTo, $taskDetailsDis, $taskDetailsSup, $taskDetailsCli, $supervisorId, $declineReason);
                            if (mysqli_stmt_fetch($statement)) {
                            }
                        }
                        mysqli_stmt_close($statement);
                    }


                    // echo 'dateFrom: ' . $dateFrom;
                    // echo '<br>';
                    // echo 'dateTo: ' . $dateTo;
                    // echo '<br>';
                    // echo 'taskDetailsDis: ' . $taskDetailsDis;
                    // echo '<br>';
                    // echo 'taskDetailsDis: ' . $taskDetailsSup;
                    // echo '<br>';
                    
                    ?>
                    <input type="hidden" id="date-from" name="date-from" value="<?php echo htmlspecialchars($dateFrom); ?>"/>
                    <input type="hidden" id="date-to" name="date-to" value="<?php echo htmlspecialchars($dateTo); ?>"/>
                    <input type="hidden" id="task-id" name="task-id" value="<?php echo (isset($_GET['taskId']) ? htmlspecialchars($_GET['taskId']) : ''); ?>" />
                    <div>
                        <label for="task-id-output">Task ID:</label>
                        <output id="task-id-output" name="task-id-output"><?php echo (isset($_GET['taskId']) ? htmlspecialchars($_GET['taskId']) : ''); ?></output>
                    </div>
                    <div>
                        <label for="date-created">Date Created:</label>
                        <output id="date-created" name="date-created">
                        <?php
                        if (isset($_GET['dateCreated'])) {
                            $dateCreated = date('d-m-Y', strtotime($_GET['dateCreated']));
                            echo htmlspecialchars($dateCreated);
                        } else {
                            echo '';
                        }
                        ?>
                        </output>
                    </div>
                    <div>
                        <label for="task-name">Task Name:</label>
                        <output id="task-name" name="task-name"><?php echo (isset($_GET['taskName']) ? htmlspecialchars($_GET['taskName']) : ''); ?></output>
                    </div>
                    <div>
                        <label for="status">Status:</label>
                        <output id="status" name="status"><?php echo (isset($_GET['status']) ? htmlspecialchars($_GET['status']) : ''); ?></output>
                    </div>
                    <div>
                        <label for="date-from-output">Date From:</label>
                        <output id="date-from-output" name="date-from-output">
                        <?php
                        if (isset($dateFrom)) {
                            $formattedDateFrom = date('d-m-Y', strtotime($dateFrom));
                            echo htmlspecialchars($formattedDateFrom);
                        } else {
                            echo '';
                        }
                        ?>
                        </output>
                    </div>
                    <div>
                        <label for="date-to-output">Date To:</label>
                        <output id="date-to-output" name="date-to-output">
                        <?php
                        if (isset($dateTo)) {
                            $formattedDateTo = date('d-m-Y', strtotime($dateTo));
                            echo htmlspecialchars($formattedDateTo);
                        } else {
                            echo '';
                        }
                        ?>
                        </output>
                    </div>
                    <?php
                    if (htmlspecialchars($_GET['status']) == 'Client Request' || htmlspecialchars($_GET['status']) == 'Declined Task by Supervisor') {
                    ?>
                    <div>
                        <?php
                        $sql = "SELECT userId, fName, lName FROM User WHERE role = 'Supervisor'";
                        $statement = mysqli_stmt_init($conn);
                        $users = [];
                        if (mysqli_stmt_prepare($statement, $sql)) {
                            if (mysqli_stmt_execute($statement)) {
                                $result = mysqli_stmt_get_result($statement);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $users[] = $row;
                                }
                            }
                            mysqli_stmt_close($statement);
                        }
                        ?>
                        <label for="assignToId">Assigned To:</label>
                        <select id="assignToId" name="assignToId">
                            <option value=""></option>
                            <?php
                            foreach ($users as $user) {
                                $userId = $user['userId'];
                                $displayName = $user['fName'] . ' ' . $user['lName'];
                                $selected = ($userId === $supervisorId) ? 'selected' : '';
                                echo "<option value='$userId' $selected>$displayName</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <?php 
                    } else {
                    ?>
                    <div>
                        <label for="assignTo">Assigned To:</label>
                        <output id="assignTo" name="assignTo"><?php echo (isset($_GET['fName']) && isset($_GET['lName']) ? htmlspecialchars($_GET['fName']) . ' ' . htmlspecialchars($_GET['lName']) : ''); ?></output>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="readOnly">
                        <label for="dis-details">Clients's Details:</label>
                        <textarea id="dis-details" name="dis-details" rows="8" cols="50" readonly><?php echo htmlspecialchars($taskDetailsCli); ?></textarea>
                    </div>
                    <?php
                    if (htmlspecialchars($_GET['status']) == 'Declined Task by Supervisor') {
                    ?>
                    <div class="readOnly">
                        <label for="declineReason">Decline Reason:</label>
                        <textarea id="declineReason" name="declineReason" rows="8" cols="50"><?php echo htmlspecialchars($declineReason); ?></textarea>
                    </div>
                    <?php
                    }
                    ?>
                    <?php
                    if (htmlspecialchars($_GET['status']) == 'Client Request' || htmlspecialchars($_GET['status']) == 'Declined Task by Supervisor') {
                        echo "<div class=\"labelAndTextarea\">";
                    } else {
                        echo "<div class=\"readOnly\">";
                    }
                    ?>
                        <label for="sup-details">Details:</label>
                        <textarea id="sup-details" name="sup-details" rows="8" cols="50"><?php echo htmlspecialchars($taskDetailsDis); ?></textarea>
                    </div>
                    <br>
                    <div class="right-button">
                        <button type="button" onclick="cancelButton()">Back</button>
                        <?php
                        if (htmlspecialchars($_GET['status']) == 'Client Request' || htmlspecialchars($_GET['status']) == 'Declined Task by Supervisor') {
                        ?>
                            <button type="button" id="assign-task" onclick="assignTask()">
                                Assign Task
                            </button>
                        <?php
                        } 
                        ?>
                    </div>
                    <div id="popup">
                        <div id="decline-popup" class="labelAndTextarea">
                            <label id="decline-reason-label" for="decline-reason"></label>
                            <textarea id="decline-reason" name="decline-reason"></textarea>
                        </div>
                        <div id="confirm-popup" class="popupMessage">
                            <output id="confirm-popup-output"></output>
                        </div>
                        <div class="right-button">
                            <button type="button" id="cancel-button" onclick="cancelPopup()">Cancel</button>
                            <button type="submit" id="process-button">Confirm</button>
                        </div>
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