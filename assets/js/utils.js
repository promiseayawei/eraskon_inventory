window.showSpinner = function() {
  const el = document.getElementById('loadingSpinner');
  if (el) el.style.display = 'flex';
};
window.hideSpinner = function() {
  const el = document.getElementById('loadingSpinner');
  if (el) el.style.display = 'none';
};

/*
Example usage in any async operation:

showSpinner();
axios.post(window.BASE_URL + '/auth/login', data)
  .then(res => { // handle response })
  .catch(err => { // handle error })
  .finally(() => hideSpinner());
*/
