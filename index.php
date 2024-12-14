<?php
//require __DIR__ . "/authenticate.php";
require __DIR__ . "/lib/User.php";
require __DIR__ . "/includes/header.php";
?>
<div id="container">
<header>
  <h1>Wordsmith</h1>
  <menu>
      <li><a href="" id="flyout-menu">Favorites</a></li>
      <li><a href="/logout">Logout</a></li>
  </menu>
</header>
<div id="search-container">
  <form method="post">
      <input type="text" name="search" placeholder="Search" id="search" required>
  </form>
</div>
</div>
<?php require __DIR__ . "/includes/footer.php"; ?>
