//Kanban
let windowHeight = window.innerHeight;
let windowWidth = window.innerWidth;
let eachColWidth = (windowWidth/4)

document.addEventListener("DOMContentLoaded", ()=>{
    let colnames = ["col1", "col2", "col3", "col4"]
    colnames.forEach(element => {
        document.querySelector("."+element).style.width = eachColWidth.toString() + "px";
    });

    let col1 = document.querySelector(".col1");
    let col2 = document.querySelector(".col2");
    let col3 = document.querySelector(".col3");
    let col4 = document.querySelector(".col4");

    let lists = document.getElementsByClassName("list");

    for (list of lists){
        list.addEventListener("dragstart", (e) => {
            let selected = e.target;

            // dragover
            col2.addEventListener("dragover", (e)=>{
                e.preventDefault();
            });
            col3.addEventListener("dragover", (e)=>{
                e.preventDefault();
            });
            col4.addEventListener("dragover", (e)=>{
                e.preventDefault();
            });

            // drop
            col2.addEventListener("drop", (e)=>{
                col2.appendChild(selected);
                selected = null;
            });
            col3.addEventListener("drop", (e)=>{
                col3.appendChild(selected);
                selected = null;
            });
            col4.addEventListener("drop", (e)=>{
                col4.appendChild(selected);
                selected = null;
            });
        })
    };
});


//function called by reports.php and redirects to reports_so.php
function redirectToReportsSoPage(
  taskId,
  taskName,
  userId,
  fName,
  lName,
  timestampSO
) {
  const baseUrl = "reports_so.php";
  const queryParams = `?taskId=${encodeURIComponent(taskId)}&taskId=${encodeURIComponent(
    taskId
  )}&taskName=${encodeURIComponent(taskName)}&userId=${encodeURIComponent(
    userId
  )}&fName=${encodeURIComponent(fName)}&lName=${encodeURIComponent(lName)}&timestampSO=${encodeURIComponent(timestampSO)}`;
  const newUrl = baseUrl + queryParams;
  window.location.href = newUrl;
}

//function called by tasks.php and redirects to reports_so.php
function redirectToTasksSoPage(
    taskId,
    dateCreated,
    taskName,
    status,
    assignedTo
  ) {
    const baseUrl = "tasks_so.php";
    const queryParams = `?taskId=${encodeURIComponent(
        taskId
    )}&dateCreated=${encodeURIComponent(dateCreated)}&taskName=${encodeURIComponent(
        taskName
    )}&status=${encodeURIComponent(status)}&assignedTo=${encodeURIComponent(
        assignedTo
    )}`;
    const newUrl = baseUrl + queryParams;
    window.location.href = newUrl;
  }

//cancel button
function cancelButton() {
  const currentPagePath = window.location.pathname;
  const currentPageName = currentPagePath.split("/").pop();
  console.log("Current Page Name:", currentPageName);

  if (currentPageName == "reports_so.php") {
    window.location.href = "reports.php";
  } else if (currentPageName == "tasks_so.php") {
    window.location.href = "tasks.php";
  }
}

//clicking the logo will redirect back to task.php
function redirecttotask() {
  const baseUrl = "tasks.php";
  const newUrl = baseUrl;
  window.location.href = newUrl;
}

//function that selects/deselects all checkbox in a table
function selectAllCheckboxes(tableId) {
  const selectAllCheckbox = document.getElementById(
    `selectAll${tableId.charAt(tableId.length - 1)}`
  );
  const checkboxes = document.querySelectorAll(
    `#${tableId} tbody input[type="checkbox"]`
  );
  checkboxes.forEach((checkbox) => {
    checkbox.checked = selectAllCheckbox.checked;
  });
}

//Funtion to confirm removal of SO from the group
function confirmRemoveSO(tableId) {
  const popup = document.getElementById("popup");
  const confirmPopupOutput = document.getElementById("confirm-popup-output");
  const cancelButton = document.getElementById("cancel-button");
  const processsButton = document.getElementById("process-button");
  const confirmPopup = document.getElementById('confirm-popup');
  const declinePopup = document.getElementById('decline-popup');
  const result = getCheckedRowsData("table1");
  const message = result.message;
  const userIds = result.userIds;
  document.getElementById("user-ids-remove").value = userIds.join(",");
  const tableBody = document.getElementById(tableId).querySelector("tbody");
  const checkboxes = tableBody.querySelectorAll(
    'input[type="checkbox"]:checked'
  );
  if(checkboxes.length > 0) {
    checkboxes.forEach((checkbox) => {
      const row = checkbox.closest("tr");
      tableBody.removeChild(row);
    });
  } else {
    popup.style.display = "block";
    confirmPopupOutput.innerText = "No Security Officer/s selected.";
    cancelButton.innerText = "Ok"
    processsButton.style.display = "none";
    confirmPopup.style.display = "block";
    declinePopup.style.display = "none";
  }
}

function submitReport() {
  const idReportSup = document.getElementById("id-report-sup");
  if (idReportSup.value != "") {
    const popup = document.getElementById("popup");
    const confirmPopup = document.getElementById('confirm-popup');
    const confirmPopupOutput = document.getElementById("confirm-popup-output");
    popup.style.display = "block";
    confirmPopup.style.display = "block";
    confirmPopupOutput.innerText = "Confirm submit report?"
  }
}

function reviewTask() {
    document.getElementById('option').value = 'review';
    const popup = document.getElementById("popup");
    const confirmPopup = document.getElementById('confirm-popup');
    const declinePopup = document.getElementById('decline-popup');
    const confirmPopupOutput = document.getElementById("confirm-popup-output");
    popup.style.display = "block";
    confirmPopup.style.display = "block";
    declinePopup.style.display = "none";
    confirmPopupOutput.innerText = "Confirm accept task?"
}

function assignTask(tableId) {
    document.getElementById('option').value = 'assign';
    const popup = document.getElementById("popup");
    const confirmPopup = document.getElementById('confirm-popup');
    const declinePopup = document.getElementById('decline-popup');
    const confirmPopupOutput = document.getElementById("confirm-popup-output");
    const cancelButton = document.getElementById("cancel-button");
    const processsButton = document.getElementById("process-button");
    const supDetails = document.getElementById("sup-details");
    const result = getCheckedRowsData(tableId);
    const message = result.message;
    const userIds = result.userIds;
    document.getElementById("user-ids-input").value = userIds.join(",");
    popup.style.display = "block";
    confirmPopup.style.display = "block";
    declinePopup.style.display = "none";
    if(userIds == '' && supDetails.value == '') {
      cancelButton.innerText = "Ok";
      processsButton.style.display = "none";
      confirmPopupOutput.innerText = "Please select Security Officer/s.";
    } else {
      cancelButton.innerText = "Cancel";
      processsButton.style.display = "inline";
      confirmPopupOutput.innerText = "Confirm assign task?";
    }
}

function updateTask(tableId) {
  document.getElementById('option').value = 'update';
  const popup = document.getElementById("popup");
  const confirmPopup = document.getElementById('confirm-popup');
  const declinePopup = document.getElementById('decline-popup');
  const confirmPopupOutput = document.getElementById("confirm-popup-output");
  const cancelButton = document.getElementById("cancel-button");
  const processsButton = document.getElementById("process-button");
  const supDetails = document.getElementById("sup-details");
  const supDetailsOrig = document.getElementById("sup-details-orig");
  const result = getCheckedRowsData(tableId);
  const message = result.message;
  const userIds = result.userIds;
  const userIdsRemove = document.getElementById("user-ids-remove").value;
  document.getElementById("user-ids-input").value = userIds.join(",");
  popup.style.display = "block";
  confirmPopup.style.display = "block";
  declinePopup.style.display = "none";
  if(userIds == '' && userIdsRemove == '' && supDetails.value == supDetailsOrig.value) {
    cancelButton.innerText = "Ok";
    processsButton.style.display = "none";
    confirmPopupOutput.innerText = "No changes found.";
  } else {
    cancelButton.innerText = "Cancel";
    processsButton.style.display = "inline";
    confirmPopupOutput.innerText = "Confirm update task?";
  }
}

function declineTask() {
    document.getElementById('option').value = 'decline';
    const popup = document.getElementById("popup");
    const confirmPopup = document.getElementById('confirm-popup');
    const declinePopup = document.getElementById('decline-popup');
    const declineReasonLabel = document.getElementById('decline-reason-label');
    popup.style.display = "block";
    confirmPopup.style.display = "none";
    declinePopup.style.display = "block";
    declineReasonLabel.innerText = "Please provide reason and confirm on why the task is declined.";
}

function cancelPopup() {
  const popup = document.getElementById("popup");
  popup.style.display = "none";
}

//Function to select all those rows that were checked
function getCheckedRowsData(tableId) {
  const checkedRowsData = [];
  const checkedUserIds = [];
  const checkboxes = document.querySelectorAll(
    `#${tableId} tbody input[type="checkbox"]`
  );

  checkboxes.forEach((checkbox) => {
    if (checkbox.checked) {
      const row = checkbox.closest("tr");
      const userId = row.cells[1].textContent;
      const name = row.cells[2].textContent;
      checkedRowsData.push({ userId, name });
      checkedUserIds.push(userId);
    }
  });
  const message = checkedRowsData
    .map((data) => `   ${data.userId} ${data.name}`)
    .join("\n");
  return { message, userIds: checkedUserIds };
}

//Funtion that gets all the parameters passed in a url
function getUrlParam(name) {
  const params = new URLSearchParams(window.location.search);
  return params.has(name) ? params.get(name) : "";
}

//Toggle between Kanban view or List view
function toggleView() {
  const kanbanWrapper = document.querySelector(".kanban_wrapper");
  const listview = document.querySelector(".ListView");
  const col1 = document.querySelector(".col1");
  const col2 = document.querySelector(".col2");
  const col3 = document.querySelector(".col3");
  const col4 = document.querySelector(".col4");
  const dropdown = document.querySelector(".filterstatus");

  if (kanbanWrapper.style.display === "none") {
    document.getElementById("toggleViewButton").innerText = "List View";
    // Switch back to Kanban view
    kanbanWrapper.style.display = "flex";
    listview.style.display = "none";
    dropdown.style.display = "none";
    col1.style.display = "block";
    col2.style.display = "block";
    col3.style.display = "block";
    col4.style.display = "block";
  } else {
    // Switch to List view
    document.getElementById("toggleViewButton").innerText = "Kanban View";
    kanbanWrapper.style.display = "none";
    listview.style.display = "block";
    dropdown.style.display = "block";
    col1.style.display = "none";
    col2.style.display = "none";
    col3.style.display = "none";
    col4.style.display = "none";
  }
}

function filtertable(text) {
  if (text != "All") {
    var input, filter, table, tr, td, i, txtValue;
    input = text;
    filter = input.toUpperCase();
    table = document.getElementById("tasktable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[3];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  } else {
    var input, filter, table, tr, td, i, txtValue;
    input = "";
    filter = input.toUpperCase();
    table = document.getElementById("tasktable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[3];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }
}

function init() {
  const currentPagePath = window.location.pathname;
  const currentPageName = currentPagePath.split("/").pop();
  console.log("Current Page Name:", currentPageName);
  if (currentPageName == "tasks.php") {
    toggleView();
    filterdropdown.addEventListener("change", function () {
      var dropdown = document.getElementById("filterdropdown");
      var selectedValue = dropdown.value;
      filtertable(selectedValue);
    });
    document
      .getElementById("toggleViewButton")
      .addEventListener("click", toggleView);
  } else if (currentPageName == "tasks_so.php") {
    const status = getUrlParam('status');
  } else if (currentPageName == "reports.php") {
    filterdropdown.addEventListener("change", function () {
      var dropdown = document.getElementById("filterdropdown");
      var selectedValue = dropdown.value;
      filtertable(selectedValue);
    });
  }
}
init();