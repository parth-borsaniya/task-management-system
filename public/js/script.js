document.addEventListener("DOMContentLoaded", function () {
    const darkModeToggle = document.getElementById("darkModeToggle"); // Corrected ID
    const body = document.body;

    // Function to enable dark mode
    function enableDarkMode() {
        body.classList.add("dark-mode");
        localStorage.setItem("darkMode", "enabled");
        darkModeToggle.textContent = "Light Mode"; // Change button text
    }

    // Function to disable dark mode
    function disableDarkMode() {
        body.classList.remove("dark-mode");
        localStorage.setItem("darkMode", "disabled");
        darkModeToggle.textContent = "Dark Mode"; // Change button text
    }

    // Check localStorage and apply dark mode if enabled
    if (localStorage.getItem("darkMode") === "enabled") {
        enableDarkMode();
    }

    // Add event listener for button click
    darkModeToggle.addEventListener("click", function () {
        if (body.classList.contains("dark-mode")) {
            disableDarkMode();
        } else {
            enableDarkMode();
        }
    });
});
