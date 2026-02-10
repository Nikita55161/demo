// JavaScript placeholder
document.addEventListener("keydown", function (e) {
  // Ignore typing inside inputs and textareas
  if (["INPUT", "TEXTAREA"].includes(document.activeElement.tagName)) {
    return;
  }

  // Press K to open admin login
  if (e.key.toLowerCase() === "k") {
    window.location.href = "/admin/login.php";
  }
});
