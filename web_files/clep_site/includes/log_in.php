<div class="log_in_page">
<p id="welcome_back"> Welcome back!</p>
<ul>
  <?php
  foreach ($session_messages as $message) {
    echo "<li class='message'><strong>" . htmlspecialchars($message) . "</strong></li>\n";
  }
  ?>
</ul>
    <form id="log_in" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <ul>
        <li>
          <input id="user_name" name="user_name" type="text" placeholder="Username">
        </li>
        <li>
          <input id="password" name="password" type="password" placeholder="Password">
        </li>
        <li>
           <button type="submit" name="login" class="account_in"> Log In</button>
        </li>
      </ul>
    </form>
</div>

<!-- I use the code from Kyle Harms. The source is https://github.coecis.cornell.edu/info2300-sp2019/ys778-lab-08/blob/master/includes/login.php -->
