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
              <h3 class="v-title">Welcome<b class="userFullName"></b></h3>
              <span class="v-subtext">
                <b>Records<span class="v-day ms-1" data-daytime="day">View</span></b>
                <span class="d-flex align-items-center justify-content-center">
                  <img src="" data-icon="day" alt="" class="img-fluid ms-1" />
                </span>
              </span>
                <p>  <strong>Account Type:</strong> <span class="user_account_type"></span></p>
                <p><strong>Role:</strong> <span id="user_role">Loading...</span></p>
            </div>
          </header>
        </div>
        <div class="card-container d-flex justify-content-between flex-wrap gap-3 mt-4">
          <!-- Card for Total Records -->
          <div class="card text-center border-0 shadow-sm" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title">Total Records</h5>
              <p class="card-text display-4">1,234</p>
            </div>
          </div>

          <!-- Card for Total Users -->
          <div class="card text-center border-0 shadow-sm" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title">Total Users</h5>
              <p class="card-text display-4">567</p>
            </div>
          </div>

          <!-- Card for Total Commissions -->
          <div class="card text-center border-0 shadow-sm" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title">Total Commissions</h5>
              <p class="card-text display-4">$12,345</p>
            </div>
          </div>
        </div>

        <!-- Add Record Button -->
        <div class="text-center mt-4">
          <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addRecordModal">
            Add Record
          </button>
        </div>

        <div  class="d-flex justify-content-between align-items-center mt-4">
          <div class="input-group w-50">
            <span style="color: white; background-color:white;" class="input-group-text bg-primary text-white">
              <i class="fas fa-search"></i> <!-- Font Awesome search icon -->
            </span>
            <input type="text" id="searchInput" class="form-control" placeholder="Search by any field">
          </div>
        </div>

        <!-- Records Table -->
        <div class="table-responsive mt-4">
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
            <tbody id="recordsTableBody" class="bg-white">
              <tr>
                <td>2025-04-02</td>
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
                <td>Mayowa</td>
                <td>+0805475787</td>
                <td>Ayomi</td>
                <td>Johnpaul</td>
                <td>Chidinma C</td>
                <td>Johnpaul</td>
                <td>Chidinma C</td>
              </tr>
            </tbody>
          </table>
        </div>  
        <p id="noResultsMessage" class="text-center mt-3" style="display: none;">No results found.</p>
        <div class="d-flex justify-content-center mt-3">
          <nav>
            <ul class="pagination" id="paginationControls">
              <!-- Pagination buttons will be dynamically generated here -->
            </ul>
          </nav>
        </div>
        <!-- Add Record Modal -->
        <div class="modal fade" id="addRecordModal" tabindex="-1" aria-labelledby="addRecordModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addRecordModalLabel">Add New Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form id="addRecordForm">
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="fullname" name="name" placeholder="Enter name" required>
                  </div>
                  <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
                  </div>
                </div>
                <div class="modal-footer">
                   <!-- Hidden fields -->
                
                <input type="hidden" class="user_mobilizer" id="mobilizer" name="mobilizer" value="Mobilizer A">
                <input type="hidden" class="user_field_officer" id="field_officer" name="field_officer" value="Field Officer B">
                <input type="hidden" class="user_supervisor" id="supervisor" name="supervisor" value="Supervisor C">
                <input type="hidden" class="user_project_manager" id="project_manager" name="project_manager" value="Project Manager D">
                <input type="hidden" class="user_project_director" id="project_director" name="project_director" value="Project Director E">
                <input type="hidden" class ="userId" id="referral_code" name="referral_code" value="">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save Record</button>
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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>// Submit Form - Add Record using Axios
document.getElementById('addRecordForm').addEventListener('submit', async function (e) {
  e.preventDefault();

  const fullname = document.querySelector('#addRecordForm input[name="name"]').value;
  const phone = document.querySelector('#addRecordForm input[name="phone"]').value;

  const formData = {
    user_id: document.getElementById('referral_code').value,
    fullname,
    phone,
    mobilizer_id: document.getElementById('mobilizer').value,
    field_officer_id: document.getElementById('field_officer').value,
    supervisor_id: document.getElementById('supervisor').value,
    project_manager_id: document.getElementById('project_manager').value,
    project_director_id: document.getElementById('project_director').value
  };

  try {
    const response = await axios.post('<?= $base_url ?>records/create/refCreateRecord', formData);

    console.log('API Response:', response.data);

    if (response.status === 200) {
      alert(response.data.message || 'Record added successfully!');
      this.reset();

      const modal = bootstrap.Modal.getInstance(document.getElementById('addRecordModal'));
      if (modal) modal.hide();

      const tableBody = document.getElementById('recordsTableBody');
      const newRow = document.createElement('tr');
      newRow.innerHTML = `
        <td>${new Date().toISOString().split('T')[0]}</td>
        <td>${fullname}</td>
        <td>${phone}</td>
        <td>${mobilizer}</td>
        <td>${fieldOfficer}</td>
        <td>${supervisor}</td>
        <td>${projectManager}</td>
        <td>${projectDirector}</td>
      `;
      tableBody.appendChild(newRow);
    } else {
      alert(response.data.message || 'Failed to add record.');
    }
  } catch (error) {
    console.error('Axios error:', error);
    const errorMessage = error.response?.data?.message || 'An error occurred. Please try again.';
    alert(errorMessage);
  }
});
</script>
