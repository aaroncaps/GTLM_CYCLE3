<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administrator - Tasks</title>
    <!-- css -->
    <link rel="stylesheet" href="../styles/navigation.css" />
    <link rel="stylesheet" href="../styles/style.css" />

    <!-- js -->
    <script src="../js/core.js"></script>
    <script src="../js/dispatcher.js" defer></script>
    <script src="../js/calendar.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
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
                <a href="calendar.php">
                    <li>Calendar</li>
                </a>
                <!-- </a> -->
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
                <h2>Calendar</h2>
                <div class="calendar">
                    <div class="calendar-header">
                        <button id="prev">Previous</button>
                        <h1 id="month-year"></h1>
                        <button id="next">Next</button>
                    </div>
                    <table id="calendar-table">
                        <thead>
                            <tr>
                                <th>Sun</th>
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>Wed</th>
                                <th>Thu</th>
                                <th>Fri</th>
                                <th>Sat</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <form action="" id="selectedDateForm">
                    <button type="submit"> Show Tasks </button>
                </form>
                <div class="task-details">
                    <!-- HERE GOES THE PHP -->
                    <?php require_once "../inc/dbconn.inc.php";

                    $selectedCurrentDate = $_COOKIE["currentDateSelected"];
                    echo "<h2> Task for the date: $selectedCurrentDate </h2>";
                    // change string to date format
                    // $new_date = date('Y-m-d', strtotime($selectedCurrentDate));
                    // echo "<h2> Task for the date: $new_date </h2>";

                    $sql = "SELECT * FROM task 
                    WHERE dispatcherId = $loginUserId";
                    if ($result = mysqli_query($conn, $sql)){
                        // count the row   
                        $numberOfRows = mysqli_num_rows($result);
                        echo "<p> $numberOfRows </p>";
                        if ($numberOfRows > 1) {
                            echo "<ul class='eachTaskUL'>";
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<li class='eachTaskListCalendar'> 
                                    {$row['taskName']}
                                    <br/>
                                    {$row['taskDetailsDis']}
                                </li>";
                            }
                            echo "</ul>";
                        }
                        mysqli_free_result($result);
                    }
                    mysqli_close($conn);
                    ?>


                    <!-- <h2>Task Details for <span id="selected-date"></span></h2> -->


                    <!-- <ul id="task-list"></ul>
                    <input type="text" id="task-input" placeholder="Add a task" style="display: none;">
                    <button id="add-task" style="display: none;">Add Task</button> -->
                </div>
            </div>
        </div>
    </div>
    <div class="cleardiv"></div>
    <!-- -->
</body>

</html>