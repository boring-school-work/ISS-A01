<?php

require "../../settings/core.php";

if (!is_logged_in()) {
  header("Location: ../../");
}

echo "Welcome, " . $_SESSION['username'];
?>

<br />
<a href="../../actions/logout_user.php">logout</a>
