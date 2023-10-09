//Kanban
function kanban() {
    let windowHeight = window.innerHeight;
    let windowWidth = window.innerWidth;
    let eachColWidth = (windowWidth/5)
  
    document.addEventListener("DOMContentLoaded", ()=>{
        let colnames = ["col1", "col2", "col3", "col4", "col5"]
        colnames.forEach(element => {
            document.querySelector("."+element).style.width = eachColWidth.toString() + "px";
        });
  
        let col1 = document.querySelector(".col1");
        let col2 = document.querySelector(".col2");
        let col3 = document.querySelector(".col3");
        let col4 = document.querySelector(".col4");
        let col5 = document.querySelector(".col5");
  
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
                col5.addEventListener("dragover", (e)=>{
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
                col5.addEventListener("drop", (e)=>{
                    col5.appendChild(selected);
                    selected = null;
                });
            })
        };
    });
  }
  
  //function called by reports.php and redirects to reports_sup.php
  function redirectToReportsSoPage(
    taskId,
    taskName,
    userId,
    fName,
    lName,
    timestampSO
  ) {
    const baseUrl = "reports_sup.php";
    const queryParams = `?taskId=${encodeURIComponent(taskId)}&taskId=${encodeURIComponent(
      taskId
    )}&taskName=${encodeURIComponent(taskName)}&userId=${encodeURIComponent(
      userId
    )}&fName=${encodeURIComponent(fName)}&lName=${encodeURIComponent(lName)}&timestampSO=${encodeURIComponent(timestampSO)}`;
    const newUrl = baseUrl + queryParams;
    window.location.href = newUrl;
  }
  
  //function called by reports.php and redirects to reports_sup_dis.php
  function redirectToReportsSoSupPage(
    taskId,
    taskName,
    status
  ) {
    const baseUrl = "reports_sup_dis.php";
    const queryParams = `?taskId=${encodeURIComponent(taskId)}&taskName=${encodeURIComponent(taskName)}&status=${encodeURIComponent(status)}`;
    const newUrl = baseUrl + queryParams;
    window.location.href = newUrl;
  }
  
  //function called by tasks.php and redirects to reports_sup.php
  function redirectToTasksSoPage(
      taskId,
      dateCreated,
      taskName,
      status,
      assignedTo,
      fName,
      lName
    ) {
      const baseUrl = "tasks_sup.php";
      const queryParams = `?taskId=${encodeURIComponent(
          taskId
      )}&dateCreated=${encodeURIComponent(dateCreated)}&taskName=${encodeURIComponent(
          taskName
      )}&status=${encodeURIComponent(status)}&assignedTo=${encodeURIComponent(
          assignedTo
      )}
      )}&fName=${encodeURIComponent(fName)}&lName=${encodeURIComponent(
        lName
    )}`;
      const newUrl = baseUrl + queryParams;
      window.location.href = newUrl;
    }
  
  //cancel button
  function cancelButton() {
    const currentPagePath = window.location.pathname;
    const currentPageName = currentPagePath.split("/").pop();
    console.log("Current Page Name:", currentPageName);
  
    if (currentPageName == "reports_sup.php" || currentPageName == "reports_sup_dis.php") {
      window.location.href = "reports.php";
    } else if (currentPageName == "tasks_sup.php") {
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
      confirmPopupOutput.innerText = "No Supervisor/s selected.";
      cancelButton.innerText = "Ok"
      processsButton.style.display = "none";
      confirmPopup.style.display = "block";
      declinePopup.style.display = "none";
    }
  }
  function submitReportConfirm() {
    document.getElementById("myForm").submit();
  }
  
  function submitReport() {
    const currentPagePath = window.location.pathname;
    const currentPageName = currentPagePath.split("/").pop();
    const idReportSup = document.getElementById("id-report-sup");
    const popup = document.getElementById("popup");
    const confirmPopup = document.getElementById('confirm-popup');
    const confirmPopupOutput = document.getElementById("confirm-popup-output");
    if(currentPageName == "reports_sup_dis.php") {
      if(idReportSup.value != "") {
        popup.style.display = "block";
        confirmPopup.style.display = "block";
        confirmPopupOutput.innerText = "Confirm submit report?"
      }
    } else if(currentPageName == "reports_sup.php") {
      popup.style.display = "block";
      confirmPopup.style.display = "block";
      confirmPopupOutput.innerText = "Confirm complete report?"
    }
    document.getElementById("myForm").addEventListener("submit", function (event) {
      event.preventDefault();
    });
  }
  
  function assignTask() {
      const popup = document.getElementById("popup");
      const confirmPopup = document.getElementById('confirm-popup');
      const declinePopup = document.getElementById('decline-popup');
      const confirmPopupOutput = document.getElementById("confirm-popup-output");
      const cancelButton = document.getElementById("cancel-button");
      const processsButton = document.getElementById("process-button");
      const supDetails = document.getElementById("sup-details");
      popup.style.display = "block";
      confirmPopup.style.display = "block";
      declinePopup.style.display = "none";
      if(supDetails.value == '') {
        cancelButton.innerText = "Ok";
        processsButton.style.display = "none";
        confirmPopupOutput.innerText = "Please select Supervisor.";
      } else {
        cancelButton.innerText = "Cancel";
        processsButton.style.display = "inline";
        confirmPopupOutput.innerText = "Confirm assign task?";
      }
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
    const col5 = document.querySelector(".col5");
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
      col5.style.display = "block";
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
      col5.style.display = "none";
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
  
  function radioReports() {
    const selectedValue = document.querySelector('input[name="reportType"]:checked').value;
    const table1 = document.getElementById("tasktable");
    const table2 = document.getElementById("tasktable2");
    if (selectedValue === 'MyReports') {
        console.log("My Reports selected");
        table1.style.display = "inline-table";
        table2.style.display = "none";
    } else if (selectedValue === 'SOReports') {
        console.log("Supervisor's Reports selected");
        table1.style.display = "none";
        table2.style.display = "inline-table";
    }
  }
  
  function init() {
    const currentPagePath = window.location.pathname;
    const currentPageName = currentPagePath.split("/").pop();
    console.log("Current Page Name:", currentPageName);
    if (currentPageName == "tasks.php") {
      kanban();
      toggleView();
      document.addEventListener("DOMContentLoaded", function () {
        var dropdown = document.getElementById("filterdropdown");
        if (dropdown !== null && dropdown !== undefined) {
            dropdown.addEventListener("change", function () {
                var selectedValue = dropdown.value;
                filtertable(selectedValue);
            });
        }
    });
      document
        .getElementById("toggleViewButton")
        .addEventListener("click", toggleView);
    } if (currentPageName == "reports.php") {
      const table1 = document.getElementById("tasktable");
      const table2 = document.getElementById("tasktable2");
      const radioButtons = document.querySelectorAll('input[name="reportType"]');
      const storedValue = localStorage.getItem("selectedReportType");
      
      radioButtons.forEach(function (radioButton) {
        radioButton.addEventListener("change", function () {
            localStorage.setItem("selectedReportType", radioButton.value);
        });
      });
      if (storedValue) {
        var selectedRadioButton = document.querySelector('input[name="reportType"][value="' + storedValue + '"]');
        if (selectedRadioButton) {
            selectedRadioButton.checked = true;
        }
        console.log("storedValue: "+storedValue);
        if(storedValue == 'MyReports') {
          table1.style.display = "inline-table";
          table2.style.display = "none";
        } else if(storedValue == 'SOReports') {
          table1.style.display = "none";
          table2.style.display = "inline-table";
        }
      } else {
        table1.style.display = "inline-table";
        table2.style.display = "none";
      }
    }
  }
  init();