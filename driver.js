// ===== LOCAL STORAGE =====
const driversKey = "drivers";
let drivers = JSON.parse(localStorage.getItem(driversKey)) || [];

// ===== ELEMENTS =====
const driverModal = document.getElementById("driverModal");
const openDriverModalBtn = document.getElementById("openDriverModal");
const closeDriverModalBtn = document.getElementById("closeDriverModal");
const driverForm = document.getElementById("driverForm");

const driverName = document.getElementById("driverName");
const driverPhone = document.getElementById("driverPhone");
const driverVehicleType = document.getElementById("driverVehicleType");
const driverVehicleNo = document.getElementById("driverVehicleNo");
const driverVehicleCategory = document.getElementById("driverVehicleCategory");
const driverStatus = document.getElementById("driverStatus");
const driverIdInput = document.getElementById("driverId");

const driversListBody = document.getElementById("driversListBody");
const driverCardsContainer = document.getElementById("driverCardsContainer");
const driverSearchInput = document.getElementById("driverSearch");

// ===== MODAL OPEN/CLOSE =====
openDriverModalBtn.addEventListener("click", () => {
  resetDriverForm();
  driverModal.style.display = "flex";
});

closeDriverModalBtn.addEventListener("click", () => {
  driverModal.style.display = "none";
});

window.addEventListener("click", (e) => {
  if (e.target === driverModal) driverModal.style.display = "none";
});

function resetDriverForm() {
  driverForm.reset();
  driverIdInput.value = "";
}

// ===== ADD / EDIT DRIVER =====
driverForm.addEventListener("submit", (e) => {
  e.preventDefault();

  const id = driverIdInput.value;
  const driverData = {
    id: id || Date.now().toString(),
    name: driverName.value.trim(),
    phone: driverPhone.value.trim(),
    vehicleType: driverVehicleType.value.trim(),
    vehicleNo: driverVehicleNo.value.trim(),
    vehicleCategory: driverVehicleCategory.value.trim(),
    status: driverStatus.value,
    logisticsId: "main", // default logistics ID
  };

  if (id) {
    // Edit existing driver
    const index = drivers.findIndex(d => d.id === id);
    if (index !== -1) drivers[index] = { ...drivers[index], ...driverData };
  } else {
    // Add new driver
    drivers.push(driverData);
  }

  saveDrivers();
  driverModal.style.display = "none";
  renderDrivers(driverData.logisticsId);
});

function saveDrivers() {
  localStorage.setItem(driversKey, JSON.stringify(drivers));
}

// ===== RENDER DRIVERS =====
function renderDrivers(logisticsId, search = "") {
  const filtered = drivers.filter(d =>
    d.logisticsId === logisticsId &&
    (d.name.toLowerCase().includes(search.toLowerCase()) ||
      d.phone.toLowerCase().includes(search.toLowerCase()))
  );

  // Table View
  driversListBody.innerHTML = filtered.length === 0
    ? `<tr><td colspan="6" style="text-align:center;">No drivers found.</td></tr>`
    : filtered.map(d => `
      <tr>
        <td>${d.name}</td>
        <td>${d.vehicleType}</td>
        <td>${d.phone}</td>
        <td>
          <select onchange="updateDriverStatus('${d.id}', this.value)" class="status-dropdown ${d.status.toLowerCase().replace(' ','-')}">
            <option value="Available" ${d.status === "Available" ? "selected" : ""}>Available</option>
            <option value="On Trip" ${d.status === "On Trip" ? "selected" : ""}>On Trip</option>
            <option value="Unavailable" ${d.status === "Unavailable" ? "selected" : ""}>Unavailable</option>
          </select>
        </td>
        <td>
          <button onclick="editDriver('${d.id}')">Edit</button>
          <button onclick="deleteDriver('${d.id}')">Delete</button>
        </td>
      </tr>`).join("");

  // Card View
  driverCardsContainer.innerHTML = filtered.map(d => `
    <div class="driver-card ${d.status.toLowerCase().replace(' ','-')}">
      <p><strong>${d.name}</strong></p>
      <p>Vehicle: ${d.vehicleType} (${d.vehicleCategory})</p>
      <p>Number: ${d.vehicleNo}</p>
      <p>Phone: ${d.phone}</p>
      <p>Status:
        <select onchange="updateDriverStatus('${d.id}', this.value)" class="status-dropdown ${d.status.toLowerCase().replace(' ','-')}">
          <option value="Available" ${d.status === "Available" ? "selected" : ""}>Available</option>
          <option value="On Trip" ${d.status === "On Trip" ? "selected" : ""}>On Trip</option>
          <option value="Unavailable" ${d.status === "Unavailable" ? "selected" : ""}>Unavailable</option>
        </select>
      </p>
      <button onclick="editDriver('${d.id}')">Edit</button>
      <button onclick="deleteDriver('${d.id}')">Delete</button>
    </div>
  `).join("");

  updateAnalytics(logisticsId);
}

// ===== UPDATE STATUS =====
window.updateDriverStatus = (id, status) => {
  const driver = drivers.find(d => d.id === id);
  if (!driver) return;
  driver.status = status;
  saveDrivers();
  renderDrivers(driver.logisticsId);
};

// ===== DELETE DRIVER =====
function deleteDriver(id) {
  const driver = drivers.find(d => d.id === id);
  if (!driver) return;
  drivers = drivers.filter(d => d.id !== id);
  saveDrivers();
  renderDrivers(driver.logisticsId);
}

// ===== EDIT DRIVER =====
function editDriver(id) {
  const driver = drivers.find(d => d.id === id);
  if (!driver) return;

  driverIdInput.value = driver.id;
  driverName.value = driver.name;
  driverPhone.value = driver.phone;
  driverVehicleType.value = driver.vehicleType;
  driverVehicleNo.value = driver.vehicleNo;
  driverVehicleCategory.value = driver.vehicleCategory;
  driverStatus.value = driver.status;

  driverModal.style.display = "flex";
}

// ===== ANALYTICS =====
function updateAnalytics(logisticsId) {
  const driversOfLogistics = drivers.filter(d => d.logisticsId === logisticsId);
  document.getElementById("available-count").innerText =
    driversOfLogistics.filter(d => d.status === "Available").length;
  document.getElementById("ontrip-count").innerText =
    driversOfLogistics.filter(d => d.status === "On Trip").length;
  document.getElementById("unavailable-count").innerText =
    driversOfLogistics.filter(d => d.status === "Unavailable").length;
}

// ===== SEARCH DRIVERS =====
driverSearchInput.addEventListener("input", () => {
  renderDrivers("main", driverSearchInput.value);
});

// ===== INITIAL RENDER =====
renderDrivers("main");
