<?php
if (isset($_POST["option"])) {
    echo "option: " . $_POST["option"];
    echo "<br>";
    echo "task-id: " . $_POST["task-id"];
    echo "<br>";
    echo "decline-reason: " . $_POST["decline-reason"];
    echo "<br>";
    echo "user-ids-input: " . $_POST["user-ids-input"];
    echo "<br>";
    echo "user-ids-remove: " . $_POST["user-ids-remove"];
    echo "<br>";
    echo "date-from: " . $_POST["date-from"];
    echo "<br>";
    echo "date-to: " . $_POST["date-to"];
    echo "<br>";
    echo "schedule-id: " . $_POST["schedule-id"];
    echo "<br>";
    echo "sup-details: " . $_POST["sup-details"];
    echo "<br>";
    echo "sup-details-orig: " . $_POST["sup-details-orig"];
    echo "<br>";

    require_once "../inc/dbconn.inc.php";
    session_start();
    $loginUserId = $_SESSION['loginUserId'];
    $taskId = $_POST["task-id"];
    $taskDetailsSup = $_POST["sup-details"];
    $taskDetailsSupOrig =  $_POST["sup-details-orig"];
    $declineReason = $_POST["decline-reason"];
    $scheduleId = $_POST["schedule-id"];
    $messageDecline = "Task declined successfully!";
    $messageReview = "Task accepted successfully!";
    $messageAssign = "Task assgined successfully!";
    $messageUpdate = "Task updated successfully!";
    $messageError = "Process  failed. Please try again.";
    if($_POST["option"] == 'review') {
        $sql = "UPDATE Task SET statusSup = 'SUP02' WHERE taskId = ?";
        $statement = mysqli_prepare($conn, $sql);
        if ($statement) {
            mysqli_stmt_bind_param($statement, 's', $taskId);
            if (mysqli_stmt_execute($statement)) {
                echo "Task taskId: " . $taskId . " updated successfully.<br>";
            } else {
                header("Location: tasks.php?messageError=" . urlencode($messageError) . "(" . mysqli_stmt_error($statement) . ")");
                mysqli_stmt_close($statement);
                mysqli_close($conn);
                exit();
            }
            mysqli_stmt_close($statement);
        } else {
            echo "Error in SQL statement: " . mysqli_error($conn);
        }
        
        //Add Event Logs to be used by Administrator
        $sql = "INSERT INTO Event_Logs (action, userId, timestamp) VALUES (?, ?, current_timestamp())";
        $statement = mysqli_prepare($conn, $sql);
        if ($statement) {
            mysqli_stmt_bind_param($statement, "si", $action, $loginUserId);
            $action = "Task reviewed by supervisor";
            $timestamp = null;
            if (mysqli_stmt_execute($statement)) {
                echo "Event_Logs User ID: " . $loginUserId . " inserted successfully.<br>";
            } else {
                $messageError = "Error message";
                header("Location: tasks.php?messageError=" . urlencode($messageError) . "(" . mysqli_stmt_error($statement) . ")");
                mysqli_stmt_close($statement);
                mysqli_close($conn);
                exit();
            }
            mysqli_stmt_close($statement);
        } else {
            echo "Error in SQL statement: " . mysqli_error($conn);
        }
        header("Location: tasks.php?message=" . urlencode($messageReview));
    } else if($_POST["option"] == 'assign') {
        // Get the maximum value of scheduleId to set the next insertion of User_Schedule
        $sql = "SELECT MAX(scheduleId) as maxScheduleId FROM User_Schedule";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if ($row['maxScheduleId'] === null) {
            $maxScheduleId = 40000; 
        } else {
            $maxScheduleId = $row['maxScheduleId'];
        }
        $scheduleId = $maxScheduleId + 1;
        echo "scheduleId: " . $scheduleId . "<br>";

        //Insert into the table User_Schedule
        $sql = "INSERT INTO User_Schedule (scheduleId, userId, dateFrom, dateTo, timestamp) VALUES (?, ?, ?, ?, current_timestamp())";
        $statement = mysqli_prepare($conn, $sql);
        if ($statement) {
            $userIds = explode(',', $_POST["user-ids-input"]);
            foreach ($userIds as $userId) {
                mysqli_stmt_bind_param($statement, 'iiss', $scheduleId, $userId, $_POST["date-from"], $_POST["date-to"]);
                if (mysqli_stmt_execute($statement)) {
                    echo "User_Schedule User ID: " . $userId . " inserted successfully.<br>";
                } else {
                    header("Location: tasks.php?messageError=" . urlencode($messageError) . "(" . mysqli_stmt_error($statement) . ")");
                    mysqli_stmt_close($statement);
                    mysqli_close($conn);
                    exit();
                }
            }
            mysqli_stmt_close($statement);
        } else {
            echo "Error in SQL statement: " . mysqli_error($conn);
        }

        // Insert into the table Report
        $sql = "INSERT INTO Report (taskId, userId, status) VALUES (?, ?, 'Pending')";
        $statement = mysqli_prepare($conn, $sql);
        if ($statement) {
            $userIds = explode(',', $_POST["user-ids-input"]);
            foreach ($userIds as $userId) {
                mysqli_stmt_bind_param($statement, 'ii', $taskId ,$userId);
                if (mysqli_stmt_execute($statement)) {
                    echo "Report User ID: " . $userId . " inserted successfully.<br>";
                } else {
                    header("Location: tasks.php?messageError=" . urlencode($messageError) . "(" . mysqli_stmt_error($statement) . ")");
                    mysqli_stmt_close($statement);
                    mysqli_close($conn);
                    exit();
                }
            }
            mysqli_stmt_close($statement);
        } else {
            echo "Error in SQL statement: " . mysqli_error($conn);
        }

        //Update Task to change the status and add supervisor details
        $sql = "UPDATE Task SET statusSup = 'SUP03', taskDetailsSup = ?, scheduleId = ? WHERE taskId = ?";
        $statement = mysqli_prepare($conn, $sql);
        if ($statement) {
            mysqli_stmt_bind_param($statement, 'ssi', $taskDetailsSup, $scheduleId, $taskId );
            if (mysqli_stmt_execute($statement)) {
                echo "Task taskId: " . $taskId . " updated successfully.<br>";
            } else {
                header("Location: tasks.php?messageError=" . urlencode($messageError) . "(" . mysqli_stmt_error($statement) . ")");
                mysqli_stmt_close($statement);
                mysqli_close($conn);
                exit();
            }
            mysqli_stmt_close($statement);
        }

        //Add Event Logs to be used by Administrator
        $sql = "INSERT INTO Event_Logs (action, userId, timestamp) VALUES (?, ?, current_timestamp())";
        $statement = mysqli_prepare($conn, $sql);
        if ($statement) {
            mysqli_stmt_bind_param($statement, "si", $action, $loginUserId);
            $action = "Task assigned by supervisor";
            $timestamp = null;
            if (mysqli_stmt_execute($statement)) {
                echo "Event_Logs User ID: " . $loginUserId . " inserted successfully.<br>";
            } else {
                $messageError = "Error message";
                header("Location: tasks.php?messageError=" . urlencode($messageError) . "(" . mysqli_stmt_error($statement) . ")");
                mysqli_stmt_close($statement);
                mysqli_close($conn);
                exit();
            }
            mysqli_stmt_close($statement);
        } else {
            echo "Error in SQL statement: " . mysqli_error($conn);
        }
        header("Location: tasks.php?message=" . urlencode($messageReview));
    }  else if($_POST["option"] == 'update') {
        //Update supervisor details
        if($taskDetailsSupOrig != $taskDetailsSup) {
            $sql = "UPDATE Task SET taskDetailsSup = ? WHERE taskId = ?";
            $statement = mysqli_prepare($conn, $sql);
            if ($statement) {
                mysqli_stmt_bind_param($statement, 'ss', $taskDetailsSup, $taskId);
                if (mysqli_stmt_execute($statement)) {
                    echo "Task taskId: " . $taskId . " updated successfully.<br>";
                } else {
                    header("Location: tasks.php?messageError=" . urlencode($messageError) . "(" . mysqli_stmt_error($statement) . ")");
                    mysqli_stmt_close($statement);
                    mysqli_close($conn);
                    exit();
                }
                mysqli_stmt_close($statement);
            } else {
                echo "Error in SQL statement: " . mysqli_error($conn);
            }
        }

        
        if($_POST["user-ids-input"] != '') {
            //Insert into the table User_Schedule
            $sql = "INSERT INTO User_Schedule (scheduleId, userId, dateFrom, dateTo, timestamp) VALUES (?, ?, ?, ?, current_timestamp())";
            $statement = mysqli_prepare($conn, $sql);
            if ($statement) {
                $userIds = explode(',', $_POST["user-ids-input"]);
                foreach ($userIds as $userId) {
                    mysqli_stmt_bind_param($statement, 'iiss', $scheduleId, $userId, $_POST["date-from"], $_POST["date-to"]);
                    if (mysqli_stmt_execute($statement)) {
                        echo "User_Schedule User ID: " . $userId . " inserted successfully.<br>";
                    } else {
                        header("Location: tasks.php?messageError=" . urlencode($messageError) . "(" . mysqli_stmt_error($statement) . ")");
                        mysqli_stmt_close($statement);
                        mysqli_close($conn);
                        exit();
                    }
                }
                mysqli_stmt_close($statement);
            } else {
                echo "Error in SQL statement: " . mysqli_error($conn);
            }

            //Insert into the table Report
            $sql = "INSERT INTO Report (taskId, userId, status) VALUES (?, ?, 'Pending')";
            $statement = mysqli_prepare($conn, $sql);
            if ($statement) {
                $userIds = explode(',', $_POST["user-ids-input"]);
                foreach ($userIds as $userId) {
                    mysqli_stmt_bind_param($statement, 'ii', $taskId ,$userId);
                    if (mysqli_stmt_execute($statement)) {
                        echo "Report User ID: " . $userId . " inserted successfully.<br>";
                    } else {
                        header("Location: tasks.php?messageError=" . urlencode($messageError) . "(" . mysqli_stmt_error($statement) . ")");
                        mysqli_stmt_close($statement);
                        mysqli_close($conn);
                        exit();
                    }
                }
                mysqli_stmt_close($statement);
            } else {
                echo "Error in SQL statement: " . mysqli_error($conn);
            }
        }

        if($_POST["user-ids-remove"] != '') {
            //Delete row in the table User_Schedule
            $sql = "DELETE FROM User_Schedule WHERE scheduleId = ? AND userId = ?";
            $statement = mysqli_prepare($conn, $sql);
            if ($statement) {
                $userIds = explode(',', $_POST["user-ids-remove"]);
                foreach ($userIds as $userId) {
                    mysqli_stmt_bind_param($statement, 'ii', $scheduleId, $userId);
                    if (mysqli_stmt_execute($statement)) {
                        echo "User_Schedule User ID: " . $userId . " deleted successfully.<br>";
                    } else {
                        header("Location: tasks.php?messageError=" . urlencode($messageError) . "(" . mysqli_stmt_error($statement) . ")");
                        mysqli_stmt_close($statement);
                        mysqli_close($conn);
                        exit();
                    }
                }
                mysqli_stmt_close($statement);
            } else {
                echo "Error in SQL statement: " . mysqli_error($conn);
            }

            //Count if there are still remaining User_Schedule for a particular scheduleId
            $rowCount = null;
            $sql = "SELECT COUNT(*) as count FROM User_Schedule WHERE scheduleId = ?";
            $statement = mysqli_prepare($conn, $sql);
            if ($statement) {
                mysqli_stmt_bind_param($statement, 'i', $scheduleId);
                if (mysqli_stmt_execute($statement)) {
                    $result = mysqli_stmt_get_result($statement);
                    $row = mysqli_fetch_assoc($result);
                    $rowCount = $row['count'];
                } else {
                    header("Location: tasks.php?messageError=" . urlencode($messageError) . "(" . mysqli_stmt_error($statement) . ")");
                    mysqli_stmt_close($statement);
                    mysqli_close($conn);
                    exit();
                }
                mysqli_stmt_close($statement);
            }
            if ($rowCount === 0) {
                echo "There are no more rows in User_Schedule for scheduleId: " . $scheduleId;
                $sql = "UPDATE Task SET statusSup = 'SUP02', scheduleId = NULL WHERE taskId = ?";
                $statement = mysqli_prepare($conn, $sql);
                if ($statement) {
                    mysqli_stmt_bind_param($statement, 's', $taskId);
                    if (mysqli_stmt_execute($statement)) {
                        echo "Task taskId: " . $taskId . " updated successfully.<br>";
                    } else {
                        header("Location: tasks.php?messageError=" . urlencode($messageError) . "(" . mysqli_stmt_error($statement) . ")");
                        mysqli_stmt_close($statement);
                        mysqli_close($conn);
                        exit();
                    }
                    mysqli_stmt_close($statement);
                } else {
                    echo "Error in SQL statement: " . mysqli_error($conn);
                }
            } 

            //Delete row in the table User_Schedule
            $sql = "DELETE FROM Report WHERE taskId = ? AND userId = ?";
            $statement = mysqli_prepare($conn, $sql);
            if ($statement) {
                $userIds = explode(',', $_POST["user-ids-remove"]);
                foreach ($userIds as $userId) {
                    mysqli_stmt_bind_param($statement, 'ii', $taskId, $userId);
                    if (mysqli_stmt_execute($statement)) {
                        echo "Report User ID: " . $userId . " deleted successfully.<br>";
                    } else {
                        header("Location: tasks.php?messageError=" . urlencode($messageError) . "(" . mysqli_stmt_error($statement) . ")");
                        mysqli_stmt_close($statement);
                        mysqli_close($conn);
                        exit();
                    }
                }
                mysqli_stmt_close($statement);
            } else {
                echo "Error in SQL statement: " . mysqli_error($conn);
            }
        }
        
        //Add Event Logs to be used by Administrator
        $sql = "INSERT INTO Event_Logs (action, userId, timestamp) VALUES (?, ?, current_timestamp())";
        $statement = mysqli_prepare($conn, $sql);
        if ($statement) {
            mysqli_stmt_bind_param($statement, "si", $action, $loginUserId);
            $action = "Task updated by supervisor";
            $timestamp = null;
            if (mysqli_stmt_execute($statement)) {
                echo "Event_Logs User ID: " . $loginUserId . " inserted successfully.<br>";
            } else {
                $messageError = "Error message";
                header("Location: tasks.php?messageError=" . urlencode($messageError) . "(" . mysqli_stmt_error($statement) . ")");
                mysqli_stmt_close($statement);
                mysqli_close($conn);
                exit();
            }
            mysqli_stmt_close($statement);
        } else {
            echo "Error in SQL statement: " . mysqli_error($conn);
        }
        header("Location: tasks.php?message=" . urlencode($messageUpdate));
    }  else if($_POST["option"] == 'decline') {
        $sql = "UPDATE Task SET statusSup = 'DIS03', declineReason = ? WHERE taskId = ?";
        $statement = mysqli_prepare($conn, $sql);
        if ($statement) {
            mysqli_stmt_bind_param($statement, 'ss', $declineReason, $taskId);
            if (mysqli_stmt_execute($statement)) {
                echo "Task taskId: " . $taskId . " updated successfully.<br>";
            } else {
                header("Location: tasks.php?messageError=" . urlencode($messageError) . "(" . mysqli_stmt_error($statement) . ")");
                mysqli_stmt_close($statement);
                mysqli_close($conn);
                exit();
            }
            mysqli_stmt_close($statement);
        } else {
            echo "Error in SQL statement: " . mysqli_error($conn);
        }

        //Add Event Logs to be used by Administrator
        $sql = "INSERT INTO Event_Logs (action, userId, timestamp) VALUES (?, ?, current_timestamp())";
        $statement = mysqli_prepare($conn, $sql);
        if ($statement) {
            mysqli_stmt_bind_param($statement, "si", $action, $loginUserId);
            $action = "Task declined by supervisor";
            $timestamp = null;
            if (mysqli_stmt_execute($statement)) {
                echo "Event_Logs User ID: " . $loginUserId . " inserted successfully.<br>";
            } else {
                $messageError = "Error message";
                header("Location: tasks.php?messageError=" . urlencode($messageError) . "(" . mysqli_stmt_error($statement) . ")");
                mysqli_stmt_close($statement);
                mysqli_close($conn);
                exit();
            }
            mysqli_stmt_close($statement);
        } else {
            echo "Error in SQL statement: " . mysqli_error($conn);
        }

        header("Location: tasks.php?message=" . urlencode($messageDecline));
    }
    mysqli_close($conn);
    exit();
}
?>