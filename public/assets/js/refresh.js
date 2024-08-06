document.addEventListener("DOMContentLoaded", function () {
  // Check if the page has been refreshed already
  if (!localStorage.getItem("refreshed")) {
    // Set the item in local storage to indicate the page has been refreshed
    localStorage.setItem("refreshed", "true");
    // Refresh the page
    location.reload();
  } else {
    // Remove the item from local storage for future visits
    localStorage.removeItem("refreshed");
  }
});
