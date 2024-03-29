<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Event logs</title>
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
                <a href="system_settings.html"><li>System Settings</li></a>
                
            </ul>
        </div>
        <div class="right_content">
            <div class="upper_navbar">
                <!-- hamurger menu starts -->
                <i class="fa-solid fa-bars" onclick="handleHamburger()"></i>
                <i class="fa-solid fa-xmark" onclick="handleXmark()"></i>
                <!-- hamburger menu ends -->
                <a href="../profile/profile.php">Profile</a>
                <a href="../profile/profile.php">Help & Support</a>
                <a href="../login/logout.php">Logout</a>
            </div>
            <div class="main_content">
                <div class="mobile_menu">
                    <ul>
                        <a href="tasks.php"><li>Tasks</li></a>
                        <a href="event_logs.php"><li>Event Logs</li></a>
                        <a href="system_settings.html">System Settings</a>
                        <a href="../profile/profile.php"><li>Profile</li></a>
                        <a href="../profile/profile.php">Help & Support</li></a>
                        <a href="../login/logout.php"><li>Logout</li></a>
                    </ul>
                </div>
                
                <div class="divtoggle">
                    <h2>Event Logs</h2>
                </div>

                <div class="search-bar">
            <div class="search-input">
                <label for="dateFrom">Date From: </label>
                <input type="date" id="dateFrom">
            </div>
            <div class="search-input">
                <label for="dateTo">Date To: </label>
                <input type="date" id="dateTo">
            </div>
            <div class="search-input">
                <label for="userName">User Name</label>
                <input type="text" id="userName">
            </div>
            <button type="button" id="searchButton">Search</button>
        </div>

        <table class="event-log-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Action</th>
                    <th>User</th>
                    <th>Role</th>
                </tr>
            </thead>
                    <tbody id="eventLogData">
    <?php
    require_once "../inc/dbconn.inc.php";

    
    if (isset($conn)) {
        $sql = "SELECT event_logs.*, user.fName, user.lName, user.role AS user_role FROM event_logs
                JOIN user ON event_logs.userid = user.userid"; 

        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            // Add code to format date and time
            $timestamp = $row['timestamp'];
            $date = date('Y-m-d', strtotime($timestamp));
            $time = date('H:i:s', strtotime($timestamp));

            echo '<tr>';
            echo '<td>' . $date . '</td>';
            echo '<td>' . $time . '</td>';
            echo '<td>' . $row['action'] . '</td>';
            echo '<td>' . $row['fName'] . ' ' . $row['lName'] . '</td>'; 
            echo '<td>' . $row['user_role'] . '</td>'; // 
            echo '</tr>';
        }

        $conn->close();
    } else {
        
        echo "Failed to connect to the database.";
    }
    ?>
</tbody>


                </table>
            
                <div class="right-button">
                    <button type="button" id="saveButton" class="right-button">Save</button>
                </div>


                
                
            </div>
        </div>
    </div>
    <div class="cleardiv"></div>
    <!-- -->
    
</body>

</html>