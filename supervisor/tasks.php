<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Supervisor - Tasks</title>
  <!-- css -->
  <link rel="stylesheet" href="../styles/navigation.css" />
  <link rel="stylesheet" href="../styles/style.css" />

  <!-- js -->
  <script src="../js/core.js"></script>
  <script src="../js/supervisor.js" defer></script>
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
        <a href="../login/login.php">Logout</a>
      </div>
      <div class="upper_navbar_user">
        <?php
        session_start();
        $loginUserId = $_SESSION['loginUserId'];
        $loginName = $_SESSION['loginName'];
        echo 'Welcome, ' . $loginName;
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
            <a href="../login/login.php">
              <li>Logout</li>
            </a>
          </ul>
        </div>
        <h2>Tasks</h2>
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
          <div class="filterstatus">
            <label for="filterdropdown">Filter by status:</label>
            <select id="filterdropdown" name="Status">
              <option value="All">All</option>
              <option value="Review Task">Review Tasks</option>
              <option value="Accepted Tasks">Accepted Tasks</option>
              <option value="Assigned to Security Officer">Assigned to Security Officer</option>
              <option value="Completed">Completed</option>
            </select>
          </div>
          <div></div>
          <button class="buttoggle" id="toggleViewButton"></button>
        </div>
        <form>
        <?php
          require_once "../inc/dbconn.inc.php";
          
          //Retrieve all tasks the belong to the login user

          $sql = "SELECT T.taskId, T.dateCreated, T.taskName, T.scheduleId, S.status
                  FROM Task T JOIN Status S ON T.statusSup = S.statusId 
                  WHERE T.statusSup IN ('SUP01','SUP02','SUP03','SUP04') AND T.supervisorId = $loginUserId
                  ORDER BY T.dateCreated DESC";
          $tasks = [];
          if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                $tasks[] = $row;
                if($row['status'] == 'Review Tasks') {
                  $reviewTask[] = $row;
                } else if($row['status'] == 'Accepted Tasks') {
                  $acceptTask[] = $row;
                } else if($row['status'] == 'Assigned to Security Officer') {
                  $assginTask[] = $row;
                } else if($row['status'] == 'Completed') {
                  $completeTask[] = $row;
                }
              }
              mysqli_free_result($result);
            }
          }
        ?>
          <div class="kanban_wrapper">
            <div class="col1">
              <div class="title">Review Tasks</div>
              <?php
              foreach ($reviewTask as $task) :
                $sql = "SELECT U.userId, U.fName, U.lName
                        FROM User U
                        JOIN User_Schedule US ON U.userId = US.userId
                        JOIN Task T ON US.scheduleId = T.scheduleId
                        WHERE T.scheduleId = ?";
                $statement = mysqli_stmt_init($conn);
                $users = [];
                if (mysqli_stmt_prepare($statement, $sql)) {
                    mysqli_stmt_bind_param($statement, 'i', $task['scheduleId']);
                    if (mysqli_stmt_execute($statement)) {
                        $result = mysqli_stmt_get_result($statement);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $users[] = $row;
                        }
                    }
                    mysqli_stmt_close($statement);
                }
              ?>
                <div class="list" draggable="false">
                <div class="information">
                  <h4><?php echo (isset($task['taskId']) ? htmlspecialchars($task['taskId']) : ''); ?></h4>
                  <p><span>Date Created:</span>
                  <?php
                    if (isset($task['dateCreated'])) {
                        $dateCreated = date('d-m-Y', strtotime($task['dateCreated']));
                        echo htmlspecialchars($dateCreated);
                    } else {
                        echo '';
                    }
                    ?>
                  </p>
                  <p><span>Task:</span><?php echo (isset($task['taskName']) ? htmlspecialchars($task['taskName']) : ''); ?></p>
                  <p><span>Assigned To:</span>
                  <?php                   
                    if(count($users) > 1) {
                      echo (isset($task['scheduleId']) ? 'Group ' . htmlspecialchars($task['scheduleId']) : '-');
                    } else {
                      $user = $users[0];
                      echo (isset($user['fName']) && isset($user['fName']) ? htmlspecialchars($user['fName']) . ' ' . htmlspecialchars($user['lName']) : '-');
                    }
                  ?>
                  </p>
                </div>
              </div>
              <?php
              endforeach;
              ?>
            </div>
            <div class="col2">
              <div class="title">Accepted Tasks</div>
              <?php
              foreach ($acceptTask as $task) :
                $sql = "SELECT U.userId, U.fName, U.lName
                        FROM User U
                        JOIN User_Schedule US ON U.userId = US.userId
                        JOIN Task T ON US.scheduleId = T.scheduleId
                        WHERE T.scheduleId = ?";
                $statement = mysqli_stmt_init($conn);
                $users = [];
                if (mysqli_stmt_prepare($statement, $sql)) {
                    mysqli_stmt_bind_param($statement, 'i', $task['scheduleId']);
                    if (mysqli_stmt_execute($statement)) {
                        $result = mysqli_stmt_get_result($statement);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $users[] = $row;
                        }
                    }
                    mysqli_stmt_close($statement);
                }
              ?>
                <div class="list" draggable="false">
                <div class="information">
                  <h4><?php echo (isset($task['taskId']) ? htmlspecialchars($task['taskId']) : ''); ?></h4>
                  <p><span>Date Created:</span>
                  <?php
                    if (isset($task['dateCreated'])) {
                        $dateCreated = date('d-m-Y', strtotime($task['dateCreated']));
                        echo htmlspecialchars($dateCreated);
                    } else {
                        echo '';
                    }
                    ?>
                  </p>
                  <p><span>Task:</span><?php echo (isset($task['taskName']) ? htmlspecialchars($task['taskName']) : ''); ?></p>
                  <p><span>Assigned To:</span>
                  <?php                   
                    if(count($users) > 1) {
                      echo (isset($task['scheduleId']) ? 'Group ' . htmlspecialchars($task['scheduleId']) : '-');
                    } else {
                      $user = $users[0];
                      echo (isset($user['fName']) && isset($user['fName']) ? htmlspecialchars($user['fName']) . ' ' . htmlspecialchars($user['lName']) : '-');
                    }
                  ?>
                  </p>
                </div>
              </div>
              <?php
              endforeach;
              ?>
            </div>
            <div class="col3">
              <div class="title">Assigned to Security Officer</div>
              <?php
              foreach ($assginTask as $task) :
                $sql = "SELECT U.userId, U.fName, U.lName
                        FROM User U
                        JOIN User_Schedule US ON U.userId = US.userId
                        JOIN Task T ON US.scheduleId = T.scheduleId
                        WHERE T.scheduleId = ?";
                $statement = mysqli_stmt_init($conn);
                $users = [];
                if (mysqli_stmt_prepare($statement, $sql)) {
                    mysqli_stmt_bind_param($statement, 'i', $task['scheduleId']);
                    if (mysqli_stmt_execute($statement)) {
                        $result = mysqli_stmt_get_result($statement);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $users[] = $row;
                        }
                    }
                    mysqli_stmt_close($statement);
                }
              ?>
                <div class="list" draggable="false">
                <div class="information">
                  <h4><?php echo (isset($task['taskId']) ? htmlspecialchars($task['taskId']) : ''); ?></h4>
                  <p><span>Date Created:</span>
                  <?php
                    if (isset($task['dateCreated'])) {
                        $dateCreated = date('d-m-Y', strtotime($task['dateCreated']));
                        echo htmlspecialchars($dateCreated);
                    } else {
                        echo '';
                    }
                    ?>
                  </p>
                  <p><span>Task:</span><?php echo (isset($task['taskName']) ? htmlspecialchars($task['taskName']) : ''); ?></p>
                  <p><span>Assigned To:</span>
                  <?php                   
                    if(count($users) > 1) {
                      echo (isset($task['scheduleId']) ? 'Group ' . htmlspecialchars($task['scheduleId']) : '-');
                    } else {
                      $user = $users[0];
                      echo (isset($user['fName']) && isset($user['fName']) ? htmlspecialchars($user['fName']) . ' ' . htmlspecialchars($user['lName']) : '-');
                    }
                  ?>
                  </p>
                </div>
              </div>
              <?php
              endforeach;
              ?>
            </div>
            <div class="col4">
              <div class="title">Completed</div>
              <?php
              foreach ($completeTask as $task) :
                $sql = "SELECT U.userId, U.fName, U.lName
                        FROM User U
                        JOIN User_Schedule US ON U.userId = US.userId
                        JOIN Task T ON US.scheduleId = T.scheduleId
                        WHERE T.scheduleId = ?";
                $statement = mysqli_stmt_init($conn);
                $users = [];
                if (mysqli_stmt_prepare($statement, $sql)) {
                    mysqli_stmt_bind_param($statement, 'i', $task['scheduleId']);
                    if (mysqli_stmt_execute($statement)) {
                        $result = mysqli_stmt_get_result($statement);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $users[] = $row;
                        }
                    }
                    mysqli_stmt_close($statement);
                }
              ?>
                <div class="list" draggable="false">
                <div class="information">
                  <h4><?php echo (isset($task['taskId']) ? htmlspecialchars($task['taskId']) : ''); ?></h4>
                  <p><span>Date Created:</span>
                  <?php
                    if (isset($task['dateCreated'])) {
                        $dateCreated = date('d-m-Y', strtotime($task['dateCreated']));
                        echo htmlspecialchars($dateCreated);
                    } else {
                        echo '';
                    }
                    ?>
                  </p>
                  <p><span>Task:</span><?php echo (isset($task['taskName']) ? htmlspecialchars($task['taskName']) : ''); ?></p>
                  <p><span>Assigned To:</span>
                  <?php                   
                    if(count($users) > 1) {
                      echo (isset($task['scheduleId']) ? 'Group ' . htmlspecialchars($task['scheduleId']) : '-');
                    } else {
                      $user = $users[0];
                      echo (isset($user['fName']) && isset($user['fName']) ? htmlspecialchars($user['fName']) . ' ' . htmlspecialchars($user['lName']) : '-');
                    }
                  ?>
                  </p>
                </div>
              </div>
              <?php
              endforeach;
              ?>
            </div>
          </div>

          <div class="ListView">
            <table id="tasktable">
              <thead>
                <tr>
                  <th>Task ID</th>
                  <th>Date Created</th>
                  <th>Task</th>
                  <th>Status</th>
                  <th>Assigned To</th>
                </tr>
              </thead>
              <tbody id="TaskTableBody">
                <?php
                foreach ($tasks as $task) :
                  // echo "taskId: " . $task['taskId'] . " dateCreated: " . $task['dateCreated'] .
                  //   " taskName: " . $task['taskName'] . " status: " . $task['status'] . " ";
                  // echo "<br>";
                  $sql = "SELECT U.userId, U.fName, U.lName
                        FROM User U
                        JOIN User_Schedule US ON U.userId = US.userId
                        JOIN Task T ON US.scheduleId = T.scheduleId
                        WHERE T.scheduleId = ?";
                    $statement = mysqli_stmt_init($conn);
                    $users = [];
                    if (mysqli_stmt_prepare($statement, $sql)) {
                        mysqli_stmt_bind_param($statement, 'i', $task['scheduleId']);
                        if (mysqli_stmt_execute($statement)) {
                            $result = mysqli_stmt_get_result($statement);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $users[] = $row;
                            }
                        }
                        mysqli_stmt_close($statement);
                    }
                ?>
                  <tr>
                      <td>
                          <a href="javascript:void(0);" onclick="redirectToTasksSoPage('<?php echo $task['taskId']; ?>', '<?php echo $task['dateCreated']; ?>',
                              '<?php echo $task['taskName']; ?>', '<?php echo $task['status']; ?>')">
                              <?php echo (isset($task['taskId']) ? htmlspecialchars($task['taskId']) : ''); ?>
                          </a>
                      </td>
                      <td>
                      <?php
                        if (isset($task['dateCreated'])) {
                            $dateCreated = date('d-m-Y', strtotime($task['dateCreated']));
                            echo htmlspecialchars($dateCreated);
                        } else {
                            echo '';
                        }
                        ?>
                      </td>
                      <td><?php echo (isset($task['taskName']) ? htmlspecialchars($task['taskName']) : ''); ?></td>
                      <td><?php echo (isset($task['status']) ? htmlspecialchars($task['status']) : ''); ?></td>
                      <?php
                      if(count($users) > 1) {
                      ?>
                        <td><?php echo (isset($task['scheduleId']) ? 'Group ' . htmlspecialchars($task['scheduleId']) : '-'); ?></td>
                      <?php
                      } else {
                        $user = $users[0];
                      ?>
                        <td><?php echo (isset($user['fName']) && isset($user['fName']) ? htmlspecialchars($user['fName']) . ' ' . htmlspecialchars($user['lName']) : '-'); ?></td>
                      <?php
                      }
                      ?>
                  </tr>
                <?php endforeach;
                    mysqli_close($conn);
                ?>
              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="cleardiv"></div>
  <!-- -->
</body>

</html>