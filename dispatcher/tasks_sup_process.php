<?php
if (isset($_POST["assignToId"])) {
    echo "task-id: " . $_POST["task-id"];
    echo "<br>";
    echo "date-from: " . $_POST["date-from"];
    echo "<br>";
    echo "date-to: " . $_POST["date-to"];
    echo "<br>";
    echo "sup-details: " . $_POST["sup-details"];
    echo "<br>";
    echo "assignToId: " . $_POST["assignToId"];
    echo "<br>";

    require_once "../inc/dbconn.inc.php";
    session_start();
    $loginUserId = $_SESSION['loginUserId'];
    $taskId = $_POST["task-id"];
    $taskDetailsSup = $_POST["sup-details"];
    $assignToId = $_POST["assignToId"];
    $messageAssign = "Task assgined successfully!";
    $messageError = "Process  failed. Please try again.";

    // Delete any taskId in the Report if there is
    $sql = "DELETE FROM Report WHERE taskId = ?";
    $statement = mysqli_prepare($conn, $sql);
    if ($statement) {
        mysqli_stmt_bind_param($statement, 'i', $taskId);
        if (mysqli_stmt_execute($statement)) {
            echo "Report Task ID: " . $taskId . " deleted successfully.<br>";
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
    
    // Insert into the table Report for Dispatcher
    $sql = "INSERT INTO Report (taskId, userId, status) VALUES (?, ?, 'Pending')";
    $statement = mysqli_prepare($conn, $sql);
    if ($statement) {
        mysqli_stmt_bind_param($statement, 'ii', $taskId ,$loginUserId);
        if (mysqli_stmt_execute($statement)) {
            echo "Report Dispatcher User ID: " . $loginUserId . " inserted successfully.<br>";
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

    // Insert into the table Report for Supervisor
    $sql = "INSERT INTO Report (taskId, userId, status) VALUES (?, ?, 'Pending')";
    $statement = mysqli_prepare($conn, $sql);
    if ($statement) {
        mysqli_stmt_bind_param($statement, 'ii', $taskId ,$assignToId);
        if (mysqli_stmt_execute($statement)) {
            echo "Report Supervisor User ID: " . $assignToId . " inserted successfully.<br>";
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

    //Update Task to change the status and add dispatcher details
    $sql = "UPDATE Task SET statusDis = 'DIS02', statusSup = 'SUP01', taskDetailsDis = ?, supervisorId = ? WHERE taskId = ?";
    $statement = mysqli_prepare($conn, $sql);
    if ($statement) {
        mysqli_stmt_bind_param($statement, 'sii', $taskDetailsSup, $assignToId, $taskId );
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
    header("Location: tasks.php?message=" . urlencode($messageAssign));
    mysqli_close($conn);
    exit();
}
?>