/*
const allTasks = [
  { number: "#123", date: "09-09-2023", name: "John", status: "Onboarding" },
  {
    number: "#134",
    date: "10-09-2023",
    name: "Freddy",
    status: "Onboarding",
  },
  {
    number: "#154",
    date: "11-09-2023",
    name: "Jackey",
    status: "Onboarding",
  },
  { number: "#190", date: "10-09-2023", name: "Terry", status: "Onboarding" },
  {
    number: "#213",
    date: "07-09-2023",
    name: "Paul",
    status: "Onboarding",
  },
  {
    number: "#222",
    date: "08-09-2023",
    name: "Kevin",
    status: "Completed",
  },
  { number: "#333", date: "09-09-2023", name: "Mark", status: "Completed" },
  { number: "#153", date: "08-09-2023", name: "Robert", status: "Completed" },
];
*/
const eventLogData = [
  {
    date: "12/09/2023",
    time: "10:00 AM",
    action: "Report Created",
    user: "Julian",
    role: "Security Officer",
  },

  {
    date: "03/09/2023",
    time: "10:00 AM",
    action: "Task declined",
    user: "John",
    role: "Supervisor",
  },
  {
    date: "10/03/2023",
    time: "11:30 AM",
    action: "Task declined",
    user: "Alice",
    role: "Security Officer",
  },

  {
    date: "10/09/2023",
    time: "11:30 AM",
    action: "Removed SO from group XXX",
    user: "Scott",
    role: "Supervisor",
  },

  {
    date: "08/05/2023",
    time: "11:30 AM",
    action: "Task completed",
    user: "Alice",
    role: "Security Officer",
  },

  {
    date: "04/03/2023",
    time: "11:30 AM",
    action: "Task completed",
    user: "Freddy",
    role: "Supervisor",
  },

];

document.addEventListener("DOMContentLoaded", function () {
    const currentPagePath = window.location.pathname;
    const currentPageName = currentPagePath.split("/").pop();
    
    if (currentPageName === 'tasks.php') {
 
      function populateListView(filterStatusId) {
        const taskList = document.getElementById("taskList");
        taskList.innerHTML = "";
      
        displayedTasks.forEach((task) => {
          if (filterStatusId === "all" || task.statusId === filterStatusId) {
            const row = document.createElement("tr");
            row.innerHTML = `
              <td><a href="task_details.php#${task.number}" class="task-link">${task.number}</a></td>
              <td>${task.date}</td>
              <td>${task.name}</td>
              <td>${task.status}</td>
            `;
            taskList.appendChild(row);
          }
        });
      }
      
      function populateKanbanView(filterStatusId) {
        const kanbanColumns = document.querySelectorAll(".kanban-column");
      
        kanbanColumns.forEach((column) => {
          const status = column.getAttribute("data-status");
          const tasksForStatus = displayedTasks.filter((task) => filterStatusId === "all" || task.statusId === filterStatusId);
          const columnContent = tasksForStatus.map((task) => `
            <div class="task-card">
              <p>Requested Number: ${task.number}</p>
              <p>Requested Date: ${task.date}</p>
              <p>Name: ${task.name}</p>
            </div>
          `).join('');
      
          if (filterStatusId === "all" || status === filterStatus) {
            column.style.display = "block";
            column.innerHTML = `<h2>${status}</h2>${columnContent}`;
          } else {
            column.style.display = "none";
          }
        });
      }
      
      
      /*
      function populateListView(filterStatus) {
        const taskList = document.getElementById("taskList");
        taskList.innerHTML = ""; 
        
        displayedTasks.forEach((task) => {
          if (filterStatus === "all" || task.status === filterStatus) {
            const row = document.createElement("tr");
            row.innerHTML = `
              <td><a href="task_details.php#${task.number}" class="task-link">${task.number}</a></td>
              <td>${task.date}</td>
              <td>${task.name}</td>
              <td>${task.status}</td>
            `;
            taskList.appendChild(row);
          }
        });
      }
      
    
      function populateKanbanView(filterStatus) {
        const kanbanColumns = document.querySelectorAll(".kanban-column");
        kanbanColumns.forEach((column) => {
          const status = column.getAttribute("data-status");
          const tasksForStatus = displayedTasks.filter((task) => filterStatus === "all" || task.status === status);
          const columnContent = tasksForStatus
            .map(
              (task) => `
                <div class="task-card">
                  <p>Requested Number: ${task.number}</p>
                  <p>Requested Date: ${task.date}</p>
                  <p>Name: ${task.name}</p>
                </div>
              `
            )
            .join("");
          column.innerHTML = `<h2>${status}</h2>${columnContent}`;
        });
      }
      */

      function switchView(view) {
        const listViewButton = document.getElementById("listViewButton");
        const kanbanViewButton = document.getElementById("kanbanViewButton");
  
        if (view === "list") {
          document.getElementById("listView").style.display = "block";
          document.getElementById("kanbanView").style.display = "none";
          listViewButton.classList.add("active");
          kanbanViewButton.classList.remove("active");

          const statusFilter = document.getElementById("statusFilter").value;
          populateListView(statusFilter);
        } else if (view === "kanban") {
          document.getElementById("listView").style.display = "none";
          document.getElementById("kanbanView").style.display = "block";
          kanbanViewButton.classList.add("active");
          listViewButton.classList.remove("active");
  
          const statusFilter = document.getElementById("statusFilter").value;
          populateKanbanView(statusFilter);
        }
      }
  
      const listViewButton = document.getElementById("listViewButton");
      listViewButton.addEventListener("click", () => {
        switchView("list");
      });
  
      const kanbanViewButton = document.getElementById("kanbanViewButton");
      kanbanViewButton.addEventListener("click", () => {
        switchView("kanban");
      });
  
      // Initially, display the List view and hide the Kanban view
      switchView("list");
  
      const statusFilter = document.getElementById("statusFilter");

      statusFilter.addEventListener("change", (event) => {
        const selectedStatusId = event.target.value;
        const currentView = listViewButton.classList.contains("active") ? "list" : "kanban";
        
        if (currentView === "list") {
          populateListView(selectedStatusId);
        } else if (currentView === "kanban") {
          populateKanbanView(selectedStatusId);
        }
      });
      

  }else if(currentPageName == 'task_details.php'){
    const taskNumber = localStorage.getItem("taskNumber");
  const taskDate = localStorage.getItem("taskDate");
  const taskName = localStorage.getItem("taskName");
  const taskStatus = localStorage.getItem("taskStatus");

  if (taskNumber && taskDate && taskName && taskStatus) {
      document.getElementById("taskNumber").textContent = taskNumber;
      document.getElementById("taskDate").textContent = taskDate;
      document.getElementById("taskName").textContent = taskName;
      document.getElementById("taskStatus").textContent = taskStatus;
  } else {
      
      alert("Task data not found.");
  }



document.getElementById("cancelButton").addEventListener("click", () => {

window.history.back();
});

document.getElementById("submitButton").addEventListener("click", () => {

 const confirmationMessage = `Confirm Send to "${taskName}"`;

alert(confirmationMessage);
});
  } else if(currentPageName == 'event_logs.php'){
    
  
  function populateEventLogTable(data) {
    const eventLogTable = document.getElementById("eventLogData");

    
    eventLogTable.innerHTML = "";

    
    data.sort((a, b) => {
      const dateA = new Date(a.date);
      const dateB = new Date(b.date);
      return dateA - dateB;
    });

    
    data.forEach((event) => {
      const row = document.createElement("tr");
      row.innerHTML = `
                    <td>${event.date}</td>
                    <td>${event.time}</td>
                    <td>${event.action}</td>
                    <td>${event.user}</td>
                    <td>${event.role}</td>
                `;
      eventLogTable.appendChild(row);
    });
  }

  function filterAndPopulateTable() {
    const dateFromInput = document.getElementById("dateFrom");
    const dateToInput = document.getElementById("dateTo");

   
    const dateFromParts = dateFromInput.value.split("-");
    const dateToParts = dateToInput.value.split("-");

    // Create Date objects from the parts (year, month, day)
    const dateFrom = new Date(
      dateFromParts[0],
      dateFromParts[1] - 1,
      dateFromParts[2]
    );
    const dateTo = new Date(dateToParts[0], dateToParts[1] - 1, dateToParts[2]);

    
    const filteredData = eventLogData.filter((event) => {
      const eventParts = event.date.split("/");
      const eventDate = new Date(
        eventParts[2],
        eventParts[1] - 1,
        eventParts[0]
      );
      return eventDate >= dateFrom && eventDate <= dateTo;
    });

    
    populateEventLogTable(filteredData);
  }

  
  window.addEventListener("load", () => {
    populateEventLogTable(eventLogData);
  });

  
  document.getElementById("searchButton").addEventListener("click", function () {
    
    const dateFrom = document.getElementById("dateFrom").value;
    const dateTo = document.getElementById("dateTo").value;

   

    window.location.href = 'event_logs.php?dateFrom=' + dateFrom + '&dateTo=' + dateTo;
});

  
  function generateCSV() {
    const rows = document.querySelectorAll(".event-log-table tbody tr");
    const headers = ["Date", "Time", "Action", "User", "Role"];
    const csvRows = [headers.join(",")];

    rows.forEach((row) => {
      const cols = Array.from(row.children).map((col) => col.textContent);
      csvRows.push(cols.join(","));
    });

    return csvRows.join("\n");
  }

 
  function downloadCSVWithConfirmation() {
    const csvData = generateCSV();

    
    const confirmation = window.confirm("Do you want to download the file?");

    if (confirmation) {
      const blob = new Blob([csvData], { type: "text/csv" });
      const url = URL.createObjectURL(blob);

      const a = document.createElement("a");
      a.href = url;
      a.download = "event_logs.csv";
      a.style.display = "none";
      document.body.appendChild(a);
      a.click();

    
      URL.revokeObjectURL(url);
      document.body.removeChild(a);
    }
  }

  
function filterEventLogs() {
  const dateFrom = document.getElementById("dateFrom").value;
  const dateTo = document.getElementById("dateTo").value;
  const userName = document.getElementById("userName").value;

  
  const filteredData = eventLogData.filter((event) => {
    const eventDate = new Date(event.date); 
    const isDateInRange = eventDate >= new Date(dateFrom) && eventDate <= new Date(dateTo);

    return isDateInRange && (userName === '' || event.user.toLowerCase().includes(userName.toLowerCase()));
  });

  
  populateEventLogTable(filteredData);
}


const searchButton = document.getElementById("searchButton");
if (searchButton) {
  searchButton.addEventListener("click", filterEventLogs);
}



  
  const saveButton = document.getElementById("saveButton");
  saveButton.addEventListener("click", downloadCSVWithConfirmation);
  } else if(currentPageName == 'system_settings.html'){
    let isEditMode = false;
    const loginDetailsElement = document.getElementById('loginDetails');
    const helpSupportElement = document.getElementById('helpSupport');
    const updateButton = document.getElementById('updateButton');
    let initialLoginDetails = `This is the login screen details. Click 'UPDATE' to edit. <br> Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis eveniet, quaerat provident sit velit voluptas temporibus repellendus rerum expedita molestias porro, et dicta quasi vel fugiat totam! Magnam, delectus veniam. Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis eveniet, quaerat provident sit velit voluptas temporibus repellendus rerum expedita molestias porro, et dicta quasi vel fugiat totam! Magnam, delectus veniam. Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis eveniet, quaerat provident sit velit voluptas temporibus repellendus rerum expedita molestias porro, et dicta quasi vel fugiat totam! Magnam, delectus veniam.  `;
    let initialHelpSupport = `This is the help and support information. Click 'UPDATE' to edit.<br> Please Contact us via<br> - Phone +61 3333333<br> - Email: taskforcesecurity@gold.com.au `;
  
    loginDetailsElement.innerHTML = initialLoginDetails;
    helpSupportElement.innerHTML = initialHelpSupport;
  
    function toggleEditMode() {
        isEditMode = !isEditMode;
        if (isEditMode) {
            updateButton.textContent = 'SAVE';
            loginDetailsElement.contentEditable = true;
            helpSupportElement.contentEditable = true;
        } else {
            updateButton.textContent = 'UPDATE';
            loginDetailsElement.contentEditable = false;
            helpSupportElement.contentEditable = false;
        }
    }
  
    updateButton.addEventListener('click', function () {
        if (isEditMode) {
            const confirmSave = confirm('Do you want to save changes?');
            if (confirmSave) {
                initialLoginDetails = loginDetailsElement.innerHTML;
                initialHelpSupport = helpSupportElement.innerHTML;
                toggleEditMode();
            }
        } else {
            toggleEditMode();
        }
    });
  }
  


});





