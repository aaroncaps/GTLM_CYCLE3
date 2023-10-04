<?php
session_start();
if(isset($_POST["user-id"]) && isset($_POST["password"])) {
    require_once "../inc/dbconn.inc.php";

    //Validate user id and password
    $sql = "SELECT userId, password, role, fName, lName FROM User WHERE userId=?";
    $statement = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($statement, $sql)) {
        mysqli_stmt_bind_param($statement, 's', $_POST["user-id"]);
        if (mysqli_stmt_execute($statement)) {
            mysqli_stmt_bind_result($statement, $userId, $password, $role, $fName, $lName);
            if (mysqli_stmt_fetch($statement)) {
                if($_POST["password"] === $password) {
                    if($role == 'Administrator') {
                        header("Location: ../administrator/tasks.php");
                    } else if($role == 'Dispatcher') {
                        header("Location: ../dispatcher/tasks.php");
                    } else if($role == 'Supervisor') {
                        header("Location: ../supervisor/tasks.php?");
                    } else if($role == 'Security Officer') {
                        header("Location: ../security_officer/tasks.php");
                    }
                    $_SESSION['loginUserId'] = $userId;
                    $_SESSION['loginName'] = $fName . ' ' . $lName;
                    mysqli_stmt_close($statement);

                    //Add Event Logs to be used by Administrator
                    $sql = "INSERT INTO Event_Logs (action, userId, timestamp) VALUES (?, ?, current_timestamp())";
                    $statement = mysqli_prepare($conn, $sql);
                    if ($statement) {
                        mysqli_stmt_bind_param($statement, "si", $action, $userId);
                        $action = "Logged in";
                        $userId = $userId;
                        $timestamp = null;
                        if (mysqli_stmt_execute($statement)) {
                            echo "Event_Logs User ID: " . $userId . " inserted successfully.<br>";
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
                    mysqli_close($conn);
                    exit();
                } else {
                    $error_message = "The User ID and/or Password you entered is incorrect. Please try again.";
                    header("Location: login.php?error=" . urlencode($error_message));
                    mysqli_stmt_close($statement);
                    mysqli_close($conn);
                    exit();
                }
            } else {
                $error_message = "The User ID and/or Password you entered is incorrect. Please try again.";
                header("Location: login.php?error=" . urlencode($error_message));
                mysqli_stmt_close($statement);
                mysqli_close($conn);
                exit();
            }
        } else {
            echo "Statement execution failed: " . mysqli_stmt_error($statement);
        }
        mysqli_stmt_close($statement);
    } else {
        echo "Statement preparation failed: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>
