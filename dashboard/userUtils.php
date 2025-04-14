<!-- users.php -->
<script>
  function populateUserData() {
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
    const accountType = localStorage.getItem('account_type');

    if (userId) {
      console.log("User ID retrieved from localStorage:", userId);

      // Update elements with data
      updateTextContent('.user_first_name', firstName || 'User');
      updateTextContent('#userFullName', `${firstName || ''} ${lastName || ''}`.trim());
      updateTextContent('#userState', state || 'N/A');
      updateTextContent('.user_account_type', accountType ? capitalize(accountType) : 'N/A');
      updateTextContent('#user_role', role ? capitalize(role) : 'N/A');
      updateTextContent('.user_mobilizer', mobilizer ? capitalize(mobilizer) : 'N/A');
    }
  }

  function updateTextContent(selector, text) {
    const element = document.querySelector(selector);
    if (element) {
      element.textContent = text;
    }
  }

  function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
  }

  // Call the function when the DOM is ready
  document.addEventListener('DOMContentLoaded', populateUserData);
</script>
