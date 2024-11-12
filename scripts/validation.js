function validate_registration() {
  // Get references to form elements
  const emailInput = document.getElementById("email");
  const loginInput = document.getElementById("login");
  const passInput = document.getElementById("pass");
  const pass2Input = document.getElementById("pass2");
  const newsletterCheckbox = document.getElementById("newsletter");
  const termsCheckbox = document.getElementById("terms");

  // Initialize error flag
  let hasErrors = false;

  // Regular expression for valid email. 
  // "/  /" is begining and end
  // "^  $" is the start and end of the string
  // []+ This quantifier mean previous character class [] should occur one or more times
  // @ and  \.(escaped with a backslash) is required part
  // {3,} is a quantifier that specifies a minimum of three characters. 
  const emailPattern = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{3,}$/;

  // Clear any previous error messages
  const errorMessages = document.getElementsByClassName("error");
  for (let i = 0; i < errorMessages.length; i++) {
    errorMessages[i].style.display = "none";
  }

  // Validate email
  // .test() is a method checks if emailPattern matches the value of the email input field
  // const.value and const.style
  if (!emailPattern.test(emailInput.value)) {
    hasErrors = true;
    // If the email is invalid, this line accesses an HTML element with 
    //  the id "emailError" and changes its CSS display property to "block".
    document.getElementById("emailError").style.display = "block";
    emailInput.style.border = "1px solid red";
  } else {
    emailInput.style.border = "1px solid #ccc";
  }

  // Validate login
  // if login input field is empty after removing leading and trailing whitespace
  // OR the length of the login input is greater than or equal to 30 characters
  if (loginInput.value.trim() === "" || loginInput.value.length >= 30) {
    hasErrors = true;
    document.getElementById("loginError").style.display = "block";
    loginInput.style.border = "1px solid red";
  } else {
    loginInput.style.border = "1px solid #ccc";
    // Convert login to lowercase
    loginInput.value = loginInput.value.toLowerCase();
  }

  // Validate password

  // (?=.*[a-z])  This is a positive lookahead assertion. It checks 
  // if the string contains at least one lowercase letter (from 'a' to 'z'). 
  // .*:          This part matches any character (represented by .) 
  // zero or more times (indicated by *)
  const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
  if (!passwordPattern.test(passInput.value)){

  // if length is less than 8 
  // if (passInput.value.length < 8){

    hasErrors = true;
    document.getElementById("passError").style.display = "block";
    passInput.style.border = "1px solid red";
  } else {
    passInput.style.border = "1px solid #ccc";
  }

  // Validate re-type password
  if (pass2Input.value !== passInput.value || pass2Input.value.trim() === "") {
    hasErrors = true;
    document.getElementById("pass2Error").style.display = "block";
    pass2Input.style.border = "1px solid red";
  } else {
    pass2Input.style.border = "1px solid #ccc";
  }

  // Validate terms checkbox
  // !termsCheckbox.checked returns true if the checkbox is unchecked
  if (!termsCheckbox.checked) {
    hasErrors = true;
    document.getElementById("termsError").style.display = "block";
  }

  // Prevent form submission if there are errors
  // If there are errors (hasErrors is true), !hasErrors will be false.
  // If there are validation errors in the form, the function will set hasErrors to true, 
  // and returning !hasErrors as false will prevent the form submission. 
  return !hasErrors;
}

function validate_login() {
  // Get references to form elements
  const emailInput = document.getElementById("email");
  const passInput = document.getElementById("pass");

  // Initialize error flag
  let hasErrors = false;

  // Clear any previous error messages
  const errorMessages = document.getElementsByClassName("error");
  for (let i = 0; i < errorMessages.length; i++) {
    errorMessages[i].style.display = "none";
  }

  // Validate email
  if (emailInput.value.length === 0) {
    hasErrors = true;
    // If the email is invalid, this line accesses an HTML element with 
    //  the id "emailError" and changes its CSS display property to "block".
    document.getElementById("emailError").style.display = "block";
    emailInput.style.border = "1px solid red";
  } else {
    emailInput.style.border = "1px solid #ccc";
  }


  // Validate password
  if (passInput.value.length === 0){
    hasErrors = true;
    document.getElementById("passError").style.display = "block";
    passInput.style.border = "1px solid red";
  } else {
    passInput.style.border = "1px solid #ccc";
  }

  // Prevent form submission if there are errors
  // If there are errors (hasErrors is true), !hasErrors will be false.
  // If there are validation errors in the form, the function will set hasErrors to true, 
  // and returning !hasErrors as false will prevent the form submission. 
  return !hasErrors;
}
