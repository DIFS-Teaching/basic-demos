<?php
require "common.php";

make_header('Admin page');
require_user();
?>

<h1>Admin page</h1>

<p>You are now authorized to access this section.

<p><a href="index.php">Back to home page</a>
<p><a href="logout.php">Logout</a>

<?php
make_footer();
?>
