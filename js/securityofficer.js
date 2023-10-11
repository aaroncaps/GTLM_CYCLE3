document.addEventListener('DOMContentLoaded', function() {
  const currentPagePath = window.location.pathname;
    const currentPageName = currentPagePath.split("/").pop(); 
if(currentPageName == "tasks.php"){
  toggleView();
  document.getElementById('toggleViewButton').addEventListener('click', toggleView);
  const reportsTableBody = document.getElementById('TaskTableBody');
  const kanbaneBody = document.getElementById('TaskKanbanBody');
  tasksData.forEach(task => {
      const row = document.createElement('tr');
      row.innerHTML = `
          <td><a href="#" onclick="redirectToTasksSoPage(${task.taskId})">#${task.taskId}</a></td>
          <td>${task.dateCreated}</td>
          <td>${task.taskName}</td>
      `;
      reportsTableBody.appendChild(row);
      const div = document.createElement('div');
      div.setAttribute('class','listso');
      div.setAttribute('draggable','false');
      div.innerHTML = `<div class="information">
      <a href="#" onclick="redirectToTasksSoPage(${task.taskId})"><h4 class="taskId">#${task.taskId}</h4></a>
      <p><span class="date">Date:</span> ${task.dateCreated}</p>
      <p><span class="taskName">Task:</span> ${task.taskName}</p>
  </div>`;
  kanbaneBody.appendChild(div);

  });
}else if(currentPageName == "reports.php"){
  const reportsTableBody = document.getElementById('reportsTableBody');
  tasksData.forEach(task => {
      const row = document.createElement('tr');
      row.innerHTML = `
          <td><a href="#" onclick="redirectToReportSoPage(${task.taskId})">#${task.taskId}</a></td>
          <td>${task.taskName}</td>
      `;
      reportsTableBody.appendChild(row);

  });
}else if(currentPageName == "insert_report.php"){
  $(function() {
    $("#reportForm").submit(function(e){
      const idReport = document.getElementById('id-report');
      if (idReport.value !== '') {
        var confirmSubmit = confirm("Are you sure you want to submit this report?");
        if(!confirmSubmit) {   
          e.preventDefault();
        }
      }
    });
  });
}
});

function toggleView() {
  const kanbanWrapper = document.querySelector('.kanban_wrapper');
  const listview = document.querySelector('.ListView');
  const col1 = document.querySelector('.col1');
  // Check if the Kanban view is currently displayed
  if (kanbanWrapper.style.display === '' || kanbanWrapper.style.display === 'none') {

      document.getElementById("toggleViewButton").innerText = "List View";
      // Switch back to Kanban view
      kanbanWrapper.style.display = 'flex';
      listview.style.display = 'none';
      col1.style.display = 'flex';
  } else {
     // Switch to List view
     document.getElementById("toggleViewButton").innerText = "Kanban View";
     kanbanWrapper.style.display = 'none';
     listview.style.display = 'block';
     col1.style.display = 'flex';
  }
}

function enableSubmitButton() {
  const taskNumber = document.getElementById('id-task').value;
  const taskName = document.getElementById('task-name').value;
  const report = document.getElementById('id-report').value;

  if (taskNumber && taskName && report) {
      document.getElementById('createGroupBtn').removeAttribute('disabled');
  } else {
      document.getElementById('createGroupBtn').setAttribute('disabled', 'disabled');
  }
}


function cancelButton() {
  window.location.href = "reports.php";
}

function displayImageNames(input) {
  var imageNamesDisplay = document.getElementById('imageNames');
  imageNamesDisplay.textContent = 'Selected Files: ';

  for (var i = 0; i < input.files.length; i++) {
      var imageName = input.files[i].name;
      imageNamesDisplay.textContent += imageName + ', ';
  }

  // Remove trailing comma and space
  imageNamesDisplay.textContent = imageNamesDisplay.textContent.slice(0, -2);
}
//function called by tasks.php and redirects to reports_so.php
function redirectToTasksSoPage(
  taskId
) {
  const baseUrl = "task_view.php";
  const queryParams = `?taskId=${encodeURIComponent(
      taskId
  )}`;
  const newUrl = baseUrl + queryParams;
  window.location.href = newUrl;
}

function redirectToReportSoPage(
  taskId
) {
  const baseUrl = "insert_report.php";
  const queryParams = `?taskId=${encodeURIComponent(
      taskId
  )}`;
  const newUrl = baseUrl + queryParams;
  window.location.href = newUrl;
}