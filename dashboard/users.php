<?php require_once "layouts/header.view.php";
require_once "../config.php";
?>
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
                <b>Users<span class="v-day ms-1" data-daytime="day">View</span></b>
                <span class="d-flex align-items-center justify-content-center">
                  <img src="" data-icon="day" alt="" class="img-fluid ms-1" />
                </span>
              </span>
                <p>  <strong>Account Type:</strong> <span class="user_account_type"></span></p>
                <p><strong>Role:</strong> <span id="user_role">Loading...</span></p>
            </div>
          </header>
        </div>

        <!-- Cards Section -->
        <div class="card-container bg-light p-4 rounded-3 mt-4">
          <!-- Mobilizers Card -->

          <div class="modern-card text-center">
            <div class="modern-card-body">
              <h5 class="modern-card-title">Mobilizers</h5>
              <p class="modern-card-text" id="mobilizerCount">1,234</p>
            </div>
          </div>
          <!-- Field Officers Card -->
          <div class="modern-card text-center">
            <div class="modern-card-body">
              <h5 class="modern-card-title">Field Officers</h5>
              <p class="modern-card-text" id="fieldOfficerCount">1,234</p>
            </div>
          </div>

          <!-- Supervisors Card -->
          <div class="modern-card text-center">
            <div class="modern-card-body">
              <h5 class="modern-card-title">Supervisors</h5>
              <p class="modern-card-text" id="supervisorCount">1,234</p>
            </div>
        </div>

        <!-- Project Managers Card -->
        <div class="modern-card text-center">
          <div class="modern-card-body">
            <h5 class="modern-card-title">Project Managers</h5>
            <p class="modern-card-text" id="projectManagerCount">1,234</p>
          </div>
        </div>

        <!-- Project Directors Card -->
        <div class="modern-card text-center">
          <div class="modern-card-body">
            <h5 class="modern-card-title">Project Directors</h5>
            <p class="modern-card-text" id="projectDirectorCount">1,234</p>
          </div>
        </div>
      </div>

      <!-- Mobilizer Table Section -->
      <div class="v-main-content-inner col-12 row mt-3 m-0 justify-content-between mx-auto position-relative">
        <div class="v-page-wrapper p-0">
          <div class="bg-white border rounded-3">
            <h4 class="text-primary fw-bold  mb-3" style="font-size: 1rem; padding-top:1rem; padding-bottom:-1rem; padding-left:1rem; letter-spacing: 0.05rem;">Mobilizers</h4>
            <header class="d-flex align-items-center p-3">

              <div class="v-form-input has-pad-left w-100">
                <span class="v-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21l-4.343-4.343m0 0A8 8 0 1 0 5.343 5.343a8 8 0 0 0 11.314 11.314" />
                  </svg>
                </span>
                <input type="search" id="searchInputUsers" placeholder="Enter your search" class="form-control">
              </div>

              <div id="noResultsMessageUsers" class="text-center mt-3" style="display: none;">No results found.</div>
            </header>
            <div class="border-top table-responsive">
              <table class="table table-hover align-middle shadow-sm border-0">
                <thead class="bg-primary text-white">
                  <tr>
                    <th scope="col" class="text-center">ID</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Account Type</th>
                  </tr>
                </thead>
                <tbody id="usersTableBody" class="bg-white">
                  <tr>
                    <th scope="row" class="text-center">1</th>
                    <td>2025-04-01</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td><a href="tel:+1234567890" class="text-decoration-none">+1234567890</a></td>
                    <td>Mobilizer</td>
                  </tr>
                  <tr>
                    <th scope="row" class="text-center">2</th>
                    <td>2025-04-02</td>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td><a href="tel:+9876543210" class="text-decoration-none">+9876543210</a></td>
                    <td>Field Officer</td>
                  </tr>
                  <tr>
                    <th scope="row" class="text-center">3</th>
                    <td>2025-04-03</td>
                    <td>Larry</td>
                    <td>Bird</td>
                    <td>+1122334455</td>
                    <td>Supervisor</td>
                  </tr>
                  <th scope="row" class="text-center">3</th>
                  <td>2025-04-03</td>
                  <td>Larry</td>
                  <td>Bird</td>
                  <td>+1122334455</td>
                  <td>Supervisor</td>
                  </tr>
                  <!-- New Rows -->
                  <tr>
                    <th scope="row" class="text-center">4</th>
                    <td>2025-04-04</td>
                    <td>Emily</td>
                    <td>Clark</td>
                    <td>+4455667788</td>
                    <td>Project Manager</td>
                  </tr>
                  <tr>
                    <th scope="row" class="text-center">5</th>
                    <td>2025-04-05</td>
                    <td>Sarah</td>
                    <td>Williams</td>
                    <td>+9988776655</td>
                    <td>Project Director</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
              <nav>
                <ul class="pagination" id="paginationControlsUsers">
                  <!-- Pagination buttons will be dynamically generated here -->
                </ul>
              </nav>
            </div>

          </div>
        </div>
      </div>
      <!-- Field officer Table Section -->
      <div class="v-main-content-inner col-12 row mt-3 m-0 justify-content-between mx-auto position-relative">
        <div class="v-page-wrapper p-0">
          <div class="bg-white border rounded-3">
            <h4 class="text-primary fw-bold  mb-3" style="font-size: 1rem; padding-top:1rem; padding-bottom:-1rem; padding-left:1rem; letter-spacing: 0.05rem;">Field Officers</h4>

            <div id="noResultsMessageFieldOfficer" class="text-center mt-3" style="display: none;">No results found.</div>
            <header class="d-flex align-items-center p-3">

              <div class="v-form-input has-pad-left w-100">
                <span class="v-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21l-4.343-4.343m0 0A8 8 0 1 0 5.343 5.343a8 8 0 0 0 11.314 11.314" />
                  </svg>
                </span>
                <input type="search" id="fieldOfficerSearchInput" placeholder="Enter your search" class="form-control">
              </div>
            </header>
            <div class="border-top table-responsive">
              <table class="table table-hover align-middle shadow-sm border-0">
                <thead class="bg-primary text-white">
                  <tr>
                    <th scope="col" class="text-center">ID</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Account Type</th>
                  </tr>
                </thead>
                <tbody id="fieldOfficerTableBody" class="bg-white">
                  <tr>
                    <th scope="row" class="text-center">1</th>
                    <td>2025-04-01</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>+1234567890</td>
                    <td>Mobilizer</td>
                  </tr>
                  <tr>
                    <th scope="row" class="text-center">2</th>
                    <td>2025-04-02</td>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>+9876543210</td>
                    <td>Field Officer</td>
                  </tr>
                  <tr>
                    <th scope="row" class="text-center">3</th>
                    <td>2025-04-03</td>
                    <td>Larry</td>
                    <td>Bird</td>
                    <td>+1122334455</td>
                    <td>Supervisor</td>
                  </tr>
                  <th scope="row" class="text-center">3</th>
                  <td>2025-04-03</td>
                  <td>Larry</td>
                  <td>Bird</td>
                  <td>+1122334455</td>
                  <td>Supervisor</td>
                  </tr>
                  <!-- New Rows -->
                  <tr>
                    <th scope="row" class="text-center">4</th>
                    <td>2025-04-04</td>
                    <td>Emily</td>
                    <td>Clark</td>
                    <td>+4455667788</td>
                    <td>Project Manager</td>
                  </tr>
                  <tr>
                    <th scope="row" class="text-center">5</th>
                    <td>2025-04-05</td>
                    <td>Sarah</td>
                    <td>Williams</td>
                    <td>+9988776655</td>
                    <td>Project Director</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
              <nav>
                <ul class="pagination" id="fieldOfficerPaginationControls">
                  <!-- Pagination buttons will be dynamically generated here -->
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
      <!-- Supervisor Table Section -->
      <div class="v-main-content-inner col-12 row mt-3 m-0 justify-content-between mx-auto position-relative">
        <div class="v-page-wrapper p-0">
          <div class="bg-white border rounded-3">
            <h4 class="text-primary fw-bold mb-3" style="font-size: 1rem; padding-top:1rem; padding-bottom:-1rem; padding-left:1rem; letter-spacing: 0.05rem;">Supervisors</h4>
            <div id="noResultsMessageSupervisor" class="text-center mt-3" style="display: none;">No results found.</div>
            <header class="d-flex align-items-center p-3">
              <div class="v-form-input has-pad-left w-100">
                <span class="v-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21l-4.343-4.343m0 0A8 8 0 1 0 5.343 5.343a8 8 0 0 0 11.314 11.314" />
                  </svg>
                </span>
                <input type="search" id="supervisorSearchInput" placeholder="Enter your search" class="form-control">
              </div>
            </header>
            <div class="border-top table-responsive">
              <table class="table table-hover align-middle shadow-sm border-0">
                <thead class="bg-primary text-white">
                  <tr>
                    <th scope="col" class="text-center">ID</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Account Type</th>
                  </tr>
                </thead>
                <tbody id="supervisorTableBody" class="bg-white">
                  <tr>
                    <th scope="row" class="text-center">1</th>
                    <td>2025-04-01</td>
                    <td>John</td>
                    <td>Doe</td>
                    <td>+1234567890</td>
                    <td>Supervisor</td>
                  </tr>
                  <tr>
                    <th scope="row" class="text-center">2</th>
                    <td>2025-04-02</td>
                    <td>Jane</td>
                    <td>Smith</td>
                    <td>+9876543210</td>
                    <td>Supervisor</td>
                  </tr>
                  <tr>
                    <th scope="row" class="text-center">3</th>
                    <td>2025-04-03</td>
                    <td>Emily</td>
                    <td>Clark</td>
                    <td>+1122334455</td>
                    <td>Supervisor</td>
                  </tr>
                  <!-- Add more rows as needed -->
                </tbody>
              </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
              <nav>
                <ul class="pagination" id="supervisorPaginationControls">
                  <!-- Pagination buttons will be dynamically generated here -->
                </ul>
              </nav>
            </div>

          </div>
        </div>
      </div>
      <!-- Project Managers Table Section -->
      <div class="v-main-content-inner col-12 row mt-3 m-0 justify-content-between mx-auto position-relative">
        <div class="v-page-wrapper p-0">
          <div class="bg-white border rounded-3">
            <h4 class="text-primary fw-bold mb-3" style="font-size: 1rem; padding-top:1rem; padding-bottom:-1rem; padding-left:1rem; letter-spacing: 0.05rem;">Project Managers</h4>
            <div id="noResultsMessageProjectManager" class="text-center mt-3" style="display: none;">No results found.</div>
            <header class="d-flex align-items-center p-3">
              <div class="v-form-input has-pad-left w-100">
                <span class="v-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21l-4.343-4.343m0 0A8 8 0 1 0 5.343 5.343a8 8 0 0 0 11.314 11.314" />
                  </svg>
                </span>
                <input type="search" id="projectManagerSearchInput" placeholder="Enter your search" class="form-control">
              </div>
            </header>
            <div class="border-top table-responsive">
              <table class="table table-hover align-middle shadow-sm border-0">
                <thead class="bg-primary text-white">
                  <tr>
                    <th scope="col" class="text-center">ID</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Account Type</th>
                  </tr>
                </thead>
                <tbody id="projectManagerTableBody" class="bg-white">
                  <tr>
                    <th scope="row" class="text-center">1</th>
                    <td>2025-04-01</td>
                    <td>Michael</td>
                    <td>Brown</td>
                    <td>+1234567890</td>
                    <td>Project Manager</td>
                  </tr>
                  <tr>
                    <th scope="row" class="text-center">2</th>
                    <td>2025-04-02</td>
                    <td>Sarah</td>
                    <td>Johnson</td>
                    <td>+9876543210</td>
                    <td>Project Manager</td>
                  </tr>
                  <!-- Add more rows as needed -->
                </tbody>
              </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
              <nav>
                <ul class="pagination" id="projectManagerPaginationControls">
                  <!-- Pagination buttons will be dynamically generated here -->
                </ul>
              </nav>
            </div>

          </div>
        </div>
      </div>

      <!-- Project Directors Table Section -->
      <div class="v-main-content-inner col-12 row mt-3 m-0 justify-content-between mx-auto position-relative">
        <div class="v-page-wrapper p-0">
          <div class="bg-white border rounded-3">
            <h4 class="text-primary fw-bold mb-3" style="font-size: 1rem; padding-top:1rem; padding-bottom:-1rem; padding-left:1rem; letter-spacing: 0.05rem;">Project Directors</h4>
            <header class="d-flex align-items-center p-3">
              <div class="v-form-input has-pad-left w-100">
                <span class="v-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21l-4.343-4.343m0 0A8 8 0 1 0 5.343 5.343a8 8 0 0 0 11.314 11.314" />
                  </svg>
                </span>
                <input type="search" id="projectDirectorSearchInput" placeholder="Enter your search" class="form-control">
              </div>
              <div id="noResultsMessageProjectDirector" class="text-center mt-3" style="display: none;">No results found.</div>
            </header>
            <div class="border-top table-responsive">
              <table class="table table-hover align-middle shadow-sm border-0">
                <thead class="bg-primary text-white">
                  <tr>
                    <th scope="col" class="text-center">ID</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Account Type</th>
                  </tr>
                </thead>
                <tbody id="projectDirectorTableBody" class="bg-white">
                  <tr>
                    <th scope="row" class="text-center">1</th>
                    <td>2025-04-01</td>
                    <td>David</td>
                    <td>Wilson</td>
                    <td>+1234567890</td>
                    <td>Project Director</td>
                  </tr>
                  <tr>
                    <th scope="row" class="text-center">2</th>
                    <td>2025-04-02</td>
                    <td>Laura</td>
                    <td>Martinez</td>
                    <td>+9876543210</td>
                    <td>Project Director</td>
                  </tr>
                  <!-- Add more rows as needed -->
                </tbody>
              </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
              <nav>
                <ul class="pagination" id="projectDirectorPaginationControls">
                  <!-- Pagination buttons will be dynamically generated here -->
                </ul>
              </nav>
            </div>

          </div>
        </div>
      </div>
</div>
</main>
</section>
</div>
<?php require_once "layouts/footer.view.php" ?>


<script>
  
  document.addEventListener('DOMContentLoaded', () => {
   populateUserData();
    // Example counts for the cards
    const mobilizerCount = 10;
    const fieldOfficerCount = 8;
    const supervisorCount = 5;
    const projectManagerCount = 3;
    const projectDirectorCount = 2;

    // Update card counts
    document.getElementById('mobilizerCount').textContent = mobilizerCount;
    document.getElementById('fieldOfficerCount').textContent = fieldOfficerCount;
    document.getElementById('supervisorCount').textContent = supervisorCount;
    document.getElementById('projectManagerCount').textContent = projectManagerCount;
    document.getElementById('projectDirectorCount').textContent = projectDirectorCount;

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

      if (query === '') {
        // If the search input is empty, reset all rows and remove highlights
        rows.forEach((row) => {
          Array.from(row.getElementsByTagName('td')).forEach((cell) => {
            cell.innerHTML = cell.textContent; // Reset cell content to original text
          });
        });

        // Show all rows and reset pagination
        noResultsMessage.style.display = 'none';
        renderTable(rows, paginationControls, 1);
        return;
      }

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

    // Initialize the Users Table
    initializeTable('usersTableBody', 'searchInputUsers', 'paginationControlsUsers', 'noResultsMessageUsers');

    // Initialize the Field Officer Table
    initializeTable('fieldOfficerTableBody', 'fieldOfficerSearchInput', 'fieldOfficerPaginationControls', 'noResultsMessageFieldOfficer');

    // Initialize the Supervisor Table
    initializeTable('supervisorTableBody', 'supervisorSearchInput', 'supervisorPaginationControls', 'noResultsMessageSupervisor');

    // Initialize the Project Managers Table
    initializeTable('projectManagerTableBody', 'projectManagerSearchInput', 'projectManagerPaginationControls', 'noResultsMessageProjectManager');

    // Initialize the Project Directors Table
    initializeTable('projectDirectorTableBody', 'projectDirectorSearchInput', 'projectDirectorPaginationControls', 'noResultsMessageProjectDirector');
  });

  
</script>