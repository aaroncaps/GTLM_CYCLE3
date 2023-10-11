<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SO - Insert Reports</title>
    <!-- css -->
    <link rel="stylesheet" href="../styles/navigation.css" />
    <link rel="stylesheet" href="../styles/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
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

                <!-- put your code here -->

                <?php
                require_once "../inc/dbconn.inc.php";

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $taskId = $_POST['task'];
                    $reportText = $_POST['report'];


                    $uploadDir = 'upload/'. $_REQUEST['taskId'];
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $uploadedFile = $uploadDir . basename($_FILES['attachment']['name']);
                    move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadedFile);


                    $stmt = $conn->prepare("INSERT INTO report (taskId, userId, report, attachment, status, timestamp) VALUES (?, ?, ?, ?, ?, NOW())");
                    $stmt->bind_param("iisss", $taskId, $loginUserId, $reportText, $uploadedFile, $status);


                    $status = 'submitted by Security Officer';

                    if ($stmt->execute()) {
                        $sql = "UPDATE Task T SET T.statusSup ='SUP04' WHERE T.taskId = " . $_REQUEST['taskId'] . " LIMIT 1";
                        $result = $conn->query($sql);
                        $sql = "INSERT INTO Event_Logs (action, userId, timestamp) VALUES (?, ?, current_timestamp())";
                        $statement = mysqli_prepare($conn, $sql);
                        if ($statement) {
                            mysqli_stmt_bind_param($statement, "si", $action, $loginUserId);
                            $action = "Report submitted by security officer";
                            $timestamp = null;
                            if (mysqli_stmt_execute($statement)) {
                                echo "Event_Logs User ID: " . $loginUserId . " inserted successfully.<br>";
                            } else {
                                $messageError = "Error message";
                                header("Location: reports.php?messageError=" . urlencode($messageError) . "(" . mysqli_stmt_error($statement) . ")");
                                mysqli_stmt_close($statement);
                                mysqli_close($conn);
                                exit();
                            }
                            mysqli_stmt_close($statement);
                        } else {
                            echo "Error in SQL statement: " . mysqli_error($conn);
                        }
                        $stmt->close();
                        $conn->close();
                        $messageReview ="Report submitted successfully!";
                        header("Location: reports.php?message=" . urlencode($messageReview));
                        exit();
                    } else {
                        echo "Error: " . $conn->error;
                    }
                }
                $sql = "SELECT * FROM Task T WHERE T.statusSup ='SUP03' AND T.taskId = " . $_REQUEST['taskId'] . " LIMIT 1";
                $result = $conn->query($sql);
                $task =  $result->fetch_assoc();
                $result->free_result();

                ?>

                <div class="main_content">
                    <!-- Existing content -->
                    <h2>Reports</h2>
                    <h4>Insert Report</h4>
                    <div class="container mt-5">
                        <form action="" id="reportForm" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="id-task">Task ID:</label>
                                <input type="text" id="id-task" name="task" value="<?php echo $task['taskId'] ?? ''; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="task-name">Task Name:</label>
                                <input type="text" id="task-name" name="taskname" value="<?php echo isset($task['taskName']) ? htmlspecialchars($task['taskName']) : ''; ?>" readonly>
                            </div>

                            <span class="labelAndTextarea">
                                <label for="id-report">Suspicious Activity:</label>
                                <textarea id="id-report" name="report" rows="8" cols="50" required></textarea>
                            </span>

                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="validatedCustomFile" name="attachment" required onchange="displayImageNames(this)">
                                    <label class="custom-file-label" for="validatedCustomFile">Image</label>
                                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                                </div>
                            </div>
                            <p id="imageNames"></p>
                            <div class="right-button">
                                <button type="button" onclick="cancelButton()">Cancel</button>
                                <button type="submit" value="Upload Image" name="submit" id="createGroupBtn">Submit Report </button>

                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cleardiv"></div>
    <!-- Add this modal at the end of your `insert_report.html` -->


    <!-- -->
</body>

</html>