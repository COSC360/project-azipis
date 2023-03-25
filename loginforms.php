<div class="form-popup" id="login-popup">

<form id="login" method="post" action="login.php">

   <h2> Login </h2>

   <label for="email"><b>Email</b></label>
   <input type="email" placeholder="Enter Email" name="email" required>

   <label for="psw"><b>Password</b></label>
   <input type="password" placeholder="Enter Password" name="psw" minlength="6" required>

   <button id="forgot-psw" class="button" onclick="openForgotPsw()">Forgot password?</button>

   <button type="submit" class="btn">Login</button>
   <button type="button" class="btn cancel" onclick="closeLogin()">Close</button>
</form>
</div>

<div class="form-popup" id="forgotpw-popup">

<form id="forgotpw" method="post" action="forgotpw.php">

   <h2> Forgot password </h2>

   <label for="email"><b>Email</b></label>
   <input type="email" id="email-input" placeholder="Enter Email" name="email" required>
   <p id="valid-email"></p>

   <button type="button" onclick="sendResetPassword()" class="btn">Reset my password</button>
   <button type="button" class="btn cancel" onclick="closeForgotPsw()">Close</button>
</form>
</div>