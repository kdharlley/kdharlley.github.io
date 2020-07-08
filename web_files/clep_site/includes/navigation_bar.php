<nav id="nav_bar">

    <ul>
      <?php
      $current_file = htmlspecialchars(basename($_SERVER['PHP_SELF']));

      $page_info = array(['index.php', 'Home'], ['eboard.php', 'E-Board', 'member.php'], ['events.php', 'Events', 'eventEdit.php'], ['join.php', 'Join Us', 'appform.php', 'listervapps.php', 'ebapps.php', 'delete_position.php']);

      // page[0] is main file name, page[1] is name as appears in nav bar
      foreach($page_info as $page) {

          if(in_array($current_file,$page)) {
            $css_id = "id='active_page' "; // this CSS id indicates the current page
          } else {
            $css_id = "";
          }

          echo "<li><a " . $css_id . "href='" . $page[0] . "'>" . $page[1] . "</a></li>";
      }
      ?>

    <?php
      if ( is_user_logged_in() ) {
              $logout_url = htmlspecialchars( 'index.php?' . http_build_query( array( 'logout' => '' ) ) );
              echo '<li><a href="' . $logout_url . '">Log Out </a></li>';
      }else{
        if($current_file=="accounts.php") {
          echo "<li><a id='active_page' href='accounts.php'>Log In</a></li>";
        } else {
          echo '<li><a href="accounts.php">Log In</a></li>';
        }
      }
    ?>
  </ul>
</nav>


<!-- I referenced code from Kyle Harms at https://github.coecis.cornell.edu/info2300-sp2019/ys778-lab-08/blob/master/includes/header.php -->
