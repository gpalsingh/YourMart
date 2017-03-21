<html><head> <title>Register</title></head>
<body>
<?php
include_once "header.php"
?>
<script type="text/javascript" src="js/register.js"></script>
<div class="content">
<h1>Registeration for YourMart</h1>
<form id="signup-form" action="registered.php" method="POST">
Name: <input type="text" name="first_name" placeholder="First Name" id="person-name-first" maxlenght="30" onChange="checkFirstName();">
<input type="text" name="last_name" placeholder="Last Name" id="person-name-last" maxlenght="30" onChange="checkLastName();">
<br>
<span id="person-name-first-errors" class="hidden"><br></span>
<span id="person-name-last-errors" class="hidden"><br></span>
Email: <input type="text" name="email" placeholder="Email" id="person-email" maxlength="30" onChange="checkEmailValid();"><br>
<span id="person-email-errors" class="hidden"><br></span>
Confirm Email: <input type="text" placeholder="Email again" id="person-email-again" onChange="checkEmailMatch();"><br>
<span id="person-email-again-errors" class="hidden"><br></span>
Username: <input type="text" name="username" placeholder="Username" id="person-username" maxlength="30" onChange="checkUsernameValid();"><br>
<span id="person-username-errors" class="hidden"><br></span>
Password: <input type="password" name="password" placeholder="Your password" id="person-password" maxlength="30" onChange="checkPasswordValid();"><br>
<span id="person-password-errors" class="hidden"><br></span>
Confirm Password: <input type="password" placeholder="Password again" id="person-password-again" onChange="checkPasswordMatch();"><br>
<span id="person-password-again-errors" class="hidden"><br></span>
<!--make birthday field-->
Gender: <select name="gender">
<option>Male</option>
<option>Female</option>
</select>
<br>
<!--Make it "I FIRST NAME agree.."-->
<input type="checkbox" id="agree-terms" onChange="checkAgreeTerms();">I agree to the terms and conditions<br>
<span id="agree-terms-errors" class="hidden"><br></span>
<button type="submit">Submit</button>
</form>
</div>
<?php
include_once "footer.php"
?>
</body></html>
