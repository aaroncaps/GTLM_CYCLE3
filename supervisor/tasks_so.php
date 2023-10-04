<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Supervisor - Assign Task to SOs</title>
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
                <h2>Tasks</h2>
                <!-- put your code here -->
                <form id="myForm" action="tasks_so_process.php" method="POST">
                    <?php
                    // echo 'taskId: ' . $_GET['taskId'];
                    // echo '<br>';
                    // echo 'dateCreated: ' . $_GET['dateCreated'];
                    // echo '<br>';
                    // echo 'taskName: ' . $_GET['taskName'];
                    // echo '<br>';
                    // echo 'status: ' . $_GET['status'];
                    // echo '<br>';
                    require_once "../inc/dbconn.inc.php";
                    $dateFrom = null;
                    $dateTo = null;
                    $taskDetailsDis = null;
                    $taskDetailsSup = null;
                    $scheduleId = null;
                    $sql = "SELECT dateFrom, dateTo, taskDetailsDis, taskDetailsSup, scheduleId FROM Task WHERE taskId = ?";
                    $statement = mysqli_stmt_init($conn);
                    if (mysqli_stmt_prepare($statement, $sql)) {
                        mysqli_stmt_bind_param($statement, 'i', $_GET['taskId']);
                        if (mysqli_stmt_execute($statement)) {
                            mysqli_stmt_bind_result($statement, $dateFrom, $dateTo, $taskDetailsDis, $taskDetailsSup, $scheduleId);
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
                    <input type="hidden" id="user-ids-input" name="user-ids-input" />
                    <input type="hidden" id="user-ids-remove" name="user-ids-remove" />
                    <input type="hidden" id="option" name="option" />
                    <input type="hidden" id="schedule-id" name="schedule-id" value="<?php echo htmlspecialchars($scheduleId); ?>"/>
                    <input type="hidden" id="date-from" name="date-from" value="<?php echo htmlspecialchars($dateFrom); ?>"/>
                    <input type="hidden" id="date-to" name="date-to" value="<?php echo htmlspecialchars($dateTo); ?>"/>
                    <input type="hidden" id="sup-details-orig" name="sup-details-orig" value="<?php echo htmlspecialchars($taskDetailsSup); ?>"/>
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
                    if (htmlspecialchars($_GET['status']) != 'Review Tasks') {
                    ?>
                        <div class="officers">
                            Assigned To:
                        </div><br>
                        <?php
                        if (htmlspecialchars($_GET['status']) == 'Assigned to Security Officer' || 
                            htmlspecialchars($_GET['status']) == 'Completed') {
                        ?>
                        <table id="table1">
                            <thead>
                                <tr>
                                    <?php
                                    if (htmlspecialchars($_GET['status']) == 'Assigned to Security Officer') {
                                    ?>
                                    <th>
                                        <input type="checkbox" id="selectAll1" onchange="selectAllCheckboxes('table1')" />
                                    </th>
                                    <?php
                                    }
                                    ?>
                                    <th>User ID</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody id="soGroupedTableBody">
                                <?php
                                $sql = "SELECT U.userId, U.fName, U.lName
                                    FROM User U
                                    JOIN User_Schedule US ON U.userId = US.userId
                                    JOIN Task T ON US.scheduleId = T.scheduleId
                                    WHERE T.scheduleId = ?";
                                $statement = mysqli_stmt_init($conn);
                                $users = [];
                                if (mysqli_stmt_prepare($statement, $sql)) {
                                    mysqli_stmt_bind_param($statement, 'i', $scheduleId);
                                    if (mysqli_stmt_execute($statement)) {
                                        $result = mysqli_stmt_get_result($statement);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $users[] = $row;
                                        }
                                    }
                                    mysqli_stmt_close($statement);
                                }
                                foreach ($users as $user) :
                                ?>
                                    <tr>
                                        <?php
                                        if (htmlspecialchars($_GET['status']) == 'Assigned to Security Officer') {
                                        ?>
                                        <td>
                                            <input type="checkbox" class="checkbox" />
                                        </td>
                                        <?php
                                        }
                                        ?>
                                        <td><?php echo $user['userId']; ?></td>
                                        <td><?php echo $user['fName'] . ' ' . $user['lName']; ?></td>
                                    </tr>
                                <?php
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                            <?php
                            if (htmlspecialchars($_GET['status']) == 'Assigned to Security Officer') {
                            ?>
                                <div class="right-button">
                                    <button type="button" id="removeSO" onclick="confirmRemoveSO('table1')">
                                        Remove SO
                                    </button>
                                </div>
                            <?php
                            }
                        }
                        if (htmlspecialchars($_GET['status']) == 'Assigned to Security Officer' ||
                            htmlspecialchars($_GET['status']) == 'Accepted Tasks') {
                        ?>
                            <div class="officers">
                                Available Security Officers:
                            </div>
                            <table id="table2">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="selectAll2" onchange="selectAllCheckboxes('table2')"/>
                                        </th>
                                        <th>User ID</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody id="soTableBody">
                                    <?php
                                    $sql = "SELECT U.* FROM User U WHERE U.role = 'Security Officer'
                                        AND NOT EXISTS (
                                            SELECT 1 FROM User_Schedule US WHERE US.userId = U.userId
                                            AND ((US.dateFrom <= ? AND US.dateTo >= ?)
                                                OR (US.dateFrom >= ? AND US.dateTo <= ?)));";
                                    $statement = mysqli_stmt_init($conn);
                                    $users = [];
                                    if (mysqli_stmt_prepare($statement, $sql)) {
                                        mysqli_stmt_bind_param($statement, 'ssss', $dateTo, $dateFrom, $dateFrom, $dateTo);
                                        if (mysqli_stmt_execute($statement)) {
                                            $result = mysqli_stmt_get_result($statement);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $users[] = $row;
                                            }
                                        }
                                        mysqli_stmt_close($statement);
                                    }
                                    mysqli_close($conn);
                                    if (count($users) == 0) {
                                        echo '<div class="error-message">No available Security Officers for the specified dates.</div>';
                                    }
                                    foreach ($users as $user) :
                                    ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="checkbox" />
                                            </td>
                                            <td><?php echo $user['userId']; ?></td>
                                            <td><?php echo $user['fName'] . ' ' . $user['lName']; ?></td>
                                        </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                        <?php
                        }
                        ?>
                    <?php
                    }
                    ?>
                    <div class="readOnly">
                        <label for="dis-details">Dispatcher's Details:</label>
                        <textarea id="dis-details" name="dis-details" rows="8" cols="50" readonly><?php echo htmlspecialchars($taskDetailsDis); ?></textarea>
                    </div>
                    <?php
                    if (htmlspecialchars($_GET['status']) == 'Assigned to Security Officer' ||
                        htmlspecialchars($_GET['status']) == 'Accepted Tasks' ||
                        htmlspecialchars($_GET['status']) == 'Completed')  {
                        if(htmlspecialchars($_GET['status']) == 'Completed') {
                            echo "<div class=\"readOnly\">";
                        } else {
                            echo "<div class=\"labelAndTextarea\">";
                        }
                    ?>
                        <label for="sup-details">Details:</label>
                        <textarea id="sup-details" name="sup-details" rows="8" cols="50"><?php echo htmlspecialchars($taskDetailsSup); ?></textarea>
                    </div>
                    <?php
                        }
                    ?>
                    <br>
                    <div class="right-button">
                        <button type="button" onclick="cancelButton()">Back</button>
                        <?php
                        if (htmlspecialchars($_GET['status']) == 'Review Tasks') {
                        ?>
                            <button type="button" id="decline" onclick="declineTask()">
                                Decline
                            </button>
                            <button type="button" id="review-ok" onclick="reviewTask()">
                                Accept
                            </button>
                        <?php
                        } else if (htmlspecialchars($_GET['status']) == 'Accepted Tasks') {
                        ?>
                            <button type="button" id="assign-task" onclick="assignTask('table2')">
                                Assign Task
                            </button>
                        <?php
                        } else if (htmlspecialchars($_GET['status']) == 'Assigned to Security Officer') {
                        ?>
                            <button type="button" id="assign-task" onclick="updateTask('table2')">
                                Update Task
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