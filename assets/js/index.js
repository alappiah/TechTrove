function validateForm() {
    // Clear previous error messages
    document.getElementById('email-error').textContent = '';
    document.getElementById('password-error').textContent = '';

    

    let isValid = true;

    // Validate Email
    const email = document.getElementById('email').value.trim();
    const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (email === "") {
        document.getElementById('email-error').textContent = "Email is required";
        isValid = false;
    } else if (!emailRegex.test(email)) {
        document.getElementById('email-error').textContent = "Please enter a valid email";
        isValid = false;
    }

    // Validate Password
    const password = document.getElementById('password').value.trim();
    const passwordRegex = /^(?=.*[A-Z])(?=.*[0-9]{3,})(?=.*[!@#\$%\^&\*]).{8,}$/;

    if (password === "") {
        document.getElementById('password-error').textContent = "Password is required";
        isValid = false;
    } else if (!passwordRegex.test(password)) {
        document.getElementById('password-error').textContent = "Please enter a valid password";
        isValid = false;
    }

    return isValid; // Prevent form submission if validation fails
}

// Clear error messages when the user interacts with the email input field
document.getElementById('email').addEventListener('input', function () {
    document.getElementById('email-error').textContent = '';
});



// Validate email and show error messages while typing
document.getElementById('email').addEventListener('input', function () {
    const email = this.value.trim();
    const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    document.getElementById('email-error').textContent = ''; // Clear previous error message

    if (email !== "" && !emailRegex.test(email)) {
        document.getElementById('email-error').textContent = "Please enter a valid email";
    }
});

// Validate password and show error messages while typing
document.getElementById('password').addEventListener('input', function () {
    const password = this.value.trim();
    const passwordRegex = /^(?=.*[A-Z])(?=(?:[^0-9]*[0-9]){3})(?=.*[!@#\$%\^&\*]).{8,}$/;
    document.getElementById('password-error').textContent = ''; // Clear previous error message

    if (password !== "" && !passwordRegex.test(password)) {
        document.getElementById('password-error').textContent = "Please enter a valid password";
    }
});