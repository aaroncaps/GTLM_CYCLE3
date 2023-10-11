<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Tasks</title>
    <!-- css -->
    <link rel="stylesheet" href="../styles/navigation.css" />
    <link rel="stylesheet" href="../styles/style.css" />
    

    <!-- js -->
    <script src="../js/core.js"></script>
    <script src="../js/admin.js" defer></script>
    

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
                <a href="event_logs.php">
                    <li>Event Logs</li>
                </a>
                <a href="system_settings.html">
                    <li>System Settings</li>
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
                        <a href="event_logs.php">
                            <li>Event Logs</li>
                        </a>
                        <a href="system_settings.html">
                            <li>System Settings</li>
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
            if (isset($_GET['messageError'])) {
                $error_message = $_GET['messageError'];
                echo '<div class="error-message">' . htmlspecialchars($error_message) . '</div>';
            } else if (isset($_GET['message'])) {
                $message = $_GET['message'];
                echo '<div class="success-message">' . htmlspecialchars($message) . '</div>';
            } 
        ?> 
                <div class="divtoggle">
                    <h2>Tasks</h2>
                   <div class="filterstatus">
                    <label for="statusFilter">Filter by Status:</label> 
                    <select id="statusFilter" class="select-box">
                        <option value="all">All</option>
                        <option value="ADM01">Onboarding</option>
                        
                        <option value="ADM02">Completed</option>
                    </select>
                   </div> 
                   <div>
                        <button id="listViewButton" class="view-button active">List</button>
                        <button id="kanbanViewButton" class="view-button">Kanban</button>  
                    </div>    
            
                </div>
                
                <?php
    
                require_once "../inc/dbconn.inc.php";
               
$sql = "SELECT n.requestId, n.dateRequest, n.fName, n.lName, s.status
FROM new_hires AS n
INNER JOIN status AS s ON n.statusId = s.statusId
WHERE s.statusId IN ('ADM01', 'ADM02')
AND (s.status = 'Onboarding' OR s.status = 'Completed')";

$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
$data[] = $row;
}
}

$conn->close();
?>


                <div id="listView" class="">
                    <table>
                        <thead>
                            <tr>
                                <th>Requested Number</th>
                                <th>Requested Date</th>
                                <th>Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="taskList" class="">
                          
                            <tbody id="taskList">
                            <?php
foreach ($data as $row) {
    echo '<tr>';
    echo '<td><a href="task_details.php?requestId=' . $row['requestId'] . '">';
    echo $row['requestId'] . '</a></td>';
    echo '<td>' . $row['dateRequest'] . '</td>';
    echo '<td>' . $row['fName'] . ' ' . $row['lName'] . '</td>';
    echo '<td>' . $row['status'] . '</td>';
    echo '</tr>';
}
?>

</tbody>

                    </table>
                </div>
                <div id="kanbanView" class="adminKanban">
                    <div class="kanban-columns">
                        <div class="kanban-column" data-status="Onboarding">
                            <span id="kanbanH2">
                                <h2 id="kanbanHeading">Onboarding</h2>
                            </span>
                            <?php
foreach ($data as $row) {
    echo '<tr>';
    echo '<td><a href="task_details.php?requestId=' . $row['requestId'] . '">';
    echo $row['requestId'] . '</a></td>';
    echo '<td>' . $row['dateRequest'] . '</td>';
    echo '<td>' . $row['fName'] . ' ' . $row['lName'] . '</td>';
    echo '<td>' . $row['status'] . '</td>';
    echo '</tr>';
}
?>


                            
                          
                        </div>
                       
                        <div class="kanban-column" data-status="Completed">
                            <h2>Completed</h2>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>       
    </div>        
</body>
</html>

