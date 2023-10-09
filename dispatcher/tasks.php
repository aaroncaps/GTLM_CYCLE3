<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Administrator - Tasks</title>
  <!-- css -->
  <link rel="stylesheet" href="../styles/navigation.css" />
  <link rel="stylesheet" href="../styles/style.css" />

  <!-- js -->
  <script src="../js/core.js"></script>
  <script src="../js/dispatcher.js" defer></script>
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
              <option value="Client Request">Client Request</option>
              <option value="Pending Supervisor Approval">Pending Supervisor Approval</option>
              <option value="Declined Task by Supervisor">Declined Task by Supervisor</option>
              <option value="Assigned to Supervisor">Assigned to Supervisor</option>
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

          // $sql =  "SELECT T.taskId, T.dateCreated, T.taskName, T.scheduleId, S.status, T.supervisorId, U.fName, U.lName
          //         FROM Task T
          //         JOIN Status S ON T.statusDis = S.statusId
          //         JOIN User U ON T.dispatcherId = U.userId
          //         WHERE T.statusDis IN ('DIS01','DIS02','DIS03','DIS04','DIS05') AND T.dispatcherId = $loginUserId
          //         ORDER BY T.dateCreated DESC";

          $sql =  "SELECT T.taskId, T.dateCreated, T.taskName, T.scheduleId, S.status, T.supervisorId, U.fName, U.lName
          FROM Task T
          JOIN Status S ON T.statusDis = S.statusId
          LEFT JOIN User U ON T.supervisorId = U.userId
          WHERE T.dispatcherId = $loginUserId
          ORDER BY T.dateCreated DESC";

          $tasks = [];
          if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                $tasks[] = $row;
                if($row['status'] == 'Client Request') {
                  $clientTask[] = $row;
                } else if($row['status'] == 'Pending Supervisor Approval') {
                  $pendingTask[] = $row;
                } else if($row['status'] == 'Declined Task by Supervisor') {
                  $declineTask[] = $row;
                } else if($row['status'] == 'Assigned to Supervisor') {
                  $assignTask[] = $row;
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
              <div class="title">Client Request</div>
              <?php
              foreach ($clientTask as $task) :
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
                  <p><span>Assigned To:</span><?php echo (isset($task['fName']) && isset($task['fName']) ? htmlspecialchars($task['fName']) . ' ' . htmlspecialchars($task['lName']) : '-'); ?></p>
                </div>
              </div>
              <?php
              endforeach;
              ?>
            </div>
            <div class="col2">
              <div class="title">Pending Supervisor Approval</div>
              <?php
              foreach ($pendingTask as $task) :
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
                  <p><span>Assigned To:</span><?php echo (isset($task['fName']) && isset($task['fName']) ? htmlspecialchars($task['fName']) . ' ' . htmlspecialchars($task['lName']) : '-'); ?></p>
                </div>
              </div>
              <?php
              endforeach;
              ?>
            </div>
            <div class="col3">
              <div class="title">Declined Task by Supervisor</div>
              <?php
              foreach ($declineTask as $task) :
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
                  <p><span>Assigned To:</span><?php echo (isset($task['fName']) && isset($task['fName']) ? htmlspecialchars($task['fName']) . ' ' . htmlspecialchars($task['lName']) : '-'); ?></p>
                </div>
              </div>
              <?php
              endforeach;
              ?>
            </div>
            <div class="col4">
              <div class="title">Assigned to Supervisor</div>
              <?php
              foreach ($assignTask as $task) :
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
                  <p><span>Assigned To:</span><?php echo (isset($task['fName']) && isset($task['fName']) ? htmlspecialchars($task['fName']) . ' ' . htmlspecialchars($task['lName']) : '-'); ?></p>
                </div>
              </div>
              <?php
              endforeach;
              ?>
            </div>
            <div class="col5">
              <div class="title">Completed</div>
              <?php
              foreach ($completeTask as $task) :
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
                  <p><span>Assigned To:</span><?php echo (isset($task['fName']) && isset($task['fName']) ? htmlspecialchars($task['fName']) . ' ' . htmlspecialchars($task['lName']) : '-'); ?></p>
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
                ?>
                  <tr>
                      <td>
                          <a href="javascript:void(0);" onclick="redirectToTasksSoPage('<?php echo $task['taskId']; ?>', '<?php echo $task['dateCreated']; ?>',
                              '<?php echo $task['taskName']; ?>', '<?php echo $task['status']; ?>',
                              '<?php echo $task['assignedTo']; ?>', '<?php echo $task['fName']; ?>', '<?php echo $task['lName']; ?>')">
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
                      <td><?php echo (isset($task['fName']) && isset($task['fName']) ? htmlspecialchars($task['fName']) . ' ' . htmlspecialchars($task['lName']) : '-'); ?></td>
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