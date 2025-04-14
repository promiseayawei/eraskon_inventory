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
                            <h3 class="v-title">Welcome <b class="user_first_name"></b></h3>
                            <span class="v-subtext">
                                <b>Roles<span class="v-day ms-1" data-daytime="day">View</span></b>
                                <span class="d-flex align-items-center justify-content-center">
                                    <img src="" data-icon="day" alt="" class="img-fluid ms-1" />
                                </span>
                            </span>
                            <p> <strong>Account Type:</strong> <span class="user_account_type"></span></p>
                            <p><strong>Role:</strong> <span id="user_role">Loading...</span></p>
                        </div>
                    </header>
                </div>

                <!-- Unassigned Roles Section -->
                <div class="container p-4 my-4" style="background-color:rgb(9, 66, 180); border-radius: 8px;">
                    <h5 style="color:whitesmoke;" class="mb-3">Unassigned Roles</h5>
                    <!-- Search Input -->
                    <div class="mb-3">
                        <input type="text" class="form-control" id="searchUnassigned" placeholder="Search unassigned users...">
                    </div>

                    <ul class="list-group mb-4" id="unassignedList">
                        <li class="list-group-item bg-light">
                            <strong>Users and roles:</strong> These are users currently without assigned roles.
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center user-item"
                            data-bs-toggle="modal"
                            data-bs-target="#assignRoleModal"
                            data-username="John Doe">
                            John Doe
                            <span class="badge bg-primary rounded-pill">unassigned</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center user-item"
                            data-bs-toggle="modal"
                            data-bs-target="#assignRoleModal"
                            data-username="Jane Smith">
                            Jane Smith
                            <span class="badge bg-primary rounded-pill">unassigned</span>
                        </li>
                    </ul>
                    <nav>
                        <ul class="pagination pagination-sm justify-content-center" id="unassignedPagination"></ul>
                    </nav>
                </div>

                <!-- Assign to Downline Section -->
                <div class="container p-4 my-4" style="background-color:rgb(9, 66, 180); border-radius: 8px;">
                    <h5 style="color:whitesmoke;" class="mb-3">Assign to Downline</h5>
                    <!-- Search Input -->
                    <!-- Search Input -->
                    <div class="mb-3">
                        <input type="text" class="form-control" id="searchDownline" placeholder="Search downline users...">
                    </div>


                    <ul class="list-group mb-4" id="downlineList">
                        <li class="list-group-item bg-light">
                            <strong>Downline Assignment:</strong> Assign users under your supervision.
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center user-item"
                            data-bs-toggle="modal"
                            data-bs-target="#assignDownlineModal"
                            data-username="Samuel King">
                            Samuel King
                            <span class="badge bg-success rounded-pill">field officer</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center user-item"
                            data-bs-toggle="modal"
                            data-bs-target="#assignDownlineModal"
                            data-username="Linda Grace">
                            Linda Grace
                            <span class="badge bg-success rounded-pill">supervisor</span>
                        </li>
                    </ul>
                    <nav>
                        <ul class="pagination pagination-sm justify-content-center" id="downlinePagination"></ul>
                    </nav>
                </div>

                <!-- Assign Role Modal -->
                <div class="modal fade" id="assignRoleModal" tabindex="-1" aria-labelledby="assignRoleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="assignRoleModalLabel">Assign Role</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="mb-3">Assigning role to: <strong id="displayUserNameRole">[User]</strong></p>
                                <form id="assignRoleForm">
                                    <div class="mb-3">
                                        <label for="roleSelect" class="form-label">Select Role</label>
                                        <select class="form-select" id="roleSelect" required>
                                            <option value="">Choose...</option>
                                            <option value="field_officer">Field Officer</option>
                                            <option value="supervisor">Supervisor</option>
                                            <option value="mobilizer">Mobilizer</option>
                                            <option value="project_manager">Project Manager</option>
                                            <option value="project_director">Project Director</option>
                                        </select>
                                    </div>
                                    <input type="hidden" id="selectedUserNameRole" name="user">
                                    <button type="submit" class="btn btn-primary">Assign Role</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assign Downline Modal -->
                <div class="modal fade" id="assignDownlineModal" tabindex="-1" aria-labelledby="assignDownlineModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="assignDownlineModalLabel">Assign to Downline</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="mb-3">Assigning downline for: <strong id="displayUserNameDownline">[User]</strong></p>
                                <form id="assignDownlineForm">
                                    <div class="mb-3">
                                        <label for="downlineRoleSelect" class="form-label">Select Downline Role</label>
                                        <select class="form-select" id="downlineRoleSelect" required>
                                            <option value="">Choose...</option>
                                            <option value="field_officer">Field Officer</option>
                                            <option value="supervisor">Supervisor</option>
                                            <option value="mobilizer">Mobilizer</option>
                                        </select>
                                    </div>
                                    <input type="hidden" id="selectedUserNameDownline" name="user">
                                    <button type="submit" class="btn btn-success">Assign Downline</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Mobilizer Table Section -->

            </div>
        </main>
    </section>
</div>
<?php require_once "layouts/footer.view.php" ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Retrieve the user data from localStorage
        const userId = localStorage.getItem('id');
        const firstName = localStorage.getItem('first_name');
        const lastName = localStorage.getItem('last_name');
        const state = localStorage.getItem('state');
        const role = localStorage.getItem('role');
        const mobilizer = localStorage.getItem('mobilizer');
        const fieldOfficer = localStorage.getItem('field_officer');
        const supervisor = localStorage.getItem('supervisor');
        const projectManager = localStorage.getItem('project_manager');
        const projectDirector = localStorage.getItem('project_director');
        const accountType = localStorage.getItem('account_type'); // Retrieve account type

        if (userId) {
            console.log("User ID retrieved from localStorage:", userId);

            // Update the welcome message with the user's first name
            const nameElement = document.querySelector('.user_first_name');
            if (nameElement) {
                nameElement.textContent = firstName || 'User';
            }

            // Update full name
            const fullNameElement = document.getElementById('userFullName');
            if (fullNameElement) {
                fullNameElement.textContent = `${firstName || ''} ${lastName || ''}`.trim();
            }

            // Update state
            const stateElement = document.getElementById('userState');
            if (stateElement) {
                stateElement.textContent = state || 'N/A';
            }

            // Update account type
            const accountTypeElement = document.querySelector('.user_account_type');
            if (accountTypeElement) {
                accountTypeElement.textContent = accountType ? capitalize(accountType) : 'N/A';
            }

            // Update role
            const roleElement = document.getElementById('user_role'); // Corrected selector to match HTML
            if (roleElement) {
                roleElement.textContent = role ? capitalize(role) : 'N/A';
            }

            // Update mobilizer
            const mobilizerElement = document.querySelector('.user_mobilizer');
            if (mobilizerElement) {
                mobilizerElement.textContent = mobilizer ? capitalize(mobilizer) : 'N/A';
            }
        }

        // Utility: Capitalize first letter
        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

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


    });
</script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- Bootstrap Bundle (if not already loaded) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>document.addEventListener("DOMContentLoaded", function () {
    const unassignedList = document.getElementById("unassignedList");
    const downlineList = document.getElementById("downlineList");
    const token = localStorage.getItem("token");

    const unassignedUsers = [];
    const downlineUsers = [];

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function createUserItem(user, name, role, targetModal) {
        const li = document.createElement("li");
        li.className = "list-group-item d-flex justify-content-between align-items-center user-item";
        li.setAttribute("data-username", name);
        li.setAttribute("data-bs-toggle", "modal");
        li.setAttribute("data-bs-target", targetModal);
        li.innerHTML = `
            ${name}
            <span class="badge bg-primary rounded-pill">${role || "unassigned"}</span>
        `;
        return li;
    }

    axios.get("<?= $base_url;?>/users/read", {
        headers: { Authorization: `Bearer ${token}` }
    }).then(response => {
        const users = response.data.data;

        users.forEach(user => {
            const name = user.role_data[0]
                ? `${capitalize(user.role_data[0].first_name)} ${capitalize(user.role_data[0].last_name)}`
                : user.email;
            const role = user.role || 'unassigned';

            if (!user.role_data || user.role_data.length === 0) {
                unassignedUsers.push({ user, name, role });
            } else {
                downlineUsers.push({ user, name, role });
            }
        });

        renderUserList(unassignedUsers, unassignedList, "assignRoleModal", "unassignedPagination", "searchUnassigned");
        renderUserList(downlineUsers, downlineList, "assignDownlineModal", "downlinePagination", "searchDownline");
    });

    function renderUserList(userArray, containerList, modalId, paginationId, searchInputId) {
        const itemsPerPage = 5;
        let currentPage = 1;

        function filterUsers(query) {
            return userArray.filter(u => u.name.toLowerCase().includes(query.toLowerCase()));
        }

        function renderPage(users, page) {
            containerList.innerHTML = '';
            const start = (page - 1) * itemsPerPage;
            const paginatedUsers = users.slice(start, start + itemsPerPage);

            if (users.length === 0) {
                containerList.innerHTML = `<li class="list-group-item">No users found.</li>`;
            } else {
                paginatedUsers.forEach(({ user, name, role }) => {
                    const li = createUserItem(user, name, role, `#${modalId}`);
                    containerList.appendChild(li);
                });
            }

            renderPagination(users.length, paginationId, page);
        }

        function renderPagination(totalItems, paginationId, currentPage) {
            const pagination = document.getElementById(paginationId);
            pagination.innerHTML = "";

            const totalPages = Math.ceil(totalItems / itemsPerPage);
            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement("li");
                li.className = `page-item ${i === currentPage ? "active" : ""}`;
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                li.addEventListener("click", function (e) {
                    e.preventDefault();
                    currentPage = i;
                    const query = document.getElementById(searchInputId).value;
                    renderPage(filterUsers(query), currentPage);
                });
                pagination.appendChild(li);
            }
        }

        // Setup search input
        const searchInput = document.getElementById(searchInputId);
        searchInput.addEventListener("input", function () {
            const query = searchInput.value;
            currentPage = 1;
            renderPage(filterUsers(query), currentPage);
        });

        // Initial render
        renderPage(userArray, currentPage);
    }

    // Modal triggers
    document.getElementById('assignRoleModal').addEventListener('show.bs.modal', function (event) {
        const trigger = event.relatedTarget;
        const username = trigger.getAttribute('data-username');
        document.getElementById('displayUserNameRole').textContent = username;
        document.getElementById('selectedUserNameRole').value = username;
    });

    document.getElementById('assignDownlineModal').addEventListener('show.bs.modal', function (event) {
        const trigger = event.relatedTarget;
        const username = trigger.getAttribute('data-username');
        document.getElementById('displayUserNameDownline').textContent = username;
        document.getElementById('selectedUserNameDownline').value = username;
    });
});

</script>