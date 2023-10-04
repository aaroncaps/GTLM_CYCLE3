<?php
if (isset($_POST["user-id"]) && isset($_POST["task-id"])) {
    echo "user-id: " . $_POST["user-id"];
    echo "<br>";
    echo "task-id: " . $_POST["task-id"];
    echo "<br>";
    echo "id-report-sup: " . $_POST["id-report-sup"];
    echo "<br>";

    require_once "../inc/dbconn.inc.php";
    session_start();
    $loginUserId = $_SESSION['loginUserId'];
    $userId = $_POST["user-id"];
    $taskId = $_POST["task-id"];
    $reportSup = $_POST["id-report-sup"];
    $allCompleted = false;
    $messageSuccess = "Report submitted successfully!";
    $messageError = "Process  failed. Please try again.";

    //Updates the Report status of each SO to Completed
    $sql = "UPDATE Report SET statusSO = 'Completed', statusSup = 'Submitted', reportSup = ?, timestampSup = current_timestamp() WHERE taskId = ? AND userId = ?";
    $statement = mysqli_prepare($conn, $sql);
    if ($statement) {
        mysqli_stmt_bind_param($statement, 'sii', $reportSup, $taskId, $userId);
        if (mysqli_stmt_execute($statement)) {
            echo "Report taskId: " . $taskId . " updated successfully.<br>";
        } else {
            header("Location: reports.php?messageError=" . urlencode($messageError) . "(" . mysqli_stmt_error($statement) . ")");
            mysqli_stmt_close($statement);
            mysqli_close($conn);
            exit();
        }
        mysqli_stmt_close($statement);
    } else {
        echo "Error in SQL statement: " . mysqli_error($conn);
    }

    //Check if every task report of a particular taskId has been completed
    $sql = "SELECT taskId, 
            CASE WHEN COUNT(*) = SUM(CASE WHEN statusSO = 'Completed' THEN 1 ELSE 0 END) 
                THEN 1 
                ELSE 0 
            END AS all_completed
            FROM Report
            WHERE taskId = ?
            GROUP BY taskId";
    $statement = mysqli_prepare($conn, $sql);
    if ($statement) {
        mysqli_stmt_bind_param($statement, 's', $taskId);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $row = mysqli_fetch_assoc($result);
    
        if ($row) {
            echo "Task ID: " . $row['taskId'] . "<br>";
            echo "All Completed: " . $row['all_completed'] . "<br>";
            $allCompleted = $row['all_completed'];
        } else {
            header("Location: reports.php?messageError=" . urlencode($messageError) . "(" . mysqli_stmt_error($statement) . ")");
            mysqli_stmt_close($statement);
            mysqli_close($conn);
            exit();
        }
        mysqli_stmt_close($statement);
    } else {
        echo "Error in SQL statement: " . mysqli_error($conn);
    }

    //Update the status to Completed
    if($allCompleted) {
        $sql = "UPDATE Task SET statusSup = 'SUP04' WHERE taskId = ?";
        $statement = mysqli_prepare($conn, $sql);
        if ($statement) {
            mysqli_stmt_bind_param($statement, 's', $taskId);
            if (mysqli_stmt_execute($statement)) {
                echo "Task taskIdId: " . $taskId . " updated successfully.<br>";
            } else {
                header("Location: reports.php?messageError=" . urlencode($messageError) . "(" . mysqli_stmt_error($statement) . ")");
                mysqli_stmt_close($statement);
                mysqli_close($conn);
                exit();
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
        $action = "Report updated by supervisor";
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

    header("Location: reports.php?message=" . urlencode($messageSuccess));
    mysqli_close($conn);
    exit();
}
?>