<?php
require "common.php";

unset($_SESSION['user']);
redirect('index.php');

make_header('Logout');
?>

<h1>Logout</h1>

<?php
?>

<a href="index.php">Back</a>

<?php
make_footer();
?>
