function validateForm() {
    // Clear previous error messages
    document.getElementById('email-error').textContent = '';
       document.getElementById('password-error').textContent = '';
       document.getElementById('confirm-password-error').textContent = '';

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
       const passwordRegex = /^(?=.*[A-Z])(?=(?:[^0-9]*[0-9]){3})(?=.*[!@#\$%\^&\*]).{8,}$/;

       if (password === "") {
           document.getElementById('password-error').textContent = "Password is required";
           isValid = false;
       } else if (!passwordRegex.test(password)) {
           document.getElementById('password-error').textContent = "Please enter a valid password";
           isValid = false;
       }

       const confirmPassword = document.getElementById('confirm-password').value.trim();

       if (confirmPassword === "") {
           document.getElementById('confirm-password-error').textContent = "Password is required";
           isValid = false;
       } else if (password !== confirmPassword ) {
           document.getElementById('confirm-password-error').textContent = "Passwords do not match";
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
       const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
       const email = this.value.trim();
       document.getElementById('email-error').textContent = ''; // Clear previous error message

       if (email !== "" && !emailRegex.test(email)) {
           document.getElementById('email-error').textContent = "Please enter a valid email";
       }
   });

   // Validate password and show error messages while typing
   document.getElementById('password').addEventListener('input', function () {
       const passwordRegex = /^(?=.*[A-Z])(?=(?:[^0-9]*[0-9]){3})(?=.*[!@#\$%\^&\*]).{8,}$/;
       const password = this.value.trim();
       document.getElementById('password-error').textContent = ''; // Clear previous error message

       if (password !== "" && !passwordRegex.test(password)) {
           document.getElementById('password-error').textContent = "Please enter a valid password";
       }
   });

   // Validate password and show error messages while typing
   document.getElementById('confirm-password').addEventListener('input', function () {
       const passwordRegex = /^(?=.*[A-Z])(?=(?:[^0-9]*[0-9]){3})(?=.*[!@#\$%\^&\*]).{8,}$/;
       const password = document.getElementById('password').value.trim();
       const confirmPassword = this.value.trim();
       document.getElementById('confirm-password-error').textContent = ''; // Clear previous error message

       if (confirmPassword !== "" && password !== confirmPassword) {
           document.getElementById('confirm-password-error').textContent = "Passwords do not match";
       }
   });