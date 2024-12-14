<div id="container">
  <form method="post" action="/signup/">
      <h1>Sign up</h1>
      <?php
      session_start();

      if ($_SESSION["message"]) {
          echo "<p>{$_SESSION["message"]}</p>";
      }
      ?>
      <input type="text" name="fullname" maxlength="32" placeholder="Full name" pattern="[A-Za-z ]{1,32}" required><br>
      <input type="text" name="username" placeholder="Username" maxlength="12" required><br>
      <input type="email" name="email" placeholder="E-mail" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
      <input type="submit" value="Sign up" name="submit"><br>
  </form>
</div>
