<?php
require "common.php";

require_user();
make_header('Home page');
?>

<h1>Admin page</h1>

<p>You are now authorized to access this section.

<p><a href="index.php">Back to home page</a>
<p><a href="logout.php">Logout</a>

<?php
make_footer();
?>
