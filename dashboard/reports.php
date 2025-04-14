<?php require_once "layouts/header.view.php";
require_once "../config.php";
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<div class="v-body-wrapper" id="v-wrapper">

  <!-- header @::start -->
  <?php require_once "layouts/nav.view.php" ?>
  <!-- header @::end -->
  <section id="v-main">
    <?php require_once "layouts/sidebar.view.php" ?>
    <main class="v-main-content">
      <div class="v-main-content-inner col-lg-11 col-xl-11 mx-auto">
      <div class="p-0">
          <header class="v-page-title d-flex align-items-center justify-content-between">
            <div>
              <h3 class="v-title">Welcome<b class="user_first_name"></b></h3>
              <span class="v-subtext">
                <b>Reports<span class="v-day ms-1" data-daytime="day">View</span></b>
                <span class="d-flex align-items-center justify-content-center">
                  <img src="" data-icon="day" alt="" class="img-fluid ms-1" />
                </span>
              </span>
                <p>  <strong>Account Type:</strong> <span class="user_account_type"></span></p>
                <p><strong>Role:</strong> <span id="user_role">Loading...</span></p>
            </div>
          </header>
        </div>


        <!-- Add Record Button -->
        <div class="text-center mt-4">
          <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addRecordModal">
            Add Reports
          </button>
        </div>



        <!-- First Table -->
        <!-- First Table -->
        <div class="table-responsive mt-4">
          <h5>First Table</h5>
          <div class="input-group w-50 mb-3">
            <span class="input-group-text bg-primary text-white">
              <i class="fas fa-search"></i>
            </span>
            <input type="text" id="searchInput1" class="form-control" placeholder="Search First Table">
          </div>
          <table class="table table-hover align-middle shadow-sm border-0">
            <thead class="bg-primary text-white">
              <tr>
                <th>Date</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Mobilizer</th>
                <th>Field Officer</th>
                <th>Supervisor</th>
                <th>Project Manager</th>
                <th>Project Director</th>
              </tr>
            </thead>
            <tbody id="recordsTableBody1" class="bg-white">
              <tr>
                <td>2025-04-01</td>
                <td>John Doe</td>
                <td>+1234567890</td>
                <td>Mobilizer A</td>
                <td>Field Officer B</td>
                <td>Supervisor C</td>
                <td>Manager D</td>
                <td>Director E</td>
              </tr>
              <tr>
                <td>2025-04-02</td>
                <td>Jane Smith</td>
                <td>+9876543210</td>
                <td>Mobilizer X</td>
                <td>Field Officer Y</td>
                <td>Supervisor Z</td>
                <td>Manager W</td>
                <td>Director V</td>
              </tr>
              <tr>
                <td>2025-04-03</td>
                <td>Emily Clark</td>
                <td>+1122334455</td>
                <td>Mobilizer P</td>
                <td>Field Officer Q</td>
                <td>Supervisor R</td>
                <td>Manager S</td>
                <td>Director T</td>
              </tr>
              <tr>
                <td>2025-04-04</td>
                <td>Michael Brown</td>
                <td>+4455667788</td>
                <td>Mobilizer L</td>
                <td>Field Officer M</td>
                <td>Supervisor N</td>
                <td>Manager O</td>
                <td>Director P</td>
              </tr>
              <tr>
                <td>2025-04-05</td>
                <td>Sarah Johnson</td>
                <td>+9988776655</td>
                <td>Mobilizer K</td>
                <td>Field Officer J</td>
                <td>Supervisor I</td>
                <td>Manager H</td>
                <td>Director G</td>
              </tr>
              <tr>
                <td>2025-04-06</td>
                <td>Chris Evans</td>
                <td>+5566778899</td>
                <td>Mobilizer F</td>
                <td>Field Officer E</td>
                <td>Supervisor D</td>
                <td>Manager C</td>
                <td>Director B</td>
              </tr>
              <tr>
                <td>2025-04-07</td>
                <td>Anna Taylor</td>
                <td>+6677889900</td>
                <td>Mobilizer Z</td>
                <td>Field Officer Y</td>
                <td>Supervisor X</td>
                <td>Manager W</td>
                <td>Director V</td>
              </tr>
              <tr>
                <td>2025-04-08</td>
                <td>David Wilson</td>
                <td>+7788990011</td>
                <td>Mobilizer U</td>
                <td>Field Officer T</td>
                <td>Supervisor S</td>
                <td>Manager R</td>
                <td>Director Q</td>
              </tr>
              <tr>
                <td>2025-04-09</td>
                <td>Laura Martinez</td>
                <td>+8899001122</td>
                <td>Mobilizer P</td>
                <td>Field Officer O</td>
                <td>Supervisor N</td>
                <td>Manager M</td>
                <td>Director L</td>
              </tr>
              <tr>
                <td>2025-04-10</td>
                <td>James Anderson</td>
                <td>+9900112233</td>
                <td>Mobilizer K</td>
                <td>Field Officer J</td>
                <td>Supervisor I</td>
                <td>Manager H</td>
                <td>Director G</td>
              </tr>
            </tbody>
          </table>
          <p id="noResultsMessage1" class="text-center mt-3" style="display: none;">No results found.</p>
          <div class="d-flex justify-content-center mt-3">
            <nav>
              <ul class="pagination" id="paginationControls1"></ul>
            </nav>
          </div>
        </div>

        <!-- Second Table -->
        <div class="table-responsive mt-4">
          <h5>Second Table</h5>
          <div class="input-group w-50 mb-3">
            <span class="input-group-text bg-primary text-white">
              <i class="fas fa-search"></i>
            </span>
            <input type="text" id="searchInput2" class="form-control" placeholder="Search Second Table">
          </div>
          <table class="table table-hover align-middle shadow-sm border-0">
            <thead class="bg-primary text-white">
              <tr>
                <th>Date</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Mobilizer</th>
                <th>Field Officer</th>
                <th>Supervisor</th>
                <th>Project Manager</th>
                <th>Project Director</th>
              </tr>
            </thead>
            <tbody id="recordsTableBody2" class="bg-white">
              <tr>
                <td>2025-04-01</td>
                <td>John Doe</td>
                <td>+1234567890</td>
                <td>Mobilizer A</td>
                <td>Field Officer B</td>
                <td>Supervisor C</td>
                <td>Manager D</td>
                <td>Director E</td>
              </tr>
              <tr>
                <td>2025-04-02</td>
                <td>Jane Smith</td>
                <td>+9876543210</td>
                <td>Mobilizer X</td>
                <td>Field Officer Y</td>
                <td>Supervisor Z</td>
                <td>Manager W</td>
                <td>Director V</td>
              </tr>
              <tr>
                <td>2025-04-03</td>
                <td>Emily Clark</td>
                <td>+1122334455</td>
                <td>Mobilizer P</td>
                <td>Field Officer Q</td>
                <td>Supervisor R</td>
                <td>Manager S</td>
                <td>Director T</td>
              </tr>
              <tr>
                <td>2025-04-04</td>
                <td>Michael Brown</td>
                <td>+4455667788</td>
                <td>Mobilizer L</td>
                <td>Field Officer M</td>
                <td>Supervisor N</td>
                <td>Manager O</td>
                <td>Director P</td>
              </tr>
              <tr>
                <td>2025-04-05</td>
                <td>Sarah Johnson</td>
                <td>+9988776655</td>
                <td>Mobilizer K</td>
                <td>Field Officer J</td>
                <td>Supervisor I</td>
                <td>Manager H</td>
                <td>Director G</td>
              </tr>
              <tr>
                <td>2025-04-06</td>
                <td>Chris Evans</td>
                <td>+5566778899</td>
                <td>Mobilizer F</td>
                <td>Field Officer E</td>
                <td>Supervisor D</td>
                <td>Manager C</td>
                <td>Director B</td>
              </tr>
              <tr>
                <td>2025-04-07</td>
                <td>Anna Taylor</td>
                <td>+6677889900</td>
                <td>Mobilizer Z</td>
                <td>Field Officer Y</td>
                <td>Supervisor X</td>
                <td>Manager W</td>
                <td>Director V</td>
              </tr>
              <tr>
                <td>2025-04-08</td>
                <td>David Wilson</td>
                <td>+7788990011</td>
                <td>Mobilizer U</td>
                <td>Field Officer T</td>
                <td>Supervisor S</td>
                <td>Manager R</td>
                <td>Director Q</td>
              </tr>
              <tr>
                <td>2025-04-09</td>
                <td>Laura Martinez</td>
                <td>+8899001122</td>
                <td>Mobilizer P</td>
                <td>Field Officer O</td>
                <td>Supervisor N</td>
                <td>Manager M</td>
                <td>Director L</td>
              </tr>
              <tr>
                <td>2025-04-10</td>
                <td>James Anderson</td>
                <td>+9900112233</td>
                <td>Mobilizer K</td>
                <td>Field Officer J</td>
                <td>Supervisor I</td>
                <td>Manager H</td>
                <td>Director G</td>
              </tr>
            </tbody>
          </table>
          <p id="noResultsMessage2" class="text-center mt-3" style="display: none;">No results found.</p>
          <div class="d-flex justify-content-center mt-3">
            <nav>
              <ul class="pagination" id="paginationControls2"></ul>
            </nav>
          </div>
        </div>


        <!-- Add Record Modal -->
        <div class="modal fade" id="addRecordModal" tabindex="-1" aria-labelledby="addRecordModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addRecordModalLabel">Add New report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form id="addRecordForm">
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                  </div>
                  <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save Report</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>
  </section>
</div>
<?php require_once "layouts/footer.view.php" ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('addRecordForm').addEventListener('submit', async function(e) {
    e.preventDefault(); // Prevent the default form submission

    // Get form data
    const name = document.getElementById('name').value;
    const phone = document.getElementById('phone').value;

    // Retrieve the Bearer token from localStorage
    const token = localStorage.getItem('token');

    if (!token) {
      alert('No token found. Please log in first.');
      return;
    }

    // Prepare the data to send
    const formData = {
      name: name,
      phone: phone
    };

    try {
      // Send POST request to the API
      const response = await fetch('<?= $base_url ?>records/create/createRecord', {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
      });

      // Parse the response
      const result = await response.json();
      console.log('API Response:', result);

      if (response.ok) {
        alert(result.message || 'Record added successfully!');
        // Optionally, reset the form
        this.reset();

        // Close the modal
        const addRecordModal = bootstrap.Modal.getInstance(document.getElementById('addRecordModal'));
        addRecordModal.hide();

        // Optionally, refresh the table or add the new record dynamically
        const tableBody = document.getElementById('recordsTableBody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
          <td>${new Date().toISOString().split('T')[0]}</td>
          <td>${name}</td>
          <td>${phone}</td>
          <td>Mobilizer A</td>
          <td>Field Officer B</td>
          <td>Supervisor C</td>
          <td>Manager D</td>
          <td>Director E</td>
        `;
        tableBody.appendChild(newRow);
      } else {
        alert(result.message || 'Failed to add record.');
      }
    } catch (error) {
      console.error('Error during API request:', error);
      alert('An error occurred while adding the record. Please try again.');
    }
  });

  document.addEventListener('DOMContentLoaded', () => {
    const rowsPerPage = 5; // Number of rows per page

    // Function to render the table rows for the current page
    function renderTable(rows, paginationControls, currentPage) {
      const start = (currentPage - 1) * rowsPerPage;
      const end = start + rowsPerPage;

      rows.forEach((row, index) => {
        row.style.display = index >= start && index < end ? '' : 'none';
      });

      renderPagination(rows, paginationControls, currentPage);
    }

    // Function to render pagination controls
    function renderPagination(rows, paginationControls, currentPage) {
      const totalPages = Math.ceil(rows.length / rowsPerPage);
      paginationControls.innerHTML = '';

      // Add "Previous" button
      const prevLi = document.createElement('li');
      prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
      prevLi.innerHTML = `<a class="page-link" href="#">Previous</a>`;
      prevLi.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentPage > 1) {
          currentPage--;
          renderTable(rows, paginationControls, currentPage);
        }
      });
      paginationControls.appendChild(prevLi);

      // Add page number buttons
      for (let i = 1; i <= totalPages; i++) {
        const li = document.createElement('li');
        li.className = `page-item ${i === currentPage ? 'active' : ''}`;
        li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
        li.addEventListener('click', (e) => {
          e.preventDefault();
          currentPage = i;
          renderTable(rows, paginationControls, currentPage);
        });
        paginationControls.appendChild(li);
      }

      // Add "Next" button
      const nextLi = document.createElement('li');
      nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
      nextLi.innerHTML = `<a class="page-link" href="#">Next</a>`;
      nextLi.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentPage < totalPages) {
          currentPage++;
          renderTable(rows, paginationControls, currentPage);
        }
      });
      paginationControls.appendChild(nextLi);
    }

    // Function to filter rows based on search input, highlight matches, and bring results to the top
    function filterRows(rows, searchInput, noResultsMessage, paginationControls, tableBody) {
      const query = searchInput.value.toLowerCase().trim();
      const filteredRows = rows.filter((row) => {
        let rowMatches = false;

        Array.from(row.getElementsByTagName('td')).forEach((cell) => {
          const cellText = cell.textContent.toLowerCase();
          if (cellText.includes(query)) {
            rowMatches = true;

            // Highlight the matching text
            const regex = new RegExp(`(${query})`, 'gi');
            cell.innerHTML = cell.textContent.replace(regex, '<mark>$1</mark>');
          } else {
            // Remove previous highlights if the cell doesn't match
            cell.innerHTML = cell.textContent;
          }
        });

        return rowMatches;
      });

      // Show or hide "No results" message
      noResultsMessage.style.display = filteredRows.length === 0 ? 'block' : 'none';

      // Move matching rows to the top of the table
      tableBody.innerHTML = ''; // Clear the table body
      filteredRows.forEach((row) => tableBody.appendChild(row)); // Add matching rows first
      rows.forEach((row) => {
        if (!filteredRows.includes(row)) {
          tableBody.appendChild(row); // Add non-matching rows after
        }
      });

      // Render the filtered rows
      renderTable(filteredRows, paginationControls, 1);
    }

    // Initialize a table with search and pagination
    function initializeTable(tableBodyId, searchInputId, paginationControlsId, noResultsMessageId) {
      const tableBody = document.getElementById(tableBodyId);
      const rows = Array.from(tableBody.getElementsByTagName('tr'));
      const searchInput = document.getElementById(searchInputId);
      const paginationControls = document.getElementById(paginationControlsId);
      const noResultsMessage = document.getElementById(noResultsMessageId);

      // Event listener for search input
      searchInput.addEventListener('input', () => {
        filterRows(rows, searchInput, noResultsMessage, paginationControls, tableBody);
      });

      // Initial render
      renderTable(rows, paginationControls, 1);
    }

    // Initialize the first table
    initializeTable('recordsTableBody1', 'searchInput1', 'paginationControls1', 'noResultsMessage1');

    // Initialize the second table
    initializeTable('recordsTableBody2', 'searchInput2', 'paginationControls2', 'noResultsMessage2');
  });
</script>