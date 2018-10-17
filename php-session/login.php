<?php
require "common.php";

make_header('Login');
?>

<h1>Login</h1>

<?php

$login = $_POST['login'];
$password = $_POST['password'];

if ($login == 'john' && $password == 'correctpwd')
{
    echo "<p>Login successful</p>";
    $_SESSION['user'] = $login;
}
else
{
    echo "<p>Incorrect login</p>";
}

?>

<a href="admin.php">Go to admin page</a>
<br><a href="index.php">Back to home page</a>

<?php
make_footer();
?>
