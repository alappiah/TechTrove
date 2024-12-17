document.addEventListener("DOMContentLoaded", function () {
    // Navigation functionality
    const navLinks = document.querySelectorAll(".sidebar ul li a");
    const sections = document.querySelectorAll(".section-content");

    navLinks.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();

            // Highlight active link
            navLinks.forEach(nav => nav.classList.remove("active"));
            this.classList.add("active");

            // Show corresponding section
            sections.forEach(section => {
                section.classList.remove("active");
            });
            const targetSection = document.querySelector(this.getAttribute("href"));
            targetSection.classList.add("active");
        });
    });
})

// Apply theme preference on page load
document.addEventListener('DOMContentLoaded', function () {
    // Retrieve the saved theme from localStorage
    var theme = localStorage.getItem('theme') || 'light';
    
    // Apply the saved theme
    document.body.classList.toggle('dark-mode', theme === 'dark');

    // Update the dropdown to reflect the saved theme
    var themeDropdown = document.getElementById('theme');
    if (themeDropdown) {
        themeDropdown.value = theme;
    }

    // Add event listener for theme changes
    var applyButton = document.getElementById('apply-preferences');
    if (applyButton) {
        applyButton.addEventListener('click', function () {
            var selectedTheme = themeDropdown.value;
            // Save the selected theme in localStorage
            localStorage.setItem('theme', selectedTheme);

            // Apply the selected theme
            document.body.classList.toggle('dark-mode', selectedTheme === 'dark');
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const newPasswordField = document.getElementById("new-password");
    const confirmPasswordField = document.getElementById("confirm-password");
    const newPasswordError = document.getElementById("new-password-error");
    const confirmPasswordError = document.getElementById("confirm-password-error");

    const passwordRegex = /^(?=.*[A-Z])(?=.*[0-9]{3,})(?=.*[!@#\$%\^&\*]).{8,}$/;

    // Validate password as the user types
    newPasswordField.addEventListener("input", function () {
        const password = this.value.trim();
        newPasswordError.textContent = ""; // Clear previous error message

        if (password !== "" && !passwordRegex.test(password)) {
            newPasswordError.textContent = "Password must be at least 8 characters long, contain an uppercase letter, at least 3 digits, and a special character.";
        }
    });

    // Validate confirm password
    confirmPasswordField.addEventListener("input", function () {
        const confirmPassword = this.value.trim();
        confirmPasswordError.textContent = ""; // Clear previous error message

        if (confirmPassword !== "" && confirmPassword !== newPasswordField.value.trim()) {
            confirmPasswordError.textContent = "Passwords do not match.";
        }
    });

    // Form submission validation
    document.getElementById("account-security-form").addEventListener("submit", function (e) {
        let isValid = true;

        // Validate new password
        const newPassword = newPasswordField.value.trim();
        if (newPassword === "") {
            newPasswordError.textContent = "Password is required";
            isValid = false;
        } else if (!passwordRegex.test(newPassword)) {
            newPasswordError.textContent = "Password must be at least 8 characters long, contain an uppercase letter, at least 3 digits, and a special character.";
            isValid = false;
        }

        // Validate confirm password
        const confirmPassword = confirmPasswordField.value.trim();
        if (confirmPassword !== newPassword) {
            confirmPasswordError.textContent = "Passwords do not match.";
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault(); // Prevent form submission if validation fails
        }
    });
});

function confirmDeletion(event) {
    event.preventDefault();

    const confirmation = confirm("Are you really sure you want to delete your account? This action cannot be undone.");
    if (confirmation) {
        document.getElementById('delete-account-form').submit();
    }
}