<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Security - Tasks</title>
    <!-- css -->
    <link rel="stylesheet" href="../styles/navigation.css" />
    <link rel="stylesheet" href="../styles/style.css" />
</head>
<style>
    .col12 {
        display: flex;
        flex-direction: row;
    }
</style>

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

                <div class="divtoggle">
                    <h2>Tasks List</h2>

                    <!-- put your code here -->
                    <button class="buttoggle" id="toggleViewButton"></button>
                </div>


                <div class="kanban_wrapper">
                    <div class="col1" id="TaskKanbanBody">

                        <!-- Please check my securityofficer.js file. -->
                    </div>

                </div>



                <div class="ListView">
                    <?php
                    require_once "../inc/dbconn.inc.php";

                    //Fetching data from databse

                    $sql = "SELECT T.taskId, T.dateCreated, T.taskName
                             FROM Task T JOIN Status S ON T.statusSup = S.statusId 
                             WHERE T.statusSup ='SUP03' AND T.securityOfficerId = $loginUserId
                             ORDER BY T.dateCreated DESC";
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
                                <th>Date Created</th>
                                <th>Task</th>
                            </tr>
                        </thead>
                        <tbody id="TaskTableBody">
                            <!-- Please check my securityofficer.js file. -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="cleardiv"></div>
    <script src="../js/securityofficer.js" defer></script>
</body>

</html>