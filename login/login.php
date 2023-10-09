<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- css -->
    <link rel="stylesheet" href="../styles/login.css">

    <title>Login Page</title>
</head>

<body>
    <?php
        require_once "../inc/dbconn.inc.php";
        $sql = "SELECT * FROM System_Settings ORDER BY timestamp DESC LIMIT 1";
        if($result = mysqli_query($conn, $sql)) {
            if(mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $loginMsg1 = $row['loginMsg1'];
                $loginMsg2 = $row['loginMsg2'];
                $loginMsg3 = $row['loginMsg3'];
                $loginMsg4 = $row['loginMsg4'];
                mysqli_free_result($result);
            }
        }
        mysqli_close($conn);
    ?>
    <div class="wrapper">
        <div class="left_section">
            <div class="left_section_content">
                <h1>Task Force Security</h1>
                <?php
                    echo "<p>" . $loginMsg1 . "</p>";
                ?>  
                <h3>Mission</h3>
                <?php
                    echo "<p>" . $loginMsg2 . "</p>";
                ?> 
                <br/>
                <a class="joinus" href="#">Join us & become a Security Officer</a>
            </div>
        </div>
        <div class="right_section">
            <div class="form_wrapper">
                <h1 class="header_mobile">Task Force Security</h1>
                <form action="login_check.php" method="POST">
                    <label class="form_label" for="user-id" id="label-user-id">User ID</label><br />
                    <input type="text" id="user-id" name="user-id" placeholder="Enter your User ID" required><br />
                    <label class="form_label" for="password" id="label-user-password">Password</label><br />
                    <input type="password" id="password" name="password" placeholder="Enter your Password"
                        required><br />
                    <?php
                        if (isset($_GET['error'])) {
                            $error_message = $_GET['error'];
                            echo '<div class="error-message">' . htmlspecialchars($error_message) . '</div>';
                        }
                    ?>
                    <button type="submit" class="login-button">Login</button>
                    <a href="#" class="forgot-password">Forgot password?</a>
                    <div class="contact_us">
                        <h2>Contact us</h2>
                        <?php
                            echo "<p>" . $loginMsg3 . "</p>";
                        ?>
                    </div>
                    <br/>
                    <?php
                        echo "<a class=\"joinus_mobile\" href=\"#\">" . $loginMsg4 . "</a>";
                    ?>
                </form>
            </div>
        </div>
    </div>
    <div class="cleardiv"></div>
</body>
</html>